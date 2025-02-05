<?php get_header(); ?>

<div class="whatpageisthis">index.php</div>		

	<div class="container">
        <div class="row">	
            <main class="span8" id="content"> <!-- Why is this not showing up in the DOM on my browser? -->


		<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
		<h2><a href="<?php the_permalink(); ?>"><?php the_title();?></a><?php edit_post_link('edit', ' <small>[', ']</small>'); ?></h2>
		<?php the_content(); ?>
		<?php endwhile; else: ?>
		<p><?php _e('Sorry, no posts matched your criteria.'); ?></p>
		<?php endif; ?>
	
    
    		</main><!--#content .span8 -->
			<?php get_sidebar(); ?>
		</div><!-- row -->
	</div><!-- container -->
<?php get_footer(); ?>