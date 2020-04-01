<?php

namespace App\DataFixtures;

use App\Entity\Owner;
use App\Entity\Syndic;
use App\Entity\User;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends BaseFixture
{

    private $encode;

    public function __construct(UserPasswordEncoderInterface $encoder) {
        $this->encode = $encoder;
    }

    public function loadData(ObjectManager $manager)
    {

        $this->createMany(
            User::class,
            20,
            function (User $user, $count) use ($manager) {
                $user->setEmail("user_".$count."@reucopro.com");
                $user->setPassword($this->encode->encodePassword($user, "user_".$count));
                $user->setRole("IS_AUTHENTICATED_FULLY");

                $manager->persist($user);

                if ($this->faker->boolean(20)) {
                    $syndic = new Syndic();
                    $syndic->setUser($user);
                    $syndic->setName($this->faker->company."_".$count);

                    $manager->persist($syndic);
                } else {
                    $owner = new Owner();
                    $owner->setUser($user);
                    $owner->setFirstname($this->faker->firstName."_".$count);
                    $owner->setLastname($this->faker->lastName."_".$count);
                    $owner->setTantieme($this->faker->numberBetween(1000, 5000));

                    $manager->persist($owner);
                }
            }
        );

        $manager->flush();
    }
}
