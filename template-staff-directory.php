<?php
/**
* // Staff archive page
* Template Name: Staff Directory Page
*/

get_header(); ?>
<div class="whatpageisthis">template-staff-directory.php</div>		
	
			<div class="container">
				<div class="row">	
					<div class="span8" id="content">
							<h1>Staff</h1>
								
							    <ul class="nav nav-tabs" id="myTab">
								    <li class="active"><a href="#music_hosts" data-toggle="tab">Music Hosts</a></li>
								    <li><a href="#news_hosts" data-toggle="tab">News Department</a></li>
								    <li><a href="#kbcs_staff" data-toggle="tab">KBCS Staff</a></li>
							    </ul>

							    <div class="tab-content">
								    <div class="tab-pane" id="kbcs_staff">
<!-- KBCS Staff Tab -->

										<?php 
											
											$args = array( 
												'post_type' => 'staff', 
												'posts_per_page' => -1, 
												'order' => 'ASC',
												'orderby'=> 'title', 
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
												else { ?>
													<img src="<?php echo get_bloginfo( 'stylesheet_directory' ); ?>/img/thumbnail-default.png" alt="<?php the_title(); ?>" />
											<?php	}
											?>												    
											    
											    </a>
									    	
									    	<div class="media-body">
			
				    							<a href="<?php the_permalink(); ?>"><h4 class="media-heading"><?php the_title(); ?></h4></a>

												<?php
													if(get_post_meta($post->ID, 'staff_role', true !='')) {
														echo '<p class="staff-role">' . get_post_meta($post->ID, 'staff_role', TRUE) . '</p>'; ?>
														
												<?php } ?>
                                                
                                                <?php
													$programs= getPrograms($post->ID);
													if(count($programs)>0)
													{
														echo '<p class="host-of"><strong>Hosts:</strong> '.$programs . '</p>' ; ?>
											
												
												<?php } ?>


				    							<?php
													if(get_post_meta($post->ID, 'staff_email', true !='')) {
														echo '<p class="staff-email"><a href="mailto:'. get_post_meta($post->ID, 'staff_email', TRUE).'">' . get_post_meta($post->ID, 'staff_email', TRUE) . '</a></p>';?>
												<?php } ?> 
												<?php
													if(get_post_meta($post->ID, 'staff_phone', true !='')) {
														echo '<p class="staff-phone">' .get_post_meta($post->ID, 'staff_phone', TRUE) . '</p>'; ?>
												<?php } ?>

												
												
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
												'posts_per_page' => -1, 
												'order' => 'ASC',
												'orderby'=> 'title', 
												'post_status' => 'publish',
							                	'tax_query'=> array( 
							                		array(
							                			'taxonomy'  => 'staff_type', 
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
												else { ?>
													<img src="<?php echo get_bloginfo( 'stylesheet_directory' ); ?>/img/thumbnail-default.png" alt="<?php the_title(); ?>" />
											<?php	}
											?>												    
											    
											    </a>
									    	
									    	<div class="media-body">
			
				    							<a href="<?php the_permalink(); ?>"><h4 class="media-heading"><?php the_title(); ?></h4></a>


												<?php
													if(get_post_meta($post->ID, 'staff_role', true !='')) {
														echo '<p class="staff-role">' . get_post_meta($post->ID, 'staff_role', TRUE) . '</p>'; ?>
														<br/>
														
												<?php } ?>

				    							<?php
													if(get_post_meta($post->ID, 'staff_email', true !='')) {
														echo '<p class="staff-email">' . get_post_meta($post->ID, 'staff_email', TRUE) . '</p>';?>
														<br/>
												<?php } ?> 
												<?php
													if(get_post_meta($post->ID, 'staff_phone', true !='')) {
														echo '<p class="staff-phone">' .get_post_meta($post->ID, 'staff_phone', TRUE) . '</p>'; ?>
														<br/>
														
												<?php } ?>

												<?php
													$programs= getPrograms($post->ID);
													if(count($programs)>0)
													{
														echo '<p class="host-of"> Hosts: '.$programs . '</p>' ; ?>
													<br/>
												
												<?php } ?>

												<!--
												<div>
													<?php //echo get_the_term_list( $post->ID, 'programs', 'Host of: ', ', ', '' ); ?> 
												</div>
												-->

												<div class="media-content">
													<?php the_excerpt(); ?>
												</div><!-- media-content -->
											     
												<!-- 
												<a class="btn btn-small primary-read-more">
													Read More <i class="icon-chevron-right"></i>
												</a>
												-->
										    </div><!-- media-body -->
									    </div><!-- media -->
									<hr />

										<?php endwhile; ?>							
										<?php	wp_reset_postdata(); ?>
								    </div><!-- .tab-pane #news_hosts -->

<!-- Music Hosts Tab -->
								    <div class="tab-pane active" id="music_hosts">
										<?php 
											
											$args = array( 
												'post_type' => 'staff', 
												'posts_per_page' => -1, 
												'order' => 'ASC',
												'orderby'=> 'title', 
												'post_status' => 'publish',
							                	'tax_query'=> array( 
							                		array(
							                			'taxonomy'  => 'staff_type', 
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
												else { ?>
													<img src="<?php echo get_bloginfo( 'stylesheet_directory' ); ?>/img/thumbnail-default.png" alt="<?php the_title(); ?>" />
											<?php	}
											?>												    
											    
											    </a>
									    	
									    	<div class="media-body">
			
				    							<a href="<?php the_permalink(); ?>"><h4 class="media-heading"><?php the_title(); ?></h4></a>

												<?php
													if(get_post_meta($post->ID, 'staff_role', true !='')) {
														echo '<p class="staff-role">' . get_post_meta($post->ID, 'staff_role', TRUE) . '</p>'; ?>
														<br/>
														
												<?php } ?>

				    							<?php
													if(get_post_meta($post->ID, 'staff_email', true !='')) {
														echo '<p class="staff-email">' . get_post_meta($post->ID, 'staff_email', TRUE) . '</p>';?>
														<br/>
												<?php } ?> 
												<?php
													if(get_post_meta($post->ID, 'staff_phone', true !='')) {
														echo '<p class="staff-phone">' .get_post_meta($post->ID, 'staff_phone', TRUE) . '</p>'; ?>
														<br/>
														
												<?php } ?>

												<?php
													$programs= getPrograms($post->ID);
													if(count($programs)>0)
													{
														echo '<p class="host-of"> Hosts: '.$programs . '</p>' ; ?>
													<br/>
												
												<?php } ?>

												<!-- 
												<div>
													<?php //echo get_the_term_list( $post->ID, 'programs', 'Host of: ', ', ', '' ); ?> 
												</div>
												-->

												<div class="media-content">
													<?php the_excerpt(); ?>
												</div><!-- media-content -->
											     
												<!-- 
												<a class="btn btn-small primary-read-more">
													Read More <i class="icon-chevron-right"></i>
												</a>
												-->
										    </div><!-- media-body -->
									    </div><!-- media -->
									<hr />

										<?php endwhile; ?>							
										<?php	wp_reset_postdata(); ?>

								    </div><!-- music_hosts -->

							    </div><!-- tab-pane tab-content -->
							
									    
						<script>
							jQuery('#myTab a').click(function (e) {
								e.preventDefault();
							jQuery(this).tab('show');
							})
						</script>		
						
						
						<script>
							jQuery(document).ready(function() {
							 jQuery('a[data-toggle="tab"]').on('shown', function (e) {
							    //save the latest tab; use cookies if you like 'em better:
							    localStorage.setItem('lastTab', jQuery(e.target).attr('href'));
							  });
							  //go to the latest tab, if it exists:
							  var lastTab = localStorage.getItem('lastTab');
							  if (lastTab) {
							      jQuery('a[href="' + lastTab + '"]').tab('show');
							  }
							
							});						
						</script>			
		    
					</div><!-- #content .span8 -->
				<?php get_sidebar(); ?>
				</div><!-- row -->
			</div><!-- container -->
<?php get_footer();
