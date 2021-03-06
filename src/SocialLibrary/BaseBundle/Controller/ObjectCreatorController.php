<?php

namespace SocialLibrary\BaseBundle\Controller;

use Symfony\Component\Translation\IdentityTranslator;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use SocialLibrary\BaseBundle\Entity\ObjectCreator;
use SocialLibrary\BaseBundle\Form\Type\ObjectCreatorType;

/**
 * 
 *
 */
class ObjectCreatorController extends Controller
{
    /**
     * Displays a form to create a new ObjectCreator entity.
     *
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
     * Creates a new ObjectCreator entity.
     *
     * @Template("SocialLibraryReadableMediaMangaBundle:Serie:newAjax.html.twig")
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
        } else {
            $translator = $this->get('translator');
            foreach ($form->get('firstname')->getErrors() as $formError) {
                $errors[] = $translator->trans($formError->getMessageTemplate(), array(), 'validators');
            }
        }
        
        $response = array_merge($response, array('id' => $entity->getId(), 'name' => $entity->getFullname(), 'error' => $errors ) );
        
        return new Response(json_encode($response), 200, array('Content-Type' => 'application/json'));
    }
}
