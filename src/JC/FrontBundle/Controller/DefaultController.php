<?php
/**
	* Controleur pour les pages d'accueil et de présentation du site
	*
	* @author Juliana Leclaire <Juliana.Leclaire@etu.univ-savoie.fr>
	* @author Céline de Roland <Celine.de-Roland@etu.univ-savoie.fr>
	*
	* @version = 2.0
	*/
namespace JC\FrontBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
	* Controleur pour les pages d'accueil et de présentation du site
	*
	* @author Juliana Leclaire <Juliana.Leclaire@etu.univ-savoie.fr>
	* @author Céline de Roland <Celine.de-Roland@etu.univ-savoie.fr>
	*
	* @version = 2.0
	*/
class DefaultController extends Controller
{

/**
	* Point d'entrée du site web
	*
	* @return VueTwig
	* @todo Empêcher l'effet vitrine avec les conteneurs posés les uns sur les autres
	*/
	public function indexAction()
	{
		return $this->render('JCFrontBundle:Default:index.html.twig');
	}

/**
	* Executer les tests du code javascript
	*
	* @return VueTwig
	*/
	public function testAction()
	{
		return $this->render('JCFrontBundle:Default:test.html.twig');
	}

}
