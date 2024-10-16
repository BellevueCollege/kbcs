<?php get_header(); ?>

<div class="whatpageisthis">single-mc-events.php</div>		

	<div class="container">
        <div class="row">	
            <main class="span8" id="content">
				<?php
				
				if (have_posts()) : while (have_posts()) : the_post();

if ( has_post_format( 'quote' )) { 
    // do some stuff
	get_template_part('format', 'quote');

} elseif ( has_post_format( 'video' )) {
    // do some other stuff
	get_template_part('format', 'video');

} else { ?>

<h2>							
	<?php the_title();?>
</h2>

<div class="event">

	<div class="event-body">

		<div class="event-content">
			<?php the_content(); ?>
		</div>
    </div><!-- media-body -->
</div><!-- media -->


<?php }


					
				
				
				endwhile; ?>


				<?php wp_reset_query(); endif; ?>

    		</main><!--#content .span8 -->
			<?php get_sidebar(); ?>
		</div><!-- row -->
	</div><!-- container -->
<?php get_footer(); 

