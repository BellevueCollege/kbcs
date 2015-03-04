<h2 <?php post_class() ?>><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
<div class="media">
	<a class="pull-left" href="<?php the_permalink(); ?>">
		<?php
		if ( has_post_thumbnail() ) {
			the_post_thumbnail( 'thumbnail', array( 'class' => 'media-object' ) );
			if( get_post( get_post_thumbnail_id() )->post_excerpt ) {
		?>
		<span class="featured-caption media-object"><?php echo get_post( get_post_thumbnail_id() )->post_excerpt ?></span>
		<?php
			}
		}
		?>
	</a>
	<div class="media-body">
		<div class="media-content">
			<p><small><?php the_time( 'F j, Y' ); ?> - <?php the_time( 'g:i a' ); ?></small></p>
			<?php the_excerpt(); ?>
		</div>
		<?php
		if ( is_single( $post ) ) {
		} else { ?>
		<p><a class="btn btn-small primary-read-more" href="<?php the_permalink(); ?>">
			Read More <i class="icon-chevron-right"></i>
		</a></p>
		<?php } ?>
	</div>
</div>
