//var episode_url_suffix = "episode/?playId=";
var defaultnowplayingtext = "";

function nowPlaying () {
		var nowplaying = jQuery("#nowplaying");
		var nowplayingprogram = "";
		var nowplayingtitle ="";
		var nowplayingdetails = "";
		var nowplayingtext = defaultnowplayingtext;
		
		jQuery.ajax({
			url: "http://kbcsweb.bellevuecollege.edu/play/api/nowplaying",
			dataType: 'jsonp',
			success: function (data) {
				
				
				var nowplayingtitle ="";
				var nowplayingdetails = "";
				var nowplayingprogram ="";
				
		
				if ( data.playlistId === "0"){
					nowplayingprogram = '<div id="nowplayingprogram">' + nowplayingtext + data.title + '</div>';
					//console.log("nowplaying returned playlist id zero. There will be no update, till we get a valid playlist id.");
					
				} else {
					
					//createHTML(data,nowplaying,nowplayingtext);
					
					nowplayingprogram = '<div id="nowplayingprogram">' + nowplayingtext;
					
					if (undefined !== data.timeOutTitle)
					{
							nowplayingprogram =  nowplayingprogram +  data.timeOutTitle;	
							//console.log("nowplaying program:"+nowplayingprogram);
					}
					
					nowplayingprogram =  nowplayingprogram  + '</div>';

					
					if (undefined !== data.title) {
						nowplayingtitle = '<span id="nowplayingtitle">"' + data.title + '"</span>';
						//console.log("nowplayingtitle:"+nowplayingtitle);
					}
					var nowplayingdetails ="";
					if (undefined !== data.artist) {
					nowplayingdetails = '<span id="nowplayingdetails"><span class="artist-by">-</span> ' + data.artist + '</span>';
					//console.log("nowplayingdetails:"+nowplayingdetails);
					}
					nowplaying.html(nowplayingprogram + nowplayingtitle + " " + nowplayingdetails); 
					
				}
					 
				nowplaying.html(nowplayingprogram + nowplayingtitle + " " + nowplayingdetails); 
				
			}
		});
		
		//run again in 20 seconds
		setTimeout('nowPlaying();',20000);
}



function liveStreamPopUp(str){
	var url = str;
    var windowName = "idealPopUp";
    var windowDetails = 'toolbar=0,scrollbars=0,location=0,statusbar=0,menubar=0,resizable=0,width=680,height=450'; 
	var windowLocation = 'left = 322,top = 259';             
    window.open(url, windowName, windowDetails, windowLocation); 
}

//only allowed to play audio archives that aired in the last 2 weeks.
function isPlayableArchive(daytime) {
	var exptime = 15; //this is in days
	var a = moment();
	var b = moment(daytime);
	var c = a.diff(b, 'days');
	if (c < 15) { 
		return true;
	} else {
		return false;	
	}
}

//figure out if there are 0, 1, 2, 3 or more audio files available for a given episode
//Note this function should replace isPlayableArchive() above.
function availableAudio(daytime, length) {
	var exptime = 15; //# of dayts before archive expires
	var availableaudio = 0;
	
	//find # hours of episode (used to calculate available audio)
	var hourslong = parseInt(length)/60;
	
	var a = moment();
	var b = moment(daytime);
	var c = a.diff(b, 'days');
	
	if (c < exptime) {
		//not expired
		var elapsedtime = a.diff(b, 'hours')
		diff = hourslong - elapsedtime;
		if ( diff < 1) {
			//episode already ended
			availableaudio = hourslong;
		} else {
			//episode still on air
			availableaudio = hourslong - diff;
		}
		//alert (availableaudio); 
		return availableaudio;
	} else {
		//passed expiration
		return availableaudio;	
	}

}


		
jQuery(function() {
	
	//what's playing on air
	defaultnowplayingtext = jQuery("#nowplaying").html();
	nowPlaying();
	
	//popup for streaming audio
	var streamurl = jQuery('.streamlive').attr('href');
	
	jQuery('a.streamlive').click( function(event){
			event.preventDefault();
			liveStreamPopUp(streamurl);
	});
	
	//add tooltip functionality on logo/homepage
	jQuery('#header-logo').find('img').tooltip({
        placement : 'right'
    });
	 
});



/**
 * Equal Heights Plugin
 * Equalize the heights of elements. Great for columns or any elements
 * that need to be the same size (floats, etc).
 * 
 * Version 1.0
 * Updated 12/10/2008
 *
 * Copyright (c) 2008 Rob Glazebrook (cssnewbie.com) 
 *
 * Usage: $(object).equalHeights([minHeight], [maxHeight]);
 * 
 * Example 1: $(".cols").equalHeights(); Sets all columns to the same height.
 * Example 2: $(".cols").equalHeights(400); Sets all cols to at least 400px tall.
 * Example 3: $(".cols").equalHeights(100,300); Cols are at least 100 but no more
 * than 300 pixels tall. Elements with too much content will gain a scrollbar.
 * 
 */

(function($) {
	$.fn.equalHeights = function(minHeight, maxHeight) {
		tallest = (minHeight) ? minHeight : 0;
		this.each(function() {
			if($(this).height() > tallest) {
				tallest = $(this).height();
			}
		});
		if((maxHeight) && tallest > maxHeight) tallest = maxHeight;
		return this.each(function() {
			$(this).height(tallest).css("overflow","auto");
		});
	}
})(jQuery);
			

		
		