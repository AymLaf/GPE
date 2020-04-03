<?php

namespace App\DataFixtures;

use App\Entity\Building;
use App\Entity\Owner;
use App\Entity\User;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class OwnerFixtures extends BaseFixture implements DependentFixtureInterface
{
    public function loadData(ObjectManager $manager)
    {

        $this->createMany(
            Owner::class,
            396,
            function (Owner $owner, $count) use ($manager) {
                /** @var User $user */
                $user = $this->getReference('user_'.($count+4));

                /** @var Building $building */
                $building = $this->getReference('building_'.$this->faker->numberBetween(0,39));

                $owner->setUser($user);
                $owner->setBuilding($building);
                $owner->setFirstname($this->faker->firstName);
                $owner->setLastname($this->faker->lastName);
                $owner->setTantieme($this->faker->numberBetween(1, 1000));

                $manager->persist($owner);
                $this->addReference('owner_'.$count, $owner);
            }
        );

        $manager->flush();
    }

    public function getDependencies()
    {
        return array(
            UserFixtures::class,
            BuildingFixtures::class
        );
    }
}
