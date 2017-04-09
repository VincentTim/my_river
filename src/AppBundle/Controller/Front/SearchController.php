<?php

namespace AppBundle\Controller\Front;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class SearchController extends Controller
{
    /**
     * @Route("/hashtag/{tag}", name="search_tag")
     * @Method({"GET"})
     */
    public function searchAction($tag)
    {
        $results = $this->get('entity.management')->rep('Post')->getBy($tag);
        var_dump(count($results));
        foreach($results as $post){

        }

        return $this->render(':default:page.html.twig', array(
            'posts' => $results
        ));
    }
}