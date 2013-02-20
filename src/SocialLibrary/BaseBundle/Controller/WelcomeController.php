<?php

namespace SocialLibrary\BaseBundle\Controller;

use Symfony\Component\HttpFoundation\Session\Session;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * Welcome controller.
 *
 */
class WelcomeController extends Controller
{
    /**
     * Displays the welcome page
     *
     * @Template()
     */
    public function indexAction()
    {
//         $languages = $this->getRequest()->getLanguages();
//         if( count($languages) > 0 ) {
//             $this->get('session')->set('_locale', $languages[0]);
//             $this->get('session')->save();
//         }
        return array();
    }
}
