<?php
/**
* // Staff archive page
* Template Name: Full Width (No Sidebar)
*/

get_header(); ?>
<div class="whatpageisthis">template-full-width.php</div>		
	
			<div class="container">
				<div class="row">	
					<div class="span12" id="content">
					
					
						<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
		
						<h1><?php the_title();?></h1>

						<?php the_content();?>
						<?php endwhile; else: ?>
						<p><?php _e('Sorry, no posts matched your criteria.'); ?></p>
						<?php endif; ?>
					
					
					</div>
				</div><!-- row -->
			</div><!-- container -->
	<?php get_footer();
