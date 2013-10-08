<?php
/**
 * Template Name: Navigation Page
 *
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 */
  get_header(); ?>
<div class="whatpageisthis">template-nav-page.php</div>

<div class="row">
	<div class="span8" id="content">
		<?php while ( have_posts() ) : the_post(); ?>
		
        	<h1><?php the_title();?></h1>
			
			
			<?php
            
			the_content();
			
			
		endwhile;

        wp_reset_query();
		
		$args = array(
			'post_type' => 'page',
			'posts_per_page' => -1,
			'orderby' => 'menu_order title',
			'post_status' => 'publish',
			'post_parent' => $post->ID
		);
		$loop = new WP_Query( $args );
		
		$count = 1;
		$collumns = 2;
		while ( $loop->have_posts() ) : $loop->the_post();
            if ($count == 1) {
				echo '<div class="row-fluid">';	
			}
            ?>
            <div class="span6">
            	<h2><a href="<?php the_permalink(); ?>"><?php the_title();?></a></h2>
                <?php 
					the_excerpt();
					edit_post_link('edit', '<small>', '</small>');
				?>
			</div>
            <?php
            if ($count == $collumns) {
				echo '</div> <!--.row-fluid-->';	
				$count = 0;
			}
			$count++;
		endwhile; 
		
		// close div if it hadn't closed duing the loop
		if ($count > 1)  { echo '</div> <!--.row-fluid-->'; }
		?>

        
    </div><!-- span8  #content -->
    
	<?php get_sidebar(); // sidebar 1 ?>

</div><!-- row -->


<?php get_footer(); ?>