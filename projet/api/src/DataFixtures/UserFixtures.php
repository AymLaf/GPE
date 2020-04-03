<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends BaseFixture
{

    private $user_psw;

    public function __construct(UserPasswordEncoderInterface $encoder) {
        $user = new User();
        $this->user_psw = $encoder->encodePassword($user, "user");
        unset($user);
    }

    public function loadData(ObjectManager $manager)
    {
        $this->createMany(
            User::class,
            400,
            function (User $user, $count) use ($manager) {
                $user->setEmail("user_".$count."@reucopro.com");
                $user->setPassword($this->user_psw);
                $user->setRole("IS_AUTHENTICATED_FULLY");

                $manager->persist($user);
                $this->addReference('user_'.$count, $user);
            }
        );

        $manager->flush();
    }
}
