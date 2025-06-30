<article title="<?php the_title(); ?>">
	<h2 <?php post_class(); ?>><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
	<div class="media">
		<?php if (has_post_thumbnail()) { ?>
			<div class="thumb media-left">
				<?php the_post_thumbnail("thumbnail", ["class" => "media-object"]); ?>

			<?php if (get_post(get_post_thumbnail_id())->post_excerpt) { ?>
		<span class="thumb featured-caption media-object"><?php echo get_post(
      get_post_thumbnail_id()
  )->post_excerpt; ?></span>
		<?php } ?>
			</div><!-- media-left -->
		<?php } ?>
		<div class="media-content">
			<p><small><?php the_time("F j, Y"); ?> - <?php the_time("g:i a"); ?></small></p>
			<?php if (@strpos($post->post_content, "<!--more-->")) {
       global $more;
       $old_more = $more;
       $more = 0;
       the_content(custom_excerpt_more(null));
       $more = $old_more;
   } else {
       the_excerpt();
   } ?>
		</div> <!-- media-content -->
	</div><!-- media -->
</article>
