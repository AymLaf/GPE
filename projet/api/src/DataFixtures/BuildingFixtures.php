<?php

namespace App\DataFixtures;

use App\Entity\Building;
use App\Entity\Syndic;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class BuildingFixtures extends BaseFixture implements DependentFixtureInterface
{
    public function loadData(ObjectManager $manager)
    {

        $this->createMany(
            Building::class,
            40,
            function (Building $building, $count) use ($manager) {
                $building->setAddress($this->faker->streetName);
                $building->setCity($this->faker->city);
                $building->setNumber($this->faker->buildingNumber);
                $building->setZipCode($this->faker->postcode);
                if ($this->faker->boolean(50)) {
                    $building->setComplement($this->faker->streetSuffix);
                }
                /** @var Syndic $syndic */
                $syndic = $this->getReference('syndic_'.$this->faker->numberBetween(0,3));
                if ($syndic !== null) {
                    $building->setSyndic($syndic);
                }

                $manager->persist($building);
                $this->addReference('building_'.$count, $building);
            }
        );

        $manager->flush();
    }

    public function getDependencies()
    {
        return array(
            SyndicFixtures::class
        );
    }
}
