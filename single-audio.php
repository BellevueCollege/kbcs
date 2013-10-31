<?php

get_header(); ?>

	<div class="container">
	<?php while (have_posts() ) : the_post(); ?>
<?php the_content(); ?>
<h2>Display Test</h2>
<?php

$audios = get_posts(array(
	'numberposts' => -1,
	'post_type' => 'audio',
	'suppress_filters' => false,
	'orderby' => 'title',
	'order' => 'ASC'
));

if($audios) { ?>
		<ol><?php

    foreach($audios as $audio) { 
	        global $audio_metabox;
	        $id = $audio->ID;
	        //$metaKey = $audio_metabox->id;
	        //$program_terms = get_the_term_list( $audio->ID, 'programs', '', ', ', '' );
	//        error_log("value :".$program_terms);

			?>
			<?php /*
			<h3><?php 
$taxonomies=get_taxonomies('','names'); 
foreach ($taxonomies as $taxonomy ) {
  echo '<p>'. $taxonomy. '</p>';
}
?></h3>
*/ ?>
			<li>
				<?php echo $id . ' - ' ;?>
				<?php echo get_the_term_list( $post->ID, 'programs'); ?><br />
				Title: <?php var_dump(get_the_title( $audio->ID )); ?>
			</li><?php
		}
}
//$audio_metabox->the_field('air_date');
//$audio_metabox->the_value();
			?></ol>
<?php endwhile; ?>
	</div>
<?php get_footer(); ?>