<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserFixture extends Fixture
{
    /**
     * Creating two dummy users
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $this->createDummyUsers(['rick', 'bob'], $manager);

        $manager->flush();
    }

    /**
     * @param array $names
     * @param ObjectManager $manager
     */
    private function createDummyUsers(array $names, ObjectManager &$manager): void
    {
        foreach ($names as $name) {
            $manager->persist(
                $this->getDummyUser($name)
            );
        }
    }

    /**
     * @param string $username
     *
     * @return User
     */
    private function getDummyUser(string $username): User
    {
        return (new User())
            ->setUsername($username)
            ->setApiKey(uuid_create(UUID_TYPE_RANDOM));
    }
}
