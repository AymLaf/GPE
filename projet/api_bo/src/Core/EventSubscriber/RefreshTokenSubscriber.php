<?php

namespace App\Core\EventSubscriber;

use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationSuccessEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Cookie;

class RefreshTokenSubscriber implements EventSubscriberInterface
{
    private $ttl;

    public function __construct($ttl)
    {
        $this->ttl = $ttl;
    }

    public function setRefreshToken(AuthenticationSuccessEvent $event): void
    {
        $data = $event->getData();
        $refreshToken = $data['refresh_token'];

        if ($refreshToken) {
            $response = $event->getResponse();
            $response->headers->setCookie(
                new Cookie(
                    'REFRESH_TOKEN',
                    $refreshToken,
                    (new \DateTime())->add(new \DateInterval('PT' . $this->ttl . 'S')),
                    '/',
                    null,
                    getenv('APP_ENV') === 'prod'
                )
            );
        }
    }

    public static function getSubscribedEvents(): array
    {
        return [
            'lexik_jwt_authentication.on_authentication_success' => 'setRefreshToken'
        ];
    }
}
