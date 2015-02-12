<?php
get_header(); ?>

<div class="whatpageisthis">front-page.php</div>
	
    <div class="container">
		<div class="row">
			<div class="span8" id="content">
<?php 
					
					
					date_default_timezone_set('America/Los_Angeles');
					$day = strtolower(date('l'));
					
					
					$meta_key_day = getMetaKey($day);
					//echo "\nday :".$meta_key_day;
					$currentPostId = "";
					$lastPostId = "";
					$futurePostId = "";
					
					$post_data = postData($meta_key_day, $currentPostId, $lastPostId, $futurePostId);
					//echo "<p>";
					//echo " \ncurrent post :".$currentPostId;
					//echo " \nPast post :".$lastPostId;
					//echo " \nFuture post id:".$futurePostId;
					//echo "</p>";
					
					?>

			<div id="hero-onair">
             On air
            </div>
            <div id="hero-block">
	            <div class="row-fluid"  id="hero-text-wrapper">
                     <div class="span9" id="hero-text">
                     <div class="inner">
                         <h1><?php echo get_the_title($currentPostId); ?></h1>
                         
							 <?php
                             echo get_the_term_list( $currentPostId, 'staff', '<p class="hostedby">Hosted by ', ', ', '</p>' );
                             ?>
                         
                         	<p class="program-days-times">
                				<?php
								$air_time = airTimings($currentPostId);
								//echo $count;
								echo $air_time; ?>
                 			 </p> 
                             
                             <ul id="hero-links">
                                <li><a href="http://www.mainplayersystem.com/radio/player/61?size=max" class="streamlive"><i class="icon-volume-up"></i>Listen live</a></li>
                                <li><a href="<?php echo home_url(); ?>/live-playlist/"><i class="icon-th-list"></i>View Playlist</a></li>
                                <li><a href="<?php echo get_permalink($currentPostId); ?>" title="<?php echo get_the_title($currentPostId); ?>"><i class="icon-list-alt"></i>View Program page</a></li>
                             </ul>
                     	</div><!-- .inner -->
                     </div> <!-- hero-text -->
 
                </div> <!-- row -->

                <div id="hero-image">
                <?php 

		
					if ( has_post_thumbnail($currentPostId) ) {  
						echo get_the_post_thumbnail( $currentPostId, 'programs-hero'); 

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
				    
                $lastprog_starttime = get_post_meta($lastPostId, 'onair_starttime', TRUE);
				$lastprog_endtime = get_post_meta($lastPostId, 'onair_endtime', TRUE);
				$futureprog_starttime = get_post_meta($futurePostId, 'onair_starttime', TRUE);
				$futureprog_endtime = get_post_meta($futurePostId, 'onair_endtime', TRUE);
				
                ?>              
				<ul id="hero-past-future">
                    	<li id="hero-past">
                        	<a href="<?php echo get_permalink($lastPostId); ?>">
                            	<span class="inner">
                                <em><span class="corner"></span>Last Show</em>
                                <span class="time"><?php echo date("ga", strtotime("{$lastprog_starttime}")) . '-' . date("ga", strtotime("{$lastprog_endtime}")); ?></span>
                                <span class="title"><?php echo get_the_title($lastPostId); ?></span>
                                </span>
                           </a>
                        </li>
                        <li id="hero-future">
                        	<a href="<?php echo get_permalink($futurePostId); ?>">
                            	<span class="inner">
                            	<em><span class="corner"></span>Up Next</em>
								<span class="time"><?php echo date("ga", strtotime("{$futureprog_starttime}")) . '-' . date("ga", strtotime("{$futureprog_endtime}")); ?></span>
								<span class="title"><?php echo get_the_title($futurePostId); ?></span>
                                </span>
                            </a>
                       </li>
                       <!-- <br class="clearer" /> -->
                </ul>

				
                <p id="schedulelink"><a href="program/"><i class="icon-calendar"></i>Weekly Schedule</a></p>

				<?php // Loop for posts
					$sticky = get_option( 'sticky_posts' );
					$args = array( 
						'post_type' => 'post', 
						'order_by'=> 'date', 
						'order' => 'DESC',
						'post__in'  =>  $sticky,
						//'ignore_sticky_posts' => 0,
						'category_name' => 'home-featured',
						'post_status' => 'publish'
						);
	
					$loop = new WP_Query( $args );
					while ( $loop->have_posts() ) : $loop->the_post();
				?>


					<?php

						if ( $sticky ) {
							// insert here your stuff…
							?>
						<h2 <?php post_class() ?>>							
							<a href="<?php the_permalink(); ?>"><?php the_title();?></a>
						</h2>
						
						<div class="media">
						    <a class="pull-left" href="<?php the_permalink(); ?>">
							<?php 
								if ( has_post_thumbnail() ) {
									the_post_thumbnail('thumbnail', array('class' => 'media-object'));
										if(get_post(get_post_thumbnail_id())->post_excerpt) { ?>
											<span class="featured-caption media-object"><?php echo get_post( get_post_thumbnail_id() )->post_excerpt ?></span>
										<?php } ?>
							<?php					

								}
								else {
									//echo '<img src="' . get_bloginfo( 'stylesheet_directory' ) . '/img/thumbnail-default.png" />';
								}
							?>												    
							    
							    </a>
							
							<div class="media-body">
						
								<div class="media-content">
									<p><small><?php the_time('F j, Y'); ?> - <?php the_time('g:i a'); ?></small></p>
									<?php the_excerpt(); ?>
								</div><!-- media-content -->
							    <?php 
								if (is_single($post)){
								?> 
						            
						        <?php
								} else {
								?> 
						           <p> 
						           		<a class="btn btn-small primary-read-more" href="<?php the_permalink(); ?>">
						                	Read More <i class="icon-chevron-right"></i>
							            </a>
						            </p>
						        <?php	
									
								}
								?>
						    </div><!-- media-body -->
						</div><!-- media -->
					<?php } else {} ?>

				<?php endwhile;?>
				<?php wp_reset_postdata(); ?>

				<?php // Loop for posts
					$args = array( 
						'post_type' => 'post', 
						'order_by'=> 'date', 
						'order' => 'DESC',
						'post__not_in' => get_option('sticky_posts'),
						'ignore_sticky_posts' => 1,
						'category_name' => 'home-featured',
						'post_status' => 'publish'
						);
	
					$loop = new WP_Query( $args );
					while ( $loop->have_posts() ) : $loop->the_post();
				?>

				     <?php 
				
					if ( in_category( 'weekly-top-10' )) {
							
							get_template_part('format', 'topten');
					}
				     elseif(!get_post_format()) {
				               get_template_part('format', 'standard');
			         } else {
				               get_template_part('format', get_post_format());
				          }
					?>

				<?php endwhile; ?>							
				<?php	wp_reset_postdata(); ?>



			</div><!-- #content span8 -->
	        <?php get_sidebar(); // sidebar 1 ?>
    	</div><!-- row -->
</div><!-- container -->   

<script type="text/javascript">
	jQuery(function() {
		
		jQuery("#hero-past-future .title").equalHeights();
		 
	});

</script>       
<?php get_footer(); ?>
