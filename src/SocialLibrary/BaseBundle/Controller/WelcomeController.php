<?php

namespace SocialLibrary\BaseBundle\Controller;

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
        return array();
    }
}
