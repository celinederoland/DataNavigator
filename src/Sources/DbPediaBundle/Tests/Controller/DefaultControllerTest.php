<?php

namespace Sources\DbPediaBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
	public function testBidon() { $this -> assertTrue(true); }

	public function testJson()
	{
		$client = static::createClient();
		$crawler = $client->request('GET', '/en/dbpedia/json/"horse"/"all"/2');

		$reponse = $client -> getResponse() -> getContent();
		$expected = '{"noeuds":[{"id":"0","nom":"Horse"},{"id":"1","nom":"Wild_horse"},{"id":"2","nom":"Thing"},{"id":"3","nom":"Class"},{"id":"5","nom":"Animal"}],"graphe":[{"noeud":"0","species":["1"],"kingdom":["5"]},{"noeud":"1","type":["2"]},{"noeud":"2","type":["3","3"]},{"noeud":"3"},{"noeud":"5","type":["2"]}],"relations":["species","type","kingdom"]}';

		$expected = str_replace('\n','',$expected);
		$expected = str_replace('  ',' ',$expected);

		$reponse = str_replace('\n','',$reponse);
		$reponse = str_replace('  ',' ',$reponse);

		$this -> assertEquals($expected,$reponse,'génération json incorrecte');
	}
}
