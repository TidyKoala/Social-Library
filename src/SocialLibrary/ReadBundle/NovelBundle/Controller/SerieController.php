<?php

namespace SocialLibrary\ReadBundle\NovelBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use SocialLibrary\ReadBundle\NovelBundle\Entity\Serie;
use SocialLibrary\ReadBundle\NovelBundle\Form\Type\SerieAjaxType;

/**
 * Manga controller.
 *
 */
class SerieController extends Controller
{
    /**
     * Displays a form to create a new Manga entity.
     *
     * @Template()
     */
    public function newAjaxAction()
    {
        if (false === $this->get('security.context')->isGranted('ROLE_USER')) {
            throw new AccessDeniedException();
        }
        
        $entity = new Serie();
        $form   = $this->createForm(new SerieAjaxType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a new Manga entity.
     *
     * @Template("SocialLibraryReadBundleMangaBundle:Serie:newAjax.html.twig")
     */
    public function createAjaxAction(Request $request)
    {
        if (false === $this->get('security.context')->isGranted('ROLE_USER')) {
            throw new AccessDeniedException();
        }
        
        $entity = new Serie();
        $response = array('code' => 400);
        $errors = array();
        $form   = $this->createForm(new SerieAjaxType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();
            $response['code'] = 200;
        } else {
            $translator = $this->get('translator');
            foreach ($form->get('name')->getErrors() as $formError) {
                $errors[] = $translator->trans($formError->getMessageTemplate(), array(), 'validators');
            }
        }
        
        $response = array_merge($response, array('id' => $entity->getId(), 'name' => $entity->getName(), 'error' => $errors ) );
        
        return new Response(json_encode($response), 200, array('Content-Type' => 'application/json'));
    }
}
