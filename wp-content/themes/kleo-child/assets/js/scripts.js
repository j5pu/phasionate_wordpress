
/* v1.5 */
/*

Copyright (c) 2009 Dimas Begunoff, http://www.farinspace.com

https://github.com/farinspace/jquery.imgpreload

Licensed under the MIT license
http://en.wikipedia.org/wiki/MIT_License
*/
if ('undefined' != typeof jQuery)
{
(function($){

// extend jquery (because i love jQuery)
$.imgpreload = function (imgs,settings)
{
settings = $.extend({},$.fn.imgpreload.defaults,(settings instanceof Function)?{all:settings}:settings);

// use of typeof required
// https://developer.mozilla.org/En/Core_JavaScript_1.5_Reference/Operators/Special_Operators/Instanceof_Operator#Description
if ('string' == typeof imgs) { imgs = new Array(imgs); }

var loaded = new Array();

$.each(imgs,function(i,elem)
{
var img = new Image();

var url = elem;

var img_obj = img;

if ('string' != typeof elem)
{
url = $(elem).attr('src') || $(elem).css('background-image').replace(/^url\((?:"|')?(.*)(?:'|")?\)$/mg, "$1");

img_obj = elem;
}

$(img).bind('load error', function(e)
{
loaded.push(img_obj);

$.data(img_obj, 'loaded', ('error'==e.type)?false:true);

if (settings.each instanceof Function) { settings.each.call(img_obj); }

// http://jsperf.com/length-in-a-variable
if (loaded.length>=imgs.length && settings.all instanceof Function) { settings.all.call(loaded); }

$(this).unbind('load error');
});

img.src = url;
});
};

$.fn.imgpreload = function(settings)
{
$.imgpreload(this,settings);

return this;
};

$.fn.imgpreload.defaults =
{
each: null // callback invoked when each image in a group loads
, all: null // callback invoked when when the entire group of images has loaded
};

//Nueva Galeria
/*Scrool Move*/
//Scroll Limit
window.onload = function() {
	

	if (window.addEventListener) {

		// IE9, Chrome, Safari, Opera
		window.addEventListener("mousewheel", MouseWheelHandler, false);
		// Firefox
		window.addEventListener("DOMMouseScroll", MouseWheelHandler, false);
	}
	// IE 6/7/8
	else window.attachEvent("onmousewheel", MouseWheelHandler);

	function MouseWheelHandler(e) {

		// cross-browser wheel delta
		var e = window.event || e; // old IE support
		var delta = Math.max(-1, Math.min(1, (e.wheelDelta || -e.detail)));

		if (delta==-1){
			$('.navImagenes').scrollTo($('.navImagenes').scrollTop()+300);
		}else if(delta==1){
			$('.navImagenes').scrollTo($('.navImagenes').scrollTop()-300);
		}

		return false;
	}

	$('body').on({
	    'mousewheel': function(e) {
			if($('.bigSection').css('display')=='block' && $(window).width()>767){
				e.preventDefault();
			}
		}
	})
	window.onscroll = function(e) {
		if($('.bigSection').css('display')=='block'){
			var scrollPosition =  self.pageYOffset || document.documentElement.scrollTop  || document.body.scrollTop;
			if ($(window).width()>767){
				e.preventDefault();
				$(window).scrollTop(20);
			}
		}
	};
}

$.fn.scrollTo = function( target, options, callback ){
  if(typeof options == 'function' && arguments.length == 2){ callback = options; options = target; }
  var settings = $.extend({
    scrollTarget  : target,
    offsetTop     : 50,
    duration      : 500,
    easing        : 'swing'
  }, options);
  return this.each(function(){
    var scrollPane = $(this);
    var scrollTarget = (typeof settings.scrollTarget == "number") ? settings.scrollTarget : $(settings.scrollTarget);
    var scrollY = (typeof scrollTarget == "number") ? scrollTarget : scrollTarget.offset().top + scrollPane.scrollTop() - parseInt(settings.offsetTop);
    scrollPane.animate({scrollTop : scrollY }, parseInt(settings.duration), settings.easing, function(){
      if (typeof callback == 'function') { callback.call(this); }
    });
  });
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

function ownResize(){
	if (document.createEvent) { // W3C
	    var ev = document.createEvent('Event');
	    ev.initEvent('resize', true, true);
	    window.dispatchEvent(ev);
	} else { // IE
	    document.fireEvent('onresize');
	}
}

/*Nueva Galeria*/
	if(!$('.portada_posts').length && $('.menuGaleria').length){

//Crear contenedor Galeria
		$('body').append($('<div>', {class: 'bigSection'}));
		$('body').append($('<div>', {class: 'bigCover'}));

//Crear boton cerrar		
		$('.bigSection').append($('<div>', {class: 'quitBigSection'}).on('click',function(){
			$('.medSection').css('display','none');
			$('.bigSection').css({'height':'0%','display':'none'});
			$('.bigCover').css('display','none');
			$('.bigSection').remove('.arrowNav');
			$('.pagination-sticky').css('visibility','visible');
			$('.kleo-go-top').css('visibility','visible');
		}));

//Ocultar las secciones dentro de contenedores(medSection)
		$sections = $('section').has('p').has('img').not(':has(section)').has('ins'); //.has('.publiGaleria');
		for ($i=0; $i<$sections.length; $i++){
			$('.bigSection').append($('<div>', {class: 'medSection', id: 'medSection'+$i}).css({'display':'none'}));
			$($sections[$i]).addClass('sec'+$i);	
		}
		$medSection = $('.medSection');
		for($i=0; $i<$medSection.length; $i++){
			$($medSection[$i]).append($('.sec'+$i));
		}

//Funcionalidad al .menuGaleria
		$imagenes = $('.menuGaleria').find('li').addClass('elemGaleria').on('click',function(){
			$l=$($imagenes).length;
			$i=$(this).parent().children().index(this);
			$('.medSection').css('display','none');
			$('.medSection').css('opacity','0');
			$('.bigSection').css('display','inline-block');
			$('.bigSection').css('height','100%');
			$('.bigCover').css('display','block');
			openMedsection($i);
		});
		
		function openMedsection(num){

			$i=num;
			$('.pagination-sticky').css('visibility','hidden');
			$('.kleo-go-top').css('visibility','hidden');
			$(window).scrollTop(20);
			$('#medSection'+num).css('display','block');
			setTimeout(function(){
				$('#medSection'+num).css('opacity','1')
				$('#medSection'+num).find('.wpb_wrapper').eq(0).find('img').css({'opacity':'1'});
			//	$('#medSection'+num).find('.col-sm-6').eq(0).find('.wpb_wrapper').eq(1).css('background-color','white');
			},500);

	//Crear shadow
			var shadowHeight = $('.medSection').eq(num).find('.kleo_text_column').height();
			$('.medSection').eq(num).find('.wpb_single_image').css('box-shadow','0px 0px 20px #000, 0px ' + shadowHeight + 'px 20px #000');
			$('.medSection').eq(num).find('.wpb_raw_html').css('box-shadow','0px 0px 20px #000, 0px ' + shadowHeight + 'px 20px #000');

			ownResize();

	//Crear flechas window.width<768
			function sideArrows(num){
				if($(window).width()<768){
					if($('.elemGaleria img').length>1){
						if(!$('.arrowLeft').length){
							$('.bigSection').append($('<div>', {class: 'arrowLeft arrowHor'})
	//							.append($('<img>').attr({'src':'wp-content/themes/kleo/assets/img/flecha-ph3.png'}))
								.on('click',function(){
									$('.medSection').css('display','none');
									$('.medSection').css('opacity','0');
									$('.arrowHor').remove();
									$numArrowLeft=(num-1+$l)%$l;
									console.log("num: " + num + " + 1 + $l: " + $l + " = " + (num+1+$l)%$l + " = " + $numArrowLeft);
									openMedsection($numArrowLeft);
									ownResize();
								}));
							$('.bigSection').append($('<div>', {class: 'arrowRight arrowHor'})
								.on('click',function(){
									$('.medSection').css('display','none');
									$('.medSection').css('opacity','0');
									$('.arrowHor').remove();
									$numArrowRight=(num+1+$l)%$l;
									console.log("num: " + num + " + 1 + $l: " + $l + " = " + (num+1+$l)%$l + " = " + $numArrowRight);
									openMedsection($numArrowRight);
								ownResize();
								}));
						}
					}
				}
			}
			sideArrows(num);

	//Crear icono debajo de la publi
			if(!$('.medSection .publiGaleria').eq(num).has('.logoGaleria').length){
				$publiSections = $('.medSection .publiGaleria');
				$diamond = $('.medSection .publiGaleria').eq(num).prev().find('.kleo_text_column').height();
				$($publiSections[num]).children().append($('<div>', {class: 'logoGaleria'}).css('height',$diamond+'px')
					.append($('<img>').attr({'src':'http://www.phasionate.com/wp-content/themes/kleo-child/assets/img/diamante.png'}).css('max-height', $('ins').eq(num).height()*0.15+'px')));
			}else{
				$('.medSection .publiGaleria').eq(num).find('.logoGaleria img').css('max-height', $('ins').eq(num).height()*0.15+'px');
			}
			$diamond = $('.medSection .publiGaleria').eq(num).prev().find('.kleo_text_column').height();
			$('.medSection .publiGaleria').find('.logoGaleria').css('height',$diamond+'px');
			ownResize();

			$(window).resize(function () {
			    waitForFinalEvent(function(){
					$diamond = $('.medSection .publiGaleria').eq(num).prev().find('.kleo_text_column').height();
					$($publiSections[num]).find('.logoGaleria').css('height',$diamond+'px');
					$($publiSections[num]).find('.logoGaleria').find('img').css('max-height',$('ins').eq(num).height()*0.15+'px');

					var shadowHeight = $('.medSection').eq(num).find('.kleo_text_column').height();
					$('.medSection').eq(num).find('.wpb_single_image').css('box-shadow','0px 0px 20px #000, 0px ' + shadowHeight + 'px 20px #000');
					$('.medSection').eq(num).find('.wpb_raw_html').css('box-shadow','0px 0px 20px #000, 0px ' + shadowHeight + 'px 20px #000');

				    //Determinar altura
				    if($(window).width()>767){
					var alturaMedSection = ($(window).height()-$('.medSection').eq(num).height())/2.5;
					$('.medSection').eq(num).css('top', alturaMedSection+'px');
					}

					sideArrows(num);
			    }, 200, "some unique string");
			});

	//Crear menu galeria
			if($('.elemGaleria img').length>1){
				if(!$('.elemNavImagenes').length){
					$('.bigSection').prepend($('<div>', {class: 'navImagenes'}));
					for(var i=0;i<$('.elemGaleria img').length;i++){
						$('.elemGaleria img').eq(i).clone().addClass('elemNavImagenes').appendTo('.navImagenes').on('click', function(){
							$('.medSection').css('display','none');
							$('.medSection').css('opacity','0');
							$i=$(this).parent().children().index(this);
							openMedsection($i);
						});
					}
				}	
				$('.elemNavImagenes').css('border-color','white');
				$('.elemNavImagenes').eq($i).css('border-color','#f96d72');

				if($(window).height()*0.7<$('.elemNavImagenes').length*$('.elemNavImagenes').height()){
					if(!$('.arrowTop').length){
						$('.bigSection').prepend($('<div>', {class: 'arrowTop arrowNav'}));
						$('.bigSection').prepend($('<div>', {class: 'arrowBot arrowNav'}));
					}	
					$('.arrowTop').on('mousedown',function(){
						$('.navImagenes').scrollTo($('.navImagenes').scrollTop()-300);
					});

					$('.arrowBot').on('mousedown',function(){
						$('.navImagenes').scrollTo($('.navImagenes').scrollTop()+300);
					});
				}
			    //Determinar altura
				if($(window).width()>767){
				var alturaMedSection = ($(window).height()-$('.medSection').eq(num).height())/2.5;
				$('.medSection').eq(num).css('top', alturaMedSection+'px');
				}
			}
		}		
	}
/*Final Nueva Galeria*/


/*Seccion active (Se pinta la categoría del menú correspondiente al post visualizado*/
	$category=$("meta[property='article:section']").attr('content');
	console.log($category);
	switch($category){
		case "Cara y Cuerpo":
		case "Salud y Dietas":
		case "Pelo":
		case "Novedades":
			$category="Belleza";
			break;
		case "Tendencias":
		case "Historia":
		case "Cómo ir":
			$category="Moda";
			break;
		case "Pasarelas":
		case "Ficha el Look de":
		case "Cómo lo llevan":
			$category="Streetstyle";
			break;
		case "Gourmet":
		case "Escapadas":
		case "Salidas":
		case "Compras":
		case "StyleTech":
			$category="Lifestyle";
			break;
	}
	if($('.product').length>0 || $('.woocommerce').length>0){
		$category="Tienda";
	}
	if($('.checkout-steps').length>0 || $('p.cart-empty').length>0){
		$('.cart-contents').find('i').css('color','#F66 !important');
		document.styleSheets[0].addRule('.icon-basket-full-alt:before','color:#f66');
		console.log(document.styleSheets[0]);
	}
	console.log($('.product').length);
	console.log($category);
	$('.navbar-nav').find("li a[title="+$category+"]").css('color','#F66');
/*Final seccion active*/

/*Effect Header Title and RRSS*/

	var $win = $(window);
	// definir mediente $pos la altura en píxeles desde el borde superior de la ventana del navegador y el elemento
	var $pos = 2;

	// header pequeño desde el comienzo
	// 15304 -> pagina perfil um (15566?)
	// 15817 -> pagina concurso
	// 15314 -> configurar my phasion
	// 15993 -> phasionistas
	// 15587 -> aphasionate o unete
	// 15897 -> login
	// 15306 -> aphasionate (acceder)
	console.log(navigator.userAgent);
	if ($win.width()>990){
		/*if ($('body.bbpress').length>0 || $('body.page-id-15304').length>0 || $('body.page-id-15566').length>0 || $('body.page-id-15817').length>0 || $('body.page-id-15314').length>0 
				|| $('body.page-id-15993').length>0 || $('body.page-id-15587').length>0 || $('body.page-id-15897').length>0 || $('body.page-id-15306').length>0 ){*/
		if(!$('body.home').length){
			$('.kleo-main-header strong.logo').clone().appendTo('.kleo-main-header').removeClass('logo').addClass('phasionateHeader').css('top','-50px');
			$('#undefined-sticky-wrapper').css({height: '38px'});
			$('.kleo-main-header strong.logo').css({top:'-160px',height:'0px'});
			$('#footer-sidebar-2').clone().appendTo('.kleo-main-header').addClass('logoHeader');
				$('.phasionateHeader').css({top: '5px'});
				$('.logoHeader').css({top: '-5px'});
			$pos = 0;
		}
	}	
	$win.scroll(function () {

		if (!(navigator.userAgent.search("Safari") >= 0 && navigator.userAgent.search("Chrome") < 0)){

			if ($win.width()>990){
				if ($win.scrollTop() < $pos) {
					$('#undefined-sticky-wrapper').animate({height:'200px'});
					$('.kleo-main-header strong.logo').animate({height:'160px', top:'0px'});
					$('.logoHeader').animate({top: '-50px'});
					$('.phasionateHeader').animate({top: '-50px'});
					setTimeout(function(){ 
						$('.logoHeader').remove();
						$('.phasionateHeader').remove();
					},400);
				} else {	       
					
					if(!$('.logoHeader').length){
						$('.kleo-main-header strong.logo').clone().appendTo('.kleo-main-header').removeClass('logo').addClass('phasionateHeader').css('top','-50px');
						$('#undefined-sticky-wrapper').animate({height: '140px'});
						$('.kleo-main-header strong.logo').animate({top:'-160px',height:'0px'});
						$('#footer-sidebar-2').clone().appendTo('.kleo-main-header').addClass('logoHeader');
						setTimeout(function(){ 	
							$('.phasionateHeader').animate({top: '5px'});
							$('.logoHeader').animate({top: '-5px'});
						},400);
					}	
				}
			}else{
				$('.kleo-main-header strong.logo').animate({height:'45px', top:'0px'});
				if($('.logoHeader').length){
					$('.logoHeader').remove();
					$('.phasionateHeader').remove();
				}
			}	
		}else if($win.width()>990){
			$('.kleo-main-header strong.logo').clone().appendTo('.kleo-main-header').removeClass('logo').addClass('phasionateHeader').css('top','-50px');
			$('#undefined-sticky-wrapper').css({height: '38px'});
			$('.kleo-main-header strong.logo').css({top:'-160px',height:'0px'});
			$('#footer-sidebar-2').clone().appendTo('.kleo-main-header').addClass('logoHeader');
				$('.phasionateHeader').css({top: '5px'});
				$('.logoHeader').css({top: '-5px'});
			$pos = 0;
		}
	});
console.log(navigator.userAgent);
/*End Effect Header Title and RRSS*/
/*Recuperar revolution slider*/

	var revSliderReforce = false;

	//Check if browser is IE or not
    if (navigator.userAgent.search("MSIE") >= 0) {
        console.log("Browser is InternetExplorer");
    }
    //Check if browser is Chrome or not
    else if (navigator.userAgent.search("Chrome") >= 0) {
        revSliderReforce = true;
    }
    //Check if browser is Firefox or not
    else if (navigator.userAgent.search("Firefox") >= 0) {
        revSliderReforce = true;
    }
    //Check if browser is Safari or not
    else if (navigator.userAgent.search("Safari") >= 0 && navigator.userAgent.search("Chrome") < 0) {
        revSliderReforce = true;
    }
/*    //Check if browser is Opera or not
    else if (navigator.userAgent.search("Opera") >= 0) {
        console.log("Browser is Opera");
    }*/

    var nua = navigator.userAgent;
	var is_android = ((nua.indexOf('Mozilla/5.0') > -1 && nua.indexOf('Android ') > -1 && nua.indexOf('AppleWebKit') > -1) && !(nua.indexOf('Chrome') > -1) && !(nua.indexOf('537') > -1));


	if(revSliderReforce && /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) && !is_android){
		$('.wpb_revslider_element').on('tap', '.tp-caption > a', function(){
		    if ($(this).attr('href').indexOf("phasionate") < 0 ){
		    	window.open($(this).attr('href'));
		    }else{
		    	self.location = $(this).attr('href');	    	
		    }
		});
	}	

/*Fin recuperar revolution slider*/
/*Pop up Log in Facebook*//*
	console.log($("meta[property='og:title']").attr('content'));
	if($('#footer-sidebar-4 .new-fb-btn').length>0 && $("meta[property='og:title']").attr('content')=="Concurso - Phasionate"){
		showPopUpFbLogIn();
	}
	if($('li.dropdown:has(a.accederComunidad)').length>0){
		$('.accederComunidad').bind('click', false);
		$('.accederComunidad').click(function () { showPopUpFbLogIn(); return false;});
		$('li.dropdown:has(a.accederComunidad)>a').addClass("classPointer");
		$('li.dropdown:has(a.accederComunidad)').click(function () { showPopUpFbLogIn(); });
		$('li.dropdown:has(a.accederComunidad)>a').removeAttr('href');
	}
	function showPopUpFbLogIn(){
		$('.new-fb-btn').css('display','inline-block');
		$('body').append($('<div>', {class: 'bigCover'}));
		$('.bigCover').append($('<div>', {class: 'popUpSection'}));
		$('.popUpSection').append($('<div>', {class: 'logoPhasionateLogIn'}));
		$('.logoPhasionateLogIn').text('PHASIONÂTE');
		$('.new-fb-btn').appendTo('.popUpSection');
		$('.popUpSection').append($('<div>', {class: 'getBackLinkContainer'}));
		$('.getBackLinkContainer').append($('<a>', {class: 'getBackLink'}));
		$urlPrincipal = $('.logo a').attr('href');
		$('.getBackLink').attr('href',$urlPrincipal);
		$('.getBackLink').text('Volver a Principal');

		$('.bigCover').css('display','inline-block');
		$('.popUpSection').css('margin-top',($(window).height()-320)/2);
		setTimeout(function(){$('.popUpSection').slideDown("slow")},2000);
	}
*//*Fin pop up Log in Facebook*/





/* Pop up Log in Ultimate Member */
	if($('.botton_register_main').length>0){
		$('.botton_register_main').bind('click', false);
		$('.botton_register_main').click(function () { showPopUpRegister(); return false;});
	}
	if($('#mostrar-pop-up-registro').length>0){
		$('#mostrar-pop-up-registro').bind('click', false);
		$('#mostrar-pop-up-registro').click(function () { showPopUpLogin(); return false;});
	}
	function showPopUpRegister(){
		$('#text-57').css('display','inline-block');
		$('body').append($('<div>', {class: 'bigCover'}));
		$('.bigCover').append($('<div>', {class: 'popUpSection'}));
		$('.popUpSection').append($('<div>', {class: 'logoPhasionateLogIn'}));
		$('.logoPhasionateLogIn').text('PHASIONÂTE');
		$('#text-57').appendTo('.popUpSection');
		$('.popUpSection').append($('<div>', {class: 'getBackLinkContainer'}));
		$('.getBackLinkContainer').append($('<div>', {class: 'getBackLink'}));
		//$urlPrincipal = $('.logo a').attr('href');
		//$('.getBackLink').attr('href',$urlPrincipal+'/login');
		$('.getBackLink').click(function () { closePopUpRegister(); });
		$('.getBackLink').text('Cerrar');

		$('.bigCover').css('display','inline-block');
		$('.popUpSection').css('margin-top',($(window).height()-$('.popUpSection').height())/2);
		//var marginleftIframeGoogle=(($('.popUpSection').width()-$('.popUpSection iframe').width())/2+20)*-1;
		//$('.popUpSection iframe').css('margin-left', marginleftIframeGoogle);
		setTimeout(function(){$('.popUpSection').slideDown("slow")},2000);
	}
	function closePopUpRegister(){
		$('#text-57').css('display','none');
		$('#text-57').appendTo('#footer-sidebar-4');
		$('.bigCover').remove();
		$('.popUpSection').remove();
		$('.logoPhasionateLogIn').remove();
		$('.getBackLinkContainer').remove();
	}
/* Fin Pop up Log in Ultimate Member */

/* Pop up Log in Ultimate Member */
	if($('.menu_acceso').length>0){
		$('.menu_acceso').bind('click', false);
		$('.menu_acceso').click(function () { showPopUpLogin(); return false;});
	}
	function showPopUpLogin(){
		$('#text-41').css('display','block');
		$('body').append($('<div>', {class: 'bigCover'}));
		$('.bigCover').append($('<div>', {class: 'popUpSection'}));
		$('.popUpSection').append($('<div>', {class: 'logoPhasionateLogIn'}));
		$('.logoPhasionateLogIn').text('PHASIONÂTE');
		$('#text-41').appendTo('.popUpSection');
		$('.popUpSection').append($('<div>', {class: 'getBackLinkContainer'}));
		$('.getBackLinkContainer').append($('<div>', {class: 'getBackLink'}));
		//$urlPrincipal = $('.logo a').attr('href');
		//$('.getBackLink').attr('href',$urlPrincipal+'/login');
		$('.getBackLink').click(function () { closePopUpLogin(); });
		$('.getBackLink').text('Cerrar');

		$('.bigCover').css('display','inline-block');
		$('.popUpSection').css('margin-top',($(window).height()-$('.popUpSection').height())/2);
		//var marginleftIframeGoogle=(($('.popUpSection').width()-$('.popUpSection iframe').width())/2+20)*-1;
		//$('.popUpSection iframe').css('margin-left', marginleftIframeGoogle);
		setTimeout(function(){$('.popUpSection').slideDown("slow")},2000);
	}
	function closePopUpLogin(){
		$('#text-41').css('display','none');
		$('#text-41').appendTo('#footer-sidebar-4');
		$('.bigCover').remove();
		$('.popUpSection').remove();
		$('.logoPhasionateLogIn').remove();
		$('.getBackLinkContainer').remove();
	}
/* Fin Pop up Log in Ultimate Member */

/* Extra for Button - Participar en el concurso */
	if($('body.page-id-15817').length>0){

		if($('label.um-field-radio').length>0){
			$('label.um-field-radio > input').attr('checked', 'checked');

			$('.um-col-alt > div.um-left').removeClass('um-half').removeClass('um-left').addClass('um-center');
			$('.um-col-alt > div.um-center > input').val("¡Quiero ser Portada!");
			$('.um-col-alt > div.um-right').remove();
		}else{
			//console.log("Ya es concursante! ...o no es phasionista");
			$('.um-form > .um-profile-body').css('display','none');
			$('.um-col-alt').css('display','none');
		}
	}

/* Fin extra for Button - Participar en el concurso */

/* Funcionalidad editar galeria */
	if($('div.um-profile.um-editing') ){
		
		if( $('.um-field-foto_concurso').has('.show').length>0 ){
			$('.um-field-foto_2_concurso').css('display','block');
		}else{
			$('.um-field-foto_concurso .um-button.um-btn-auto-width').on('click', function(){
			setTimeout(function(){ 
				$('.um-modal-btn.um-finish-upload.image').on('click', function(){ $('.um-field-foto_2_concurso').css('display','block'); })
			}, 1000)
			})
		}

		if( $('.um-field-foto_2_concurso').has('.show').length>0 ){
			$('.um-field-foto_3_concurso').css('display','block');
		}else{
			$('.um-field-foto_2_concurso .um-button.um-btn-auto-width').on('click', function(){
			setTimeout(function(){ 
				$('.um-modal-btn.um-finish-upload.image').on('click', function(){ $('.um-field-foto_3_concurso').css('display','block'); })
			}, 1000)
			})
		}

		if( $('.um-field-foto_3_concurso').has('.show').length>0 ){
			$('.um-field-foto_4_concurso').css('display','block');
		}else{
			$('.um-field-foto_3_concurso .um-button.um-btn-auto-width').on('click', function(){
			setTimeout(function(){ 
				$('.um-modal-btn.um-finish-upload.image').on('click', function(){ $('.um-field-foto_4_concurso').css('display','block'); })
			}, 1000)
			})
		}

		if( $('.um-field-foto_4_concurso').has('.show').length>0 ){
			$('.um-field-foto_5_concurso').css('display','block');
		}else{
			$('.um-field-foto_4_concurso .um-button.um-btn-auto-width').on('click', function(){
			setTimeout(function(){ 
				$('.um-modal-btn.um-finish-upload.image').on('click', function(){ $('.um-field-foto_5_concurso').css('display','block'); })
			}, 1000)
			})
		}
	}
	
/* Fin funcionalidad editar galeria */

/* Extra buscador de phasionistas de la pagina*//*
	if($('input#user_login').length> 0 && $('.um-15303').length> 0){
		$('.um-button.um-do-search').on('click', function(){
			var formulario = $('div.um-15303').find($('form'));
			formulario.css('border','2px solid red');
			valor_busqueda = $('input#user_login').val();
			formulario.append($('<input>', {type: 'hidden', name: 'nickname', id: 'nickname', value: valor_busqueda}));
		})
		console.log("aqui estoy");
	}
*/
})(jQuery);
}
