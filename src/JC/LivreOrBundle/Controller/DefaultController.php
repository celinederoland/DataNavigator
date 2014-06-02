<?php

namespace JC\LivreOrBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('JCLivreOrBundle:Default:index.html.twig', array('name' => $name));
    }
}
