<?php
/**
	* Modèle pour le traitement d'un résultat Getty
	*
	* @author Juliana Leclaire <Juliana.Leclaire@etu.univ-savoie.fr>
	* @author Céline de Roland <Celine.de-Roland@etu.univ-savoie.fr>
	*
	* @version 2.0
	*/
namespace Sources\GettyBundle\Entity;

/**
	* Modèle pour le traitement d'un résultat Getty
	*
	* @author Juliana Leclaire <Juliana.Leclaire@etu.univ-savoie.fr>
	* @author Céline de Roland <Celine.de-Roland@etu.univ-savoie.fr>
	*
	* @version 2.0
	*/
class GettyFormateur
{

	/**
	 * Fabrique un json au format commun correspondant à la recherche demandée
	 *
	 * @param string $mot : Mot recherché
	 * @param integer $limite : Maximum de parents à explorer
	 * @return string chaine de caractère au format json générique
	 * @todo prendre en compte d'autres relations que l'hypernymie
	*/
	public function fabriqueGraphe($mot,$limite)
	{
		$resultat = array('noeuds' => array(), 'relations' => array('childOf'), 'graphe' => array());
		$listeNoeuds = array();

		//Chaque entrée de tabjson sera de la forme 
			//Term -> array(3) (nom du noeud)
			//ScopeNote -> array(3) (description du noeud)
			//Parents -> array(2) (lignée du noeud)
		//Pour chaque tableau c'est l'attribut value qui va nous intéresser
		$tabjson = json_decode($this -> jsonRechercheGlobale($mot),true)['results']['bindings']; 
		/*echo 'Tableau résultat tabjson <br/>';
		var_dump($tabjson);*/
		
		//On crée un tableau contenant tous les noeuds et leurs ids (qu'ils soient référencés en tant que résultat ou en tant que parent d'un résultat). On construit également un tableau $parent qui contiendra le premier parent de chaque noeud
		foreach($tabjson as $valeur)
		{
			if(isset($valeur['ScopeNote']['value'])) { $descriptionNoeud = $valeur['ScopeNote']['value']; }
			$nomNoeud = trim($valeur['Term']['value']);

			//Le noeud
			$listeNoeuds[] = $nomNoeud;
			//Sa description
			if (isset($descriptionNoeud)) { $description[$nomNoeud] = $descriptionNoeud; }
			//Ses parents
			$parents = explode(',',$valeur['Parents']['value'],$limite + 1); //On pourra ajouter un attribut à explode pour limiter la profondeur
			if (isset($parents[$limite])) { unset($parents[$limite]); }
			foreach($parents as $cle => $val) 
			{ 
				$parents[$cle] = trim($val); 
				if ($cle == 0) { $parent[$nomNoeud] = trim($val); }
				if (isset($parents[$cle + 1])) { $parent[$parents[$cle]] = trim($parents[$cle + 1]); }
			}
			$listeNoeuds = array_merge($listeNoeuds,$parents);
		}
		$listeNoeuds = array_unique($listeNoeuds);
		$correspondance = array_flip($listeNoeuds);

		/*echo 'tableau listeNoeuds <br/>';
		var_dump($listeNoeuds);
		echo 'tableau parent <br/>';
		var_dump($parent);*/

		//On crée le tableau $resultat['noeuds']
		foreach ($correspondance as $cle => $valeur)
		{
			//Son id répertoriée dans le tableau $correspondance
			$noeud = array( 'id' => $valeur);
			//Son type et son nom dépende de la présence de < dans son prefLabel
			if ($cle[0] == '<') 
			{ 
				$noeud['type'] = 'Concept'; 
				$noeud['nom'] = substr($cle,1,-1);
			} 
			else 
			{ 
				$noeud['type'] = 'Term'; 
				$noeud['nom'] = $cle;
			}
			//Si il a une description on la met
			if (isset($description[$cle])) { $noeud['description'] = $description[$cle]; }
			//Sinon si c'est un terme on la cherche
			else if ($noeud['type'] == 'Term') { $noeud['description'] = $this -> rechercheDescription($cle); }

			//On ajoute le noeud
			$resultat['noeuds'][] = $noeud;
		}

		//On crée le tableau $resultat['graphe']
		foreach($tabjson as $valeur)
		{
			$id = $correspondance[trim($valeur['Term']['value'])];
			//echo 'ID : ' . $id . '<br/>';
			//echo 'Noeud : ' . $listeNoeuds[$id] . '<br/>';
			if (isset($parent[$listeNoeuds[$id]]))
			{
				//echo 'Parent Direct : ' . $parent[$listeNoeuds[$id]] . '<br/>';
				$parentDirect = $parent[$listeNoeuds[$id]];
				//if (!isset($correspondance[$parentDirect])) { echo 'Parent direct non trouvé <br/>'; }
				if (!isset($resultat['graphe'][$id]))
				{
					$resultat['graphe'][$id] = array(
						'noeud' => $id,
						'childOf' => array()
					);
				}
				$resultat['graphe'][$id]['childOf'][] = $correspondance[$parentDirect];
			}
		}

		$resultat['graphe'] = array_values($resultat['graphe']);

		//var_dump($resultat);

		$jsoncommun = json_encode($resultat);
		return $jsoncommun;
	}

	/**
	 * Fait une requête sur le endpoint sparql pour obtenir un json décrivant les relations d'un terme.
	 *
	 * @param string $mot : Mot recherché
	 * @return string chaine de caractère au format json
	*/
	public function jsonRechercheGlobale($mot)
	{
		$searchUrl = 'http://vocab.getty.edu/sparql.json?query=' . 
		urlencode('# 4.1.6 Full Text Search Query
PREFIX luc: <http://www.ontotext.com/owlim/lucene#>
PREFIX rdfs: <http://www.w3.org/2000/01/rdf-schema#>
PREFIX gvp: <http://vocab.getty.edu/ontology#>
PREFIX skosxl: <http://www.w3.org/2008/05/skos-xl#>
PREFIX skos: <http://www.w3.org/2004/02/skos/core#>
PREFIX dct: <http://purl.org/dc/terms/>
PREFIX gvp_lang: <http://vocab.getty.edu/language/>
SELECT ?Term ?ScopeNote ?Parents 
{
  ?Subject luc:term "'.$mot.'"; a ?typ.
  ?typ rdfs:subClassOf gvp:Subject; rdfs:label ?Type.
  optional {?Subject gvp:prefLabelGVP [skosxl:literalForm ?Term]}
  optional {?Subject gvp:parentString ?Parents}
  optional {?Subject skos:scopeNote [dct:language gvp_lang:en; skosxl:literalForm ?ScopeNote]}
}');

		//On utilise CURL pour effectuer la requête
		$curl_session = curl_init();
		curl_setopt($curl_session,CURLOPT_URL,$searchUrl);
		curl_setopt($curl_session,CURLOPT_RETURNTRANSFER,true);
		$response = curl_exec($curl_session);
		curl_close($curl_session);

		return $response;
	}

	/**
	 * Fait une requête sur le endpoint sparql pour obtenir la description d'un terme.
	 *
	 * @param string $mot : Mot recherché
	 * @return string chaine de caractère au format json
	*/
	public function rechercheDescription($mot)
	{
		//return 'no description';
		$searchUrl = 'http://vocab.getty.edu/sparql.json?query=' . 
		urlencode('# 4.1.8    Find Description by Exact English PrefLabel 
PREFIX dcterms: <http://purl.org/dc/terms/> 
PREFIX gvp: <http://vocab.getty.edu/ontology#> 
PREFIX skos: <http://www.w3.org/2004/02/skos/core#> 
PREFIX xl: <http://www.w3.org/2008/05/skos-xl#> 
PREFIX rdf: <http://www.w3.org/1999/02/22-rdf-syntax-ns#>
SELECT ?Description 
{ 
    ?subj gvp:prefLabelGVP/xl:literalForm "'.$mot.'"@en . 
    ?subj skos:note ?Note . 
    ?Note rdf:type xl:Label .
  	?Note dcterms:language aat:300388277 .
  	?Note xl:literalForm ?Description .
}');

		//On utilise CURL pour effectuer la requête
		$curl_session = curl_init();
		curl_setopt($curl_session,CURLOPT_URL,$searchUrl);
		curl_setopt($curl_session,CURLOPT_RETURNTRANSFER,true);
		$response = curl_exec($curl_session);
		curl_close($curl_session);
		$response = json_decode($response,true);
		if (isset($response['results']['bindings'][0]['Description']['value'])) 
		{ 
			return $response['results']['bindings'][0]['Description']['value']; 
		}
		return 'No description available';
	}

}
