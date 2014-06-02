<?php

namespace Sources\WordNetBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('SourcesWordNetBundle:Default:index.html.twig', array('name' => $name));
    }
}
