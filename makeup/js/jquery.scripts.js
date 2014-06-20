$(function() {
	
	/*$('#videos .video').stickem();*/
	
	var $grid = $('#grid');

	$grid.isotope({
		itemSelector: '.item',
		layoutMode: 'masonry',
		masonry: {
			gutter: 15
		}
	});
	
	$(window).scroll(function() {
		if( $(window).scrollTop() > 114 )
		{
			$('#wrapper').addClass('nav-fixed');
		}
		else $('#wrapper').removeClass('nav-fixed');
	});
	
	//$('#videos .video').sticky();
	//$('#books .books').sticky();
});


(function($) {

	$.fn.sticky = function(options) {
		
		options = {
			container : '.stickem-container',
			sticky : '.stickem'
		};
		
		return this.each(function() {
			
			var $container = $(this);
			var $sticky = $container.find(options.sticky);
			
			var _resize = function(e) {
				$sticky.css({ width: 'auto', position: 'static' }).width($sticky.width()).css('position', '');
			};
			
			var _scroll = function() {
 
				var windowTop = $(window).scrollTop();
				
				_bottom = $container.offset().top + $container.height() - $sticky.height() - 30;
			 
				if( $container.offset().top <= windowTop && _bottom >= windowTop )
				{
					$sticky.removeClass('bottom').addClass('fixed');
				}
				else if( $container.offset().top <= windowTop && _bottom <= windowTop )
				{
					$sticky.removeClass('fixed').addClass('bottom');
				}
				else
				{
					$sticky.removeClass('fixed').removeClass('bottom');
				}
		 
			};
			
			$(window).scroll(_scroll).resize(function() { _resize(); _scroll(); });
			
			_resize();
			
		});
	};

})(jQuery);