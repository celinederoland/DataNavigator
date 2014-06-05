<?php

namespace Sources\WordNetBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
	public function testBidon() { $this -> assertTrue(true); }

	public function testJsonrelations()
	{
		$client = static::createClient();
		$crawler = $client->request('GET', '/fr/wordnet/relations');
		$expected = '["derivation","pertainymie","construction","participe_passe","hypernymie","hyponymie","meronymie","holonymie","troponymie","verbe_hyponymie","entailments","antonymie","attribut","cause","consequence","similar","synonymie"]';
		$this->assertEquals($client -> getResponse() -> getContent(), $expected,'wordnet relations en panne');
	}
}
