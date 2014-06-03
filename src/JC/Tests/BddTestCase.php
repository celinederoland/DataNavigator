<?php

namespace JC\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class BddTestCase extends WebTestCase
{
	protected $manager;

	public function __construct() 
	{
		$kernel = static::createKernel();
		$kernel -> boot();
		$this -> manager = $kernel -> getContainer() -> get('doctrine.orm.entity_manager');
	}

}
