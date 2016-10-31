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
        $posts = $this->get('entity.management')->rep('Post')->findBy(array('publish'=>true), array('modification' =>'DESC'));
        $collections = $this->get('entity.management')->rep('Collection')->getCollectionInfo();
        return $this->render('default/index.html.twig', array(
            'posts' => $posts,
            'collection' => $collections
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
        return $this->render(':default:page.html.twig', array(
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

            $random = $this->get('items.functions')->randomPost($post->getId());
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
