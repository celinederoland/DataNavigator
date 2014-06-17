//Tests du relais : @RelaisBundle/Resources/views/layout.js.twig
	//Dépendant de main.js (fonction rechercher)
	//Dépendant de ce que renvoie la source
	//Dépendant de JsonRep.js.twig (ce que fait la vue)


function vuesTest()
{
	asyncTest( 
		"test du formateur to_graph et de la vue jsongraph (vues)", 
		function() {
			expect( 1 );
			//On active la source et la vue, puis on clique sur recherche
			$('.activesource').removeClass('activesource');
			$('.activevue').removeClass('activevue');
			$('#wordnet').trigger('click');
			$('#jsongraph').trigger('click');
			$('#btrecherche').trigger('click');
			$('#form_mot').val('entity');
 
			//Après avoir cliqué sur recherche, on attend 10s pour vérifier le résultat
			setTimeout(function() {
				console.log("récupération");
				var actual = $('#conteneurpage').html().length;
				var expected = 14975;
				//On vérifie que le résultat est bien une chaîne de caractères ayant la taille attendue
				equal(expected,actual,'jsongraph (formateur et vue) s\'insère correctement');
				start();
			}, 15000);

		}
	);

}


