<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

use App\Entity\Author;
use App\Entity\Pdf;
use App\Entity\Video;

class InheritanceEntitiesFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        
        for($i=1; $i<=2; $i++)
        {
            $author = new Author;
            $author->setName('Author name '.$i);
            $manager->persist($author);

            for ($j=1; $j <=3 ; $j++) 
            { 
                $pdf = new Pdf;
                $pdf->setFilename('pdf name of user '. $j);
                $pdf->setDescription('pdf description of user '. $i);
                $pdf->setSize(5454 + $j);
                $pdf->setOrientation('portrait');
                $pdf->setPagesNumber(200 + $j);
                $pdf->setAuthor($author);
                $manager->persist($pdf);
            }

            for ($k=1; $k <=2 ; $k++) 
            { 
                $video = new Video;
                $video->setFileName('video name of user ' . $k);
                $video->setDescription('video descriptiom of user ' . $i);
                $video->setSize(10000 + $k);
                $video->setFormat('mpeg-2');
                $video->setDuration(250 + $k);
                $video->setAuthor($author);
                $manager->persist($video);

            }
        }

        $manager->flush();
    }
}
