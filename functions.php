<?php 

//date_default_timezone_set('America/Los_Angeles');

function status_title_filter( $cleanPost )
{
	if( $cleanPost['post_type'] == 'epsiodes' && $cleanPost['post_status'] != 'auto-draft' && $_GET['action'] != 'trash' && $_GET['action'] != 'untrash' )
		$cleanPost['post_title'] = $cleanPost['post_name'] = $cleanPost['post_date'];

	return $cleanPost;
}

add_filter( 'wp_insert_post_data', 'status_title_filter' );


######################################
// Add Search box to mobile menu
######################################
add_filter('wp_nav_menu_items','add_search_box', 0, 2);
function add_search_box($items, $args) {

		ob_start();
		get_search_form();
		$searchform = ob_get_contents();
		ob_end_clean();

		$items .= '<li class="visible-phone">';
		$items .= $searchform . '</li>';

	return $items;
}

###############################
// Includes
##############################

if( file_exists(get_template_directory() . '/inc/funddrive/funddrive.php') )
	require( get_template_directory() . '/inc/funddrive/funddrive.php');


if( file_exists(get_template_directory() . '/inc/staff/staff.php') )
	require( get_template_directory() . '/inc/staff/staff.php');
	
if( file_exists(get_template_directory() . '/inc/currentprograms.php') )
	require( get_template_directory() . '/inc/currentprograms.php');

if( file_exists(get_template_directory() . '/inc/homepage-program.php') ) {
	require_once( get_template_directory() . '/inc/homepage-program.php');
}

if( file_exists(get_template_directory() . '/acf.php') ) {
	require_once( get_template_directory() . '/acf.php');
}

###############################
// front-end filters
##############################

//excerpt tweak
//function replace_excerpt($content) {
//       return str_replace('[...]',
//               '... <div class="more-link"><a href="'. get_permalink() .'">More...</a></div>',
//               $content
//       );
//}
//add_filter('the_excerpt', 'replace_excerpt');

###############################
// search filter to prevent empty search redirect to home page
##############################

add_filter( 'request', 'my_request_filter' );
function my_request_filter( $query_vars ) {
	if( isset( $_GET['s'] ) && empty( $_GET['s'] ) ) {
		$query_vars['s'] = " ";
	}
	return $query_vars;
}

###############################################
// Change what dashboard metaboxes are hidden by default
###############################################

add_filter('default_hidden_meta_boxes', 'be_hidden_meta_boxes', 10, 2);
function be_hidden_meta_boxes($hidden, $screen) {
	if ( 'post' == $screen->base || 'page' == $screen->base )
		$hidden = array('slugdiv', 'trackbacksdiv', /*'postexcerpt',*/ 'postcustom', 'commentstatusdiv', 'commentsdiv', 'authordiv', 'revisionsdiv');
		// removed 'postcustom',
	return $hidden;
}

##############################
// Enqueue Scripts & Styles
##############################

	//Backend
	function load_admin_scripts() {
		$funddrive_css_path = get_template_directory_uri() . '/inc/funddrive/css/funddrive.css';
		$bootstrap_js_path = get_template_directory_uri() . '/js/bootstrap.min.js';

			wp_register_style( 'admin', get_template_directory_uri() . '/admin.css', array(), wp_get_theme()->get( 'Version' ) );
	   		wp_register_style( 'jquery-ui', get_template_directory_uri() . '/css/jquery-ui.css', array(), wp_get_theme()->get( 'Version' ) );
			wp_register_style( 'funddrive', $funddrive_css_path, array(), wp_get_theme()->get( 'Version' ) );

			wp_enqueue_style( 'admin' );
			wp_enqueue_style( 'funddrive' );
			wp_enqueue_style( 'jquery-ui' );

		   wp_register_script( 'bootstrap', $bootstrap_js_path, array(), false);
		   //wp_enqueue_script('bootstrap');  

			wp_enqueue_script('jquery-ui-datepicker');   
			wp_enqueue_script('datepicker', get_template_directory_uri() . '/inc/funddrive/js/datepicker.js'); 
			wp_enqueue_script('jquery-ui-sortable');   
	}
	add_action( 'admin_enqueue_scripts', 'load_admin_scripts' );

	//Frontend	

	function load_frontend_scripts() {
		$funddrive_css_path = get_template_directory_uri() . '/inc/funddrive/css/funddrive.css';
		$bootstrap_js_path = get_template_directory_uri() . '/js/bootstrap.min.js';

		wp_deregister_style( 'kbcs' );
		wp_enqueue_style( 'kbcs', get_stylesheet_uri(), array('bootstrap'), wp_get_theme()->get( 'Version' ) );

		wp_enqueue_style( 'funddrive', $funddrive_css_path, array(), wp_get_theme()->get( 'Version' ) );

		wp_enqueue_style( 'bootstrap', get_template_directory_uri() . '/css/bootstrap.css', array(), wp_get_theme()->get( 'Version' ) );
		wp_enqueue_style( 'bootstrap-responsive', get_template_directory_uri('bootstrap') . '/css/bootstrap-responsive.css', array(), wp_get_theme()->get( 'Version' ) );
		wp_enqueue_style( 'font-awesome', get_template_directory_uri() . '/css/font-awesome.css', array(), wp_get_theme()->get( 'Version' ) );

		wp_enqueue_script( 'bootstrap', $bootstrap_js_path, array(), wp_get_theme()->get( 'Version' ) );

		wp_enqueue_script('moment', get_template_directory_uri() . '/js/moment.min.js', array('jquery') ); 
		wp_enqueue_script('jplayer', get_template_directory_uri() . '/js/jquery.jplayer.min.js', array('jquery'), '2.9.2b');
		wp_enqueue_script('jplaylist', get_template_directory_uri() . '/js/jplayer.playlist.min.js', array('jquery', 'jplayer'), '2.9.2b');      
		wp_enqueue_script('sitejs', get_template_directory_uri() . '/js/sitejs.js');   
	}
	add_action( 'wp_enqueue_scripts', 'load_frontend_scripts' );
		
#######################################
// adds wordpress theme support
#######################################

	// Post Thumbnails
		if ( function_exists( 'add_theme_support' ) ) {
			add_theme_support( 'post-thumbnails' );
				set_post_thumbnail_size( 150, 150);
				add_image_size( 'sidebar-ad', 370,310, true);
				add_image_size( 'edit-screen-thumbnail', 100, 100, true );
				add_image_size( 'staff-thumbnail', 200, 300, true );
				add_image_size( 'programs-hero', 770, 360, true );
				add_image_size( 'programs-thumb', 180, 150, true );
				//add_image_size( 'featured-full', 1170,210,true);
				//add_image_size( 'featured-in-content', 940,310,true);
		}

	// Custom Menus
		if (function_exists('add_theme_support')) {
			add_theme_support('menus');
		}

register_nav_menus( array(
	'main-nav' => __( 'Main Nav' ),
	'sub-nav' => __( 'Sub Nav' )
) ); 		

// adding post format support
	add_theme_support( 'post-formats',      // post formats
		array( 
			'quote',   // a quick quote
			'video',   // video 
		)
	);


// enable excerpts on pages
add_post_type_support( 'page', 'excerpt' );


######################################
// Widget Areas
######################################

if ( function_exists('register_sidebar') )
	register_sidebar(array(
		'name'=> 'Events Widget',
		'id' => 'events-widget-area',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3>',
		'after_title' => '</h3>',
	));

######################################
// Resize embedded video filter
######################################

add_filter('embed_defaults', 'custom_embed_defaults');

function custom_embed_defaults($embed_size) {
	if (is_single()) { // Conditionally set max height and width
		$embed_size['width'] = 770;
		$embed_size['height'] = 600;
	} else {           // Default values
		$embed_size['width'] = 770;
		$embed_size['height'] = 600;
	}
	return $embed_size; // Return new size
}

#######################################
// Register custom taxonomies
#######################################


add_action( 'init', 'build_taxonomies', 0 );

function build_taxonomies() {
register_taxonomy( 'program_type', array('programs', 'segments'), array( 'hierarchical' => true, 'label' => 'Program Type', 'query_var' => true, 'rewrite' => true, 'show_in_rest' => true ) );
register_taxonomy( 'staff_type', 'staff', array( 'hierarchical' => true, 'label' => 'Staff Type', 'query_var' => true, 'rewrite' => true, 'show_in_rest' => true ) );

}


#######################################
// add Custom Post types
#######################################

	// Newsletter
	/*   add_action('init', 'kbcs_newsletter_cpt_register');  
	  
		function kbcs_newsletter_cpt_register() {  
			$labels = array(
				'name' => _x('Newsletters', 'post type general name'),
				'singular_name' => _x('Newsletter', 'post type singular name'),
				'add_new' => _x('Add New', 'Newsletter'),
				'add_new_item' => __('Add New Newsletter'),
				'edit_item' => __('Edit Newsletter'),
				'new_item' => __('New Newsletter'),
				'all_items' => __('Newsletter List'),
				'view_item' => __('View Newsletter'),
				'search_items' => __('Search Newsletters'),
				'not_found' =>  __('No Newsletters found'),
				'not_found_in_trash' => __('No Newsletters found in Trash'), 
				'parent_item_colon' => '',
				'menu_name' => __('Newsletter')		
			);
			
			$args = array(  
				'labels' => $labels,
				'public' => true,  
				'show_ui' => true,  
				'hierarchical' => true,  
				'has_archive' =>true,
				'rewrite' => true,  
	 			'menu_position' => null, 
				'supports' => array('title', 'editor', 'thumbnail', 'category', 'author', 'revisions',  'author', ),
		
			   );  
		  
			register_post_type( 'newsletter' , $args );  
		}  
*/

	// Segments
		add_action('init', 'kbcs_segments_cpt_register');  
	  
		function kbcs_segments_cpt_register() {  
			$labels = array(
				'name' => _x('Segments', 'post type general name'),
				'singular_name' => _x('Segment', 'post type singular name'),
				'add_new' => _x('Add New', 'Segment'),
				'add_new_item' => __('Add New Segment'),
				'edit_item' => __('Edit Segment'),
				'new_item' => __('New Segment'),
				'all_items' => __('Segment List'),
				'view_item' => __('View Segments'),
				'search_items' => __('Search Segments'),
				'not_found' =>  __('No Segments found'),
				'not_found_in_trash' => __('No Segments found in Trash'), 
				'parent_item_colon' => '',
				'menu_name' => __('Segments')		
			);
			
			$args = array(  
				'labels' => $labels,
				'public' => true,  
				'show_ui' => true,  
				'hierarchical' => true,  
				'has_archive' =>true,
				'rewrite' => true,  
	 			'menu_position' => null, 
				'supports' => array('title', 'editor', 'thumbnail', 'category', 'author', 'revisions', /*'page-attributes',*/ 'author', /*'comments'*/),
				'taxonomies' => array(/*'category', 'post_tag',*/) // this is IMPORTANT
			   );  
		  
			register_post_type( 'segments' , $args );  
		} 
		

	// Ads
		add_action('init', 'kbcs_ads_cpt_register');  
	  
		function kbcs_ads_cpt_register() {  
			$labels = array(
				'name' => _x('Ads', 'post type general name'),
				'singular_name' => _x('Ad', 'post type singular name'),
				'add_new' => _x('Add New', 'Ad'),
				'add_new_item' => __('Add New Ad'),
				'edit_item' => __('Edit Ad'),
				'new_item' => __('New Ad'),
				'all_items' => __('Ad List'),
				'view_item' => __('View Ads'),
				'search_items' => __('Search Ads'),
				'not_found' =>  __('No Ads found'),
				'not_found_in_trash' => __('No Ads found in Trash'), 
				'parent_item_colon' => '',
				'menu_name' => __('Ads')		
			);
			
			$args = array(  
				'labels' => $labels,
				'public' => true,  
				'show_ui' => true,  
				'hierarchical' => true,  
				'has_archive' =>true,
				'rewrite' => true,  
	 			'menu_position' => null, 
				'supports' => array('title', 'editor', 'thumbnail', 'category', 'author', 'revisions', /*'page-attributes',*/ 'author', /*'comments'*/),
				'taxonomies' => array(/*'category', 'post_tag',*/), // this is IMPORTANT
				'show_in_rest' => true
			   );  
		  
			register_post_type( 'ads' , $args );  
		} 	
					


		
	// Programs
		add_action('init', 'kbcs_programs_cpt_register');  
	  
		function kbcs_programs_cpt_register() {  
			$labels = array(
				'name' => _x('Programs', 'post type general name'),
				'singular_name' => _x('Program', 'post type singular name'),
				'add_new' => _x('Add New', 'Program'),
				'add_new_item' => __('Add New Program'),
				'edit_item' => __('Edit Program'),
				'new_item' => __('New Program'),
				'all_items' => __('Program List'),
				'view_item' => __('View Program'),
				'search_items' => __('Search Programs'),
				'not_found' =>  __('No Programs found'),
				'not_found_in_trash' => __('No Programs found in Trash'), 
				'parent_item_colon' => '',
				'menu_name' => __('Programs')		
			);
			
			$args = array(  
				'labels' => $labels,
				'public' => true,  
				'show_ui' => true,  
				'hierarchical' => true,  
				'has_archive' =>true,
				'rewrite' => true,  
				'show_in_nav_menus' => true,
	 			'menu_position' => null, 
				'supports' => array('title', 'editor', 'thumbnail', 'category', /*'author',*/ 'revisions', /*'page-attributes',*/ /*'author',*/ /*'comments'*/),
				'taxonomies' => array(/*'category', 'post_tag',*/), // this is IMPORTANT
				'show_in_rest' => true
			   );  
		  
			register_post_type( 'programs' , $args );  
		}  






	//Getting unixtime
			function format_date($utime) {
			
				if ($utime != null) {
					return date("Y-m-d", $utime); 		
				}
			else { return "";}
			}




##################################################
// Custom Metaboxes for Programs - Schedule Info
##################################################



###########################################
// Custom Columns for Programs CPT
###########################################

add_filter( 'manage_edit-programs_columns', 'my_edit_programs_columns' ) ;

function my_edit_programs_columns( $columns ) {

	$columns = array(
		'cb' => '<input type="checkbox" />',
		'featured-image' => __( 'Image' ),
		'title' => __( 'Program' ),
		'ontheair' => __( 'On the Air' ),
		'programid' => __( 'Program ID' )
	);
	return $columns;
}

//Add content to custom columns 

add_action( 'manage_programs_posts_custom_column', 'my_manage_programs_columns', 10, 2 );

function my_manage_programs_columns( $column, $post_id ) {
	global $post;

	switch( $column ) {

		case 'featured-image' :

			/* Get the featured image id. */
			$thumbnail_id = get_post_meta( $post_id, '_thumbnail_id', true );

			/* If no featured image is found, output a default message. */
			if ( $thumbnail_id )
				echo get_the_post_thumbnail( $post->ID, 'edit-screen-thumbnail' );
			else
				echo __( 'None' );

			break;


		case 'ontheair' :

			//$onair = get_post_meta($post_id, 'onaircheckbox_group', true);
			$onair = get_field( 'air_days', $post_id ) ?? array();
			foreach ( $onair as $key => $value ) {
				//Trim 'onair_' from the value and capitalize the first letter
				echo ucfirst( ltrim( $value, 'onair_' ) ) . ' ';
			}

			
			$starttime = get_post_meta( $post_id, 'onair_starttime', true );
			$endtime = get_post_meta( $post_id, 'onair_endtime', true );

			?>
			<br />
			<span>
				<?php if ( ! empty($starttime)) { echo date("g:i a", strtotime("{$starttime} UTC")); }?> - <?php if ( ! empty($endtime)) { echo date("g:i a", strtotime("{$endtime} UTC")); }?>
			</span>
			<?php
			

			//if (! empty( $onair_sat ) )
			//	echo __( 'Unknown' );

 




			
						break;

		case 'programid' :

			/* Get the post meta. */
			$programid = get_post_meta( $post_id, 'programid_mb', true );

			/* If no duration is found, output a default message. */
			if ( empty( $programid ) )
				echo __( 'Unknown' );

			/* If there is a duration, append 'minutes' to the text string. */
			else
				printf( __( '%s' ), $programid );

			break;

			
			


		/* Just break out of the switch statement for everything else. */
		default :
			break;
	}
}


##################################################
// Change visibility of default settings in WP
##################################################

//remove menu items from dashboard
function remove_menu_items() {
  global $menu;
  $restricted = array(__('Comments'));
  end ($menu);
  while (prev($menu)){
	$value = explode(' ',$menu[key($menu)][0]);
	if(in_array($value[0] != NULL?$value[0]:"" , $restricted)){
	  unset($menu[key($menu)]);}
	}
  }

add_action('admin_menu', 'remove_menu_items');

/*
 * Change excerpt_more function output
 */
function custom_excerpt_more( $more ) {
	return '<p><a class="btn btn-small primary-read-more" href="' .
		get_permalink( get_the_ID() ) .
		'">Read More <i class="icon-chevron-right"></i></a></p>'
	;
}
add_filter( 'excerpt_more', 'custom_excerpt_more' );


/**
 * Add API Endpoint for Homepage Program Listing
 */
add_action( 'rest_api_init', function () {
	register_rest_route( 'kbcsapi/v1', '/now-playing/', array(
		'methods' => 'GET',
		'callback' => 'homepage_programs_rest',
		'permission_callback' => '__return_true',
		
	) );

	// Also accept a random 4 digit time to prevent caching. Time itself doesn't matter.
	register_rest_route( 'kbcsapi/v1', '/now-playing/(?P<timestamp>\d\d\d\d)', array(
		'methods' => 'GET',
		'callback' => 'homepage_programs_rest',
		'permission_callback' => '__return_true',
	) );
} );
function homepage_programs_rest() {
	$prog     = new Homepage_Program();
	$current  = $prog->get_current_program();
	$prev     = $prog->get_last_program( $current );
	$next     = $prog->get_next_program( $current );
	$airtimes = Homepage_Program::get_airtimes_for_display( $current['id'] );
	$host     = get_field( 'program_to_host_connection', $current['id'] );

	if ( is_array( $host ) ) {
		$hosts = array_map( function ( $host ) {
			return array(
				'name' => $host->post_title,
				'link' => get_permalink( $host->ID ),
			);
		}, $host );
	} else {
		$hosts = array();
	}
	

	return array(
		'current' => array(
			'title' => get_the_title( $current['id'] ),
			'hosts' => $hosts,
			'airtimes' => $airtimes,
			'start' => Homepage_Program::timestamp_to_utc( $current['start_time'] ),
			'end' => Homepage_Program::timestamp_to_utc( $current['end_time'] ),
			'permalink' => get_permalink( $current['id'] ),
			'image_url' => get_the_post_thumbnail_url( $current['id'], 'programs-hero' ),
			'image_alt' => get_post_meta( get_post_thumbnail_id( $current['id'] ), '_wp_attachment_image_alt', true ),
		),
		'previous' => array(
			'title' => get_the_title( $prev['id'] ),
			'airtimes' => date( "ga", $prev['start_time'] ) . '-' . date( "ga", $prev['end_time'] ),
			'permalink' => get_permalink( $prev['id'] ),
		),
		'next' => array(
			'title' => get_the_title( $next['id'] ),
			'airtimes' => date( "ga", $next['start_time'] ) . '-' . date( "ga", $next['end_time'] ),
			'permalink' => get_permalink( $next['id'] ),
		),
	);
}

/**
 * Enqueue homepage-hero.js on the homepage only
 */
function homepage_hero_scripts() {
	if ( is_front_page() ) {
		wp_enqueue_script( 'homepage-hero', get_stylesheet_directory_uri() . '/js/homepage-hero.js', array( 'jquery' ), wp_get_theme()->get( 'Version' ), true );
	}
}
add_action( 'wp_enqueue_scripts', 'homepage_hero_scripts' );


/**
 * Migrate Airdays Options to ACF when Program Loaded
 * 
 * This should be disabled after migration is complete, since it adds extra overhead
 */
function migrate_airdays( $post ) {
	if ( 'programs' === $post->post_type ) {
		$meta = get_post_meta( $post->ID );
		foreach ( $meta as $key => $value ) {
			if ( preg_match( '/^onair_.*day/', $key ) ) {
				$current_airdays = get_field( 'air_days', $post->ID ) ?? array();
				if ( ! in_array( $key, $current_airdays ) ) {
					$current_airdays[] = $key;
					update_field( 'air_days', $current_airdays, $post->ID );
				}
				delete_post_meta( $post->ID, $key );
			}

		}
		

	}
}

add_action( 'the_post', 'migrate_airdays' );