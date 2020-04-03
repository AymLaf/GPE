<?php

namespace App\DataFixtures;

use App\Entity\Building;
use App\Entity\Delegation;
use App\Entity\Meeting;
use App\Entity\Resolution;
use App\Entity\User;
use App\Entity\Vote;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class MeetingFixtures extends BaseFixture implements DependentFixtureInterface
{
    public function loadData(ObjectManager $manager)
    {

        $this->createMany(
            Meeting::class,
            500,
            function (Meeting $meeting, $count) use ($manager) {
                /** @var Building $building */
                $building = $this->getReference('building_'.$this->faker->numberBetween(0,39));
                $meeting->setBuilding($building);
                $meeting->setDate($this->faker->dateTimeBetween('-100 days', '+100 days'));
                $meeting->setFileName('');
                $meeting->setGuestLink('');
                $meeting->setLive(999);

                /** Delegations **/
                foreach ($meeting->getBuilding()->getOwners() as $owner) {
                    if ($this->faker->boolean(5) && $meeting->getBuilding()->getOwners()->count()>=2) {
                        $delegation = new Delegation();
                        $delegation->setMeeting($meeting);
                        $delegation->setDonorOwner($owner);
                        $receiverArray = $meeting->getBuilding()->getOwners();
                        foreach ($receiverArray as $key => $value) {
                            if ($value->getId() == $owner->getId()) unset($receiverArray[$key]);
                        }
                        $delegation->setReceiverOwner($this->faker->randomElement($receiverArray));

                        $manager->persist($delegation);
                    } else {
                        $meeting->addOwner($owner);
                    }
                }

                /** Resolution **/
                for ($i=0 ; $i<$this->faker->numberBetween(5,15) ; $i++) {
                    $resolution = new Resolution();
                    $resolution->setTitle($this->faker->sentence);
                    $resolution->setTypeVote($this->faker->randomElement(['Simple', 'Absolue', 'Double', 'Unanimité']));
                    $resolution->setMeeting($meeting);

                    $manager->persist($resolution);

                    if ($meeting->getDate() < date_create('now')) {
                        foreach ($meeting->getOwners() as $owner) {
                            $vote = new Vote();
                            $vote->setOwner($owner);
                            $vote->setResolution($resolution);
                            $vote->setResult($this->faker->randomElement(['Pour', 'Contre', 'Neutre']));
                            $vote->setResolution($resolution);

                            $manager->persist($vote);
                        }
                    }
                }

                $manager->persist($meeting);
                $this->addReference('meeting_'.$count, $meeting);
            }
        );

        $manager->flush();
    }

    public function getDependencies()
    {
        return array(
            BuildingFixtures::class,
            OwnerFixtures::class
        );
    }
}
