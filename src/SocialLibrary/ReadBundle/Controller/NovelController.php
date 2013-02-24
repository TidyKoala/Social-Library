<?php

namespace SocialLibrary\ReadBundle\NovelBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use SocialLibrary\ReadBundle\NovelBundle\Entity\Novel;
use SocialLibrary\ReadBundle\NovelBundle\Form\Type\NovelType;

/**
 * Novel controller.
 *
 */
class NovelController extends Controller
{
    /**
     * Lists all Novel entities.
     *
     * @Template()
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
            ->getRepository('SocialLibraryReadBundleNovelBundle:Novel')
            ->findAllPaginated(
                    $this->get('knp_paginator'),
                    $this->get('request')->query->get('page', 1),
                    $user
                );
        
        return $this->render(
            'SocialLibraryReadBundleNovelBundle:Novel:' . $view . '.html.twig',
            array(
                'entities' => $entities,
                'selection' => $selection
            )
        );
    }

    /**
     * Finds and displays a Novel entity.
     *
     * @Template()
     */
    public function showAction($id, $nameSlug)
    {
        $entity = $this->getDoctrine()
            ->getRepository('SocialLibraryReadBundleNovelBundle:Novel')
            ->findNovel($id, $nameSlug);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Novel entity.');
        }
        
        return array(
            'entity' => $entity,
        );
    }

    /**
     * Displays a form to create a new Novel entity.
     *
     * @Template()
     */
    public function newAction()
    {
        if (false === $this->get('security.context')->isGranted('ROLE_USER')) {
            throw new AccessDeniedException();
        }
        
        $entity = new Novel();
        $form   = $this->createForm(new NovelType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a new Novel entity.
     *
     * @Template("SocialLibraryReadBundleNovelBundle:Novel:new.html.twig")
     */
    public function createAction(Request $request)
    {
        if (false === $this->get('security.context')->isGranted('ROLE_USER')) {
            throw new AccessDeniedException();
        }
        
        $entity  = new Novel();
        $form = $this->createForm(new NovelType(), $entity);
        $form->bind($request);
        $entity->addOwner($this->get('security.context')->getToken()->getUser());

        if ($form->isValid()) {
            if($entity->getPictureFile()) {
                $mediaManager = $this->get('sonata.media.manager.media');
                $photo = $mediaManager->create();
                $photo->setBinaryContent($entity->getPictureFile());
                $photo->setContext('novel');
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
                        'novel_this_added_library'
                );
            $this->get('session')->getFlashBag()->add('success', $flashMessage);
            return $this->redirect(
                $this->generateUrl(
                    'novel_show',
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
     * Displays a form to edit an existing Novel entity.
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
            ->getRepository('SocialLibraryReadBundleNovelBundle:Novel')
            ->findNovel($id, $nameSlug);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Novel entity.');
        }

        $editForm = $this->createForm(new NovelType(), $entity);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
        );
    }

    /**
     * Edits an existing Novel entity.
     *
     * @Template("SocialLibraryReadBundleNovelBundle:Novel:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        if (false === $this->get('security.context')->isGranted('ROLE_USER')) {
            throw new AccessDeniedException();
        }
        
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SocialLibraryReadBundleNovelBundle:Novel')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Novel entity.');
        }

        $editForm = $this->createForm(new NovelType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            if($entity->getPictureFile()) {
                $mediaManager = $this->get('sonata.media.manager.media');
                $photo = $mediaManager->create();
                $photo->setBinaryContent($entity->getPictureFile());
                $photo->setContext('novel');
                $photo->setProviderName('sonata.media.provider.image');
                $mediaManager->save($photo);
                $entity->setPicture($photo);
            }
            $em->persist($entity);
            $em->flush();
            
            $flashMessage = $this
            ->get('translator')
            ->trans(
                    'novel_updated',
                    array(
                            '%novel_name%' => $entity->getVolume() . ' - ' . $entity->getSerie()
                    )
            );
            $this->get('session')->getFlashBag()->add('success', $flashMessage);
            return $this->redirect($this->generateUrl('novel_index'));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
        );
    }

    /**
     * Add ownership of a Novel entity.
     *
     */
    public function addOwnerAction($id, $nameSlug)
    {
        if (false === $this->get('security.context')->isGranted('ROLE_USER')) {
            throw new AccessDeniedException();
        }
        
        $em = $this->getDoctrine()->getManager();
        $entity = $em
            ->getRepository('SocialLibraryReadBundleNovelBundle:Novel')
            ->findNovel($id, $nameSlug);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Novel entity.');
        }
        
        $entity->addOwner($this->getUser());
        $em->persist($entity);
        $em->flush();
        
        $flashMessage = $this
        ->get('translator')
        ->trans(
                'novel_added_library',
                array(
                        '%novel_name%' => $entity->getVolume() . ' - ' . $entity->getSerie()
                )
        );
        $this->get('session')->getFlashBag()->add('success', $flashMessage);
        return $this->redirect(
            $this->getRequest()->headers->get(
                'referer',
                $this->generateUrl('novel_index')
            )
        );
    }

    /**
     * Remove ownership of a Manga entity.
     *
     */
    public function removeOwnerAction($id, $nameSlug)
    {
        if (false === $this->get('security.context')->isGranted('ROLE_USER')) {
            throw new AccessDeniedException();
        }
        
        $em = $this->getDoctrine()->getManager();
        $entity = $em
            ->getRepository('SocialLibraryReadBundleNovelBundle:Novel')
            ->findNovel($id, $nameSlug);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Novel entity.');
        }
        
        $entity->removeOwner($this->get('security.context')->getToken()->getUser());
        $em->persist($entity);
        $em->flush();
        
        $flashMessage = $this
            ->get('translator')
            ->trans(
                'novel_removed_library',
                array(
                    '%novel_name%' => $entity->getVolume() . ' - ' . $entity->getSerie()
                )
            );
        $this->get('session')->getFlashBag()->add('success', $flashMessage);
        return $this->redirect(
            $this->getRequest()->headers->get(
                'referer',
                $this->generateUrl('novel_index')
            )
        );
    }
}
