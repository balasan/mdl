$(function() {

	/* SWIPER
  ------------------------------------------------------------*/

	// bail if no swiper context
	if ($('.swiper-container').length) createSwiper();

	function createSwiper() {

		var Swiper = $('.swiper-container').swiper({
			mode: 'horizontal',
			loop: true,
			initialSlide: 0,
			pagination: $('#slide-pagination ul')[0],
			paginationElement: 'li',
			paginationClickable: true,
			onSlideChangeEnd: function() {
				updatePostHeader();
			},
			onTouchEnd: function() {
				updatePostHeader();
			}
		});

		var slidePrev = $('#slide-nav-prev'),
			slideNext = $('#slide-nav-next');

		slidePrev.add(slideNext).on('click', function() {
			if ($(this).is(slidePrev)) {
				Swiper.swipePrev();
			} else {
				Swiper.swipeNext();
			}
			updatePostHeader();
		});

		var postHeader = $('#post-header a');

		// set slideshow post-header title from active slide's post_object link
		function updatePostHeader() {
			// bail if not archive
			if ($('body').hasClass('single') || postHeader.length === 0) {
				return;
			}

			var active = Swiper.activeSlide(),
				permalink = $(active).find('.feature-caption a'),
				href = permalink.attr('href'),
				// grab title from relative path, replace meta-char-ish stuff with spaces
				title = sliceRel(href).toUpperCase().replace(/[#_-]/g, ' ');

			postHeader.attr('href', href).text(title);
		}
		updatePostHeader();
	}

	// get final relative part of url
	// https://github.com/Lokua/L/blob/master/js/L.js >> line 178
	function sliceRel(url, preSlash, trailingSlash) {
		var hasTrailing = false;
		if (url.slice(-1) === '/') {
			hasTrailing = true;
			url = url.slice(0, -1);
		}
		// snatch last part
		url = url.slice(url.lastIndexOf('/') + 1);
		// only if url already had trailing will we add it back
		// when trailingSlash is true.
		if (hasTrailing && trailingSlash) {
			url = url.concat('/');
		}
		if (preSlash) {
			url = '/'.concat(url);
		}
		return url;
	}

	/* MASONRY
  ------------------------------------------------------------*/

	// bail if no masonry context
	if ($('#masonry-container').length) {
		createMasonry();
		setRowHeights();
		setupFilters();
		$(window).on('resize', function() {
			setRowHeights();
		});
	}

	function createMasonry() {
		$(window).load(function() {
			// setItemClasses();
			var container = $('#masonry-container');
			container.masonry({
				itemSelector: '.item-w',
				columnWidth: 1
			});
		});
	}

	function setRowHeights() {
		var small = $('.small'),
			wunit = small.eq(0).width(),
			hunit = wunit * 0.7179487179487179;
		// we cannot use direct $obj.height when using border-box model
		small.css('height', hunit + 'px');
		$('.portrait, .large').css('height', hunit * 2 + 'px');
	}

	function setupFilters() {
		var items = $('.item-w'),
			filters = $('#posts, #press, #instagram, #events, #all'),
			noposts = $('#no-posts');
		speed = '500';
		filters.on('click', function(e) {
			e.preventDefault();

			noposts.hide(speed);


			// if ($(this).is('#all')) {
			//  $(items).show(speed, layout);
			//  return;
			// }
			// convert filter id to related class string
			var classtr = '.' + $(this).attr('id');
			if ($(this).is('#all')) {
				classtr = '.item-w'
				// $(items).show(speed, layout);
				// return;
			}
			// convert filter id to related class string

			var container = $('#masonry-container');

			// 'reveal' isn't working - bug
			// var hide = new Array();
			// $(items).not(classtr).each(function() {
			//  hide.push($(this));
			// })
			// var show = new Array();
			// $(items).filter(classtr).each(function() {
			//  show.push($(this)[0]);
			// })
			// container.masonry('hide', hide)
			// container.masonry('reveal', show)
			// layout();




			// show category
			$(items).not(classtr).fadeOut(speed, layout).end().filter(classtr).fadeIn(speed, layout);

			layout();
			// if filter contains no matches, show the no-posts div
			if (!$(classtr).length) {
				var title = $('title').text(),
					title = title.substr(0, title.indexOf('|') - 1),
					nopoststr = title + ' has no related ' + classtr.slice(1) + ' posts.';
				noposts.text(nopoststr).show(speed);
			}


		});
	}

	function layout() {
		var container = $('#masonry-container');
		container.masonry('layout');
	}

	/* MODAL GALLERY
  ------------------------------------------------------------*/

	var modalGallery = $('#modal');

	$('#view-works').on('click', function(e) {
		e.preventDefault();
		// var img = $('.item').eq(0).prop('style').backgroundImage;
		// img = img.match(/\((.*?)\)/)[1];
		// img = $('<img>').attr('src', img).css('position', 'fixed');
		// modalGallery.removeClass('hidden').append(img);
		modalGallery.removeClass('hidden');
	});

	modalGallery.on('click', function() {
		$(this).addClass('hidden');
	});

});