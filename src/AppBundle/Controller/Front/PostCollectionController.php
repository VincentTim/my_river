<?php

namespace AppBundle\Controller\Front;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\EventDispatcher\EventDispatcher;

use AppBundle\AppBundleEvents;
use AppBundle\EventListener\PostListener;

use AppBundle\Event\PostEvent;

class PostCollectionController extends Controller
{
    /**
    * @Route("/collections", name="view_collection")
    */
    public function collectionAction(){

        $collections = $this->get('entity.management')->rep('Collection')->findBy(
            array(),
            array('modification' => 'DESC')
        );

        return $this->render('default/page.html.twig', array(
            'posts' => $collections
        ));

    }

    /**
    * @Route("/collection/{year}/{month}/{day}/{title}", name="collection_detail")
    */
    public function collectionDetailAction($year, $month, $day, $title){

        $post = $this->get('entity.management')->rep('Collection')->findOneBy(array('slug' => $title));

            if(null !== $post){

                $tags = $this->get('entity.management')->rep('Tag')->getTagCount();
                $cats = $this->get('entity.management')->rep('Category')->findAll();

                $random = $this->get('items.functions')->randomPost(null);
                $most = $this->get('items.functions')->mostView();
                $this->get('items.functions')->countUpdate($post);

                return $this->render('default/detail.html.twig', array(
                    'post' => $post,
                    'tags' => $tags,
                    'cats' => $cats,
                    'random' => $random,
                    'most' => $most
                ));
            }

            return $this->redirectToRoute('error_page', array(), 301);


        }


}