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

global $wpdb, $audio_metabox, $post;
$output = array();
$sql = "select * from wp_postmeta where meta_key='_audio_meta'";
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
//error_log("audio content :".$audio_content);

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
                        $hosts = get_field( 'program_to_host_connection' );
                        $host_string = false;
                        if ( is_array($hosts) && count($hosts) > 0 ) {
                            $host_string = '<p class="hostedby">Hosted by ';
                            foreach ( $hosts as $host ) {
                                $permalink = get_permalink( $host->ID );
                                $host_string .= "<a href='$permalink'>$host->post_title</a>" . ', ';
                            }
                            $host_string = rtrim($host_string, ', ');
                            $host_string .= '</p>';
                        }
                        // Term list returns WP_Error object on error; make sure this is text before echoing.
						if ( is_string( $host_string ) ) {
							echo $host_string;
						} else {
							echo '<!-- Error retrieving staff list -->';
							echo '<!--  ';
							print_r( $host_string );
							echo '  -->';
						}
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

                        	<img src="<?php echo get_stylesheet_directory_uri(); ?>/img/program-hero-generic.jpg" alt="photo of cds in KBCS library" />
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



        
<?php get_footer(); ?>
