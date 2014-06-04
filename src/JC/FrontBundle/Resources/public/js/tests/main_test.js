function mainTest()
{
	//J'exécute un test initial
	test( 
		"initial test", 
		function() {
		ok( 1 == 1, "test bidon réussi" );
		}
	);

	//Puis tous les tests de l'application
	relaisTest();
}

