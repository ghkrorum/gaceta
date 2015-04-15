function resizeFullGalleryImages(){
	if ( typeof galleryImages != 'undefined'){
		var windowHeight = jQuery(window).height();
		var headerHeight = jQuery('.content-logo').height();
		var contentWidth = jQuery('#gallery-slider').width();
		var contentOffset = jQuery('#gallery-slider').offset();


		var contentHeight = windowHeight - contentOffset.top;

		if (contentWidth < 640){
			contentHeight = 250;
		}
		jQuery('#gallery-slider').height(contentHeight);
	
		for (key in galleryImages){

			var img = galleryImages[key];
			
			var imgWidth = (img[1] * contentHeight) / img[2];
			
			var avg = (100 * imgWidth) / img[1];

			var imgHeight = (avg * img[2]) / 100;

			jQuery(img).width(imgWidth);
								
			jQuery(img).height(imgHeight);

			if (img[1] > img[2] && imgWidth > contentWidth){
				var marginLeft = (imgWidth - contentWidth) / 2;
				jQuery(img).css('margin-left', -marginLeft+'px');
			}else{
				jQuery(img).css('margin-left', 'auto');
			}
		}

	}
}



function resizeSliderImages(){
	if ( typeof sliderImages != 'undefined'){
		var postSlideWidth = 640;
		var postSlideHeight = 450;
		
		var contSlideWidth = jQuery('.post-slider-cont').width();

		var contSlideHeight = (postSlideHeight * contSlideWidth) / postSlideWidth;
		jQuery('#post-slideshow').height(contSlideHeight);
		jQuery('.post-slider-cont').height(contSlideHeight);
		

		for (key in sliderImages){
			var img = sliderImages[key];

			var imgWidth = (img[1] * contSlideHeight) / img[2];
			var avg = (100 * imgWidth) / img[1];

			var imgHeight = (avg * img[2]) / 100;

			var imgHeight = (img[2] * imgWidth) / img[1];

			jQuery(img).width(imgWidth);
			jQuery(img).height(contSlideHeight);


			if (img[1] > img[2] && imgWidth > contSlideWidth){
				var marginLeft = (imgWidth - contSlideWidth) / 2;
				jQuery(img).css('margin-left', -marginLeft+'px');
			}else{
				jQuery(img).css('margin-left', 'auto');
			}
		}
	}
}

function setupVideoTrigger(){
		//videos
	jQuery('.video-items-loaded .category-posts-item a').click(function(event) {
		var urlVideo = jQuery(this).attr('href');

		event.preventDefault();
		jQuery('.content-video .content-image-video iframe').attr('src',urlVideo);
		jQuery('.sub-title').html(videoTitle);
		var body = jQuery("html, body");
		body.animate({scrollTop:0}, '100', 'swing', function() {}); 
	});
	jQuery('.video-items-loaded').removeClass('video-items-loaded');
	jQuery('.video-post .category-posts-item a').click(function(event) {
		var urlVideo = jQuery(this).attr('href');
		var title = jQuery(this).attr('data-title');
		event.preventDefault();
		jQuery('.content-video .content-image-video iframe').attr('src',urlVideo);
		jQuery('.sub-title').html(title);
	});
    jQuery('.video-list .video-list-item a').click(function(event){
    	var urlVideo = jQuery(this).attr('href');
    	var videoTitle = jQuery(this).attr('data-title');
		console.log(this);
        event.preventDefault();
        jQuery('.section-4 .video iframe').attr('src',urlVideo);
    });
}


(function ($) {

	var site_id = '4efdcb14b7f4b2404cc3c53475fc2bb0';
    var page_config = {"apps":{"share_buttons":{"get_share_counts":  function(url, services, cb) {
    Shareaholic.Utils.ajax({
      cache: true,
      cache_ttl: '1 minute',
      url: 'http://gaceta-new.loc/wp-admin/admin-ajax.php',
      data: { action: 'shareaholic_share_counts_api', url: url, services: services },
      success: function(res) {
        if(res && res.data) {
          cb(res.data, true);
        }
      }
    })
  }}},"endpoints":{"local_recs_url":"http:\/\/gaceta-new.loc\/wp-admin\/admin-ajax.php?action=shareaholic_permalink_related","share_counts_url":"http:\/\/gaceta-new.loc\/wp-admin\/admin-ajax.php?action=shareaholic_share_counts_api"},"user":[]};
  	

	function getUrlParameter(sParam)
	{
	    var sPageURL = window.location.search.substring(1);
	    var sURLVariables = sPageURL.split('&');
	    for (var i = 0; i < sURLVariables.length; i++) 
	    {
	        var sParameterName = sURLVariables[i].split('=');
	        if (sParameterName[0] == sParam) 
	        {
	            return sParameterName[1];
	        }
	    }
	}  

	function initMainSlider(){
		var windowWidth = $(window).width();
		$('#top-main-slider').css('width', '100%');
		$('#top-main-slider').css('margin-left', '0');
		$('#top-main-slider').addClass('slider-movil');
		if (windowWidth < 640){
			$('#top-main-slider').cycle({
				swipeFx: 'scrollHorz',
			    timeout: 0,
			    next: '.slider-next',
			    prev: '.slider-prev',
			    swipe: true,
			    slides: '> div',
			    pager: '#carousel-nav'
			});
		}else{
			$('#top-main-slider').removeClass('slider-movil');
			$('#top-main-slider').css('width', '120%');
			$('#top-main-slider').css('margin-left', '-10%');
			var visibleSlides = $('#top-main-slider').attr('data-slides');

			$('#top-main-slider').cycle({
			    fx: 'carousel',
			    timeout: 3500,
			    next: '.slider-next',
			    prev: '.slider-prev',
			    'carouselVisible': visibleSlides,
			    'allow-wrap': true,
			    'carouselFluid': true,
			    slides: '> div'
			});
		}
	}

	$(document).ready(function(){
		resizeSliderImages();
		resizeFullGalleryImages();
		// $('.container-fluid.galeria').resize(function(e){
		// 	// $('.content-sidebar').height($(this).height());
		// });
		$('.header-search .search').hover(
			function(){
				$('#SearchForm').css('width',160);
			},
			function(){
				$('#SearchForm').css('width',0);
			}
		);

		$('.header-search #SearchForm').hover(function(){
			$(this).css('width',160);
		});

		$('.header-search .search').click(function(){
			$('#SearchForm').css('width',0);
		});

		// $('.main-slider-cont').slick({
	 //        adaptiveHeight: true,
	 //        variableWidth: true,
	 //        centerMode: true,
	 //        autoplay: true,
	 //        infinite: true,
	 //        slidesToShow: 3,
	 //        slidesToScroll: 1,
	 //        prevArrow: '.slider-prev',
	 //        nextArrow: '.slider-next'
	 //    });

	    $('.header-menu li').hover(
	    	function(){
	    		$(this).children('.header-submenu').css('display', 'block');
	    	},
	    	function(){
				$(this).children('.header-submenu').css('display', 'none');
	    	}
	    );
        
	    $('.header-menu li:nth-last-child(4)').hover(
	    	function(){
	    		$(this).children('.header-submenu').css('left', -44+'px');
	    });

	    $('.header-menu li:nth-last-child(3)').hover(
	    	function(){
	    		$(this).children('.header-submenu').css('left', -30+'px');
	    });
        $('.header-menu li:nth-last-child(2)').hover(
	   		function(){
	    		$(this).children('.header-submenu').css('left', -15+'px');
	    });

	    $('.uparrow a').click(function(event){
	    	event.preventDefault();
	    	var body = $("html, body");
			body.animate({scrollTop:0}, '100', 'swing', function() { 
			});
	    });

	    $('.footer-newsletter-btn').click(function(event){
	    	event.preventDefault();
	    	$('#newsletter-submit').trigger('click');
	    });

	    $( '#top-main-slider' ).on( 'cycle-initialized', function( event, optionHash, outgoingSlideEl, incomingSlideEl, forwardFlag ) {
	    	$( ".cycle-slide-active" ).next('.slide').find('.slide-txt').fadeIn();
		});

	    $( '#top-main-slider' ).on( 'cycle-before', function( event, optionHash, outgoingSlideEl, incomingSlideEl, forwardFlag ) {
	    	$( ".cycle-carousel-wrap .slide-txt" ).fadeOut();
		});

		

	    $( '#top-main-slider' ).on( 'cycle-after', function( event, optionHash, outgoingSlideEl, incomingSlideEl, forwardFlag ) {
	    	$( ".cycle-carousel-wrap .cycle-slide-active" ).next('.slide').find('.slide-txt').fadeIn();
		});


// data-cycle-fx=carousel
// data-cycle-timeout="5000"
// data-cycle-next=".slider-next"
// data-cycle-prev=".slider-prev"
// data-cycle-carousel-visible="3"
// data-allow-wrap="true"
// data-cycle-carousel-fluid=true
// data-cycle-slides="> div"
		
		
		$( '#top-main-slider' ).on( 'cycle-destroyed', function( event, optionHash, outgoingSlideEl, incomingSlideEl, forwardFlag ) {
			
			// initMainSlider();
		});

		

	    var loadCarousel = false;
		var loadCycle = true;

		var windowWidth = $(window).width();

		if (windowWidth >= 640){
			loadCarousel = true;
			loadCycle = false;
		}
		

		$(window).resize(function() {

			var windowWidth = $(window).width();

			resizeSliderImages();
			
			resizeFullGalleryImages();
			
			
			if (windowWidth < 640 && loadCycle){
				
				loadCycle = false;
				loadCarousel = true;
				 if ( $('#top-main-slider').data('cycle.opts') !== undefined ){
					$('#top-main-slider').cycle('destroy');
					initMainSlider();
				}
				
			}else if (windowWidth >= 640 && loadCarousel){
				
				loadCarousel = false;
				loadCycle = true;
				if ( $('#top-main-slider').data('cycle.opts') !== undefined ){
					$('#top-main-slider').cycle('destroy');
				}
				
				initMainSlider();
			}

		});

		$( '#post-slideshow' ).on( 'cycle-initialized', function( event, optionHash) {
		    resizeSliderImages();
		});


		$('#post-slideshow').cycle({
				fx: 'scrollHorz',
				swipeFx: 'scrollHorz',
			    timeout: 0,
			    caption: '#cycle-caption',
			    captionTemplate: "<span class='active gotham-bold'>{{slideNum}} </span><span class='total-img gotham-book'>/ {{slideCount}}</span>",
			    next: '#post-slide-next',
			    prev: '#post-slide-prev',
			    swipe: true,
			    slides: '> div',
			    pager: '#carousel-nav'
			});
		
		$( '#post-slideshow' ).on( 'cycle-before', function( event, optionHash, outgoingSlideEl, incomingSlideEl, forwardFlag ) {
		    resizeSliderImages();
		});


	    $( '#post-slideshow' ).on( 'cycle-after', function( event, optionHash, outgoingSlideEl, incomingSlideEl, forwardFlag ) {
		    var caption = $(incomingSlideEl).children('.post-slideshow-item-caption').html();
		    var description = $(incomingSlideEl).children('.post-slideshow-item-description').html();
		    $('#post-slider-caption').html(caption);
		    $('#post-slider-description').html(description);
		});

		$('#post-slider-carousel img').click(function(){
		    var index = $('#post-slider-carousel').data('cycle.API').getSlideIndex(this);
		    $('#post-slideshow').cycle('goto', index);
		});

		var hash = window.location.hash.substring(1);

		if (hash.length == 0){
			hash = 1;
		}
		

		$( '#gallery-slider' ).on( 'cycle-initialized', function( event, optionHash, outgoingSlideEl, incomingSlideEl, forwardFlag ) {
			$('#gallery-slider').cycle('goto', parseInt(hash) - 1 );
			$('.share-1').css('display', 'block');
		});

		$( '#gallery-slider' ).on( 'cycle-after', function( event, optionHash, outgoingSlideEl, incomingSlideEl, forwardFlag ) {
			
			window.location.hash = optionHash.slideNum;

			$('.shareaholic-canvas').css('display', 'none');

			$('.share-'+optionHash.slideNum).css('display', 'block');

			
		    var htmlCaption = $(incomingSlideEl).children('.gallery-item-caption').html();
		    $('.footer-galery').html(htmlCaption);
		    var htmlDescription = $(incomingSlideEl).children('.gallery-item-description').html();
		    $('.description-galery').html(htmlDescription);
		});


		$('#gallery-slider').cycle({
			swipe: true,
			swipeFx: 'scrollHorz',
			fx: 'scrollHorz',
		    timeout: 0,
		    pager: '#carousel-nav',
		    caption: '#gallery-caption',
		    next: '#gallery-next',
		    prev: '#gallery-prev',
		    captionTemplate: "<span class='active gotham-bold'>{{slideNum}} </span><span class='total-img gotham-book'>/ {{slideCount}}</span>",
		    slides: '> div',
		});

		$('#show-slider-carousel').click(function(event){
			event.preventDefault();
			var carouselVisibility = $('#post-slider-carousel-cont').css('visibility');
			var carouselDisplay = $('#post-slider-carousel-cont').css('display');
			if ( carouselVisibility == 'visible' && carouselDisplay == 'block' ){
				$('#post-slider-carousel-cont').slideUp();
			}else{
				$('#post-slider-carousel-cont').css('visibility', 'visible');
				$('#post-slider-carousel-cont').css('margin', '0');
				$('#post-slider-carousel-cont').css('display', 'none');
				$('#post-slider-carousel-cont').slideDown();
			}
		});

		//cita Social
		$('#cita-twitter-btn').click(function(event){
			event.preventDefault();
			$url = $(this).attr('href');
			window.open($url, "", "width=550, height=420, location=no, scrollbars=no");
		});

		//menu avisos
		$('.header-menu a').click(function(){
			$('.header-menu a').removeClass('active');
			$(this).addClass('active');
		});

	    //Avisos hover
		$('.section-avisos .category-posts-item .content-image').hover(function(){
	        $(this).addClass('active');
			$('.section-avisos .active .more-btn-content').css('display','block');
		},
		function(){
			$(this).removeClass('active');
			$('.section-avisos .more-btn-content').css('display','none');
		});

		//modal
		$('.modalmask').click(function(){
			$(location).attr('href', '#close');
		});
	     //Antes de redimensionar
		var ventana_ancho = $(window).width();
	    var ventana_alto = $(window).height();
	    if(ventana_ancho>480){
		    var widthSlide=ventana_ancho-350;
		     /*Cuando se Redimensiona el navegador*/
		    $('.width-slider').css('width',widthSlide);
		    $('.galeria .post-col1 .post-slider .post-slider-wrap').css('width',widthSlide);
		    $('.galeria .post-col1').css('height',ventana_alto-15);
		    // $('.galeria .content-sidebar').css('height',ventana_alto-15);
	    }

	    //Redimensionando pantalla
		$(window).resize(function() {
			var ventana_ancho = $(window).width();
		    var ventana_alto = $(window).height();

		    if (ventana_ancho > 767){
			    var sidebarHeight = $('.post-slider-bottom').height();
			    var sliderHeight = $('.width-slider').height();
			    

			    if (sidebarHeight <= ventana_alto){
			    	if (ventana_alto > sliderHeight){
			    		$('.content-sidebar').css('height', ventana_alto+'px');
			    	}else{
			    		$('.content-sidebar').css('height', sliderHeight+'px');
			    	}
			    }else{
			    	if (ventana_alto < sidebarHeight){
			    		$('.content-sidebar').css('height', 'auto');
			    	}
			    }

			    var galleryBannerOffset = $('.aside-galery').offset();

			   	if ( typeof galleryBannerOffset != 'undefined'){
			   		var galleryBannerBtmOffset = 250 + galleryBannerOffset.top;
			   		
			   		if (galleryBannerBtmOffset > ventana_alto){
			   			$('.aside-gallery-banner').css('display', 'none');
			   		}else{
			   			$('.aside-gallery-banner').css('display', 'block');
			   		}
			   	}
			}

		    



		   	// console.log(galleryBannerOffset);

		    var widthSlide=ventana_ancho-350;
		    if($(window).width()>767){
		     /*Cuando se Redimensiona el navegador*/
		        $('.width-slider').css('width',widthSlide-2);
			    $('.galeria .post-col1 .post-slider .post-slider-wrap').css('width',widthSlide);
			    $('.width-sidebar').css('width',350+"px");
			    $('.galeria .post-col1').css('height','auto');
				// $('.galeria .content-sidebar').css('height',ventana_alto-15);
			}
			else{
				$('.width-slider').css('width',100+'%');
				$('.galeria .post-col1 .post-slider .post-slider-wrap').css('width',100+'%');
				$('.width-sidebar').css('width',100+'%');
				$('.post-col1').css('height','auto');
				// $('.content-sidebar').css('height','auto');

			} 
		});
		//menu movil
		$('.navbar-header .navbar-toggle').click(function(){
			if($('.navbar-header button').hasClass('false')){
				$(this).removeClass('false');
				$('.menu-mobile .content-menu').css({'height': ventana_alto,'display':'block'});
				$('.menu-mobile .modal-mobil').css({'height': ventana_alto,'opacity':0.72});
				$('.shareaholic-share-buttons-container').css('position','relative');
				$('.menu-mobile .content-nav').css('display','block');
				$('.menu-mobile .header-search').css('display','none');
			}else{
	            $('.menu-mobile .content-menu').css('display','none');
	            $('.shareaholic-share-buttons-container').css('position','');
	            $('.menu-mobile .modal-mobil').css({'opacity':0});
	            $('.navbar-header button').addClass('false');
	            $('.search').addClass('false');
			}
		});
		//Close-menu
		$('.close-menu').click(function(){
	        $('.menu-mobile .content-menu').css('display','none');
	        $('.shareaholic-share-buttons-container').css('position','');
	        $('.menu-mobile .modal-mobil').css({'opacity':0});
	        $('.navbar-header button').addClass('false');
	        $('.search').addClass('false');
		});
		//search
		$('.search').click(function(){
	        if($(this).hasClass('false')){
				$(this).removeClass('false');
				$('.menu-mobile .content-menu').css({'height': ventana_alto,'display':'block'});
				$('.menu-mobile .modal-mobil').css({'height': ventana_alto,'opacity':0.72});
				$('.shareaholic-share-buttons-container').css('position','relative');
				$('.menu-mobile .content-nav').css('display','none');
				$('.menu-mobile .header-search').css('display','block');
			}else{
	            $('.menu-mobile .content-menu').css('display','none');
	            $('.menu-mobile .header-search').css('display','none');
	            $('.menu-mobile .modal-mobil').css({'opacity':0});
	            $('.shareaholic-share-buttons-container').css('position','');
	            $('.menu-mobile .content-nav').css('display','block');
	            $('.search').addClass('false');
	            $('.navbar-header button').addClass('false');
			}
		});

		 //when scroll
	    /*if(ventana_ancho>600){
		    $(window).scroll(function(){
		    	var offset = $('.header .content-nav').offset();
		    	if ( typeof offset != 'undefined' ){
		            var test = $('.header .content-nav').offset().top;
		            //console.log(test);
			        if (($(window).scrollTop()) == test){
			            $('.header').css({"position":"fixed", 'z-index': 1600, 'padding-bottom':17+'px'});
			            $('.mobil-hidden').css('display','block');
			            $('.screen-hidden').css('display','none');
			            $('.header-position .header-submenu').css('padding-top',14+'px');
			            $('.redes-sociales-header, .top-belt').css('display','none');
			            $('.header-position .content-image').addClass('scroll-menu');
			            $('.header-position .content-nav').css('border', 'none');
			            $('.header-position .content-image img').removeClass('header-logo');
			        } else {
			            $('.header-position .content-image').removeClass('scroll-menu');
			        }
			    }
		    });
		}*/

		setupVideoTrigger();
		
	    //Thumbnail galeria
	    
	    $('.post-slider-bottom .content-img').click(function() {
	    	var thumbnailDisplay = $('.galeria .thumbnail-galery').css('display');
	    	if (thumbnailDisplay == 'block'){
	    		$('.galeria .thumbnail-galery').css('display', 'none');
				$('.galeria .gallery-slider-cont').css('display', 'block');	
	    	}else{
				$('.galeria .thumbnail-galery').css('display', 'block');
				$('.galeria .gallery-slider-cont').css('display', 'none');
			}
		});

		$('.thumbnail-galery li').click(function() {
			$('.galeria .gallery-slider-cont').css('display', 'block');
			$('.galeria .thumbnail-galery').css('display', 'none');
			$('#gallery-slider').cycle('goto', $(this).attr( 'data-index' ) );
		});

		$(window).trigger('resize');
		initMainSlider();

	});
	
})(jQuery);


if (typeof newsletter_check !== "function") {
window.newsletter_check = function (f) {
    var re = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-]{1,})+\.)+([a-zA-Z0-9]{2,})+$/;
    if (!re.test(f.elements["ne"].value)) {
        alert("The email is not correct");
        return false;
    }
    if (f.elements["ny"] && !f.elements["ny"].checked) {
        alert("You must accept the privacy statement");
        return false;
    }
    return true;
}
}
