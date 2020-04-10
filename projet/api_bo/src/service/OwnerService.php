<?php


namespace App\service;


use App\Entity\Meeting;
use App\Entity\Owner;
use App\Repository\OwnerRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityNotFoundException;
use Psr\Log\LoggerInterface;

class OwnerService
{
    private $ownerRepository;
    private $em;
    private  $logger;

    /**
     * OwnerService constructor.
     * @param OwnerRepository $ownerRepository
     * @param EntityManagerInterface $em
     * @param LoggerInterface $logger
     */
    public function __construct(OwnerRepository $ownerRepository, EntityManagerInterface $em, LoggerInterface $logger)
    {
        $this->em = $em;
        $this->ownerRepository = $ownerRepository;
        $this->logger = $logger;
    }

    /**
     * @param int $id_meeting
     * @return mixed
     * @throws EntityNotFoundException
     */
    public function getEmailOwnerForMeeting(int $id_meeting)
    {
        $this->logger->info("Entré methode getEmailOwnerForMeeting dans ownerService");

        $meeting = $this->em->find(Meeting::class, $id_meeting);
        $emails = $meeting->getOwners()->map(

            function (Owner $owner) {
                return $owner->getUser()->getEmail();
            }
        )->toArray();
        if (!$emails) {
            throw new EntityNotFoundException('Emails not founds..');
        }
        return $emails;
    }


}