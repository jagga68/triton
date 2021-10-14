<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class EmailsTest extends WebTestCase
{
    public function testSomething(): void
    {
        $client = static::createClient();
        $client->enableProfiler();
        $crawler = $client->request('GET', '/mailer');
        $mailCollector = $client->getProfile()->getCollector('swiftmailer');

        $this->assertSame(1, $mailCollector->getMessageCount());

        $collectedMessages = $mailCollector->getMessages();
        $message = $collectedMessages[0];

        $this->assertInstanceOf('Swift_Message', $message);
        $this->assertSame('Hello Title', $message->getSubject());
        $this->assertSame('example@example.com', key($message->getFrom()));
        $this->assertSame('recipient@example.com', key($message->getTo()));
        $this->assertStringContainsString('You did it!', $message->getBody());

    }
}