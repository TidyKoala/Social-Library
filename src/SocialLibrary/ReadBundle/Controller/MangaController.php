<?php

namespace SocialLibrary\ReadBundle\Controller;

use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use SocialLibrary\ReadBundle\Entity\Manga;
use SocialLibrary\ReadBundle\Form\Type\MangaType;

/**
 * Manga controller.
 *
 */
class MangaController extends Controller
{
    /**
     * Lists all Manga entities.
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
            ->getRepository('SocialLibraryReadBundle:Manga')
            ->findAllPaginated(
                    $this->get('knp_paginator'),
                    $this->get('request')->query->get('page', 1),
                    $user
                );
        
        return $this->render(
            'SocialLibraryReadBundle:Manga:' . $view . '.html.twig',
            array(
                'entities' => $entities,
                'selection' => $selection
            )
        );
    }

    /**
     * Finds and displays a Manga entity.
     *
     * @Template()
     */
    public function showAction($id, $nameSlug)
    {
        $entity = $this->getDoctrine()
            ->getRepository('SocialLibraryReadBundle:Manga')
            ->findManga($id, $nameSlug);
        
        return array(
            'entity' => $entity,
        );
    }

    /**
     * Displays a form to create a new Manga entity.
     *
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
     * @Template("SocialLibraryReadBundle:Manga:new.html.twig")
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
            if($entity->getPictureFile()) {
                $mediaManager = $this->get('sonata.media.manager.media');
                $photo = $mediaManager->create();
                $photo->setBinaryContent($entity->getPictureFile());
                $photo->setContext('manga');
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
                    'manga_this_added_library'
                );
            $this->get('session')->getFlashBag()->add('success', 'manga_this_added_library');
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
     * @Template()
     */
    public function editAction($id, $nameSlug)
    {
        if (false === $this->get('security.context')->isGranted('ROLE_USER')) {
            throw new AccessDeniedException();
        }
        
        $em = $this->getDoctrine()->getManager();

        $entity = $em
            ->getRepository('SocialLibraryReadBundle:Manga')
            ->findManga($id, $nameSlug);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Manga entity.');
        }

        $editForm = $this->createForm(new MangaType(), $entity);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
        );
    }

    /**
     * Edits an existing Manga entity.
     *
     * @Template("SocialLibraryReadBundle:Manga:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        if (false === $this->get('security.context')->isGranted('ROLE_USER')) {
            throw new AccessDeniedException();
        }
        
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SocialLibraryReadBundle:Manga')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Manga entity.');
        }

        $editForm = $this->createForm(new MangaType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            if($entity->getPictureFile()) {
                $mediaManager = $this->get('sonata.media.manager.media');
                $photo = $mediaManager->create();
                $photo->setBinaryContent($entity->getPictureFile());
                $photo->setContext('manga');
                $photo->setProviderName('sonata.media.provider.image');
                $mediaManager->save($photo);
                $entity->setPicture($photo);
            }
            $em->persist($entity);
            $em->flush();
            
            $flashMessage = $this
            ->get('translator')
            ->trans(
                    'manga_updated',
                    array(
                            '%manga_name%' => $entity->getVolume() . ' - ' . $entity->getSerie()
                    )
            );
            $this->get('session')->getFlashBag()->add('success', $flashMessage);
            return $this->redirect($this->generateUrl('manga_index'));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
        );
    }

    /**
     * Add ownership of a Manga entity.
     *
     */
    public function addOwnerAction($id, $nameSlug)
    {
        if (false === $this->get('security.context')->isGranted('ROLE_USER')) {
            throw new AccessDeniedException();
        }
        
        $em = $this->getDoctrine()->getManager();
        $entity = $em
            ->getRepository('SocialLibraryReadBundle:Manga')
            ->findManga($id, $nameSlug);
        $entity->addOwner($this->get('security.context')->getToken()->getUser());
        
        $em->persist($entity);
        $em->flush();
        
        $flashMessage = $this
        ->get('translator')
        ->trans(
                'manga_added_library',
                array(
                        '%manga_name%' => $entity->getVolume() . ' - ' . $entity->getSerie()
                )
        );
        $this->get('session')->getFlashBag()->add('success', $flashMessage);
        return $this->redirect(
            $this->getRequest()->headers->get(
                'referer',
                $this->generateUrl('manga_index')
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
            ->getRepository('SocialLibraryReadBundle:Manga')
            ->findManga($id, $nameSlug);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Manga entity.');
        }
        
        $entity->removeOwner($this->get('security.context')->getToken()->getUser());
        $em->persist($entity);
        $em->flush();
        
        $flashMessage = $this
            ->get('translator')
            ->trans(
                'manga_removed_library',
                array(
                    '%manga_name%' => $entity->getVolume() . ' - ' . $entity->getSerie()
                )
            );
        $this->get('session')->getFlashBag()->add('success', $flashMessage);
        return $this->redirect(
            $this->getRequest()->headers->get(
                'referer',
                $this->generateUrl('manga_index')
            )
        );
    }
}
