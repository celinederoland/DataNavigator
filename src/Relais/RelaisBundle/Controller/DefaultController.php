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
		$formBuilder -> add('source','hidden');
		$formBuilder -> add('vue','hidden');
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

/**
	* Enregistre la recherche en cours dans la base de données si l'utilisateur est connecté.
	* 
	* @return HttpResponse
	*/
	public function historiqueAction()
	{
		$request = $this -> getRequest();
		$source = $request -> get('form');
		$source = $source['source'];
		if ($request -> getMethod() == 'POST')
		{
			//Récupération des relations possibles pour les insérer dans le formulaire
			if ($source == 'debian') { $source = 'Debian'; }
			else if ($source == 'wordnet') { $source = 'WordNet'; }
			else if ($source == 'humour') { $source = 'Humour'; }
			else if ($source == 'dbpedia') { $source = 'DbPedia'; }
			else if ($source == 'getty') { $source = 'Getty'; }
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
			if ($this -> get('security.context') -> isGranted('ROLE_USER')) 
			{ 
				$usr = $this -> get('security.context') -> getToken() -> getUser();
			}
			else
			{
				$userManager = $this -> get('fos_user.user_manager');
				$usr = $userManager -> findUserByUsername('inconnu');
			}
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

/**
	* Récupère toutes les recherches effectuées par l'utilisateur en les filtrant (affichage complet de la page d'historique)
	* 
	* @return VueTwig
	* @param string $prio : ordre de classement (ex : date-desc,source-asc pour trier par date descendante et source ascendante). On peut trier par date, source, vue, mot.
	* @param string $impose : récupérer seulement certaines valeur (ex: source-dbpedia, mot-horse pour WHERE source=dbpedia and mot=horse)
	*/
	public function showhistoriqueAction($prio,$impose)
	{
		$recherche_rep = $this -> getDoctrine() -> getRepository('RelaisRelaisBundle:Recherche');
		$historique = $recherche_rep -> trier($this -> get('security.context') -> getToken() -> getUser(),$prio,$impose);
		return $this -> render('RelaisRelaisBundle:Default:historique.html.twig', array('historique' => $historique));
	}

/**
	* Récupère toutes les recherches effectuées par l'utilisateur en les filtrant (affichage de la seule partie contenant les résultats)
	* 
	* @return VueTwig
	* @param string $prio : ordre de classement (ex : date-desc,source-asc pour trier par date descendante et source ascendante). On peut trier par date, source, vue, mot.
	* @param string $impose : récupérer seulement certaines valeur (ex: source-dbpedia, mot-horse pour WHERE source=dbpedia and mot=horse)
	*/
	public function showhistoriqueminAction($prio,$impose)
	{
		$recherche_rep = $this -> getDoctrine() -> getRepository('RelaisRelaisBundle:Recherche');
		$historique = $recherche_rep -> trier($this -> get('security.context') -> getToken() -> getUser(),$prio,$impose);
		return $this -> render('RelaisRelaisBundle:Default:showhistorique.html.twig', array('historique' => $historique));
	}


/**
	* Modifie l'attribut favori de la recherche d'id donnée (si true passe à false et réciproquement)
	* 
	* @return HttpResponse
	* @param integer $id : id de la recherche à modifier
	*/
	public function changefavoriteAction($id)
	{
		//Sélection de la recherche demandée
		$recherche_rep = $this -> getDoctrine() -> getRepository('RelaisRelaisBundle:Recherche');
		$recherche = $recherche_rep -> find($id);

		//Modification de l'attribut favorite
		$recherche -> setFavorite( !($recherche -> getFavorite()) );

		//Enregistrement en bdd de la modification
		$manager = $this -> getDoctrine() -> getManager();
		$manager -> persist($recherche);
		$manager -> flush();

		return new Response('');
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
	* @return VueTwig script javascript
	*/
	public function layoutShowWNAction()
	{
		return $this -> render('RelaisRelaisBundle::layoutShowWN.js.twig');
	}
	
	/**
	* Appelle le layoutShowDB (partie cliente de l'application)
	* Le layoutinfos a pour rôle de proposer à l'utilisateur des informations complementaires sur DB
	* 
	* @return VueTwig script javascript
	*/
	public function layoutShowDBAction()
	{
		return $this -> render('RelaisRelaisBundle::layoutShowDB.js.twig');
	}

	/**
	* Appelle le layoutShowDebian (partie cliente de l'application)
	* Le layoutinfos a pour rôle de proposer à l'utilisateur des informations complementaires sur Debian
	* 
	* @return VueTwig script javascript
	*/
	public function layoutShowDebianAction()
	{
		return $this -> render('RelaisRelaisBundle::layoutShowDebian.js.twig');
	}
}
