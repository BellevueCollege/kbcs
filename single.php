<?php get_header(); ?>

<div class="whatpageisthis">single.php</div>		

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

<article class="media-body">
	<h2>							
		<?php the_title();?>
	</h2>

	<p><small><?php the_time('F j, Y'); ?> - <?php the_time('g:i a'); ?></small></p>

	<div class="media-thumbnail">
	
		<?php 
			if ( has_post_thumbnail() ) {
				?>
			
				
				<?php
					the_post_thumbnail('featured-in-content', array('class' => 'media-object')); 
						if(get_post(get_post_thumbnail_id())->post_excerpt) { ?>
						<span class="full-caption media-object"><?php echo get_post( get_post_thumbnail_id() )->post_excerpt ?></span>
						<?php } ?>
				
			<?php
				}
				else {	}
			?>												    
		</div><!-- media-thumbnail -->
		<?php the_content(); ?>
</article><!-- media-body -->


<?php }


					
				
				
				endwhile; ?>


    <ul class="pager">
    <li class="previous">
    <?php previous_post_link( '%link', '<span class="meta-nav">' . _x( '&larr;', 'Previous post link', 'twentytwelve' ) . '</span> %title' ); ?>
    </li>
    <li class="next">
    <?php next_post_link( '%link', '%title <span class="meta-nav">' . _x( '&rarr;', 'Next post link', 'twentytwelve' ) . '</span>' ); ?>
    </li>
    </ul>
    
    
				<!--<nav class="nav-single">
					<span class="nav-previous"></span>
					<span class="nav-next"></span>
				</nav>.nav-single -->

				<?php wp_reset_query(); endif; ?>

    		</main><!--#content .span8 -->
			<?php get_sidebar(); ?>
		</div><!-- row -->
	</div><!-- container -->
<?php get_footer(); 


/* Redfinition of core function. Removed due to conflict as hotfix.
function the_post_thumbnail_caption() {
  global $post;

  $thumbnail_id    = get_post_thumbnail_id($post->ID);
  $thumbnail_image = get_posts(array('p' => $thumbnail_id, 'post_type' => 'attachment'));

  if ($thumbnail_image && isset($thumbnail_image[0])) {
    echo '<span>'.$thumbnail_image[0]->post_excerpt.'</span>';
  }
} */
