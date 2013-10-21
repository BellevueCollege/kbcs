<?php 

//date_default_timezone_set('America/Los_Angeles');

function status_title_filter( $cleanPost )
{
    if( $cleanPost['post_type'] == 'epsiodes' && $cleanPost['post_status'] != 'auto-draft' && $_GET['action'] != 'trash' && $_GET['action'] != 'untrash' )
        $cleanPost['post_title'] = $cleanPost['post_name'] = $cleanPost['post_date'];

    return $cleanPost;
}

add_filter( 'wp_insert_post_data', 'status_title_filter' );

###############################
// Include WP Alchemy Metabox Class
##############################
include_once 'metaboxes/setup.php';
include_once 'metaboxes/simple-spec.php';

###############################
// Includes
##############################

if( file_exists(get_template_directory() . '/inc/funddrive/funddrive.php') )
    require( get_template_directory() . '/inc/funddrive/funddrive.php');

if( file_exists(get_template_directory() . '/inc/metaboxes/meta_box.php') )
    require( get_template_directory() . '/inc/metaboxes/meta_box.php');

if( file_exists(get_template_directory() . '/inc/staff/staff.php') )
    require( get_template_directory() . '/inc/staff/staff.php');
	
if( file_exists(get_template_directory() . '/inc/currentprograms.php') )
    require( get_template_directory() . '/inc/currentprograms.php');

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

###############################################
// Change how WP handles the_excerpt
###############################################

function custom_wp_trim_excerpt($text) {
$raw_excerpt = $text;
if ( '' == $text ) {
    //Retrieve the post content. 
    $text = get_the_content('');
 
    //Delete all shortcode tags from the content. 
    $text = strip_shortcodes( $text );
 
    $text = apply_filters('the_content', $text);
    $text = str_replace(']]>', ']]&gt;', $text);
     
    $allowed_tags = '<p>,<a>,<em>,<strong>,<img>,<ol><ul><li>'; /*** MODIFY THIS. Add the allowed HTML tags separated by a comma.***/
    $text = strip_tags($text, $allowed_tags);
     
    $excerpt_word_count = 55; /*** MODIFY THIS. change the excerpt word count to any integer you like.***/
    $excerpt_length = apply_filters('excerpt_length', $excerpt_word_count); 
     
    $excerpt_end = '[...]'; /*** MODIFY THIS. change the excerpt endind to something else.***/
    $excerpt_more = apply_filters('excerpt_more', ' ' . $excerpt_end);
     
    $words = preg_split("/[\n\r\t ]+/", $text, $excerpt_length + 1, PREG_SPLIT_NO_EMPTY);
    if ( count($words) > $excerpt_length ) {
        array_pop($words);
        $text = implode(' ', $words);
        $text = $text . $excerpt_more;
    } else {
        $text = implode(' ', $words);
    }
}
return apply_filters('wp_trim_excerpt', $text, $raw_excerpt);
}
remove_filter('get_the_excerpt', 'wp_trim_excerpt');
add_filter('get_the_excerpt', 'custom_wp_trim_excerpt');


##############################
// Enqueue Scripts & Styles
##############################

	//Backend
	function load_admin_scripts() {
	    $funddrive_css_path = get_template_directory_uri() . '/inc/funddrive/css/funddrive.css';
	    $bootstrap_js_path = get_template_directory_uri() . '/js/bootstrap.min.js';
			
				
		    wp_register_style( 'admin', get_template_directory_uri() . '/admin.css', false, '1.0.0' );
	   		wp_register_style( 'jquery-ui', get_template_directory_uri() . '/css/jquery-ui.css', true);
	        wp_register_style( 'funddrive', $funddrive_css_path, 'false');

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

	        wp_register_style( 'funddrive', $funddrive_css_path );
	       // wp_register_style( 'jquery-style', get_template_directory_uri() . '/css/jquery-ui.css', true);

        	wp_enqueue_style( 'funddrive' );
	        //wp_enqueue_style( 'jquery-style' );

	        wp_register_script( 'bootstrap', $bootstrap_js_path, array(), false, true);
	        wp_enqueue_script('bootstrap'); 

	       // wp_enqueue_script('jquery-ui-datepicker');   
			wp_enqueue_script('moment', get_template_directory_uri() . '/js/moment.min.js', array('jquery') ); 
	        wp_enqueue_script('jplayer', get_template_directory_uri() . '/js/jquery.jplayer.min.js');
			wp_enqueue_script('jplaylist', get_template_directory_uri() . '/js/jplayer.playlist.min.js');      
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
register_taxonomy( 'program_type', array('programs', 'segments'), array( 'hierarchical' => true, 'label' => 'Program Type', 'query_var' => true, 'rewrite' => true ) );
register_taxonomy( 'staff_type', 'staff', array( 'hierarchical' => true, 'label' => 'Staff Type', 'query_var' => true, 'rewrite' => true ) );

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
	//Audio
	    add_action('init', 'kbcs_audio_cpt_register');  
      
	    function kbcs_audio_cpt_register() {  
			$labels = array(
				'name' => _x('Audio', 'post type general name'),
				'singular_name' => _x('Audio', 'post type singular name'),
				'add_new' => _x('Add New', 'Audio'),
				'add_new_item' => __('Add New Audio'),
				'edit_item' => __('Edit Audio'),
				'new_item' => __('New Audio'),
				'all_items' => __('Audio List'),
				'view_item' => __('View Audio'),
				'search_items' => __('Search Audio'),
				'not_found' =>  __('No Audio posts found'),
				'not_found_in_trash' => __('No Audio posts found in Trash'), 
				'parent_item_colon' => '',
				'menu_name' => __('Audio')		
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
	      
	        register_post_type( 'audio' , $args );  
	    } 
	    
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
				'taxonomies' => array(/*'category', 'post_tag',*/) // this is IMPORTANT
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
				'taxonomies' => array(/*'category', 'post_tag',*/) // this is IMPORTANT
	           );  
	      
	        register_post_type( 'programs' , $args );  
	    }  



	// Events

			add_action('init', 'event_register');
			
			function event_register() {
			
				$labels = array(
					'name' => _x('Events', 'post type general name'),
					'singular_name' => _x('Event', 'post type singular name'),
					'add_new' => _x('Add New', 'event'),
					'add_new_item' => __('Add New Event'),
					'edit_item' => __('Edit Event'),
					'new_item' => __('New Event'),
					'view_item' => __('View Event'),
					'search_items' => __('Search Events'),
					'not_found' =>  __('Nothing found'),
					'not_found_in_trash' => __('Nothing found in Trash'),
					'parent_item_colon' => ''
				);
			
				$args = array(
					'labels' => $labels,
					'public' => true,
					'publicly_queryable' => true,
					'show_ui' => true,
					'query_var' => true,
					'rewrite' => true,
					'capability_type' => 'post',
					'hierarchical' => false,
					'menu_position' => null,
					'supports' => array('title','editor','thumbnail')
				  );
			
				register_post_type( 'events' , $args );
			}

#######################################
//Add custom functionality to Events CPT
#######################################	

	//Custom columns to Events CPT
		add_action("manage_posts_custom_column",  "events_custom_columns");
		add_filter("manage_events_posts_columns", "events_edit_columns");
		
		function events_edit_columns($columns){
		    $columns = array(
		        "cb" => "<input type=\"checkbox\" />",
		        "title" => "Event",
		        "event_date" => "Event Date",
		        "event_location" => "Location",
		        "event_city" => "City",
		  );
		  return $columns;
		}
		
		function events_custom_columns($column){
		    global $post;
		    $custom = get_post_custom();
		
		    switch ($column) {
		    case "event_date":
		            echo format_date($custom["event_date"][0]) . '<br /><em>' .
		            $custom["event_start_time"][0] . ' - ' .
		            $custom["event_end_time"][0] . '</em>';
		            break;

		    case "event_location":
		            echo $custom["event_location"][0];
		            break;
		
			case "event_city":
		            echo $custom["event_city"][0];
		            break;
		    }
		}

	// Sortable custom columns
		
			add_filter("manage_edit-events_sortable_columns", "event_date_column_register_sortable");
			add_filter("request", "event_date_column_orderby" );
			
			function event_date_column_register_sortable( $columns ) {
			        $columns['event_date'] = 'event_date';
			        return $columns;
			}
			
			function event_date_column_orderby( $vars ) {
			    if ( isset( $vars['orderby'] ) && 'event_date' == $vars['orderby'] ) {
			        $vars = array_merge( $vars, array(
			            'meta_key' => 'event_date',
			            'orderby' => 'meta_value_num'
			        ) );
			    }
			    return $vars;
			}

	// Custom metaboxes for Events CPT

			add_action("admin_init", "events_admin_init");
			
			function events_admin_init(){
			  add_meta_box("event_meta", "Event Details", "event_details_meta", "events", "normal", "default");
			}
			
			function event_details_meta() {
			
				$ret = '<p><label>Start Date: </label><input type="text" name="event_date" class="datepicker" value="' . format_date(get_event_field("event_date")) . '" /><em>(yyyy-mm-dd)</em>';
				$ret = $ret . '</p><p><label>Start Time: </label><input type="text" name="event_start_time" value="' . get_event_field("event_start_time") . '" /><em>(hh:mm pm)</em></p>';
				$ret = $ret . '<p><label>End Time: </label><input type="text" name="event_end_time" value="' . get_event_field("event_end_time") . '" />	<em>(hh:mm pm)</em> </p>';
				$ret = $ret . '<p><label>Location: </label><input type="text" size="70" name="event_location" value="' . get_event_field("event_location") . '" /></p>';
				$ret = $ret . '<p><label>Street: </label><input type="text" size="50" name="event_street" value="' . get_event_field("event_street") . '" /></p>';
				$ret = $ret . '<p><label>City: </label><input type="text" size="50" name="event_city" value="' . get_event_field("event_city") . '" /></p>';
				$ret = $ret . '<p><label>Location URL: </label><input type="text" size="70" name="event_location_url" value="' . get_event_field("event_location_url") . '" /></p>';
				$ret = $ret . '<p><label>Register URL: </label><input type="text" size="70" name="event_register_url" value="' . get_event_field("event_register_url") . '" /></p>';
			
				echo $ret;
			}



			function get_event_field($event_field) {
			    global $post;
			
			    $custom = get_post_custom($post->ID);
			
			    if (isset($custom[$event_field])) {
			        return $custom[$event_field][0];
			    }
			}

	//Save custom meta data for Events CPT
	
			add_action('save_post', 'save_event_details');
			
			function save_event_details(){
			   global $post;
			
			   if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
			      return;
			
			   if ( get_post_type($post) == 'event')
			      return;
			
			   if(isset($_POST["event_date"])) {
			      update_post_meta($post->ID, "event_date", strtotime($_POST["event_date"] . $_POST["event_start_time"]));
			   }
			
			   save_event_field("event_start_time");
			   save_event_field("event_end_time");
			   save_event_field("event_location");
			   save_event_field("event_street");
			   save_event_field("event_city");
			   save_event_field("event_location_url");
			   save_event_field("event_register_url");
			}	

	// Helper function to make fields save easier
	function save_event_field($event_field) {
	    global $post;
	
	    if(isset($_POST[$event_field])) {
	        update_post_meta($post->ID, $event_field, $_POST[$event_field]);
	    }
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



/////////////////////////
// Custom Meta Boxes
/////////////////////////

// Add the Meta Box
function add_onair_custom_meta_box() {
    add_meta_box(
		'onair_custom_meta_box', // $id
		'Program Air Day/Time', // $title
		'show_custom_onair_meta_box', // $callback
		'programs', // $page
		'normal', // $context
		'default'); // $priority
}
add_action('add_meta_boxes', 'add_onair_custom_meta_box');
  


// Field Array
$prefix = 'onair_';
$onair_custom_meta_fields = array(

	array( // Single checkbox
		'label'	=> 'Monday', // <label>
		'desc'	=> '', // description
		'id'	=> $prefix.'monday', // field id and name
		'type'	=> 'checkbox' // type of field
	),
	array( // Single checkbox
		'label'	=> 'Tuesday', // <label>
		'desc'	=> '', // description
		'id'	=> $prefix.'tuesday', // field id and name
		'type'	=> 'checkbox' // type of field
	),
	array( // Single checkbox
		'label'	=> 'Wednesday', // <label>
		'desc'	=> '', // description
		'id'	=> $prefix.'wednesday', // field id and name
		'type'	=> 'checkbox' // type of field
	),
	array( // Single checkbox
		'label'	=> 'Thursday', // <label>
		'desc'	=> '', // description
		'id'	=> $prefix.'thursday', // field id and name
		'type'	=> 'checkbox' // type of field
	),
	array( // Single checkbox
		'label'	=> 'Friday', // <label>
		'desc'	=> '', // description
		'id'	=> $prefix.'friday', // field id and name
		'type'	=> 'checkbox' // type of field
	),
	array( // Single checkbox
		'label'	=> 'Saturday', // <label>
		'desc'	=> '', // description
		'id'	=> $prefix.'saturday', // field id and name
		'type'	=> 'checkbox' // type of field
	),
	array( // Single checkbox
		'label'	=> 'Sunday', // <label>
		'desc'	=> '', // description
		'id'	=> $prefix.'sunday', // field id and name
		'type'	=> 'checkbox' // type of field
	),

	array( // Select box
		'label'	=> 'Start Time', // <label>
		'desc'	=> '', // description
		'id'	=> $prefix.'starttime', // field id and name
		'type'	=> 'select', // type of field
		'options' => array ( // array of options
			'00:00' => array ( // array key needs to be the same as the option value
			'label' => '12:00am', // text displayed as the option
			'value'	=> '00:00' // value stored for the option
	),
			'01:00' => array (
			'label' => '1:00am',
			'value'	=> '01:00'
			),
			'02:00' => array (
			'label' => '2:00am',
			'value'	=> '02:00'
			),
			'03:00' => array (
			'label' => '3:00am',
			'value'	=> '03:00'
			),
			'04:00' => array (
			'label' => '4:00am',
			'value'	=> '04:00'
			),
			'05:00' => array (
			'label' => '5:00am',
			'value'	=> '05:00'
			),
			'06:00' => array (
			'label' => '6:00am',
			'value'	=> '06:00'
			),
			'07:00' => array (
			'label' => '7:00am',
			'value'	=> '07:00'
			),
			'08:00' => array (
			'label' => '8:00am',
			'value'	=> '08:00'
			),
			'09:00' => array (
			'label' => '9:00am',
			'value'	=> '09:00'
			),
			'10:00' => array (
			'label' => '10:00am',
			'value'	=> '10:00'
			),
			'11:00' => array (
			'label' => '11:00am',
			'value'	=> '11:00'
			),
			'12:00' => array (
			'label' => '12:00pm',
			'value'	=> '12:00'
			),
			'13:00' => array (
			'label' => '1:00pm',
			'value'	=> '13:00'
			),
			'14:00' => array (
			'label' => '2:00pm',
			'value'	=> '14:00'
			),
			'15:00' => array (
			'label' => '3:00pm',
			'value'	=> '15:00'
			),
			'16:00' => array (
			'label' => '4:00pm',
			'value'	=> '16:00'
			),
			'17:00' => array (
			'label' => '5:00pm',
			'value'	=> '17:00'
			),
			'18:00' => array (
			'label' => '6:00pm',
			'value'	=> '18:00'
			),
			'19:00' => array (
			'label' => '7:00pm',
			'value'	=> '19:00'
			),
			'20:00' => array (
			'label' => '8:00pm',
			'value'	=> '20:00'
			),
			'21:00' => array (
			'label' => '9:00pm',
			'value'	=> '21:00'
			),
			'22:00' => array (
			'label' => '10:00pm',
			'value'	=> '22:00'
			),
			'23:00' => array (
			'label' => '11:00pm',
			'value'	=> '23:00'
			),

		)
	),
	array( // Select box
		'label'	=> 'End Time', // <label>
		'desc'	=> '', // description
		'id'	=> $prefix.'endtime', // field id and name
		'type'	=> 'select', // type of field
		'options' => array ( // array of options
			'00:00' => array ( // array key needs to be the same as the option value
			'label' => '12:00am', // text displayed as the option
			'value'	=> '00:00' // value stored for the option
	),
			'01:00' => array (
			'label' => '1:00am',
			'value'	=> '01:00'
			),
			'02:00' => array (
			'label' => '2:00am',
			'value'	=> '02:00'
			),
			'03:00' => array (
			'label' => '3:00am',
			'value'	=> '03:00'
			),
			'04:00' => array (
			'label' => '4:00am',
			'value'	=> '04:00'
			),
			'05:00' => array (
			'label' => '5:00am',
			'value'	=> '05:00'
			),
			'06:00' => array (
			'label' => '6:00am',
			'value'	=> '06:00'
			),
			'07:00' => array (
			'label' => '7:00am',
			'value'	=> '07:00'
			),
			'08:00' => array (
			'label' => '8:00am',
			'value'	=> '08:00'
			),
			'09:00' => array (
			'label' => '9:00am',
			'value'	=> '09:00'
			),
			'10:00' => array (
			'label' => '10:00am',
			'value'	=> '10:00'
			),
			'11:00' => array (
			'label' => '11:00am',
			'value'	=> '11:00'
			),
			'12:00' => array (
			'label' => '12:00pm',
			'value'	=> '12:00'
			),
			'13:00' => array (
			'label' => '1:00pm',
			'value'	=> '13:00'
			),
			'14:00' => array (
			'label' => '2:00pm',
			'value'	=> '14:00'
			),
			'15:00' => array (
			'label' => '3:00pm',
			'value'	=> '15:00'
			),
			'16:00' => array (
			'label' => '4:00pm',
			'value'	=> '16:00'
			),
			'17:00' => array (
			'label' => '5:00pm',
			'value'	=> '17:00'
			),
			'18:00' => array (
			'label' => '6:00pm',
			'value'	=> '18:00'
			),
			'19:00' => array (
			'label' => '7:00pm',
			'value'	=> '19:00'
			),
			'20:00' => array (
			'label' => '8:00pm',
			'value'	=> '20:00'
			),
			'21:00' => array (
			'label' => '9:00pm',
			'value'	=> '21:00'
			),
			'22:00' => array (
			'label' => '10:00pm',
			'value'	=> '22:00'
			),
			'23:00' => array (
			'label' => '11:00pm',
			'value'	=> '23:00'
			),

		)

	),

);




// The Callback
function show_custom_onair_meta_box() {
global $onair_custom_meta_fields, $post;
// Use nonce for verification
echo '<input type="hidden" name="onair_custom_meta_box_nonce" value="'.wp_create_nonce(basename(__FILE__)).'" />'; 
	// Begin the field table and loop
	echo '<table class="form-table">';
	foreach ($onair_custom_meta_fields as $field) {
		// get value of this field if it exists for this post
		$meta = get_post_meta($post->ID, $field['id'], true);
		// begin a table row with
		echo '<tr>
				<th><label for="'.$field['id'].'">'.$field['label'].'</label></th>
				<td>';
				switch($field['type']) {
					// case items will go here

					// text

					case 'checkbox':  
					    echo '<input type="checkbox" name="'.$field['id'].'" id="'.$field['id'].'" ',$meta ? ' checked="checked"' : '','/> 
					        <label for="'.$field['id'].'">'.$field['desc'].'</label>';  
					break;  

				    // select  
				    case 'select':  
				        echo '<select name="'.$field['id'].'" id="'.$field['id'].'">';  
				        foreach ($field['options'] as $option) {  
				            echo '<option', $meta == $option['value'] ? ' selected="selected"' : '', ' value="'.$option['value'].'">'.$option['label'].'</option>';  
				        }  
				        echo '</select><br /><span class="description">'.$field['desc'].'</span>';  
				    break;  
				} //end switch
		echo '</td></tr>';
	} // end foreach
	echo '</table>'; // end table
}
  


// Save the Data
function save_custom_meta($post_id) {
    global $onair_custom_meta_fields;
	// verify nonce

	// verify nonce
	if ( !isset( $_POST['onair_custom_meta_box_nonce'] ) || !wp_verify_nonce( $_POST['onair_custom_meta_box_nonce'], basename( __FILE__ ) ) )
		return $post_id;

	// check autosave
	if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
		return $post_id;
	// check permissions
	if ('page' == $_POST['post_type']) {
		if (!current_user_can('edit_page', $post_id))
			return $post_id;
		} elseif (!current_user_can('edit_post', $post_id)) {
			return $post_id;
	}
	// loop through fields and save the data
	foreach ($onair_custom_meta_fields as $field) {
		$old = get_post_meta($post_id, $field['id'], true);
		$new = $_POST[$field['id']];
		if ($new && $new != $old) {
			update_post_meta($post_id, $field['id'], $new);
		} elseif ('' == $new && $old) {
			delete_post_meta($post_id, $field['id'], $old);
		}
	} // end foreach
}
add_action('save_post', 'save_custom_meta');  

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


		case 'ontheair' :

			//$onair = get_post_meta($post_id, 'onaircheckbox_group', true);
			$onair_mon = get_post_meta($post_id, 'onair_monday', true);
			$onair_tue = get_post_meta($post_id, 'onair_tuesday', true);
			$onair_wed = get_post_meta($post_id, 'onair_wednesday', true);
			$onair_thu = get_post_meta($post_id, 'onair_thursday', true);
			$onair_fri = get_post_meta($post_id, 'onair_friday', true);
			$onair_sat = get_post_meta($post_id, 'onair_saturday', true);
			$onair_sun = get_post_meta($post_id, 'onair_sunday', true);
			
			$starttime = get_post_meta( $post_id, 'onair_starttime', true );
			$endtime = get_post_meta( $post_id, 'onair_endtime', true );

			if ( ! empty($onair_mon)) { echo 'Monday  '; }
			if ( ! empty($onair_tue)) { echo 'Tuesday  '; }
			if ( ! empty($onair_wed)) { echo 'Wednesday  '; }
			if ( ! empty($onair_thu)) { echo 'Thursday  '; }
			if ( ! empty($onair_fri)) { echo 'Friday  '; }
			if ( ! empty($onair_sat)) { echo 'Saturday  '; }
			if ( ! empty($onair_sun)) { echo 'Sunday  '; }
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





###########################################
//Add program ID metabox to Programs CPT
###########################################

 
add_action( 'add_meta_boxes', 'register_programid_metabox' );
function register_programid_metabox()
{
	add_meta_box( 
		'programid_metabox', 
		'Program ID', 
		'programid_callback', 
		'programs', 
		'side', 
		'high' );
}

function programid_callback( $post )
{
	$values = get_post_custom( $post->ID );
	$text = isset( $values['programid_mb'] ) ? esc_attr( $values['programid_mb'][0] ) : '';
//	$selected = isset( $values['programid_meta_box_select'] ) ? esc_attr( $values['programid_meta_box_select'][0] ) : '';
//	$check = isset( $values['programid_meta_box_check'] ) ? esc_attr( $values['programid_meta_box_check'][0] ) : '';
	wp_nonce_field( 'programid_meta_box_nonce', 'meta_box_nonce' );
	?>
	<p>
		<label for="programid_mb">ID</label>
		<input type="text" name="programid_mb" id="programid_mb" value="<?php echo $text; ?>" />
	</p>
	
	<?php	
}


add_action( 'save_post', 'programid_save' );
function programid_save( $post_id )
{
	// Bail if we're doing an auto save
	if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
	
	// if our nonce isn't there, or we can't verify it, bail
	if( !isset( $_POST['meta_box_nonce'] ) || !wp_verify_nonce( $_POST['meta_box_nonce'], 'programid_meta_box_nonce' ) ) return;
	
	// if our current user can't edit this post, bail
	if( !current_user_can( 'edit_post' ) ) return;
	
	// now we can actually save the data
	$allowed = array( 
		'a' => array( // on allow a tags
			'href' => array() // and those anchords can only have href attribute
		)
	);
	
	// Probably a good idea to make sure your data is set
	if( isset( $_POST['programid_mb'] ) )
		update_post_meta( $post_id, 'programid_mb', wp_kses( $_POST['programid_mb'], $allowed ) );
		

}  

###########################################
// Custom Columns for Ads CPT
###########################################

add_filter( 'manage_edit-ads_columns', 'my_edit_ads_columns' ) ;

function my_edit_ads_columns( $columns ) {

	$columns = array(
		'cb' => '<input type="checkbox" />',
		'thumbnail' => __( 'Image' ),
		'title' => __( 'Ad Name' ),
		'ad_enddate' => __( 'Ad End Date' )
	);
	return $columns;
}

//Add content to custom columns 

add_action( 'manage_ads_posts_custom_column', 'my_manage_ads_columns', 10, 2 );

function my_manage_ads_columns( $column, $post_id ) {
	global $post;

	switch( $column ) {

    case 'thumbnail':
			echo get_the_post_thumbnail( $post->ID, 'edit-screen-thumbnail' );
			break;
			    default:

		case 'ad_enddate' :

			/* Get the post meta. */
			$ad_enddate = get_post_meta( $post_id, 'ad_enddate', true );

			/* If no duration is found, output a default message. */
			if ( empty( $ad_enddate ) )
				echo __( 'Unknown' );

			/* If there is a duration, append 'minutes' to the text string. */
			else
				printf( __( '%s' ), $ad_enddate );

			break;

			
			


		/* Just break out of the switch statement for everything else. */
		default :
			break;
	}
}


###########################################
//Add start/end date metabox to Ads CPT
###########################################

// Add the Meta Box
 function register_kbcs_ads_metabox() {
	add_meta_box( 
		'kbcs_ads_enddate_metabox', // $id
		'Ad End Date', // $title 
		'kbcs_ads_enddate_callback', // $callback
		'ads', // $post_type
		'side', // $context
		'high' ); // $priority
}
add_action( 'add_meta_boxes', 'register_kbcs_ads_metabox' );


function kbcs_ads_enddate_callback( $post )
{
	$values = get_post_custom( $post->ID );
	$text = isset( $values['ad_enddate'] ) ? esc_attr( $values['ad_enddate'][0] ) : '';
	wp_nonce_field( 'programid_meta_box_nonce', 'meta_box_nonce' );
	?>
	<p>
		<label for="ad_enddate">End Date:</label>
		<input type="text" class="datepicker" name="ad_enddate" id="ad_enddate" value="<?php echo $text; ?>" />
	</p>
	
	<?php	
}


add_action( 'save_post', 'kbcs_ads_enddate_save' );
function kbcs_ads_enddate_save( $post_id )
{
	// Bail if we're doing an auto save
	if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
	
	// if our nonce isn't there, or we can't verify it, bail
	if( !isset( $_POST['meta_box_nonce'] ) || !wp_verify_nonce( $_POST['meta_box_nonce'], 'programid_meta_box_nonce' ) ) return;
	
	// if our current user can't edit this post, bail
	if( !current_user_can( 'edit_post' ) ) return;
	
	// now we can actually save the data
	$allowed = array( 
		'a' => array( // on allow a tags
			'href' => array() // and those anchords can only have href attribute
		)
	);
	
	// Probably a good idea to make sure your data is set
	if( isset( $_POST['ad_enddate'] ) )
		update_post_meta( $post_id, 'ad_enddate', wp_kses( $_POST['ad_enddate'], $allowed ) );
		

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




      	
?>