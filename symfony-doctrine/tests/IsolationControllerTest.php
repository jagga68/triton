<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use App\Entity\Video;

class IsolationControllerTest extends WebTestCase
{

    private $entityManager;

    protected function setUp(): void
    {
        parent::setUp();
        $this->client = static::createClient();

        $this->entityManager = $this->client->getContainer()->get('doctrine.orm.entity_manager');

        $this->entityManager->beginTransaction();
        $this->entityManager->getConnection()->setAutoCommit(false);
    }

    protected function tearDown(): void
    {
        $this->entityManager->rollback();
        $this->entityManager->close();
        $this->entityManager = null;
    }

    /**
     * @dataProvider provideUrls
     */
    public function testSomething($url)
    {
        $crawler = $this->client->request('GET', $url);
        $this->assertTrue($this->client->getResponse()->isSuccessful());

        $video = $this->entityManager
            ->getRepository(Video::class)
            ->find(1);

        $this->entityManager->remove($video);
        $this->entityManager->flush();

        $this->assertNull($this->entityManager
        ->getRepository(Video::class)
        ->find(1));
   
    }

    public function provideUrls()
    {
        return [
            ['/isolation'],
            ['/login']
        ];
    }
}

