jQuery(document).ready(function ($) {
	$('ul.menuRopa li').on('click',function(){
		var location_url = window.location.href;
		if (location_url.search("ropa-bogadia")>0){
			location_url = location_url.substring(0, location_url.search('ropa-bogadia'));
		}
		$('#contenidoRopa').load(location_url+'wp-content/themes/kleo-child/page-parts/products/'+$(this).attr('slug')+'.php');
		$('ul.menuRopa li').css('color','#000');
		$(this).css('color','#f66');
		setTimeout(function( ){ checkOrderProducts(); },1000);
	});
	$('ul.menuRopa li').on('mouseover',function(){
		$(this).css('color','#f66')
	});
	$('ul.menuRopa li').on('mouseout',function(){
		if ($('#contenidoRopa h1').text() != $(this).text()){
			$(this).css('color','#000')
		}
	});
	function checkOrderProducts(){
		$('#contenidoRopa ul.orderProducts li').on('click', function(){
			alert($(this).attr('slug'));
			orderProducts($(this).attr('slug'));
		});
	}
	function orderProducts(like){
		switch (like){
			case 'precioBajo':
				alert('bajo');
				alert( $(' ul.products li').length );
				$.each( $(' ul.products li') , function( i , val){
					alert( $(val).find('.amount').text() );
				} );
				break;
			case 'precioAlto':
				alert('alto');
				break;
			case 'novedades':
				alert('novedad')
		}
	}
});