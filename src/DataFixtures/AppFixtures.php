<?php

namespace App\DataFixtures;

use App\Entity\Post;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Cocur\Slugify\Slugify;


class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $slugify = new Slugify();

        echo $slugify->slugify('Hello World!'); // hello-world

        for ($i=1; $i < 20; $i++) { 

            $Post = new Post();
            $Post->setTitle('Post Number '.$i);
            $Post->setBody('
            Lorem ipsum dolor sit, amet consectetur adipisicing elit. Doloribus nobis minus ea rem eligendi. Possimus vel dicta rem culpa. Sequi sed doloremque corporis nihil sint qui amet ut maiores. Totam?
            Lorem ipsum dolor sit, amet consectetur adipisicing elit. Doloribus nobis minus ea rem eligendi. Possimus vel dicta rem culpa. Sequi sed doloremque corporis nihil sint qui amet ut maiores. Totam?
            Lorem ipsum dolor sit, amet consectetur adipisicing elit. Doloribus nobis minus ea rem eligendi. Possimus vel dicta rem culpa. Sequi sed doloremque corporis nihil sint qui amet ut maiores. Totam?
            Lorem ipsum dolor sit, amet consectetur adipisicing elit. Doloribus nobis minus ea rem eligendi. Possimus vel dicta rem culpa. Sequi sed doloremque corporis nihil sint qui amet ut maiores. Totam?' .$i);
            $Post->setSlug($slugify->slugify($Post->getTitle()));
            $Post->setCreatedAt(new \datetime);
            $manager->persist($Post);
            
        }
            $manager->flush();
    }
}
