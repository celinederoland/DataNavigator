<?php

namespace JC\DocBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('JCDocBundle:Default:index.html.twig', array('name' => $name));
    }
}
