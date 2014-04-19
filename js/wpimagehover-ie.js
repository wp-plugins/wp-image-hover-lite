// Utility
jQuery(document).ready(function($){

	$(document).on('mouseenter', '.wpimagehover-anim-fade',  function(){
		// var H = $(this).find('.wpimagehover-caption').innerHeight();
		$(this).find('.wpimagehover-caption').css({'height' : '100%'});
		$(this).find('.wpimagehover-caption').css({ 'z-index' : '50' });
        $(this).find('img').fadeTo(300, 0.2);
        $(this).find('.wpimagehover-caption').fadeTo(300, 1);
	}).on('mouseleave', '.wpimagehover-anim-fade', function() {
	    $(this).find('img').fadeTo(250, 1);
        $(this).find('.wpimagehover-caption').fadeTo(250, 0.2);
        $(this).find('.wpimagehover-caption').css({ 'z-index' : '1' });
	});

});