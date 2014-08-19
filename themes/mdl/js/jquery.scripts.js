function initPage() {
	
	if(Router.relativeUrl().match('objects')){
		$('.logo').addClass('atf').show()
	}
	else{
		$('.logo').removeClass('atf').show()
	}
	
	var offset = 135;
	
	if( $('#videos').length )
		offset = 135 + 10;


	
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
		$( window ).on( 'load', function() {
			$(document.body).trigger("sticky_kit:recalc");
		});
	}
	
	if( $('.nav-panel').length )
	{
		var $navPanel = $('.nav-panel');
		
		$(window).bind("resize scroll", function() {
			if( $(window).scrollTop() + 105 > $navPanel.offset().top )
				$navPanel.addClass('fixed');
			else $navPanel.removeClass('fixed');
		});
	}
	
	if( $('.search-btn').length )
	{
		var $searchBtn = $('.search-btn');
		var $grid = $('#grid');
		
		$(window).bind("resize scroll", function() {
			if( $(window).scrollTop() + 155 > $grid.offset().top )
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
			
			if( $(window).scrollTop() + 145 > $container.offset().top )
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
	
	/*$swiperContainer = $('.swiper-container');
	
	if( $swiperContainer.length )
	{		
		var mySwiper = $swiperContainer.swiper({
			mode: 'horizontal',
			loop: true,
			// resizeReInit:true
		});

		$('.arrow-left').on('click', function(e){
			e.preventDefault();
			mySwiper.swipePrev();
		});
		$('.swiper-slide').on('click', function(e){
			e.preventDefault();
			mySwiper.swipeNext();
		});
		$('.arrow-right').on('click', function(e){
			e.preventDefault();
			mySwiper.swipeNext();
		});
		
		// var _resize = function() {
		// 	var height = $('#slider').width() / 2;
		// 	$('#slider').height( height ).find('.swiper-slide').height( height );
		// 	mySwiper.resizeFix()
		// };
					
		// $(window).resize(_resize); _resize();
	}*/
	
};

function showPage(el)
{
	var parent = $('.page-excerpt').parent()

	if(!parent.hasClass('open')){
		parent.css({
			'min-height': parent.outerHeight()
		})
		$('.page-excerpt-full').css({
			'min-height':($('.page-excerpt').height())
		})
		$('.page-read-more a').text('')

		$('.page-excerpt-full').slideDown(330, 'easeInOutQuart', function(){
			$(document.body).trigger("sticky_kit:recalc");
		});
		$('.page-excerpt').hide()
			parent.addClass('open')

	}
	else{
		parent.removeClass('open')

		$('.page-read-more a').text("Read More")
		$('.page-excerpt-full').slideUp(330, 'easeInOutQuart',function(){
			$('.page-excerpt').show()
			// $('.page-excerpt-full').hide()
			$(document.body).trigger("sticky_kit:recalc");
		});

	}


	// $('.page-excerpt').slideUp('fast', function() {
	// 	$('.page-excerpt-full').slideDown('slow', function() {
	// 		$('.page-read-more').hide('fast', function() {
	// 			$(document.body).trigger("sticky_kit:recalc");
	// 		});
	// 	});
	// });
	
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

function hideDrops()
{		
	$('.menu li').removeClass('active');
	$('.drop').removeClass('show');
	
	return false;
};

function showEpisode(id)
{
	var _scrollTop = $('#post-' + id + ' .image ').offset().top;	
	
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

	Router.route('/tv',function(){
		  var getYTPVideoID=function(url){
		    var movieURL;
		    if(url.substr(0,16)=="http://youtu.be/"){
		      movieURL= url.replace("http://youtu.be/","");
		    }else if(url.indexOf("http")>-1){
		      movieURL = url.match(/[\\?&]v=([^&#]*)/)[1];
		    }else{
		      movieURL = url
		    }
		    return movieURL;
		  };

		$('a.video-link').each(function(){
		    var id = getYTPVideoID($(this).attr('href'));
		    var script = '<iframe class="ytplayer" type="text/html" width="100%" height="100%"' + 
		    'src="https://www.youtube.com/embed/'+id+'?disablekb=1&enablejsapi=1&showinfo=0&autohide=1&color=white&iv_load_policy=3&theme=light"' + 
		    'frameborder="0" allowfullscreen>'
		    $(this).replaceWith(script);
		    $(document.body).trigger("sticky_kit:recalc");

		})

		$('.player').height($('.player').width()*9/16);
		$(document.body).trigger("sticky_kit:recalc");

		$(window).resize(function(){
		    $('.player').height($('.player').width()*9/16);
		    // $(document.body).trigger("sticky_kit:recalc");
		})

	})
	
	initPage();
	
	var $logo = $('.logo');
	
	$(window).bind("resize scroll", function() {
		if( $(window).scrollTop() > 0 )
			$logo.addClass('scroll');
		else $logo.removeClass('scroll');
	});
		
});


// (function($) {
	
// 	$.fn.sticky = function(options) {
		
// 		options = $.extend({
// 			container : '.stickem-container',
// 			sticky : '.stickem',
// 			offset: 0
// 		}, options);
		
// 		return this.each(function() {
			
// 			var $container = $(this);
// 			var $sticky = $container.find(options.sticky);
			
// 			var _resize = function(e) {
// 				$sticky.css({ width: 'auto', position: 'static' }).width($sticky.width()).css('position', '');
// 			};
			
// 			var _scroll = function() {
				
// 				if( $(window).width() <= 640 )
// 				{
// 					$sticky.removeClass('fixed').removeClass('bottom');
					
// 					return;
// 				}
				
// 				if( $container.innerHeight() - 30 == $sticky.innerHeight() )
// 				{
// 					$sticky.removeClass('fixed').removeClass('bottom');
					
// 					return;
// 				}
 
// 				var windowTop = $(window).scrollTop();
				
// 				_bottom = $container.offset().top - options.offset + $container.innerHeight() - $sticky.innerHeight() - 30;
			 
// 				if( $container.offset().top - options.offset <= windowTop && _bottom >= windowTop )
// 				{
// 					$sticky.removeClass('bottom').addClass('fixed');
// 				}
// 				else if( $container.offset().top - options.offset <= windowTop && _bottom <= windowTop )
// 				{
// 					$sticky.removeClass('fixed').addClass('bottom');
// 				}
// 				else
// 				{
// 					$sticky.removeClass('fixed').removeClass('bottom');
// 				}
		 
// 			};
			
// 			$(window).scroll(_scroll).resize(function() { _resize(); _scroll(); });
			
// 			_resize();
			
// 		});
// 	};

// })(jQuery);