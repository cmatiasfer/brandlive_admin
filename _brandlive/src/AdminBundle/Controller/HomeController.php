<?php

namespace AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class HomeController extends Controller
{
    /**
     * @Route("/" ,name="home")
     */
    public function indexAction()
    {
        return $this->render('@admin_views/Home/home.html.twig');
    }
}
