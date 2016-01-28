/*
 * VenoBox - jQuery Plugin
 * version: 1.5.3
 * @requires jQuery
 *
 * Examples at http://lab.veno.it/venobox/
 * License: MIT License
 * License URI: https://github.com/nicolafranchini/VenoBox/blob/master/LICENSE
 * Copyright 2013-2015 Nicola Franchini - @nicolafranchini
 *
 */
(function ($) {

	var bgcolor, blocknum, blocktitle, border, core, container, content, dest,
		  evitacontent, evitanext, evitaprev, extraCss, figliall, framewidth, frameheight,
		  infinigall, items, keyNavigationDisabled, margine, numeratio, overlayColor, overlay,
		  prima, title, thisgall, thenext, theprev, type,
		  finH, sonH, nextok, prevok;

	$.fn.extend({
		//plugin name - venobox
		venobox: function (options) {

			// default option
			var defaults = {
				framewidth: '',
				frameheight: '',
				border: '0',
				bgcolor: '#fff',
				titleattr: 'title', // specific attribute to get a title (e.g. [data-title]) - thanx @mendezcode
				numeratio: false,
				infinigall: false,
				overlayclose: true, // disable overlay click-close - thanx @martybalandis
				onEnd: false // action
			};
                        

                        var regs = {
                            videoregs: {
                                swf: {
                                    reg: /[^\.]\.(swf)\s*$/i
                                },
                                youtu: {
                                    reg: /youtu\.be\//i,
                                    split: '/',
                                    index: 3,
                                    iframe: 1,
                                    url: 'http://www.youtube.com/embed/%id%?autoplay=1&amp;fs=1&amp;rel=0&amp;enablejsapi=1'
                                },
                                youtube: {
                                    reg: /youtube\.com\/watch/i,
                                    split: '=',
                                    index: 1,
                                    iframe: 1,
                                    url: 'http://www.youtube.com/embed/%id%?autoplay=1&amp;fs=1&amp;rel=0&amp;enablejsapi=1'
                                },
                                vimeo: {
                                    reg: /vimeo\.com/i,
                                    split: '/',
                                    index: 3,
                                    iframe: 1,
                                    url: 'http://player.vimeo.com/video/%id%?hd=1&amp;autoplay=1&amp;show_title=1&amp;show_byline=1&amp;show_portrait=0&amp;color=&amp;fullscreen=1'
                                },
                                metacafe: {
                                    reg: /metacafe\.com\/watch/i,
                                    split: '/',
                                    index: 4,
                                    url: 'http://www.metacafe.com/fplayer/%id%/.swf?playerVars=autoPlay=yes'
                                },
                                dailymotion: {
                                    reg: /dailymotion\.com\/video/i,
                                    split: '/',
                                    index: 4,
                                    iframe: true,
                                    url: 'http://www.dailymotion.com/embed/video/%id%?autoPlay=1&forcedQuality=hd720'
                                },
                                ustream: {
                                    reg: /ustream\.tv/i,
                                    split: '/',
                                    index: 4,
                                    url: 'http://www.ustream.tv/flash/video/%id%?loc=%2F&amp;autoplay=true&amp;vid=%id%&amp;disabledComment=true&amp;beginPercent=0.5331&amp;endPercent=0.6292&amp;locale=en_US'
                                },
                                twitvid: {
                                    reg: /twitvid\.com/i,
                                    split: '/',
                                    index: 3,
                                    url: 'http://www.twitvid.com/player/%id%'
                                },
                                wordpress: {
                                    reg: /v\.wordpress\.com/i,
                                    split: '/',
                                    index: 3,
                                    url: 'http://s0.videopress.com/player.swf?guid=%id%&amp;v=1.01'
                                }
                            },
                            imgsreg: /\.(?:jpg|png|jpeg|gif|bmp|tiff)/i
                        };
                        
                        function parseUrlType(href) {
                            var tmp = {
                                type: false,
                                href: ''
                            };
                            
                            if ( href.match(regs.imgsreg) )
                            {
                                tmp.type = 'image';
                                tmp.href = href;
                                return tmp;
                            }                            
                            
                            
                            jQuery.each(regs.videoregs, function (index, regEl)
                            {
                                console.log( href.match(regEl.reg)  );

                                if ( href.match(regEl.reg) )
                                {
                                    tmp.href = href;
                                    if (regEl.split)
                                    {
                                        var id = href.split(regEl.split) [regEl.index].split('?') [0].split('&') [0];
                                        tmp.href = regEl.url.replace('%id%', id);
                                    }
                                    tmp.type = 'iframe';
                                }
                                if ( tmp.type !== false ) {
                                    return false;
                                }
                            });
                            return tmp;
                        }
                        
                        /* -------- LOAD Smart (Image or Video) -------- */
                        function loadSmart (obj, dest) {
                                var target = parseUrlType(dest);
                                type = false;
                                if (target.type !== false)
                                {
                                    dest = target.href;
                                    type = target.type;
                                }

                                if ( type == 'image' ) {
                                        content.html('<img src="' + dest + '">');
                                        preloadFirst();
                                } else if ( type == 'iframe' || obj.data('type') == 'iframe') {
                                        loadIframe(dest);
                                } else if (obj.data('type') == 'inline') {
                                        loadInline();
                                } else if (obj.data('type') == 'ajax') {
                                        loadAjax();
                                } else if (obj.data('type') == 'vimeo') {
                                        loadVimeo();
                                } else if (obj.data('type') == 'youtube') {
                                        loadYoutube();
                                }            
                        }                         

			var option = $.extend(defaults, options);

			return this.each(function () {
				var obj = $(this);

				// Prevent double initialization - thanx @matthistuff
				if (obj.data('venobox')) {
					return true;
				}

				obj.addClass('vbox-item');
				obj.data('framewidth', option.framewidth);
				obj.data('frameheight', option.frameheight);
				obj.data('border', option.border);
				obj.data('bgcolor', option.bgcolor);
				obj.data('numeratio', option.numeratio);
				obj.data('infinigall', option.infinigall);
				obj.data('overlayclose', option.overlayclose);
				obj.data('venobox', true);

				obj.click(function (e) {
					e.stopPropagation();
					e.preventDefault();
					obj = $(this);
					overlayColor = obj.data('overlay');
					framewidth = obj.data('framewidth');
					frameheight = obj.data('frameheight');
					border = obj.data('border');
					bgcolor = obj.data('bgcolor');
					nextok = false;
					prevok = false;
					keyNavigationDisabled = false;
					dest = obj.attr('href');
					extraCss = obj.data('css') || "";

					$('body').addClass('vbox-open');
					core = '<div class="vbox-overlay ' + extraCss + '" style="background:' + overlayColor + '">' +
						  '<div class="vbox-preloader">Loading...</div><div class="vbox-container"><div class="vbox-content"></div></div>' +
						  '<div class="vbox-title"><span class="vbox-title-text"></span><span class="vbox-title-actions"></span></div>' +
						  '<div class="vbox-num">0/0</div>' +
						  '<div class="vbox-close">X</div><div class="vbox-next">next</div><div class="vbox-prev">prev</div></div>';

					$('body').append(core);

					overlay = $('.vbox-overlay');
					container = $('.vbox-container');
					content = $('.vbox-content');
					blocknum = $('.vbox-num');
					blocktitle = $('.vbox-title');

					content.html('');
					content.css('opacity', '0');

					checknav();
					actionButtonsOn();	//**MAX

					overlay.css('min-height', $(window).outerHeight());

					// fade in overlay
					overlay.animate({opacity: 1}, 250, function () {

                                            loadSmart(obj, dest);
                                                
					});

					/* -------- CHECK NEXT / PREV -------- */
					function checknav() {

						//thisgall = obj.data('gall');
						thisgall = obj.attr('rel');
						numeratio = obj.data('numeratio');
						infinigall = obj.data('infinigall');

						//items = $('.vbox-item[data-gall="' + thisgall + '"]');
						items = $('.vbox-item[rel="' + thisgall + '"]');

						if (items.length > 0 && numeratio === true) {
							blocknum.html(items.index(obj) + 1 + ' / ' + items.length);
							blocknum.show();
						} else {
							blocknum.hide();
						}

						thenext = items.eq(items.index(obj) + 1);
						theprev = items.eq(items.index(obj) - 1);

						if (obj.attr(option.titleattr)) {
							title = obj.attr(option.titleattr);
							blocktitle.show();
						} else {
							title = '';
							blocktitle.hide();
						}

						if (items.length > 0 && infinigall === true) {

							nextok = true;
							prevok = true;

							if (thenext.length < 1) {
								thenext = items.eq(0);
							}
							if (items.index(obj) < 1) {
								theprev = items.eq(items.index(items.length));
							}

						} else {

							if (thenext.length > 0) {
								$('.vbox-next').css('display', 'block');
								nextok = true;
							} else {
								$('.vbox-next').css('display', 'none');
								nextok = false;
							}
							if (items.index(obj) > 0) {
								$('.vbox-prev').css('display', 'block');
								prevok = true;
							} else {
								$('.vbox-prev').css('display', 'none');
								prevok = false;
							}
						}

						if (option.onEnd !== false) option.onEnd(obj);

					}

					function actionButtonsOn() {
						//$( '<button type="button" id="imagelightbox-actions" title="actions"></button>' ).
						if (jQuery('.vbox-title').length == 1) {

							jQuery('<span class="action-vote vbox-exclude" title="Vote"><i class="fvicon-heart3 vbox-exclude"></i></span>').
								  appendTo('.vbox-title .vbox-title-actions')
								  .on('click touchend', function () {
									  // Click to vote button
									  sv_vote(fv_current_id);
								  });

							jQuery('<span class="action-share vbox-exclude" title="Share"><i class="fvicon-share vbox-exclude"></i></span>').
								  appendTo('.vbox-title .vbox-title-actions')
								  .on('click touchend', function () {
									  // Open share dialog

								 	FvModal.goShare(fv_current_id);
									  //setTimeout(function () {}, 550);
								  });
						}
					}

					/* -------- NAVIGATION CODE -------- */
					var gallnav = {

						prev: function () {

							if (keyNavigationDisabled) {
								return;
							} else {
								keyNavigationDisabled = true;
							}

							overlayColor = theprev.data('overlay');

							framewidth = theprev.data('framewidth');
							frameheight = theprev.data('frameheight');
							border = theprev.data('border');
							bgcolor = theprev.data('bgcolor');

							dest = theprev.attr('href');

							if (theprev.attr(option.titleattr)) {
								title = theprev.attr(option.titleattr);
							} else {
								title = '';
							}

							if (overlayColor === undefined) {
								overlayColor = "";
							}

							content.animate({ opacity: 0}, 500, function () {

								overlay.css('background', overlayColor);

                                                                loadSmart(obj, dest);
                                                                
								obj = theprev;
								checknav();
								keyNavigationDisabled = false;
							});

						},

						next: function () {

							if (keyNavigationDisabled) {
								return;
							} else {
								keyNavigationDisabled = true;
							}

							overlayColor = thenext.data('overlay');

							framewidth = thenext.data('framewidth');
							frameheight = thenext.data('frameheight');
							border = thenext.data('border');
							bgcolor = thenext.data('bgcolor');
							dest = thenext.attr('href');

							if (thenext.attr(option.titleattr)) {
								title = thenext.attr(option.titleattr);
							} else {
								title = '';
							}

							if (overlayColor === undefined) {
								overlayColor = "";
							}

							content.animate({ opacity: 0}, 500, function () {

								overlay.css('background', overlayColor);

                                                                loadSmart(obj, dest);
                                                                
								obj = thenext;
								checknav();
								keyNavigationDisabled = false;
							});

						}                                               

					};
                                                                               

					/* -------- NAVIGATE WITH ARROW KEYS -------- */
					$('body').keydown(function (e) {

						if (e.keyCode == 37 && prevok == true) { // left
							gallnav.prev();
						}

						if (e.keyCode == 39 && nextok == true) { // right
							gallnav.next();
						}

					});

					/* -------- PREVGALL -------- */
					$('.vbox-prev').click(function () {
						gallnav.prev();
					});

					/* -------- NEXTGALL -------- */
					$('.vbox-next').click(function () {
						gallnav.next();
					});

					/* -------- ESCAPE HANDLER -------- */
					function escapeHandler(e) {
						if (e.keyCode === 27) {
							closeVbox();
						}
					}

					/* -------- CLOSE VBOX -------- */

					function closeVbox() {

						$('body').removeClass('vbox-open');
						$('body').unbind('keydown', escapeHandler);

						overlay.animate({opacity: 0}, 500, function () {
							overlay.remove();
							keyNavigationDisabled = false;
							obj.focus();
						});
					}

					/* -------- CLOSE CLICK -------- */
					var closeclickclass = '.vbox-close, .vbox-overlay';
					if (!obj.data('overlayclose')) {
						closeclickclass = '.vbox-close';    // close only on X
					}

					$(closeclickclass).click(function (e) {
						evitacontent = '.figlio';
						evitaprev = '.vbox-prev';
						evitanext = '.vbox-next';
						figliall = '.figlio *';
						var excludeEls = '.vbox-exclude';
						if (!$(e.target).is(excludeEls) && !$(e.target).is(evitacontent) && !$(e.target).is(evitanext) && !$(e.target).is(evitaprev) && !$(e.target).is(figliall)) {
							closeVbox();
						}
					});
					$('body').keydown(escapeHandler);
					return false;
				});
			});
		}
	});

	/* -------- LOAD AJAX -------- */
	function loadAjax() {
		$.ajax({
			url: dest,
			cache: false
		}).done(function (msg) {
			content.html('<div class="vbox-inline">' + msg + '</div>');
			updateoverlay(true);

		}).fail(function () {
			content.html('<div class="vbox-inline"><p>Error retrieving contents, please retry</div>');
			updateoverlay(true);
		})
	}


	/* -------- LOAD IFRAME -------- */
	function loadIframe(dest) {
		content.html('<iframe class="venoframe" src="' + dest + '"></iframe>');
		//  $('.venoframe').load(function(){ // valid only for iFrames in same domain
		updateoverlay();
		//  });
	}

	/* -------- LOAD VIMEO -------- */
	function loadVimeo() {
		var pezzi = dest.split('/');
		var videoid = pezzi[pezzi.length - 1];
		content.html('<iframe class="venoframe" src="//player.vimeo.com/video/' + videoid + '"></iframe>');
		updateoverlay();
	}

	/* -------- LOAD YOUTUBE -------- */
	function loadYoutube() {
		var pezzi = dest.split('/');
		var videoid = pezzi[pezzi.length - 1];
		content.html('<iframe class="venoframe" allowfullscreen src="//www.youtube.com/embed/' + videoid + '"></iframe>');
		updateoverlay();
	}

	/* -------- LOAD INLINE -------- */
	function loadInline() {
		content.html('<div class="vbox-inline">' + $(dest).html() + '</div>');
		updateoverlay();
	}

	/* -------- PRELOAD IMAGE -------- */
	function preloadFirst() {
		prima = $('.vbox-content').find('img');
		prima.one('load',function () {
			updateoverlay();
		}).each(function () {
			if (this.complete) $(this).load();
		});
	}

	/* -------- CENTER ON LOAD -------- */
	function updateoverlay() {

		blocktitle.find('.vbox-title-text').html(title);
		content.find(">:first-child").addClass('figlio');
		$('.figlio').css('width', framewidth).css('height', frameheight).css('padding', border).css('background', bgcolor);

		sonH = content.outerHeight();
		finH = $(window).height();

		if (sonH + 80 < finH) {
			margine = (finH - sonH) / 2;
			content.css('margin-top', margine);
			content.css('margin-bottom', margine);

		} else {
			content.css('margin-top', '40px');
			content.css('margin-bottom', '40px');
		}
		content.animate({
			'opacity': '1'
		}, 'slow');

	}

	/* -------- CENTER ON RESIZE -------- */
	function updateoverlayresize() {
		if ($('.vbox-content').length) {
			sonH = content.height();
			finH = $(window).height();

			if (sonH + 80 < finH) {
				margine = (finH - sonH) / 2;
				content.css('margin-top', margine);
				content.css('margin-bottom', margine);
			} else {
				content.css('margin-top', '40px');
				content.css('margin-bottom', '40px');
			}
		}
	}

	$(window).resize(function () {
		updateoverlayresize();
	});

})(jQuery);


jQuery(document).ready(function () {

	if (fv.no_lightbox) {
		FvLib.log('fv lightbox disabled');
		return;
	}

	var setupID = function (instance) {
		fv_current_id = jQuery(instance).data('id');
	};

	/* custom settings */
	jQuery('.fv_lightbox').venobox({
		//framewidth: '400px',        // default: ''
		//frameheight: '300px',       // default: ''
		//border: '10px',             // default: '0'
		//bgcolor: '#5dff5e',         // default: '#fff'
		titleattr: 'title',    // default: 'title'
		numeratio: true,            // default: false
		infinigall: true,            // default: false
		onEnd: setupID            // default: false
	});

});

/* ================= */
