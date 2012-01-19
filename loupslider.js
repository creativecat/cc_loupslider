// test

(function ($) {
	$.fn.loupslider = function (options) {
		var defaults = {
			durationTimeOut: 7000,
			durationBlende: 1500,
			opacity: 0.7,
			thumb_width: 0,
			thumb_height: 0,
			img_width: 0,
			img_height: 0,
			sliderBack: 'slider_back',
			sliderBottom: 30,
			imagesSlider: 'slider_images',
			navigation: true,
			random: false,
			easing: ''
		};
		var options = $.extend(defaults, options);
		return this.each(function () {
			function creativecat_loupslider() {
				var current_object = current.find('.active');
				var current_position = current_object.index();
				if (current_position == anzahl - 1) {
					var current_position = -1;
					current_imagesSlider.css({
						marginLeft: -(anzahl - 1) * options.img_width + 'px'
					});
					$('#' + options.sliderBack + ' #slider_images_left .' + options.imagesSlider).css({
						marginRight: -(anzahl * 2 + 1) * options.thumb_width + (options.img_width / 2) + 'px'
					});
					$('#' + options.sliderBack + ' #slider_images_right .' + options.imagesSlider).css({
						marginLeft: -(anzahl) * options.thumb_width + (options.img_width / 2) + 'px'
					})
				}
				current_object.removeClass('active');
				current.find('img').eq(current_position + 1).addClass('active');
				$('.nav_point').removeClass('active');
				$('.nav_point').eq(current_position + 1).addClass('active');
				var slider_height = $('#slider_title').outerHeight();
				$('#slider_title').stop().animate({
					bottom: -slider_height + 'px'
				}, 200, function () {
					current_imagesSlider.stop().animate({
						marginLeft: -(anzahl + current_position + 1) * options.img_width + 'px'
					}, options.durationBlende, options.easing, function () {
						var title = $('#slider_titles .slider_title').eq(current_position + 1).html();
						var link = $('#slider_links .slider_links').eq(current_position + 1).html();
						$('#slider_title').html(link + title);
						if ($('#slider_title').html() != '') {
							$('#slider_title').stop().animate({
								bottom: '0px'
							}, 200);
						}
					});
					$('#' + options.sliderBack + ' #slider_images_left .' + options.imagesSlider).stop().animate({
						marginRight: -(anzahl * 2 - current_position - 1) * options.thumb_width + (options.img_width / 2) + 'px'
					}, options.durationBlende, options.easing);
					$('#' + options.sliderBack + ' #slider_images_right .' + options.imagesSlider).stop().animate({
						marginLeft: -(anzahl + 1 + current_position + 1) * options.thumb_width + (options.img_width / 2) + 'px'
					}, options.durationBlende, options.easing)
				})
			}
			var current = $(this);
			if (options.img_height == 0) {
				options.img_height = current.children('img').height();
				options.img_width = current.children('img').width()
			}
			if (options.thumb_height == 0) {
				options.thumb_height = Math.round(options.img_height / 1.618);
				options.thumb_width = Math.round(options.img_width / 1.618)
			}
			var anzahl = current.find('img').size();
			current.find('img').each(function () {
				$(this).attr('rel', $(this).index())
			});
			if (options.random == true) {
				current.children('img').each(function () {
					var current_index = $(this).index();
					var random = Math.ceil(Math.random() * anzahl);
					while (current_index == random) {
						random = Math.ceil(Math.random() * anzahl)
					}
					$(this).before(current.find('img').eq(random));
					$('.slider_title').eq(current_index).before($('.slider_title').eq(random));
					$('.slider_links').eq(current_index).before($('.slider_links').eq(random))
				})
			}
			current.children('img').wrapAll('<div class="' + options.imagesSlider + '" />');
			current.wrap('<div id="slider_wrapper" />').parent().append('<div id="' + options.sliderBack + '"><div id="slider_images_left" class="' + options.imagesSlider + '"></div><div id="slider_images_right" class="' + options.imagesSlider + '"></div></div>');
			$('#slider_wrapper').css({
				width: '100%',
				position: 'relative',
				zIndex: 10
			});
			$('#slider_title').css({width: (options.img_width-100)+'px'});
			var shadow_height = Math.round(options.img_width / 11.6);
			$('.cc_loupslider_shadow').css({width: (options.img_width+30)+'px', height: shadow_height+'px', left: '50%', position: 'relative', marginLeft: -Math.round((options.img_width+30)/2)+'px', zIndex: 2});
			$('#slider_wrapper img').css({
				margin: '0px',
				padding: '0px'
			});
			current.css({
				left: '50%',
				zIndex: 5,
				top: '0px',
				position: 'relative',
				height: options.img_height + 'px',
				marginLeft: -(options.img_width / 2) + 'px',
				width: options.img_width + 'px',
				overflow: 'hidden'
			});
			$('#' + options.sliderBack).css({
				top: options.img_height - options.thumb_height - options.sliderBottom + 'px',
				position: 'absolute',
				zIndex: 1,
				height: options.thumb_height + 'px',
				width: '100%',
				overflow: 'hidden'
			});
			$('#' + options.sliderBack + ' #slider_images_left').css({
				width: '50%',
				left: '0px',
				top: '0px',
				position: 'absolute',
				height: options.thumb_height + 'px',
				overflow: 'hidden'
			});
			$('#' + options.sliderBack + ' #slider_images_right').css({
				width: '50%',
				right: '0px',
				top: '0px',
				position: 'absolute',
				height: options.thumb_height + 'px',
				overflow: 'hidden'
			});
			current.children('.' + options.imagesSlider).css({
				left: '0px',
				top: '0px',
				position: 'absolute'
			});
			current_imagesSlider = current.children('.' + options.imagesSlider);
			var one = current_imagesSlider.children('img').clone();
			var two = current_imagesSlider.children('img').clone();
			one.appendTo(current_imagesSlider);
			two.appendTo(current_imagesSlider);
			current_imagesSlider.children('img').clone().appendTo('#' + options.sliderBack + ' #slider_images_left');
			current_imagesSlider.children('img').clone().appendTo('#' + options.sliderBack + ' #slider_images_right');
			$('#' + options.sliderBack + ' #slider_images_left').children('img').wrapAll('<div class="' + options.imagesSlider + '" />');
			$('#' + options.sliderBack + ' #slider_images_right').children('img').wrapAll('<div class="' + options.imagesSlider + '" />');
			$('#' + options.sliderBack).find('img').css({
				height: options.thumb_height + 'px',
				width: options.thumb_width + 'px',
				opacity: options.opacity,
				float: 'left'
			});
			$('#' + options.sliderBack + ' #slider_images_left .' + options.imagesSlider).css({
				width: (anzahl) * 3 * options.thumb_width + 'px',
				marginRight: -(anzahl * 2) * options.thumb_width + (options.img_width / 2) + 'px',
				position: 'absolute',
				right: '0px'
			});
			$('#' + options.sliderBack + ' #slider_images_right .' + options.imagesSlider).css({
				width: (anzahl) * 3 * options.thumb_width + 'px',
				marginLeft: -(anzahl + 1) * options.thumb_width + (options.img_width / 2) + 'px'
			});
			current_imagesSlider.css({
				width: anzahl * 3 * options.img_width + 'px',
				marginLeft: -anzahl * options.img_width + 'px'
			});
			if (options.navigation == true) {
				$('#slider_wrapper').append('<div class="left_nav slider_nav"></div><div class="right_nav slider_nav"></div>');
				var punkte = current_imagesSlider.find('img').size() / 3;
				$('#slider_wrapper').append('<div id="slider_nav_points" />');
				var zahler = 0;
				while (zahler < punkte) {
					$('#slider_nav_points').append('<div class="nav_point" />');
					zahler++
				}
				var point_width = $('.nav_point').outerWidth(true);
				$('#slider_nav_points').css({
					width: punkte * point_width + 'px',
					height: '20px',
					position: 'absolute',
					bottom: '-40px',
					left: '50%',
					marginLeft: '-' + punkte * point_width / 2 + 'px',
					zIndex: 10
				});
				$('.nav_point').css({
					cursor: 'pointer'
				});
				$('.nav_point:first').addClass('active')
			}
			$('.nav_point').click(function () {
				clearInterval(slider_function);
				var current_active = current.find('.active').index();
				current.find('.active').removeClass('active');
				var clicked = $(this).index();
				if (clicked > 0) {
					current.find('img').eq(clicked - 1).addClass('active')
				}
				creativecat_loupslider();
				slider_function = setInterval(function () {
					creativecat_loupslider()
				}, options.durationTimeOut)
			});
			$('.right_nav').click(function () {
				clearInterval(slider_function);
				creativecat_loupslider();
				slider_function = setInterval(function () {
					creativecat_loupslider()
				}, options.durationTimeOut)
			});
			$('.left_nav').click(function () {
				clearInterval(slider_function);
				var current_active = current.find('.active').index();
				current.find('.active').removeClass('active');
				if (current_active > 1) {
					current.find('img').eq(current_active - 2).addClass('active')
				}
				if (current_active == 0) {
					$('.nav_point').removeClass('active');
					$('.nav_point').eq(anzahl - 1).addClass('active');
					current.find('img').eq(anzahl - 1).addClass('active');
					current_imagesSlider.css({
						marginLeft: -(anzahl * 2) * options.img_width + 'px'
					});
					$('#' + options.sliderBack + ' #slider_images_left .' + options.imagesSlider).css({
						marginRight: -(anzahl) * options.thumb_width + (options.img_width / 2) + 'px'
					});
					$('#' + options.sliderBack + ' #slider_images_right .' + options.imagesSlider).css({
						marginLeft: -(2 * anzahl + 1) * options.thumb_width + (options.img_width / 2) + 'px'
					});
					current_imagesSlider.stop().animate({
						marginLeft: -(2 * anzahl - 1) * options.img_width + 'px'
					}, options.durationBlende, options.easing);
					$('#' + options.sliderBack + ' #slider_images_left .' + options.imagesSlider).stop().animate({
						marginRight: -(anzahl + 1) * options.thumb_width + (options.img_width / 2) + 'px'
					}, options.durationBlende, options.easing);
					$('#' + options.sliderBack + ' #slider_images_right .' + options.imagesSlider).stop().animate({
						marginLeft: -(2 * anzahl) * options.thumb_width + (options.img_width / 2) + 'px'
					}, options.durationBlende, options.easing)
				} else {
					creativecat_loupslider()
				}
				slider_function = setInterval(function () {
					creativecat_loupslider()
				}, options.durationTimeOut)
			});
			$('#slider_wrapper').find('img:first').addClass('active');
			var title = $('#slider_titles .slider_title').eq(0).html();
			var link = $('#slider_links .slider_links').eq(0).html();
			$('#slider_title').html(link + title);
			if ($('#slider_title').html() != '') {
				$('#slider_title').stop().animate({
					bottom: '-400px'
				}, 0, function () {
					$('#slider_title').stop().animate({
						bottom: '0px'
					}, 400)
				})
			} else {
				$('#slider_title').css({
					bottom: '-400px'
				})
			}
			slider_function = setInterval(function () {
				creativecat_loupslider()
			}, options.durationTimeOut)
		})
	}
})(jQuery);