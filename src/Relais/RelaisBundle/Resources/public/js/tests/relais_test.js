//Tests du relais : @RelaisBundle/Resources/views/layout.js.twig
	//Dépendant de main.js (fonction rechercher)
	//Dépendant de ce que renvoie la source
	//Dépendant de JsonRep.js.twig (ce que fait la vue)


function relaisTest()
{
	asyncTest( 
		"test de la fonction recherche (relais)", 
		function() {
			expect( 2 );
			//On active la source et la vue, puis on clique sur recherche
			$('.activesource').removeClass('activesource');
			$('.activevue').removeClass('activevue');
			$('#wordnet').trigger('click');
			$('#json').trigger('click');
			$('#btrecherche').trigger('click');
			$('#form_mot').val('entity');
 
			//Après avoir cliqué sur recherche, on attend 10s pour vérifier le résultat
			setTimeout(function() {
				console.log("récupération");
				var actual = $('#conteneurpage').html().length;
				var expected = 11161;
				//On vérifie que le résultat est bien une chaîne de caractères ayant la taille attendue
				equal(expected,actual,'le contenu du json s\'insère dans conteneurpage');
				start();

				//On vérifie que les relations se sont affichées
				var actualRels = $('#form_relations').html().length;
				var expectedRels = 816;
				equal(expectedRels,actualRels,'les relations ne sont pas insérées correctement');
			}, 10000);

		}
	);

	asyncTest( 
		"test du passage des options et du mot recherché", 
		function() {
			expect( 1 );

			//On active la source et la vue, puis on clique sur recherche
			$('.activesource').removeClass('activesource');
			$('.activevue').removeClass('activevue');
			$('#wordnet').trigger('click');
			$('#json').trigger('click');
			$('#btrecherche').trigger('click');
			$('#form_limite').val(4);
			$('#form_mot').val('entity');
			$('option').attr('selected','selected');
 
			//Après avoir cliqué sur recherche, on attend 10s pour vérifier le résultat
			setTimeout(function() {
				console.log("récupération");
				var actual = $('#conteneurpage').html().length;
				var expected = 920;
				//On vérifie que le résultat est bien une chaîne de caractères ayant la taille attendue
				equal(expected,actual,'problème dans la prise en compte des options et du mot recherché');
				start();
			}, 10000);
		}
	);
}


