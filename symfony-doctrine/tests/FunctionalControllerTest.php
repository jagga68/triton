<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class FunctionalControllerTest extends WebTestCase
{
    public function testSomething(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/functional');

        // $this->assertResponseIsSuccessful();

        // $this->assertStringContainsString('Hello FunctionalController!', $crawler->filter('h1')->text());

        // $this->assertGreaterThan(
        //     0,
        //     $crawler->filter('html:contains("Hello FunctionalController!")')->count()
        // );

        // $this->assertCount(1, $crawler->filter('h1'));


        // $this->assertStringContainsString('Your template', $client->getResponse()->getContent());
        // // $this->assertRegExp('/foo(bar)?/', $client->getResponse()->getContent());
        // $this->assertTrue($client->getResponse()->isSuccessful(), 'response status is 2xx');
        // $this->assertFalse($client->getResponse()->isNotFound());
        // $this->assertEquals(
        //     200,
        //     $client->getResponse()->getStatusCode()
        // );
        // $this->assertFalse(
        //     $client->getResponse()->isRedirect('/demo/contact')
        // );
        // $this->assertFalse($client->getResponse()->isRedirect());

        // $link = $crawler->filter('a:contains("Functional test link to login")')->link();
        // $crawler = $client->click($link);
        // $this->assertStringContainsString('Remember me', $client->getResponse()->getContent());

        // below is sample for login 

        $crawler = $client->request('GET', '/login');
        $form = $crawler->selectButton('Sign in')->form();
        $form['email'] = 'jag@example.com';
        $form['password'] = '123';

        $crawler = $client->submit($form);
        $crawler = $client->followRedirect();

        // $this->assertEquals(1, $crawler->filter('a:contains("logout")')->count());
        $this->assertStringContainsString('Hello DefaultController!', $client->getResponse()->getContent());


    }
}
