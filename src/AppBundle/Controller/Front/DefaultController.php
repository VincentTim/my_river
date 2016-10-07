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
     * @Route("/categories/{category}", name="view_category")
     */
    public function categoryAction($category){
        $iDcategory = $this->get('entity.management')->rep('Category')->findOneBy(array('name'=>$category));
        $posts = $this->get('entity.management')->rep('Post')->findBy(
            array('category'=>$iDcategory->getId()), 
            array('modification' => 'DESC')
        ); 
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

        if(null !== $post){
            $tags = $this->get('entity.management')->rep('Tag')->getTagCount();
            $cats = $this->get('entity.management')->rep('Category')->findAll();

            $random = $this->randomPost($post->getId());
            $most = $this->mostView();
            $this->countUpdate($post);

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

    /**
     * @param $post
     */
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

    /**
     * @param $id
     * @return mixed
     */
    public function randomPost($id){
        $posts = $this->get('entity.management')->rep('Post')->findAll();

        $arrayPost =  array();

        foreach($posts as $index => $post){
            $arrayPost[$index] = $post->getId();
        }

        $index = array_rand ( $arrayPost );

        $interval = $arrayPost[$index];

        if($interval == $id){
            $index == end($arrayPost);
            $random = $this->get('entity.management')->rep('Post')->find(prev($arrayPost));
        } else {
            $random = $this->get('entity.management')->rep('Post')->find($arrayPost[$index]);
        }

        return $random;
    }

    /**
     * @return mixed
     */
    public function mostView(){
        $most = $this->get('entity.management')->rep('Post')->getMostViewed();
        return $most;
    }

    /**
     * @Route("/page-not-found", name="error_page")
     */
    public function errorPageAction(){
        return $this->render('default/404.html.twig');
    }

    /**
     * @Route("/*", name="error_contet")
     */
    public function errorContentAction(){
        return $this->redirectToRoute('error_page', array(), 301);
    }

    
}
