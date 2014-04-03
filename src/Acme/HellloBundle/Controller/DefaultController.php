<?php

namespace Acme\HellloBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('AcmeHellloBundle:Default:index.html.twig', array('name' => $name));
    }
}
