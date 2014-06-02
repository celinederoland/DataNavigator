<?php

namespace Sources\HumourBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('SourcesHumourBundle:Default:index.html.twig', array('name' => $name));
    }
}
