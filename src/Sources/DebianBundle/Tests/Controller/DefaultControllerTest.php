<?php

namespace Sources\DebianBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
	public function testBidon() { $this -> assertTrue(true); }

	public function testJson()
	{
		$client = static::createClient();
		$crawler = $client->request('GET', '/en/debian/json/nano/all/2');

		$reponse = $client -> getResponse() -> getContent();
		$expected = '{"noeuds":[{"id":"1657ec96792937f71c20c9e1bdc2300f","nom":"nano"},{"id":"dpkg","nom":"dpkg"},{"id":"libc0.1","nom":"libc0.1"},{"id":"libc6","nom":"libc6"},{"id":"libc6.1","nom":"libc6.1"},{"id":"libncursesw5","nom":"libncursesw5"},{"id":"libtinfo5","nom":"libtinfo5"},{"id":"libbz2-1.0","nom":"libbz2-1.0"},{"id":"libgcc1","nom":"libgcc1"},{"id":"liblzma5","nom":"liblzma5"},{"id":"libselinux1","nom":"libselinux1"},{"id":"tar","nom":"tar"},{"id":"zlib1g","nom":"zlib1g"},{"id":"libc-bin","nom":"libc-bin"},{"id":"multiarch-support","nom":"multiarch-support"},{"id":"gcc-4.7-base","nom":"gcc-4.7-base"},{"id":"libunwind7","nom":"libunwind7"}],"relations":["REGEXP"],"graphe":[{"noeud":"1657ec96792937f71c20c9e1bdc2300f","REGEXP":["1657ec96792937f71c20c9e1bdc2300f","dpkg","libc0.1","libc6","libc6.1","libncursesw5","libtinfo5"]},{"noeud":"dpkg","REGEXP":["libbz2-1.0","libgcc1","liblzma5","libselinux1","tar","zlib1g"]},{"noeud":"libc0.1","REGEXP":["libc-bin"]},{"noeud":"libc6","REGEXP":[]},{"noeud":"libc6.1","REGEXP":[]},{"noeud":"libncursesw5","REGEXP":["multiarch-support"]},{"noeud":"libtinfo5","REGEXP":[]},{"noeud":"libbz2-1.0","REGEXP":[]},{"noeud":"libgcc1","REGEXP":["gcc-4.7-base","libunwind7"]},{"noeud":"liblzma5","REGEXP":[]},{"noeud":"libselinux1","REGEXP":[]},{"noeud":"tar","REGEXP":[]},{"noeud":"zlib1g","REGEXP":[]},{"noeud":"libc-bin","REGEXP":[]},{"noeud":"multiarch-support","REGEXP":[]}]}';

		$expected = str_replace('\n','',$expected);
		$expected = str_replace('  ',' ',$expected);

		$reponse = str_replace('\n','',$reponse);
		$reponse = str_replace('  ',' ',$reponse);

		$this -> assertEquals($expected,$reponse,'génération json incorrecte');
	}

	public function testInformations()
	{
		$client = static::createClient();
		$crawler = $client->request('GET', '/fr/debian/fenetre');

		$reponse = $client -> getResponse() -> getContent();

		$this -> assertContains("gedit", $reponse);
	}
}
