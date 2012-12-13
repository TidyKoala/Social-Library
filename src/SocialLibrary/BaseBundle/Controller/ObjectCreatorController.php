<?php

namespace SocialLibrary\BaseBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use SocialLibrary\BaseBundle\Entity\ObjectCreator;
use SocialLibrary\BaseBundle\Form\Type\ObjectCreatorType;

/**
 * Manga controller.
 *
 * @Route("/object-creator/{_locale}", defaults={"_locale" = "en"})
 */
class ObjectCreatorController extends Controller
{
    /**
     * Displays a form to create a new Manga entity.
     *
     * @Route("/ajax-new", name="object_creator_ajax_new")
     * @Template()
     */
    public function newAjaxAction()
    {
        if (false === $this->get('security.context')->isGranted('ROLE_USER')) {
            throw new AccessDeniedException();
        }
        
        $entity = new ObjectCreator();
        $form   = $this->createForm(new ObjectCreatorType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a new Manga entity.
     *
     * @Route("/ajax-create", name="object_creator_ajax_create", defaults={ "_format"="xml|json"})
     * @Template("SocialLibraryReadableMediaMangaBundle:Serie:newAjax.html.twig")
     * @Method("POST")
     */
    public function createAjaxAction(Request $request)
    {
        if (false === $this->get('security.context')->isGranted('ROLE_USER')) {
            throw new AccessDeniedException();
        }
        
        $entity = new ObjectCreator();
        $form   = $this->createForm(new ObjectCreatorType(), $entity);
        $response = array('code' => 400);
        $errors = array();
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();
            $response['code'] = 200;
        }
        
        // TODO: send the error message when necessary
        
        $response = array_merge($response, array('id' => $entity->getId(), 'name' => $entity->getFullname(), 'error' => $errors ) );
        
        return new Response(json_encode($response), 200, array('Content-Type' => 'application/json'));
    }
}
