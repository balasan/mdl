//AJAX MODULE


var Router = (function() {

	var History = window.History;

	var router = {};
	var homeUrl;
	var currentUrl;
	var newUrl;
	//call this before transition
	var before;
	//call this after transition
	var after;
	var routes = [];
	var relativeUrl;


	//defaluts
	var defaultOptions = {
		ignore: ".external",
	}


	var pushstate = 'push';

	if (!History.enabled) {
		pushstate = 'no';
	}


	router.route = function(route, fn) {
		routes.push({
			route: route,
			callback: fn
		});
	}

	var routerFunction = function(myUrl) {
		var myArr = myUrl.split('/')
		for (var i = 0; i < routes.length; i++) {
			var tmpArray = routes[i].route.slice(1).split('/')
			if (myArr.length == tmpArray.length) {
				if (myArr[0] == tmpArray[0]) {
					routes[i].callback()
					return;
				}
			}
			if (routes[i].route == "*")
				routes[i].callback()
		}
	}

	router.init = function(options) {

		opt = options;
		before = opt.before;
		after = opt.after;
		homeUrl = opt.home;
		currentUrl = window.location.href;

		if (pushstate == 'push') {

			History.Adapter.bind(window, 'statechange', function() {
				var State = History.getState();
				replacePage(State.url);
			});

			$('body').on('click', 'a', function(e) {
				var comp = new RegExp(location.host);
				if (!comp.test($(this).attr('href')) && ($(this).attr('href').substring(0, 4) === "http"))
					return;
				if (this.href == "javascript:void(0)")
					return;
				//everything you don't want to be ajax
				if ($(this).is(opt.ignore ? opt.ignore : defaultOptions.ignore)) {
					return;
				}

				e.preventDefault();
				if (typeof(window.history.pushState) == 'function' && pushstate == 'push') {
					History.pushState({
						state: 1,
						rand: Math.random()
					}, null, this.href);
				} else {
					window.location.href = this.href;
				}
			});

		}
	}

	var pageRequest;
	var replacePage = function(url) {
		if (typeof(window.history.pushState) == 'function' && pushstate == 'push') {

			if (pageRequest) {
				pageRequest.abort();
			}

			relativeUrl = url.replace(homeUrl, '').replace(/\/$/, '');

			newUrl = url;
			// if(currentUrl == newUrl)
			// return;

			before(url);

			pageRequest = $.ajax({
				url: url,
				type: 'get',
				dataType: 'html',
				success: function(data) {

					var $response = $(data);

					routerFunction(relativeUrl)

					after($response);

					currentUrl == newUrl;
					if (typeof window._gaq !== 'undefined') {
						window._gaq.push(['_trackPageview', relativeUrl]);
					}
				}
			});

		} else {
			window.location.href = url;
		}
	}
	return router;
})()