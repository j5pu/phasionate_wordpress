
// EDIT BELOW THIS LINE FOR CUSTOM EFFECTS, TWEAKS AND INITS

/*--------------------------------------------------

Custom overwiev:

Page scripts
Header scripts
Isotope scripts
---------------------------------------------------*/

(function($){
	
"use strict";

/***************************************************
 Site functions
***************************************************/
var kleoPage = {
	
	init: function() {
			
		//remove overflow hidden
		kleoPage.removeOverflowHidden();
		
		//image sliders
		kleoPage.carouselItems();
		kleoPage.bannerSlider();
		kleoPage.rtMediaslider();

		//activate prettyPhoto
		kleoPage.magnificPopup();

		//activate html5 video/audio player
		if($.fn.kleo_enable_media && $.fn.mediaelementplayer) {
			$(".kleo-video, .kleo-audio, .video-wrap video", "body").kleo_enable_media();
		}
	
		//initialize Pins
		kleoPage.initPins();
		
		if(kleoFramework.goTop == 1) {
			kleoPage.goTop();
		}

		kleoPage.likes();
        kleoPage.progressBar();
        kleoPage.kleoAjaxLogin();
        kleoPage.kleoAjaxLostPass();
		
		//Fit videos
		$(".post-content, .activity-inner, .article-media, article, .kleo-video-embed, .wpb_video_widget").fitVids();

		// Sidebar menu toggle
		if (!isMobile || kleoIsotope.viewport().width > 992) {
			kleoPage.kleoMenuWidget();
		}

		//Accordion/toggle icons
		$('.panel-collapse').on('show.bs.collapse', function () {
			$(".panel-heading a[href='#"+$(this).attr('id')+"'] span.icon-opened").removeClass("hide");
			$(".panel-heading a[href='#"+$(this).attr('id')+"'] span.icon-closed").addClass("hide");
			;
		})
		$('.panel-collapse').on('hide.bs.collapse', function () {
			$(".panel-heading a[href='#"+$(this).attr('id')+"'] span.icon-opened").addClass("hide");
			$(".panel-heading a[href='#"+$(this).attr('id')+"'] span.icon-closed").removeClass("hide");
		})
				
		//Tabs and accordions triggers
		$('a[data-toggle="tab"]').on('shown.bs.tab', function () {
			//carousels
			$('.kleo-carousel').trigger('updateSizes');

			//masonry
			kleoIsotope.init();
		});
		$('.panel-collapse').on('shown.bs.collapse', function () {
			//carousels
			$('.kleo-carousel').trigger('updateSizes');
			//masonry
			kleoIsotope.init();
		});
        //tours
        if ($('.wpb_tour').length) {
            $('.tour_next_slide').click(function() {
                var tabs = $(this).closest('.wpb_tour').find('li');
                var active = tabs.filter('.active');
                var next = active.next('li').length? active.next('li').find('a') : tabs.filter(':first-child').find('a');
                next.tab('show');
                return false;
            });
            $('.tour_prev_slide').click(function() {
                var tabs = $(this).closest('.wpb_tour').find('li');
                var active = tabs.filter('.active');
                var prev = active.prev('li').length? active.prev('li').find('a') : tabs.filter(':last-child').find('a');
                prev.tab('show');
                return false;
            });

            $('.wpb_tour').each(function() {
                var $this = $(this);
                var tourChange = function() {
                    var tabs = $this.find('li');
                    var active = tabs.filter('.active');
                    var next = active.next('li').length? active.next('li').find('a') : tabs.filter(':first-child').find('a');
                    next.tab('show');
                }
                if ($this.data("interval") != 0) {
                    var interval = $this.data("interval");
                    var tabCycle = setInterval( tourChange, interval * 1000 )

                    $(this).find('li').hover(function(){
                        clearInterval(tabCycle);
                    });
                }
            });
        }


		// Popover profile
		$('.click-pop').popover({
			trigger: "click"
		}).on('click',  function(e) {e.preventDefault; return false;});
	
		$('.hover-pop').popover({
			trigger: "hover focus",
			html: true
		});
		
		// Tooltip
		$('.hover-tip').tooltip({
			trigger: "hover",
            container: "body"
		});
		$('.click-tip').tooltip({
			trigger: "click",
            container: "body"
		});

        /* submit form using an anchor element */
        $("a.form-submit").on("click", function() {
            $(this).closest("form").submit();
            return false;
        });

        /* Portfolio */
        if (($(".porto-video").length || $(".porto-hosted_video").length) && ($(".porto-thumb").length || $(".porto-slider").length)) {
            $(".portfolio-items").imagesLoaded(function() {
                kleoPage.portfolioVideo();
            });
            $window.on("debouncedresize", kleoPage.portfolioVideo);
        }
        if ($(".porto-video").length) {
            $('iframe').each(function() {
                var video = $(this);
                var vidSrc = "";
                vidSrc = video.attr('src');
                if(vidSrc.indexOf("//www.youtube.com/embed/") > -1){
                    video.attr('src', vidSrc + '&autohide=1');
                }
                if(vidSrc.indexOf("//player.vimeo.com/") > -1) {
                    if(vidSrc.indexOf("?") > -1) {
                        video.attr('src', vidSrc + '&title=0&byline=0&portrait=0');
                    } else {
                        video.attr('src', vidSrc + '?title=0&byline=0&portrait=0');
                    }

                }

            });
        }
	},

    portfolioVideo: function() {
        $(".porto-video .kleo-video-embed, .porto-hosted_video .mejs-inner").height( function() {
            var image = $(this).closest(".portfolio-items").find('.portfolio-image img, .kleo-banner-slider img').eq(0);
            return image.length && image.height() > 0 ? image.height() : "auto";
        } );
    },
	
	notReadyInit: function() {
		//Preload logo
		$("#logo_img").imgpreload();
		
		$('.responsive-tabs, .nav-pills, .top-menu > ul, #top-social > ul').tabdrop();
		
	},
	
	// Sidebar menu toggle
	kleoMenuWidget: function() {
			var submenuParent = jQuery(".widget_nav_menu ul.sub-menu").parent('li');
			submenuParent.addClass('parent');
			submenuParent.children("a").append('<span class="caret"></span>');
			submenuParent.find(".caret").click( function() {
				jQuery(this).closest(".parent").children('.sub-menu').stop(true,true).slideToggle('fast');
				jQuery(this).toggleClass('active');
				return false;
			});
		},
	
	adjustHeights: function(elem) {
      var fontstep = 2;
      if ($(elem).height()>$(elem).parent().height() || $(elem).width()>$(elem).parent().width()) {
        $(elem).css('font-size',(($(elem).css('font-size').substr(0,2)-fontstep)) + 'px').css('line-height',(($(elem).css('font-size').substr(0,2))) + 'px');
        adjustHeights(elem);
      }
    },
	
	removeOverflowHidden: function() {
		
		$('body').on('click', function() {
			if ($('#buddypress .tabdrop').hasClass('open'))
			{
				$('#buddypress div#item-nav').css('overflow','hidden');
			}
		});
		
		$('.item-list-tabs .dropdown-toggle').on('click', function() {
			if ($('#buddypress .tabdrop').hasClass('open'))
			{
				$('#buddypress div#item-nav').css('overflow','hidden');
			}
			else {
				$('#buddypress div#item-nav').css('overflow','visible');
			}
		});
		
	},
	
	bannerSlider: function() {
		
		$('.kleo-banner-slider').animate({"opacity": "1"}, 700);
		
		$('.kleo-banner-slider').each(function() {
			var thisSliderItems = $(this).find('.kleo-banner-items');
			var $prev = $(this).find(".kleo-banner-prev");
			var $next = $(this).find(".kleo-banner-next");
			
			thisSliderItems.imagesLoaded(function() {
				thisSliderItems.carouFredSel({
						//auto: false,
						responsive: true,
						circular: false,
						infinite: true,
						auto: {
							play : true,
							pauseDuration: 0,
							duration: 2000
						},
						scroll: {
							items: 1,
							duration: 600,
							//fx: "crossfade",
							easing: "easeInOutExpo",
							wipe: true
						},
						//padding: 0,
						prev: $prev,
						next: $next,
						items: {
							height : 'variable',
							visible: 1
						}
				});
			});
		});

	},
	
	carouselItems: function() {
		
		$('.kleo-carousel-items').each(function() {
			// Load Carousel options into variables
			var $currentCrslPrnt = $(this);
			var $currentCrsl = $currentCrslPrnt.children('.kleo-carousel');
			var $prev = $currentCrslPrnt.closest('.kleo-carousel-container').find(".carousel-arrow .carousel-prev");
			var $next = $currentCrslPrnt.closest('.kleo-carousel-container').find(".carousel-arrow .carousel-next");
			var $pagination = $currentCrslPrnt.closest('.kleo-carousel-container').find(".kleo-carousel-pager");

			var $visible,
			$items_height = 'auto',
			$items_width = null,
			$auto_play = false,
			$auto_pauseOnHover = 'resume',
			$scroll_fx = 'scroll',
			$duration = 2000;

			if ($currentCrslPrnt.data("pager")) {
				$pagination = $currentCrslPrnt.closest('.kleo-carousel-container').find($currentCrslPrnt.data("pager"));
			}
			if ($currentCrslPrnt.data("autoplay")) {
				$auto_play = true;
			}
			if ($currentCrslPrnt.data("speed") ) {
				$duration = parseInt($currentCrslPrnt.data("speed"));
			}
			if ($currentCrslPrnt.data("items-height") ) {
				$items_height = $currentCrslPrnt.data("items-height");
			}
			if ($currentCrslPrnt.data("items-width") ) {
				$items_width = $currentCrslPrnt.data("items-width");
			}
			if ($currentCrslPrnt.data("scroll-fx") ) {
				$scroll_fx = $currentCrslPrnt.data("scroll-fx");
			}
			
			if ($currentCrslPrnt.data("min-items") && $currentCrslPrnt.data("max-items")) {
				$visible = {
						min: $currentCrslPrnt.data("min-items"),
						max: $currentCrslPrnt.data("max-items")
					};
			}

			// Apply common carousel options
			$currentCrsl.imagesLoaded( function() {
				$currentCrsl.carouFredSel({
						responsive: true,
						width: '100%',
						pagination: $pagination,
						prev: $prev,
						next: $next,
						auto: {
							play : $auto_play,
							pauseOnHover: $auto_pauseOnHover
						},
						swipe: {
							onTouch: true
						},
						scroll: {
							items: 1,
							duration: 600,
							fx: $scroll_fx,
							easing: "swing",
							timeoutDuration: $duration,
                            wipe: true
						},
						items: {
							width: $items_width,
							height: $items_height,
							visible: $visible
						}
				}).visible();
			});
		});

		if($(".kleo-thumbs-carousel").length) {
			$(".kleo-thumbs-carousel").each(function() {
				var $thumbsCarousel = $(this), 
						$thumbsVisible = 6,
						$circular = false;

				if ($thumbsCarousel.data("min-items") && $thumbsCarousel.data("max-items")) {
					$thumbsVisible = {
						min: $thumbsCarousel.data("min-items"),
						max: $thumbsCarousel.data("max-items")
					};
				}
				if ($thumbsCarousel.data("circular")) {
					$circular = true;
				}
				
				$thumbsCarousel.imagesLoaded( function() {
					$thumbsCarousel.carouFredSel({
						responsive: true,
						circular: $circular,
						infinite: true,
						auto: false,
						prev: {
							button : function(){
								return $(this).parents('.kleo-gallery').find('.kleo-thumbs-prev');
							}
						},
						next:{
							button : function(){
								return $(this).parents('.kleo-gallery').find('.kleo-thumbs-next');
							}
						},
						swipe: {
							onMouse: true,
							onTouch: true
						},
						scroll: {
							items: 1
						},
						items: {
							height: 'auto',
							visible: $thumbsVisible,
						}
					});
				});
				
			});
		}

		$('.kleo-thumbs-carousel a').click(function() {
			$(this).closest('.kleo-gallery-container').find('.kleo-gallery-image').trigger('slideTo', '#' + this.href.split('#').pop() );
			$('.kleo-thumbs-carousel a').removeClass('selected');
			$(this).addClass('selected');
			return false;
		});

		if($(".kleo-gallery-image").length) {
			$('.kleo-gallery-image').carouFredSel({
					responsive: true,
					circular: false,
					auto: false,
					items: {
					height: 'variable',
					visible: 1
					},
					scroll: {
						items: 1,
						fx: 'crossfade'
					}
			});
		}
		
	},

	rtMediaslider: function() {
		
		$(".rtmedia-activity-container").append('<div class="activity-feed-prev">&nbsp;</div><div class="activity-feed-next">&nbsp;</div>');
		//jQuery('.rtmedia-activity-container').animate({"opacity": "1"}, 700);
		$('.rtmedia-activity-container').each(function() {
			var $prev = $(this).find(".activity-feed-prev");
			var $next = $(this).find(".activity-feed-next");
			var thisSliderItems = $(this).find('.large-block-grid-3');
			
			thisSliderItems.imagesLoaded( function() {
				thisSliderItems.carouFredSel({
						//auto: false,
						responsive: true,
						circular: false,
						auto: {
							play : true,
							pauseDuration: 0,
							duration: 2000
						},
						scroll: {
							items: 1,
							duration: 600,
							//fx: "crossfade",
							easing: "easeInOutExpo",
							wipe: true
						},
						swipe: {
							onTouch: true
						},
						//padding: 0,
						prev: $prev,
						next: $next,
						items: {
							height : 'auto',
							visible: {
										min: 1,
										max: 4
								}
						}
				});
			});
		});

	},
	
	initPins: function() {
		
		$( ".kleo-pin-circle, .kleo-pin-poi, .kleo-pin-icon" ).each(function() {
			var $length = "";

			if ($(this).is('[data-top]')) {
				$( this ).css({ "top": $(this).attr('data-top')+$length});
			}
			if ($(this).is('[data-left]')) {
				$( this ).css({ "left": $(this).attr('data-left')+$length});
			}
			if ($(this).is('[data-right]')) {
				$( this ).css({ "right": $(this).attr('data-right')+$length});
			}
			if ($(this).is('[data-bottom]')) {
				$( this ).css({ "bottom": $(this).attr('data-bottom')+$length});
			}

		});
		
	},
	
	/***************************************************
	 Go To Top Link
	***************************************************/
	goTop: function() {
		$(window).scroll(function () {
			if ($(this).scrollTop() > 500) {
					$('.kleo-go-top, .kleo-quick-contact-wrapper').removeClass('off').addClass('on');
			}
			else {
					$('.kleo-go-top, .kleo-quick-contact-wrapper').removeClass('on').addClass('off');
			}
		});

		$('.kleo-go-top, .divider-go-top').click(function () {
				$("html, body").animate({
						scrollTop: 1
				}, 800);
				return false;
		});

		$('.kleo-classic-comments').click(function () {
				$("html, body").animate({
						scrollTop: $('#comments').offset().top
				}, 800);

		});
	 },
	
	/***************************************************
		PrettyPhoto - Replace 'data-rel' with 'rel'
		'rel' attribute it's not a valid tag anymore
	***************************************************/
	prettyPhoto: function() {
		
		$('a[data-rel]').each(function() {
				$(this).attr('rel', $(this).data('rel'));
		});

		//PrettyPhoto settings
		$("a[rel^='prettyPhoto']").prettyPhoto({
				animation_speed: 'fast', /* fast/slow/normal */
				slideshow: false, /* false OR interval time in ms */
				autoplay_slideshow: false, /* true/false */
				opacity: 0.80, /* Value between 0 and 1 */
				show_title: true, /* true/false */
				allow_resize: true, /* Resize the photos bigger than viewport. true/false */
				default_width: 500,
				default_height: 344,
				counter_separator_label: '/', /* The separator for the gallery counter 1 "of" 2 */
				theme: 'pp_default', /* light_rounded / dark_rounded / light_square / dark_square / facebook */
				hideflash: false, /* Hides all the flash object on a page, set to TRUE if flash appears over prettyPhoto */
				wmode: 'opaque', /* Set the flash wmode attribute */
				autoplay: true, /* Automatically start videos: True/False */
				modal: false, /* If set to true, only the close button will close the window */
				overlay_gallery: false, /* If set to true, a gallery will overlay the fullscreen image on mouse over */
				keyboard_shortcuts: true, /* Set to false if you open forms inside prettyPhoto */
				deeplinking: false,
				social_tools: false
		});
		
	},

	magnificPopup: function() {

        /* Login modal */
        $('.kleo-show-login, .bp-menu.bp-login-nav a, .must-log-in > a').magnificPopup({
          items: {
            src: '#kleo-login-modal',
            type: 'inline',
            focus: '#username'
          },
          preloader: false,
          mainClass: 'kleo-mfp-zoom',

          // When elemened is focused, some mobile browsers in some cases zoom in
          // It looks not nice, so we disable it:
          callbacks: {
            beforeOpen: function() {
              if($(window).width() < 700) {
                this.st.focus = false;
              } else {
                this.st.focus = '#username';
              }
            }
          }
        });

        /* Lost Pass modal */
        $('.kleo-show-lostpass').magnificPopup({
          items: {
            src: '#kleo-lostpass-modal',
            type: 'inline',
            focus: '#username'
          },
          preloader: false,
          mainClass: 'kleo-mfp-zoom',

          // When elemened is focused, some mobile browsers in some cases zoom in
          // It looks not nice, so we disable it:
          callbacks: {
            beforeOpen: function() {
              if($(window).width() < 700) {
                this.st.focus = false;
              } else {
                this.st.focus = '#forgot-email';
              }
            }
          }
        });

		/* Regular popup images */
		$("a[data-rel^='prettyPhoto'], a[rel^='prettyPhoto'], .article-content a[href$=jpg]:has(img), .article-content a[href$=JPG]:has(img), .article-content a[href$=jpeg]:has(img), .article-content a[href$=JPEG]:has(img), .article-content a[href$=gif]:has(img), .article-content a[href$=bmp]:has(img), .article-content a[href$=png]:has(img)").magnificPopup({
			type: 'image',
			mainClass: 'mfp-img-pop',
			gallery:{
				enabled: true
			}
		});

		/* WordPress Gallery */
		$(".gallery a[href$=jpg], .gallery a[href$=JPG], .gallery a[href$=jpeg], .gallery a[href$=JPEG], .gallery a[href$=png], .gallery a[href$=gif], .gallery a[href$=bmp] :has(img)").parent().magnificPopup({
			delegate: 'a',
			type: 'image',
			mainClass: 'mfp-gallery-pop',
			navigateByImgClick: true,
			gallery: {
				enabled: true,
				navigateByImgClick: true,
				preload: [0,1]
			}
		});
	},
	
	likes: function() {
		$('.item-likes').live('click',
			function() {
				var link = $(this);
				if(link.hasClass('liked')) return false;

				var id = $(this).attr('id'),
					postfix = link.find('.item-likes-postfix').text();

				$.post(kleoFramework.ajaxurl, { action:'item-likes', likes_id:id, postfix:postfix }, function(data){
					link.html(data).addClass('liked').attr('title',kleoFramework.alreadyLiked);
				});

				return false;
			});

			if( $('body.ajax-item-likes').length ) {
				$('.item-likes').each(function(){
				var id = $(this).attr('id');
				$(this).load(kleoFramework.ajaxurl, { action:'item-likes', post_id:id });
			});
		}
	},
	getURLParameters: function(url) {

    var result = {};
    var searchIndex = url.indexOf("?");
    if (searchIndex == -1 ) return result;
    var sPageURL = url.substring(searchIndex +1);
    var sURLVariables = sPageURL.split('&');
    for (var i = 0; i < sURLVariables.length; i++)
    {
      var sParameterName = sURLVariables[i].split('=');
      result[sParameterName[0]] = sParameterName[1];
    }
    return result;
	},
  
  /* Progress bar */
  progressBar: function() {

    if (typeof jQuery.fn.waypoint !== 'undefined') {
      $('.vc_progress_bar').waypoint(function () {
        $(this).find('.vc_single_bar').each(function (index) {
          var $this = $(this),
            bar = $this.find('.vc_bar'),
            val = bar.data('percentage-value');

          setTimeout(function () {
            bar.css({"width":val + '%'});
          }, index * 200);
        });
      }, { offset:'85%' });
    }
  },
  kleoAjaxLogin: function() {
    $('form#login_form').on('submit', function(e){
      $('#kleo-login-result').show().html(kleoFramework.loadingmessage);
      $.ajax({
        type: 'POST',
        dataType: 'json',
        url: kleoFramework.ajaxurl,
        data: {
          action: 'kleoajaxlogin',
          log: $('form#login_form #username').val(), 
          pwd: $('form#login_form #password').val(),
          remember: ($('form#login_form #rememberme').is(':checked') ? true : false),
          security: $('form#login_form #security').val() 
        },
        success: function(data){
          $('#kleo-login-result').html(data.message);
          if (data.loggedin == true) {
            if (data.redirecturl == null) {
              document.location.reload();
            }
            else {
              document.location.href = data.redirecturl;
            }
          }
        },
        complete: function() {

        },
        error: function() {
          $('form#login_form', '#login_panel').off('submit');
          $("#login_form").submit();
        }			
      });
      e.preventDefault();
    });
  },

  kleoAjaxLostPass: function() {
    $("#forgot_form").on("submit",function(){
      $('#kleo-lost-result').show().html(kleoFramework.loadingmessage);
      $.ajax({
        url: kleoFramework.ajaxurl,
        type: 'POST',
        data: {
          action: 'kleo_lost_password',
          email: $("#forgot-email").val(),
        },
        success: function(data){
          $('#kleo-lost-result').html(data);
        },
        error: function() {
          $('#kleo-lost-result').html('Sorry, an error occurred.').css('color', 'red');
        }

      });
      return false;
    });  
  }  
  

};


/***************************************************
 Buddypress
***************************************************/
var bP = {
	rehreshID: null,
  
	init: function() {
		//$("#buddypress div#item-nav .responsive-tabs").css('visibility', 'visible');
		$("#buddypress div#item-nav").css('background-image', 'none');

		//Enable masonry isotope
		$("body").on('gridloaded', function() {
			kleoIsotope.applyGridIsotpe(".kleo-isotope");
			$('.animate-when-almost-visible').kleo_waypoints({ offset: '90%'});
		});
		
		//Activity on change events
		$("body").on('bpActivityLoaded', function() {
			//Init animation
			$('.animate-when-almost-visible').kleo_waypoints({ offset: '90%'});
			
			//Init slider
			kleoPage.rtMediaslider();

			//Init fitVids
			$(".activity-inner").fitVids();
		});
    if (typeof(rtMediaHook) != "undefined") {
      rtMediaHook.register( 'rtmedia_after_gallery_load', function() {
        $('.el-zero-fade').kleo_waypoints({ offset: '90%'});
      });
    }
    
    if ($(".kleo-notifications-nav").length) {
      $(".navbar").on("click", ".kleo-notifications-nav a.mark-as-read", function(e) {
        bP.notificationsRead($(this));
        e.preventDefault();
      });
      if (kleoFramework.bpNotificationsRefresh != '0') {
        bP.notificationsRefresh();
      }
    }
    
	},
  
  notificationsRefresh: function() {
    
    bP.rehreshID = setInterval(function() {
      
      var values = { 
        action: "kleo_bp_notifications_refresh",
        current: $(".kleo-notifications-nav .kleo-notifications").first().text()
      };
 
      $.ajax({
        url: kleoFramework.ajaxurl,
        type: "GET",
        dataType: "json",
        data: values,
        success: function(response)
        {
          if (response.status == 'success') {
            if(response.count == '0') {
                $('.kleo-notifications-nav .minicart-buttons').hide();
                $(".kleo-notifications-nav .kleo-notifications").removeClass("new-alert").addClass("no-alert");
                $(".kleo-notifications-nav .submenu-inner").removeClass("has-notif");
            } else {
                $(".kleo-notifications-nav").addClass("kleo-loading");
                $(".kleo-notifications-nav .kleo-notifications").removeClass("no-alert").addClass("new-alert");
                $(".kleo-notifications-nav .submenu-inner").addClass("has-notif");
                $('.kleo-notifications-nav .minicart-buttons').show();
            }
            
            $(".kleo-notifications-nav .kleo-notifications").text(response.count);
            $('.kleo-notifications-nav .submenu-inner').html(response.data);
          } else {
            //
          }

        },
        complete: function()
        {
          $(".kleo-notifications-nav").removeClass("kleo-loading");
        }
      });
 
    }, kleoFramework.bpNotificationsRefresh);
    
    
  },
  
  notificationsRead: function(e) {
    
    var values = { action: "kleo_bp_notification_mark_read" };

    $.ajax({
        url: kleoFramework.ajaxurl,
        type: "GET",
        dataType: "json",
        data: values,
        beforeSend: function()
        {
          $(".kleo-notifications-nav").addClass("kleo-loading");
        },
        success: function(response)
        {
          if (response.status == 'success') {
            if(response.count == '0') {
                $('.kleo-notifications-nav .submenu-inner').html(response.empty);
                $('.kleo-notifications-nav .minicart-buttons').hide();
                $(".kleo-notifications-nav .kleo-notifications").removeClass("new-alert").addClass("no-alert");
                $(".kleo-notifications-nav .submenu-inner").removeClass("has-notif");
            } else {
                $(".kleo-notifications-nav .kleo-notifications").removeClass("no-alert").addClass("new-alert");
                $(".kleo-notifications-nav .submenu-inner").addClass("has-notif");
                $('.kleo-notifications-nav .minicart-buttons').show();
            }
            $(".kleo-notifications-nav .kleo-notifications").text(response.count);
          } else {
            //
          }

        },
        complete: function()
        {
          $(".kleo-notifications-nav").removeClass("kleo-loading");
        }
    });
      
  
  }
	
}

/***************************************************
 Woocommerce
***************************************************/
var kleoShop = {
	
	wooGalItems: [],
	wooMainImg: $(".woocommerce-main-image"),
	
	init: function() {
		
		kleoShop.productQuickView();
		kleoShop.removeCartProduct();
		
		if ($(".kleo-woo-gallery a.zoom").length < 2) {
			$(".woo-main-image-nav").hide();
		}
		
		if ($(".kleo-woo-gallery a.zoom").length) {
			kleoShop.startMultiGallery();
			
			$(".kleo-woo-next").on('click', function(e) {
				
				e.preventDefault();
				$('.kleo-thumbs-carousel').trigger('next');
				
				if ($(".kleo-woo-gallery a.zoom.selected").nextAll("a.zoom:eq(0)").length ) {

					var nextElem = $(".kleo-woo-gallery a.zoom.selected").nextAll("a.zoom:eq(0)");
					kleoShop.setSelected(nextElem);

				}
			});

			$(".kleo-woo-prev").on('click', function(e) {

				e.preventDefault();
				$('.kleo-thumbs-carousel').trigger('prev');
				
				if ($(".kleo-woo-gallery a.zoom.selected").prevAll("a.zoom:eq(0)").length) {

					var prevElem = $(".kleo-woo-gallery a.zoom.selected").prevAll("a.zoom:eq(0)");
					kleoShop.setSelected(prevElem);

				}
			});
			
		} else {
			kleoShop.startSingleGallery();
		}
		
	},
	
	setSelected: function(element) {
		$(".woocommerce-main-image img").attr('src', element.attr('href')).parent("a").attr("href", element.attr('href'));
		$(".kleo-woo-gallery a.zoom").removeClass('selected');
		element.addClass('selected');
		kleoShop.updateGalleryItems(element);
	},
	
	startSingleGallery: function() {
		
		kleoShop.wooMainImg.magnificPopup({
			type: 'image',
      mainClass: 'kleo-mfp-zoom',
      removalDelay: 300,
      closeOnContentClick: true,
			image: {
				verticalFit: false
			}
		});
		
	},
	
	startMultiGallery: function() {
		
		//update images array
		kleoShop.updateGalleryItems($(".kleo-woo-gallery a.zoom.selected"));
		//disable click
		kleoShop.wooMainImg.on('click', function(e) {
			e.preventDefault();
		});
		
		//enable gallery lightbox
		kleoShop.wooMainImg.magnificPopup({
			items: kleoShop.wooGalItems,
			type: 'image',
      mainClass: 'kleo-mfp-zoom',
      removalDelay: 300,
      closeOnContentClick: true,
			gallery: {
				enabled: true
			},
			image: {
				verticalFit: false
			}
		});
		kleoShop.wooMainImg.on('mfpBeforeOpen', function() {
			$.magnificPopup.instance.items = kleoShop.wooGalItems;
			$.magnificPopup.instance.updateItemHTML();
		});
		
		$(".kleo-woo-gallery a.zoom").on('click', function(e) {
			e.preventDefault();
			kleoShop.setSelected($(this));
			
			return false;
		});
		
	},
	
	updateGalleryItems: function(elem) {
		
		kleoShop.wooGalItems = [{src: elem.attr('href')}];
		var tmp;
		$(".kleo-woo-gallery a.zoom:not(.selected)").each(function() {
			tmp = {
				src: $(this).attr('href')
			};
			kleoShop.wooGalItems.push(tmp);
		});
		
	},
	
	productQuickView: function() {
		$('.navbar, #main').on('click', '.quick-view', function(e) {
			
			var thiss = $(this);			
			var product_id = $(this).attr('data-prod');
			var data = { action: 'woo_quickview', product: product_id};
			
			$.ajax({
					url: kleoFramework.ajaxurl,
					type: "POST",
					data: data,
					beforeSend: function()
					{
						thiss.addClass('kleo-loading');
					},
					success: function(response)
					{
						
						$.magnificPopup.open({
							 mainClass: 'kleo-mfp-zoom',
							 items: {
								 src: '<div id="productModal" class="product-modal main-color">'+response+'</div>',
								 type: 'inline'
							 }
						 });
						
						setTimeout(function() {
							//init slider
							kleoPage.carouselItems();
							
							$('.product-modal form').wc_variation_form();
							$('.product-modal form select').change();

						}, 500);
						
					},
					complete: function()
					{
						thiss.removeClass('kleo-loading');
					}
			});
			
			e.preventDefault();
		}); // productQuickView	
	},
	
	removeCartProduct: function() {
		$(".navbar").on("click", ".kleo-minicart a.remove", function(e) {
			
			var thiss = $(this), 
			values = {action: "kleo_woo_rem_item"},
			queryParams = kleoPage.getURLParameters(thiss.attr('href'));
			
			$.extend( values, queryParams );
			//rename product param name
			var newVar = { kleo_item : values.remove_item };
			delete values.remove_item;
			$.extend( values, newVar );

			$.ajax({
					url: kleoFramework.ajaxurl,
					type: "GET",
					dataType: "json",
					data: values,
					beforeSend: function()
					{
						$(".shop-drop").addClass('kleo-loading');
					},
					success: function(response)
					{
						$(".kleo-toggle-menu.shop-drop .kleo-toggle-submenu").html(response.cart);
						$(".kleo-toggle-menu.shop-drop .cart-items > span, .mheader .cart-items > span").html(response.count);
						
						if (response.count == '') {
							$(".kleo-toggle-menu.shop-drop .cart-items").removeClass('has-products');
                            $(".kleo-toggle-menu.shop-drop .kleo-notifications").removeClass('new-alert');
                            $(".kleo-toggle-menu.shop-drop .kleo-notifications").addClass('no-alert');
						} else {
							$(".kleo-toggle-menu.shop-drop .cart-items").addClass('has-products');
                            $(".kleo-toggle-menu.shop-drop .kleo-notifications").addClass('new-alert');
                            $(".kleo-toggle-menu.shop-drop .kleo-notifications").removeClass('no-alert');
						}
						
						/* widget cart */
						if ($('.widget_shopping_cart_content').length && response.hasOwnProperty('widget')) {
							$('.widget_shopping_cart_content').replaceWith(response.widget)
						}
						
					},
					complete: function()
					{
                        $(".shop-drop").removeClass('kleo-loading');
					}
			});
			e.preventDefault();
		});
	}
	
};


/***************************************************
 Isotope
***************************************************/
var kleoIsotope = {
	
	container: '.kleo-isotope, .kleo-masonry',
	elContainer: $('.kleo-isotope, .kleo-masonry'),
	
	init: function() {

		if (kleoIsotope.elContainer.length > 0) {
			kleoIsotope.applyGridIsotpe(kleoIsotope.container);
		}
		
	},

	applyGridIsotpe: function(container, atts) {
		var $container = $(container);
		$container.each(function() {
			var $isoItem = $(this);
			var $isoAtts;
			if($isoItem.data('layout') == 'fitRows') {
				$isoAtts = { layoutMode : 'fitRows' };
			}
      
			atts = typeof atts !== 'undefined' ? true : false;
			if (atts == false) {
				$isoAtts = {};
			}

			$isoItem.imagesLoaded( function(){
				$isoItem.isotope($isoAtts);
			});

            $(window).on("debouncedresize", function() {
                // reinit isotope
                $isoItem.isotope($isoAtts);
            });

            /* filter items on button click */
            if ($isoItem.prev(".filter-wrap").length) {
                var filterButton = $isoItem.prev(".filter-wrap");
                filterButton.on( 'click', "a", function() {
                    var filterValue = $(this).data('filter');
                    $(this).closest('ul').find('li').removeClass('selected');
                    $(this).parent('li').addClass('selected');
                    $isoItem.isotope({ filter: filterValue });
                    return false;
                });
            }

		});

	},
	getWidth: function(item){
		var $isoWidth;

		if(kleoIsotope.viewport().width < 480) {
			$isoWidth = item.width() / 1;
			
		} else if(kleoIsotope.viewport().width < 768) {
			$isoWidth = item.width() / 2;
			
		} else if(kleoIsotope.viewport().width < 992) {
			$isoWidth = item.width() / 2;
			
		} else if(kleoIsotope.viewport().width < 1200) {
			if (item.closest(".template-page").hasClass('col-sm-12') ) {
				$isoWidth = item.width() / 3;
			} else {
				$isoWidth = item.width() / 2;
			}
					
		} else if(kleoIsotope.viewport().width < 1440) {
			if (item.closest(".template-page").hasClass('col-sm-12')) {

				$isoWidth = item.width() / 4;
		
			} else {
				$isoWidth = item.width() / 3;
			}
		} else {
			if (item.closest(".template-page").hasClass('col-sm-12')) {
				if (item.closest(".section-container").hasClass('container-full')) {
					$isoWidth = item.width() / 6;
				} else {
					$isoWidth = item.width() / 4;
				}
			} else {
				$isoWidth = item.width() / 3;
			}
		}
		return $isoWidth;
	},
	
	viewport: function() {
    var e = window, a = 'inner';
    if (!('innerWidth' in window )) {
        a = 'client';
        e = document.documentElement || document.body;
    }
    return { width : e[ a+'Width' ] , height : e[ a+'Height' ] };
	}	
	
};


/***************************************************
 Site Header
***************************************************/
var kleoHeader = {
	spacing: 0,
	initialPos:				($('.kleo-main-header').length && ! $("body").hasClass('navbar-transparent')) ? $('.kleo-main-header').offset().top : 0,
	initialSize:			($('.kleo-main-header #logo_img').length && $('.kleo-main-header #logo_img').height() > 10) ? $('.kleo-main-header #logo_img').height() : 88,
    header:				    $('.kleo-main-header'),
	logo:					$('.navbar-header .logo img, .navbar-header .logo a'),
	elements:				$('.navbar-header, .kleo-main-header .navbar-collapse > ul > li > a'),
	
	init: function() {
		
		if( kleoHeader.header.length ) {
			/* Activate logo resizing */
			if ($("body.kleo-navbar-fixed.navbar-resize").length) {
				kleoHeader.resizeLogo();
			} else {
                /* Set initial line height */
				kleoHeader.initialLineHeight();

                /* Apply background to non-resizing sticky menu when transparent */
                if ($("body.kleo-navbar-fixed.navbar-transparent").length) {
                    var st = $window.scrollTop();
                    if (st > 40) {
                        kleoHeader.header.addClass('header-scrolled');
                    } else {
                        kleoHeader.header.removeClass('header-scrolled');
                    }

                    $window.scroll(function() {
                        var st = $window.scrollTop();
                        if (st > 40) {
                            kleoHeader.header.addClass('header-scrolled');
                        } else {
                            kleoHeader.header.removeClass('header-scrolled');
                        }
                    });
                }
			}
		}
    
		//activate sticky main menu
		if (body.hasClass("kleo-navbar-fixed")) {
			kleoHeader.enable_sticky();
		}

		//activate retina logo
		kleoHeader.enableRetinaLogo();
		
		//activate social icons expand effect
		kleoHeader.topSocialExpander();
		
		//enable menu Ajax search button
		if($('.kleo_ajax_results').length) {
			kleoHeader.toggleAjaxSearch();
			kleoHeader.doAjaxSearch();
		}
		
		// Activate Hover menu
		if (kleoIsotope.viewport().width > 992) {
			$('#header .js-activated').dropdownHover().dropdown();
		}
		$('.js-activated').off('click');
		
		//Expand dropdown on caret click
		$('#header .caret').on('click', function() {
			var liItem = $(this).closest(".dropdown, .dropdown-submenu");
			if (liItem.hasClass("open")) {
				liItem.removeClass("open");
			} else {
				liItem.addClass("open");
			}
			return false;
		});
    
        kleoHeader.dropdownToggle();

        kleoHeader.scrollTo();
		
	},

    scrollTo: function() {
        $('a[href^="#"]').on('click', function(event) {
            var target = kleoHeader.getRelatedContent(this);

            var topHeight = 0;

            if ($("body").hasClass("kleo-navbar-fixed")) {
                topHeight += kleoHeader.initialSize;

                if ($("body").hasClass("navbar-resize")) {
                    topHeight = topHeight / 2 ;
                }
            }

            if ($("#wpadminbar").length) {
                topHeight += $("#wpadminbar").height();
            }

            if( target.length ) {
                event.preventDefault();
                $('html, body').animate({
                    scrollTop: target.offset().top - topHeight
                }, 1000);
            }
        });

        $('section')
            .waypoint(function(direction) {
                // Highlight element when related content
                // is 10% percent from the bottom...
                // remove if below
                kleoHeader.getRelatedNavigation(this).parents('li').toggleClass('active', direction === 'down');
            }, {
                offset: 150 //
            })
            .waypoint(function(direction) {
                // Highlight element when bottom of related content
                // is 100px from the top - remove if less
                kleoHeader.getRelatedNavigation(this).parents('li').toggleClass('active', direction === 'up');
            }, {
                offset: function() {  return -$(this).height() + 100; }
            });
    },
    /* Get section or article by href */
    getRelatedContent: function(el){
        return $($(el).attr('href'));
    },
    /* Get link by section or article id */
    getRelatedNavigation: function(el){
        return $('.kleo-main-header .nav > li a[href=#'+$(el).attr('id')+']');
    },


    initialLineHeight: function() {
		kleoHeader.elements.css({
			'lineHeight': kleoHeader.initialSize + 'px'
		});
        kleoHeader.logo.css({'maxHeight': kleoHeader.initialSize + 'px'})
	},

	/* Decreases header size when user scrolls down */
	resizeLogo: function() {
		
		var el_height = kleoHeader.elements.filter(':first').height(),

			set_height      = function()
			{
				if (kleoIsotope.viewport().width < 992) {
					kleoHeader.initialLineHeight();
					return;
				}
				kleoHeader.elements = $('.navbar-header, .kleo-main-header .navbar-collapse > ul > li > a');
				var st = $window.scrollTop(), newH = 0, minHeight = kleoHeader.initialSize /2;
				
				if(st > (kleoHeader.initialPos )) {
					
					if(st < (kleoHeader.initialPos + el_height/2))
					{
						newH = el_height - st + kleoHeader.initialPos;
						kleoHeader.header.removeClass('header-scrolled'); 
						$('.btn-buy').removeClass('btn-default');
					}
					else
					{ 
							newH = (el_height)/2;
							kleoHeader.header.addClass('header-scrolled');
							$('.btn-buy').addClass('btn-default');
					}
					if (newH < minHeight) { 
						newH = minHeight;
					}

					kleoHeader.elements.css({
						'lineHeight': newH + 'px'
					});
					kleoHeader.logo.css({'maxHeight': newH + 'px'});
					
				} else {
					
					newH = kleoHeader.initialSize;
					kleoHeader.logo.css({'maxHeight': newH + 'px'})
					
					kleoHeader.elements.css({
						'lineHeight': newH + 'px'
					});
					$('.btn-buy').removeClass('btn-default');
                    kleoHeader.header.removeClass('header-scrolled');

				}

			}

		$window.scroll(set_height);
        $(window).on("debouncedresize", set_height);
        set_height();
	},
	
	enable_sticky: function() {
	
		if ($('#wpadminbar').length > 0 && parseInt($window.width()) > 584) {
			kleoHeader.spacing = $('#wpadminbar').height();
		}
		$(".kleo-main-header").sticky({topSpacing:kleoHeader.spacing});
	},
	
	enableRetinaLogo: function() {
		if (window.devicePixelRatio > 1 && kleoFramework.retinaLogo != '') {
            var image = $("#logo_img"),
                imageName = kleoFramework.retinaLogo,
                imageHeight = 88;

            if (image.height() > 0) {
                imageHeight = image.height();
            }

            if ($(".sticky-wrapper").hasClass("is-sticky")) {
                imageHeight = imageHeight / 2;
            }

            //set image height
            //image.css({"max-height": imageHeight + "px"});

            //rename image
            image.attr('src', imageName);

            //add specific class
            image.closest('.logo').addClass('retina-logo');

		}
	},
	
	/* Top Social Bar -  Small slide effect for social icons  */
	topSocialExpander: function(){
		
		$("#top-social li a").hover(function() {
			if ( !$("#top-social .tabdrop").length || $("#top-social .tabdrop").hasClass("hide")) {
				var tsTextWidth = $(this).children('.ts-text').outerWidth() + 52;
				$(this).stop().animate({width: tsTextWidth}, 250, '');
			}
		}, function() {
			if ( $("#top-social .tabdrop").length || $("#top-social .tabdrop").hasClass("hide")) {
				$(this).stop().animate({width: 33}, 250, '');
			}
		});

	},
	
	toggleAjaxSearch: function() {
        $('.search-trigger').click(function() {
            if ($('#ajax_search_container').hasClass('searchHidden'))
            {
                $('#ajax_search_container').removeClass('searchHidden').addClass('show_search_pop');
                $(this).next().find(".ajax_s").focus();
            }
            return false;
        });
	},
	
	doAjaxSearch: function(options)
	{
        var defaults = {
            delay: 350,                //delay in ms for typing
            minChars: 3,               //no. of characters after we start the search
            scope: 'body'
        }

        this.options = $.extend({}, defaults, options);
        this.scope   = $(this.options.scope);
        this.body = $("body");
        this.timer   = false;
        this.doingSearch = false;
        this.lastVal = "";
        this.request = "";
        this.bind_ev = function() {
            this.scope.on('keyup', '.ajax_s' , $.proxy( this.test_search, this));
            this.body.on('mousedown', $.proxy( this.hide_search, this) );

            /* Show the results on input click */
            $(".ajax_s").on('click focus', function() {
                var res = $(this).closest(".kleo-search-form").find(".kleo_ajax_results");

                if ( ! res.is(":empty") && $.trim($(this).val()) != '' ) {
                    res.slideDown('slow');
                }
                res.css("opacity", "1");
                $(this).css("opacity", "1");
            } );

            /* Hide the results on outside click */
            this.body.on('mousedown', function(e) {
                var element = $(e.target);
                if(!element.is('.kleo_ajax_results, .ajax_s') && element.closest('.kleo_ajax_results').length == 0) {
                    $(".kleo-search-form .kleo_ajax_results").css("opacity", "0.5").slideUp('slow');
                    $(".kleo-search-form .ajax_s").css("opacity", "0.5");
                }
            } );

        };
        this.test_search = function(e) {
            clearTimeout(this.timer);
            if( $.trim(e.currentTarget.value) == '' || $.trim(e.currentTarget.value.length) >= this.options.minChars)
            {
                this.timer = setTimeout($.proxy( this.search, this, e), this.options.delay);
            }
        };
        this.hide_search = function(e) {
            var element = $(e.target);
            if(!element.is('#ajax_search_container') && element.parents('#ajax_search_container').length == 0) {
                $('#ajax_search_container').addClass('searchHidden').removeClass('show_search_pop');
            }
        };
        this.search = function(e) {
            var element = e.currentTarget;

            var $this = this,
                form        = $(element).closest("form"),
                wrap        = $(element).closest(".kleo-search-wrap"),
                results     = wrap.find(".kleo_ajax_results"),
                loading     = wrap.find(".kleo-ajax-search-loading"),
                values      = form.serialize();

            values += "&action=kleo_ajax_search";

            //if it is not ajax search, bail out
            if ( ! results.length ) {
                return;
            }

            //if it is another search in place
            if( $this.doingSearch === true ) {
                //return;
                this.request.abort();
            }

            //if current valuer matches last search value
            if( this.lastVal == $.trim(element.value) ) {
                results.slideDown();
                return;
            }

            //if current value is blank
            if ($.trim(element.value)  == '') {
                results.slideUp('fast');
                return;
            }


            this.lastVal = $.trim(element.value);

            this.request = $.ajax({
                url: kleoFramework.ajaxurl,
                type: "POST",
                data:values,
                beforeSend: function()
                {
                    loading.css('display', 'inline-block');
                    //results.slideUp();
                    $this.doingSearch = true;
                },
                success: function(response)
                {
                    if(response == 0) { response = ""; };
                    if(results.is(":empty")) {
                        results.hide().html(response).slideDown('slow');
                    } else {
                        results.html(response).slideDown('slow');
                    }
                },
                complete: function()
                {
                    /*$("#kleo_ajaxsearch").html(icon);*/
                    loading.css('display', 'none');
                    $this.doingSearch = false;
                    clearTimeout($this.timer);
                }
            });
        };

        //do search...
        this.bind_ev();
	},
  
	dropdownToggle: function() {
		
		$(".navbar").on("mouseenter", ".kleo-toggle-menu", function() {
			clearTimeout($(this).data('timeout'));
			$(this).find('.kleo-toggle-submenu').fadeIn(50);
			//$(this).addClass('active');
		});
		$(".navbar").on("mouseleave", ".kleo-toggle-menu", function() {
        var $this = $(this);
				var t = setTimeout(function() {
					$this.find('.kleo-toggle-submenu').fadeOut(50);
					//$(this).removeClass('active');
				}, 400);
				$(this).data('timeout', t);
		});
		
	}
	
	
};


/***************************************************
 Parallax
***************************************************/
var parallax = {
		init: function() {

            if($window.width() > 480) {

                $('.bg-parallax').each(function () {
                    // assigning the object
                    var $bgobj = $(this);

                    $window.scroll(function () {
                        // Scroll the background at var speed
                        // the yPos is a negative value because we're scrolling it UP!
                        var yPos = -(($window.scrollTop() - $bgobj.offset().top) / ($bgobj.data('prlx-speed') * 100 ) );

                        // Put together our final background position
                        var coords = '50% ' + yPos + 'px';

                        // Move the background
                        $bgobj.css({backgroundPosition: coords});
                    });
                    // window scroll Ends
                });

                parallax.changeSizes();
            }
		},
		
		changeSizes: function() {

            // Wait until the video meta data has loaded
            $('.bg-full-video video').on('loadedmetadata', function() {

                var adjSize, $width, $height, // Width and height of screen
                    $this = $(this),
                    $content = $this.closest(".bg-full-video").find(".section-container"),
                    $vidwidth = this.videoWidth, // Width of video (actual width)
                    $vidheight = this.videoHeight, // Height of video (actual height)
                    $aspectRatio = $vidwidth / $vidheight; // The ratio the video's height and width are in

                (adjSize = function() { // Create function called adjSize

                    var $width = $content.width(); // Width of the screen
                    var $height = $content.height(); // Height of the screen

                    var $boxRatio = $width / $height; // The ratio the screen is in

                    var $adjRatio = $aspectRatio / $boxRatio; // The ratio of the video divided by the screen size

                    if($boxRatio < $aspectRatio) { // If the screen ratio is less than the aspect ratio..
                        // Set the width of the video to the screen size multiplied by $adjRatio
                        $this.css({'width' : $width*$adjRatio+'px'});
                    } else {
                        // Else just set the video to the width of the screen/container
                        $this.css({'width' : $width+'px'});
                    }

                })(); // Run function immediately

                // Run function also on window resize.
                $window.on("debouncedresize", adjSize);

            });


		}
};


/***************************************************
 Quick Contact Form
***************************************************/
$(".kleo-quick-contact-wrapper").click(function (event) {
		if (event.stopPropagation) {
				event.stopPropagation();
		}
		else if (window.event) {
				window.event.cancelBubble = true;
		}
});
$("html").click(function () {
		$(this).find("#kleo-quick-contact").fadeOut(300);
		$('.kleo-quick-contact-link').removeClass('quick-contact-active');
});

$('.kleo-quick-contact-link').on('click', function () {
	if(!$(this).hasClass('quick-contact-active')) {
			$('#kleo-quick-contact').fadeIn(300);
			$(this).addClass('quick-contact-active');
	} else {
			 $('#kleo-quick-contact').fadeOut(300);
			 $(this).removeClass('quick-contact-active');
	}
	return false;
});

$('.kleo-contact-form').submit(ajaxSubmit);
function ajaxSubmit()
{
	var thiss = $(this);
	var customerForm = thiss.serialize();
	thiss.find(".kleo-contact-success").html('');
	thiss.find(".kleo-contact-loading").show();

	$.ajax({
		type:"POST",
		url: kleoFramework.ajaxurl,
		data: customerForm,
		success:function(data){
			thiss.find(".kleo-contact-loading").hide();
			thiss.find(".kleo-contact-success").html(data);
		},
		error: function(errorThrown){
			alert(errorThrown);
		}
	});
 return false;

}


$.fn.kleo_enable_media = function(options) {
	var defaults = {};
	var options = $.extend(defaults, options);

	return this.each(function() {
		var el				= $(this);

		el.mediaelementplayer({
	    // if the <video width> is not specified, this is the default
			defaultVideoWidth: 480,
			// if the <video height> is not specified, this is the default
			defaultVideoHeight: 270,
			// if set, overrides <video width>
			videoWidth: -1,
			// if set, overrides <video height>
			videoHeight: -1,
			// width of audio player
			audioWidth: "100%",
			// height of audio player
			audioHeight: 30,
			// initial volume when the player starts
			startVolume: 0.8,
			// useful for <audio> player loops
			loop: false,
			// enables Flash and Silverlight to resize to content size
			enableAutosize: true,
			// the order of controls you want on the control bar (and other plugins below)
			features: ['playpause','progress','duration','volume','fullscreen'],
			// Hide controls when playing and mouse is not over the video
			alwaysShowControls: false,
			// force iPad's native controls
			iPadUseNativeControls: false,
			// force iPhone's native controls
			iPhoneUseNativeControls: false,
			// force Android's native controls
			AndroidUseNativeControls: false,
			// forces the hour marker (##:00:00)
			alwaysShowHours: false,
			// show framecount in timecode (##:00:00:00)
			showTimecodeFrameCount: false,
			// used when showTimecodeFrameCount is set to true
			framesPerSecond: 25,
			// turns keyboard support on and off for this instance
			enableKeyboard: true,
			// when this player starts, it will pause other players
			pauseOtherPlayers: true,
			// array of keyboard commands
			keyActions: [],
			/*mode: 'shim'*/
		});
	});
}

$.fn.visible = function() {
	return this.css('visibility', 'visible');
};

$.fn.invisible = function() {
	return this.css('visibility', 'hidden');
};

$.fn.visibilityToggle = function() {
	return this.css('visibility', function(i, visibility) {
			return (visibility == 'visible') ? 'hidden' : 'visible';
	});
};

	/***************************************************
	GLOBAL VARIABLES
	***************************************************/
	var $window = jQuery(window),
		body = jQuery('body'),
		deviceAgent = navigator.userAgent.toLowerCase(),
		isMobile = deviceAgent.match(/(iphone|ipod|ipad|android|iemobile)/);
	
	
	/***************************************************
	LOAD AND READY FUNCTION
	***************************************************/
	var onReady = {
		init: function(){
			kleoPage.init();
			kleoHeader.init();
			
			parallax.init();
		
			kleoIsotope.init();
			bP.init();
			kleoShop.init();

			activate_waypoints();
			activate_shortcode_scripts();
			
			
			/* Focus search Bp directory*/
			
			$( "#buddypress div#group-dir-search input[type=text], #buddypress div#members-dir-search input[type=text]" )
					.focusin(function() {
						$( this ).closest( "form" ).css( "min-width", "90%" );
					});
			$( "#buddypress div#group-dir-search input[type=text], #buddypress div#members-dir-search input[type=text]" )
				.focusout(function() {
					$( this ).closest( "form" ).css( "min-width", "60%" );
				});


		}
	};
	
	var onLoad = {
		init: function(){

		}
	};
	
	kleoPage.notReadyInit();
	jQuery(document).ready(onReady.init);
	jQuery(window).load(onLoad.init);
	
})( jQuery );
