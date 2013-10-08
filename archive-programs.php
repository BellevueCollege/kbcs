<?php
/**
 * Template Name: Programs Page
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 */

get_header(); ?>

<div class="whatpageisthis">archive-programs.php</div>		

    <div class="container">
        <div class="row">	
            <div class="span8" id="content">
        
        
				<h1>Programs</h1>
								
					<ul class="nav nav-tabs" id="myTab">
						<li class="active"><a href="#schedule">Schedule</a></li>
						<li><a href="#az-list">A-Z List</a></li>
						<li><a href="#music">Music</a></li>
						<li><a href="#news-ideas">News & Ideas</a></li>
					</ul><!-- nav-tabs -->
					 
					<div class="tab-content">
						<div class="tab-pane active" id="schedule">
						    
						    <!-- start weekday left tabs -->
						    <div class="tabbable tabs-left"> <!-- Only required for left/right tabs -->
							    <?php $today = date('N'); ?>
							    <ul class="nav nav-tabs">
								    <li <?php if( $today == 1) { echo 'class="active"'; } ?>>
								    	<a href="#monday" data-toggle="tab">Monday</a>
							    	</li>
								    <li <?php if( $today == 2) { echo 'class="active"'; } ?>>
								    	<a href="#tuesday" data-toggle="tab">Tuesday</a>
							    	</li>
								    <li <?php if( $today == 3) { echo 'class="active"'; } ?>>
								    	<a href="#wednesday" data-toggle="tab">Wednesday</a>
							    	</li>
								    <li <?php if( $today == 4) { echo 'class="active"'; } ?>>
								    	<a href="#thursday" data-toggle="tab">Thursday</a>
							    	</li>
								    <li <?php if( $today == 5) { echo 'class="active"'; } ?>>
								    	<a href="#friday" data-toggle="tab">Friday</a>
							    	</li>
								    <li <?php if( $today == 6) { echo 'class="active"'; } ?>>
								    	<a href="#saturday" data-toggle="tab">Saturday</a>
							    	</li>
								    <li <?php if( $today == 7) { echo 'class="active"'; } ?>>
								    	<a href="#sunday" data-toggle="tab">Sunday</a>
							    	</li>
							    </ul><!-- nav-tabs -->
	
							    <div class="tab-content">


								    <div class="tab-pane active" id="monday">
									    <table class="table table-condensed table-striped">
										    <tbody>
											<thead>
												<tr>
													<th>Start Time</th>
													<th>Program Name</th>
												</tr>
											</thead>
						    					<?php
													$args = array(
														'post_type' => 'programs',
														'posts_per_page' => -1,
														'meta_key' => 'onair_starttime',
														'orderby' => 'meta_value',
														'order' => 'ASC',
														);
													
													$query = new WP_Query( $args ); 
													while ( $query->have_posts() ) : $query->the_post();
												
												$onair_mon = get_post_meta($post->ID, 'onair_monday', false);
												$starttime = get_post_meta( $post->ID, 'onair_starttime', true );
												$endtime = get_post_meta( $post->ID, 'onair_endtime', true );
												?>
		
												<?php	if ($onair_mon) { ?>
													<?php foreach($onair_mon as $airing) { ?>
													    <tr>
														    <td><?php echo date("g:ia", strtotime("{$starttime} UTC")); };?></td>
														    <td><?php the_title(); ?></td>
													    </tr>
													<?php } ?>
					
												<?php endwhile; ?>
												<?php wp_reset_postdata(); ?>

										    </tbody>
									    </table>	
							    	</div><!-- tab-pane #monday -->



								    <div class="tab-pane" id="tuesday">
									    <table class="table table-condensed table-striped">
										    <tbody>
											<thead>
												<tr>
													<th>Start Time</th>
													<th>Program Name</th>
												</tr>
											</thead>

						    					<?php
													$args = array(
														'post_type' => 'programs',
														'posts_per_page' => -1,
														'meta_key' => 'onair_starttime',
														'orderby' => 'meta_value',
														'order' => 'ASC',
														);
													
													$query = new WP_Query( $args ); 
													while ( $query->have_posts() ) : $query->the_post();
												
												$onair_tue = get_post_meta($post->ID, 'onair_tuesday', false);
												$starttime = get_post_meta( $post->ID, 'onair_starttime', true );
												$endtime = get_post_meta( $post->ID, 'onair_endtime', true );
												?>
		
												<?php	if ($onair_tue) { ?>
													<?php foreach($onair_tue as $airing) { ?>
													    <tr>
														    <td><?php echo date("g:ia", strtotime("{$starttime} UTC")); };?></td>
														    <td><?php the_title(); ?></td>
													    </tr>
													<?php } ?>
					
												<?php endwhile; ?>
												<?php wp_reset_postdata(); ?>

										    </tbody>
									    </table>	
								    </div><!-- tab-pane #tuesday --> 



								    <div class="tab-pane" id="wednesday">
									    <table class="table table-condensed table-striped">
										    <tbody>
											<thead>
												<tr>
													<th>Start Time</th>
													<th>Program Name</th>
												</tr>
											</thead>

						    					<?php
													$args = array(
														'post_type' => 'programs',
														'posts_per_page' => -1,
														'meta_key' => 'onair_starttime',
														'orderby' => 'meta_value',
														'order' => 'ASC',
														);
													
													$query = new WP_Query( $args ); 
													while ( $query->have_posts() ) : $query->the_post();
												
												$onair_wed = get_post_meta($post->ID, 'onair_wednesday', false);
												$starttime = get_post_meta( $post->ID, 'onair_starttime', true );
												$endtime = get_post_meta( $post->ID, 'onair_endtime', true );
												?>
		
												<?php	if ($onair_wed) { ?>
													<?php foreach($onair_wed as $airing) { ?>
													    <tr>
														    <td><?php echo date("g:ia", strtotime("{$starttime} UTC")); };?></td>
														    <td><?php the_title(); ?></td>
													    </tr>
													<?php } ?>
					
												<?php endwhile; ?>
												<?php wp_reset_postdata(); ?>

										    </tbody>
									    </table>	
								    </div><!-- tab-pane #wednesday --> 



								    <div class="tab-pane" id="thursday">
									    <table class="table table-condensed table-striped">
										    <tbody>
											<thead>
												<tr>
													<th>Start Time</th>
													<th>Program Name</th>
												</tr>
											</thead>

						    					<?php
													$args = array(
														'post_type' => 'programs',
														'posts_per_page' => -1,
														'meta_key' => 'onair_starttime',
														'orderby' => 'meta_value',
														'order' => 'ASC',
														);
													
													$query = new WP_Query( $args ); 
													while ( $query->have_posts() ) : $query->the_post();
												
												$onair_thu = get_post_meta($post->ID, 'onair_thursday', false);
												$starttime = get_post_meta( $post->ID, 'onair_starttime', true );
												$endtime = get_post_meta( $post->ID, 'onair_endtime', true );
												?>
		
												<?php	if ($onair_thu) { ?>
													<?php foreach($onair_thu as $airing) { ?>
													    <tr>
														    <td><?php echo date("g:ia", strtotime("{$starttime} UTC")); };?></td>
														    <td><?php the_title(); ?></td>
													    </tr>
													<?php } ?>
					
												<?php endwhile; ?>
												<?php wp_reset_postdata(); ?>

										    </tbody>
									    </table>	
								    </div><!-- tab-pane #thursday --> 



								    <div class="tab-pane" id="friday">
									    <table class="table table-condensed table-striped">
										    <tbody>
											<thead>
												<tr>
													<th>Start Time</th>
													<th>Program Name</th>
												</tr>
											</thead>

						    					<?php
													$args = array(
														'post_type' => 'programs',
														'posts_per_page' => -1,
														'meta_key' => 'onair_starttime',
														'orderby' => 'meta_value',
														'order' => 'ASC',
														);
													
													$query = new WP_Query( $args ); 
													while ( $query->have_posts() ) : $query->the_post();
												
												$onair_fri = get_post_meta($post->ID, 'onair_friday', false);
												$starttime = get_post_meta( $post->ID, 'onair_starttime', true );
												$endtime = get_post_meta( $post->ID, 'onair_endtime', true );
												?>
		
												<?php	if ($onair_fri) { ?>
													<?php foreach($onair_fri as $airing) { ?>
													    <tr>
														    <td><?php echo date("g:ia", strtotime("{$starttime} UTC")); };?></td>
														    <td><?php the_title(); ?></td>
													    </tr>
													<?php } ?>
					
												<?php endwhile; ?>
												<?php wp_reset_postdata(); ?>

										    </tbody>
									    </table>	
								    </div><!-- tab-pane #friday --> 



								    <div class="tab-pane" id="saturday">
									    <table class="table table-condensed table-striped">
										    <tbody>
											<thead>
												<tr>
													<th>Start Time</th>
													<th>Program Name</th>
												</tr>
											</thead>
		
						    					<?php
													$args = array(
														'post_type' => 'programs',
														'posts_per_page' => -1,
														'meta_key' => 'onair_starttime',
														'orderby' => 'meta_value',
														'order' => 'ASC',
														);
													
													$query = new WP_Query( $args ); 
													while ( $query->have_posts() ) : $query->the_post();
												
												$onair_sat = get_post_meta($post->ID, 'onair_saturday', false);
												$starttime = get_post_meta( $post->ID, 'onair_starttime', true );
												$endtime = get_post_meta( $post->ID, 'onair_endtime', true );
												?>
		
												<?php	if ($onair_sat) { ?>
													<?php foreach($onair_sat as $airing) { ?>
													    <tr>
														    <td><?php echo date("g:ia", strtotime("{$starttime} UTC")); };?></td>
														    <td><?php the_title(); ?></td>
													    </tr>
													<?php } ?>
					
												<?php endwhile; ?>
												<?php wp_reset_postdata(); ?>

										    </tbody>
									    </table>	
								    </div><!-- tab-pane #saturday --> 



								    <div class="tab-pane" id="sunday">
									    <table class="table table-condensed table-striped">
										    <tbody>
											<thead>
												<tr>
													<th>Start Time</th>
													<th>Program Name</th>
												</tr>
											</thead>

						    					<?php
													$args = array(
														'post_type' => 'programs',
														'posts_per_page' => -1,
														'meta_key' => 'onair_starttime',
														'orderby' => 'meta_value',
														'order' => 'ASC',
														);
													
													$query = new WP_Query( $args ); 
													while ( $query->have_posts() ) : $query->the_post();
												
												$onair_sun = get_post_meta($post->ID, 'onair_sunday', false);
												$starttime = get_post_meta( $post->ID, 'onair_starttime', true );
												$endtime = get_post_meta( $post->ID, 'onair_endtime', true );
												?>
		
												<?php	if ($onair_sun) { ?>
													<?php foreach($onair_sun as $airing) { ?>
													    <tr>
														    <td><?php echo date("g:ia", strtotime("{$starttime} UTC")); };?></td>
														    <td><?php the_title(); ?></td>
													    </tr>
													<?php } ?>
					
												<?php endwhile; ?>
												<?php wp_reset_postdata(); ?>

										    </tbody>
									    </table>	
								    </div><!-- tab-pane #sunday --> 

							    </div><!-- tab-content -->
						    </div><!tabbable tabs-left -->						
						</div><!-- tab-pane #schedule -->

						<div class="tab-pane" id="az-list">
							<?php 
							
								$args = array( 
									'post_type' => array( 'programs', 'segments'), 
									'posts_per_page' => -1, 
									'orderby'=> 'title', 
									'order' => 'ASC', 
									'post_status' => 'publish',
				                	'tax_query'=> array( 
				                		'releation' => 'OR',
					                		array(
					                			'taxonomy'  => 'program_type', 
					                			'field' => 'slug', 
					                			'terms' => array( 'music', 'news-ideas'),
					                			'operator'  => 'IN'
					                			),
				                			)
									);
								$loop = new WP_Query( $args );
								while ( $loop->have_posts() ) : $loop->the_post();
						
							?>						
						<h3 <?php post_class() ?>>							
							<a href="<?php the_permalink(); ?>"><?php the_title();?></a>
						</h3>
							<p>
								<?php echo get_the_excerpt(); ?>
							</p>
							
							<p class="results-meta">
									<?php echo get_the_term_list( $post->ID, 'staff', '<i class="meta-host"></i>Host: ', ', ', '' ); ?>
							</p><!-- results-meta -->
						
					
	
							<?php endwhile; ?>
							<?php wp_reset_postdata(); ?>

						</div><!-- tab-pane #az-list -->
						
						<div class="tab-pane" id="music">
							<?php 
								
								$args = array( 
									'post_type' => array( 'programs', 'segments'), 
									'posts_per_page' => -1, 
									'order' => 'ASC',
									'orderby'=> 'title', 
									'post_status' => 'publish',
				                	'tax_query'=> array( 
				                		array(
				                			'taxonomy'  => 'program_type', 
				                			'field' => 'slug', 
				                			'terms' => 'music',
				                			'operator'  => 'IN'),
				                			) 
									);

								$loop = new WP_Query( $args );
								while ( $loop->have_posts() ) : $loop->the_post();
							?>

							<h2 <?php post_class() ?>>							
								<a href="<?php the_permalink(); ?>"><?php the_title();?></a>
							</h2>

							<p>
								<?php echo get_the_excerpt(); ?>
							</p>
							
							<p class="results-meta">
									<?php echo get_the_term_list( $post->ID, 'staff', '<i class="meta-host"></i>Host: ', ', ', '' ); ?>
							</p><!-- results-meta -->


							<?php endwhile; ?>
							<?php wp_reset_postdata(); ?>
						
						</div><!-- tab-pane #music -->
						
						<div class="tab-pane" id="news-ideas">
							
							<?php 
								
								$args = array( 
									'post_type' => 'programs', 
									'posts_per_page' => -1, 
									'order' => 'ASC',
									'orderby'=> 'title', 
									'post_status' => 'publish',
				                	'tax_query'=> array( 
				                		array(
				                			'taxonomy'  => 'program_type', 
				                			'field' => 'slug', 
				                			'terms' => 'news-ideas',
				                			'operator'  => 'IN'),
				                			) 
									);

								$loop = new WP_Query( $args );
								while ( $loop->have_posts() ) : $loop->the_post();
							?>

							<h2 <?php post_class() ?>>							
								<a href="<?php the_permalink(); ?>"><?php the_title();?></a>
							</h2>

							<p>
								<?php echo get_the_excerpt(); ?>
							</p>
							
							<p class="results-meta">
									<?php echo get_the_term_list( $post->ID, 'staff', '<i class="meta-host"></i>Host: ', ', ', '' ); ?>
							</p><!-- results-meta -->

							<?php endwhile; ?>
							<?php wp_reset_postdata(); ?>
						
						</div><!-- tab-pane #news-ideas -->
					
					</div><!-- tab-content -->					






						<script>
							jQuery('#myTab a').click(function (e) {
								e.preventDefault();
							jQuery(this).tab('show');
							})
						</script>				    

					</div><!--#content .span8 -->
				<?php get_sidebar(); ?>
				</div><!-- row -->
			</div><!-- container -->
	<?php get_footer(); ?>