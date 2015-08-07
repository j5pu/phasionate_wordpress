jQuery(document).ready(function ($) {
	var length_Designers = $('.boxDesigner').length;
	$(window).scroll(function() {
   		if($(window).scrollTop() + $(window).height() > $(document).height() - 100 && $('.loading-designers').length<1 && $('.noMoreDesigners').length<1) {
			$('.boxContDesigners').append("<p class='loading-designers'>Cargando más diseñadores...<img alt='loading' src='wp-content/themes/kleo-child/assets/img/Loading2.gif'/></p>");
			$('.boxContDesigners').append($('<div class="loaded">').load( 'wp-content/themes/kleo-child/page-parts/more-designers.php?desigle='+length_Designers, function(){
				$('.loading-designers').remove();
				length_Designers = $('.boxDesigner').length;
			}));
	    }
	});
})