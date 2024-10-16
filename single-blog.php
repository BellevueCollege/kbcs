<?php get_header(); ?>

<div class="whatpageisthis">single-blog.php</div>		

	<div class="container">
        <div class="row">	
            <main class="span8" id="content">


		<?php $query = new WP_Query( 'post_type=blog' ); ?>
		<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

		<?php echo get_the_content(); ?>
		<?php endwhile; else: ?>
		<p><?php _e('Sorry, no posts matched your criteria.'); ?></p>
		<?php endif; ?>


			</main><!--#content .span8 -->
			<?php get_sidebar(); ?>
		</div><!-- row -->
	</div><!-- container -->
<?php get_footer(); ?>