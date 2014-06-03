<?php
/**
	* Controleur pour les pages de gestion des utilisateurs
	*
	* @author Juliana Leclaire <Juliana.Leclaire@etu.univ-savoie.fr>
	* @author Céline de Roland <Celine.de-Roland@etu.univ-savoie.fr>
	*
	* @version = 2.0
	*/
namespace JC\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
	* Controleur pour les pages de gestion des utilisateurs
	*
	* @author Juliana Leclaire <Juliana.Leclaire@etu.univ-savoie.fr>
	* @author Céline de Roland <Celine.de-Roland@etu.univ-savoie.fr>
	*
	* @version = 2.0
	*/
class DefaultController extends Controller
{

/**
	* Suppression d'un compte
	*
	* @return Redirection vers la page d'accueil
	*/
	public function supprimerAction()
	{
		$container = $this -> get('service_container');
		$userManager = $container->get('fos_user.user_manager');
		$utilisateur = $this -> get('security.context') -> getToken() -> getUser();
		$userManager -> deleteUser($utilisateur);
		return $this -> redirect($this -> generateUrl('jc_front_homepage'));
	}
}
