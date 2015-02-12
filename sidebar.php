<?php
### Sidebar - Contains Sub Page navigation
### Automatically appears if sub-nav exists
?>

		<div class="sidebar span4">

			<div class="navbar sidebar-audio-buttons hidden-phone">
				<div class="navbar-inner">
					<div class="container">
						<ul class="nav">
							<li>
								<a href="http://www.mainplayersystem.com/radio/player/61?size=max" class="streamlive"><i class="icon-volume-up"></i> Live Stream</a>
							</li>
							<li>
								<a href="http://kbcsweb.bellevuecollege.edu/play/tools/finder">Audio & Playlist Archives</a>
							</li>
						</ul><!-- nav -->
					</div><!-- container -->
				</div><!-- navbar-inner -->
			</div><!-- navbar now-playing -->
	<div class="nowplaying hidden-phone">
    	<strong><a href="<?php echo home_url(); ?>/live-playlist/">Now Playing</a>:</strong>
    </div> <!--#nowplaying-->

			<div class="row" id="social-links">
				<div class="span2">
					<a class="btn btn-primary btn-block" href="http://www.facebook.com/KBCSBellevueSeattle"><i class="icon-facebook"></i> Like on Facebook</a>
				</div><!-- span2 -->
				<div class="span2">
					<a class="btn btn-info btn-block" href="https://twitter.com/KBCS"><i class="icon-twitter"></i> Follow on Twitter</a>
				</div><!-- span2 -->
			</div><!-- row -->
			
			<?php

					$args = array(
						'post_type' => 'ads',
						'post_status' => 'publish',
						'posts_per_page' => 1,
						'orderby' => 'date',
						'order' => 'ASC'
						
					);
					$query = new WP_Query( $args );

					while ($query->have_posts()) : $query->the_post();
					
						//$start_date = the_date('Y-m-d', '', '', FALSE);
						//$current_date = date("Y-m-d");
						//$end_date = get_post_meta(get_the_id(), 'ad_enddate', true);
			
			 			//if($current_date >= $start_date && $current_date <= $end_date) {
			?>
										
                        <div id="ad-manager">
							<a href="<?php echo get_post_meta(get_the_id(), '_links_to', true);?>">
								<?php echo the_post_thumbnail("sidebar-ad"); ?>
							</a>
						
                           <small style="display: block;">KBCS thanks our sponsors</small>
						</div><!-- ad-manager -->
						
						<?php // } else ?>
                    
                        <?php
                        	endwhile; 
							wp_reset_postdata();
						?>

			<div class="events-list">
				<h3>Events sponsored by KBCS</h3>
				<?php 

					$args = array(
						'post_type' => 'events',
						'meta_key' => 'event_date',
						'posts_per_page' => -1, 
						'orderby'=> 'meta_value_num',
						'order' => 'ASC',
						
					);
					$query = new WP_Query( $args );
					$current_datetime = strtotime("today");
					while ($query->have_posts()) : $query->the_post();

					$event_date = date('Y/m/d',(get_post_meta($post->ID, 'event_date', true)));
					$event_date_formatted = date('l, F j', (get_post_meta($post->ID, 'event_date',  true)));
					$event_start_time = get_post_meta($post->ID, 'event_start_time', true);
					$event_end_time = get_post_meta($post->ID, 'event_end_time', true);
					$event_location = get_post_meta($post->ID, 'event_location', true);
					$event_street = get_post_meta($post->ID, 'event_street', true);
					$event_city = get_post_meta($post->ID, 'event_city', true);
					$event_location_url = get_post_meta($post->ID, 'event_location_url', true);
					
					$event_datetime = strtotime($event_date." ".$event_start_time);
					if($event_datetime>=$current_datetime)
					{

				?>
						<p>

                            <strong><?php the_title();?></strong><br/>

						    <?php if(! empty($event_date_formatted)) { ?>
	                            <span><?php echo $event_date_formatted . ' - ' ;?></span>
					    	<?php } ?>

						    <?php if(! empty($event_start_time)) { ?>
	                            <span><?php echo $event_start_time. " - " ;?></span>
					    	<?php } ?>

						    <?php if(! empty($event_end_time)) { ?>
	                            <span><?php echo $event_end_time ;?></span>
					    	<?php } ?>

						    <?php if(! empty($event_location_url)) { ?>
                            <span><a href="<?= $event_location_url ?>"><?php echo $event_location ;?></a> - </span>
					    	<?php } ?>

						    <?php if(! empty($event_street)) { ?>
                            <span><?php echo $event_street ;?></span>
					    	<?php } ?>

						    <?php if(! empty($event_city)) { ?>
                            <span><?php echo $event_city ;?></span>
					    	<?php } ?>

                        </p>
					<?php 
					}
					endwhile; ?>
				<?php	wp_reset_postdata(); ?>

			<div class="latests-posts">
				<h3>Latest posts</h3>
				<ul class="blog-list">
			<?php  

					$args = array(

						'posts_per_page' => 10, 

					);
					$query = new WP_Query( $args );
					while ($query->have_posts()) : $query->the_post();
						$title = get_the_title();

						$content = get_the_content('Read more');
						?>

                        <li><a href="<?php the_permalink(); ?>">
                            <?php
                                $the_post = get_post();
                                $dateline = $the_post->post_date;
                             ?>
                            <span class="date">
                                <span class="month"><?php  echo date('M',strtotime($dateline));  ?></span>
                                <span class="day"><?php  echo date('j',strtotime($dateline));  ?></span>
                            </span>
                            <span class="post-title"><span class="inner"><?php the_title(); ?></span></span>					
                        </a></li>
					<?php 
					endwhile; ?>
				<?php	wp_reset_postdata(); ?>
				</ul><!-- blog-list -->

				<a href="<?php echo home_url(); ?>/blog/" class="btn">More Posts <i class="icon-chevron-right"></i></a>

			</div><!-- latests-posts -->

			<div>
				<?php dynamic_sidebar( 'primary-widget-area' ); ?>
			</div><!--  -->

		</div><!-- span4 -->

<?php // endif; ?>