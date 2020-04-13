<?php


namespace App\Core\EventListener;

use App\Entity\User;
use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationSuccessEvent;
use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTCreatedEvent;
use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTDecodedEvent;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\RequestStack;

class JWTListener
{
    private $requestStack;
    private $tokenTtl;

    public function __construct(
        $tokenTtl,
        RequestStack $requestStack
    ) {
        $this->requestStack = $requestStack;
        $this->tokenTtl = $tokenTtl;
    }

    /**
     * https://github.com/lexik/LexikJWTAuthenticationBundle/blob/master/Resources/doc/2-data-customization.md
     *
     * @param JWTCreatedEvent $event
     */
    public function onJWTCreated(JWTCreatedEvent $event): void
    {
        $request = $this->requestStack->getCurrentRequest();

        $payload       = $event->getData();
        $payload['ip'] = $request->getClientIp();

        $event->setData($payload);
    }

    public function onJWTDecoded(JWTDecodedEvent $event): void
    {
        $request = $this->requestStack->getCurrentRequest();

        $payload = $event->getPayload();

        if (!isset($payload['ip']) || $payload['ip'] !== $request->getClientIp()) {
            $event->markAsInvalid();
        }
    }

    public function onAuthenticationSuccessResponse(AuthenticationSuccessEvent $event): void
    {
        $response = $event->getResponse();
        $data = $event->getData();
        $user = $event->getUser();

        $token = $data['token'];
        unset($data);

        if ($user instanceof User) {
            $data['user'] = array(
                'uuid' => $user->getUuid(),
                'roles' => $user->getRoles()
            );

            $event->setData($data);
        }

        $response->headers->setCookie(
            new Cookie(
                'BEARER',
                $token,
                (new \DateTime())->add(new \DateInterval('PT' . $this->tokenTtl . 'S')),
                '/',
                null,
                getenv('APP_ENV') === 'prod'
            )
        );
    }
}
