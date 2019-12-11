<?php

namespace App\DataFixtures;

use App\Entity\Actor;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class ActorFixtures extends Fixture
{
    const ACTORS = [
        'Andrew Lincoln',
        'Jennyfer Aniston',
        'Matt Damon',
        'Norman Reedus',
        'Lauren Cohan',
        'Danai Gurira'

    ];

    public function load(ObjectManager $manager)
    {
        $i = 0;
        foreach (self::ACTORS as $key => $actorName) {
            $actor = new Actor();
            $actor->setName($actorName);
            $actor->getPrograms();

            $manager->persist($actor);
            $this->addReference('actor_' . $i, $actor);
            $i++;
        }
        $manager->flush();
    }
}
