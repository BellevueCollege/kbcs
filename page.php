<?php get_header(); ?>
<div class="whatpageisthis">page.php</div>

<div class="row">
	<main class="span8" id="content">
	<h1 class="inner-heading"><?php the_title();?></h1>
		<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

        <?php the_content();?>
		<?php endwhile; else: ?>
		<p><?php _e('Sorry, no posts matched your criteria.'); ?></p>
		<?php endif; ?>
	</main><!-- span8  #content -->

	<?php get_sidebar(); // sidebar 1 ?>

</div><!-- row -->


<?php get_footer(); ?>
