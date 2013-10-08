<?php
/**
 * Template Name: Staff Page
 *
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 */

get_header(); ?>
<div class="whatpageisthis">template-staff.php</div>		


	<div class="container">
        <div class="row">	
            <div class="span8" id="content">
							<h1><?php the_title(); ?></h1>
								
							    <ul class="nav nav-tabs" id="myTab">
								    <li class="active"><a href="#kbcs_staff" data-toggle="tab">KBCS Staff</a></li>
								    <li><a href="#news_hosts" data-toggle="tab">News Hosts</a></li>
								    <li><a href="#music_hosts" data-toggle="tab">Music Hosts</a></li>
							    </ul>

							    <div class="tab-content">
								    <div class="tab-pane active" id="kbcs_staff">
<!-- KBCS Staff Tab -->

										<?php 
											
											$args = array( 
												'post_type' => 'staff', 
												'posts_per_page' => 10, 
												'order_by'=> 'date', 
												'post_status' => 'publish',
							                	'tax_query'=> array( 
							                		array(
							                			'taxonomy'  => 'staff_type', 
							                			'field' => 'slug', 
							                			'terms' => 'kbcs-staff',
							                			'operator'  => 'IN'),
							                			) 
												);
		
											$loop = new WP_Query( $args );
											while ( $loop->have_posts() ) : $loop->the_post();
										?>
															     
									    <div class="media">
										    <a class="pull-left" href="<?php the_permalink(); ?>">
											<?php 
												if ( has_post_thumbnail() ) {
													the_post_thumbnail('thumbnail', array('class' => 'media-object'));
												}
												else {
													echo '<img src="' . get_bloginfo( 'stylesheet_directory' ) . '/img/thumbnail-default.png" />';
												}
											?>												    
											    
											    </a>
									    	
									    	<div class="media-body">
			
				    							<a href="<?php the_permalink(); ?>"><h4 class="media-heading"><?php the_title(); ?></h4></a>

				    							
												<div class="media-content">
													<?php the_content(); ?>
												</div><!-- media-content -->
											     
												<a class="btn btn-small primary-read-more">
													Read More <i class="icon-chevron-right"></i>
												</a>
										    </div><!-- media-body -->
									    </div><!-- media -->
									<hr />

										<?php endwhile; ?>							
										<?php	wp_reset_postdata(); ?>
								    </div><!-- tab-pane kbcs_staff -->

<!-- News Hosts Tab -->
								    <div class="tab-pane" id="news_hosts">
										<?php 
											
											$args = array( 
												'post_type' => 'staff', 
												'posts_per_page' => 10, 
												'order_by'=> 'date', 
												'post_status' => 'publish',
							                	'tax_query'=> array( 
							                		array(
							                			'taxonomy'  => 'program_type', 
							                			'field' => 'slug', 
							                			'terms' => 'news-host',
							                			'operator'  => 'IN'),
							                			) 
												);
		
											$loop = new WP_Query( $args );
											while ( $loop->have_posts() ) : $loop->the_post();
										?>
															     
									    <div class="media">
										    <a class="pull-left" href="<?php the_permalink(); ?>">
											<?php 
												if ( has_post_thumbnail() ) {
													the_post_thumbnail('thumbnail', array('class' => 'media-object'));
												}
												else {
													echo '<img src="' . get_bloginfo( 'stylesheet_directory' ) . '/img/thumbnail-default.png" />';
												}
											?>												    
											    
											    </a>
									    	
									    	<div class="media-body">
			
				    							<a href="<?php the_permalink(); ?>"><h4 class="media-heading"><?php the_title(); ?></h4></a>


												<div class="media-content">
													<?php the_content(); ?>
												</div><!-- media-content -->
											     
												<a class="btn btn-small primary-read-more">
													Read More <i class="icon-chevron-right"></i>
												</a>
										    </div><!-- media-body -->
									    </div><!-- media -->
									<hr />

										<?php endwhile; ?>							
										<?php	wp_reset_postdata(); ?>
								    </div><!-- news_hosts -->

<!-- Music Hosts Tab -->
								    <div class="tab-pane" id="music_hosts">
										<?php 
											
											$args = array( 
												'post_type' => 'staff', 
												'posts_per_page' => 10, 
												'order_by'=> 'date', 
												'post_status' => 'publish',
							                	'tax_query'=> array( 
							                		array(
							                			'taxonomy'  => 'program_type', 
							                			'field' => 'slug', 
							                			'terms' => 'music-host',
							                			'operator'  => 'IN'),
							                			) 
												);
		
											$loop = new WP_Query( $args );
											while ( $loop->have_posts() ) : $loop->the_post();
										?>
															     
									    <div class="media">
										    <a class="pull-left" href="<?php the_permalink(); ?>">
											<?php 
												if ( has_post_thumbnail() ) {
													the_post_thumbnail('thumbnail', array('class' => 'media-object'));
												}
												else {
													echo '<img src="' . get_bloginfo( 'stylesheet_directory' ) . '/img/thumbnail-default.png" />';
												}
											?>												    
											    
											    </a>
									    	
									    	<div class="media-body">
			
				    							<a href="<?php the_permalink(); ?>"><h4 class="media-heading"><?php the_title(); ?></h4></a>


												<div class="media-content">
													<?php the_content(); ?>
												</div><!-- media-content -->
											     
												<a class="btn btn-small primary-read-more">
													Read More <i class="icon-chevron-right"></i>
												</a>
										    </div><!-- media-body -->
									    </div><!-- media -->
									<hr />

										<?php endwhile; ?>							
										<?php	wp_reset_postdata(); ?>

								    </div><!-- music_hosts -->

							    </div><!-- tab-content -->
							
									    
						<script>
							jQuery('#myTab a').click(function (e) {
								e.preventDefault();
							jQuery(this).tab('show');
							})
						</script>				    
					</div><!-- #content .span8 -->
					<?php get_sidebar(); ?>
				</div><!-- row -->
			</div><!-- container -->
<?php get_footer(); ?>