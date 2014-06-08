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
use Sources\DebianBundle\Controller\DefaultController as debianController;
use Sources\WordNetBundle\Controller\DefaultController as wordnetController;
use Sources\DbPediaBundle\Controller\DefaultController as dbpediaController;
use Sources\HumourBundle\Controller\DefaultController as humourController;
use Symfony\Component\HttpFoundation\Response;
use Relais\RelaisBundle\Entity\Recherche;

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
		$recherche = new Recherche();
		$formBuilder = $this -> createFormBuilder($recherche);
		$formBuilder -> add('source','text');
		$formBuilder -> add('vue','text');
		$formBuilder -> add('mot','text');
		$formBuilder -> add('limite','integer',array('required' => false));
		$formBuilder -> add('relations','choice',array('multiple' => true, 'expanded' => false, 'required' => false));
		$form = $formBuilder -> getForm() -> createView();
		return $this->render('RelaisRelaisBundle:Default:index.html.twig',array('formrecherche' => $form));
	}

/**
	* Appelle le layout (partie cliente de l'application)
	* Le layout a pour rôle d'effectuer le relais entre les données entrées par l'utilisateur, la source de données, et la vue
	* 
	* @return HttpResponse script javascript
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
	* @todo Idée : Lorsqu'on clique sur une relation ça afficherait dans le cadre d'informations la signification de cette relation
	*/
	public function layoutrelationsAction() //testée par qunit
	{
		//On lance le script qui récupère toutes les options et appelle ensuite la fonction index pour charger le json
		return $this -> render('RelaisRelaisBundle::layoutrelations.js.twig');
	}

	public function historiqueAction($source)
	{
		$request = $this -> getRequest();
		if ($this -> get('security.context') -> isGranted('ROLE_USER') and $request -> getMethod() == 'POST')
		{
			//Récupération des relations possibles pour les insérer dans le formulaire
			$listerel = json_decode($this->forward('Sources'.ucFirst($source).'Bundle:Default:jsonrelations') -> getContent());
			$choix = array();
			foreach($listerel as $rel)
			{
				$choix[$rel] = $rel;
			}

			//Création du formulaire
			$recherche = new Recherche();
			$formBuilder = $this -> createFormBuilder($recherche);
			$formBuilder -> add('source','text');
			$formBuilder -> add('vue','text');
			$formBuilder -> add('mot','text');
			$formBuilder -> add('limite','integer',array('required' => false));
			$formBuilder -> add('relations','choice',array('choices' => $choix, 'multiple' => true, 'expanded' => false, 'required' => false));
			$form = $formBuilder -> getForm();

			//Hydratation de l'objet recherche grâce au formulaire + utilisateur connecté
			$form -> bind($request);
			$usr = $this -> get('security.context') -> getToken() -> getUser();
			$recherche -> setUser($usr);

			//Persistance de l'objet recherche en base de données
			$manager = $this -> getDoctrine() -> getManager();
			$manager -> persist($recherche);
			$manager -> flush();

			return new Response('');
		}
		else
		{
			return new Response('Formulaire Invalide');
		}
	}
}
