
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

/*Seccion active (Se pinta la categoría del menú correspondiente al post visualizado*/
	$category=$("meta[property='article:section']").attr('content');
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
		case "Streetstyle":
		case "Pasarelas":
		case "Ficha el Look de":
		case "Cómo lo llevan":
			$category="Street style";
			break;
		case "Gourmet":
		case "Escapadas":
		case "Salidas":
		case "Compras":
		case "StyleTech":
			$category="Lifestyle";
			break;
	}
	if($('.product').length>0 || $('body.woocommerce-page').length>0){
		$category="Tienda";
	}
	if($('.checkout-steps').length>0 || $('p.cart-empty').length>0){
		$('.cart-contents').find('i').css('color','#F66 !important');
		document.styleSheets[0].addRule('.icon-basket-full-alt:before','color:#f66');
	}
	if(window.location.href.search("disenadores")>0 && $('body.woocommerce-page').length>0){
		$('#enlace-disenadores-bogadia').css('color','#f66');
	}
	if(window.location.href.search("colecciones")>0 && $('body.woocommerce-page').length>0){
		$('#enlace-colecciones-bogadia').css('color','#f66');
	}
	if(window.location.href.search("productos-bogadia")>0 || $('body.single-product').length>0){
		$('#enlace-productos-bogadia').css('color','#f66');
	}
	if(window.location.href.search("por-que-bogadia")>0){
		$('#enlace-por-que-bogadia').css('color','#f66');
	}
	$('.navbar-nav').find("li a[title='"+$category+"']").css('color','#F66');
/*Final seccion active*/

/*Change header item list*/
	$('#nav-menu-item-search').insertBefore($('#menu-item-15589'));
	$('#nav-menu-item-search').insertBefore($('#menu-item-15568'));

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
		    if ($(this).attr('href').indexOf("bogadia") < 0 ){
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
		//$('#footer-sidebar-4').append($('<div>').attr('id','text-57').append($('.um-register')));
		$('.botton_register_main').bind('click', false);
		$('.botton_register_main').click(function () { showPopUpRegister(); return false;});
		if($('.um-register .um-field-error').length>0 || $('p.um-notice.err').length>0){
			showPopUpRegister();
		}
	}
	if($('#mostrar-pop-up-registro').length>0){
		$('#mostrar-pop-up-registro').bind('click', false);
		$('#mostrar-pop-up-registro').click(function () { showPopUpRegister(); return false;});
	}
	function showPopUpRegister(){
		$('#text-57').css('display','inline-block');
		$('body').append($('<div>', {class: 'bigCover'}));
		$('.bigCover').append($('<div>', {class: 'popUpSection'}));
		$('.popUpSection').append($('<div>', {class: 'logoPhasionateLogIn'}));
		$('.logoPhasionateLogIn').text('BOGADIA');
		$('#text-57').appendTo('.popUpSection');
		$('.popUpSection').append($('<div>', {class: 'getBackLinkContainer'}));
		$('.getBackLinkContainer').append($('<div>', {class: 'getBackLink'}));
		$('.getBackLink').click(function () { closePopUpRegister(); });
		$('.getBackLink').text('Cerrar');

		$('.bigCover').css('display','inline-block');
		$('.popUpSection').css('margin-top',($(window).height()-$('.popUpSection').height())/2);
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
		//$('#footer-sidebar-4').append($('<div>').attr('id','text-41').append($('.um-login')));
		$('.menu_acceso').bind('click', false);
		$('.menu_acceso').click(function () { showPopUpLogin(); return false;});
		if($('.um-login .um-field-error').length>0){
			showPopUpLogin();
		}
	}
	function showPopUpLogin(){
		$('#text-41').css('display','block');
		$('body').append($('<div>', {class: 'bigCover'}));
		$('.bigCover').append($('<div>', {class: 'popUpSection'}));
		$('.popUpSection').append($('<div>', {class: 'logoPhasionateLogIn'}));
		$('.logoPhasionateLogIn').text('BOGADIA');
		$('#text-41').appendTo('.popUpSection');
		$('#text-41').append($('<div>', {class: 'registerLink'}).text('¿Aun no tienes cuenta?').append($('<span>').text(' Registrate')));
		$('.registerLink').click(function () { closePopUpLogin(); showPopUpRegister(); });
		$('.popUpSection').append($('<div>', {class: 'getBackLinkContainer'}));
		$('.getBackLinkContainer').append($('<div>', {class: 'getBackLink'}));
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
		$('.registerLink').remove();
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
