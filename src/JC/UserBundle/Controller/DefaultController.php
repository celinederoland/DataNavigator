<?php

namespace JC\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
	public function indexAction($name)
	{
		return $this->render('JCUserBundle:Default:index.html.twig', array('name' => $name));
	}

	public function supprimerAction()
	{
		$container = $this -> get('service_container');
		$userManager = $container->get('fos_user.user_manager');
		$utilisateur = $this -> get('security.context') -> getToken() -> getUser();
		$userManager -> deleteUser($utilisateur);
		return $this -> redirect($this -> generateUrl('jc_front_homepage'));
	}
}
