<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{

    private $encode;

    public function __construct(UserPasswordEncoderInterface $encoder) {
        $this->encode = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user->setEmail("admin@reucopro.com");
        $user->setPassword($this->encode->encodePassword($user, "admin"));
        $user->setRole("IS_AUTHENTICATED_FULLY");

        $manager->persist($user);
        $manager->flush();
    }
}
