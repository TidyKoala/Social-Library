<?php

namespace SocialLibrary\ReadableMedia\MangaBundle\Controller;

use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use SocialLibrary\ReadableMedia\MangaBundle\Entity\Manga;
use SocialLibrary\ReadableMedia\MangaBundle\Form\Type\MangaType;

/**
 * Manga controller.
 *
 * @Route("/manga/{_locale}", defaults={"_locale" = "en"})
 */
class MangaController extends Controller
{
    /**
     * Lists all Manga entities.
     *
     * @Route("/", name="manga")
     * @Template()
     */
    public function indexAction()
    {
        $entities = $this->getDoctrine()
            ->getRepository('SocialLibraryReadableMediaMangaBundle:Manga')
            ->findAllPaginated(
                    $this->get('knp_paginator'),
                    $this->get('request')->query->get('page', 1)
                );
        
        return array(
            'entities' => $entities,
        );
    }

    /**
     * Finds and displays a Manga entity.
     *
     * @Route("/show/{id}/{nameSlug}/", name="manga_show")
     * @Template()
     */
    public function showAction($id, $nameSlug)
    {
        $entity = $this->getDoctrine()
            ->getRepository('SocialLibraryReadableMediaMangaBundle:Manga')
            ->findManga($id, $nameSlug);
        
        $deleteForm = $this->createDeleteForm($id);
        
        return array(
            'entity' => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to create a new Manga entity.
     *
     * @Route("/new", name="manga_new")
     * @Template()
     */
    public function newAction()
    {
        if (false === $this->get('security.context')->isGranted('ROLE_USER')) {
            throw new AccessDeniedException();
        }
        
        $entity = new Manga();
        $form   = $this->createForm(new MangaType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a new Manga entity.
     *
     * @Route("/create", name="manga_create")
     * @Method("POST")
     * @Template("SocialLibraryReadableMediaMangaBundle:Manga:new.html.twig")
     */
    public function createAction(Request $request)
    {
        if (false === $this->get('security.context')->isGranted('ROLE_USER')) {
            throw new AccessDeniedException();
        }
        
        $entity  = new Manga();
        $form = $this->createForm(new MangaType(), $entity);
        $form->bind($request);
        $entity->addOwner($this->get('security.context')->getToken()->getUser());

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect(
                $this->generateUrl(
                    'manga_show',
                    array(
                        'id' => $entity->getId(),
                        'nameSlug' => $entity->getNameSlug()
                    )
                )
            );
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Manga entity.
     *
     * @Route("/edit/{id}/{nameSlug}/", name="manga_edit")
     * @Template()
     */
    public function editAction($id, $nameSlug)
    {
        if (false === $this->get('security.context')->isGranted('ROLE_USER')) {
            throw new AccessDeniedException();
        }
        
        $em = $this->getDoctrine()->getManager();

        $entity = $em
            ->getRepository('SocialLibraryReadableMediaMangaBundle:Manga')
            ->findManga($id, $nameSlug);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Manga entity.');
        }

        $editForm = $this->createForm(new MangaType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Manga entity.
     *
     * @Route("/update/{id}", name="manga_update")
     * @Method("POST")
     * @Template("SocialLibraryReadableMediaMangaBundle:Manga:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        if (false === $this->get('security.context')->isGranted('ROLE_USER')) {
            throw new AccessDeniedException();
        }
        
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SocialLibraryReadableMediaMangaBundle:Manga')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Manga entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new MangaType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('manga_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Add ownership of a Manga entity.
     *
     * @Route("/add/{id}/{nameSlug}", name="manga_add_owner")
     */
    public function addOwnerAction($id, $nameSlug)
    {
        if (false === $this->get('security.context')->isGranted('ROLE_USER')) {
            throw new AccessDeniedException();
        }
        
        $em = $this->getDoctrine()->getManager();
        $entity = $em
            ->getRepository('SocialLibraryReadableMediaMangaBundle:Manga')
            ->findManga($id, $nameSlug);
        $entity->addOwner($this->get('security.context')->getToken()->getUser());
        
        $em->persist($entity);
        $em->flush();

        return $this->redirect($this->generateUrl('manga'));
    }

    /**
     * Remove ownership of a Manga entity.
     *
     * @Route("/remove/{id}", name="manga_remove_owner")
     * @Method("POST")
     */
    public function removeOwnerAction(Request $request, $id)
    {
        if (false === $this->get('security.context')->isGranted('ROLE_USER')) {
            throw new AccessDeniedException();
        }
        
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('SocialLibraryReadableMediaMangaBundle:Manga')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Manga entity.');
            }
            
            $entity->removeOwner($this->get('security.context')->getToken()->getUser());
            $em->persist($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('manga'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
