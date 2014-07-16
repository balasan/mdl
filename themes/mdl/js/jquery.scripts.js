function initPage() {
	
	if(Router.relativeUrl().match('objects')){
		$('.logo').addClass('atf').show()
	}
	else{
		$('.logo').removeClass('atf').show()
	}
	
	var offset = 102;
	
	if( $('#videos').length )
		offset = 102 + 10;
	
	if( $("[data-sticky_parent]").length ) {
		$("[data-sticky_parent]").imagesLoaded(function() {
			$("[data-sticky_column]").stick_in_parent({
				parent		: "[data-sticky_parent]",
				offset_top	: offset,
                offset_bottom  : 40
			});
		});
				
		$( window ).on( 'resize', function() {
			$(document.body).trigger("sticky_kit:recalc");
		});
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
	
	if( $('.search-btn').length )
	{
		var $searchBtn = $('.search-btn');
		var $grid = $('#grid');
		
		$(window).bind("resize scroll", function() {
			if( $(window).scrollTop() + 102 > $grid.offset().top )
				$searchBtn.addClass('fixed');
			else $searchBtn.removeClass('fixed');
		});
		
		
	}
	
	var $container = $('#grid');
	
	if( $container.length )
	{
		$('.loading').addClass('active');

		$container.isotope({
			itemSelector: '.item',
			layoutMode: 'masonry',
			masonry: {
				gutter: ".gutter-sizer"
			}
		})
		
		$container.imagesLoaded(function() {
			$('.loading').removeClass('active');
			
			$container.show().isotope({
				itemSelector: '.item',
				layoutMode: 'masonry',
				masonry: {
					gutter: ".gutter-sizer"
				}
			}).find('.post').removeClass('hide');
			
			if( $(window).scrollTop() + 102 > $container.offset().top )
				$('.search-btn').addClass('fixed');
			else $('.search-btn').removeClass('fixed');
			
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
			$('.page-read-more').slideUp('fast', function() {
				$(document.body).trigger("sticky_kit:recalc");
			});
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

function showEpisode(id)
{
	var _scrollTop = $('#post-' + id + ' .main').offset().top;	
	
	$('body, html').animate({ 'scrollTop': _scrollTop - 132 }, 'slow');
	
	$('.menu li').removeClass('active');
	$('.drop').removeClass('show');
	
	return false;
};

function scrollToTop()
{
	$('body, html').animate({ 'scrollTop': 0 }, 'slow');
};

function getSearch(evt, self)
{
	if( evt.keyCode == 13 )
	{
		$('<a href="#"></a>').hide().appendTo('body').attr('href', '?search=' + $(self).val()).trigger('click').remove();
		$('#search').removeClass('show');
		
		return false;
	}
};

var objectsCache;
var objectsScrollPosition = 0;

$(function() {
	
	var baseurl = $('body').attr('data-base');
	
	Router.init({
		home: baseurl,
		before: function(url) {
			$('body').removeClass('menu-open')

			$('.loading').addClass('active');
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
					
			if(Router.relativeUrl() == 'objects' && objectsCache)
				$("#container").html(objectsCache)
					.promise().done(function(){
							$("#container").fadeIn('slow');
							$('html, body').scrollTop(objectsScrollPosition);
					})
			else
				$("#container").html(content).fadeIn('slow');;
			$("#navigation .menu").html(menu);
		

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