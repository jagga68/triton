<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Component\Cache\Adapter\TagAwareAdapter;

class CacheController extends AbstractController
{
    /**
     * @Route("/cache", name="cache")
     */
    public function index(): Response
    {

        $cache = new FilesystemAdapter();
        $posts = $cache->getItem('database.get_posts');

        if(!$posts->isHit())
        {
            // this is only simulation, should be taken from db
            $posts_from_db = ['post 1', 'post 2', 'post 2']; 
            dump('connected with database...');

            $posts->set(serialize($posts_from_db));
            $posts->expiresAfter(5); // expistres after 5 seconds
            $cache->save($posts);
        }

        $cache->deleteItem('database.get_posts'); // clears only specified key
        $cache->clear(); // clears entire cache

        dump(unserialize($posts->get()));



        return $this->render('cache/index.html.twig', [
            'controller_name' => 'CacheController',
        ]);
    }

    /**
     * @Route("/cache-tagging", name="cache-tagging")
     */
    public function cacheTagging(): Response
    {

        $cache = new TagAwareAdapter(new FilesystemAdapter());

        $acer = $cache->getItem('acer');
        $dell = $cache->getItem('dell');
        $ibm = $cache->getItem('ibm');
        $apple = $cache->getItem('apple');

        if(!$acer->isHit())
        {
            $acer_from_db = 'acer laptop';
            $acer->set($acer_from_db);
            $acer->tag(['computers', 'laptops', 'acer']);
            $cache->save($acer);
            dump('acer laptop from database...');
        }
        if(!$dell->isHit())
        {
            $dell_from_db = 'dell laptop';
            $dell->set($dell_from_db);
            $dell->tag(['computers', 'laptops', 'dell']);
            $cache->save($dell);
            dump('dell laptop from database...');
        }
        if(!$ibm->isHit())
        {
            $ibm_from_db = 'ibm desktop';
            $ibm->set($ibm_from_db);
            $ibm->tag(['computers', 'desktops', 'ibm']);
            $cache->save($ibm);
            dump('ibm desktop from database...');
        }
        if(!$apple->isHit())
        {
            $apple_from_db = 'apple desktop';
            $apple->set($apple_from_db);
            $apple->tag(['computers', 'desktops', 'apple']);
            $cache->save($apple);
            dump('apple desktop from database...');
        }

        // $cache->invalidateTags(['ibm']);
        $cache->invalidateTags(['desktops']);

        dump($acer->get());
        dump($dell->get());
        dump($ibm->get());
        dump($apple->get());




        return $this->render('cache/index.html.twig', [
            'controller_name' => 'CacheController',
        ]);
    }
}
