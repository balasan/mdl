function initPage() {
	
	if(Router.relativeUrl().match('objects')){
		$('.logo').addClass('atf').show()
	}
	else{
		$('.logo').removeClass('atf').show()
	}
	
	var offset = 72;
	
	if( $('#about').length ) {
		$('#about .person').sticky({ offset: offset });
	}
	
	if( $('#videos').length ) {
		offset = 72 + 40;
		$('#videos .video').sticky({ offset: offset });
	}
	
	if( $('.nav-panel').length )
	{
		var $navPanel = $('.nav-panel');
		
		$(window).bind("resize scroll", function() {
			if( $(window).scrollTop() + 72 > $navPanel.offset().top )
				$navPanel.addClass('fixed');
			else $navPanel.removeClass('fixed');
		});
	}
	
	var $container = $('#grid');
	
	if( $container.length ) {
		
		// $container.isotope({
		// 	itemSelector: '.item',
		// 	layoutMode: 'masonry',
		// 	masonry: {
		// 		gutter: ".gutter-sizer"
		// 	}
		// });

	 //    $container.find('img').each(function(){
	 //          $(this).on('load',function(){
	 //              var $item = $(this).parent()
	 //              $container.isotope('appended', $item.removeClass('hide'));
	 //              $item.find('.display').css( 'top', ( $item.innerHeight() - $item.find('.display').innerHeight()) / 2 );
	 //          })
	 //      })


		$container.isotope({
			itemSelector: '.item',
			layoutMode: 'masonry',
			masonry: {
				gutter: ".gutter-sizer"
			}
		})
		
		$container.imagesLoaded(function() {
			$container.isotope({
				itemSelector: '.item',
				layoutMode: 'masonry',
				masonry: {
					gutter: ".gutter-sizer"
				}
			}).find('.post').removeClass('hide');
			
			$container.find('.item').each(function() {
				$(this).find('.display').css( 'top', ( $(this).innerHeight() - $(this).find('.display').innerHeight()) / 2 );
			});
			
			$(window).resize(function(e) {
				$container.imagesLoaded(function() {
					$container.find('.item').each(function() {
						$(this).find('.display').css( 'top', ( $(this).innerHeight() - $(this).find('.display').innerHeight()) / 2 );
					});
				});
      });
		});
	}
	
	$swiperContainer = $('.swiper-container');
	
	if( $swiperContainer.length )
	{		
		var mySwiper = $swiperContainer.swiper({
			mode: 'horizontal',
			loop: true
		});
		$('.arrow-left').on('click', function(e){
			e.preventDefault();
			mySwiper.swipePrev();
		});
		$('.arrow-right').on('click', function(e){
			e.preventDefault();
			mySwiper.swipeNext();
		});
		
		var _resize = function() {
			var height = $('#slider').width() / 2 + 80;
			$('#slider').height( height ).find('.swiper-slide').height( height );
		};
					
		$(window).resize(_resize); _resize();
	}
	
};

function showPage(el)
{
	$('.page-excerpt').slideUp('fast', function() {
		$('.page-excerpt-full').slideDown('slow', function() {
			$('.page-read-more').slideUp('fast');
		});
	});
	
	return false;
};

function showDrop(elem, id)
{
	var active = true;
	if( $(id).hasClass('show') ) active = false;
		
	$('.menu li').removeClass('active');
	$('.drop').removeClass('show');
	
	if( active ) {
		$(elem).parent().addClass('active');
		$(id).addClass('show');
	}
	
	return false;
};

function getSearch(evt, self)
{
	if( evt.keyCode == 13 )
	{
		$('<a href="#"></a>').hide().appendTo('body').attr('href', '?search=' + $(self).val()).trigger('click').remove();
		$('#search').removeClass('show');
		
		return false;
	}
}

var objectsCache;
var objectsScrollPosition = 0;

$(function() {
	
	var baseurl = $('body').attr('data-base');
	
	Router.init({
		home: baseurl,
		before: function(url) {
			$('.loading').addClass('active').show();
			$('input').blur();

			if(Router.relativeUrl() == 'objects'){
				objectsCache = $('#container').html()
				objectsScrollPosition = $(window).scrollTop();
			}

		},
		after: function($response) {
			var content = $response.find('#container').html();
			var menu = $response.find('#navigation .menu').html();

			targetTitle = $response.filter('title').text();
			
			if( $('#grid').length )
				$('#grid').infinitescroll('destroy');
				
			if( $('#about').length )
				$('#about').infinitescroll('destroy');

			$('html, body').scrollTop(0);
			
			$("#container").stop(true).hide().empty()
				.each(function() {
					
					$("#container").hide();
					if(Router.relativeUrl() == 'objects' && objectsCache)
						$("#container").html(objectsCache)
							.promise().done(function(){
								setTimeout(function(){
									$('html, body').scrollTop(objectsScrollPosition);
								},10)
							})
					else
						$("#container").html(content);
					$("#navigation .menu").html(menu);
				}).fadeIn('slow');

			initPage();

			$('.loading').removeClass('active').hide();

			document.title = targetTitle;
		}

	});
	
	initPage();
	
	var $logo = $('.logo');
	
	$(window).bind("resize scroll", function() {
		if( $(window).scrollTop() > 0 )
			$logo.addClass('scroll');
		else $logo.removeClass('scroll');
	});
		
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