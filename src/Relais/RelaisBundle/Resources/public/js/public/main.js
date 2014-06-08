/**
 * Fonctions javascript communes à toute l'application (style graphique et réaction sur les menus)
 */

$( init );
 
/**
 * Initialisation des positionnements des menus dans la page
 */
function init() {
	var larg = $('#conteneurmenu').innerWidth();
	var hbox = $('#menusite').outerHeight() + 5;

	$('#menusite').draggable();
	$('#menuvue').draggable();
	$('#menudonnees').draggable();
	$('#menutools').draggable();
	$('#recherche').draggable();
	$('#infos').draggable();
	$('#options').draggable();

	$('#menusite').css('top','0px');
	$('#recherche').css('top','0px');
	$('#options').css('top',hbox + 'px');
	$('#infos').css('top',3*hbox + 'px');

	$('#recherche').css('left',(larg/2) + 'px');

	$('#menudonnees').css('top','0px');
	$('#menuvue').css('top',hbox + 'px');
	$('#menutools').css('top',2*hbox + 'px');

	var lvue = larg - $('#menuvue').outerWidth() - 5;
	var ldonnees = larg - $('#menudonnees').outerWidth() - 5;
	var ltools = larg - $('#menutools').outerWidth() - 5;

	$('#menuvue').css('left',lvue + 'px');
	$('#menudonnees').css('left',ldonnees + 'px');
	$('#menutools').css('left',ltools + 'px');

	$('#infos').resizable({ ghost:true  });
	$('#selectRelation').resizable({ ghost:true  });
	//$('#options').resizable({ ghost:true  });
	/*$('#menusite').resizable({ ghost:true  });
	$('#menuvue').resizable({ ghost:true  });
	$('#menudonnees').resizable({ ghost:true  });
	$('#menutools').resizable({ ghost:true  });
	$('#recherche').resizable({ ghost:true  });
	*/
}

/**
 * Charge une url demandée dans le cadre #conteneurtests puis exécute les tests
 */
function chargerTests()
{
	$('#conteneurtests').css('visibility','visible');
	mainTest();
}

/**
 * Charge une url demandée dans une iframe sur le cadre #conteneurpage
 */
function chargerPage(url)
{
	$('#conteneurtests').css('visibility','hidden');
	$('#conteneurpage').css('visibility','visible');
	$('#conteneurpage').html(
			"<iframe id='pageframe' src='"+url+"' "+
			"width='98%' frameborder='0'></iframe>"
			);
	$('#pageframe').css('height' , '100%');
}

/**
 * Ajoute la classe 'activesource' à la source de données demandée
 */
function activerSource(id,url)
{
	$('.activesource').removeClass('activesource');
	$(id).addClass('activesource');
	$('#form_source').val(id.substring(1));
	$.getScript(url);
}

/**
 * Ajoute la classe 'activevue' à la visualisation demandée
 */
function activerVue(id)
{
	$('.activevue').removeClass('activevue');
	$(id).addClass('activevue');
	$('#form_vue').val(id.substring(1));
}

/**
 * Lance la recherche grâce au relais :
 * on efface conteneur page
 * on appelle layout (script js)
 * layout regarde les options indiquées
 * layout récupère le json fabriqué par la partie serveur du relais (contrôleur) en lui donnant les options indiquées
 * layout appelle la vue (script js) en lui donnant le json fabriqué
 * la vue insère des contenus dans conteneurD3 et/ou conteneurpage
 */
function rechercher(url)
{
	console.log('fonction rechercher dans main.js, appelle le script à l\'adresse ' + url);
	$('#conteneurpage').html('');
	$('#conteneurpage').css('visibility','hidden');
	$.getScript(url);
}

function historique(url)
{
	$('#conteneurpage').html('');
	$('#conteneurpage').css('visibility','visible');
	$('#conteneurpage').load(url);
}
