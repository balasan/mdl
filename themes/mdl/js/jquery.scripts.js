function initPage() {
	
	$('html, body').scrollTop(0);
	
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
		
		$('.nav-panel .drop a').click(function() {
			$('.quick').toggleClass('active');
			$('.drop').toggleClass('show');
		});
	}
	
	var $container = $('#grid');
	
	if( $container.length ) {
		$container.isotope({
			itemSelector: '.item',
			layoutMode: 'masonry',
			masonry: {
				gutter: ".gutter-sizer"
			}
		});
		
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

$(function() {
	
	var baseurl = $('body').attr('data-base');
	
	Router.init({
		home: baseurl,
		before: function(url) {
			//$("#container").hide();
			$('.loading').addClass('active');
			$('input').blur();
		},
		after: function($response) {

			//var pageInfo = $response.find('#content').data('info');
			
			//if (!pageInfo)
			//	pageInfo = {};


			//var header = $response.find('header').html();
			var content = $response.find('#container').html();
			var menu = $response.find('#navigation .menu').html();
			//var footer = $response.find('#footer').html();

			targetTitle = $response.filter('title').text();

			//implement saving scroll to router's History State
			
			if( $('#grid').length )
				$('#grid').infinitescroll('destroy');
				
			if( $('#about').length )
				$('#about').infinitescroll('destroy');

			$("#container").stop(true).hide().empty()
				.each(function() {
					
					$("#container").hide();
					$("#container").html(content);
					$("#navigation .menu").html(menu);
					//$('#footer').remove();
					//$("#wrapper").append(footer);
				}).fadeIn('slow');

			initPage();

			$('.loading').removeClass('active');

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