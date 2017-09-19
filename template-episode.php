<?php
/**
 * Template Name: Episode Page
 *
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 */

get_header(); ?> 			
<div class="whatpageisthis">template-episode.php</div>		

<link href="<?php bloginfo('stylesheet_directory'); ?>/css/jplayer/blue.monday/jplayer.blue.monday.css" rel="stylesheet" type="text/css" />

			<div class="container">
				<div class="row content">	
					<div class="span8" id="content">
							<h1><?php the_title(); ?>: <span id="episode-program-title"></span></h1>
							
                            <!-- Need to generate a link using an ajax call http://wp.tutsplus.com/tutorials/getting-loopy-ajax-powered-loops-with-jquery-and-wordpress/ -->
                            <p id="program-page-link"><strong>Program:</strong> </p>
         
         
         <!--used as source, but gets moved -->                   
		<div id="jplayer-html">
        <div class="jplayer-block">
        
        <div id="jquery_jplayer_1" class="jp-jplayer"></div>

		<div id="jp_container_1" class="jp-audio">
			<div class="jp-type-single">
				<div class="jp-gui jp-interface">
					<ul class="jp-controls">
						<li><a href="javascript:;" class="jp-play" tabindex="1">play</a></li>
						<li><a href="javascript:;" class="jp-pause" tabindex="1">pause</a></li>
						<li><a href="javascript:;" class="jp-stop" tabindex="1">stop</a></li>
						<li><a href="javascript:;" class="jp-mute" tabindex="1" title="mute">mute</a></li>
						<li><a href="javascript:;" class="jp-unmute" tabindex="1" title="unmute">unmute</a></li>
						<li><a href="javascript:;" class="jp-volume-max" tabindex="1" title="max volume">max volume</a></li>
					</ul>
					<div class="jp-progress">
						<div class="jp-seek-bar">
							<div class="jp-play-bar"></div>
						</div>
					</div>
					<div class="jp-volume-bar">
						<div class="jp-volume-bar-value"></div>
					</div>
					<div class="jp-time-holder">
						<div class="jp-current-time"></div>
						<div class="jp-duration"></div>

						<ul class="jp-toggles">
							<li><a href="javascript:;" class="jp-repeat" tabindex="1" title="repeat">repeat</a></li>
							<li><a href="javascript:;" class="jp-repeat-off" tabindex="1" title="repeat off">repeat off</a></li>
						</ul>
					</div>
				</div>
				<div class="jp-playlist">
					<ul>
						<li></li>
					</ul>
				</div>
				<div class="jp-no-solution">
					<span>Update Required</span>
					To play the media you will need to either update your browser to a recent version or update your <a href="http://get.adobe.com/flashplayer/" target="_blank">Flash plugin</a>.
				</div>
			</div>
		</div>                            
          </div><!--.jplayer-block-->   
          </div> <!--#jplayer-html-->       
                            
                            
                            <!-- episode info goes here-->
                            <div class="episode-info"></div><!--episode-info-->
                            	
							<ul class="playlist"></ul> <!--the playlist goes here-->

      
					</div><!-- /.span8 -->
	<?php get_sidebar(); ?>
				</div><!-- row content -->
			</div><!-- container -->
            
            
            
            <script type="text/javascript">
				function querystring(key) {
				   var re=new RegExp('(?:\\?|&)'+key+'=(.*?)(?=&|$)','gi');
				   var r=[], m;
				   while ((m=re.exec(document.location.search)) != null) r.push(m[1]);
				   return r;
				}
				
				function generatePlaylist(data) {  
  					var episodeinfo = jQuery('.episode-info');
					var playlistdiv = jQuery(".playlist");
					var hostname = ""
					playlistdiv.append('<div class="row hidden-phone" aria-hidden="true"><div class="span8 playlist-headers"><div class="row"><div class="span2 offset1">Artist</div><div class="span3">Title</div><div class="span2">Album</div></div></div></div>');
					
					jQuery.each(data, function (i, item) {
						hostname =  item.host;
			        	jQuery('#episode-program-title, #program-page-link').append(item.title);					
						episodeinfo.append('<h2>'+ moment(item.start).format("dddd M/D/YYYY")+ ' <small>&nbsp; ' +  moment(item.start).format("ha")  +'</small></h2>');
						episodeinfo.append('<p class="hostedby">Hosted by: '+ hostname +'</p>');
						
						//only display if available
						if (undefined != item.notes){
							episodeinfo.append('<p><strong>Show notes:</strong><br /> '+ item.notes +'</p>');
						}
						
						var numberofaudiofiles = availableAudio(item.start,item.length);
						
						//YES! we can display the audio!
						if (numberofaudiofiles > 0) {
							episodeinfo.append('<p class="showplaylist"><strong><span aria-hidden="true" data-icon="&#xf00b;"></span>Playlist &amp Audio Archive</strong></p>');
							
							jQuery("#jplayer-html").find('.jplayer-block').appendTo(episodeinfo);
						
							if (numberofaudiofiles == 1) {
								//initiatie jplayer call for one audio file
								jQuery("#jquery_jplayer_1").jPlayer({
									ready: function (event) {
										jQuery(this).jPlayer("setMedia", {
											mp3: item.audioUrl
										});
									},
									swfPath: "<?php bloginfo('stylesheet_directory'); ?>/js/",
									supplied: "mp3",
									wmode: "window"
								});	
								
								jQuery("#jp_container_1").find(".jp-playlist").hide();
							}else{
								
								var myplaylist = new jPlayerPlaylist({
									jPlayer: "#jquery_jplayer_1",
									},[],{
										 playlistOptions: {
											displayTime: 0
										},
										swfPath: "<?php bloginfo('stylesheet_directory'); ?>/js/",
										supplied: "mp3",
										wmode: "window"
								});
								
								var hournum = 1;
								var audiourl = "";
								var archiveurl = "//kbcsweb.bellevuecollege.edu/playlist/audioarchive/";
								var mp3suffix = "-01.mp3";
								
								for (var i=0;i<numberofaudiofiles;i++){
									//alert (i);
									hourtext = "Hour " + (hournum + i);
									audiourl = archiveurl + moment(item.start).add('hours', i).format("YYYYMMDDHHmm") + mp3suffix;
									
									//ads audio file to playlist of player
									myplaylist.add({
										title:hourtext,
										mp3:audiourl
									});
								}
							}
							
						} else {
							episodeinfo.append('<p class="showplaylist"><strong><span aria-hidden="true" data-icon="&#xf00b;"></span>Playlist Archive</strong></p>');	
						}
						
						
	
	
			    	});  
					jQuery.each(data[0].playlist, function (i, item) { 
						
						var playlistItemComment = "";
						var micBreakClass = "";
						
						if (undefined != item.comment){
							if (item.comment != ""){
								playlistItemComment = '<div class="row"><div class="span6 offset1"><div class="playlist-item-comment"><strong>Note: </strong> "' + item.comment + '"</div></div><div class="span1"><span aria-hidden="true" data-icon="&#xf075;"></span></div></div>';
							}
						}
						
						//check if item is a micbreak.  Value of variable is placed in class of playlist-item 
						if (undefined != item.isMicBreak){
							if (item.isMicBreak == true){
								micBreakClass = " mic-break";
							}
						}
	
						playlistdiv.append('<li class="row "><div class="span8 playlist-item' + micBreakClass + '"><div class="row"><div class="span1"><span class="hour">' + moment(item.played).format("h:mma") + '</span></div><div class="span2"><span class=".playlist-item-artist">' + item.artist + '</span></div><div class="span3"><span class="playlist-item-title">' + item.title + '</span></div><div class="span2"><span class=".playlist-item-album">' + item.album + '</span></div></div>' + playlistItemComment + '</div></li>');  						
    				});
				};
	
				
				
				jQuery(function() {
			    	var jsonpath = "//kbcsweb.bellevuecollege.edu/play/api/shows/?playlistId=";
					var playlistId = querystring('playID');
					var jsonurl = jsonpath + playlistId;
					
					jQuery.ajax({
			          	url: jsonurl,
			        	dataType: 'jsonp',
			          	success: function (data) {
							generatePlaylist(data); 
			   			}
			        });
				});
				
				
				
			
			
			
		</script>
        
	<?php get_footer(); ?>