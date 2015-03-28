(function ($) {

	function displayVideoItems(){
		var images = $('.video-items-loaded img');
    	var imagesLoaded = 0;
    	$('.video-items-loaded').removeClass('video-items-loaded');
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
			event.preventDefault();
			$('.content-video .content-image-video iframe').attr('src',urlVideo);
			var body = $("html, body");
			body.animate({scrollTop:0}, '100', 'swing', function() {}); 
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

			jQuery.get(
			    GacetaAjax.ajaxurl, 
			    {
			        'action': 'load_more_posts',
			        'security':   GacetaAjax.security,
			        'category': category,
			        'taxonomy': taxonomy,
			        's': s,
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
			    	$(This).attr('data-offset', response.offset);
			    	addVideoTrigger();
			    	displayVideoItems();
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
			    	$('#load-more-videos').attr('data-offset', response.offset);
			    	$('#load-more-videos').attr('data-category', category);
			    	displayVideoItems();
			    },
			    'json'
			);
		});

	});
})(jQuery);
