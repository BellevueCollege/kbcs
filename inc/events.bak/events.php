<?php
/* ------------------- THEME FORCE ---------------------- */



/*
 * EVENTS FUNCTION (CUSTOM POST TYPE)
 */

// 1. Custom Post Type Registration ( Events )

function create_event_postype() {

	$labels = array(
	    'name' => _x('Events', 'post type general name', 'themeforce'),
	    'singular_name' => _x('Event', 'post type singular name', 'themeforce'),
	    'add_new' => _x('Add New', 'events', 'themeforce'),
	    'add_new_item' => __('Add New Event', 'themeforce'),
	    'edit_item' => __('Edit Event', 'themeforce'),
	    'new_item' => __('New Event', 'themeforce'),
	    'view_item' => __('View Event', 'themeforce'),
	    'search_items' => __('Search Events', 'themeforce'),
	    'not_found' =>  __('No events found', 'themeforce'),
	    'not_found_in_trash' => __('No events found in Trash', 'themeforce'),
	    'parent_item_colon' => '',
	);
	
	$args = array(
	    'label' 		=> __( 'Events' ),
	    'labels' 		=> $labels,
	    'public' 		=> true,
	    'can_export' 	=> true,
	    'show_ui' 		=> true,
	    '_builtin' 		=> false,
	    'capability_type' => 'post',
	    'menu_icon' 	=> get_bloginfo( 'template_url' ).'/framework/assets/images/event_16.png',
	    'hierarchical' 	=> false,
	    'rewrite' 		=> array( 'slug' => 'events' ),
	    'supports'		=> array( 'title', 'thumbnail', 'excerpt', 'editor', 'quick_add' ) ,
	    'show_in_nav_menus' => true,
	    'taxonomies' 	=> array( 'eventcategory')
	);
	
	register_post_type( 'events', $args);

}

add_action( 'init', 'create_event_postype' );

// 2. Custom Taxonomy Registration (Event Types)

function create_eventcategory_taxonomy() {

    $labels = array(
        'name' => __( 'Categories', 'themeforce'),
        'singular_name' => __( 'Category', 'themeforce'),
        'search_items' =>  __( 'Search Categories', 'themeforce' ),
        'popular_items' => __( 'Popular Categories', 'themeforce' ),
        'all_items' => __( 'All Categories', 'themeforce' ),
        'parent_item' => null,
        'parent_item_colon' => null,
        'edit_item' => __( 'Edit Category', 'themeforce' ),
        'update_item' => __( 'Update Category', 'themeforce' ),
        'add_new_item' => __( 'Add New Category', 'themeforce' ),
        'new_item_name' => __( 'New Category Name', 'themeforce' ),
        'separate_items_with_commas' => __( 'Separate categories with commas', 'themeforce' ),
        'add_or_remove_items' => __( 'Add or remove categories', 'themeforce' ),
        'choose_from_most_used' => __( 'Choose from the most used categories', 'themeforce' ),
    );

    register_taxonomy('eventcategory', 'events', array(
        'label' => __('Event Category', 'themeforce'),
        'labels' => $labels,
        'hierarchical' => true,
        'show_ui' => true,
        'query_var' => true,
        'rewrite' => array( 'slug' => 'event-category', 'themeforce' ),
    ));

}

add_action( 'init', 'create_eventcategory_taxonomy', 0 );

// 3. Show Columns

add_filter ("manage_edit-events_columns", "events_edit_columns");
add_action ("manage_posts_custom_column", "events_custom_columns");

function events_edit_columns( $columns ) {

    $columns = array(
        "cb" => "<input type=\"checkbox\" />",
        "col_ev_thumb" => '',
        "col_ev_date" => __( 'When', 'themeforce' ),
        "title" => __( 'Name', 'themeforce' ),
        "col_ev_cat" => __( 'Category', 'themeforce' ),
        "col_ev_desc" => __( 'Description', 'themeforce' )
        );

    return $columns;

}

function events_custom_columns( $column ) {

    global $post;
    $custom = get_post_custom();
    switch ( $column )

        {
            case "col_ev_cat":
                // - show taxonomy terms -
                $eventcats = get_the_terms($post->ID, "eventcategory");
                $eventcats_html = array();
                if ( $eventcats ) {
                    foreach ($eventcats as $eventcat) {
                        $event = $eventcat->name;
                        echo '<span class="cat-default cat-' . strtolower($event) . '">' . $event . '</span>';
                        }
                } else {
                echo '';
                }
            break;
            case "col_ev_date":
                
                // - show dates -
                
                $startd = $custom["events_startdate"][0];
                $endd = $custom["events_enddate"][0];
                $day = date("j", $startd);
                $month = date("M", $endd);
                $year = date("y", $endd);
                $weekday = date("l", $endd);
                
                // - show times -
                
                $startt = $custom["events_startdate"][0];
                $endt = $custom["events_enddate"][0];
                $time_format = get_option( 'time_format' );
                $starttime = date($time_format, $startt);
                $endtime = date($time_format, $endt);
                
                echo '<div class="ev_block"><div class="ev_day">' . $day . '</div></div><div class="ev_block"><div class="ev_monthyear"><strong>' . $month . '</strong> ' . $year . '</div><div class="ev_weekday events-detail">'. $weekday . '</div><div class="events-detail">' . $starttime . ' to ' . $endtime . '</div></div>';
                
            break;
            case "col_ev_thumb":
                // - show thumb -
                echo '<div class="table-thumb">';
		            the_post_thumbnail( 'width=60&height=60&crop=1' );
                echo '</div>';
            break;
            case "col_ev_desc";
                the_excerpt();
		       	events_inline_data( $post->ID );
            break;

        }
}

// 4. Show Meta-Box

add_action( 'admin_init', 'events_create' );

function events_create() {
    add_meta_box('events_meta', __( 'Events', 'themeforce' ), 'events_meta', 'events');
}

function events_meta () {

    // - grab data -

    global $post;
    $custom = get_post_custom( $post->ID );
    $meta_sd = $custom["events_startdate"][0];
    $meta_ed = $custom["events_enddate"][0];
    $meta_st = $meta_sd;
    $meta_et = $meta_ed;

    // - grab wp time format -

    $date_format = get_option( 'date_format' ); // Not required in my code
    $time_format = get_option( 'time_format' );

    // - populate today if empty, 00:00 for time -

    if ($meta_sd == null) { $meta_sd = time(); $meta_ed = $meta_sd; $meta_st = 0; $meta_et = 0;}

    // - convert to pretty formats -

    $clean_sd = date("D, M d, Y", $meta_sd);
    $clean_ed = date("D, M d, Y", $meta_ed);
    $clean_st = date("H:i", $meta_st);
    $clean_et = date("H:i", $meta_et);

    // - security -

    echo '<input type="hidden" name="events-events-nonce" id="events-events-nonce" value="' .
    wp_create_nonce( 'events-events-nonce' ) . '" />';

    // - output -

    ?>
    <div class="events-meta">
        <ul>
            <li><label><?php _e('Start Date', 'themeforce'); ?></label><input name="events_startdate" class="tfdate" value="<?php echo $clean_sd; ?>" /></li>
            <li><label><?php _e('Start Time', 'themeforce'); ?></label><input name="events_starttime" value="<?php echo $clean_st; ?>" /><em><?php _e('Use 24h format (7pm = 19:00)', 'themeforce'); ?></em></li>
            <li><label><?php _e('End Date', 'themeforce'); ?></label><input name="events_enddate" class="tfdate" value="<?php echo $clean_ed; ?>" /></li>
            <li><label><?php _e('End Time', 'themeforce'); ?></label><input name="events_endtime" value="<?php echo $clean_et; ?>" /><em><?php _e('Use 24h format (7pm = 19:00)', 'themeforce'); ?></em></li>
        </ul>
    </div>
    <?php
}

// 5. Save Data

add_action ('save_post', 'save_events');

function save_events(){

    global $post;

    // - check nonce & permissions

    if ( !wp_verify_nonce( $_POST['events-events-nonce'], 'events-events-nonce' )) {
        return $post->ID;
    }

    if ( !current_user_can( 'edit_post', $post->ID ))
        return $post->ID;

    // - convert back to unix & update post

    if ( !isset($_POST["events_startdate"]) ):
        return $post;
        endif;
        $updatestartd = strtotime ( $_POST["events_startdate"] . $_POST["events_starttime"] );
        update_post_meta($post->ID, "events_startdate", $updatestartd );

    if ( !isset($_POST["events_enddate"]) ):
        return $post;
        endif;
        $updateendd = strtotime ( $_POST["events_enddate"] . $_POST["events_endtime"]);
        update_post_meta($post->ID, "events_enddate", $updateendd );

}

// 6. Customize Update Messages

add_filter('post_updated_messages', 'events_updated_messages');

function events_updated_messages( $messages ) {

  global $post, $post_ID;

  $messages['events'] = array(
    0 => '', // Unused. Messages start at index 1.
    1 => sprintf( __('Event updated. <a href="%s">View item</a>', 'themeforce'), esc_url( get_permalink( $post_ID ) ) ),
    2 => __('Custom field updated.', 'themeforce'),
    3 => __('Custom field deleted.', 'themeforce'),
    4 => __('Event updated.', 'themeforce'),
    /* translators: %s: date and time of the revision */
    5 => isset( $_GET['revision'] ) ? sprintf( __('Event restored to revision from %s', 'themeforce'), wp_post_revision_title( ( int ) $_GET['revision'], false ) ) : false,
    6 => sprintf( __('Event published. <a href="%s">View event</a>', 'themeforce'), esc_url( get_permalink( $post_ID ) ) ),
    7 => __('Event saved.'),
    8 => sprintf( __('Event submitted. <a target="_blank" href="%s">Preview event</a>', 'themeforce'), esc_url( add_query_arg( 'preview', 'true', get_permalink( $post_ID ) ) ) ),
    9 => sprintf( __('Event scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview event</a>', 'themeforce'),
      // translators: Publish box date format, see http://php.net/date
      date_i18n( __( 'M j, Y @ G:i', 'themeforce' ), strtotime( $post->post_date ) ), esc_url( get_permalink( $post_ID ) ) ),
    10 => sprintf( __('Event draft updated. <a target="_blank" href="%s">Preview event</a>', 'themeforce'), esc_url( add_query_arg( 'preview', 'true', get_permalink( $post_ID ) ) ) ),
  );

  return $messages;
}

// 7. JS Datepicker UI

function events_styles() {
    global $post_type;
    if ( 'events' != $post_type )
        return;
    wp_enqueue_style('ui-datepicker', get_bloginfo('template_url') . '/inc/events/css/jquery-ui-1.8.9.custom.css', array(), VERSION );
}

function events_scripts() {
    global $post_type;
//    if ( 'events' != $post_type )
//    return;
    // wp_deregister_script( 'jquery-ui-core' ); TODO removed deregister, seems to have no conflicting issues.
    wp_enqueue_script('jquery-ui', get_bloginfo('template_url') . '/inc/events/js/jquery-ui-1.8.9.custom.min.js', array( 'jquery'), VERSION );
    wp_enqueue_script('ui-datepicker', get_bloginfo('template_url') . '/inc/events/js/jquery.ui.datepicker.js', array(), VERSION );
    wp_enqueue_script('ui-datepicker-settings', get_bloginfo('template_url') . '/inc/events/js/themeforce-admin.js', array( 'jquery'), VERSION  );
}

if ( in_array( $GLOBALS['pagenow'], array( 'edit.php') ) ) {
    add_action( 'admin_print_styles', 'events_styles', 1000 );
    add_action( 'admin_print_scripts', 'events_scripts', 1000 );
}

// 8. Create New Terms

add_action( 'init', 'create_events_tax', 10 );

function create_events_tax() {

    if ( get_option('added_default_events_terms' ) != 'updated') {
        // Create the terms
        if (term_exists('Featured', 'eventcategory') == false ) {
            wp_insert_term(
              __('Featured', 'themeforce'),
              'eventcategory'
              );
         }
        if (term_exists('Football', 'eventcategory') == false ) {
            wp_insert_term(
              __('Football', 'themeforce'),
              'eventcategory'
              );
         }
         if (term_exists('Quiz Night', 'eventcategory') == false ) {
            wp_insert_term(
              __('Quiz Night', 'themeforce'),
              'eventcategory'
              );
         }
         // Register update so that it's not repeated
         update_option( 'added_default_events_terms', 'updated' );
    }
}

/**
 * Events have custom permalinks including their category.
 * 
 * @param string $permalink
 * @param object $post
 * @return string
 */
function event_permalink( $permalink, $post, $leavename ) {
	
	if ( $post->post_type !== 'events' || strpos( $permalink, '?' ) )
		return $permalink;
	
	$terms = wp_get_object_terms( $post->ID, 'eventcategory' );
	$term_slug = null;
	
	foreach( $terms as $t ) {
		if ( $t->slug != 'featured' ) {
			$term_slug = $t->slug;
			break;
		}
	}
	
	if ( $term_slug === null )		
		$term_slug = 'uncategorized';
	
	return trailingslashit( get_bloginfo( 'url' ) ) . 'events/' . $term_slug . '/'. ( $leavename ? '%postname%' : $post->post_name  ) . '/';
}
add_filter( 'post_type_link', 'event_permalink', 10, 3 );

class TFDateSelector {

	private $date;
	private $id;
	
	public function __construct( $id ) {
		$this->id = $id;
	}
	
	public function setDate( $date ) {
		
		if( $date )
			$this->date = (int) $date;
		else
			$this->date = time();
	}
	
	public function getDateFromPostData() { return $this->getDateFromData( $_POST ); }
	
	public function getDateFromPostDataDatePicker() { return $this->getDateFromDataDatePicker( $_POST ); }
	
	public function getDateFromDataDatePicker( $data ) {
	
		$date_from_post['day'] = $data[$this->id . '-day'];
		
		if ( $data[$this->id . '-ampm'] == 'am'  ){
			if( $data[$this->id . '-hour'] == '12' )
				$date_from_post['hour'] = '00';
			else
				$date_from_post['hour'] =  $data[$this->id . '-hour'];
		}else{
			if ( $data[$this->id . '-hour'] == '12' )
				$date_from_post['hour'] = $data[$this->id . '-hour'];
			else	
				$date_from_post['hour'] = (string) ( (int) $data[$this->id . '-hour'] + 12);
		}
		
		$date_from_post['minute'] =  $data[$this->id . '-minute'];
		
		$date_from_post['day'] = str_replace( '- ', '', $date_from_post['day'] );		
		$date = strtotime( $date_from_post['day'] .' '. $date_from_post['hour'] .':'. $date_from_post['minute'] . ':00'  );
			
		return $date;
	}
	
	public function getDateFromData( $data ) {
		
		$y = $data[ $this->id . '_aa' ];
		$m = $data[ $this->id . '_mm' ];
		$d = $data[ $this->id . '_jj' ];
		$h = $data[ $this->id . '_hh' ];
		$mn = $data[ $this->id . '_mn' ];
		$ss = $data[ $this->id . '_ss' ];
		
		$date = strtotime( "$y-$m-$d $h:$mn:$ss" );
		
		return $date;
	}
	
	public function getHTML() {
		
		global $post;
		$_post = $post;
		$post = (object) array( 'post_date_gmt' => date( 'Y-m-d H:i:s', $this->date ), 'post_date' =>  date( 'Y-m-d H:i:s', $this->date ), 'post_status' => 'publish' );
		
		ob_start();
		touch_time( 1, 1, 0, 1 );
		$data = ob_get_contents();
		ob_end_clean();
		
		$data = preg_replace( '/name="([^"]+)"/', 'name="' . $this->id . '_$1"', $data );
		
		$post = $_post;

		return $data;
	}
	
	public function getDatePickerHTML() {
		$minute_options = array( '00', '15', '30','45' );

		ob_start();  ?>
				
                <input type="text" name="<?php echo $this->id . '-day'; ?>" class="ev_inputdate" id="<?php echo $this->id . '-day'; ?>" value="<?php echo date( 'D - j M - y', $this->date ) ?>"/>
                <div class="ev_inputspacer"> @ </div>
                
                <select name="<?php echo $this->id . '-hour'; ?>"  class="ev_inputtime" id="<?php echo $this->id . '-hour'; ?>">
                		<?php for( $hour = 1; $hour < 13; $hour++ ): ?>
                			<option value="<?php echo $hour?>" <?php if ( date( 'g', $this->date ) == $hour ) echo 'selected="selected"' ?>><?php echo $hour?></option>
                		<?php endfor; ?>
                </select>
     
                <div class="ev_inputspacer"> : </div>
                
                <select name="<?php echo $this->id . '-minute'; ?>"  class="ev_inputtime" id="<?php echo $this->id . '-minute'; ?>">
                		<?php foreach( $minute_options as $value ): ?>
                			<option value="<?php echo $value?>" <?php if ( date( 'i', $this->date ) == $value ) echo 'selected="selected"' ?>><?php echo $value?></option>
                		<?php endforeach; ?>
                </select>
                
                <select name="<?php echo $this->id . '-ampm'; ?>" class="ev_inputtime" id="<?php echo $this->id . '-ampm'; ?>">
                	<option value="am" <?php if ( (int) date( 'H', $this->date ) < 13) echo 'selected="selected"'; ?>>am</option>
                	<option value="pm" <?php if ( (int) date( 'H', $this->date ) > 11) echo 'selected="selected"'; ?>>pm</option>
                </select>
                                   				
	     	<?php $data=ob_get_contents();
		
		ob_end_clean(); ?>
			
		<?php return $data;

	}
	
}

add_action( 'parse_query', 'set_events_order' );
function set_events_order( $obj){
	if ( ($obj->query_vars['post_type'] != 'events') || ( $obj->query_vars['orderby'] ) )
		return;
		
	$obj->query_vars['order'] = 'desc';
	$obj->query_vars['orderby'] = 'meta_value_num';
	$obj->query_vars['meta_key'] ='events_enddate';
	return $obj;

}

add_action( 'admin_footer', function( ) {

    $wp_list_table = _get_list_table('WP_Posts_List_Table');

    if ( ! $wp_list_table->has_items() )
        $wp_list_table->inline_edit();

} );