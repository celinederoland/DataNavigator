<?php

namespace Sources\DebianBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
	public function testBidon() { $this -> assertTrue(true); }

	public function testJson()
	{
		$client = static::createClient();
		$crawler = $client->request('GET', '/en/debian/json/"nano"/"all"/2');

		$reponse = $client -> getResponse() -> getContent();
		$expected = '{"noeuds":[{"id":"1657ec96792937f71c20c9e1bdc2300f","nom":"nano"},{"id":"dpkg","nom":"dpkg"},{"id":"libc0.1","nom":"libc0.1"},{"id":"libc6","nom":"libc6"},{"id":"libc6.1","nom":"libc6.1"},{"id":"libncursesw5","nom":"libncursesw5"},{"id":"libtinfo5","nom":"libtinfo5"}],"relations":["REGEXP"],"graphe":[{"noeud":"1657ec96792937f71c20c9e1bdc2300f","REGEXP":["1657ec96792937f71c20c9e1bdc2300f","dpkg","libc0.1","libc6","libc6.1","libncursesw5","libtinfo5"]}]}';

		$expected = str_replace('\n','',$expected);
		$expected = str_replace('  ',' ',$expected);

		$reponse = str_replace('\n','',$reponse);
		$reponse = str_replace('  ',' ',$reponse);

		$this -> assertEquals($expected,$reponse,'génération json incorrecte');
	}
}
