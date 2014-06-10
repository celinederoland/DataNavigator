<?php
/**
	* Controleur pour les pages du relais entre les sources de données et les vues
	*
	* @author Juliana Leclaire <Juliana.Leclaire@etu.univ-savoie.fr>
	* @author Céline de Roland <Celine.de-Roland@etu.univ-savoie.fr>
	*
	* @version = 2.0
	*/
namespace Relais\RelaisBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

/**
	* Controleur pour les pages du relais entre les sources de données et les vues
	*
	* @author Juliana Leclaire <Juliana.Leclaire@etu.univ-savoie.fr>
	* @author Céline de Roland <Celine.de-Roland@etu.univ-savoie.fr>
	*
	* @version = 2.0
	*/
class DefaultController extends Controller
{


/**
	* Point d'entrée de la page
	*
	* @return VueTwig
	*/
	public function indexAction() //testée par phpunit
	{
		return $this->render('RelaisRelaisBundle:Default:index.html.twig');
	}

/**
	* Appelle le layout (partie cliente de l'application)
	* Le layout a pour rôle d'effectuer le relais entre les données entrées par l'utilisateur, la source de données, et la vue
	* 
	* @return HttpResponse script javascript
	* @todo Prendre en compte les options et le mot recherché
	* @todo Mettre en place un appel automatique à un layoutRelations lorsqu'on sélectionne une source de données, ce qui permettrait d'afficher les relations en option
	* @todo Adapter lorsqu'on ajoute de nouvelles vues et de nouvelles sources
	* @todo Gérer également l'enregistrement des options de l'utilisateur en bdd. Plus généralement : mettre en place un système de favoris et d'historique.
	*/
	public function layoutAction() //testée par qunit
	{
		//On lance le script qui récupère toutes les options et appelle ensuite la fonction index pour charger le json
		return $this -> render('RelaisRelaisBundle::layout.js.twig');
	}

/**
	* Appelle le layoutrelations (partie cliente de l'application)
	* Le layoutrelations a pour rôle de proposer à l'utilisateur les relations possibles pour la source qu'il a sélectionnée
	* 
	* @return HttpResponse script javascript
	*/
	public function layoutrelationsAction() //testée par qunit
	{
		//On lance le script qui récupère toutes les options et appelle ensuite la fonction index pour charger le json
		return $this -> render('RelaisRelaisBundle::layoutrelations.js.twig');
	}
	
	
	/**
	* Appelle le layoutinfos (partie cliente de l'application)
	* Le layoutinfos a pour rôle de proposer à l'utilisateur des informations complementaires
	* 
	* @return HttpResponse script javascript
	*/
	public function layoutinfosAction()
	{
		return $this -> render('RelaisRelaisBundle::layoutinfos.js.twig');
	}
	
	/**
	* Appelle le layoutShowWN (partie cliente de l'application)
	* Le layoutinfos a pour rôle de proposer à l'utilisateur des informations complementaires sur WN
	* 
	* @return HttpResponse script javascript
	*/
	public function layoutShowWNAction()
	{
		return $this -> render('RelaisRelaisBundle::layoutShowWN.js.twig');
	}
	
	/**
	* Appelle le layoutShowDB (partie cliente de l'application)
	* Le layoutinfos a pour rôle de proposer à l'utilisateur des informations complementaires sur DB
	* 
	* @return HttpResponse script javascript
	*/
	public function layoutShowDBAction()
	{
		return $this -> render('RelaisRelaisBundle::layoutShowDB.js.twig');
	}
}
