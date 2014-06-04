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
	* Appelle le layout (partie cliente de l'application)
	* Le layout a pour rôle d'effectuer le relais entre les données entrées par l'utilisateur, la source de données, et la vue
	* 
	* @return HttpResponse script javascript
	*/
	public function layoutAction()
	{
		//On lance le script qui récupère toutes les options et appelle ensuite la fonction index pour charger le json
		return $this -> render('RelaisRelaisBundle::layout.js.twig');
	}
}
