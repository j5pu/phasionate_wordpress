jQuery(document).ready(function ($) {
	$('ul.menuRopa li').on('click',function(){
		var location_url = window.location.href;
		if (location_url.search("productos-bogadia")>0){
			location_url = location_url.substring(0, location_url.search('productos-bogadia'));
		}
		var title_selected = $(this).text();
		var slug_selected = $(this).attr('slug');
		$('ul.menuRopa li').css('color','#000');
		$('ul.menuRopa li[slug='+slug_selected+']').css('color','#f66');
		$('#contenidoRopa').children().fadeOut('slow');
		$('<img>').addClass('loadingContenidoRopa').attr('src', location_url+'wp-content/themes/kleo-child/assets/img/loadingProductos.gif').appendTo($('#contenidoRopa')).fadeIn();
		$('#contenidoRopa').load(location_url+'wp-content/themes/kleo-child/page-parts/products.php?slug='
				+ $(this).attr('slug')
				+ '&type_attr=' + $(this).attr('attr'),
			function(){
				$('ul.products li').addClass("start-animation");		
				$('<h1>').text(title_selected).prependTo($('#contenidoRopa'));
				/*var aCopy = $('#contenidoRopa').clone();
				$('#contenidoRopa').remove();
				$('#contenidoRopa').prepend(aCopy);*/
				setTimeout(function( ){ checkOrderProducts(); },500);
				mouseoverEffectActive();
				$('ul.menuRopa li').css('color','#000');
				$('ul.menuRopa li[slug='+slug_selected+']').css('color','#f66');
			});
	});
	function mouseoverEffectActive(){	
		$('ul.menuRopa li').on('mouseover',function(){
			$(this).css('color','#f66')
		});
		$('ul.menuRopa li').on('mouseout',function(){
			if ($('#contenidoRopa h1').text() != $(this).text()){
				$(this).css('color','#000')
			}
		});
	}
	function checkOrderProducts(){
		$('#contenidoRopa ul.orderProducts li').on('click', function(){
			$('#contenidoRopa ul.orderProducts li').css({'border-color':'#000','background-color':'#fff','color':'#000'});
			$(this).css({'border-color':'#bbb','background-color':'#000','color':'#f66'})
			orderProducts($(this).attr('slug'));
		});
	}
	function orderProducts(like){

		switch (like){
			case 'precioBajo':
				$orden = [];
				$.each( $(' ul.products li') , function( i , val){
					$orden.push( $(val).find('.amount').text() );
					$orden.sort();
				} );
				$.each( $orden, function( i, val){
					$('ul.products li:contains('+ val + ')').appendTo($('ul.products'));
				});
				break;
			case 'precioAlto':
				$orden = [];
				$.each( $(' ul.products li') , function( i , val){
					$valor = $(val).find('.amount').text().replace("€","");
					$orden.push( parseFloat($valor) );
					$orden.sort(function(a, b){ return b-a});
				} );
				$.each( $orden, function( i, val){
					$('ul.products li:contains('+ val + ')').appendTo($('ul.products'));
				});
				break;
			case 'novedades':
				$orden = [];
				$.each( $(' ul.products li') , function( i , val){
					$valor = $(val).find('.product-details').attr('data-release');
					$orden.push( $valor );
					$orden.sort(function(a, b){ return b-a});
				} );
				$.each( $orden, function( i, val){
					$('ul.products li:has(.product-details[data-release='+val+'])').appendTo($('ul.products'));
				});
				break;
			case 'populares':
				$orden = [];
				$.each( $(' ul.products li') , function( i , val){
					$valor = $(val).find('.product-details').attr('data-pop');
					$orden.push( $valor );
					$orden.sort(function(a, b){ return b-a});
				} );
				$.each( $orden, function( i, val){
					$('ul.products li:has(.product-details[data-pop='+val+'])').appendTo($('ul.products'));
				});
				break;
		}
	}
});