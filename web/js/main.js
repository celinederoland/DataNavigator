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
	/*$('#menusite').resizable({ ghost:true  });
	$('#menuvue').resizable({ ghost:true  });
	$('#menudonnees').resizable({ ghost:true  });
	$('#menutools').resizable({ ghost:true  });
	$('#recherche').resizable({ ghost:true  });
	$('#options').resizable({ ghost:true  });*/
}

/**
 * Charge une url demandée dans une iframe sur le cadre #conteneurpage
 */
function chargerPage(url)
{
	$('#conteneurpage').css('visibility','visible');
	$('#conteneurpage').html(
			"<iframe id='pageframe' src='"+url+"' "+
			"width='98%' frameborder='0'></iframe>"
			);
	$('#pageframe').css('height' , '100%');
}

function activerSource(id)
{
	$('.activesource').removeClass('activesource');
	$(id).addClass('activesource');
}

function activerVue(id)
{
	$('.activevue').removeClass('activevue');
	$(id).addClass('activevue');
}
