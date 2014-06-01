/**
 * Fonctions javascript communes à toute l'application (style graphique en particulier)
 */

$( init );
 
function init() {
	var larg = $(window).width() - 400;
	var haut = $(window).height();
	var hbox = $('#menusite').height() + 20;
	var lbox = $('#menuvue').width();

	$('#menusite').draggable();
	$('#menuvue').draggable();
	$('#menudonnees').draggable();
	$('#menutools').draggable();
	$('#recherche').draggable();
	$('#infos').draggable();
	$('#options').draggable();

	$('#menusite').css('top','0px');
	$('#recherche').css('top',hbox + 'px');
	$('#options').css('top',(2*hbox) + 'px');

	$('#infos').css('top','0px');
	$('#menudonnees').css('top',hbox + 'px');
	$('#menuvue').css('top',(2*hbox) + 'px');
	$('#menutools').css('top',(3*hbox) + 'px');


	$('#menuvue').css('left',larg + 'px');
	$('#menudonnees').css('left',larg + 'px');
	$('#menutools').css('left',larg + 'px');
	$('#infos').css('left',larg + 'px');

	$('#infos').resizable({ ghost:true  });
}
