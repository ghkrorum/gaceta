var noticeBelt; // Declare expoForm variable in global scope
(function ($) {

  	function NoticeBelt(){
		var This = this;
		this.isExpanded = false;
		
		this.init = function(){ 
			$(document).ready(function(){
				$('#notices-trigger').click(function(event){
					event.preventDefault();
					This.evalShow();
				});
				$(window).resize(This.updatePosition);
				$(window).scroll(This.updatePosition);
			});
		};

		this.evalShow = function(){
			if (!This.isExpanded){
				This.showNotices();
			}else{
				This.closeNotices();
			}
		}

		this.showNotices = function(){
			This.isExpanded = true;
			This.updatePosition();
		};

		this.closeNotices = function(){
			This.isExpanded = false;
			This.updatePosition();
		};

		this.updatePosition = function(){
			var windowWidth = $(window).width();
			var windowHeight = $(window).height();
			var top = $(document).scrollTop();
			var beltHeight = $('.footer-notices').height();
			var pos = 0;
			$('#notices-iframe').css('left', '0px');
			if (!This.isExpanded){
				pos = windowHeight + top - beltHeight;
				$('.footer-notices').css('top', pos+'px');
			}else{
				pos = top;
				$('.footer-notices').css('top', pos+'px');
				$('#notices-iframe').width(windowWidth);
				var iframeHeight = windowHeight - beltHeight
				$('#notices-iframe').height(iframeHeight);
				$('#notices-iframe').css('display', 'block');
			}
		};

		this.init(); // Call when instance is created
	}

	noticeBelt = new NoticeBelt(); // Crate instance of NoticeBelt
    
})(jQuery);
