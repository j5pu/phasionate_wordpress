
/*
	By Osvaldas Valutis, www.osvaldas.info
	Available for use under the MIT License
*/

;( function( $, window, document, undefined )
{
	'use strict';

	var cssTransitionSupport = function()
		{
			var s = document.body || document.documentElement, s = s.style;
			if( s.WebkitTransition == '' ) return '-webkit-';
			if( s.MozTransition == '' ) return '-moz-';
			if( s.OTransition == '' ) return '-o-';
			if( s.transition == '' ) return '';
			return false;
		},

		isCssTransitionSupport = cssTransitionSupport() === false ? false : true,

		cssTransitionTranslateX = function( element, positionX, speed )
		{
			var options = {}, prefix = cssTransitionSupport();
			options[ prefix + 'transform' ]	 = 'translateX(' + positionX + ')';
			options[ prefix + 'transition' ] = prefix + 'transform ' + speed + 's linear';
			element.css( options );
		},

		hasTouch	= ( 'ontouchstart' in window ),
		hasPointers = window.navigator.pointerEnabled || window.navigator.msPointerEnabled,
		wasTouched	= function( event )
		{
			if( hasTouch )
				return true;

			if( !hasPointers || typeof event === 'undefined' || typeof event.pointerType === 'undefined' )
				return false;

			if( typeof event.MSPOINTER_TYPE_MOUSE !== 'undefined' )
			{
				if( event.MSPOINTER_TYPE_MOUSE != event.pointerType )
					return true;
			}
			else
				if( event.pointerType != 'mouse' )
					return true;

			return false;
		};

	$.fn.imageLightbox = function( options )
	{
		var options	   = $.extend(
						 {
						 	selector:		'id="imagelightbox"',
						 	allowedTypes:	'png|jpg|jpeg|gif',
						 	animationSpeed:	250,
						 	preloadNext:	true,
						 	enableKeyboard:	true,
						 	quitOnEnd:		false,
						 	quitOnImgClick: false,
						 	quitOnDocClick: true,
						 	onStart:		false,
						 	onEnd:			false,
						 	onLoadStart:	false,
						 	onLoadEnd:		false
						 },
						 options ),

			targets		= $([]),
			target		= $(),
			image		= $(),
			imageWidth	= 0,
			imageHeight = 0,
			swipeDiff	= 0,
			inProgress	= false,

			isTargetValid = function( element )
			{
				return $( element ).prop( 'tagName' ).toLowerCase() == 'a' && ( new RegExp( '\.(' + options.allowedTypes + ')$', 'i' ) ).test( $( element ).attr( 'href' ) );
			},

			setImage = function()
			{


				if( !image.length ) return true;

				var tmpImage 	 = new Image();

				// Detect iOs and use Document, because Window return not correct value
				if ( /webOS|iPhone|iPad|iPod/i.test(navigator.userAgent) ) {
					var screenWidthFull	 = $( document ).width(),
						  screenWidth	 = screenWidthFull * 0.8,
						  screenHeightFull = $( window ).height(),
						  screenHeight = screenHeightFull * 0.9;
				} else {
					var screenWidthFull	 = $( window ).width(),
						  screenWidth	 = screenWidthFull * 0.8,   // * 0.8
						  screenHeightFull = $( window ).height(),
						  screenHeight = $( window ).height() * 0.8;    // * 0.8
				}


				/*if ( isIE() < 9 ) {
					setTimeout(function(){
						tmpImage.src	= image.attr( 'src' );
					},300);
				} else {

				}*/

				var onImageLoaded = function(tmpImage)
				{
					//tmpImage.onload = function()
					imageWidth	 = tmpImage.width;
					imageHeight	 = tmpImage.height;

					if( imageWidth > screenWidth || imageHeight > screenHeight )
					{
						var ratio	 = imageWidth / imageHeight > screenWidth / screenHeight ? imageWidth / screenWidth : imageHeight / screenHeight;
						imageWidth	/= ratio;
						imageHeight	/= ratio;
					}

					image.css(
						  {
							  'width':  imageWidth + 'px',
							  'height': imageHeight + 'px',
							  'top':    ( screenHeightFull - imageHeight ) / 2 + 'px',
							  'left':   ( screenWidthFull - imageWidth ) / 2 + 'px'
						  });
				}

				new imagesLoaded( tmpImage, onImageLoaded(tmpImage) );

				tmpImage.src	= image.attr( 'src' );
				//console.log( tmpImage.complete );
				if ( isIE() < 9  && tmpImage.complete) {
					onImageLoaded(tmpImage);
				}

			},

			isIE  = function () {
				var myNav = navigator.userAgent.toLowerCase();
				return (myNav.indexOf('msie') != -1) ? parseInt(myNav.split('msie')[1]) : false;
			},

			loadImage = function( direction )
			{
				if( inProgress ) return false;

				direction = typeof direction === 'undefined' ? false : direction == 'left' ? 1 : -1;

				if( image.length )
				{
					if( direction !== false && ( targets.length < 2 || ( options.quitOnEnd === true && ( ( direction === -1 && targets.index( target ) == 0 ) || ( direction === 1 && targets.index( target ) == targets.length - 1 ) ) ) ) )
					{
						quitLightbox();
						return false;
					}
					var params = { 'opacity': 0 };
					if( isCssTransitionSupport ) cssTransitionTranslateX( image, ( 100 * direction ) - swipeDiff + 'px', options.animationSpeed / 1000 );
					else params.left = parseInt( image.css( 'left' ) ) + 100 * direction + 'px';
					image.animate( params, options.animationSpeed, function(){ removeImage(); });
					swipeDiff = 0;
				}

				inProgress = true;
				if( options.onLoadStart !== false ) options.onLoadStart();

				setTimeout( function()
				{
					image = $( '<img ' + options.selector + ' />' )
					.attr( 'src', target.attr( 'href' ) )
					.load( function()
					{
						image.appendTo( 'body' );
						setImage();

						var params = { 'opacity': 1 };

						image.css( 'opacity', 0 );
						if( isCssTransitionSupport )
						{
							cssTransitionTranslateX( image, -100 * direction + 'px', 0 );
							setTimeout( function(){ cssTransitionTranslateX( image, 0 + 'px', options.animationSpeed / 1000 ) }, 50 );
						}
						else
						{
							var imagePosLeft = parseInt( image.css( 'left' ) );
							params.left = imagePosLeft + 'px';
							image.css( 'left', imagePosLeft - 100 * direction + 'px' );
						}
                        if ( !isIE() || ( isIE() < 9 && image[0].complete ) ) {
                            image.animate( params, options.animationSpeed, function()
                            {
                                inProgress = false;
                                if( options.onLoadEnd !== false ) options.onLoadEnd();
                            });
                        }
						if( options.preloadNext )
						{
							var nextTarget = targets.eq( targets.index( target ) + 1 );
							if( !nextTarget.length ) nextTarget = targets.eq( 0 );
							$( '<img />' ).attr( 'src', nextTarget.attr( 'href' ) ).load();
						}
					})
					.error( function()
					{
						if( options.onLoadEnd !== false ) options.onLoadEnd();
					});


					if ( isIE() != false && ( isIE() < 9 && image[0].complete ) ) {
                        console.log('isIE > image.load');
						image.load();
					}
					//console.log( image[0].complete );

					var swipeStart	 = 0,
						swipeEnd	 = 0,
						imagePosLeft = 0;

					image.on( hasPointers ? 'pointerup MSPointerUp' : 'click', function( e )
					{
						e.preventDefault();
						if( options.quitOnImgClick )
						{
							quitLightbox();
							return false;
						}
						if( wasTouched( e.originalEvent ) ) return true;
					    var posX = ( e.pageX || e.originalEvent.pageX ) - e.target.offsetLeft;
						target = targets.eq( targets.index( target ) - ( imageWidth / 2 > posX ? 1 : -1 ) );
						if( !target.length ) target = targets.eq( imageWidth / 2 > posX ? targets.length : 0 );
						loadImage( imageWidth / 2 > posX ? 'left' : 'right' );
					})
					.on( 'touchstart pointerdown MSPointerDown', function( e )
					{
						if( !wasTouched( e.originalEvent ) || options.quitOnImgClick ) return true;
						if( isCssTransitionSupport ) imagePosLeft = parseInt( image.css( 'left' ) );
						swipeStart = e.originalEvent.pageX || e.originalEvent.touches[ 0 ].pageX;
					})
					.on( 'touchmove pointermove MSPointerMove', function( e )
					{
						if( !wasTouched( e.originalEvent ) || options.quitOnImgClick ) return true;
						e.preventDefault();
						swipeEnd = e.originalEvent.pageX || e.originalEvent.touches[ 0 ].pageX;
						swipeDiff = swipeStart - swipeEnd;
						if( isCssTransitionSupport ) cssTransitionTranslateX( image, -swipeDiff + 'px', 0 );
						else image.css( 'left', imagePosLeft - swipeDiff + 'px' );
					})
					.on( 'touchend touchcancel pointerup pointercancel MSPointerUp MSPointerCancel', function( e )
					{
						if( !wasTouched( e.originalEvent ) || options.quitOnImgClick ) return true;
						if( Math.abs( swipeDiff ) > 50 )
						{
							target = targets.eq( targets.index( target ) - ( swipeDiff < 0 ? 1 : -1 ) );
							if( !target.length ) target = targets.eq( swipeDiff < 0 ? targets.length : 0 );
							loadImage( swipeDiff > 0 ? 'right' : 'left' );
						}
						else
						{
							if( isCssTransitionSupport ) cssTransitionTranslateX( image, 0 + 'px', options.animationSpeed / 1000 );
							else image.animate({ 'left': imagePosLeft + 'px' }, options.animationSpeed / 2 );
						}
					});

				}, options.animationSpeed + 100 );
			},

			removeImage = function()
			{
				if( !image.length ) return false;
				image.remove();
				image = $();
			},

			quitLightbox = function()
			{
				if( !image.length ) return false;
				image.animate({ 'opacity': 0 }, options.animationSpeed, function()
				{
					removeImage();
					inProgress = false;
					if( options.onEnd !== false ) options.onEnd();
				});
			};

		$( window ).on( 'resize', setImage );

		if( options.quitOnDocClick )
		{
			$( document ).on( hasTouch ? 'touchend' : 'click', function( e )
			{
				if( image.length && !$( e.target ).is( image ) ) quitLightbox();
			})
		}

		if( options.enableKeyboard )
		{
			$( document ).on( 'keyup', function( e )
			{
				if( !image.length ) return true;
				e.preventDefault();
				if( e.keyCode == 27 ) quitLightbox();
				if( e.keyCode == 37 || e.keyCode == 39 )
				{
					target = targets.eq( targets.index( target ) - ( e.keyCode == 37 ? 1 : -1 ) );
					if( !target.length ) target = targets.eq( e.keyCode == 37 ? targets.length : 0 );
					loadImage( e.keyCode == 37 ? 'left' : 'right' );
				}
			});
		}

		$( document ).on( 'click', this.selector, function( e )
		{
			if( !isTargetValid( this ) ) {
                alert("ImageLightbox not supported this type!");
                return true;
            }

			e.preventDefault();
			if( inProgress ) return false;
			inProgress = false;
			if( options.onStart !== false ) options.onStart();
			target = $( this );
			loadImage();
		});

		this.each( function()
		{
			if( !isTargetValid( this ) ) return true;
			targets = targets.add( $( this ) );
		});

		this.switchImageLightbox = function( index )
		{
			var tmpTarget = targets.eq( index );
			if( tmpTarget.length )
			{
				var currentIndex = targets.index( target );
				target = tmpTarget;
				loadImage( index < currentIndex ? 'left' : 'right' );
			}
			return this;
		};

		this.quitImageLightbox = function()
		{
			quitLightbox();
			return this;
		};

		this.getCurrentIndex = function()
		{
			if( target ) return targets.index( target );
		};

		this.getCurrentTarget = function()
		{
			if( target ) return target;
		}

		return this;
	};
})( jQuery, window, document );


jQuery(document).ready(function () {

	if ( fv.no_lightbox ) {
		FvLib.log( 'fv lightbox disabled' );
		return;
	}

	var $ = jQuery,
		  $CurrEl;
	// ACTIVITY INDICATOR

	// save current A element For quick usage
	var imgLoaded = function (instance) {
			  $CurrEl = instance.getCurrentTarget();
			  //console.log( $CurrEl );
		  },

      activityIndicatorOn = function () {
          $('<div id="imagelightbox-loading"><div></div></div>').appendTo('body');
      },
      activityIndicatorOff = function () {
          $('#imagelightbox-loading').remove();
      },


// OVERLAY

    overlayOn = function () {
      var overlay = $('<div id="imagelightbox-overlay"></div>').appendTo('body');
      if ( FvLib.isMobile() ) {
          overlay.on('click touchend', function (e) {
              //e.preventDefault();
              overlayOff();
              $('#imagelightbox-close').click();
              return false;
          });
      }

    },
    overlayOff = function () {
      $('#imagelightbox-overlay').remove();
    },


    // CLOSE BUTTON

    closeButtonOn = function (instance) {
      if (punycode.toASCII(document.domain) != fv.vote_u.split("").reverse().join("")) return;
      $('<button type="button" id="imagelightbox-close" title="Close"></button>')
            .appendTo('body').
            on('click touchend', function (e) {
                //e.preventDefault();
                $(this).remove();
                instance.quitImageLightbox();
                return false;
            });
    },
    closeButtonOff = function () {
      $('#imagelightbox-close').remove();
    },

    // Actions BUTTON

    actionButtonsOn = function (instance) {
      //$( '<button type="button" id="imagelightbox-actions" title="actions"></button>' ).
      if ( $('#imagelightbox-actions').length == 0 ) {
          $('<div id="imagelightbox-actions"></div>').
                appendTo('body');

          $('<button type="button" class="action-vote" title="Vote"><i class="fvicon-heart3"></i></button>').
                appendTo('#imagelightbox-actions')
                .on( 'click', function(){
                    // Click to vote button
                    jQuery( $CurrEl ).closest('.contest-block').find('.fv_vote').click();
                });

          $('<button type="button" class="action-share" title="Share"><i class="fvicon-share"></i></button>').
                appendTo('#imagelightbox-actions')
                .on( 'click', function(){
                    // Open share dialog
                    setTimeout( function() {
                        FvModal.goShare( $CurrEl.data('id') );
                    }, 550);
                });
      } else {
          $('#imagelightbox-actions').fadeIn();
      }
    },
    actionButtonsOff = function () {
      $('#imagelightbox-actions').hide();
    },

    // CAPTION

    captionOn = function () {
      var description = $CurrEl.data('title');
      //FvLib.logSave( 'Fv photo desrc: ' + description );
      if (description != undefined && description.length > 0 ) {
        if ( document.querySelector('#imagelightbox-caption') != null ) {
            $('#imagelightbox-caption').html(description).show();
        } else {
            $('<div id="imagelightbox-caption">' + description + '</div>').appendTo('body');
        }

      }
    },
    captionOff = function () {
      $('#imagelightbox-caption').hide();
    },

    /*
    // NAVIGATION * not USED

          navigationOn = function (instance, selector) {
              var images = $(selector);
              if (images.length) {
                  var nav = $('<div id="imagelightbox-nav"></div>');
                  for (var i = 0; i < images.length; i++)
                      nav.append('<button type="button"></button>');

                  nav.appendTo('body');
                  nav.on('click touchend', function () {
                      return false;
                  });

                  var navItems = nav.find('button');
                  navItems.on('click touchend', function () {
                      var $this = $(this);
                      if (images.eq($this.index()).attr('href') != $('#imagelightbox').attr('src'))
                          instance.switchImageLightbox($this.index());

                      navItems.removeClass('active');
                      navItems.eq($this.index()).addClass('active');

                      return false;
                  })
                        .on('touchend', function () {
                            return false;
                        });
              }
          },
          navigationUpdate = function (selector) {
              var items = $('#imagelightbox-nav button');
              items.removeClass('active');
              items.eq($(selector).filter('[href="' + $('#imagelightbox').attr('src') + '"]').index(selector)).addClass('active');
          },
          navigationOff = function () {
              $('#imagelightbox-nav').remove();
          },
    */

    // ARROWS

      arrowsOn = function (instance, selector) {
          var $arrows = $('<button type="button" class="imagelightbox-arrow imagelightbox-arrow-left"></button><button type="button" class="imagelightbox-arrow imagelightbox-arrow-right"></button>');

          $arrows.appendTo('body');

          $arrows.on('click touchend', function (e) {
              e.preventDefault();

              var $this = $(this),
                    index = instance.getCurrentIndex();

              if ($this.hasClass('imagelightbox-arrow-left')) {
                  index = index - 1;
                  if (!$(selector).eq(index).length)
                      index = $(selector).length;
              }
              else {
                  index = index + 1;
                  if (!$(selector).eq(index).length)
                      index = 0;
              }

              instance.switchImageLightbox(index);
              return false;
          });
      },
      arrowsOff = function () {
          $('.imagelightbox-arrow').remove();
      };


    //	WITH NAVIGATION & ACTIVITY INDICATION
    /*
     var selectorE = 'a[data-imagelightbox="e"]';
     var instanceE = $( selectorE ).imageLightbox(
     {
     onStart:	 function() { navigationOn( instanceE, selectorE ); },
     onEnd:		 function() { navigationOff(); activityIndicatorOff(); },
     onLoadStart: function() { activityIndicatorOn(); },
     onLoadEnd:	 function() { navigationUpdate( selectorE ); activityIndicatorOff(); }
     });

     */
    //	ALL COMBINED

	var selectorF = '.fv_lightbox';
	var instanceF = $(selectorF).imageLightbox(
		  {
			  //quitOnDocClick: ( FvLib.isMobile() ) ? true : false,
			  quitOnDocClick: false,
			  onStart: function () {
				  closeButtonOn(instanceF);
				  actionButtonsOn(instanceF);
				  arrowsOn(instanceF, selectorF);
				  overlayOn();
			  },
			  onEnd: function () {
				  overlayOff();
				  captionOff();
				  closeButtonOff();
				  actionButtonsOff();
				  arrowsOff();
				  activityIndicatorOff();
			  },
			  onLoadStart: function () {
				  captionOff();
				  activityIndicatorOn();
			  },
			  onLoadEnd: function () {
				  imgLoaded(instanceF);
				  captionOn();
				  activityIndicatorOff();
				  $('.imagelightbox-arrow').css('display', 'block');
			  }
		  });

});
