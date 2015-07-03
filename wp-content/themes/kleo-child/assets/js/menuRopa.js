jQuery(document).ready(function ($) {
	$('ul.menuRopa li').on('click',function(){
		var location_url = window.location.href;
		if (location_url.search("ropa-bogadia")>0){
			location_url = location_url.substring(0, location_url.search('ropa-bogadia'));
		}
		$('#contenidoRopa').load(location_url+'wp-content/themes/kleo-child/page-parts/products/'+$(this).attr('slug')+'.php');
		$('ul.menuRopa li').css('color','#000');
		$(this).css('color','#902828')
	});
});