<?php get_header(); ?>

<div class="whatpageisthis">single-audio.php</div>		

	<div class="container">
        <div class="row">	
            <div class="span8" id="content">

				<?php while (have_posts() ) : the_post(); ?>
					<h2><?php the_title(); ?></h2>
					<?php the_content(); ?>		
				<?php endwhile; ?>

			</div><!--#content .span8 -->
			<?php get_sidebar(); ?>
		</div><!-- row -->
	</div><!-- container -->
<?php get_footer(); ?>