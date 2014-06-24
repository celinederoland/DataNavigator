/**
 * Fonctions javascript communes à toute l'application (style graphique et réaction sur les menus)
 */

$( init );
 
/**
 * Initialisation des positionnements des menus dans la page
 */
function init() {
/*	var larg = $('#conteneurmenu').innerWidth();
	var haut = $('#conteneurmenu').innerHeight();
	var hbox = $('#menuvue').outerHeight() + 5;

	$('#menuvue').draggable();
	$('#menudonnees').draggable();
	$('#menutools').draggable();
	$('#recherche').draggable();
	$('#infos').draggable();
	$('#options').draggable();
	$('#menuadmin').draggable();

	$('#recherche').css('top','0px');
	$('#options').css('top','0px');

	var hinfo = haut - $('#infos').outerHeight() - 50;

	$('#infos').css('top',hinfo + 'px');
	$('#menuadmin').css('top',haut - 2*hbox + 'px');


	$('#recherche').css('left',(larg/2 - 200) + 'px');

	$('#menudonnees').css('top','0px');
	$('#menuvue').css('top',hbox + 'px');
	$('#menutools').css('top',2*hbox + 'px');

	var lvue = larg - $('#menuvue').outerWidth() - 5;
	var ldonnees = larg - $('#menudonnees').outerWidth() - 5;
	var ltools = larg - $('#menutools').outerWidth() - 5;
	var ladmin = larg - $('#menuadmin').outerWidth() - 5;

	$('#menuvue').css('left',lvue + 'px');
	$('#menudonnees').css('left',ldonnees + 'px');
	$('#menutools').css('left',ltools + 'px');
	$('#menuadmin').css('left',ladmin + 'px');

	$('#infos').resizable({ ghost:true  });
	$('#form_relations').resizable({ ghost:true  });

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
	if ($(id).hasClass('activesource'))
	{
		$(id).removeClass('activesource');
	}
	else
	{
		$(id).addClass('activesource');
		$('#form_source').val(id.substring(1));
		$.getScript(url);
	}

}

/**
 * Ajoute la classe 'activevue' à la visualisation demandée
 */
function activerVue(id)
{
	if ($(id).hasClass('activevue'))
	{
		$(id).removeClass('activevue');
	}
	else
	{
		$(id).addClass('activevue');
		$('#form_vue').val(id.substring(1));
	}
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
	$('#loading').css('visibility','visible');
	console.log('fonction rechercher dans main.js, appelle le script à l\'adresse ' + url);
	$('#conteneurpage').html('');
	$('#conteneurpage').css('visibility','hidden');
	$.getScript(url);
}

function historique(url)
{
	$('#conteneurpage').html('');
	$('#conteneurpage').css('visibility','visible');
	$('#conteneurD3').css('visibility','hidden');
	$('#conteneurpage').load(url);
}

/*function activerRotation(id,dir)
{
	var outils = new D3_Outils();
	outils.rotate(id,dir);
}

function activerDrag(id,dx,dy)
{
	var outils = new D3_Outils();
	var dir = { x: dx * 20, y: dy * 20 };
	outils.bouger(id,dir);
}

function activerZoom(id,dir)
{
	var outils = new D3_Outils();
	outils.zoom(id,dir/10);
}*/
