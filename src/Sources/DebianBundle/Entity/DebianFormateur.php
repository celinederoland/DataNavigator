<?php
/**
	* Modèle pour le traitement d'un résultat Debian
	*
	* @author Juliana Leclaire <Juliana.Leclaire@etu.univ-savoie.fr>
	* @author Céline de Roland <Celine.de-Roland@etu.univ-savoie.fr>
	*
	* @version 2.0
	*/
namespace Sources\DebianBundle\Entity;

/**
	* Modèle pour le traitement d'un résultat Debian
	*
	* @author Juliana Leclaire <Juliana.Leclaire@etu.univ-savoie.fr>
	* @author Céline de Roland <Celine.de-Roland@etu.univ-savoie.fr>
	*
	* @version 2.0
	*/
class DebianFormateur
{

	/**
	 * Fabrique un json au format commun correspondant à la recherche demandée
	 *
	 * @param string $mot : nom du package recherché
	 * @param integer $limite : profondeur de graphe demandée
	 * @return string chaine de caractère au format json générique
	*/
	public function fabriqueGraphe($mot,$limite)
	{
		return $this -> jsonNiveau($mot,$limite);
	}

	/**
	 * Utilise le programme de l'équipe datacrawler pour générer un json générique de profondeur 1
	 *
	 * @param string $mot : nom du package
	 * @return string chaine de caractère au format json générique
	*/
	public function jsonNiveau1($mot)
	{
		$searchUrl = "http://demo4.itpassion.info/crawler.php?target=".$mot;

		$curlSession = curl_init();

		curl_setopt($curlSession, CURLOPT_URL, $searchUrl);
		curl_setopt($curlSession, CURLOPT_BINARYTRANSFER, true);
		curl_setopt($curlSession, CURLOPT_RETURNTRANSFER, true);

		$jsonresult = curl_exec($curlSession);
		curl_close($curlSession);

		//On envoie la réponse
		return $jsonresult;
	}

	/**
	 * Cherche récursivement les dépendances de packages pour les packages trouvés par la recherche de niveau 1
	 *
	 * @param string $mot : nom du package
	 * @param string $n : profondeur demandée (on s'arrête à 1)
	 * @return string chaine de caractère au format json générique
	*/
	public function jsonNiveau($mot,$n)
	{
		if ($n >= 1)
		{
			$tabjson = json_decode($this -> jsonNiveau($mot,--$n),true);
			$tabjsonfinal = $tabjson;
			foreach($tabjson['noeuds'] as $cle => $valeur)
			{
				$tabjsonfinal = $this -> fusionne($tabjsonfinal,json_decode($this -> jsonNiveau1($valeur['nom']),true),$cle);
			}

			return json_encode($tabjsonfinal);
		}
		else { return $this -> jsonNiveau1($mot); }
	}

	/**
	 * Fusionne deux tableaux au format json générique pour en former un seul 
	 *
	 * @param array $tab1 : json générique de profondeur n
	 * @param array $tab2 : json générique de profondeur 1
	 * @param integer $indice : indice à utiliser dans le tableau graphe
	 * @return array tableau fusionné
	*/
	public function fusionne($tab1,$tab2,$indice)
	{
		if ($indice != 0)
		{
			$listeid = array();
			foreach( $tab1['noeuds'] as $valeur ) { $listeid[] = $valeur['nom'];  }
			if (!isset($tab1['graphe'][$indice]['noeud'])) {
				$tab1['graphe'][$indice] = array('noeud' => $tab2['noeuds'][0]['nom'], 'REGEXP' => array());
			}
			foreach( $tab2['noeuds'] as $cle => $valeur ) 
			{ 
				if (!in_array($valeur['nom'],$listeid))
				{
					$tab1['noeuds'][] = array('id' => $valeur['nom'], 'nom' => $valeur['nom']);
					$tab1['graphe'][$indice]['REGEXP'][] = $valeur['nom'];
				}
			}
		}

		return $tab1;
	}
}
