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

$post_id = get_the_ID();


define("META_KEY", "_audio_meta");
global $wpdb, $audio_metabox, $post;
$output = array();
$sql = "select * from wp_postmeta where meta_key=META_KEY";
$results = $wpdb->get_results($sql);
foreach($results as $audio)
{
    if(isset($audio->post_id) && isset($audio->meta_key))
    {
        $meta = get_post_meta($audio->post_id,$audio->meta_key,TRUE);
        //error_log("meta programs :".$meta["_airdate_group"][0]);
        if(isset($meta["_airdate_group"]) && isset($meta["_airdate_group"][0]) )
        {
            //error_log("airdate group:".print_r($meta["_airdate_group"],true));

            foreach($meta["_airdate_group"] as $airAudio)
            {
                //error_log("meta programs :".$airAudio["program_terms"]);
                //error_log("meta date :".$airAudio["air_date"]);
                $program_terms = $airAudio["program_terms"];
                if(!empty($airAudio["air_date"]))
                {
                    $air_date = $airAudio["air_date"];
                    $content = "";
                    //error_log("program term :".$program_terms);
                    //error_log("air date :".$air_date);
                    if($program_terms == $post_id)
                    {  
                        $content_post = get_post($audio->post_id);
                        $content = $content_post->post_content;
                        //$content = wp_oembed_get($content);
						$content = apply_filters('the_content', $content);
						$content = str_replace(']]>', ']]&gt;', $content);
                        $output[] = array("air_date"=>$air_date,"content" => urlencode($content));
                    }
                }
            }
        }
    }
}
$audio_content = json_encode($output);
error_log("audio content :".$audio_content);

//get json data
//$playlistData = file_get_contents("http://kbcsweb.bellevuecollege.edu/play/api/shows/?programID=".$programId);
//error_log($playlistData);
?>
<div class="whatpageisthis">single-programs.php</div>	
		
<link href="<?php bloginfo('stylesheet_directory'); ?>/css/jplayer/blue.monday/jplayer.blue.monday.css" rel="stylesheet" type="text/css">

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
	function successCallbackEpisodes(data, pageNum) {
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
// Display audio content
            var audio_content = '<?php echo $audio_content; ?>';
            var extract_json = jQuery.parseJSON(audio_content);
            //console.log("json extract :"+extract_json);
            if(extract_json.length>0)
            {
               // console.log("coming here");
                //for each(var audio in extract_json)
                for(var i=0;i<extract_json.length;i++)
                {
                    if(extract_json[i]["air_date"])
                    {
                        if(moment(item.start).format("YYYY-M-D") == extract_json[i]["air_date"])
                        {
                            //console.log("audio content :"+extract_json[i]["content"]);
                            var content = extract_json[i]["content"];

                            episodes.prepend('<p>'+urldecode(content)+'</p>');
                        }
                    }

                }
            }


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
				successCallbackEpisodes(data, pageNum);
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

    function urldecode (str) {
        // http://kevin.vanzonneveld.net
        // +   original by: Philip Peterson
        // +   improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
        // +      input by: AJ
        // +   improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
        // +   improved by: Brett Zamir (http://brett-zamir.me)
        // +      input by: travc
        // +      input by: Brett Zamir (http://brett-zamir.me)
        // +   bugfixed by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
        // +   improved by: Lars Fischer
        // +      input by: Ratheous
        // +   improved by: Orlando
        // +   reimplemented by: Brett Zamir (http://brett-zamir.me)
        // +      bugfixed by: Rob
        // +      input by: e-mike
        // +   improved by: Brett Zamir (http://brett-zamir.me)
        // +      input by: lovio
        // +   improved by: Brett Zamir (http://brett-zamir.me)
        // %        note 1: info on what encoding functions to use from: http://xkr.us/articles/javascript/encode-compare/
        // %        note 2: Please be aware that this function expects to decode from UTF-8 encoded strings, as found on
        // %        note 2: pages served as UTF-8
        // *     example 1: urldecode('Kevin+van+Zonneveld%21');
        // *     returns 1: 'Kevin van Zonneveld!'
        // *     example 2: urldecode('http%3A%2F%2Fkevin.vanzonneveld.net%2F');
        // *     returns 2: 'http://kevin.vanzonneveld.net/'
        // *     example 3: urldecode('http%3A%2F%2Fwww.google.nl%2Fsearch%3Fq%3Dphp.js%26ie%3Dutf-8%26oe%3Dutf-8%26aq%3Dt%26rls%3Dcom.ubuntu%3Aen-US%3Aunofficial%26client%3Dfirefox-a');
        // *     returns 3: 'http://www.google.nl/search?q=php.js&ie=utf-8&oe=utf-8&aq=t&rls=com.ubuntu:en-US:unofficial&client=firefox-a'
        // *     example 4: urldecode('%E5%A5%BD%3_4');
        // *     returns 4: '\u597d%3_4'
        return decodeURIComponent((str + '').replace(/%(?![\da-f]{2})/gi, function () {
            // PHP tolerates poorly formed escape sequences
            return '%25';
        }).replace(/\+/g, '%20'));
    }


		</script>
        
<?php get_footer(); ?>