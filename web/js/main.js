/**
 * Fonctions javascript communes à toute l'application (style graphique en particulier)
 */

$( init );
 
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
