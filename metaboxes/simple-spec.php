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
	//'save_action'   => 'save_taxonomy_terms',
	//'save_action'   => 'my_save_action_func',
	//'save_action'   => 'save_degree_title',
	'mode' => WPALCHEMY_MODE_ARRAY,
));

$event_metabox = $simple_mb = new WPAlchemy_MetaBox(array
(
	'id' => '_eventdate_meta',
	'title' => 'Event Occurs',
	'template' => get_stylesheet_directory() . '/metaboxes/events-meta.php',
	'types' => array('events'),
	'priority' => 'low',
	'autosave' => TRUE,
	'save_action'   => 'save_event_start_date',
	//'save_action'   => 'save_event_start_time',
	//'save_action'   => 'save_event_end_time',
	//'mode' => WPALCHEMY_MODE_EXTRACT,
));





function save_taxonomy_terms($meta, $post_id) {
	wp_set_post_terms($post_id, array($meta['my_terms']), 'category', FALSE);
}

function save_event_start_date ($meta, $post_id) {
	global $event_metabox;
	$meta = get_post_meta(get_the_ID(), $event_metabox->get_the_id(), TRUE);
	update_post_meta($post_id, '_kbcs_event_start_date',  $meta);
}

/* eof */