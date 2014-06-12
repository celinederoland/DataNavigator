<?php

namespace Sources\HumourBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
	public function testBidon() { $this -> assertTrue(true); }

	public function testJson()
	{
		$client = static::createClient();
		$crawler = $client->request('GET', '/en/humour/json/"Professeur_Roche"/"all"/2');

		$reponse = $client -> getResponse() -> getContent();
		$expected = '{"noeuds":[{"id":3,"nom":"Professeur_Roche","type":"Personne"},{"id":1,"nom":"Juliana_Leclaire","type":"Personne"},{"id":2,"nom":"Celine_de_Roland","type":"Personne"}],"relations":["dirige","rigole_avec"],"graphe":[{"noeud":3,"dirige":[1,2]},{"noeud":1,"rigole_avec":[2]},{"noeud":2,"rigole_avec":[1]}]}';

		$expected = str_replace('\n','',$expected);
		$expected = str_replace('  ',' ',$expected);

		$reponse = str_replace('\n','',$reponse);
		$reponse = str_replace('  ',' ',$reponse);

		$this -> assertEquals($expected,$reponse,'génération json incorrecte');
	}
}
