<?php get_header(); ?>
<div class="whatpageisthis">page.php</div>

<div class="row">
	<div class="span8" id="content">
		<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
		
        <h1><?php the_title();?></h1>

        <?php the_content();?>
		<?php endwhile; else: ?>
		<p><?php _e('Sorry, no posts matched your criteria.'); ?></p>
		<?php endif; ?>
	</div><!-- span8  #content -->
    
	<?php get_sidebar(); // sidebar 1 ?>

</div><!-- row -->


<?php get_footer(); ?>