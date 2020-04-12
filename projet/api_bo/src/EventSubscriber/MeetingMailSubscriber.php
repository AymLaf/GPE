<?php


namespace App\EventSubscriber;


use ApiPlatform\Core\EventListener\EventPriorities;
use App\Entity\Meeting;
use App\service\OwnerService;
use App\service\ResolutionService;
use Doctrine\ORM\EntityNotFoundException;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\KernelEvent;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class MeetingMailSubscriber implements EventSubscriberInterface
{
    private $mailer;
    private $resolutionService;
    private $ownerService;
    private $logger;


    public function __construct(\Swift_Mailer $mailer, OwnerService $ownerService, ResolutionService $resolutionService, LoggerInterface $logger)
    {
        $this->mailer = $mailer;
        $this->ownerService = $ownerService;
        $this->resolutionService = $resolutionService;
        $this->logger = $logger;
    }

    /**
     * Returns an array of event names this subscriber wants to listen to.
     *
     * The array keys are event names and the value can be:
     *
     *  * The method name to call (priority defaults to 0)
     *  * An array composed of the method name to call and the priority
     *  * An array of arrays composed of the method names to call and respective
     *    priorities, or 0 if unset
     *
     * For instance:
     *
     *  * ['eventName' => 'methodName']
     *  * ['eventName' => ['methodName', $priority]]
     *  * ['eventName' => [['methodName1', $priority], ['methodName2']]]
     *
     * @return array The event names to listen to
     */
    public static function getSubscribedEvents()
    {
        return [KernelEvents::VIEW => ['sendMail', EventPriorities::POST_WRITE]];

    }

    public function sendMail(ViewEvent $event): void
    {
        $this->logger->info("Entré methode sendmail");
        $meeting = $event->getControllerResult();
        $method = $event->getRequest()->getMethod();
        if (!$meeting instanceof Meeting || Request::METHOD_POST !== $method) {
            $this->logger->critical("Pas une instance meeting ou method post");
            return;
        }
        $id = $meeting->getId();

        $emails = [];

        $this->logger->info("recup des infos emails, resolution");
        try {
            $emails = $this->ownerService->getEmailOwnerForMeeting($id);
        } catch (EntityNotFoundException $e) {
            $this->logger->critical("$e");

        }
        $resolutions = $this->resolutionService->getResolutionsInfo($id);
        $resolutionsTitle = [];
        foreach ($resolutions as $resolution) {
            array_push($resolutionsTitle, $resolution["title"]);
        }
        $date = ($meeting->getDate())->format('Y-m-d');

        // Construction de l'email
        $title = "";
        $i = 1;
        foreach ($resolutionsTitle as $t) {
            $title .= "<p>Resolution : " . $i . "<br>" . $t . "</p>";
            $i++;
        }
        $this->logger->info("creation du  message");

        $message = (new \Swift_Message('convocation de l\'AG de copropriété '))
            ->setFrom('reucopro.mailer@gmail.com')
            ->setTo($emails)
            ->setBody('<strong>Bonjour Madame, Monsieur</strong>, <br> 
                               <p>En qualité de syndic de copropriété de l’immeuble, je vous invite en tant que copropriétaire à participer à l’assemblée générale exceptionnelle qui se tiendra le ' . $date . '</p>' .
                ' <p>L’ordre du jour de cette assemblée générale exceptionnelle portera sur les points suivants :' . $title . '</p><p>Si vous étiez dans l’impossibilité de vous rendre à cette assemblée générale exceptionnelle, 
                               je tiens à vous rappeler que vous avez la possibilité de vous connecter à la plateforme http://www.reucopro.com et ainsi particier mais aussi voter à distance à la reunion.</p>
                               <p> En espérant que vous pourrez vous-même assister à cette assemblée générale exceptionnelle, je me tiens à votre disposition si vous avez la moindre question et vous prie d’agréer, Madame/Monsieur, l\'expression de mes sentiments distingués,</p>
                                <br>Bien à vous <br>
                                Votre syndic.', 'text/html');


        $this->mailer->send($message);
        $this->logger->info("Email envoyé");
    }
}