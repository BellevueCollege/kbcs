<?php
### Sidebar - Contains Sub Page navigation
### Automatically appears if sub-nav exists
?>

<?php
/* Check which layout option is being used */
/* If a layout without a sidebar is selected don't run this code 

	jQueryoptions = get_option( 'bcause_layout_options' );

//	jQueryoptions = bcause_get_theme_options();
	jQuerycurrent_layout = jQueryoptions['theme_layout'];
	
	if ( 'content' != jQuerycurrent_layout ) :
*/
?>

		<div class="sidebar span4">

			<div class="navbar sidebar-audio-buttons">
				<div class="navbar-inner">
					<div class="container">
						<ul class="nav">
							<li>
								<a href="http://www.mainplayersystem.com/radio/player/61?size=max" class="streamlive"><i class="icon-volume-up"></i> Live Stream</a>
							</li>
							<li>
								<a href="http://kbcsweb.bellevuecollege.edu/play/tools/finder">Playlist &amp; Audio Archives</a>
							</li>
						</ul><!-- nav -->
					</div><!-- container -->
				</div><!-- navbar-inner -->
			</div><!-- navbar now-playing -->
	<div id ="nowplaying">
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
					do_shortcode('[tf-events-full limit=20]'); 
					$args = array(
						'post_type' => 'ads',
						'posts_per_page' => 1
						
					);
					$query = new WP_Query( $args );
					while ($query->have_posts()) : $query->the_post();
						?>
                        <div id="ad-manager">
					
								<a href="<?php echo get_the_content();?>">
								<?php echo  the_post_thumbnail("sidebar-ad"); ?>
							</a>
						
                           <small>KBCS thanks our sponsors</small>
               			</div><!-- ad=manager -->
                        <?php
					endwhile; 

					wp_reset_postdata();
			?>

				

				
			
			<div class="events-list">
				<h3>Events sponsored by KBCS</h3>
				<?php do_shortcode('[tf-events-full limit=20]'); 

/*
	Written by Tripti Sharma
	Added Events displayed on home page
*/


					$args = array(
						'post_type' => 'events',
						'posts_per_page' => 12, 
						'order' => 'ASC',
						'meta_key' => 'event_date',
						'orderby'=> 'meta_value_num'
						
					);
					$query = new WP_Query( $args );
					while ($query->have_posts()) : $query->the_post();

					$event_date = format_date(get_post_meta($post->ID, 'event_date', true));
					
					$event_start_time = get_post_meta($post->ID, 'event_start_time', true);
					$event_end_time = get_post_meta($post->ID, 'event_end_time', true);
					$event_location = get_post_meta($post->ID, 'event_location', true);
					$event_street = get_post_meta($post->ID, 'event_street', true);
					$event_city = get_post_meta($post->ID, 'event_city', true);
					$event_location_url = get_post_meta($post->ID, 'event_location_url', true);
					$current_datetime = strtotime("now");
					$event_datetime = strtotime($event_date." ".$event_start_time);
					//echo "event datetime :".$event_datetime;
					if($event_datetime>$current_datetime)
					{



				?>
						<p>
                            <strong><?php the_title();?></strong><br/>
                            <span><?php echo $event_date ;?></span>
                            <span><?php echo $event_start_time. " - " ;?></span>
                            <span><?php echo $event_end_time ;?></span>
                            <span><a href="<?= $event_location_url ?>"><?php echo $event_location ;?></a> - </span>
                            <span><?php echo $event_street ;?></span>
                            <span><?php echo $event_city ;?></span>
                        </p>
					<?php 
					}
					endwhile; ?>
				<?php	wp_reset_postdata(); ?>

<!--
	End Tripti Sharma
->


				<!-- <ul>

					<li>
						<h4 class="event-list-title">North Mississippi Allstars</h4>
						<p>February 13, <a href="">Tractor Tavern</a>, Ballard</p>
					</li>
					<li>
						<h4 class="event-list-title">Makana</h4>
						<p>February 15, <a href="">Kirkland Performing Arts Center</a>, Kirkland</p>
					</li>
					<li>
						<h4 class="event-list-title">Wintergrass</h4>
						<p>February 28 - March 3, <a href="">Hyatt Regency</a>, Bellevue</p>
					</li>
				</ul> -->
		<!--
				<span class="sidebar-more-link">
					<a href="">More Events <i class="icon-chevron-right"></i></a>
				</span> -->
				<!-- sidebar-more-link -->
			</div><!-- event-list -->
			
			<div class="latests-posts">
				<h3>Latest posts</h3>
				<ul class="blog-list">
			<?php do_shortcode('[tf-events-full limit=20]'); 

/*
	Written by Tripti Sharma
	Added Events displayed on home page
*/


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
				</ul> <!-- blog-list -->

				<a href="<?php echo home_url(); ?>/blog/" class="btn">More Posts <i class="icon-chevron-right"></i></a>

			</div><!-- latests-posts -->
					
			<div>
				<?php dynamic_sidebar( 'primary-widget-area' ); ?>
			</div><!--  -->

		</div><!-- span4 -->


<?php // endif; ?>