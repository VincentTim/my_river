<?php

namespace AppBundle\Controller\Admin;

use AppBundle\AppBundleEvents;
use AppBundle\EventListener\PostListener;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\EventDispatcher\EventDispatcher;

use AppBundle\Event\PostEvent;
use AppBundle\Entity\Post;
use AppBundle\Form\PostType;

class DashboardController extends Controller
{
    /**
     * @Route("/admin", name="admin_dashboard")
     */
    public function indexManagementAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('admin/index.html.twig', array(
            'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
        ));
    }

    /**
     * @Route("/dashboard", name="dashboard")
     */
    public function indexAction()
    {
        $posts = $this->get('entity.management')->rep('Post')->findBy(array('category'=> 2));
        $ill = $this->get('entity.management')->rep('Post')->findBy(array('category'=> 1));
        return $this->render('admin/main.html.twig', array('photos'=>$posts, 'ill'=>$ill));
    }
    
    /**
     * @Route("/dashboard/illustrations/liste", name="dashboard_illustration")
     */
    public function illustrationAction()
    {
        $liste = $this->get('entity.management')->rep('Post')->findAll();
        return $this->render('admin/post.html.twig', 
                             array(
                                 'liste'=>$liste
                             )
                            );
    }
    
    /**
     * @Route("/dashboard/illustrations/ajout", name="dashboard_illustration_add")
     * @Route("/dashboard/illustrations/edition/{id}", name="dashboard_illustration_edit")
     */
    public function addIllustrationAction($id = null)
    {
        if($id != null){
            $post = $this->get('entity.management')->rep('Post')->find($id);
            $file = false;
            $action = 'update';
        }
        else {
            $post = new Post();
            $file = true;
            $action = 'create';
        }

        $form = $this->createForm(new PostType(), $post, array('file'=> $file));

        return $this->render('admin/post.html.twig', array(
                'form'=>$form->createView(),
                'action'=>$action
            )
        );
    }
    
    /**
     * @Route("/dashboard/illustrations/contribution/{id}", name="dashboard_illustration_contribute")
     * @Route("/dashboard/photographies/contribution/{id}", name="dashboard_photo_contribute")
     */
    public function postContributeAction(Request $request, $id = null)
    {
        $dispatcher = new EventDispatcher();
        $subscriber = new PostListener();
        $dispatcher->addSubscriber($subscriber);

        if($id != null){

            $post = $this->get('entity.management')->rep('Post')->find($id);

            //Pour la mise à jour des tags, on supprime d'abord ceux enregistrés et liés
            foreach($post->getTags() as $tag){
                $tag->removePost($post);
                $post->removeTag($tag);
                $this->get('entity.management')->delete($tag);
            }

        }
        else {
            $post = new Post();
        }

        $form = $this->createForm(new PostType(), $post);

        if($request->getMethod() == 'POST'){

            $form->handleRequest($request);

            if($form->isValid()){

                $post = $form->getData();

                $event = new PostEvent($post, $request);
                $dispatcher->dispatch(AppBundleEvents::ADD_POST_EVENT, $event);

                if (null === $response = $event->getResponse()) {

                    if ($event->getPost()->getId() != null) {
                        $this->get('entity.management')->update($post);
                        $response = $this->redirectToRoute('dashboard_illustration_edit', array('id' => $event->getPost()->getId()), 301);
                    } else {
                        $this->get('entity.management')->add($post);
                        $response = $this->redirectToRoute('dashboard_illustration_add', array(), 301);
                    }

                    return $response;

                } 
            }
        }
        
        return $this->redirectToRoute('dashboard_illustration_add', array(), 301);



    }

    /**
     *
     * @Route("/dashboard/illustration/suppression/{id}", name="dashboard_illustration_delete")
     */
    public function deleteTravelAction(Request $request, $id)
    {
        $trip = $this->get('entity.management')->rep('Post')->find($id);

        try {
            $this->get('entity.management')->delete($trip);
            return $this->redirectToRoute('dashboard_illustration', array(), 301);

        } catch(\Exception $e){
            var_dump($e);
        }

    }

}
