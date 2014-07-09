$(document).ready(function() {

	var baseurl = $('body').attr('data-base');
	var viewportHeight = $(window).height();
	var viewportWidth = $(window).width();
	var docHeight = $(document).height();


	var lastPage = false;


	// device detection
	var device;

	function checkdevice() {
		if (/Android|webOS|iPhone|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
			device = 'mobile';
		} else if (/iPad/i.test(navigator.userAgent)) {
			device = 'desktop';
		} else {
			device = 'desktop';
			if ($(window).width() <= 800)
				device = "desktop_small";
		}
		if (device != 'desktop')
			minHeight = 0;
		if (viewportWidth <= 900)
			device = "mobile";
	}

	checkdevice();


	Router.init({
		home: baseurl,
		before: function(url) {
			$("#content, #footer").fadeOut();
			$('.loader').addClass('active')
			$('.search input').blur();
		},
		after: function($response) {

			var pageInfo = $response.find('#content').data('info');

			if (!pageInfo)
				pageInfo = {};


			var header = $response.find('header').html();
			var content = $response.find('#content').html();
			var footer = $response.find('#footer').html();

			targetTitle = $response.filter('title').text();

			//implement saving scroll to router's History State

			$("#content, #footer, #header").stop(true).hide().empty()
				.ahem(function() {
					$("#content").append(content).data('info', pageInfo);
					$('#footer').remove();
					$("#wrapper").append(footer)
				}).fadeIn('slow');

			initPage();

			$('.loader').removeClass('active')

			document.title = targetTitle;
		}
	})



	function initPage() {

		var pageInfo = $('#content').data('info');



		//re-init infinite scroll
		lastPage = false;
	}

	initPage();




	/* IMAGES */




	/* RESIZERS */

	$(window).resize(function() {

		viewportHeight = $(window).height();
		viewportWidth = $(window).width();
		docHeight = $(document).height();
		resize();

	});

	function resize() {
		checkdevice();

	}





	/* SCROLL */
	var navOffset = 0


	$(window).scroll(function(e) {

		var scrolled = $(document).scrollTop();

		/* INFINITE SCROLL*/

		docHeight = $(document).height();

		if (viewportHeight + scrolled + 300 > docHeight && oktoScroll) {

			oktoScroll = false;

			var container = $('.gridContainer');
			var totalPageCount = container.attr('data-pages');
			var requestUrl = $('#nextPage').attr('data-url');

			if (lastPage) {
				$('.loading-gif').hide();
				return;
			}

			// if ($('#nextPage').length) {

			$('.loading-gif').show();

			$.ajax({
				url: requestUrl,
				type: 'get',
				dataType: 'html',
				success: function(data) {

					var $data = $(data);
					var next = $data.find('#nextPage');
					var items = $data.find('.gridContainer').children();

					//здесь нужно добавить items в isotope

					// container.isotope('reLayout');
					// isotopeSetMobileItemClass();
					// container.append(items);

					$('#nextPage').replaceWith(next);
					$('.loading-gif').hide();
					oktoScroll = true;

				},
				error: function() {
					$('.loading-gif').hide();
					oktoScroll = true;
					lastPage = true;
				}
			});
		}
	});



	function scrollToTop() {
		$('body, html').animate({
			'scrollTop': 0
		}, 'fast');
	}









	/* CLICKS */






	/* HOVERS */





	/* -- GALLERY -- */



	/* ISOTOPE
    ------------------------------------------------------------*/

	function initIsotope() {
		var speed = 0;
		var container = $('#isotope-container');

		container.isotope({
			itemSelector: '.item-w', 
			layoutMode: 'masonry',
			masonry: {
				columnWidth: 1,
				rowHeight: 1
			},
			isStill: true,
			transitionDuration: speed,
			animationEngine: 'best-available',
			animationOptions: {
				transitionDuration: speed
			}
		});
		setupFilters(container, speed);

		isotopeSetMobileItemClass();
	}



	function layout() {
		if (device == 'mobile') {
			$('#isotope-container').isotope('option', {
				masonry: {
					columnWidth: 1,
					rowHeight: 1
				}
			});
		}
		$('#isotope-container').isotope('reLayout');
		isotopeSetMobileItemClass();
	}




	window.doSearch = function() {

		if ($('.search-box').width() > 30) {
			return;
		}

		$('.search input').show().focus();

		setTimeout(function() {
			$('.search input').focus();
		}, 100)
	}

	var delay = (function() {
		var timer = 0;

		return function(callback, ms) {
			clearTimeout(timer);
			timer = setTimeout(callback, ms);
		};
	})();

	var wp_search = {
		query: '',
		init: function() {
			var $search = $('.search input');

			var $searchBox = $('.search-box');

			$search.focus(function(e) {

				$(this).parent().addClass('focus');
				// $searchBox.slideDown('fast');
				// });


			})
			$search.blur(function(e) {

				self = $(this);

				setTimeout(function() {

					self.parent().removeClass('focus')

					if (!$search.is(':focus'))

						if (!$search.val().length)
							$search.parent().removeClass('find').find('ul').html('');
				}, 100);

			}).bind('keyup keypress paste', function() {

				if (wp_search.query == $search.val())
					return;

				if (!$search.val().length) {
					$search.parent().removeClass('find').find('ul').html('');

					return;
				}

				wp_search.query = $search.val();

				delay(function() {
					if (!$search.is(':focus'))
						return;

					if (!$search.val().length)
						return;

					$search.parent().addClass('loading');

					$.post(setting.host + 'wp-admin/admin-ajax.php', {
						'action': 'search',
						'value': $search.val()
					}, function(data) {

						$search.parent().removeClass('loading');

						if (!$search.is(':focus'))
							return;

						$search.parent().addClass('find').find('.search-ul').show().html(data);
					});
				}, 1000);
			});
		}
	};

	wp_search.init();





	$.fn.extend({

		// implementation of underscore's _.tap ?
		ahem: function(fn) {
			if (typeof fn == 'function') {
				fn.call(this);
			}
			return this;
		},
	});

});