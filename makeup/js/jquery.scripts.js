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
	
	if( $('.nav-panel').length )
	{
		var $navPanel = $('.nav-panel');
		
		$(window).bind("resize scroll", function() {
			if( $(window).scrollTop() + 72 > $navPanel.offset().top )
				$navPanel.addClass('fixed');
			else $navPanel.removeClass('fixed');
		});
	}
	
	$('#videos .video').sticky({
		offset: 72 + 40
	});
	//$('#books .books').sticky();
});


(function($) {

	$.fn.sticky = function(options) {
		
		options = $.extend({
			container : '.stickem-container',
			sticky : '.stickem',
			offset: 0
		}, options);
		
		return this.each(function() {
			
			var $container = $(this);
			var $sticky = $container.find(options.sticky);
			
			var _resize = function(e) {
				$sticky.css({ width: 'auto', position: 'static' }).width($sticky.width()).css('position', '');
			};
			
			var _scroll = function() {
				
				if( $container.height() - 30 == $sticky.height() )
				{
					$sticky.removeClass('fixed').removeClass('bottom');
					console.log('lol');
					return;
				}
 
				var windowTop = $(window).scrollTop();
				
				_bottom = $container.offset().top - options.offset + $container.height() - $sticky.height() - 30;
			 
				if( $container.offset().top - options.offset <= windowTop && _bottom >= windowTop )
				{
					$sticky.removeClass('bottom').addClass('fixed');
				}
				else if( $container.offset().top - options.offset <= windowTop && _bottom <= windowTop )
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