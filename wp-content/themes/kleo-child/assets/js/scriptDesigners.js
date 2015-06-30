// Funcion waitForFinalEvent() no tira


if ('undefined' != typeof jQuery)
{
(function($){

	$('.imageBoxDesigner').on('mouseover', function(){

		$(this).fadeOut(1000, function(){
			startChange( $('.imageBoxDesigner').index(this), $(this) );
		}).fadeIn(400);

	})

	function startChange( nBox, image ){
		switch(nBox){
			case 0:
				image.attr("src", "<?php bloginfo('wpurl'); ?>/wp-content/uploads/2015/06/productosEjemplo.jpg");
				break;
			case 1:
				image.attr("src", "<?php bloginfo('wpurl'); ?>/wp-content/uploads/2015/06/productosEjemplo.jpg");
				break;
			case 2:
				image.attr("src", "<?php bloginfo('wpurl'); ?>/wp-content/uploads/2015/06/productosEjemplo.jpg");
				break;
			case 3:
				image.attr("src", "<?php bloginfo('wpurl'); ?>/wp-content/uploads/2015/06/productosEjemplo.jpg");
				break;
			case 4:
				image.attr("src", "<?php bloginfo('wpurl'); ?>/wp-content/uploads/2015/06/productosEjemplo.jpg");
				break;
		}		
	}

	$('.imageBoxDesigner').on('mouseout', function(){

		$(this).fadeOut(1000, function(){
			stopChange( $('.imageBoxDesigner').index(this), $(this) );
		}).fadeIn(400);

	})

	function stopChange( nBox, image ){
		switch(nBox){
			case 0:
				image.attr("src", "<?php bloginfo('wpurl'); ?>/wp-content/uploads/2015/05/lucrecia-foto-bio-1024x683.jpg");
				break;
			case 1:
				image.attr("src", "<?php bloginfo('wpurl'); ?>/wp-content/uploads/2015/06/guimmet.jpg");
				break;
			case 2:
				image.attr("src", "<?php bloginfo('wpurl'); ?>/wp-content/uploads/2015/06/sartoria.jpg");
				break;
			case 3:
				image.attr("src", "<?php bloginfo('wpurl'); ?>/wp-content/uploads/2015/06/mario.jpg");
				break;
			case 4:
				image.attr("src", "<?php bloginfo('wpurl'); ?>/wp-content/uploads/2015/06/blondies.jpg");
				break;
		}
	}

	var waitForFinalEvent = (function () {
		var timers = {};
		return function (callback, ms, uniqueId) {
		  if (!uniqueId) {
		    uniqueId = "Don't call this twice without a uniqueId";
		  }
		  if (timers[uniqueId]) {
		    clearTimeout (timers[uniqueId]);
		  }
		  timers[uniqueId] = setTimeout(callback, ms);
		};
	})();

})(jQuery);
}
