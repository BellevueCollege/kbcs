<?php

///////////////////////////////////////
// - Setup Staff Custom Post type - //
///////////////////////////////////////

    add_action('init', 'staff_register');  
      
    function staff_register() {  
		$labels = array(
			'name' => _x('Staff', 'post type general name'),
			'singular_name' => _x('Staff', 'post type singular name'),
			'add_new' => _x('Add New', 'Staff'),
			'add_new_item' => __('Add New Staff'),
			'edit_item' => __('Edit Staff'),
			'new_item' => __('New Staff'),
			'all_items' => __('Staff List'),
			'view_item' => __('View Staff'),
			'search_items' => __('Search Staff'),
			'not_found' =>  __('No Staff found'),
			'not_found_in_trash' => __('No Staff found in Trash'), 
			'parent_item_colon' => '',
			'menu_name' => __('Staff')		
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
			'taxonomies' => array(/*'category', 'post_tag',*/ 'staff_type', ) // this is IMPORTANT
           );  
      
        register_post_type( 'staff' , $args );  
    }  



///////////////////////////////////////
// - Add a sub menu to the staff menu
///////////////////////////////////////

add_action( 'admin_menu', 'register_staff_sort_page' );

function register_staff_sort_page() {
	add_submenu_page(
		'edit.php?post_type=staff',
		'Order Slides',
		'Re-Order',
		'edit_pages', 'staff-order',
		'staff_order_page'
	);
}


//////////////////////////////////////
// - Customize the WP_List_Table Class
//////////////////////////////////////

if(!class_exists('WP_List_Table')){
    require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}

class staff_List_Table extends WP_List_Table {

	/**
	 * Constructor, we override the parent to pass our own arguments
	 * We usually focus on three parameters: singular and plural labels, as well as whether the class supports AJAX.
	 */
	 function __construct() {
		 parent::__construct( array(
		'plural' => 'staff', //plural label, also this well be one of the table css class
		) );
	 }

}

///////////////////////////////////////
// - Create an interface showing each slide with a handle to sort
///////////////////////////////////////

function staff_order_page() {
?>
	<div class="wrap">
		<h2>Sort Slides</h2>
		<p>Simply drag the slide up or down and it will be saved in that order.</p>
	<?php $slides = new WP_Query( array( 'post_type' => 'staff', 'posts_per_page' => -1, 'order' => 'ASC', 'orderby' => 'menu_order' ) ); ?>
	<?php if( $slides->have_posts() ) : ?>

		<table class="wp-list-table widefat fixed posts" id="sortable-table">
			<thead>
				<tr>
					<th class="column-order">Re-Order</th>
					<th class="column-thumbnail">Thumbnail</th>
					<th class="column-title">Title</th>
					<th class="column-title">Details</th>
				</tr>
			</thead>
			<tbody data-post-type="staff">
			<?php while( $slides->have_posts() ) : $slides->the_post(); ?>
				<tr id="post-<?php the_ID(); ?>">
					<td class="column-order"><img src="<?php echo get_stylesheet_directory_uri() . '/img/row-move.png'; ?>" title="" alt="Move Icon" width="16" height="16" class="" /></td>
					<td class="column-thumbnail"><?php the_post_thumbnail( 'featured-full' ); ?></td>
					<td class="column-title"><strong><?php the_title(); ?></strong></td>
					<td class="column-details"><div class="excerpt"><?php the_excerpt(); ?></div></td>
				</tr>
			<?php endwhile; ?>
			</tbody>
			<tfoot>
				<tr>
					<th class="column-order">Order</th>
					<th class="column-thumbnail">Thumbnail</th>
					<th class="column-title">Title</th>
					<th class="column-title">Details</th>
				</tr>
			</tfoot>

		</table>

	<?php else: ?>

		<p>No slides found, why not <a href="post-new.php?post_type=staff">create one?</a></p>

	<?php endif; ?>
	<?php wp_reset_postdata(); // Don't forget to reset again! ?>

	<style>
		/* Dodgy CSS ^_^ */
		#sortable-table td { background: white; }
		#sortable-table .column-order { padding: 3px 10px; width: 60px; }
			#sortable-table .column-order img { cursor: move; }
		#sortable-table td.column-order { vertical-align: middle; text-align: center; }
		#sortable-table .column-thumbnail { width: auto; }
		#sortable-table tbody tr.ui-state-highlight {
		height:202px;
		width: 100%;
	    background:white !important;
	    -webkit-box-shadow: inset 0px 1px 2px 1px rgba(0, 0, 0, 0.1);
	    -moz-box-shadow: inset 0px 1px 2px 1px rgba(0, 0, 0, 0.1);
	    box-shadow: inset 0px 1px 2px 1px rgba(0, 0, 0, 0.1);
	    }
	</style>
	</div><!-- .wrap -->

<?php

}


///////////////////////////////////////
// - Create an interface showing each slide with a handle to sort
///////////////////////////////////////


add_action('admin_enqueue_scripts','staff_admin_enqueue_scripts');
function staff_admin_enqueue_scripts() {
  global $pagenow, $typenow;
  if ($pagenow=='edit.php' && $typenow=='staff') {
	wp_enqueue_script( 'bcause-admin-scripts', get_template_directory_uri() . '/js/sorting.js' );
  }
}

///////////////////////////////////////
// - Register and write the ajax callback function to actually update the posts.
///////////////////////////////////////


add_action( 'wp_ajax_staff_update_post_order', 'staff_update_post_order' );

function staff_update_post_order() {
	global $wpdb;

	$post_type     = $_POST['postType'];
	$order        = $_POST['order'];

	/**
	*    Expect: $sorted = array(
	*                menu_order => post-XX
	*            );
	*/
	foreach( $order as $menu_order => $post_id )
	{
		$post_id         = intval( str_ireplace( 'post-', '', $post_id ) );
		$menu_order     = intval($menu_order);
		wp_update_post( array( 'ID' => $post_id, 'menu_order' => $menu_order ) );
	}

	die( '1' );
}


/////////////////////////////////////////
// Custom Post Title text for Staff CPT
/////////////////////////////////////////

function staff_title_text( $title ){
$screen = get_current_screen();
if ( 'staff' == $screen->post_type ) {
$title = 'Name of Staff';
}
return $title;
}

add_filter( 'enter_title_here', 'staff_title_text' );


///////////////////////////////////////
// Custom Columns for Staff Post type
///////////////////////////////////////

// Add to admin_init function
add_filter('manage_edit-staff_columns', 'add_new_staff_columns');

function add_new_staff_columns($staff_columns) {
		$staff_columns = array (
			'cb' => '<input type="checkbox" />',
			'thumbnail' => __( 'Photo' ),
			'title' => __('Name'),
			'staff_email' => __('Email'),
			'staff_role' => __('Role'),
			'staff_phone' => __('Phone'),
		);
		
//		$new_columns['date'] = __('Date Added', 'column name');
 
		return $staff_columns;
	}

add_action( 'manage_staff_posts_custom_column', 'my_manage_staff_columns', 10, 2 );

function my_manage_staff_columns( $column, $post_id ) {
	global $post;

	switch( $column ) {

    case 'thumbnail':
			echo get_the_post_thumbnail( $post->ID, 'edit-screen-thumbnail' );
			break;

			case 'staff_email':
			/* Get the post meta. */
			$staff_meta = get_post_meta( $post_id, 'staff_email', true );

			/* If no duration is found, output a default message. */
			if ( empty( $staff_meta ) )
				echo __( '' );

			/* If there is a duration, append 'minutes' to the text string. */
			else
				echo $staff_meta;
			break;

			case 'staff_role':
			/* Get the post meta. */
			$staff_meta = get_post_meta( $post_id, 'staff_role', true );

			/* If no duration is found, output a default message. */
			if ( empty( $staff_meta ) )
				echo __( '' );

			/* If there is a duration, append 'minutes' to the text string. */
			else
				echo $staff_meta;
			break;

			case 'staff_phone':
			/* Get the post meta. */
			$staff_meta = get_post_meta( $post_id, 'staff_phone', true );

			/* If no duration is found, output a default message. */
			if ( empty( $staff_meta ) )
				echo __( '' );

			/* If there is a duration, append 'minutes' to the text string. */
			else
				echo $staff_meta;
			break;
		default: 

		} // end switch
	}	

?>
