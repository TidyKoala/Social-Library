<?php

namespace Acme\DemoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Acme\DemoBundle\Form\ContactType;

// these import the "@Route" and "@Template" annotations
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DemoController extends Controller
{
    /**
     * @Route("/", name="_demo")
     * @Template()
     */
    public function indexAction()
    {
        return array();
    }

    /**
     * @Route("/hello/{name}", name="_demo_hello")
     * @Template()
     */
    public function helloAction($name)
    {
        return array('name' => $name);
    }

    /**
     * @Route("/contact", name="_demo_contact")
     * @Template()
     */
    public function contactAction()
    {
        $form = $this->get('form.factory')->create(new ContactType());

        $request = $this->get('request');
        if ('POST' == $request->getMethod()) {
            $form->bindRequest($request);
            if ($form->isValid()) {
                $mailer = $this->get('mailer');
                // .. setup a message and send it
                // http://symfony.com/doc/current/cookbook/email.html

                $this->get('session')->setFlash('notice', 'Message sent!');

                return new RedirectResponse($this->generateUrl('_demo'));
            }
        }

        return array('form' => $form->createView());
    }
    
	/**
	 * @Route("/posts", name="_demo_posts")
     * @Template()
	 */
	public function postsAction()
	{
	    $em = $this->getDoctrine()->getEntityManager();
	    $repository = $em->getRepository('AcmeDemoBundle:BlogPost');
	    
//         $post = new \Acme\DemoBundle\Entity\BlogPost();
//         $post->setTitle('Squash et Capoeira');
//         $em->persist($post);

//         $next = new \Acme\DemoBundle\Entity\BlogPost();
//         $next->setTitle('Maculélé');
//         $em->persist($next);
        
//         $post = new \Acme\DemoBundle\Entity\BlogPost();
//         $post->setTitle('James Bond - Skyfall');
//         $em->persist($post);

//         $next = new \Acme\DemoBundle\Entity\BlogPost();
//         $next->setTitle('James Bond - Demain Ne Meurt Jamais');
//         $em->persist($next);
        
//         $em->flush();
        
	    $posts = $em
	        ->createQuery('SELECT p FROM AcmeDemoBundle:BlogPost p')
	        ->getArrayResult()
	    ;
	    
        return array('entities' => $posts);
	}
}
