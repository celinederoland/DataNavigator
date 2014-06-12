<?php

namespace Sources\GettyBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
	public function testJson()
	{
		$client = static::createClient();
		$crawler = $client->request('GET', '/en/getty/json/"analyse"/"all"/2');

		$reponse = $client -> getResponse() -> getContent();
		$expected = '{"noeuds":[{"id":0,"type":"Term","nom":"analysis and testing techniques","description":"Techniques having to do with analysis and testing."},{"id":1,"type":"Concept","nom":"processes and techniques by specific type"},{"id":2,"type":"Concept","nom":"processes and techniques (processes and techniques)"},{"id":3,"type":"Term","nom":"microwear analysis","description":"Analysis employing microscopic techniques to determine how a tool was used and what materials were worked on by examining its wear."},{"id":4,"type":"Term","nom":"use-wear analysis","description":"Analysis to determine how a tool was used and what materials were worked on by examining its wear."},{"id":9,"type":"Term","nom":"analysis","description":"Examining an object, action, material, or concept in detail by separating it into its fundamental elements or component parts, reducing something complex into its various simple elements. It is the opposite process to \"synthesis.\""},{"id":10,"type":"Term","nom":"analytical functions","description":"General functions related to analysis. "},{"id":11,"type":"Concept","nom":"functions by general context"},{"id":12,"type":"Term","nom":"chemical analysis","description":"Analysis of the chemical composition of a material."},{"id":15,"type":"Term","nom":"dynamic analysis","description":"Analysis under dynamic conditions."},{"id":18,"type":"Term","nom":"thermal analysis","description":"Methods of analysis that characterize material by examining how it responds to heat."},{"id":21,"type":"Term","nom":"quantitative analysis","description":"Chemical analysis aimed at determining the proportions of the substances present in a sample of a material."},{"id":24,"type":"Term","nom":"qualitative analysis","description":"Chemical analysis aimed at examining the nature of a material\'s chemical constituents."},{"id":27,"type":"Term","nom":"differential thermal analysis","description":"A technique for observing the temperature, direction, and magnitude of thermally induced transitions in a material by heating or cooling a sample and comparing its temperature with that of an inert reference material under similar conditions."},{"id":30,"type":"Term","nom":"spatial analysis","description":"Statistical technique in which the spatial locations, distributions, and relations of designated factors are analyzed."},{"id":33,"type":"Term","nom":"risk assessment","description":"Analyzing the potential loss, failure, injury, or other damage involved in or resulting from any activity or project."},{"id":34,"type":"Term","nom":"risk management","description":"Planning how to conduct affairs by assessing, minimizing, and preventing potential losses, injuries, or other damages."}],"relations":["childOf"],"graphe":[{"noeud":0,"childOf":[1]},{"noeud":3,"childOf":[4]},{"noeud":4,"childOf":[0]},{"noeud":9,"childOf":[10]},{"noeud":12,"childOf":[0]},{"noeud":15,"childOf":[0]},{"noeud":18,"childOf":[0]},{"noeud":21,"childOf":[12]},{"noeud":24,"childOf":[12]},{"noeud":27,"childOf":[18]},{"noeud":30,"childOf":[0]},{"noeud":33,"childOf":[34]}]}';

		$expected = str_replace('\n','',$expected);
		$expected = str_replace('  ',' ',$expected);

		$reponse = str_replace('\n','',$reponse);
		$reponse = str_replace('  ',' ',$reponse);

		$this -> assertEquals($expected,$reponse,'génération json incorrecte');
	}
}
