<?php
/**
 * Template Name: Audio Archives
 *
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 */
  get_header(); ?>
<div class="whatpageisthis">page.php</div>

<div class="row">
	<div class="span8" id="content">
		<?php while ( have_posts() ) : the_post(); ?>
		
        	<h1><?php the_title();?></h1>
			
			
			<?php
            
			the_content();
	
		endwhile;

        wp_reset_query();
		?>
        <ul>
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
                            
                            
                                	<li <?php post_class() ?>>							
                                        <a href="<?php the_permalink(); ?>"><?php the_title();?></a>
                                    </li>
            

							<?php endwhile; ?>
							<?php wp_reset_postdata(); ?>

						</ul><!-- tab-pane #az-list -->

        
    </div><!-- span8  #content -->
    
	<?php get_sidebar(); // sidebar 1 ?>

</div><!-- row -->


<?php get_footer(); ?>