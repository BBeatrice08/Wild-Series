<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Program;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class ProgramFixtures extends Fixture
{
    const PROGRAMS = [

        'Walking Dead' => [

            'summary' => 'Le policier Rick Grimes se réveille après un long coma. Il découvre avec effarement que le monde, ravagé par une épidémie, est envahi par les morts-vivants.',
            'poster' => 'https://external-content.duckduckgo.com/iu/?u=http%3A%2F%2Fwww.coronacomingattractions.com%2Fsites%2Fdefault%2Ffiles%2Fnews%2Fwalking_dead_poster.jpg&f=1&nofb=1',
            'category' => 'categorie_4',

        ],

        'The Haunting Of Hill House' => [

            'summary' => 'Plusieurs frères et sœurs qui, enfants, ont grandi dans la demeure qui allait devenir la maison hantée la plus célèbre des États-Unis, sont contraints de se réunir pour finalement affronter les fantômes de leur passé.',
            'poster' => 'https://external-content.duckduckgo.com/iu/?u=http%3A%2F%2Ffilmmusicreporter.com%2Fwp-content%2Fuploads%2F2018%2F10%2Ftedcas-19.jpg&f=1&nofb=1',
            'category' => 'categorie_4',

        ],

        'American Horror Story' => [

            'summary' => 'A chaque saison, son histoire. American Horror Story nous embarque dans des récits à la fois poignants et cauchemardesques, mêlant la peur, le gore et le politiquement correct.',
            'poster' => 'https://external-content.duckduckgo.com/iu/?u=http%3A%2F%2Fimages5.fanpop.com%2Fimage%2Fphotos%2F26600000%2FAmerican-Horror-Story-Season-1-UK-Promotional-Poster-american-horror-story-26649184-1056-1500.jpg&f=1&nofb=1',
            'category' => 'categorie_4',

        ],

        'Love Death And Robots' => [

            'summary' => 'Un yaourt susceptible, des soldats lycanthropes, des robots déchaînés, des monstres-poubelles, des chasseurs de primes cyborgs, des araignées extraterrestres et des démons assoiffés de sang : tout ce beau monde est réuni dans 18 courts métrages animés déconseillés aux âmes sensibles.',
            'poster' => 'https://external-content.duckduckgo.com/iu/?u=https%3A%2F%2Fcdn.flickeringmyth.com%2Fwp-content%2Fuploads%2F2019%2F02%2FLOVE_DEATH_ROBOTS_Vertical-Main_PRE_US-600x889.jpg&f=1&nofb=1',
            'category' => 'categorie_4',

        ],

        'Penny Dreadful' => [

            'summary' => 'Dans le Londres ancien, Vanessa Ives, une jeune femme puissante aux pouvoirs hypnotiques, allie ses forces à celles de Ethan, un garçon rebelle et violent aux allures de cowboy, et de Sir Malcolm, un vieil homme riche aux ressources inépuisables. Ensemble, ils combattent un ennemi inconnu, presque invisible, qui ne semble pas humain et qui massacre la population.',
            'poster' => 'https://external-content.duckduckgo.com/iu/?u=https%3A%2F%2Ffanart.tv%2Ffanart%2Ftv%2F265766%2Ftvposter%2Fpenny-dreadful-53afeb4130732.jpg&f=1&nofb=1',
            'category' => 'categorie_4',

        ],

        'Fear The Walking Dead' => [

            'summary' => 'La série se déroule au tout début de l épidémie relatée dans la série mère The Walking Dead et se passe dans la ville de Los Angeles, et non à Atlanta. Madison est conseillère dans un lycée de Los Angeles. Depuis la mort de son mari, elle élève seule ses deux enfants : Alicia, excellente élève qui découvre les premiers émois amoureux, et son grand frère Nick qui a quitté la fac et a sombré dans la drogue.',
            'poster' => 'https://external-content.duckduckgo.com/iu/?u=http%3A%2F%2Fwww.dvdsreleasedates.com%2Fposters%2F800%2FF%2FFear-the-Walking-Dead-2015-movie-poster.jpg&f=1&nofb=1',
            'category' => 'categorie_4',

        ],

    ];


    public function load(ObjectManager $manager)
    {
        $i = 0;
        foreach (self::PROGRAMS as $title => $data) {
            $program = new Program();
            $program->setTitle($title);
            $program->setSummary($data['summary']);
            $program->setPoster('poster');

            $manager->persist($program);
            $this->addReference('program ' . $i, $program);
            $i++;
        }
        $manager->flush();
    }
}
