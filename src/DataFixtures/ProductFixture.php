<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ProductFixture extends Fixture
{
    /**
     * Creating dummy products
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $this->createDummyProducts(['product 1', 'product 2'], $manager);

        $manager->flush();
    }

    /**
     * @param array $names
     * @param ObjectManager $manager
     */
    private function createDummyProducts(array $names, ObjectManager &$manager): void
    {
        foreach ($names as $name) {
            $manager->persist(
                $this->getDummyProduct($name)
            );
        }
    }

    /**
     * @param string $name
     *
     * @return Product
     */
    private function getDummyProduct(string $name): Product
    {
        return (new Product())->setName($name);
    }
}
