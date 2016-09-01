/*
 * Bones Scripts File
 * Author: Eddie Machado
 *
 * This file should contain any js scripts you want to add to the site.
 * Instead of calling it in the header or throwing it inside wp_head()
 * this file will be called automatically in the footer so as not to
 * slow the page load.
 *
 * There are a lot of example functions and tools in here. If you don't
 * need any of it, just remove it. They are meant to be helpers and are
 * not required. It's your world baby, you can do whatever you want.
*/


/*
 * Get Viewport Dimensions
 * returns object with viewport dimensions to match css in width and height properties
 * ( source: http://andylangton.co.uk/blog/development/get-viewport-size-width-and-height-javascript )
*/
function updateViewportDimensions() {
	var w=window,d=document,e=d.documentElement,g=d.getElementsByTagName('body')[0],x=w.innerWidth||e.clientWidth||g.clientWidth,y=w.innerHeight||e.clientHeight||g.clientHeight;
	return { width:x,height:y };
}
// setting the viewport width
var viewport = updateViewportDimensions();


/*
 * Throttle Resize-triggered Events
 * Wrap your actions in this function to throttle the frequency of firing them off, for better performance, esp. on mobile.
 * ( source: http://stackoverflow.com/questions/2854407/javascript-jquery-window-resize-how-to-fire-after-the-resize-is-completed )
*/
var waitForFinalEvent = (function () {
	var timers = {};
	return function (callback, ms, uniqueId) {
		if (!uniqueId) { uniqueId = "Don't call this twice without a uniqueId"; }
		if (timers[uniqueId]) { clearTimeout (timers[uniqueId]); }
		timers[uniqueId] = setTimeout(callback, ms);
	};
})();

// how long to wait before deciding the resize has stopped, in ms. Around 50-100 should work ok.
var timeToWaitForLast = 100;


/*
 * Here's an example so you can see how we're using the above function
 *
 * This is commented out so it won't work, but you can copy it and
 * remove the comments.
 *
 *
 *
 * If we want to only do it on a certain page, we can setup checks so we do it
 * as efficient as possible.
 *
 * if( typeof is_home === "undefined" ) var is_home = $('body').hasClass('home');
 *
 * This once checks to see if you're on the home page based on the body class
 * We can then use that check to perform actions on the home page only
 *
 * When the window is resized, we perform this function
 * $(window).resize(function () {
 *
 *    // if we're on the home page, we wait the set amount (in function above) then fire the function
 *    if( is_home ) { waitForFinalEvent( function() {
 *
 *	// update the viewport, in case the window size has changed
 *	viewport = updateViewportDimensions();
 *
 *      // if we're above or equal to 768 fire this off
 *      if( viewport.width >= 768 ) {
 *        console.log('On home page and window sized to 768 width or more.');
 *      } else {
 *        // otherwise, let's do this instead
 *        console.log('Not on home page, or window sized to less than 768.');
 *      }
 *
 *    }, timeToWaitForLast, "your-function-identifier-string"); }
 * });
 *
 * Pretty cool huh? You can create functions like this to conditionally load
 * content and other stuff dependent on the viewport.
 * Remember that mobile devices and javascript aren't the best of friends.
 * Keep it light and always make sure the larger viewports are doing the heavy lifting.
 *
*/

/*
 * We're going to swap out the gravatars.
 * In the functions.php file, you can see we're not loading the gravatar
 * images on mobile to save bandwidth. Once we hit an acceptable viewport
 * then we can swap out those images since they are located in a data attribute.
*/
function loadGravatars() {
	// set the viewport using the function above
	viewport = updateViewportDimensions();
	// if the viewport is tablet or larger, we load in the gravatars
	if (viewport.width >= 768) {
		jQuery('.comment img[data-gravatar]').each(function(){
			jQuery(this).attr('src',jQuery(this).attr('data-gravatar'));
		});
	}
} // end function

// get query string parameters
// http://stackoverflow.com/questions/4656843/jquery-get-querystring-from-url
function getQueryString() {
	var vars = [], hash;
    var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
    for(var i = 0; i < hashes.length; i++)
    {
        hash = hashes[i].split('=');
		// if the key in the query string has no value, set the value to true
        if (hash[1] == undefined) {
			hash[1] = true;
		}
        vars.push(hash[0]);
        vars[hash[0]] = hash[1];
    }
    return vars;
}


/*
 * Put all your regular jQuery in here.
*/
jQuery(document).ready(function($) {
	var win = $(window);
	
	// Hide wp admin bar
	$('#wpadminbar').addClass('hidden').append('<div class="wpadminbar-activator"></div>').hover(
		function() {
			$(this).removeClass('hidden');
		},
		function() {
			$(this).addClass('hidden');
		}
	)

	// Check what page we're on
	if (typeof isHome === "undefined") var isHome = $('body').hasClass('home');
	if (typeof isIndex === "undefined") var isIndex = $('body').hasClass('page-template-page-index');
	if (typeof isVideoIndex === "undefined") var isVideoIndex = $('body').hasClass('page-video-production');
	if (typeof isVideo === "undefined") var isVideo = $('body').hasClass('video-gallery') || $('body').hasClass('single-shows');
	if (typeof isVideoGallery === "undefined") var isVideoGallery = $('body').hasClass('video-gallery');
	if (typeof isSingleShow === "undefined") var isSingleShow = $('body').hasClass('single-shows');
	
	/*
	* You can remove this if you don't need it
	* Let's fire off the gravatar function
	*/
	//loadGravatars();
	
	win.resize(function() {
		waitForFinalEvent( function() {
			mobileDeviceBodyClass();
			headerHeight();
		}, timeToWaitForLast, 'resizeWindow');
	});
	
	win.scroll(function() {
		headerHeight();
	});

	// Mobile device classes
	function mobileDeviceType() {
		if (win.width() > 1024) {
			return false;
		} else if (win.width() < 768) {
			return 'mobile';
		} else {
			return 'tablet';
		}
	}
	function mobileDeviceBodyClass() {
		if (mobileDeviceType() == 'mobile') {
			$('body').addClass('mobile').removeClass('tablet');
		} else if (mobileDeviceType() == 'tablet') {
			$('body').addClass('tablet').removeClass('mobile');
		} else {
			$('body').removeClass('mobile tablet');
		}
	}
	mobileDeviceBodyClass();
	
	function headerHeight() {
		var scrollTrigger = 0;
		var secondaryScrollTrigger = isHome ? $('.HOME_LOGO').outerHeight()*.50: 0;
		if (win.scrollTop() > scrollTrigger) {
			$('html').addClass('scrolled');
		} else {
			$('html').removeClass('scrolled');
		}
		if (win.scrollTop() > secondaryScrollTrigger) {
			$('html').addClass('secondary-scrolled');
		} else {
			$('html').removeClass('secondary-scrolled');
		}
	}
	
	// Control mobile main nav
	$('.TRIGGER_NAV').click(function(e) {
		e.preventDefault();
		$(this).add('.MAIN_NAV').toggleClass('active');
		$('html').toggleClass('mobile-nav-active');
	});
	
	$('.MAIN_NAV').on('click','a',function(e) {
		if (mobileDeviceType()) {
			$('.TRIGGER_NAV').click();
		}
	});
	
	$('.OV_CLOSE').click(function(e) {
		e.preventDefault();
		$(this).closest('.OV').removeClass('active');
	});
	
	win.keyup(function(e) {
		if (e.keyCode == 27 || e.which == 27) {
			$('.OV').removeClass('active');
		}
		var galleryItemOv = $('#gallery_item_ov');
		if (galleryItemOv.hasClass('active')) {
			if (e.keyCode == 37 || e.which == 37) {
				galleryItemOv.find('.actions .PREV').click();
			} else if (e.keyCode == 39 || e.which == 39) {
				galleryItemOv.find('.actions .NEXT').click();
			}
		}
	});
	
	function simpleAutoCarousel(container, duration) {
		var simpleAutoCarouselInteval = setInterval(function() {
			var active = container.find('.active');
			var next = active.next().length > 0 ? active.next() : active.siblings().first();
			active.removeClass('active');
			next.addClass('active');
		}, duration);
	}
	
	// GALLERY OVERLAY
	$('#gallery_item_ov').on('click', '.PREV, .NEXT', function(e) {
		e.preventDefault();
		if ($(this).hasClass('disabled')) { return false; }
		if ($(this).hasClass('PREV')) {
			$('#gallery_item_ov').data('current').prev().click();
		} else if ($(this).hasClass('NEXT')) {
			$('#gallery_item_ov').data('current').next().click();
		}
		//setGalleryOvSize();
	});
	$('.GALLERY').on('click', '.GALLERY_ITEM', function(e) {
		e.preventDefault();
		var thisItem = $(this);
		var galOv = $('#gallery_item_ov');
		var ovImg = galOv.children('img');
		galOv.addClass('active').removeClass('ready').data('current',thisItem);
		readyCount = 0;
		// Wait long enough for CSS transition (.375 seconds) to complete the fade out of the previous image before removing its src attribute
		setTimeout(function() {
			ovImg.attr('src','');
			showImageWhenReady(galOv,ovImg,imgSrc);
		}, 375);
		var imgSrc = thisItem.find('.IMG_SRC').val();
		$.imgpreload(imgSrc, function() {
			showImageWhenReady(galOv,ovImg,imgSrc);
		});
		var imgPreloadArray = [];
		if (thisItem.prev().length > 0) {
			imgPreloadArray.push(thisItem.prev().find('.IMG_SRC').val());
		}
		if (thisItem.next().length > 0) {
			imgPreloadArray.push(thisItem.next().find('.IMG_SRC').val());
		}
		if (thisItem.is(':first-child')) {
			$('#gallery_item_ov .PREV').addClass('disabled');
		} else {
			$('#gallery_item_ov .PREV').removeClass('disabled');
		}
		if (thisItem.is(':last-child')) {
			$('#gallery_item_ov .NEXT').addClass('disabled');
		} else {
			$('#gallery_item_ov .NEXT').removeClass('disabled');
		}
		$.imgpreload(imgPreloadArray);
	});
	// Both the fade out of the previous image and the load of the next image must be complete before the new image can fade in. Both events run this function.
	function showImageWhenReady(galOv,ovImg,imgSrc) {
		readyCount ++;
		if (readyCount > 1) {
			ovImg.attr({
				'src':imgSrc,
				'alt':$(this).find('img').attr('alt')
			});
			galOv.addClass('ready');
		}
	}
	
	// SPECIFIC PAGES
	if (isIndex) {
		simpleAutoCarousel($('.SUBHEAD_CAROUSEL'), 15000);
		var playerContainer = $('.VID_PLAYER_OV');
		var playerWrap = playerContainer.find('.VID_PLAYER_WRAPPER');
		var video = playerWrap.find('video');
		var player = video.get(0);
		var playButton = $('.VIDEO_PLAY');
		var videoCanPlayThrough = false;
		video.on('canplaythrough', function() {
			console.log('can play through');
			playerContainer.removeClass('waiting');
			videoCanPlayThrough = true;
		});
		playButton.click(function(e) {
			e.preventDefault();
			playWhenReady();
		});
		if (isVideoIndex) {
			$('.REEL_PLAY').click(function(e) {
				e.preventDefault();
				playWhenReady();
			});
		}
		video.on('ended', function() {
			playerContainer.removeClass('active').addClass('waiting');
		});
		video.on('waiting', function() {
			playerContainer.addClass('waiting');
			console.log('waiting');
		});
		playerContainer.find('.OV_CLOSE').click(function() {
			player.pause();
		});
		win.keyup(function(e) {
			if (e.keyCode == 27 || e.which == 27) {
				player.pause();
			}
		});
		var queryString = getQueryString();
		if (queryString['videoplay']) {
			playWhenReady();
		}
		function playWhenReady() {
			if (videoCanPlayThrough) {
				playVideo();
			} else {
				video.on('canplaythrough', function() {
					playVideo();
				});
			}
		}
		function playVideo() {
			playerContainer.addClass('active');
			player.play();
		}
	}
	
	if (isVideoGallery) {
		var catSelect = $('.CAT_SELECT');
		var thumbsList = $('.VID_THUMBS_LIST');
		function makeCatSelection() {
			if (catSelect.val() == '') {
				thumbsList.children('li').addClass('selected');
			} else {
				thumbsList.children('li').removeClass('selected').filter('.'+catSelect.val()).addClass('selected');
			}
		}
		makeCatSelection();
		catSelect.change(function() {
			makeCatSelection();
		});
		var queryString = getQueryString();
		if (queryString['filter']) {
			var queryStringFilter = queryString['filter'];
			if (queryStringFilter == 'all') {
				catSelect.val('');
				catSelect.change();
			} else if (catSelect.find('option[value="cat-'+queryStringFilter+'"]').length > 0) {
				catSelect.val('cat-'+queryStringFilter);
				catSelect.change();
			}
		}
	}
	
	if (isVideo) {
		var player;
		var videoUpdateInterval;
		var nextVideoTriggered = false;
		var nextPlayCountdownNumber = 15;
		var playerContainer = $('.VID_PLAYER_OV');
		var playerWrap = playerContainer.find('.VID_PLAYER_WRAPPER');
		var vid_player_current_id = playerContainer.find('.VID_PLAYER_CURRENT_ID');
		var vid_next_id = playerContainer.find('.VID_NEXT_ID');
		var vid_next_page = playerContainer.find('.VID_NEXT_PAGE');
		var vid_next_title = playerContainer.find('.VID_NEXT_TITLE');
		var vid_next_thumb = playerContainer.find('.VID_NEXT_THUMB');
		var vid_credits_timecode = playerContainer.find('.VID_CREDITS_TIMECODE');
		var next_play_countdown = $('.NEXT_PLAY_COUNTDOWN');
		var closeButton = $('.VID_PLAYER_OV .OV_CLOSE');
		function videoIntervalCheck() {
			clearInterval(videoUpdateInterval);
			if (vid_credits_timecode.val() != '' && vid_next_id.val()) {
				videoUpdateInterval = setInterval(function () {
					if (parseInt(player.getCurrentTime()) > parseInt(vid_credits_timecode.val())) {
						if (!nextVideoTriggered) {
							playerWrap.addClass('next-video-triggered');
							if (document.exitFullscreen) {
								document.exitFullscreen();
							} else if (document.msExitFullscreen) {
								document.msExitFullscreen();
							} else if (document.mozCancelFullScreen) {
								document.mozCancelFullScreen();
							} else if (document.webkitExitFullscreen) {
								document.webkitExitFullscreen();
							}
							nextVideoTriggered = true;
							nextPlayCountdownNumber = parseInt(player.getDuration()) - parseInt(player.getCurrentTime()) -1 < 12 ? parseInt(player.getDuration()) - parseInt(player.getCurrentTime()) -1  : 12
						} else {
							nextPlayCountdownNumber = nextPlayCountdownNumber - 1;
						}
						next_play_countdown.text(nextPlayCountdownNumber);
						if (nextPlayCountdownNumber <= 0) {
							clearVideoIntervalCheck();
							if (isSingleShow) {
								location.href = $('.VID_NEXT_PAGE').attr('href');
							} else {
								playNextVideo();
							}
						}
					}
				}, 1000);
			}
		}
		function clearVideoIntervalCheck() {
			clearInterval(videoUpdateInterval);
			playerWrap.removeClass('next-video-triggered');
		}
		window.onYouTubeIframeAPIReady = function(){
			player = new YT.Player('video_player', {
				width:1280,
				height:720,
				events: {
					onReady: function() {
						if (isSingleShow) {
							var queryString = getQueryString();
							if (queryString['autoplay']) {
								$('.TRIGGER_VIDEO').click();
							}
						}
					},
					onStateChange : function(e) {
						if (e.data == 1 && !mobileDeviceType()) {
							videoIntervalCheck() ;
						} else {
							clearVideoIntervalCheck();
						}
					}
				}
			});
		}
		$('.VID_THUMBS_LIST a.VIDEO_PLAY, .TRIGGER_VIDEO').click(function(e) {
			clearVideoIntervalCheck();
			nextVideoTriggered = false;
			var videoID = $(this).attr('data-video-ID');
			if (videoID) {
				e.preventDefault();
				playerContainer.addClass('active');
				if (videoID != vid_player_current_id.val()) {
					vid_player_current_id.val(videoID);
					vid_next_id.val($(this).attr('data-next-ID'));
					vid_next_page.attr('href', $(this).attr('data-next-page') + '?autoplay');
					vid_next_title.text($(this).attr('data-next-title'));
					vid_next_thumb.attr({
						'src':$(this).attr('data-next-thumb-src'),
						'alt':$(this).attr('data-next-title')
					});
					vid_credits_timecode.val($(this).attr('data-credits-timecode'));
					player.cueVideoById(videoID);
				}
				player.playVideo();
			}
		});
		closeButton.click(function() {
			player.pauseVideo();
			clearVideoIntervalCheck();
		});
		win.keyup(function(e) {
			if (e.keyCode == 27 || e.which == 27) {
				player.pauseVideo();
				clearVideoIntervalCheck();
			}
		});
		$('.CANCEL_AUTOPLAY').click(function(e) {
			e.preventDefault();
			clearVideoIntervalCheck();
		});
		$('.VID_NEXT_PAGE').click(function(e) {
			if (!isSingleShow) {
				e.preventDefault();
				playNextVideo();
			}
		});
		function playNextVideo() {
			$('.VIDEO_PLAY').each(function() {
				if ($(this).attr('data-video-ID') == vid_next_id.val()) {
					$(this).click();
					return false;
				}
			});
		}
	}
	if (isSingleShow) {
		// hiding and showing cast or crew lists
		var castCrew = $('.CAST_CREW');
		if (castCrew.find('tr.cast').length >= 10) {
			toggleCast();
		}
		if (castCrew.find('tr.crew').length >= 10) {
			toggleCrew();
		}
		castCrew.find('.TOGGLE_CAST').click(function() {
			 toggleCast();
		});
		castCrew.find('.TOGGLE_CREW').click(function() {
			 toggleCrew();
		});
		function toggleCast() {
			castCrew.toggleClass('hide-cast');
		}
		function toggleCrew() {
			castCrew.toggleClass('hide-crew');
		}
	}

}); /* end of as page load scripts */
