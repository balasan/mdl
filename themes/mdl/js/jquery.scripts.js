function showPage(el)
{
	$('.page-excerpt').slideUp('fast', function() {
		$('.page-excerpt-full').slideDown('slow', function() {
			$('.page-read-more').slideUp('fast');
		});
	});
	
	return false;
};

$(window).load(function() {
	var $container = $('#grid');
	
	$container.isotope({
		itemSelector: '.item',
		layoutMode: 'masonry',
		masonry: {
			gutter: ".gutter-sizer"
		}
	}).find('.post').removeClass('hide');
	
	/*$container.find('.item').each(function() {
		$(this).find('.display').css( 'top', ($container.find('.item').innerHeight() - $(this).find('.display').innerHeight()) / 2 );
    });*/
});

$(function() {
	
	$('#about .person').sticky({
		offset: 72
	});
	/*$('#videos .video').stickem();*/
	
	var $logo = $('.logo');
	
	$(window).bind("resize scroll", function() {
		if( $(window).scrollTop() > 0 )
			$logo.addClass('scroll');
		else $logo.removeClass('scroll');
	});
	
	var $container = $('#grid');

	$container.isotope({
		itemSelector: '.item',
		layoutMode: 'masonry',
		masonry: {
			gutter: ".gutter-sizer"
		}
	});
	
	$('.nav-panel .drop a').click(function() {
		$('.quick').toggleClass('active');
		$('.drop').toggleClass('show');
		
		/*$container.isotope({ filter: function() {
			var number = $(this).text();			
			
			return number.match( /(6|3|5)/ig );
		} });*/
		
		//return false;
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

	$.fn.crop = function(parentWidth, parentHeight)
			{
				return this.each(function()
				{
					var width  = $(this).width();
					var height = $(this).height();
					
					console.log(parentHeight);
			
					if(width / parentWidth < height / parentHeight)
					{
						newWidth  = parentWidth;
						newHeight = parseInt( newWidth / width * height );
					}
					else
					{
						newHeight = parentHeight;
						newWidth  = parseInt( newHeight / height * width );
					}
					margin_top  = (parentHeight - newHeight) / 2;
					margin_left = (parentWidth  - newWidth ) / 2;
					
					$(this).css({'margin-top' :margin_top  + 'px',
								 'margin-left':margin_left + 'px',
								 'height'     :newHeight   + 'px',
								 'width'      :newWidth    + 'px'});
				});
			};
			
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
				
				if( $(window).width() <= 640 )
				{
					$sticky.removeClass('fixed').removeClass('bottom');
					
					return;
				}
				
				if( $container.innerHeight() - 30 == $sticky.innerHeight() )
				{
					$sticky.removeClass('fixed').removeClass('bottom');
					
					return;
				}
 
				var windowTop = $(window).scrollTop();
				
				_bottom = $container.offset().top - options.offset + $container.innerHeight() - $sticky.innerHeight() - 30;
			 
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