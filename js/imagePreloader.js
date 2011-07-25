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