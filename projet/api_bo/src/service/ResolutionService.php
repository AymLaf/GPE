<?php


namespace App\service;


use App\Repository\ResolutionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;

class ResolutionService
{
    public $em;
    public $resolutionRepository;
    public $logger;

    public function __construct(ResolutionRepository $resolutionRepository, EntityManagerInterface $em, LoggerInterface $logger)
    {
        $this->em = $em;
        $this->resolutionRepository = $resolutionRepository;
        $this->logger = $logger;
    }

    public function getResolutionsInfo($id)
    {
        $this->logger->info("Entré methode getResolutionsInfo dans ResolutionService");
        $topics = $this->resolutionRepository->findBy(
        ['meeting' => $id]
        );

        if(count($topics) == 0) {
            return null;
        }
        else
            {
                //Build title topic array
                $topicArray = [];
                foreach($topics as $topic)
                {
                    $obj_topic = [];
                    $obj_topic["id"] = $topic->getId();
                    $obj_topic["meeting_id"] = $topic->getMeeting();
                    $obj_topic["title"] = $topic->getTitle();
                    array_push($topicArray, $obj_topic);
                }
                return $topicArray;
        }
    }

}