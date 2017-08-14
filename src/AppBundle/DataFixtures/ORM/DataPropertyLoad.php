<?php
/**
 * Created by PhpStorm.
 * User: olegl
 * Date: 14.08.2017
 * Time: 15:55
 */

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Properties;

class DataPropertyLoad implements FixtureInterface
{

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $property1 = new Properties();
        $property1->setPropertyName('width');
        $property1->setPropertyName('100');

        $manager->persist($property1);
        $manager->flush();

        $property2 = new Properties();
        $property2->setPropertyName('height');
        $property2->setPropertyName('200');

        $manager->persist($property2);
        $manager->flush();

    }
}