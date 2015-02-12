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
						<li><a href="#playlist" data-toggle="tab">Playlists</a></li>
					</ul><!-- nav-tabs -->
					 
					<div class="tab-content">
						<div class="tab-pane active" id="schedule">
						    <?php
							/////////////////////////////////////////////
							//////////    Schedule
							/////////////////////////////////////////////
							?>
						    <!-- start weekday left tabs -->
						    <div class="tabbable tabs-left"> <!-- Only required for left/right tabs -->
							    <ul class="nav nav-tabs">
								    <li  class="active">
								    	<a href="#monday" data-toggle="tab">Monday</a>
							    	</li>
								    <li>
								    	<a href="#tuesday" data-toggle="tab">Tuesday</a>
							    	</li>
								    <li>
								    	<a href="#wednesday" data-toggle="tab">Wednesday</a>
							    	</li>
								    <li>
								    	<a href="#thursday" data-toggle="tab">Thursday</a>
							    	</li>
								    <li>
								    	<a href="#friday" data-toggle="tab">Friday</a>
							    	</li>
								    <li>
								    	<a href="#saturday" data-toggle="tab">Saturday</a>
							    	</li>
								    <li>
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
														    <td><?php echo date("g:ia", strtotime("{$starttime}")); };?></td>
														    <td><a href="<?php the_permalink();?>"><?php the_title(); ?></a>
                                                            					<?php edit_post_link('edit', ' <small>[', ']</small>');?> </td>
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
														    <td><?php echo date("g:ia", strtotime("{$starttime}")); };?></td>
														    <td><a href="<?php the_permalink();?>"><?php the_title(); ?></a>
                                                            			<?php edit_post_link('edit', ' <small>[', ']</small>');?></td>
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
														    <td><?php echo date("g:ia", strtotime("{$starttime}")); };?></td>
														    <td><a href="<?php the_permalink();?>"><?php the_title(); ?></a>
                                                            			<?php edit_post_link('edit', ' <small>[', ']</small>');?></td>
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
														    <td><?php echo date("g:ia", strtotime("{$starttime}")); };?></td>
														    <td><a href="<?php the_permalink();?>"><?php the_title(); ?></a>
                                                            			<?php edit_post_link('edit', ' <small>[', ']</small>');?></td>
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
														    <td><?php echo date("g:ia", strtotime("{$starttime}")); };?></td>
														    <td><a href="<?php the_permalink();?>"><?php the_title(); ?></a>
                                                            			<?php edit_post_link('edit', ' <small>[', ']</small>');?></td>
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
														    <td><?php echo date("g:ia", strtotime("{$starttime}")); };?></td>
														    <td><a href="<?php the_permalink();?>"><?php the_title(); ?></a>
                                                            			<?php edit_post_link('edit', ' <small>[', ']</small>');?></td>
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
														    <td><?php echo date("g:ia", strtotime("{$starttime}")); };?></td>
														    <td><a href="<?php the_permalink();?>"><?php the_title(); ?></a>
                                                            			<?php edit_post_link('edit', ' <small>[', ']</small>');?></td>
													    </tr>
													<?php } ?>
					
												<?php endwhile; ?>
												<?php wp_reset_postdata(); ?>

										    </tbody>
									    </table>	
								    </div><!-- tab-pane #sunday --> 

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
									   	$starttime = get_post_meta( $post->ID, 'onair_starttime', true );
										$endtime = get_post_meta( $post->ID, 'onair_endtime', true );
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
                                
                                                            <img src="<?php echo $upload_dir['baseurl']; ?>/2013/03/program-hero-generic-180x150.jpg" alt="photo of cds in KBCS library" width="180" height="150" />
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
														$air_time = airTimings($postId);
														//echo $count;
														echo $air_time; ?>
                                                     </p>

                                                        <?php echo get_the_excerpt(); ?>

                                                    <p class="results-meta">
                                                            <?php echo get_the_term_list( $post->ID, 'staff', '<i class="meta-host"></i>Hosted by ', ', ', '' ); ?>
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
                            
                                                        <img src="<?php echo $upload_dir['baseurl']; ?>/2013/03/program-hero-generic-180x150.jpg" alt="photo of cds in KBCS library" width="180" height="150" />
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
                                                        <?php echo get_the_term_list( $post->ID, 'staff', '<i class="meta-host"></i>Hosted by ', ', ', '' ); ?>
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
								
							$args = array( 'child_of' => 5 );

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
														<img src="<?php echo $upload_dir['baseurl']; ?>/2013/03/program-hero-generic-180x150.jpg" alt="photo of cds in KBCS library" width="180" height="150" /><?php	
												}?>
											</div>
											<div class="span9">
												<h3 <?php post_class() ?>><a href="<?php the_permalink(); ?>"><?php the_title();?></a><?php edit_post_link('edit', ' <small>[', ']</small>');?></h3>
												 <p class="program-days-times"><?php
														$postId = get_the_ID();
														$air_time = airTimings($postId);
														//echo $count;
														echo $air_time; ?>
                                                     </p>
                                                 
                                                 <?php echo get_the_excerpt(); ?>
												<p class="results-meta"><?php echo get_the_term_list( $post->ID, 'staff', '<i class="meta-host"></i>Hosted by ', ', ', '' ); ?></p><!-- results-meta -->
											</div><!-- span9 -->
										</div><!-- row-fluid -->
										<?php endwhile; 
										
									}//end foreach
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
							
														<img src="<?php echo $upload_dir['baseurl']; ?>/2013/03/program-hero-generic-180x150.jpg" alt="photo of cds in KBCS library" width="180" height="150" />
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
													$air_time = airTimings($postId);
													//echo $count;
													echo $air_time; ?>
												 </p>

													<?php echo get_the_excerpt(); ?>

												<p class="results-meta">
														<?php echo get_the_term_list( $post->ID, 'staff', '<i class="meta-host"></i>Hosted by ', ', ', '' ); ?>
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
							
														<img src="<?php echo $upload_dir['baseurl']; ?>/2013/03/program-hero-generic-180x150.jpg" alt="photo of cds in KBCS library" width="180" height="150" />
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
														<?php echo get_the_term_list( $post->ID, 'staff', '<i class="meta-host"></i>Hosted by ', ', ', '' ); ?>
												</p><!-- results-meta -->
											   
												
											</div><!-- span9 -->
											
										</div>		<!-- row-fluid -->
                                    
                                    <?php
									}
									
									
									endwhile; 
									wp_reset_postdata(); ?>
						
						</div><!-- tab-pane #news-ideas -->

						<div class="tab-pane active" id="playlist">
							<ul>
								<li><a href="http://kbcs.fm/live-playlist/">Current Playlist</a></li>
								<li><a href="http://kbcsweb.bellevuecollege.edu/play/tools/finder">Search Playlists By Date</a></li>
							</ul>
						</div><!-- tab-pane #playlist -->
					</div><!-- tab-content -->					




						<script>
							jQuery('#myTab a').click(function (e) {
								e.preventDefault();
								jQuery(this).tab('show');						
							})
							
							
							jQuery(function(){

								//add hash on URL
							var hash = window.location.hash;
							hash && $('ul.nav a[href="' + hash + '"]').tab('show');

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
