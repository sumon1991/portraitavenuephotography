/* test */
;(function ($, window, document, undefined) {
	'use strict';

	$('body').fitVids();
	
	/*=================================*/
	/* 01 - VARIABLES */
	/*=================================*/
	var swipers = [],
		winW, winH, winScr, _isresponsive, smPoint = 768,
		mdPoint = 992,
		lgPoint = 1200,
		addPoint = 1600,
		_ismobile = navigator.userAgent.match(/Android/i) || navigator.userAgent.match(/webOS/i) || navigator.userAgent.match(/iPhone/i) || navigator.userAgent.match(/iPad/i) || navigator.userAgent.match(/iPod/i),
		pageCalculateHeight;


	/*=================================*/
	/* 02 - PAGE CALCULATIONS */
	/*=================================*/
	/**
	 *
	 * PageCalculations function
	 * @since 1.0.0
	 * @version 1.0.1
	 * @var winW
	 * @var winH
	 * @var winS
	 * @var pageCalculations
	 * @var onEvent
	 **/
	if (typeof pageCalculations !== 'function') {

		var winW, winH, winS, pageCalculations, onEvent = window.addEventListener;

		pageCalculations = function(func){

			winW = window.innerWidth;
			winH = window.innerHeight;
			winS = document.body.scrollTop;

			if (!func) return;

			onEvent('load', func, true); // window onload
			onEvent('resize', func, true); // window resize
			onEvent("orientationchange", func, false); // window orientationchange

		}// end pageCalculations

		pageCalculations(function(){
			pageCalculations();
		});
	}

	function pageHeightCalculate() {
		if($('.page-calculate.fullheight').length) {

			var pageCalculate = $('.page-calculate'),
				headerHeight = $('.header_top_bg').not('.header_trans-fixed').outerHeight() || 0,
				footerHeight = $('#footer').not('.fix-bottom').outerHeight() || 0;

			pageCalculate.height(winH - headerHeight - footerHeight);
			pageCalculateHeight = pageCalculate.height();
		}
	}


	pageCalculations(function(){

		pageHeightCalculate();
		blogSimpleHeightCalculate();
		if (!window.enable_foxlazy) {
			wpc_add_img_bg('.s-img-switch');
		}

		/* fix for splited slider */
		wpc_add_img_bg('.ms-section .s-img-switch');
		wpc_add_img_bg('.woocommerce .s-img-switch');

		$('.swiper-container.initialized[data-slides-per-view="responsive"]').each(function () {
			var thisSwiper = swipers['swiper-' + $(this).attr('id')]
				, $t = $(this)
				, slidesPerViewVar = updateSlidesPerView($t)
				, centerVar = thisSwiper.params.centeredSlides;
			thisSwiper.params.slidesPerView = slidesPerViewVar;
			thisSwiper.reInit();
			if (!centerVar) {
				var paginationSpan = $t.find('.pagination span');
				var paginationSlice = paginationSpan.hide().slice(0, (paginationSpan.length + 1 - slidesPerViewVar));
				if (paginationSlice.length <= 1 || slidesPerViewVar >= $t.find('.swiper-slide').length) $t.addClass('pagination-hidden');
				else $t.removeClass('pagination-hidden');
				paginationSlice.show();
			}
		});

	});


	if($('.kenburns').length){
		$('.kenburns').each(function () {
			$(this).kenBurning({
				time : 6000
			});

		});
	}

	function kenburnsHeight() {
		if($('.kenburns-wrap').length){
			$('.kenburns-wrap').each(function () {
				var headerH = $('.header_top_bg').not('.header_trans-fixed').outerHeight() || 0,
					footerH = $('#footer').not('.fix-bottom').outerHeight() || 0,
					sliderH = $(window).height() - (headerH + footerH),
					bottomplay = $('#footer').hasClass('fix-bottom') ? ($('#footer').outerHeight() + 2) : '10';

				$(this).find('.kenburns-play').css('bottom', bottomplay + 'px');
				$(this).find('.napoli-sound-btn').css('bottom', bottomplay + 'px');

				$(this).css('height', sliderH + 'px');
			});
		}
	}




	/*=================================*/
	/* 03 - FUNCTION ON DOCUMENT READY */
	/*=================================*/
	$(window).ready(function () {
		if($('.full_screen_slider.disable_scroll').length) {
			$('html, body').addClass('overflow-hidden');
		}
	});

	/*Full height banner*/
	function topBannerHeight() {

		var bannerHeight = $(window).height() - $('footer').outerHeight();
		$('.full-height').css('min-height', (bannerHeight - $('header').closest('.col-xs-12').outerHeight()) + 'px');
		$('.full-height-hard').css('height', (bannerHeight - $('header').closest('.col-xs-12').outerHeight()) + 'px');
		var fullHeight = $('.top-banner.full-height').outerHeight();
		var heightContentBanner = $('.top-banner.full-height .content').outerHeight();
		var minheightContentBanner = heightContentBanner + 100;
		$('.top-banner.full-height .content').css('top', (fullHeight - heightContentBanner) / 2 + 'px');
		if (fullHeight < minheightContentBanner) {
			$('.top-banner.full-height').css('min-height', minheightContentBanner + 'px');
			$('.top-banner.full-height .content').css('top', (minheightContentBanner - heightContentBanner) / 2 + 'px');
		}


		if($('.iframe-video.banner-video').length){
			var headerH = $('.header_top_bg').not('.header_trans-fixed').outerHeight() || 0,
				footerH = $('#footer').not('.fix-bottom').outerHeight() || 0,
				bannerH = $(window).height() - (headerH + footerH);

			$('.iframe-video.banner-video').css('height', bannerH + 'px' );
		}


	}


	/*=================================*/
	/* PAGE LOADING TRANSITION */
	/*=================================*/

	if($(".animsition").length){
		$(".animsition").animsition({
			inClass               :   'fade-in',
			outClass              :   'fade-out',
			inDuration            :    2000,
			outDuration           :    800,
			loading               :    true,
			loadingParentElement  :   'body', //animsition wrapper element
			loadingClass          :   'animsition-loading',
			unSupportCss          : [ 'animation-duration',
			                          '-webkit-animation-duration',
			                          '-o-animation-duration'
			                        ],
			overlay               :   false,
			overlayClass          :   'animsition-overlay-slide',
			overlayParentElement  :   'body'
		});
	}


	/*=================================*/
	/* 04 - FUNCTION ON PAGE LOAD */
	/*=================================*/

	$(window).on('load', function () {
		initSwiper(); 
		initFullScreenSwiper();
		initFlowSlider();
		portfolioSliderHeight();

		if ($('.multiscroll-slider').length) {
			initMultiscroll();
			multiScrollControls();
		}
		initThumbFlexSlider();
		kenburnsHeight();
		wpc_add_img_bg('.s-img-switch');
	});

	/*=================================*/
	/* 06 - FUNCTION ON PAGE SCROLL */
	/*=================================*/
	$(window).on('scroll', function() {
	});


	/*=================================*/
	/* BACKGROUND */
	/*=================================*/
	//sets child image as a background
	function wpc_add_img_bg(img_sel, parent_sel) {
		if (!img_sel) {
			console.info('no img selector');
			return false;
		}
		var $parent, $imgDataHidden, _this;
		$(img_sel).each(function () {
			_this = $(this);
			$imgDataHidden = _this.data('s-hidden');
			$parent = _this.closest(parent_sel);
			$parent = $parent.length ? $parent : _this.parent();
			$parent.css('background-image', 'url(' + this.src + ')').addClass('s-back-switch');
			if ($imgDataHidden) {
				_this.css('visibility', 'hidden');
			}
			else {
				_this.hide();
			}
		});
	}


	/*=================================*/
	/* SWIPER SLIDER */
	/*=================================*/
	function initSwiper() {
		var initIterator = 0;
		$('.swiper-container').each(function () {

			var $t = $(this);
			var index = 'swiper-unique-id-' + initIterator;
			$t.addClass('swiper-' + index + ' initialized').attr('id', index);
			$t.find('.pagination').addClass('pagination-' + index);
			var autoPlayVar = parseInt($t.attr('data-autoplay'), 10);
			var mode = $t.attr('data-mode');
			var slidesPerViewVar = $t.attr('data-slides-per-view');
			if (slidesPerViewVar == 'responsive') {
				slidesPerViewVar = updateSlidesPerView($t);
			}
			else slidesPerViewVar = parseInt(slidesPerViewVar, 10);
			var loopVar = parseInt($t.attr('data-loop'), 10);
			var noSwipingVar = $t.attr('data-noSwiping');
			var speedVar = parseInt($t.attr('data-speed'), 10);
			var centerVar = parseInt($t.attr('data-center'), 10);
			console.log('sefsg');
			swipers['swiper-' + index] = new Swiper('.swiper-' + index, {
				speed: speedVar,
				pagination: '.pagination-' + index,
				loop: loopVar,
				paginationClickable: true,
				autoplay: autoPlayVar,
				slidesPerView: slidesPerViewVar,
				keyboardControl: true,
				calculateHeight: true,
				simulateTouch: true,
				roundLengths: true,
				centeredSlides: centerVar,
				noSwiping: noSwipingVar,
				loopAdditionalSlides: 4,
				initialSlide:0,
				noSwipingClass: 'stop-swiping',
				mode: mode || 'horizontal',
				onInit: function (swiper) {
					$t.find('.swiper-slide').addClass('active');


					if($t.closest('.banner-slider-wrap.vertical') && $(window).width() < 768){
						$t.find('.swiper-slide').addClass('stop-swiping');
					}else{
						$t.find('.swiper-slide').removeClass('stop-swiping');
					}


				},
				onSlideChangeEnd: function (swiper) {

					var activeIndex = (loopVar === 1) ? swiper.activeLoopIndex : swiper.activeIndex;
				},
				onSlideChangeStart: function (swiper) {
					if ( window.enable_foxlazy) {
						$t.find('.swiper-slide img[data-lazy-src]').foxlazy();
					}
					$t.find('.swiper-slide.active').removeClass('active');
				}
			});

			swipers['swiper-' + index].reInit();
			popup_image();

			var _this = swipers['swiper-' + index];
			popup_image_products(_this);


			$('.single-product .product .napoli_images a').on('click', function () {
				swipers['swiper-' + index].stopAutoplay();
			});


			if ($t.attr('data-slides-per-view') == 'responsive') {
				var paginationSpan = $t.find('.pagination span');
				var paginationSlice = paginationSpan.hide().slice(0, (paginationSpan.length + 1 - slidesPerViewVar));
				if (paginationSlice.length <= 1 || slidesPerViewVar >= $t.find('.swiper-slide').length) $t.addClass('pagination-hidden');
				else $t.removeClass('pagination-hidden');
				paginationSlice.show();
			}

			if ($t.find('.default-active').length) {
				swipers['swiper-' + index].swipeTo($t.find('.swiper-slide').index($t.find('.default-active')), 0);
			}

			initIterator++;
		});
	}

	function popup_image(){
		$('.popup-image').magnificPopup({
			type: 'image',
			mainClass: 'mfp-fade',
			removalDelay: 300,
			closeOnContentClick: true,
			fixedContentPos: true,
			fixedBgPos: true
		});
	}
	popup_image();

	function popup_image_products(_this){
		$('.product .popup-image').magnificPopup({
			type: 'image',
			mainClass: 'mfp-fade',
			removalDelay: 300,
			closeOnContentClick: true,
			fixedContentPos: true,
			fixedBgPos: true,
			callbacks: {
				close: function() {
					_this.startAutoplay();
				}
			}
		});
	}
	popup_image_products();


	/*=================================*/
	/* FULL SCREEN SLIDER */
	/*=================================*/
    function initFullScreenSwiper(){
        var initIterator = 0;
        $('.full_screen_slider').each(function(){

        	var $t = $(this);
            var index = 'swiper-unique-id-'+initIterator;
            $t.addClass('swiper-'+index + ' initialized').attr('id', index);
            $t.find('.pagination').addClass('pagination-'+index);
            var autoPlayVar = parseInt($t.attr('data-autoplay'),10);
            var mode = $t.attr('data-mode');
            var slidesPerViewVar = $t.attr('data-slides-per-view');
            if(slidesPerViewVar == 'responsive'){
                slidesPerViewVar = updateSlidesPerView($t);
            }
            else slidesPerViewVar = parseInt(slidesPerViewVar,10);

            var setThumb = function(activeIndex, slidesNum){
                var url_thumb,
                    leftClick = $t.find('.slider-click.left'),
                    rightClick = $t.find('.slider-click.right'),
                    slidesNum = slidesNum,
                    activeIndexLeft, activeIndexRight;
                if(activeIndex<1) {
                    leftClick.addClass('disabled');
                }
                else {
                    leftClick.removeClass('disabled').find('.left').text(activeIndex);
                    leftClick.find('.right').text(slidesNum);
                }
                if(activeIndex == slidesNum-1) {
                    rightClick.addClass('disabled');
                }
                else {
                    rightClick.removeClass('disabled').find('.left').text(activeIndex+2);
                    rightClick.find('.right').text(slidesNum);
                }
            }

            var loopVar = parseInt($t.attr('data-loop'),10);
            var speedVar = parseInt($t.attr('data-speed'),10);
            var centerVar = parseInt($t.attr('data-center'),10);

            swipers['swiper-'+index] = new Swiper('.swiper-'+index,{
                speed: speedVar,
                pagination: '.pagination-'+index,
                loop: loopVar,
                paginationClickable: true,
                autoplay: autoPlayVar,
                slidesPerView: slidesPerViewVar,
                keyboardControl: true,
                calculateHeight: true,
                simulateTouch: true,
                roundLengths: true,
                centeredSlides: centerVar,
                mode: mode || 'horizontal',
                onInit: function(swiper){
                    $t.find('.swiper-slide').addClass('active');
                    if ( winW > 1024 ){
                    	$t.find(".slider-click").each(function() {
                            var arrow = $(this);
                            $(document).on("mousemove", function(event) {
                                var arrow_parent = arrow.parent(),
                                    parent_offset = arrow_parent.offset(),
                                    pos_left = Math.min(event.pageX - parent_offset.left, arrow_parent.width()),
                                    pos_top = event.pageY - parent_offset.top;

                                arrow.css({
                                	'left': pos_left,
                                	'top' : pos_top
                                });
                            });
                    	});
                    }
                	setThumb(swiper.activeLoopIndex, swiper.slides.length);
                	popup_image();
            	},
                onSlideChangeEnd: function(swiper){
                    var activeIndex = (loopVar===1)?swiper.activeLoopIndex:swiper.activeIndex;
                    setThumb(swiper.activeLoopIndex, swiper.slides.length);
                    popup_image()
                },
                onSlideChangeStart: function(swiper){
                    $t.find('.swiper-slide.active').removeClass('active');
                    var activeIndex = (loopVar==1)?swiper.activeLoopIndex:swiper.activeIndex;
                    setThumb(swiper.activeLoopIndex, swiper.slides.length);
                    swiper.startAutoplay();
                }
            });
            swipers['swiper-'+index].reInit();

            if($t.attr('data-slides-per-view')=='responsive'){
                var paginationSpan = $t.find('.pagination span');
                var paginationSlice = paginationSpan.hide().slice(0,(paginationSpan.length+1-slidesPerViewVar));
                if(paginationSlice.length<=1 || slidesPerViewVar>=$t.find('.swiper-slide').length) $t.addClass('pagination-hidden');
                else $t.removeClass('pagination-hidden');
                paginationSlice.show();
            }

            initIterator++;
        });
    }

	function updateSlidesPerView(swiperContainer) {
		if (winW >= addPoint) return parseInt(swiperContainer.attr('data-add-slides'), 10);
		else if (winW >= lgPoint) return parseInt(swiperContainer.attr('data-lg-slides'), 10);
		else if (winW >= mdPoint) return parseInt(swiperContainer.attr('data-md-slides'), 10);
		else if (winW >= smPoint) return parseInt(swiperContainer.attr('data-sm-slides'), 10);
		else return parseInt(swiperContainer.attr('data-xs-slides'), 10);
	}

	//swiper arrows
	$('.swiper-arrow-left').on('click', function () {
		swipers['swiper-' + $(this).parent().attr('id')].swipePrev();
	});
	$('.swiper-arrow-right').on('click', function () {
		swipers['swiper-' + $(this).parent().attr('id')].swipeNext();
	});
	$('.swiper-outer-left').on('click', function () {
		swipers['swiper-' + $(this).parent().find('.swiper-container').attr('id')].swipePrev();
	});
	$('.swiper-outer-right').on('click', function () {
		swipers['swiper-' + $(this).parent().find('.swiper-container').attr('id')].swipeNext();
	});
	$('.slider-click.left').on('click', function(){
        swipers['swiper-' + $(this).parent().parent().parent().find('.full_screen_slider').attr('id')].swipePrev();
    	swipers['swiper-' + $(this).parent().parent().parent().find('.full_screen_slider').attr('id')].startAutoplay();
    });
    $('.slider-click.right').on('click', function(){
        swipers['swiper-' + $(this).parent().parent().parent().find('.full_screen_slider').attr('id')].swipeNext();
    	swipers['swiper-' + $(this).parent().parent().parent().find('.full_screen_slider').attr('id')].startAutoplay();
    });


    /*=================================*/
	/* FLOW SLIDER */
	/*=================================*/

	function initFlowSlider() {
		$('.flipster-slider').each(function(index) {

			var that = $(this);

			var sliderIndex = 'flipster-slider-unique-id-' + index;

			that.addClass(sliderIndex + ' initialized').attr('id', sliderIndex);

			var VarKeyboardControl = parseInt(that.attr('data-keyboard'), 10);
			var VarMousewheel = parseInt(that.attr('data-mousewheel'), 10);
			var VarNavButtons = parseInt(that.attr('data-controls'), 10);

			that.flipster({
				style:'carousel',
				enableKeyboard: VarKeyboardControl || false,
				enableMousewheel: VarMousewheel || false,
				enableNavButtons: VarNavButtons	|| false
			})
		})
	}


	/*=================================*/
	/* POST BOX HEIGHT */
	/*=================================*/
	function blogSimpleHeightCalculate() {
		if($('.simple.enable_fullheight').length) {

			var blogSimple = $('.simple.enable_fullheight'),
				headerHeight = $('.header_top_bg').not('.header_trans-fixed').outerHeight() || 0,
				footerHeight = $('#footer').not('.fix-bottom').outerHeight() || 0,
				blogSimpleHeight;

			blogSimple.height(winH - headerHeight - footerHeight - 40);

		}
		if($('.team-member.fullheight.full_height').length) {
			var teamFullheight = $('.team-member.fullheight.full_height'),
				headerHeight = $('.header_top_bg').not('.header_trans-fixed').outerHeight() || 0,
				footerHeight = $('#footer').not('.fix-bottom').outerHeight() || 0,
				teamFullheightHeight;

			teamFullheight.height(winH - headerHeight - footerHeight - 40);
		}
	}


	/***********************************/
	/* COUNTER PAGINATION*/
	/**********************************/

	function counterPagination() {
		if ($('.pagination.simpple').length) {
			$('.pagination.simpple').each(function(index) {
				$(this).find('span').each(function(index) {
					if ((index + 1) < 10) {
						$(this).html('0' + (index + 1));
					} else {
						$(this).html((index + 1));
					}
				});
			});
		}
	}



	$(window).on('resize', function () {
		if ($('.ytbg').length) {
			video_size();
		}
		topBannerHeight();
		kenburnsHeight();
	});

	function video_size() {
		var height = $('.ytbg').width() * 0.55;
		$('.ytbg').closest('.wpb_wrapper').css('height', height + 'px');
	}
	if ($('.ytbg').length) {
		video_size();
	}
	if ($('.wpb_wrapper .hero-slider .slide').length) {
		if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
			$('.hero-slider .slide').closest('.wpb_wrapper').css('margin', '0 15px')
		}
		else {
			$('.hero-slider .slide').closest('.wpb_wrapper').css('margin', '0 50px')
		}
	}
	$('.mb_YTPPlaypause').live('click', function () {
		$(this).toggleClass("active");
	});
	$("iframe:not([src*=soundcloud])").each(function (index) {
		$(this).wrap("<div class='video-container'></div>");
	});




	// if element visible
	// ---------------------------------
	$.fn.isVisible = function () {
		var st = $(window).scrollTop()
			, wh = $(window).height()
			, tt = $(this).offset().top
			, th = $(this).height()
			, r;
		if (st + wh >= tt && tt + th >= st) {
			r = 1
		}
		else {
			r = 0
		}
		return r;
	};


	// smooth scroll
	// ---------------------------------
	$('.sscroll').on('click', function () {
		var ti = $(this).attr('href')
			, tt = $(ti).offset().top - 100;
		$('html, body').animate({
			scrollTop: tt
		}, 600);
		return false;
	});


	// scroll to top
	// ---------------------------------
	$(window).on('scroll', function () {
		var wh = $(window).height()
			, st = $(window).scrollTop();
		if (st >= wh * 0.1) {
			$('.to-top').fadeIn();
		}
		else {
			$('.to-top').fadeOut()
		}
	});
	$('.to-top').on('click', function () {
		$('html, body').animate({
			scrollTop: 0
		}, 600);
		return false;
	});


	// parallax
	$.stellar({
		horizontalScrolling: false
		, responsive: true
	});


	// stellar fix - bg position on load
	if ($('[data-stellar-background-ratio]').length > 0) {
		setTimeout(function () {
			var st = $(window).scrollTop();
			$(window).scrollTop(st + 1);
			setTimeout(function () {
				$(window).scrollTop(st)
			}, 200);
		}, 200);
	}
	if ($('.hero-inner').length) {
		$(window).on('resize', function () {
			var hh = $('header').height();
			var hi = $('.hero-inner').height() / 2;
		}).resize();
	}


	// MOBILE NAVIGATION
	$('.mob-nav').on('click', function () {
		$(this).toggleClass('active');
		$(this).find('i').toggleClass('fa-bars fa-times');
		$('#topmenu').slideToggle();
		$('.header_top_bg.header_trans-fixed').toggleClass('open');
		$('body, html').toggleClass('no-scroll');
		return false;
	});


	// side links
	$('.side-link').each(function () {
		var e = $(this);
		var h = Math.round(e.height());
		if ((h % 2) == 1) {
			e.css({
				height: '+=1'
			});
		}
	});


	// Hero slider
	// ---------------------------------
	if ($('.hero-slider').length) {
		$(window).on('resize', function () {
			$('.hero-slider .slide').height('800px').width('100%');
		}).resize();
		$('.hero-slider').flexslider({
			animation: "slide",
			pauseOnAction: true,
			animationLoop: true,
			slideshow: true,
			slideshowSpeed: 7000,
			animationSpeed: 600,
			controlNav: true,
			directionNav: false
		});
	}


	// YT Background
	// ---------------------------------
	$('.ytbg').YTPlayer({
		showYTLogo: false,
		optimizeDisplay: true
	});
	// equal-height columns
	$('.equal-height [class*="col-"]').matchHeight({
		byRow: false
	});
	/**/
	$('.equal-height .wpb_wrapper').matchHeight({
		byRow: false
	});
	/**/



	// image slider
	// ---------------------------------
	if($('.img-slider').length) {
		$('.img-slider').flexslider({
			animation: "slide",
			smoothHeight: true,
			pauseOnAction: false,
			controlNav: false,
			directionNav: true,
			prevText: "<i class='pe pe-7s-angle-left'></i>",
			nextText: "<i class='pe pe-7s-angle-right'></i>"
		});
	}
	$('.flex-direction-nav a').on('click', function (ev) {
		ev.stopPropagation();
	});


	// BLOG
	// ---------------------------------
	$(window).on('load', function () {
		$('.blog').imagesLoaded(function () {
			$('.blog').shuffle({
				"itemSelector": ".post"
			});
			// fix
			setTimeout(function () {
				$('.blog').shuffle('shuffle');
			}, 200);
		});
		topBannerHeight();
		calcPaddingMainWrapper();
	});

	var shuffleInstance;
	function suffle(){
		// debugger;
		shuffleInstance = $('.portfolio .wpb_wrapper').shuffle({
			"itemSelector": ".item",
			"delimeter": ' '
		});
	}
	// PORTFOLIO
	// ---------------------------------
	$(window).on('load', function () {

		if ($('.portfolio.col-3').length) {
			$('.item').width(100 / 3 + '%');
			$('.item.wide, .item.wide-tall').width(100 * 2 / 3 + '%');
		}
		if ($('.portfolio.col-4').length) {
			$('.item').width(100 / 4 + '%');
			$('.item.wide, .item.wide-tall').width(100 * 2 / 4 + '%');
		}
		if( $('.portfolio.col-6').length ){
			$('.item').width( 100/2+'%' );
			$('.item.wide, .item.wide-tall').width( 100*2/2+'%' );
		}

 		suffle();
		portfolioFilter();

		// fix
		setTimeout(function () {

			$(window).resize();
	 		$('.portfolio .wpb_wrapper').shuffle('update');
		}, 200);

		initIsotop();
		$('.portfolio .wpb_wrapper').shuffle('shuffle', 'all');

		$("img[data-lazy-src]").foxlazy('', function(){
			setTimeout(initIsotop, 200);
			setTimeout(function () {
				$('.portfolio .wpb_wrapper').shuffle('shuffle', 'all');
				portfolioFilter();
			}, 200);
		});

	});


	// spaces between items
	$('.portfolio[data-space]').each(function () {
		var space = $(this).data('space');
		$(this).find('.item-link').css({
			'margin': space
		});
		$('.portfolio').css({
			'margin-left': -space + 'px',
			'margin-right': -space + 'px'
		});
	});


	// FILTER
	$('.filter ul li').on('click', function () {
		var filter = $(this).data('group');
		$('.portfolio .wpb_wrapper').shuffle('shuffle', filter);
		$('.filter ul li').removeClass('active');
		$(this).addClass('active');
		setTimeout(function(){
			$("img[data-lazy-src]").foxlazy();
		},200);
	});


	// banner with gallery
	// ---------------------------------
	function bannerGallery() {
		var w1 = $(window).width();
		var itemsArray = $('.banner-gallery .banner-list li');
		var imgWidth = $('.banner-gallery .banner-list li').height();
		var contentLeft;
		var contentRight;
		if (w1 > 1200) {
			contentLeft = $(itemsArray[9]).width() + $(itemsArray[10]).width();
			contentRight = $(itemsArray[16]).width() + $(itemsArray[17]).width();
			$('.banner-gallery .content-wrap').css({
				'top': imgWidth + 'px'
				, 'height': imgWidth * 3 + 'px'
				, 'left': contentLeft + 'px'
				, 'right': contentRight + 'px'
			});
		}
		else if (w1 > 767) {
			contentLeft = $(itemsArray[7]).width();
			contentRight = $(itemsArray[13]).width();
			$('.banner-gallery .content-wrap').css({
				'top': imgWidth + 'px'
				, 'height': imgWidth * 3 + 'px'
				, 'left': contentLeft + 'px'
				, 'right': contentRight + 'px'
			});
		}
		else if (w1 <= 767) {
			$('.banner-gallery .content-wrap').css({
				'top': imgWidth + 'px'
				, 'left': 0 + 'px'
				, 'right': 0 + 'px'
				, 'height': imgWidth * 3 + 'px'
			});
		}
	}

	$(window).on('resize', function () {
		bannerGallery();
		calcPaddingMainWrapper();
		counterPagination();
	});
	$(window).load(function () {
		bannerGallery();
		counterPagination();
		// fix
		// ---------------------------------
		setTimeout(function () {
			$(window).scroll();
		}, 300);
	});


	// toggles
	// ---------------------------------
	$('.toggle .toggle-title').click(function () {
		$(this).next('.toggle-content').slideToggle(200);
		$(this).parent('.toggle').toggleClass('active');
		return false;
	});


	// IMAGE POPUP
	// ---------------------------------
	// single

	// gallery mode
	$('.gallery-item:not(.popup-details)').magnificPopup({
		gallery: {
			enabled: true
		}
		, mainClass: 'mfp-fade'
		, fixedContentPos: true
		, fixedBgPos: true
		, type: 'image',

		image: {
			titleSrc: function(item) {
				return item.el.attr('data-title');
			}
		}

	});

	// YOUTUBE, VIMEO, GOOGLE MAPS POPUP
	// ---------------------------------
	$('.popup-youtube, .popup-vimeo, .popup-gmaps').magnificPopup({
		type: 'iframe'
		, mainClass: 'mfp-fade'
		, disableOn: 0
		, preloader: false
		, removalDelay: 300
		, fixedContentPos: true
		, fixedBgPos: true
	});


	// GALLERY POPUP
	// ---------------------------------
	// for portfolio
	$('.popup-gallery').magnificPopup({
		delegate: '.filtered a'
		, mainClass: 'mfp-fade'
		, gallery: {
			enabled: true
		}
		, fixedContentPos: true
		, fixedBgPos: true
		, type: 'image'
	});
	// single gallery
	$('.popup-single-gallery').each(function () {
		$(this).magnificPopup({
			delegate: 'a'
			, mainClass: 'mfp-fade'
			, gallery: {
				enabled: true
			}
			, fixedContentPos: true
			, fixedBgPos: true
			, type: 'image'
		});
	});


	// AJAX CONTACT FORM
	// ---------------------------------
	$('#contact form').submit(function () {
		var url = $(this).attr('action');
		// get information from contact form
		var name = $('[name=name]').val();
		var email = $('[name=email]').val();
		var message = $('[name=message]').val();
		// send information to contact.php
		$.ajax({
			type: "POST"
			, url: url
			, data: {
				name: name
				, email: email
				, message: message
			}
			, success: function (response) {
				// response from contact.php
				$('.contact-message').html(response).slideDown(500);
			}
			, error: function () {
				// error message
				$('.contact-message').html('<p class="error">Something went wrong, try again!</p>').slideDown('slow');
			}
		});
		return false;
	});


	// GOOGLE MAP
	// ----------------------------------
	//set your google maps parameters
	$(window).load(function () {
		if ($('#google-map').length > 0) {
			var latitude = $('#google-map').attr("data-lat")
				, longitude = $('#google-map').attr("data-lng")
				, contentString = $('#google-map').attr("data-string")
				, map_zoom = parseInt($('#google-map').attr("data-zoom"), 10);
			//google map custom marker icon
			var marker_url = $('#google-map').attr("data-marker");
			//we define here the style of the map
			var style = [{
				"featureType": "all", "elementType": "labels.text.fill", "stylers": [{
					"saturation": 36}, {"color": "#000000"}, {"lightness": 40}]}, {
				"featureType": "all", "elementType": "labels.text.stroke", "stylers": [{
					"visibility": "on"}, {"color": "#000000"}, {"lightness": 16}]}, {
				"featureType": "all", "elementType": "labels.icon", "stylers": [{
					"visibility": "off"}]}, {
				"featureType": "administrative", "elementType": "geometry.fill", "stylers": [{
					"color": "#000000"}, {"lightness": 20
				}]
			}, {
				"featureType": "administrative"
				, "elementType": "geometry.stroke"
				, "stylers": [{
					"color": "#000000"
				}, {
					"lightness": 17
				}, {
					"weight": 1.2
				}]
			}, {
				"featureType": "landscape"
				, "elementType": "geometry"
				, "stylers": [{
					"color": "#000000"
				}, {
					"lightness": 20
				}]
			}, {
				"featureType": "poi"
				, "elementType": "geometry"
				, "stylers": [{
					"color": "#000000"
				}, {
					"lightness": 21
				}]
			}, {
				"featureType": "road.highway"
				, "elementType": "geometry.fill"
				, "stylers": [{
					"color": "#000000"
				}, {
					"lightness": 17
				}]
			}, {
				"featureType": "road.highway"
				, "elementType": "geometry.stroke"
				, "stylers": [{
					"color": "#000000"
				}, {
					"lightness": 29
				}, {
					"weight": 0.2
				}]
			}, {
				"featureType": "road.arterial"
				, "elementType": "geometry"
				, "stylers": [{
					"color": "#000000"
				}, {
					"lightness": 18
				}]
			}, {
				"featureType": "road.local"
				, "elementType": "geometry"
				, "stylers": [{
					"color": "#000000"
				}, {
					"lightness": 16
				}]
			}, {
				"featureType": "transit"
				, "elementType": "geometry"
				, "stylers": [{
					"color": "#000000"
				}, {
					"lightness": 19
				}]
			}, {
				"featureType": "water"
				, "elementType": "geometry"
				, "stylers": [{
					"color": "#000000"
				}, {
					"lightness": 17
				}]
			}];
			//set google map options
			var map_options = {
					center: new google.maps.LatLng(latitude, longitude)
					, zoom: map_zoom
					, panControl: false
					, zoomControl: true
					, mapTypeControl: false
					, streetViewControl: false
					, mapTypeId: google.maps.MapTypeId.ROADMAP
					, scrollwheel: false
					, styles: style
				, }
				//inizialize the map
			var map = new google.maps.Map(document.getElementById('google-map'), map_options);
			//add a custom marker to the map
			var marker = new google.maps.Marker({
				position: new google.maps.LatLng(latitude, longitude)
				, map: map
				, visible: true
				, icon: marker_url
			, });
			var infowindow = new google.maps.InfoWindow({
				content: contentString
			});
			google.maps.event.addListener(marker, 'click', function () {
				infowindow.open(map, marker);
			});
		}
	});
	$('.wpcf7').on('focus', '.wpcf7-not-valid', function () {
		$(this).removeClass('wpcf7-not-valid');
	});

	function initIsotop(){

		if ($('.izotope-container').length) {
			$('.izotope-container').each(function () {
				var self = $(this);
				var layoutM = self.attr('data-layout') || 'masonry';
				self.isotope({
					itemSelector: '.item-single'
					, layoutMode: layoutM
					, masonry: {
						columnWidth: '.item-single'
						, gutterWidth: 30
					}
				});
			});
		}

		if ($('.izotope-container-2').length) {
			var $container = $('.izotope-container-2');
			$('.izotope-container-2').each(function () {
				var self = $(this);
				var layoutM = self.attr('data-layout') || 'masonry';
				self.isotope({
					itemSelector: '.full-single'
					, layoutMode: layoutM
					, masonry: {
						columnWidth: '.full-single'
					}
				});
			});
		}


		if ($('.izotope-container-3').length) {
			var $container = $('.izotope-container-3');
			$('.izotope-container-3').each(function () {
				var self = $(this);
				var layoutM = self.attr('data-layout') || 'masonry';
				self.isotope({
					itemSelector: '.images'
					, layoutMode: layoutM
					, masonry: {
						columnWidth: '.images'
					}
				});
			});
		}
	}
	

	$(window).on('resize', function () {
		initIsotop();
	});
	window.addEventListener("orientationchange", function () {
		setTimeout(bannerGallery, 130);
		kenburnsHeight();
		counterPagination();
	});
	/*Calculate paddings for main wrapper*/
	function calcPaddingMainWrapper() {
		if(!$("#footer.fix-bottom").length) {
			var paddValue = $('footer').outerHeight();
			$('.main-wrapper').css('padding-bottom', paddValue);
		}
	}
	calcPaddingMainWrapper();


	//fixed menu
	function addFixedHeader(){
		var topHeader = $('.header_top_bg.enable_fixed'),
			heightHeader = topHeader.height();

		$(window).on('scroll', function () {
			if ($(window).scrollTop() > 0 ) {
				topHeader.addClass('fixed');
				$('.main-wrapper').css('padding-top', heightHeader);
			} else {
				topHeader.removeClass('fixed');
				$('.main-wrapper').css('padding-top', '0');
			}
		});
	}
	addFixedHeader();
	$(window).on('resize',function(){
		addFixedHeader();
	});
	window.addEventListener("orientationchange", function() {
		addFixedHeader();
	}, false);

	// header social
	$('.napoli-top-social .social-icon').on("click", function() {
        var thisItem = $(this);
        var thisItemParent = thisItem.parent('.napoli-top-social');
        var thisSocials = thisItemParent.find('.social');

        thisItemParent.toggleClass('over');
        thisSocials.toggleClass('active');

        return false;
    });

	// for woocommerce
	$('.add_to_cart_button').on('click',function(){
        $(document.body).trigger('wc_fragment_refresh');
    });

	// flexslider
	$(window).on('load', function () {
		initFlexSlider();
	});

    function initFlexSlider() {

        $('#carousel').eventType = ('ontouchstart' in document.documentElement) ? 'touchstart' : 'click';
  		$('#carousel').eventType = "click";


        $('#slider').flexslider({
            animation: "fade",
            controlNav: false,
            animationLoop: false,
            slideshow: false,
            sync: "#carousel"
        })
        if(winW < 768) {
            $('#carousel').flexslider({
                animation: "slide",
                animationSpeed: 600,
                controlNav: false,
                animationLoop: true,
                direction: "horizontal",
                slideshow: true,
                itemWidth: 100,
                itemMargin: 1,
                mousewheel: true,
                move: 1,
                asNavFor: '#slider'
            });
        }
        else {
            $('#carousel').flexslider({
                animation: "slide",
                animationSpeed: 600,
                controlNav: false,
                animationLoop: true,
                direction: "vertical",
                slideshow: false,
                itemWidth: 100,
                itemMargin: 1,
                mousewheel: true,
                move: 1,
                asNavFor: '#slider'
            });
        }
    }



	// banner video full screen
	if($('.banner-video .full-button').length){
		$('.banner-video .full-button').each(function (index) {
			$(this).on('click', function(){
				if($(this).hasClass('on')){
					$(this).removeClass('on');
					$(this).closest('.banner-video').removeClass('full');
					$('header').removeClass('zindex');
					$('footer').removeClass('zindex');
				}else{
					$(this).addClass('on');
					$(this).closest('.banner-video').addClass('full');
					$('header').addClass('zindex');
					$('footer').addClass('zindex');
				}
			})
		})
	}


    function changeStateVideo(iframe_container,button,player,hover_enable,services){


    	var $this = $(button),
    		iframe = iframe_container.find('iframe');

    	if (hover_enable) {

    		iframe_container.on('mouseover',function(){
    			services == 'youtube' && player.playVideo();
    			$(this).addClass('play');
    			if (services != 'youtube') {
    				if (iframe.data('src')) {
		    			iframe.attr('src',iframe.data('src'));
		    		}

		    		$this.addClass('start')
		    			 .closest('.iframe-video').addClass('play');
    			}
    		});

    		iframe_container.on('mouseout',function(){
    			services == 'youtube' && player.pauseVideo();
    			if (services != 'youtube') {
    				if (iframe.data('src')) {
		    			iframe.attr('src','about:blank');
		    		}
		    		$this.addClass('start')
		    			 .closest('.iframe-video').addClass('play');
    			}
    			$(this).removeClass('play');
    		});

    		return;
    	}

    	if ($this.hasClass('start')) {
    		services == 'youtube' && player.pauseVideo();
    		if (iframe.data('src')) {
    			iframe.attr('src','about:blank');
    		}
    		$this.removeClass('start')
    			 .closest('.iframe-video').removeClass('play');
    	} else {
    		services == 'youtube' && player.playVideo();
    		if (iframe.data('src')) {
    			iframe.attr('src',iframe.data('src'));
    		}
    		$this.addClass('start')
    			 .closest('.iframe-video').addClass('play');
    	}

    	iframe_container = '';
    }
    // youtube video ready
    window.onYouTubeIframeAPIReady = function() {

    	var player = [],
    		$iframe_parent = [],
    		$this,
    		$button;

    	// each all iframe
    	$('iframe').each(function(i){
    		// get parent element
    		$this = $(this);
    		$iframe_parent[i] = $this.closest('.iframe-video.youtube');

    		// init video player
    		player[i] = new YT.Player(this, {

    			// callbacks
				events: {
					'onReady': function(event){
						// mute on/off
						if ( $iframe_parent[i].data('mute') ) {
							event.target.mute();
						}
					},
					'onStateChange': function(event){

						switch (event.data) {
						  case 1:
						  	// start play
						  	//Exammple: console.log(player.getDuration());
						  	//changeStateVideo($iframe_parent[i],$this[0], player[i],false,'youtube');
						  break;

						  case 2:
							// pause
						  break;

						  case 3:
						  	// buffering

						  break;

						  case 0:
						  	// end video
							  $iframe_parent[i].removeClass('play').find('.play-button').removeClass('start');

						  break;

						  default: '-1'
						  	// not play
						}
					}
				}
	        });

    		// hover play/pause video
	        if ($iframe_parent[i].data('type-start') == 'hover') {
		        changeStateVideo($iframe_parent[i], this, player[i],true,'youtube')
	        }

	        // click play/pause video
	        if ($iframe_parent[i].data('type-start') == 'click') {
	        	$iframe_parent[i].find('.play-button').on('click', function(event){
	        		event.preventDefault();
	        		changeStateVideo($iframe_parent[i],this, player[i],false,'youtube')
	        	});
	        }

			var muteButton = $iframe_parent[i].find('.mute-button');
			// mute video
			if(muteButton.length){
				muteButton.on('click', function () {
					if(muteButton.hasClass('mute1')){
						player[i].unMute();
						muteButton.removeClass('mute1');
					}else{
						muteButton.addClass('mute1');
						player[i].mute();
					}
				});
			}
	        // stop video
	        $iframe_parent[i].find('.video-close-button').on('click',function(){
	        	event.preventDefault();
	        	player[i].stopVideo();
	        	$iframe_parent[i].removeClass('play')
	        					 .find('.play-button').removeClass('start');
	        });

    	});

    };

 	var $iframe_parent = [];
    $('.iframe-video:not(.youtube)').each(function(i){
    	$iframe_parent[i] = $(this);
    	$('.play-button',$iframe_parent[i]).on('click',function(){
    		event.preventDefault();
    		changeStateVideo( $iframe_parent[i], this )
    	});
    	$iframe_parent[i].find('.video-close-button').on('click',function(){
    		event.preventDefault();
    		$iframe_parent[i].find('iframe').attr('src','about:blank');
    		$iframe_parent[i].removeClass('play')
    						 .find('.play-button').removeClass('start');
    	});

		// hover play/pause video
        if ($iframe_parent[i].data('type-start') == 'hover') {
	        changeStateVideo($iframe_parent[i], $iframe_parent[i].find('iframe')[0], false, true)
        }
    });

    if (navigator.userAgent.match(/(iPod|iPhone|iPad)/)) {
        $('form').submit(function(){

            var required = $(this).find('[required]'); // change to [required] if not using true option as part of the attribute as it is not really needed.
            var error = false;

            for(var i = 0; i <= (required.length - 1);i++)
            {
                if(required[i].value == '' || !required[i].validity.valid ) // tests that each required value does not equal blank, you could put in more stringent checks here if you wish.
                {
                    required[i].style.backgroundColor = 'rgb(255,155,155)';
                    error = true; // if any inputs fail validation then the error variable will be set to true;
                }
            }

            if(error) // if error is true;
            {
                return false; // stop the form from being submitted.
            }
        });
    }

    if( jQuery(".wpb-date").length ){
      jQuery(".wpb-date").datetimepicker();
    }

    // coming soon

    $(window).on('load', function(){
		if (comingSoonElements.length) {
			comingSoonValue()
		}
	});
	$(window).on('resize', function(){
		if (comingSoonElements.length) {
			comingSoonValue()
		}
	});

    var comingSoonElements = $('.coming-soon-descr li');
	function comingSoonValue(){
		comingSoonElements.each(function(){
			var thisElement = $(this),
				text = thisElement.data('desktop'),
				mobileText = thisElement.data('mobile');
			if ($(window).width() < 768) {
				thisElement.text(mobileText);
			} else {
				thisElement.text(text);
			}
		})
	}


$('.gridrotate').gridrotator({
	rows : 5,
	// number of columns
	columns : 9,
	w1200 : { rows : 5, columns : 9 },
	w992 : { rows : 5, columns : 7 },
	w510 : {rows : 5,columns : 5 },
	step : 7,
	maxStep : 7
});


	/**********************************/
	/*COUNTER coming SOON*/
	/**********************************/



	function getTimeRemaining(endtime) {
	  var t = Date.parse(endtime) - Date.parse(new Date());
	  var seconds = Math.floor((t / 1000) % 60);
	  var minutes = Math.floor((t / 1000 / 60) % 60);
	  var hours = Math.floor((t / (1000 * 60 * 60)) % 24);
	  var days = Math.floor(t / (1000 * 60 * 60 * 24));
	  return {
	    'total': t,
	    'days': days,
	    'hours': hours,
	    'minutes': minutes,
	    'seconds': seconds
	  };
	}


	function updateClock($clock,endTime,updateDays) {
	  var t = getTimeRemaining(endTime);

		if (updateDays) {
			$clock.find('.count-days').text( t.days );
		}

		if (updateDays || t.minutes === 59) {
			$clock.find('.count-hours').text( ('0' + t.hours).slice(-2) );
		}

		if (updateDays || t.seconds === 59) {
			$clock.find('.count-mins').text( ('0' + t.minutes).slice(-2) );
		}

		$clock.find('.count-secs').text( ('0' + t.seconds).slice(-2) );

		if (t.total <= 0) {
		  clearInterval(timeinterval);
		}
	}

	if ($('.coming-soon').length) {
		$('.coming-soon').each(function () {
			var self = $(this),
				endTime = self.attr('data-end'),
				$mask_clock = self.find('.mask');

			updateClock($mask_clock,endTime,true);

			var timeinterval = setInterval(function(){
				updateClock($mask_clock,endTime);
			}, 1000);

		});
	}


	/* Infinite scroll */
	function load_infinite_scroll() {
	    // Load More Portfolio
	    if (window.infinite_scroll) {

	        var amount_images_per_page = parseInt(infinite_scroll.amount_images_per_page);

	        // The maximum number of pages the current query can return.
	        var countImages = parseInt(infinite_scroll.countImages);

	        // The link of the next page of posts.
	        var url_next_page = infinite_scroll.url_next_page;


	        var maxPages = infinite_scroll.maxPages;


	        var infinite_page = infinite_scroll.infinite_page;

	        // wrapper selector
	        var wrap_selector = '.gallery-wrap';

	        var pageNum = 1;
	        $(window).on('scroll',function(){
	        	if ($(document).height() - winH == $(window).scrollTop() && pageNum < maxPages ) {
	        		pageNum++;
	        		$.ajax({
	        		    url: url_next_page + '?infinite_page='+(pageNum),
	        		    type: "get",
	        		    success: function (data) {

	        		        var newElements = $(data).find('.izotope-container-2 .item-single');

		        		       var elems = [];

		        		        newElements.each(function (i) {
		        		            elems.push(this);
		        		        });

		        		        $('.izotope-container-2').isotope('insert', elems);
		        		        $('.izotope-container-2').find('img').on('load', function () {
		        		        	 if (!window.enable_foxlazy) {
		        		        	 	wpc_add_img_bg('.s-img-switch');
		        		        	 }
		        		        });

		        		        pageCalculations();

		        		        $('.gallery-item:not(.popup-details)').magnificPopup({
		        		        	gallery: {
		        		        		enabled: true
		        		        	}
		        		        	, mainClass: 'mfp-fade'
									, fixedContentPos: true
									, fixedBgPos: true
		        		        	, type: 'image'
		        		        });

		        		        newElements.find('img[data-lazy-src]').foxlazy();

		        		    pageNum++;


	        		    }
	        		});
	        	}
	        });

	    }
	}
	load_infinite_scroll();


	/**********************************/
	/*SPLITTED SLIDER*/
	/**********************************/

	$(window).on('resize', function () {
		if ($('.multiscroll-slider').length) {
			$.fn.multiscroll.destroy();
			initMultiscroll();
		}
	});

	window.addEventListener('orientationchange', function () {
		if ($('.multiscroll-slider').length) {
			$.fn.multiscroll.destroy();
			initMultiscroll();
		}
	});

	function initMultiscroll() {

		var winW = $(window).width(),
		    winH = $(window).height(),
		    mutiscrollWrapp = $('.multiscroll-slider'),
			multiscrollLeft = mutiscrollWrapp.find('.multiscroll-slider-left'),
			multiscrollRight = mutiscrollWrapp.find('.multiscroll-slider-right'),
			multiscrollHeight;

		if (mutiscrollWrapp.hasClass('fullheight')) {
			var headerHeight = $('.header_top_bg').not('.header_trans-fixed').outerHeight();
			var footerHeight = $('#footer').not('.fix-bottom').outerHeight();
			mutiscrollWrapp.height(winH - headerHeight - footerHeight);
		}

		multiscrollHeight = mutiscrollWrapp.height();

		if ((winW > 0 && winW < 480) || (winW > 767 && winW < 992)) {
			multiscrollLeft.height(multiscrollHeight / 2);
			multiscrollRight.height(multiscrollHeight / 2);
		} else if ((winW > 991) || (winW > 479 && winW < 768)) {
			multiscrollLeft.height(multiscrollHeight);
			multiscrollRight.height(multiscrollHeight);
		}

		mutiscrollWrapp.multiscroll({
			verticalCentered: false,
			scrollingSpeed: parseInt(mutiscrollWrapp.attr('data-speed'), 10),
			easing: 'easeInQuart',
			menu: false,
			navigation: false,
			loopBottom: parseInt(mutiscrollWrapp.attr('data-loop'), 10),
			loopTop: parseInt(mutiscrollWrapp.attr('data-loop'), 10),
			keyboardScrolling: parseInt(mutiscrollWrapp.attr('data-keyboard'), 10),
			touchSensitivity: 50,
			sectionSelector: '.ms-section',
			leftSelector: '.ms-left',
			rightSelector: '.ms-right'
		});

		mutiscrollWrapp.find('.ms-section').removeClass('active');
		mutiscrollWrapp.find('.ms-right .ms-section').last().addClass('active');
        mutiscrollWrapp.find('.ms-left .ms-section').first().addClass('active');
	}

	function multiScrollControls() {
		$('.scroll-btn.down').on('click', function () {
			$.fn.multiscroll.moveSectionDown();
		});
		$('.scroll-btn.up').on('click', function () {
			$.fn.multiscroll.moveSectionUp();
		});
	}

	/**********************************/
	/* SKILLS */
	/**********************************/

	$(window).on('scroll', function () {
        if ($('.skills').length) {
            $('.skills').not('.active').each(function () {

                if ($(window).scrollTop() >= $(this).offset().top - $(window).height() * 1) {
                    $(this).addClass('active');
                    $(this).find('.skill').each(function () {
                        var procent = $(this).attr('data-value');
                        $(this).find('.active-line').css('width', procent + '%');
                        $(this).find('.counter').countTo();
                    });
                }
            });
        }

    });

	/**********************************/
	/* THUMB FLEX SLIDER */
	/**********************************/
	$(window).on('resize', function () {
		portfolioSliderHeight();
		if ($('.thumb-slider-wrapp').length) {
			initThumbFlexSlider();
		}
	});

	window.addEventListener('orientationchange', function () {
		portfolioSliderHeight();
		if ($('.thumb-slider-wrapp').length) {
			initThumbFlexSlider();
		}
	});

    function initThumbFlexSlider() {

		var winW = $(window).width(),
		    winH = $(window).innerHeight(),
		    innerWinH = $(window).height(),
		    thumbSliderWrapp = $('.thumb-slider-wrapp'),
		    headerHeight = $('.header_top_bg').not('.header_trans-fixed').outerHeight(),
		    footerHeight = $('#footer').not('.fix-bottom').outerHeight();

		thumbSliderWrapp.innerHeight(winH - headerHeight - footerHeight);

        $('.main-thumb-slider').flexslider({
            animation: "fade",
            animationSpeed: 600,
            controlNav: false,
            animationLoop: false,
            slideshow: false,
            sync: ".sub-thumb-slider"
        });

        $('.sub-thumb-slider').flexslider({
            animation: "slide",
            animationSpeed: 600,
            controlNav: false,
            animationLoop: true,
            direction: "horizontal",
            slideshow: false,
            itemWidth: 180,
            itemMargin: 5,
            mousewheel: true,
            asNavFor: '.main-thumb-slider'
        });

    }

    $('.thumb-slider-wrapp-arrow').on('click', function() {
        $(this).toggleClass('active').parent().find('.sub-thumb-slider').toggleClass('active');
    });


    /* Share */

    $('[data-share]').on('click',function(){

    	var w = window,
    		url = this.getAttribute('data-share'),
    		title = '',
    		w_pop = 600,
    		h_pop = 600,
    		scren_left = w.screenLeft != undefined ? w.screenLeft : screen.left,
    		scren_top = w.screenTop != undefined ? w.screenTop : screen.top,
    		width = w.innerWidth,
    		height = w.innerHeight,
    		left = ((width / 2) - (w_pop / 2)) + scren_left,
    		top = ((height / 2) - (h_pop / 2)) + scren_top,
    		newWindow = w.open(url, title, 'scrollbars=yes, width=' + w_pop + ', height=' + h_pop + ', top=' + top + ', left=' + left);

    	if (w.focus) {
    	    newWindow.focus();
    	}

    	return false;
    });

    // for sound bg
    $('.napoli-sound-btn').on('click',function(){

    	var $button = $(this);
    	if ($button.hasClass('play')) {
    		$button.next('audio').trigger('pause');
    		$button.removeClass('play');
    	} else {
    		$button.next('audio').trigger('play');
    		$button.addClass('play');
    	}

    });

    /* Copyright */
    if ($('.napoli_copyright_overlay').length) {
    	$(document).on('contextmenu',function(event){
			if($('.napoli_copyright_overlay').hasClass('copy')){
				event.preventDefault();
			}else if(event.target.tagName != 'A'){
				event.preventDefault();
			}
				$('.napoli_copyright_overlay').css({
					'left': event.pageX,
					'top' : event.pageY
				}).addClass('active');
    	}).on('click', function(){
    		$('.napoli_copyright_overlay').removeClass('active').removeAttr('style');
    	});
    }




function portfolioFilter() {
	// init Isotope
	var $grid = $('.albums-left-filter .portfolio .wpb_wrapper').isotope({
		itemSelector: '.element-item',
		layoutMode: 'fitRows'
	});
// filter functions
	var filterFns = {
		// show if number is greater than 50
		numberGreaterThan50: function() {
			var number = $(this).find('.number').text();
			return parseInt( number, 10 ) > 50;
		},
		// show if name ends with -ium
		ium: function() {
			var name = $(this).find('.name').text();
			return name.match( /ium$/ );
		}
	};
// bind filter button click
	$('.albums-left-filter .filters-button-group').on( 'click', 'button', function() {
		var filterValue = $( this ).attr('data-filter');
		// use filterFn if matches value
		filterValue = filterFns[ filterValue ] || filterValue;
		$grid.isotope({ filter: filterValue });

		$("img[data-lazy-src]").foxlazy();
		wpc_add_img_bg('.s-img-switch');
	});
// change is-checked class on buttons
	$('.albums-left-filter .button-group').each( function( i, buttonGroup ) {
		var $buttonGroup = $( buttonGroup );
		$buttonGroup.on( 'click', 'button', function() {
			$buttonGroup.find('.is-checked').removeClass('is-checked');
			$( this ).addClass('is-checked');
		});
	});
}

if($('.filmstrim-gallery-outer.no1').length){
	$('.fullview').css('display', 'none');
}


	/**********************************/
	/* PORTFOLIO SLIDER FULL HEIGHT */
	/**********************************/

	function portfolioSliderHeight() {
		var headerH = $('.header_top_bg:not(.header_trans-fixed)').length ? $('.header_top_bg:not(.header_trans-fixed)').outerHeight() : 0,
		footerH = $('#footer:not(.fix-bottom)').length ? $('#footer:not(.fix-bottom)').outerHeight() : 0,
		sliderH = $(window).height() - (headerH + footerH);

		$('.portfolio-slider-wrapper.slider_simple .images-slider-wrapper .images-one').height(sliderH);
		$('.portfolio-slider-wrapper.slider_simple').height(sliderH);

	$('.main-header-testimonial.simpple .swiper-slide').css('height', 'auto').equalHeights();


	}
	portfolioSliderHeight();

	/**********************************/
	/* POPUP DETAILS */
	/**********************************/

	// popup form
	$(".popup-details").fancybox({
		arrows: true,
		loop: true
	});

	$('.gallery-item.slip').parent().parent().sliphover({
		caption : 'data-content',
		target: '.info-content'
	});

	if ($('#back-to-top').length) {
		var scrollTrigger = 100, // px
			backToTop = function () {
				var scrollTop = $(window).scrollTop();
				if (scrollTop > scrollTrigger) {
					$('#back-to-top').addClass('show');
				} else {
					$('#back-to-top').removeClass('show');
				}
			};
		backToTop();
		$(window).on('scroll', function () {
			backToTop();
		});
		$('#back-to-top').on('click', function (e) {
			e.preventDefault();
			$('html,body').animate({
				scrollTop: 0
			}, 700);
		});
	}

	$('.portfolio-load-more').on('click', function () {
		var count = $(this).data('num'),
			counter = 0;
		$(this).closest('.counter-wrap-port').find('.item-single:not(.count-show)').each(function () {
			if(counter < count){
				$(this).addClass('count-show');
			}
			counter++;
		});
		if(!$(this).closest('.counter-wrap-port').find('.item-single:not(.count-show)').length){
			$(this).hide();
		}

		initIsotop();

		event.preventDefault();
	});
	

	function pageLoad() {
		var loc = window.location.href;
		$('.filter li a').each(function () {
			var href = $(this).attr('href');
			if (href === loc) {
				$('.filter li.active').removeClass('active');
				$(this).parent().addClass('active');
			}
		});
	}

	pageLoad();


})(jQuery, window, document);


