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

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $posts = $this->get('entity.management')->rep('Post')->findAll();
        return $this->render('default/index.html.twig', array(
            'posts' => $posts
        ));
    }

    /**
     * @Route("/post/{category}/{year}/{month}/{day}/{title}", name="post_detail")
     */
    public function postDetailAction($category, $year, $month, $day, $title){
        
        $iDcategory = $this->get('entity.management')->rep('Category')->findOneBy(array('name'=>$category));
        $post = $this->get('entity.management')->rep('Post')->findOneBy(array('category'=>$iDcategory->getId(), 'slug' => $title));
        
        $this->countUpdate($post);
        
        return $this->render('default/detail.html.twig', array(
            'post' => $post
        ));
    }
    
    public function countUpdate($post){
          
        $request = new Request();
        
        $dispatcher = new EventDispatcher();
        $subscriber = new PostListener();
        $dispatcher->addSubscriber($subscriber);
        
        $event = new PostEvent($post, $request);
        $dispatcher->dispatch(AppBundleEvents::UPDATE_POST_VIEW_COUNT_EVENT, $event);

        if (null === $response = $event->getResponse()) {

            $this->get('entity.management')->update($post);            

        }
        
    }
    
}
