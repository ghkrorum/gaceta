(function ($) {

	function displayVideoItems(){
		var images = $('.video-items-loaded img');
    	var imagesLoaded = 0;
    	
    	$(images).each( function(index){
    		$(this).bind('load', function(){
				imagesLoaded++;
				if ( imagesLoaded ==  images.length ){
					$('.category-posts-item').each(function(index){
						$(this).delay(200*index).fadeIn();
					});

				}
    		})
    	});
	}

	function addVideoTrigger(){
		$('.video-items-loaded .category-posts-item a').click(function(event) {
			var urlVideo = $(this).attr('href');
			var videoTitle = $(this).attr('data-title');
			event.preventDefault();
			$('.content-video .content-image-video iframe').attr('src',urlVideo);
			$('.sub-title').html(videoTitle);
			var body = $("html, body");
			body.animate({scrollTop:0}, '100', 'swing', function() {}); 
			var item = $(this).attr('data-item');
			evalVideoShareShow(item);
		});
	}

	$(document).ready(function(){

		$('.load-more-posts').click(function(event){
			event.preventDefault();
			var This = this;
			var offset = $(this).attr('data-offset');
			var category = $(this).attr('data-category');
			var taxonomy = $(this).attr('data-taxonomy');
			var s = $(this).attr('data-s');
			var tag = $(this).attr('data-t');

			jQuery.get(
			    GacetaAjax.ajaxurl, 
			    {
			        'action': 'load_more_posts',
			        'security':   GacetaAjax.security,
			        'category': category,
			        'taxonomy': taxonomy,
			        's': s,
			        'tag': tag,
			        'offset':   offset
			    }, 
			    function(response){
			    	$('#general-posts').append(response.content);
			    	$(This).attr('data-offset', response.offset);
			    },
			    'json'
			);
		});

		$('#load-more-videos').click(function(event){
			event.preventDefault();
			var This = this;
			var offset = $(this).attr('data-offset');
			var category = $(this).attr('data-category');

			$.get(
			    GacetaAjax.ajaxurl, 
			    {
			        'action': 'load_more_videos',
			        'security':   GacetaAjax.security,
			        'category': category,
			        'offset':   offset
			    }, 
			    function(response){
			    	$('#videos-list-cont').append(response.content);
			    	$('.redes-sociales').append(response.share);
			    	$(This).attr('data-offset', response.offset);
			    	Shareaholic.init();
			    	addVideoTrigger();
			    	displayVideoItems();
			    	$('.video-items-loaded').removeClass('video-items-loaded');
			    },
			    'json'
			);
		});


		//Menú videos
		$('#videos-menu a').click(function(event){
			event.preventDefault();
			var category = $(this).attr('data-category');
			jQuery.get(
			    GacetaAjax.ajaxurl, 
			    {
			        'action': 'load_more_videos',
			        'security':   GacetaAjax.security,
			        'category': category,
			        'offset': 0
			    }, 
			    function(response){
			    	$('#videos-list-cont').html(response.content);
			    	$('.redes-sociales').html(response.share);
			    	$('#load-more-videos').attr('data-offset', response.offset);
			    	$('#load-more-videos').attr('data-category', category);
			    	Shareaholic.init();
			    	evalVideoShareShow(0);
			    	displayVideoItems();
			    	setupVideoTrigger();
			    },
			    'json'
			);
		});

	});
})(jQuery);
