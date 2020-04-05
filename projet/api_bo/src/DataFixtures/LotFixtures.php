<?php

namespace App\DataFixtures;

use App\Entity\Building;
use App\Entity\Lot;
use App\Entity\Owner;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LotFixtures extends BaseFixture implements DependentFixtureInterface
{
    public function loadData(ObjectManager $manager)
    {

        $this->createMany(
            Lot::class,
            396,
            function (Lot $lot, $count) use ($manager) {
                /** @var Building $building */
                $building = $this->getReference('building_'.$this->faker->numberBetween(0,39));
                if ($building !== null) {
                    $lot->setBuilding($building);
                }

                /** @var Owner $owner */
                $owner = $this->getReference('owner_'.$this->faker->numberBetween(0,395));
                if ($owner !== null) {
                    $lot->setOwner($owner);
                }

                $manager->persist($lot);
                $this->addReference('lot_'.$count, $lot);
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
