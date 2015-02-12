<?php
/**
 * Template Name: Current Playlist
 *
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 */

get_header(); ?> 			
<div class="whatpageisthis">template-current-playlist.php</div>		

<!-- <link href="<?php bloginfo('stylesheet_directory'); ?>/css/jplayer/blue.monday/jplayer.blue.monday.css" rel="stylesheet" type="text/css" /> -->

			<div class="container">
				<div class="row content">	
					<div class="span8" id="content">
							<h1><?php the_title(); ?></h1>
							
                            <!-- Need to generate a link using an ajax call http://wp.tutsplus.com/tutorials/getting-loopy-ajax-powered-loops-with-jquery-and-wordpress/ -->
                            <p id="program-page-link"><strong>Program:</strong> <span></span></p>
         
         
   
                            
                            <!-- episode info goes here-->
                            <div class="episode-info"></div><!--episode-info-->
                            	
							<ul class="playlist"></ul> <!--the playlist goes here-->

      
					</div><!-- /.span8 -->
	<?php get_sidebar(); ?>
				</div><!-- row content -->
			</div><!-- container -->
            
            
            
            <script type="text/javascript">
			
		
				
				function generatePlaylistReverse(data) {  
					//console.log("Inside generatePlaylistReverse");
  					var episodeinfo = jQuery('.episode-info');
					var playlistdiv = jQuery(".playlist");
					var hostname = ""
					
					//echo episode info
					//jQuery.each(data, function (i, item) {
						hostname =  data[0].host;
			        	jQuery('#program-page-link span').html(data[0].title);					
						episodeinfo.append('<strong>Started at:</strong> '+  moment(data[0].start).format("ha") + ' <br /> ' );
						episodeinfo.append('<strong>Hosted by:</strong> '+ hostname );
						
						//only display if available
						if (undefined != data[0].notes){
							episodeinfo.append('<p><strong>Show notes:</strong><br /> '+ data[0].notes +'</p>');
						}
			    	//});  
					if(undefined != data[0].playlist)
					{
						if((data[0].playlist).length > 0)
						{
							//echo actual playlist
							jQuery.each(data[0].playlist, function (i, item) { 
								
								var playlistItemComment = "";
								var micBreakClass = "";
								
								if (undefined != item.comment){
									if (item.comment != ""){
										playlistItemComment = '<div class="row"><div class="span6 offset1"><div class="playlist-item-comment"><strong>Notes: </strong> "' + item.comment + '"</div></div><div class="span1"><span aria-hidden="true" data-icon="&#xf075;"></span></div></div>';
									}
								}
								
								//check if item is a micbreak.  Value of variable is placed in class of playlist-item 
								if (undefined != item.isMicBreak){
									if (item.isMicBreak == true){
										//extra space is because this will be a CSS class applied to a div with mutlple classes
										micBreakClass = " mic-break";
									}
								}
								
								//spit out a row of a playlist
								playlistdiv.prepend('<li class="row "><div class="span8 playlist-item' + micBreakClass + '"><div class="row"><div class="span1"><span class="hour">' + moment(item.played).format("h:mma") + '</span></div><div class="span2"><span class=".playlist-item-artist">' + item.artist + '</span></div><div class="span3"><span class="playlist-item-title">' + item.title + '</span></div><div class="span2"><span class=".playlist-item-album">' + item.album + '</span></div></div>' + playlistItemComment + '</div></li>');  						
		    				});
							
							//playlist header info (note it's getting hidden on phones (responsive)
							playlistdiv.prepend('<br /><div class="row hidden-phone" aria-hidden="true"><div class="span8 playlist-headers"><div class="row"><div class="span2 offset1">Artist</div><div class="span3">Title</div><div class="span2">Album</div></div></div></div>');
						}
						else
						{
							playlistdiv.append('<div class="playlist-item-comment"><strong>No playlist data.</strong></div>')
						}
					}
				};
	
	
				
				function getcurrentplaylist(playlistID) {
					
						//define API Call
						var playlistjsonpath = "http://kbcsweb.bellevuecollege.edu/play/api/shows/?playlistId=";
						var jsonplaylisturl = playlistjsonpath + playlistID;
						//echo jsonplaylisturl;

						
						//ajax call to generate full playlist
						jQuery.ajax({
				          	url: jsonplaylisturl,
				        	dataType: 'jsonp',
				          	success: function (data) {
				          		if(data.length>0)
				          		{
									generatePlaylistReverse(data); 
								}
								else
								{
									jQuery('.episode-info, .playlist').html("No Playlist information.");
									//console.log("data returned by query on playlistId is empty");
								}

				   			}
				        });
				    }
				    

				
				
			
				function docurrentshow() {
					//console.log("Inside docurrentshow");
					//var currentshowjson = "http://kbcsweb.bellevuecollege.edu/play/api/shows/current/";
					var currentshowjson = "http://kbcsweb.bellevuecollege.edu/play/api/nowplaying/";
					
					//entire purpose of this call is to get the playist ID
					jQuery.ajax({
			          	url: currentshowjson,
			        	dataType: 'jsonp',
			          	success: function (data) {
			          		if(data.playlistId != "0") 
			          		
			          		{
			          			//console.log("playlist id:"+data.playlistId);
								getcurrentplaylist(data.playlistId); 
							}
							else
							{
								 //jQuery('.episode-info, .playlist').html("No information.");
								//console.log("querying /nowplaying ... returns playlist id zero");
								var urljson = "http://kbcsweb.bellevuecollege.edu/play/api/shows/current/";

									jQuery.ajax({
						          	url: urljson,
						        	dataType: 'jsonp',
						          	success: function (data) {
			          		//###################
			          		// Code is failing on the line below this note when there is no data in the call to /api/shows/current/
			          		// Should we remove .playlistID? Seems like jQuery is trying to check for something that isn't there. JSON returned [] so there is no playlistID to check for a "0" value.
			          		// Console Error Msg: Unable to get value of the property 'playlistId': object is null or undefined (see screenshot on PC)
			          		// We are currently making for JSON calls every 20 seconds. Should we clean that up a bit? 
			          		//###################
						          		if(data[0].playlistId != "0")
						          		{
						          			//console.log("playlist id:"+data[0].playlistId);
											getcurrentplaylist(data[0].playlistId); 
										}
										else
										{
											//console.log("querying /shows/current ... returns playlist id zero");
											//jQuery('.episode-info, .playlist').html("No Playlist information.");
										}
						          	}
						          });
							}
			   			}
			        });
					
					
					setTimeout(function(){
						 jQuery('.episode-info, .playlist').html("");
						 docurrentshow();
					}, 20000);

		
					
				}
				
				
				jQuery(function() {
					docurrentshow()
				});
				
				
				
			
			
			
		</script>
        
	<?php get_footer(); ?>