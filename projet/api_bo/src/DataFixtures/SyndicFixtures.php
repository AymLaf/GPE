<?php

namespace App\DataFixtures;

use App\Entity\Owner;
use App\Entity\Syndic;
use App\Entity\User;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class SyndicFixtures extends BaseFixture implements DependentFixtureInterface
{
    public function loadData(ObjectManager $manager)
    {

        $this->createMany(
            Syndic::class,
            4,
            function (Syndic $syndic, $count) use ($manager) {
                /** @var User $user */
                $user = $this->getReference('user_'.$count);
                $syndic->setUser($user);
                $syndic->setName($this->faker->company);

                $manager->persist($syndic);
                $this->addReference('syndic_'.$count, $syndic);
            }
        );

        $manager->flush();
    }

    public function getDependencies()
    {
        return array(
            UserFixtures::class
        );
    }
}
