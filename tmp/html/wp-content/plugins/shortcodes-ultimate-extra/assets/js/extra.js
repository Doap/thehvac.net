jQuery(document).ready(function ($) {
	// Splash screen
	$('.sue-splash').each(function () {
		var $splash = $(this),
			data = $splash.data(),
			$screen = $splash.children('.sue-splash-screen');
		// Check for cookie
		if (data.once === 'yes') createCookie(data.cookie, true, 1000);
		else eraseCookie(data.cookie);
		// Remove empty P's
		$screen.find('p:empty').remove();
		// Open popup with delay
		window.setTimeout(function () {
			// Create popup
			$.magnificPopup.open({
				closeOnBgClick: data.onclick === 'close-bg',
				closeBtnInside: true,
				showCloseBtn: data.close === 'yes',
				enableEscapeKey: data.esc === 'yes',
				callbacks: {
					beforeOpen: function () {
						// Add style class
						$('body').addClass(data.style);
					},
					open: function () {
						// Set window width
						$screen.css('max-width', data.width + 'px');
						// Set bg opacity
						$('.mfp-bg').css('opacity', data.opacity);
						// Set action for click
						$('body').on('mousedown.su', function (e) {
							// Go to url
							if (data.onclick === 'url') {
								var tag = e.target.nodeName.toLowerCase();
								if (tag === 'button' || tag === 'a') return;
								else window.location.href = data.url;
							}
							// Close screen
							else if (data.onclick === 'close') $.magnificPopup.close();
						});
					},
					close: function () {
						// Remove all styles
						$('.mfp-bg').attr('style', '');
						// Remove style class
						$('body').removeClass(data.style);
						// Remove click action
						$('body').unbind('mousedown.su');
					}
				},
				items: {
					src: $screen.remove()
				},
				type: 'inline'
			}, 0);
		}, parseInt(data.delay) * 1000 + 10);
	});

	// Photo/Icon panel
	$('body:not(.su-extra-loaded)').on('click', '.sue-panel-clickable', function (e) {
		document.location.href = $(this).data('url');
	});

	// Progress pie
	$('.sue-progress-pie').each(function () {
		// Prepare data
		var $pie = $(this),
			$canvas = $pie.children('canvas'),
			$text = $pie.children('div'),
			$data = $pie.data(),
			context = $canvas.get(0).getContext('2d'),
			chart = null,
			data = [],
			options = {};
		// Chart data
		data = [{
			value: $data.percent,
			color: $data.fill_color
		}, {
			value: 100 - $data.percent,
			color: $data.pie_color
		}];
		// Chart options
		options.segmentShowStroke = false;
		options.animationEasing = 'easeOutQuart';
		options.percentageInnerCutout = 100 - $data.pie_width;
		// Create chart
		$pie.on('inview', function () {
			if (chart === null) chart = new Chart(context).Doughnut(data, options);
		});
	});

	// Progress bar
	$('.sue-progress-bar').on('inview', function () {
		var $this = $(this),
			$span = $this.children('span'),
			percent = $this.data('percent');
		$span.animate({
			width: percent + '%'
		}, percent * 12);
	});

	// Section with parallax
	var $window = $(window);
	$('.sue-section-parallax').each(function () {
		var $this = $(this);
		// Check mobile option
		if ($this.data('mobile') == 'no' && $(window).width() < 768) {
			$this.css({
				backgroundAttachment: 'scroll'
			});
		} else {
			$(window).on('scroll touchmove', function () {
				var yPos = -($window.scrollTop() / $this.data('speed'));
				var coords = '50% ' + yPos + 'px';
				$this.css({
					backgroundPosition: coords
				});
			});
		}
	});

	// Content slider
	$('.sue-content-slider').each(function () {
		var $slider = $(this),
			$panels = $slider.children('div'),
			data = $slider.data(),
			autoplay;
		// Remove unwanted br's
		$slider.children(':not(.sue-content-slide)').remove();
		// Apply Owl Carousel
		$slider.owlCarousel({
			autoPlay: (data.autoplay > 0) ? data.autoplay : false,
			stopOnHover: true,
			navigation: true,
			paginationSpeed: data.speed,
			goToFirstSpeed: data.speed,
			singleItem: true,
			autoHeight: true,
			transitionStyle: data.effect,
			navigationText: ['', '']
		});
		// Adjust slide height on click
		$slider.on('click', '.sue-content-slide', function (e) {
			window.setTimeout(function () {
				$slider.data('owlCarousel').autoHeight();
			}, 300);
		});
		// Stop slider on click
		$slider.on('click', function (e) {
			$slider.trigger('owl.stop');
		});
	});
	// Fix YouTube iframe embeds
	$('.sue-content-slider .su-youtube iframe').each(function () {
		var $iframe = $(this),
			src = $iframe.attr('src'),
			amp = src.indexOf('?') >= 0 ? '&amp;' : '?';
		$iframe.attr('src', $iframe.attr('src') + amp + 'html5=1');
	});

	// Equal heights for pricing plans
	$('.sue-pricing-table').each(function () {
		var $options = $(this).find('.sue-plan-options'),
			max_height = 0;
		$options.each(function () {
			var options_height = $(this).outerHeight();
			if (options_height > max_height) max_height = options_height;
		});
		$options.css('min-height', max_height + 'px');
	});

	function createCookie(name, value, days) {
		var expires;

		if (days) {
			var date = new Date();
			date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
			expires = "; expires=" + date.toGMTString();
		} else {
			expires = "";
		}
		document.cookie = escape(name) + "=" + escape(value) + expires + "; path=/";
	}

	function readCookie(name) {
		var nameEQ = escape(name) + "=";
		var ca = document.cookie.split(';');
		for (var i = 0; i < ca.length; i++) {
			var c = ca[i];
			while (c.charAt(0) === ' ') c = c.substring(1, c.length);
			if (c.indexOf(nameEQ) === 0) return unescape(c.substring(nameEQ.length, c.length));
		}
		return null;
	}

	function eraseCookie(name) {
		createCookie(name, "", -1);
	}

	$('body').addClass('su-extra-loaded');
});