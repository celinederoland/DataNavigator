<?php
/**
	* Controleur pour les pages des représentations
	*
	* @author Juliana Leclaire <Juliana.Leclaire@etu.univ-savoie.fr>
	* @author Céline de Roland <Celine.de-Roland@etu.univ-savoie.fr>
	*
	* @version = 2.0
	*/
namespace Vues\RepresentationsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
	* Controleur pour les pages des représentations
	*
	* @author Juliana Leclaire <Juliana.Leclaire@etu.univ-savoie.fr>
	* @author Céline de Roland <Celine.de-Roland@etu.univ-savoie.fr>
	*
	* @version = 2.0
	*/
class DefaultController extends Controller
{

	public function recupPost()
	{
		return array(
			'data' => $this -> getRequest() -> request -> get('data'),
			'nbsrc' => $this -> getRequest() -> request -> get('nbsrc'),
			'nbvue' => $this -> getRequest() -> request -> get('nbvue'),
			'numsrc' => $this -> getRequest() -> request -> get('numsrc'),
			'numvue' => $this -> getRequest() -> request -> get('numvue')
		);
	}
/**
	* Appelle la vue json (partie cliente de l'application)
	* 
	* @return HttpResponse script javascript
	*/
	public function jsonAction() //testée par qunit
	{
		$data = $this -> getRequest() -> request -> get('data');
		return $this -> render('VuesRepresentationsBundle:Representations:JsonRep.js.twig', $this -> recupPost());
	}

/**
	* Appelle la vue json formatée en graphe (partie cliente de l'application)
	* On construit le tableau nodes qui contient toutes les informations nécessaires pour chaque noeud
	* On construit les paires source - target qui décrivent les relations
	* 
	* @param string $data json générique fourni par le relais
	* @return HttpResponse script javascript
	*/
	public function jsonGraphAction() //testée par qunit
	{
		return $this -> render('VuesRepresentationsBundle:Representations:JsonGraphRep.js.twig', $this -> recupPost());
	}

/**
	* Appelle la vue json formatée en arbre (partie cliente de l'application)
	* Initialisation : on enregistre les informations contenues dans chaque noeud dans des tableaux (vu, types, noms, descriptions, typecouleurs)
	* On enregistre toutes les relations dans un tableau qui facilitera la construction de d3_tree
	* On répertorie les relations sous la forme relations[noeudsource][noeudcible] = nomdelarelation
	* Fabrique récursivement un json arborescent : construire un arbre = construire ses sous arbres etc
	* 
	* @param string $data json générique fourni par le relais
	* @return HttpResponse script javascript
	*/
	public function jsonTreeAction() //testée par qunit
	{
		$data = $this -> getRequest() -> request -> get('data');
		return $this -> render('VuesRepresentationsBundle:Representations:JsonTreeRep.js.twig', $this -> recupPost());
	}

/**
	* Appelle la vue bubble
	* Le packlayout de D3 permet d'agencer des ensembles de cercles dans des cercles
	* On ajoute les cercles représentant les noeuds de l'arbre
	* On ajoute le texte représentant le noeud dans chaque cercle.
	* On ajoute des etiquettes sur les noeuds
	* On prépare les zooms et on se focalise sur la racine de l'arbre
	* 
	* @return HttpResponse script javascript
	*/
	public function bubbleAction() //testée par qunit
	{
		$data = $this -> getRequest() -> request -> get('data');
		return $this -> render('VuesRepresentationsBundle:Representations:bubble.js.twig', $this -> recupPost());
	}

/**
	* Appelle la vue indented
	* On utilise le layout tree de d3 pour la forme du dessin
	* On cree les noeuds de la representation (rectangles contenant du texte)
	* On ajoute des etiquettes sur les noeuds
	* On gère le déplacement des noeuds selon s'ils ont été cliqués ou non
	* On ajoute les liens et leurs étiquettes
	* 
	* @return HttpResponse script javascript
	*/
	public function indentedAction() //testée par qunit
	{
		$data = $this -> getRequest() -> request -> get('data');
		return $this -> render('VuesRepresentationsBundle:Representations:indented.js.twig', $this -> recupPost());
	}

/**
	* Appelle la vue force
	* Le layout force de D3 permet d'agencer sous forme de graphe
	* On cree les liens de la representation et leurs étiquettes
	* On cree les noeuds de la representation (cercle, nom, étiquettes)
	* On lance la fonction tick qui gère le replacement des noeuds
	* 
	* @return HttpResponse script javascript
	*/
	public function forceAction() //testée par qunit
	{
		$data = $this -> getRequest() -> request -> get('data');
		return $this -> render('VuesRepresentationsBundle:Representations:force.js.twig', $this -> recupPost());
	}

/**
	* Appelle la vue radial
	* On utilise le layout tree de d3 pour la forme du dessin
	* On cree les liens de la representation et leurs étiquettes
	* On cree les noeuds de la representation (cercle, nom, étiquettes)
	* 
	* @return HttpResponse script javascript
	*/
	public function radialAction() //testée par qunit
	{
		$data = $this -> getRequest() -> request -> get('data');
		return $this -> render('VuesRepresentationsBundle:Representations:radial.js.twig', $this -> recupPost());
	}

/**
	* Appelle la vue matrice
	* On construit la matrice
	* On construit les lignes
	* On construit les cellules contenues dans les lignes et leurs title
	* On construit les colonnes
	* On place les noms des noeuds dans les lignes et les colonnes et on définit leurs étiquettes
	* On crée la fonction mouseover pour highlighter la ligne et la colonne courantes
	* 
	* @return HttpResponse script javascript
	*/
	public function matriceAction() //testée par qunit
	{
		$data = $this -> getRequest() -> request -> get('data');
		return $this -> render('VuesRepresentationsBundle:Representations:matrice.js.twig', $this -> recupPost());
	}

}
