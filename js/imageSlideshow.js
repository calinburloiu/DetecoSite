/**
 * Functions that help in preloading images with Javascript, including a
 * feature to start preloading after the page is completely loaded.
 */

/**
 * Starts preloading all the images with their URLs passed as argument.
 */
function preload(imgURLs) 
{
	var images = new Array();
	for (i = 0; i < imgURLs.length; i++)
	{
		images[i] = new Image();
		images[i].src = imgURLs[i];
	}
}

/**
 * Schedules a function to be called when the page is loaded.
 *
 * @param	function func	the function
 * @param	Array params	the function's parameters
 */
function addLoadEvent(func, params) 
{
	var oldonload = window.onload;
	if (typeof window.onload != 'function') 
	{
		window.onload = function()
		{
			func(params);
		}
	}
	else 
	{
		window.onload = function() 
		{
			if (oldonload) 
			{
				oldonload();
			}
			func(params);
		}
	}
}

/**
 * Schedules image preloading when the page is loaded.
 *
 * @param	Array imgURLs	the URLs of the images to be preloaded
 */
function preloadOnLoad(imgURLs)
{
	addLoadEvent(preload, imgURLs);
}



/** Functions that provide a way to show a slideshow of images in an
 * image tag. Preloading is recomended.
 *
 * In order to make it work, the array ss_Images needs to be populated with
 * the URLs of the images and ss_ImgId must be set with the id of the HTML
 * img element that is going to hold each image in the slideshow. The time
 * intervals can be also customized.
 */
 
// Images array
var ss_Images = new Array();
ss_Images[0] = '/images/home_lakeview01.jpg';
ss_Images[1] = '/images/home_lakeview02.jpg';
ss_Images[2] = '/images/home_lakeview03.jpg';
var ss_ImgId = 'slideshow';
 
// States
var SS_WAIT = 0;
var SS_FADEOUT = 1;
var SS_FADEIN = 2;

// Time intervals
var SS_WAIT_INTERV = 4250;
var SS_FADEOUT_INTERV = 750;
var SS_FADEIN_INTERV = 750;
var SS_FPS = 25;
 
var ss_On = false;
var ss_State = SS_WAIT;
var ss_CrtImg = 0;
var ss_Timer;
var ss_tFade;
var ss_FadeStepsCnt;

/**
 * Timeout handler used for the slideshow.
 */
function slideshowHandler()
{
	if(ss_On == false)
		return;
	
	if(ss_State == SS_WAIT)
	{
		// Switch to fadeout state.
		ss_State = SS_FADEOUT;
		ss_tFade = SS_FADEOUT_INTERV / SS_FPS;
		ss_FadeStepsCnt = ss_tFade;
		setTimeout("slideshowHandler()", SS_FADEOUT_INTERV / SS_FPS);
	}
	else if(ss_State == SS_FADEOUT)
	{
		if(ss_tFade > 0)
		{
			// Image fading
			var opacity = ss_tFade / ss_FadeStepsCnt;
			var imgElem = document.getElementById(ss_ImgId);
			imgElem.style.opacity = opacity;
			
			ss_tFade = ss_tFade - 1;
			setTimeout("slideshowHandler()", SS_FADEOUT_INTERV / SS_FPS);
		}
		// Switch to fadein state.
		else
		{
			ss_CrtImg = (ss_CrtImg + 1) % ss_Images.length;
			var imgElem = document.getElementById(ss_ImgId);
			imgElem.src = ss_Images[ss_CrtImg];
		
			ss_State = SS_FADEIN;			
			ss_tFade = SS_FADEIN_INTERV / SS_FPS;
			setTimeout("slideshowHandler()", SS_FADEIN_INTERV / SS_FPS);
		}
	}
	else if(ss_State == SS_FADEIN)
	{
		if(ss_tFade > 0)
		{
			// Image fading
			var opacity = 1 - ss_tFade / ss_FadeStepsCnt;
			var imgElem = document.getElementById(ss_ImgId);
			imgElem.style.opacity = opacity;
			
			ss_tFade = ss_tFade - 1;
			setTimeout("slideshowHandler()", SS_FADEIN_INTERV / SS_FPS);
		}
		// Switch to wait state again.
		else
		{
			ss_State = SS_WAIT;
			setTimeout("slideshowHandler()", SS_WAIT_INTERV);
		}
	}
}

/**
 * Starts the slideshow from the first picture.
 */
function startSlideshow()
{
	ss_On = true;
	ss_CrtImg = 0;
	
	ss_State = SS_WAIT;
	setTimeout("slideshowHandler()", SS_WAIT_INTERV);
	
/*	// Image is initially transparent.
	var imgElem = document.getElementById(ss_ImgId);
	imgElem.style.opacity = 0;
	// Start in fadein state.
	ss_State = SS_FADEIN;			
	ss_tFade = SS_FADEIN_INTERV / SS_FPS;
	setTimeout("slideshowHandler()", SS_FADEIN_INTERV / SS_FPS);*/
}

/**
 * Stops the slideshow.
 */
function stopSlideshow()
{
	ss_On = false;
	clearTimeout(ss_Timer);
}

/**
 * Initializes the slideshow by preloading its pictures when page finishes
 * loading and starts the slideshow.
 */
function initSlideshow()
{
	addLoadEvent(function() {
		preload(ss_Images);
		startSlideshow();
	} , null);
}


initSlideshow();