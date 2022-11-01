<?php
/**
 * Template Name: Programs Page
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 */

get_header(); 
$archivedprograms = array();  //create list of programs (and maybe segments) that are archived
?>

<div class="whatpageisthis">template-programs.php</div>

	<div class="container">
		<div class="row">	
			<div class="span8" id="content">
		
		
				<h1>Programs</h1>
								
					<ul class="nav nav-tabs" id="myTab">
						<li class="active"><a href="#schedule" data-toggle="tab">Schedule</a></li>
						<li><a href="#az-list" data-toggle="tab">A-Z List</a></li>
						<li><a href="#music" data-toggle="tab">Music</a></li>
						<li><a href="#news-ideas" data-toggle="tab">News & Ideas</a></li>
					</ul><!-- nav-tabs -->
					
					<div class="tab-content">
						<div class="tab-pane active" id="schedule">
							<?php
							/////////////////////////////////////////////
							//////////    Schedule
							/////////////////////////////////////////////
							$day_tabs = array(
								'monday',
								'tuesday',
								'wednesday',
								'thursday',
								'friday',
								'saturday',
								'sunday'
							);
							?>
							<!-- start weekday left tabs -->
							<div class="tabbable tabs-left"> <!-- Only required for left/right tabs -->
								<ul class="nav nav-tabs">
									<?php
										$active = 'active';
										foreach ( $day_tabs as $tab ) {
											echo '<li class="'.$active.'"><a href="#'.$tab.'" data-toggle="tab">'.ucfirst($tab).'</a></li>';
											$active = '';
										}
									?>
								</ul><!-- nav-tabs -->
	
								<div class="tab-content">
									<?php
									$active = 'active';
									foreach ( $day_tabs as $tab ) : ?>

										<div class="tab-pane <?php echo $active ?>" id="<?php echo $tab ?>">
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
														'post_status' => 'publish',
														'posts_per_page' => -1,
														'fields' => 'ids',
														'meta_query' => array(
															'relation' => 'AND',
															array(
																'key' => 'onair_starttime',
																'value' => '',
																'compare' => '!=',
															),
															array(
																'key' => 'onair_endtime',
																'value' => '',
																'compare' => '!=',
															),
															array(
																'key' => 'air_days',
																'value' => Homepage_Program::get_meta_key( $tab ),
																'compare' => 'LIKE',
															),
														),
														'orderby' => 'meta_value',
														'meta_key' => 'onair_starttime',
														'order' => 'ASC',
													);
													
													$query = new WP_Query( $args ); 
													while ( $query->have_posts() ) : $query->the_post();
													
														$starttime = get_field( 'onair_starttime');
														$endtime = get_field( 'onair_endtime');
														?>
															<tr>
																<td><?php echo date("g:ia", strtotime("{$starttime}")); ?></td>
																<td><a href="<?php the_permalink();?>"><?php the_title(); ?></a> <?php edit_post_link('edit', ' <small>[', ']</small>');?> </td>
															</tr>
						
													<?php endwhile; ?>
													<?php wp_reset_postdata(); ?>

												</tbody>
											</table>
										</div>
										
									<?php
									$active = ''; // only make the first loop active
									endforeach;
									?>

								</div><!-- tab-content -->
							</div><!-- tabbable tabs-left -->
						</div><!-- tab-pane #schedule -->

						<div class="tab-pane" id="az-list">
							<?php 
							
							/////////////////////////////////////////////
							//////////    A-Z SECTION
							/////////////////////////////////////////////
							
								$args = array( 
									'post_type' => array( 'programs', 'segments'), 
									'posts_per_page' => -1, 
									'orderby'=> 'name', 
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
									
									 <?php 
								   //
								   if ( 'programs' == get_post_type() ) {
									 //THIS IS A PROGRAM
									   
									   	//Check to see if it's a program that is currently airing
									   	$starttime = get_field(  'onair_starttime', $post->ID );
										$endtime = get_field( 'onair_endtime', $post->ID );
									   	if ( $starttime == $endtime ) {
											//add to archived programs array
											$archivedprograms[] = $post->ID; 	
										} else {
											?>
											<div class="row-fluid program-item">
												<div class="span3">
													<?php if ( has_post_thumbnail() ) {  
														the_post_thumbnail("programs-thumb");
														
													} else {
														?>
														<?php $upload_dir = wp_upload_dir(); ?>
								
															<img src="<?php echo get_stylesheet_directory_uri(); ?>/img/program-hero-generic-180x150.jpg" alt="photo of cds in KBCS library" width="180" height="150" />
														<?php	
													}
													?>
												</div>
												<div class="span9">
													<h3 <?php post_class() ?>>							
														<a href="<?php the_permalink(); ?>"><?php the_title();?></a> <?php edit_post_link('edit', ' <small>[', ']</small>');?>
													</h3>
													<p class="program-days-times"><?php
														$postId = get_the_ID();
														$air_time = Homepage_Program::get_airtimes_for_display( $postId );
														//echo $count;
														echo $air_time; ?>
													 </p>

														<?php echo get_the_excerpt(); ?>

													<p class="results-meta">
														<?php
														$host_string = null;
														$hosts = get_field( 'program_to_host_connection', $post->ID ) ?? '';
														
														if ( is_array($hosts) && count($hosts) > 0 ) {
															$host_string = '<i class="meta-host"></i>Hosted by ';
															foreach ( $hosts as $host ) {
																$permalink = get_permalink( $host->ID );
																$host_string .= "<a href='$permalink'>$host->post_title</a>" . ', ';
															}
															$host_string = rtrim($host_string, ', ');
														
															// Term list returns WP_Error object on error; make sure this is text before echoing.
															if ( is_string( $host_string ) ) {
																echo $host_string;
															} else {
																echo '<!-- Error retrieving staff list -->';
																echo '<!--  ';
																print_r( $host_string );
																echo '  -->';
															}
														}
														?>
													</p><!-- results-meta -->
													
												</div><!-- span9 -->
												
											</div>		<!-- row-fluid -->
											<?php
										}
									 ?>
									 
										 
		
									 <?php   
									} else {
										//THIS IS A SEGMENT
									?>	
										 <div class="row-fluid program-item">
											<div class="span3">
												<?php if ( has_post_thumbnail() ) {  
													the_post_thumbnail("programs-thumb");
													
												} else {
													?>
													<?php $upload_dir = wp_upload_dir(); ?>
							
														<img src="<?php echo get_stylesheet_directory_uri(); ?>/img/program-hero-generic-180x150.jpg" alt="photo of cds in KBCS library" width="180" height="150" />
													<?php	
												}
												?>
											</div>
											<div class="span9">
												<h3 <?php post_class() ?>>							
													<a href="<?php the_permalink(); ?>"><?php the_title();?></a> <?php edit_post_link('edit', ' <small>[', ']</small>');?>
												</h3>

													<?php echo get_the_excerpt(); ?>

												<p class="results-meta">
													<?php
													$hosts = get_field( 'program_to_host_connection', $post->ID ) ?? '';
					
													if ( is_array($hosts) && count($hosts) > 0 ) {
														$host_string = '<i class="meta-host"></i>Hosted by ';
														foreach ( $hosts as $host ) {
															$permalink = get_permalink( $host->ID );
															$host_string .= "<a href='$permalink'>$host->post_title</a>" . ', ';
														}
														$host_string = rtrim($host_string, ', ');
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
												</p><!-- results-meta -->
											   
											</div><!-- span9 -->
											
										</div>		<!-- row-fluid -->
						
									
									<?php
									}
								   ?>
				
						

							<?php endwhile; ?>
							<?php wp_reset_postdata(); ?>


						</div><!-- tab-pane #az-list -->
						
						<div class="tab-pane" id="music">
							<?php 
							
							/////////////////////////////////////////////
							//////////    MUSIC
							/////////////////////////////////////////////

								$music_term = get_term_by('slug', 'music', 'program_type');
							
								if ( !empty( $music_term) ) {
						
									$term_id = $music_term->term_id;
					
									$args = array( 'child_of' => $term_id );

									$terms = get_terms('program_type', $args);
							
								$count = count($terms); $i=0;
								if ($count > 0) {

									foreach ($terms as $term) {
										$i++;
										echo "<h2>" . $term->name . "</h2>";
									
										$args = array( 
											'post_type' => array( 'programs'), 
											'post__not_in' => $archivedprograms,
											'posts_per_page' => -1, 
											'tax_query' => array(
												array(
													'taxonomy' => 'program_type',
													'field' => 'slug',
													'terms' => $term->slug
												)
											),
											'order' => 'ASC',
											'orderby'=> 'name', 
											'post_status' => 'publish'
										);
										
										$loop = new WP_Query( $args );
										while ( $loop->have_posts() ) : $loop->the_post();
										?>
										
										<div class="row-fluid program-item">
											<div class="span3">
												<?php if ( has_post_thumbnail() ) {  
													the_post_thumbnail("programs-thumb");	
												} else {
													$upload_dir = wp_upload_dir(); ?>
														<img src="<?php echo get_stylesheet_directory_uri(); ?>/img/program-hero-generic-180x150.jpg" alt="photo of cds in KBCS library" width="180" height="150" /><?php	
												}?>
											</div>
											<div class="span9">
												<h3 <?php post_class() ?>><a href="<?php the_permalink(); ?>"><?php the_title();?></a><?php edit_post_link('edit', ' <small>[', ']</small>');?></h3>
												 <p class="program-days-times"><?php
														$postId = get_the_ID();
														$air_time = Homepage_Program::get_airtimes_for_display( $postId );
														//echo $count;
														echo $air_time; ?>
													 						</p>
												 
												 						<?php echo get_the_excerpt(); ?>
												<p class="results-meta">
												<?php
														$host_string = null;
														$hosts = get_field( 'program_to_host_connection', $post->ID ) ?? '';
						
														if ( is_array($hosts) && count($hosts) > 0 ) {
															$host_string = '<i class="meta-host"></i>Hosted by ';
															foreach ( $hosts as $host ) {
																$permalink = get_permalink( $host->ID );
																$host_string .= "<a href='$permalink'>$host->post_title</a>" . ', ';
															}
															$host_string = rtrim($host_string, ', ');
														
															// Term list returns WP_Error object on error; make sure this is text before echoing.
															if ( is_string( $host_string ) ) {
																echo $host_string;
															} else {
																echo '<!-- Error retrieving staff list -->';
																echo '<!--  ';
																print_r( $host_string );
																echo '  -->';
															}
														}
														?>
												</p><!-- results-meta -->
											</div><!-- span9 -->
										</div><!-- row-fluid -->
										<?php endwhile; 
										
									}//end foreach
								}//end if
							}//end if
						?>
						
						</div><!-- tab-pane #music -->
						
						<div class="tab-pane" id="news-ideas">
							
							
							<?php 
							
							/////////////////////////////////////////////
							//////////   News & Ideas
							/////////////////////////////////////////////
								
								$args = array( 
									'post_type' => array( 'programs', 'segments'), 
									'post__not_in' => $archivedprograms,
									'posts_per_page' => -1, 
									'order' => 'ASC',
									'orderby'=> 'name', 
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
									
									if ( 'programs' == get_post_type() ) {
									 //THIS IS A PROGRAM
										?>
			
										<div class="row-fluid program-item">
											<div class="span3">
												<?php if ( has_post_thumbnail() ) {  
													the_post_thumbnail("programs-thumb");
													
												} else {
													?>
													<?php $upload_dir = wp_upload_dir(); ?>
							
														<img src="<?php echo get_stylesheet_directory_uri(); ?>/img/program-hero-generic-180x150.jpg" alt="photo of cds in KBCS library" width="180" height="150" />
													<?php	
												}
												?>
											</div>
											<div class="span9">
												<h3 <?php post_class() ?>>							
													<a href="<?php the_permalink(); ?>"><?php the_title();?></a><?php edit_post_link('edit', ' <small>[', ']</small>');?>
												</h3>
												<p class="program-days-times"><?php
													$postId = get_the_ID();
													$air_time = Homepage_Program::get_airtimes_for_display( $postId );
													//echo $count;
													echo $air_time; ?>
												 </p>

													<?php echo get_the_excerpt(); ?>

												<p class="results-meta">
												<?php
														$host_string = null;
														$hosts = get_field( 'program_to_host_connection', $post->ID ) ?? '';
														
														if ( is_array($hosts) && count($hosts) > 0 ) {
															$host_string = '<i class="meta-host"></i>Hosted by ';
															foreach ( $hosts as $host ) {
																$permalink = get_permalink( $host->ID );
																$host_string .= "<a href='$permalink'>$host->post_title</a>" . ', ';
															}
															$host_string = rtrim($host_string, ', ');
														
															// Term list returns WP_Error object on error; make sure this is text before echoing.
															if ( is_string( $host_string ) ) {
																echo $host_string;
															} else {
																echo '<!-- Error retrieving staff list -->';
																echo '<!--  ';
																print_r( $host_string );
																echo '  -->';
															}
														}
														?>
												</p><!-- results-meta -->
											   
												
											</div><!-- span9 -->
											
										</div>		<!-- row-fluid -->
									<?php
									} else {
									//THIS IS A SEGMENT
									?>
										<div class="row-fluid program-item">
											<div class="span3">
												<?php if ( has_post_thumbnail() ) {  
													the_post_thumbnail("programs-thumb");
													
												} else {
													?>
													<?php $upload_dir = wp_upload_dir(); ?>
							
														<img src="<?php echo get_stylesheet_directory_uri(); ?>/img/program-hero-generic-180x150.jpg" alt="photo of cds in KBCS library" width="180" height="150" />
													<?php	
												}
												?>
											</div>
											<div class="span9">
												<h3 <?php post_class() ?>>							
													<a href="<?php the_permalink(); ?>"><?php the_title();?></a><?php edit_post_link('edit', ' <small>[', ']</small>');?>
												</h3>

													<?php echo get_the_excerpt(); ?>

												<p class="results-meta">
														<?php
														$host_string = null;
														$hosts = get_field( 'program_to_host_connection', $post->ID ) ?? '';
														if ( is_array($hosts) && count($hosts) > 0 ) {
															$host_string = '<i class="meta-host"></i>Hosted by ';
															foreach ( $hosts as $host ) {
																$permalink = get_permalink( $host->ID );
																$host_string .= "<a href='$permalink'>$host->post_title</a>" . ', ';
															}
															$host_string = rtrim($host_string, ', ');
														
															// Term list returns WP_Error object on error; make sure this is text before echoing.
															if ( is_string( $host_string ) ) {
																echo $host_string;
															} else {
																echo '<!-- Error retrieving staff list -->';
																echo '<!--  ';
																print_r( $host_string );
																echo '  -->';
															}
														}
														?>
												</p><!-- results-meta -->
											   
												
											</div><!-- span9 -->
											
										</div>		<!-- row-fluid -->
									
									<?php
									}
									
									
									endwhile; 
									wp_reset_postdata(); ?>
						
						</div><!-- tab-pane #news-ideas -->

					</div><!-- tab-content -->					




						<script>
							jQuery('#myTab a').click(function (e) {
								e.preventDefault();
								jQuery(this).tab('show');						
							})
							
							
							jQuery(function(){

								//add hash on URL
							var hash = window.location.hash;
							hash && jQuery('ul.nav a[href="' + hash + '"]').tab('show');

							});
							
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
						
					</div><!--#content .span8 -->
				<?php get_sidebar(); ?>
				</div><!-- row -->
			</div><!-- container -->
	<?php get_footer(); ?>
