<?php

namespace Relais\RelaisBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('RelaisRelaisBundle:Default:index.html.twig', array('name' => $name));
    }
}
