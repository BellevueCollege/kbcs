<?php
/**
 * The template for displaying all posts.
 *
 * Default Post Template
 *
 * Page template with a fixed 940px container and right sidebar layout
 *
 * @package WordPress
 * @subpackage WP-Bootstrap
 * @since WP-Bootstrap 0.1
 */

get_header(); 

$programId = get_post_meta($post->ID, 'programid_mb', TRUE);

?>
<div class="whatpageisthis">single-programs.php</div>	
		
<link href="<?php bloginfo('stylesheet_directory'); ?>/css/jplayer/blue.monday/jplayer.blue.monday.css" rel="stylesheet" type="text/css" />

<div class="container">
		<div class="row">
			<div class="span8" id="content">
            <div id="hero-block">

	            <div class="row-fluid"  id="hero-text-wrapper">
                     <div class="span9" id="hero-text">
                     <div class="inner">
                         <h1><?php the_title();?></h1>
                         
                         <?php
                         echo get_the_term_list( $post->ID, 'staff', '<p class="hostedby">Hosted by ', ', ', '</p>' );
                         ?>
                         
                         <p class="program-days-times">
                				<?php
									$air_time = airTimings($post->ID);
									//echo $count;
									echo $air_time; ?>
                 			</p> 
                     	</div><!-- .inner -->
                     </div> <!-- hero-text -->

                </div> <!-- row -->

                <div id="hero-image">
                <?php while ( have_posts() ) : the_post(); 
				
					
		
					if ( has_post_thumbnail() ) {  
    					the_post_thumbnail( 'programs-hero' );
 						
					} else {
						?>
                        <?php $upload_dir = wp_upload_dir(); ?>

                        	<img src="<?php echo $upload_dir['baseurl']; ?>/2013/03/program-hero-generic.jpg" alt="photo of cds in KBCS library" />
                        <?php	
					}
					?>
                </div> <!-- #hero-image -->
	             </div> <!-- hero-block -->
                <?php 
					endwhile;
					 
						wp_reset_query();
						while ( have_posts() ) : the_post(); ?>
                        	
                             <?php  ?>
                        		
							<?php the_content();?>
						<?php endwhile;?>
						 
					
	
					<!--episodes go here-->
					<div id="episodes"></div><!--#episodes-->		
							
<!--templates for reuse in DOM-->			
<div id="jquery_jplayer_template" class="jp-jplayer"></div>
<div id="jp_container_template" class="jp-audio">
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
</div>  <!--#jp_container_template-->   
<!--End Templates-->     
					
			</div><!-- #content span8 -->
	        <?php get_sidebar(); // sidebar 1 ?>
    	</div><!-- row -->
</div><!-- container -->  


<script type="text/javascript">

	//THIS FUNCTION IS DUPLICATED IN OTHER PAGES
	function querystring(key) {
	   var re=new RegExp('(?:\\?|&)'+key+'=(.*?)(?=&|$)','gi');
	   var r=[], m;
	   while ((m=re.exec(document.location.search)) != null) r.push(m[1]);
	   return r;
	}
	
	
	function successCallbackPlaylist(data, plid){
		var playlistdiv = jQuery("#playId"+plid);
	
		
		//retreive episode/show related content
		jQuery.each(data, function (i, item) {
			
			
			var numberofaudiofiles = availableAudio(item.start,item.length);
						
			if (numberofaudiofiles > 0) {
				var cloneJPlayer = jQuery('#jquery_jplayer_template').clone(); 
				var cloneJContainer = jQuery('#jp_container_template').clone(); 
				cloneJPlayer.attr('id', 'jplayer_'+plid);
				cloneJContainer.attr('id', 'jp_container_'+plid);
				
				//alert(clone.attr('id'));            // gives 'abc'
				playlistdiv.append(cloneJPlayer);
				playlistdiv.append(cloneJContainer);     // <==== Put the clone into the document
				
			
				if (numberofaudiofiles == 1) {
					//initiatie jplayer call for one audio file
					jQuery('#jplayer_'+plid).jPlayer({
						ready: function (event) {
							jQuery(this).jPlayer("setMedia", {
								mp3: item.audioUrl
							});
						},
						swfPath: "<?php bloginfo('stylesheet_directory'); ?>/js/",
						supplied: "mp3",
						wmode: "window",
						cssSelectorAncestor: "#jp_container_"+plid
					});	
					
					jQuery("#jp_container_"+plid).find(".jp-playlist").hide();
				}else{
					
					var myplaylist = new jPlayerPlaylist({
						jPlayer: '#jplayer_'+plid,
						cssSelectorAncestor: "#jp_container_"+plid
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
					var archiveurl = "http://kbcsweb.bellevuecollege.edu/playlist/audioarchive/";
					var mp3suffix = "-01.mp3";
					
					for (var i=0;i<numberofaudiofiles;i++){
						//alert (i);
						hourtext = "Hour " + (hournum + i);
						audiourl = archiveurl + moment(item.start).add('hours', i).format("YYYYMMDDHHmm") + mp3suffix;
						myplaylist.add({
							title:hourtext,
							mp3:audiourl
						});
					}
				}
				
			}
			
			
			
		}); 
		
		
		
		
		playlistdiv.append('<div class="row hidden-phone" aria-hidden="true"><div class="span8 playlist-headers"><div class="row"><div class="span2 offset1">Artist</div><div class="span3">Title</div><div class="span2">Album</div></div></div></div><ul class="playlist"></ul>');
		
		
		
		//retreive playlist tiems
		jQuery.each(data[0].playlist, function (i, item) { 		
			var playlistItemComment = "";
			var micBreakClass = "";
			
			if (undefined != item.comment){
				if (item.comment != ""){
					playlistItemComment = '<div class="row"><div class="span6 offset1"><div class="playlist-item-comment"><strong>Host said: </strong> "' + item.comment + '"</div></div><div class="span1"><span aria-hidden="true" data-icon="&#xf075;"></span></div></div>';
				}
			}
			
			//check if item is a micbreak.  Value of variable is placed in class of playlist-item 
			if (undefined != item.isMicBreak){
				if (item.isMicBreak == true){
					micBreakClass = " mic-break";
				}
			}
			
			//build playlist item
			playlistdiv.find("ul.playlist").append('<li class="row "><div class="span8 playlist-item' + micBreakClass + '"><div class="row"><div class="span1"><span class="hour">' + moment(item.played).format("h:mma") + '</span></div><div class="span2"><span class="playlist-item-artist">' + item.artist + '</span></div><div class="span3"><span class="playlist-item-title">' + item.title + '</span></div><div class="span2"><span class="playlist-item-album">' + item.album + '</span></div></div>' + playlistItemComment + '</div></li>');  						
		});
					
		
		
		
		//return playlistdiv;
	}
	
	
	
	//Will display list of episodes
	function successCallbackEpisodes(data, pageNum,programId) {
		var episodes= jQuery('#episodes');
		var hostname = ""
		var playlistbuttontext = "Playlist Archive"
		pageNum = parseFloat(pageNum);
		

		
		var nextPage = pageNum - 1;
		var prevPage = pageNum + 1;
		var nextPageLink = '<li class="next"><a href="<?php echo get_permalink( $post->ID ); ?>/?pager=' + nextPage + '">Newer &rarr;</a></li>'
		//if on first page
				
		if (pageNum == 0){
			nextPageLink = '';
		} 
				
		
		jQuery.each(data, function (i, item) {
			
			//skip this item if it happens in the future
			if (moment(item.start) > moment()) {
				return;	
			}
			
			//save host name
			hostname =  item.host;
		
			//if there is an audio file
			if (availableAudio(item.start,item.length) > 0) {
				playlistbuttontext = "Playlist &amp; Audio Archive";
			}
			
			
								
			
			//Run through the loop elements backwards since hte data is not coming in reverse chronological order
			
			episodes.prepend('<button type="button" class="btn btn-inverse" data-toggle="collapse" data-target="#playId'+ item.playlistId + '"><span aria-hidden="true" data-icon="&#xf00b;"></span>' + playlistbuttontext + '</button><div id="playId'+ item.playlistId + '" class="collapse playlistbox"><br /></div>');
			
			//only display if available
			if (undefined != item.notes){
				episodes.prepend('<p><strong>Show notes:</strong><br /> '+ item.notes +'</p>');
			}
			
			episodes.prepend('<p class="hostedby">Hosted by: '+ hostname +'</p>');
			
			//Add ajax to get the segments associated with this program id and date
            jQuery.ajax({
                url: jsonurl,
                data: { programid: programId, date: moment(item.start).format("M/D/YYYY") },
                //dataType: 'jsonp',
                success: function (response) {

                }
            });



			episodes.prepend('<h2>'+ moment(item.start).format("M/D/YYYY")+ ' <small>&nbsp; ' +  moment(item.start).format("ha")  +'</small></h2>');

		});
		
		episodes.append('<ul class="pager"><li class="previous"><a href="<?php echo get_permalink( $post->ID ); ?>?pager=' + prevPage + '">&larr; Older</a></li>' + nextPageLink + '</ul>');
		
	
	}	
	
	
	jQuery(function() {	

		var jsonpath = "http://kbcsweb.bellevuecollege.edu/play/api/shows/?programID=";
		var programId = <?php echo $programId ?>;
		var pageNum = querystring('pager'); 
		var pagestring = "&page="
		if (pageNum == "") {
			pageNum = "0";
		} 
		var jsonurl = jsonpath + programId + pagestring + pageNum; 
		
		
		jQuery.ajax({
			url: jsonurl,
			dataType: 'jsonp',
			success: function (data) {
				successCallbackEpisodes(data, pageNum,programId);
			}
		});
			
		jQuery('#episodes').on("show", ".collapse", function () {
			//check to see if element has playlistId stored
			var playidval = jQuery.data(this, "playlistId");
			
			if (null == playidval) {
				//get id (playlistid with a prefix) from div, then remove prefix so it's just the numeric playlistId
				var playlistId = jQuery(this).attr('id');   
				playlistId = playlistId.replace(/\D/g,'');   
				
				
				//add playlistId to the html element to be used later
				jQuery.data(this, "playlistId", playlistId);
				var playidval = jQuery.data(this, "playlistId");
				
				//begin JSON playlist call
				var jsonpath = "http://kbcsweb.bellevuecollege.edu/play/api/shows/?playlistId=";
				var jsonurl = jsonpath + playlistId;
				
				jQuery.ajax({
					url: jsonurl,
					dataType: 'jsonp',
					success: function (data) {
						successCallbackPlaylist(data, playlistId); 
					}
				});
				
			}
			//jQuery(this).text("" + playlistId);  //test
			//var chickens = showPlaylistInfo();
			//jQuery(this).html(showPlaylistInfo(playidval));
			
		});	
	});
		</script>
        
<?php get_footer(); ?>