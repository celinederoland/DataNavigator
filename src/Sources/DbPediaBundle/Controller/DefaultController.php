<?php

namespace Sources\DbPediaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('SourcesDbPediaBundle:Default:index.html.twig', array('name' => $name));
    }
}
