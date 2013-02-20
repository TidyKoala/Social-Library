<?php

namespace SocialLibrary\ReadBundle\GraphicNovelBundle\Controller;

use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use SocialLibrary\ReadBundle\GraphicNovelBundle\Entity\GraphicNovel;
use SocialLibrary\ReadBundle\GraphicNovelBundle\Form\Type\GraphicNovelType;

class GraphicNovelController extends Controller
{
    /**
     * Lists all GraphicNovel entities.
     *
     */
    public function indexAction($view, $selection)
    {
        if( $selection == 'all') {
            $user = null;
        }
        elseif ( $selection == 'my') {
            $user = $this->getUser();
        }
        else {
            $user = null;
        }
        
        $entities = $this->getDoctrine()
            ->getRepository('SocialLibraryReadBundleGraphicNovelBundle:GraphicNovel')
            ->findAllPaginated(
                $this->get('knp_paginator'),
                $this->get('request')->query->get('page', 1),
                $user
            );
        
        return $this->render(
            'SocialLibraryReadBundleGraphicNovelBundle:GraphicNovel:' . $view . '.html.twig',
            array(
                'entities' => $entities,
                'selection' => $selection
            )
        );
    }

    /**
     * Finds and displays a GraphicNovel entity.
     *
     * @Template()
     */
    public function showAction($id, $nameSlug)
    {
        $entity = $this->getDoctrine()
            ->getRepository('SocialLibraryReadBundleGraphicNovelBundle:GraphicNovel')
            ->findGraphicNovel($id, $nameSlug);
        
        return array(
            'entity' => $entity,
        );
    }

    /**
     * Displays a form to create a new GraphicNovel entity.
     *
     * @Template()
     */
    public function newAction()
    {
        if (false === $this->get('security.context')->isGranted('ROLE_USER')) {
            throw new AccessDeniedException();
        }
        
        $entity = new GraphicNovel();
        $form   = $this->createForm(new GraphicNovelType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a new GraphicNovel entity.
     *
     * @Template("SocialLibraryReadBundleGraphicNovelBundle:GraphicNovel:new.html.twig")
     */
    public function createAction(Request $request)
    {
        if (false === $this->get('security.context')->isGranted('ROLE_USER')) {
            throw new AccessDeniedException();
        }
        
        $entity  = new GraphicNovel();
        $form = $this->createForm(new GraphicNovelType(), $entity);
        $form->bind($request);
        $entity->addOwner($this->get('security.context')->getToken()->getUser());

        if ($form->isValid()) {
            if($entity->getPictureFile()) {
                $mediaManager = $this->get('sonata.media.manager.media');
                $photo = $mediaManager->create();
                $photo->setBinaryContent($entity->getPictureFile());
                $photo->setContext('graphic_novel');
                $photo->setProviderName('sonata.media.provider.image');
                $mediaManager->save($photo);
                $entity->setPicture($photo);
            }
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();
            
            $flashMessage = $this
                ->get('translator')
                ->trans(
                    'graphic_novel_this_added_library'
                );
            $this->get('session')->getFlashBag()->add('success', $flashMessage);
            return $this->redirect(
                $this->generateUrl(
                    'graphic_novel_show',
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
     * Displays a form to edit an existing GraphicNovel entity.
     *
     * @Template()
     */
    public function editAction($id, $nameSlug)
    {
        if (false === $this->get('security.context')->isGranted('ROLE_USER')) {
            throw new AccessDeniedException();
        }
        
        $em = $this->getDoctrine()->getManager();

        $entity = $em
            ->getRepository('SocialLibraryReadBundleGraphicNovelBundle:GraphicNovel')
            ->findGraphicNovel($id, $nameSlug);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find GraphicNovel entity.');
        }

        $editForm = $this->createForm(new GraphicNovelType(), $entity);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
        );
    }

    /**
     * Edits an existing GraphicNovel entity.
     *
     * @Template("SocialLibraryReadBundleGraphicNovelBundle:GraphicNovel:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        if (false === $this->get('security.context')->isGranted('ROLE_USER')) {
            throw new AccessDeniedException();
        }
        
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SocialLibraryReadBundleGraphicNovelBundle:GraphicNovel')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find GraphicNovel entity.');
        }

        $editForm = $this->createForm(new GraphicNovelType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            if($entity->getPictureFile()) {
                $mediaManager = $this->get('sonata.media.manager.media');
                $photo = $mediaManager->create();
                $photo->setBinaryContent($entity->getPictureFile());
                $photo->setContext('graphic_novel');
                $photo->setProviderName('sonata.media.provider.image');
                $mediaManager->save($photo);
                $entity->setPicture($photo);
            }
            $em->persist($entity);
            $em->flush();
            
            $flashMessage = $this
            ->get('translator')
            ->trans(
                'graphic_novel_updated',
                array(
                    '%graphic_novel_name%' => $entity->getVolume() . ' - ' . $entity->getSerie()
                )
            );
            $this->get('session')->getFlashBag()->add('success', $flashMessage);
            return $this->redirect($this->generateUrl('graphic_novel_index'));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
        );
    }

    /**
     * Add ownership of a GraphicNovel entity.
     *
     */
    public function addOwnerAction($id, $nameSlug)
    {
        if (false === $this->get('security.context')->isGranted('ROLE_USER')) {
            throw new AccessDeniedException();
        }
        
        $em = $this->getDoctrine()->getManager();
        $entity = $em
            ->getRepository('SocialLibraryReadBundleGraphicNovelBundle:GraphicNovel')
            ->findGraphicNovel($id, $nameSlug);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find GraphicNovel entity.');
        }
        
        $entity->addOwner($this->get('security.context')->getToken()->getUser());
        $em->persist($entity);
        $em->flush();
        
        $flashMessage = $this
        ->get('translator')
        ->trans(
            'graphic_novel_added_library',
            array(
                '%graphic_novel_name%' => $entity->getVolume() . ' - ' . $entity->getSerie()
            )
        );
        $this->get('session')->getFlashBag()->add('success', $flashMessage);
        return $this->redirect(
            $this->getRequest()->headers->get(
                'referer',
                $this->generateUrl('graphic_novel_index')
            )
        );
    }

    /**
     * Remove ownership of a GraphicNovel entity.
     *
     */
    public function removeOwnerAction($id, $nameSlug)
    {
        if (false === $this->get('security.context')->isGranted('ROLE_USER')) {
            throw new AccessDeniedException();
        }
        
        $em = $this->getDoctrine()->getManager();
        $entity = $em
            ->getRepository('SocialLibraryReadBundleGraphicNovelBundle:GraphicNovel')
            ->findGraphicNovel($id, $nameSlug);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find GraphicNovel entity.');
        }
        
        $entity->removeOwner($this->get('security.context')->getToken()->getUser());
        $em->persist($entity);
        $em->flush();
        
        $flashMessage = $this
            ->get('translator')
            ->trans(
                'graphic_novel_removed_library',
                array(
                    '%graphic_novel_name%' => $entity->getVolume() . ' - ' . $entity->getSerie()
                )
            );
        $this->get('session')->getFlashBag()->add('success', $flashMessage);
        return $this->redirect(
            $this->getRequest()->headers->get(
                'referer',
                $this->generateUrl('graphic_novel_index')
            )
        );
    }
}
