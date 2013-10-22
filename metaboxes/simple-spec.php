<?php

$custom_metabox = $simple_mb = new WPAlchemy_MetaBox(array
(
	'id' => '_custom_meta',
	'title' => 'My Custom Meta',
	'types' => array(''),
	'template' => get_stylesheet_directory() . '/metaboxes/simple-meta.php',
));

$audio_metabox = $simple_mb = new WPAlchemy_MetaBox(array
(
	'id' => '_audio_meta',
	'title' => 'Air Dates',
	'template' => get_stylesheet_directory() . '/metaboxes/audio-meta.php',
	'types' => array('audio'),
	'save_action'   => 'save_taxonomy_terms',
	'save_action'   => 'my_save_action_func',
	//'save_action'   => 'save_degree_title',
	'mode' => WPALCHEMY_MODE_ARRAY,
));

function save_taxonomy_terms($meta, $post_id) {
	wp_set_post_terms($post_id, array($meta['my_terms']), 'category', FALSE);
}

function my_save_action_func ($meta, $post_id) {
	$value = $meta['program_terms'];
	update_post_meta($post_id, '_my_custom_title3_',  $value);
}

/* eof */