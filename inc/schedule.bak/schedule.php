<?php




##############################

/**
 * This function introduces the theme options into the 'Appearance' menu and into a top-level
 * 'BCause Options' menu.
 */
function kbcs_schedule_menu() {

	add_menu_page(
		'Programming Schedule',	// The value used to populate the browser's title bar when the menu page is active
		'Schedule',	// The text of the menu in the administrator's sidebar
		'administrator',	// What roles are able to access the menu
		'schedule_setup',	// The ID used to bind submenu items to this menu
		'kbcs_schedule_display'	// The callback function used to render this menu
	);

	add_submenu_page(
		'bcause_menu', // The ID of the top-level menu page to which this submenu item belongs
		'Monday Schedule', // The value used to populate the browser's title bar when the menu page is active
		'Monday', // The label of this submenu item displayed in the menu
		'administrator', // What roles are able to access this submenu item
		'monday_options', // The ID used to represent this submenu item
		'kbcs_schedule_display', // The callback function used to render the options for this submenu item
		create_function( null, 'kbcs_schedule_display( "monday_options" );' )
	);

	add_submenu_page(
		'bcause_menu', // The ID of the top-level menu page to which this submenu item belongs
		'Tuesday Schedule', // The value used to populate the browser's title bar when the menu page is active
		'Tuesday', // The label of this submenu item displayed in the menu
		'administrator', // What roles are able to access this submenu item
		'tuesday_options', // The ID used to represent this submenu item
		'kbcs_schedule_display', // The callback function used to render the options for this submenu item
		create_function( null, 'kbcs_schedule_display( "tuesday_options" );' )
	);

	add_submenu_page(
		'bcause_menu', // The ID of the top-level menu page to which this submenu item belongs
		'Wednesday Schedule', // The value used to populate the browser's title bar when the menu page is active
		'Wednesday', // The label of this submenu item displayed in the menu
		'administrator', // What roles are able to access this submenu item
		'wednesday_options', // The ID used to represent this submenu item
		'kbcs_schedule_display', // The callback function used to render the options for this submenu item
		create_function( null, 'kbcs_schedule_display( "wednesday_options" );' )
	);

	add_submenu_page(
		'bcause_menu', // The ID of the top-level menu page to which this submenu item belongs
		'Wednesday Schedule', // The value used to populate the browser's title bar when the menu page is active
		'Wednesday', // The label of this submenu item displayed in the menu
		'administrator', // What roles are able to access this submenu item
		'thursday_options', // The ID used to represent this submenu item
		'kbcs_schedule_display', // The callback function used to render the options for this submenu item
		create_function( null, 'kbcs_schedule_display( "thursday_options" );' )
	);

	add_submenu_page(
		'bcause_menu', // The ID of the top-level menu page to which this submenu item belongs
		'Wednesday Schedule', // The value used to populate the browser's title bar when the menu page is active
		'Wednesday', // The label of this submenu item displayed in the menu
		'administrator', // What roles are able to access this submenu item
		'friday_options', // The ID used to represent this submenu item
		'kbcs_schedule_display', // The callback function used to render the options for this submenu item
		create_function( null, 'kbcs_schedule_display( "friday_options" );' )
	);

	add_submenu_page(
		'bcause_menu', // The ID of the top-level menu page to which this submenu item belongs
		'Wednesday Schedule', // The value used to populate the browser's title bar when the menu page is active
		'Wednesday', // The label of this submenu item displayed in the menu
		'administrator', // What roles are able to access this submenu item
		'saturday_options', // The ID used to represent this submenu item
		'kbcs_schedule_display', // The callback function used to render the options for this submenu item
		create_function( null, 'kbcs_schedule_display( "saturday_options" );' )
	);

	add_submenu_page(
		'bcause_menu', // The ID of the top-level menu page to which this submenu item belongs
		'Wednesday Schedule', // The value used to populate the browser's title bar when the menu page is active
		'Wednesday', // The label of this submenu item displayed in the menu
		'administrator', // What roles are able to access this submenu item
		'sunday_options', // The ID used to represent this submenu item
		'kbcs_schedule_display', // The callback function used to render the options for this submenu item
		create_function( null, 'kbcs_schedule_display( "sunday_options" );' )
	);



} // end kbcs_schedule_menu
add_action( 'admin_menu', 'kbcs_schedule_menu' );

/**
 * Renders a simple page to display for the theme menu defined above.
 */
function kbcs_schedule_display( $active_tab = '' ) {
?>
<!-- Create a header in the default WordPress 'wrap' container -->
<div class="wrap">
	<div id="icon-themes" class="icon32"></div>

		<h2><?php _e( 'Programming Schedule', 'schedule' ); ?></h2>

<?php settings_errors(); ?>

<?php if( isset( $_GET[ 'tab' ] ) ) {
		$active_tab = $_GET[ 'tab' ];
	} else if( $active_tab == 'tuesday_options' ) {
			$active_tab = 'tuesday_options';
	} else if( $active_tab == 'wednesday_options' ) {
			$active_tab = 'wednesday_options';
	} else if( $active_tab == 'thursday_options' ) {
			$active_tab = 'thursday_options';
	} else if( $active_tab == 'friday_options' ) {
		$active_tab = 'friday_options';
	} else if( $active_tab == 'saturday_options' ) {
		$active_tab = 'saturday_options';
	} else if( $active_tab == 'sunday_options' ) {
		$active_tab = 'sunday_options';
	} else {
		$active_tab = 'monday_options';
	} // end if/else ?>

<h2 class="nav-tab-wrapper">
	<a href="?page=schedule_setup&tab=monday_options" class="nav-tab <?php echo $active_tab == 'monday_options' ? 'nav-tab-active' : ''; ?>">Monday</a>
	<a href="?page=schedule_setup&tab=tuesday_options" class="nav-tab <?php echo $active_tab == 'tuesday_options' ? 'nav-tab-active' : ''; ?>">Tuesday</a>
	<a href="?page=schedule_setup&tab=wednesday_options" class="nav-tab <?php echo $active_tab == 'wednesday_options' ? 'nav-tab-active' : ''; ?>">Wednesday</a>
	<a href="?page=schedule_setup&tab=thursday_options" class="nav-tab <?php echo $active_tab == 'thursday_options' ? 'nav-tab-active' : ''; ?>">Thursday</a>
	<a href="?page=schedule_setup&tab=friday_options" class="nav-tab <?php echo $active_tab == 'friday_options' ? 'nav-tab-active' : ''; ?>">Friday</a>
	<a href="?page=schedule_setup&tab=saturday_options" class="nav-tab <?php echo $active_tab == 'saturday_options' ? 'nav-tab-active' : ''; ?>">Saturday</a>
	<a href="?page=schedule_setup&tab=sunday_options" class="nav-tab <?php echo $active_tab == 'sunday_options' ? 'nav-tab-active' : ''; ?>">Sunday</a>
</h2>


<form method="post" action="options.php">
<?php

	if( $active_tab == 'monday_options' ) {

		settings_fields( 'monday_options' );
		do_settings_sections( 'monday_options' );

	} elseif( $active_tab == 'tuesday_options' ) {

		settings_fields( 'tuesday_options' );
		do_settings_sections( 'tuesday_options' );

	} elseif( $active_tab == 'wednesday_options' ) {

		settings_fields( 'wednesday_options' );
		do_settings_sections( 'wednesday_options' );

	} elseif( $active_tab == 'thursday_options' ) {

		settings_fields( 'thursday_options' );
		do_settings_sections( 'thursday_options' );


	} elseif( $active_tab == 'friday_options' ) {

		settings_fields( 'friday_options' );
		do_settings_sections( 'friday_options' );

	} elseif( $active_tab == 'saturday_options' ) {

		settings_fields( 'saturday_options' );
		do_settings_sections( 'saturday_options' );

	} elseif( $active_tab == 'sunday_options' ) {

		settings_fields( 'sunday_options' );
		do_settings_sections( 'sunday_options' );



	} // end if/else

				submit_button();

	?>
                
</form>
</div><!-- /.wrap -->
<?php
} // end kbcs_schedule_display



/* ------------------------------------------------------------------------ *
* Setting Registration
* ------------------------------------------------------------------------ */

/**
* Provides default values for the Input Options.
*/
function kbcs_schedule_default_options() {

$defaults = array(
'input_example'	=>	'',
'textarea_example'	=>	'',
'checkbox_example'	=>	'',
'radio_example'	=>	'',
'time_options'	=>	'default'	
);

return apply_filters( 'kbcs_schedule_default_options', $defaults );

} // end kbcs_schedule_default_options

###############################################################################################
/* Initializes MONDAY OPTIONS by registering the Sections, Fields, and Settings. */
/* This function is registered with the 'admin_init' hook. */
###############################################################################################

function init_monday_options () {

if( false == get_option( 'monday_options' ) ) {	
add_option( 'monday_options', apply_filters( 'kbcs_schedule_default_options', kbcs_schedule_default_options() ) );
} // end if

	add_settings_section(
		'schedule_details_section',
		__( 'Schedule Details', 'schedule' ),
		'schedule_details_callback',
		'monday_options'
	);
	
	add_settings_field(	
		'schedule_startdate',	// String for use in the 'id' attribute of tags.
		__( 'Start/End Dates', 'schedule' ),	//Title of the field.
		'schedule_startdate_callback',	//Function that fills the field with the desired inputs as part of the larger form. 
		'monday_options',	//The menu page on which to display this field. 
		'schedule_details_section'	// The section of the settings page in which to show the box 
	);

	add_settings_field(	
		'schedule_repeating',	// String for use in the 'id' attribute of tags.
		__( '', 'schedule' ),	//Title of the field.
		'schedule_repeating_callback',	//Function that fills the field with the desired inputs as part of the larger form. 
		'monday_options',	//The menu page on which to display this field. 
		'schedule_details_section'	// The section of the settings page in which to show the box 
	);

	
	// Register all the settings
	register_setting(
		'monday_options',
		'monday_options',
		'schedule_validate'
	);

} // end init_monday_options
add_action( 'admin_init', 'init_monday_options' );


###############################################################################################
/* Initializes TUESDAY OPTIONS by registering the Sections, Fields, and Settings. */
/* This function is registered with the 'admin_init' hook. */
###############################################################################################

function init_tuesday_options () {

if( false == get_option( 'tuesday_options' ) ) {	
add_option( 'tuesday_options', apply_filters( 'kbcs_schedule_default_options', kbcs_schedule_default_options() ) );
} // end if

	add_settings_section(
		'schedule_details_section',
		__( 'Schedule Details', 'schedule' ),
		'schedule_details_callback',
		'tuesday_options'
	);
	
	add_settings_field(	
		'schedule_startdate',	// String for use in the 'id' attribute of tags.
		__( 'Start/End Dates', 'schedule' ),	//Title of the field.
		'schedule_startdate_callback',	//Function that fills the field with the desired inputs as part of the larger form. 
		'tuesday_options',	//The menu page on which to display this field. 
		'schedule_details_section'	// The section of the settings page in which to show the box 
	);
		

	
	// Register all the settings
	register_setting(
		'tuesday_options',
		'tuesday_options',
		'schedule_validate'
	);

} // end init_tuesday_options
add_action( 'admin_init', 'init_tuesday_options' );


###############################################################################################
/* Initializes WEDNESDAY OPTIONS by registering the Sections, Fields, and Settings. */
/* This function is registered with the 'admin_init' hook. */
###############################################################################################

function init_wednesday_options () {

if( false == get_option( 'wednesday_options' ) ) {	
add_option( 'wednesday_options', apply_filters( 'kbcs_schedule_default_options', kbcs_schedule_default_options() ) );
} // end if

	add_settings_section(
		'schedule_details_section',
		__( 'Schedule Details', 'schedule' ),
		'schedule_details_callback',
		'wednesday_options'
	);
	
	add_settings_field(	
		'schedule_startdate',	// String for use in the 'id' attribute of tags.
		__( 'Start/End Dates', 'schedule' ),	//Title of the field.
		'schedule_startdate_callback',	//Function that fills the field with the desired inputs as part of the larger form. 
		'wednesday_options',	//The menu page on which to display this field. 
		'schedule_details_section'	// The section of the settings page in which to show the box 
	);
		

	
	// Register all the settings
	register_setting(
		'wednesday_options',
		'wednesday_options',
		'schedule_validate'
	);

} // end init_wednesday_options
add_action( 'admin_init', 'init_wednesday_options' );


###############################################################################################
/* Initializes THURSDAY OPTIONS by registering the Sections, Fields, and Settings. */
/* This function is registered with the 'admin_init' hook. */
###############################################################################################

function init_thursday_options () {

if( false == get_option( 'thursday_options' ) ) {	
add_option( 'thursday_options', apply_filters( 'kbcs_schedule_default_options', kbcs_schedule_default_options() ) );
} // end if

	add_settings_section(
		'schedule_details_section',
		__( 'Schedule Details', 'schedule' ),
		'schedule_details_callback',
		'thursday_options'
	);
	
	add_settings_field(	
		'schedule_startdate',	// String for use in the 'id' attribute of tags.
		__( 'Start/End Dates', 'schedule' ),	//Title of the field.
		'schedule_startdate_callback',	//Function that fills the field with the desired inputs as part of the larger form. 
		'thursday_options',	//The menu page on which to display this field. 
		'schedule_details_section'	// The section of the settings page in which to show the box 
	);
		

	
	// Register all the settings
	register_setting(
		'thursday_options',
		'thursday_options',
		'schedule_validate'
	);

} // end init_thursday_options
add_action( 'admin_init', 'init_thursday_options' );


###############################################################################################
/* Initializes FRIDAY OPTIONS by registering the Sections, Fields, and Settings. */
/* This function is registered with the 'admin_init' hook. */
###############################################################################################

function init_friday_options () {

if( false == get_option( 'friday_options' ) ) {	
add_option( 'friday_options', apply_filters( 'kbcs_schedule_default_options', kbcs_schedule_default_options() ) );
} // end if

	add_settings_section(
		'schedule_details_section',
		__( 'Schedule Details', 'schedule' ),
		'schedule_details_callback',
		'friday_options'
	);
	
	add_settings_field(	
		'schedule_startdate',	// String for use in the 'id' attribute of tags.
		__( 'Start/End Dates', 'schedule' ),	//Title of the field.
		'schedule_startdate_callback',	//Function that fills the field with the desired inputs as part of the larger form. 
		'friday_options',	//The menu page on which to display this field. 
		'schedule_details_section'	// The section of the settings page in which to show the box 
	);
		

	
	// Register all the settings
	register_setting(
		'friday_options',
		'friday_options',
		'schedule_validate'
	);

} // end init_friday_options
add_action( 'admin_init', 'init_friday_options' );


###############################################################################################
/* Initializes SATURDAY OPTIONS by registering the Sections, Fields, and Settings. */
/* This function is registered with the 'admin_init' hook. */
###############################################################################################

function init_saturday_options () {

if( false == get_option( 'saturday_options' ) ) {	
add_option( 'saturday_options', apply_filters( 'kbcs_schedule_default_options', kbcs_schedule_default_options() ) );
} // end if

	add_settings_section(
		'schedule_details_section',
		__( 'Schedule Details', 'schedule' ),
		'schedule_details_callback',
		'saturday_options'
	);
	
	add_settings_field(	
		'schedule_startdate',	// String for use in the 'id' attribute of tags.
		__( 'Start/End Dates', 'schedule' ),	//Title of the field.
		'schedule_startdate_callback',	//Function that fills the field with the desired inputs as part of the larger form. 
		'saturday_options',	//The menu page on which to display this field. 
		'schedule_details_section'	// The section of the settings page in which to show the box 
	);
		

	
	// Register all the settings
	register_setting(
		'saturday_options',
		'saturday_options',
		'schedule_validate'
	);

} // end init_saturday_options
add_action( 'admin_init', 'init_saturday_options' );


###############################################################################################
/* Initializes SUNDAY OPTIONS by registering the Sections, Fields, and Settings. */
/* This function is registered with the 'admin_init' hook. */
###############################################################################################

function init_sunday_options () {

if( false == get_option( 'sunday_options' ) ) {	
add_option( 'sunday_options', apply_filters( 'kbcs_schedule_default_options', kbcs_schedule_default_options() ) );
} // end if

	add_settings_section(
		'schedule_details_section',
		__( 'Schedule Details', 'schedule' ),
		'schedule_details_callback',
		'sunday_options'
	);
	
	add_settings_field(	
		'schedule_startdate',	// String for use in the 'id' attribute of tags.
		__( 'Start/End Dates', 'schedule' ),	//Title of the field.
		'schedule_startdate_callback',	//Function that fills the field with the desired inputs as part of the larger form. 
		'sunday_options',	//The menu page on which to display this field. 
		'schedule_details_section'	// The section of the settings page in which to show the box 
	);
		

	
	// Register all the settings
	register_setting(
		'sunday_options',
		'sunday_options',
		'schedule_validate'
	);

} // end init_sunday_options
add_action( 'admin_init', 'init_sunday_options' );


###############################################################################################
/* Custom Meta Box for Reusable Schedule Items */
###############################################################################################

//do_meta_boxes( 'schedule_setup', 'normal' );

// Add the Meta Box  
function add_schedule_meta_box() {  
    add_meta_box(  
        'custom_meta_box', // $id  
        'Custom Meta Box', // $title   
        'show_schedule_meta_box', // $callback  
        'schedule_setup', // $page  
        'normal', // $context  
        'high'); // $priority  
}  
add_action('add_meta_boxes', 'add_schedule_meta_box');  


// Field Array
$prefix = 'custom_';
$custom_meta_fields = array(
	array(
		'label'=> 'Text Input',
		'desc'	=> 'A description for the field.',
		'id'	=> $prefix.'text',
		'type'	=> 'text'
	),
	array(
		'label'=> 'Textarea',
		'desc'	=> 'A description for the field.',
		'id'	=> $prefix.'textarea',
		'type'	=> 'textarea'
	),
	array(
		'label'=> 'Checkbox Input',
		'desc'	=> 'A description for the field.',
		'id'	=> $prefix.'checkbox',
		'type'	=> 'checkbox'
	),
	array(
		'label'=> 'Select Box',
		'desc'	=> 'A description for the field.',
		'id'	=> $prefix.'select',
		'type'	=> 'select',
		'options' => array (
			'one' => array (
				'label' => 'Option One',
				'value'	=> 'one'
			),
			'two' => array (
				'label' => 'Option Two',
				'value'	=> 'two'
			),
			'three' => array (
				'label' => 'Option Three',
				'value'	=> 'three'
			)
		)
	)
);

// The Callback  
function show_schedule_meta_box() {  
global $custom_meta_fields, $post;  
// Use nonce for verification  
echo '<input type="hidden" name="custom_meta_box_nonce" value="'.wp_create_nonce(basename(__FILE__)).'" />';  
      
    // Begin the field table and loop  
    echo '<table class="form-table">';  
    foreach ($custom_meta_fields as $field) {  
        // get value of this field if it exists for this post  
        $meta = get_post_meta($post->ID, $field['id'], true);  
        // begin a table row with  
        echo '<tr> 
                <th><label for="'.$field['id'].'">'.$field['label'].'</label></th> 
                <td>';  
                switch($field['type']) {  
                    // case items will go here 

					    // text  
					    case 'text':  
					        echo '<input type="text" name="'.$field['id'].'" id="'.$field['id'].'" value="'.$meta.'" size="30" /> 
					            <br /><span class="description">'.$field['desc'].'</span>';  
					    break;  

					    // textarea  
					    case 'textarea':  
					        echo '<textarea name="'.$field['id'].'" id="'.$field['id'].'" cols="60" rows="4">'.$meta.'</textarea> 
					            <br /><span class="description">'.$field['desc'].'</span>';  
					    break;  				    

					    // checkbox  
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
    function save_schedule_meta($post_id) {  
        global $custom_meta_fields;  
          
        // verify nonce  
        if (!wp_verify_nonce($_POST['custom_meta_box_nonce'], basename(__FILE__)))   
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
        foreach ($custom_meta_fields as $field) {  
            $old = get_post_meta($post_id, $field['id'], true);  
            $new = $_POST[$field['id']];  
            if ($new && $new != $old) {  
                update_post_meta($post_id, $field['id'], $new);  
            } elseif ('' == $new && $old) {  
                delete_post_meta($post_id, $field['id'], $old);  
            }  
        } // end foreach  
    }  
    add_action('save_post', 'save_schedule_meta');    

/* ------------------------------------------------------------------------ *
* Section Callbacks
* ------------------------------------------------------------------------ */

/**
* This function provides a simple description for the Input Examples page.
*
* It's called from the 'sandbox_theme_intialize_input_examples_options' function by being passed as a parameter
* in the add_settings_section function.
*/
function schedule_details_callback() {
//echo '<p>' . __( 'Provides examples of the five basic element types.', 'schedule' ) . '</p>';
} // end schedule_general_options_callback

function schedule_message_callback() {
//echo '<p>' . __( 'Provides examples of the five basic element types.', 'schedule' ) . '</p>';
} // end schedule_general_options_callback

/* ------------------------------------------------------------------------ *
* Field Callbacks
* ------------------------------------------------------------------------ */

function schedule_startdate_callback() {
	$options = get_option( 'monday_options' );
	// Render the output
	echo 'Start date: ';
	echo '<input type="text" id="from" name="monday_options[schedule_startdate]" value="' . $options['schedule_startdate'] . '" class="datepicker" />';
	echo ' End date: ';
	echo '<input type="text" id="to" name="monday_options[schedule_enddate]" value="' . $options['schedule_enddate'] . '" class="datepicker" />';
	?>
	

<?php } // end schedule_startdate_callback


function schedule_repeating_callback() {
	echo 'yay!';
add_meta_box( 
    'add_schedule_meta_box',
    __( 'My Custom Meta Box' ),
    'schedule_setup',
    'normal' );

do_meta_boxes( 'schedule_setup', 'normal', '');


	

 } // end schedule_repeating_callback
/*
function schedule_on_off_callback() {
	$options = get_option( 'monday_options' );
	$start_date = $options['schedule_startdate'];	
	$end_date = $options['schedule_enddate'];
	$current_date = date("Y-m-d");
	
    if($current_date > $start_date && $current_date < $end_date)
        echo "true";
    else
        echo "false";
} // end schedule_on_off_callback
*/



/*
function schedule_enddate_callback() {
	$options = get_option( 'monday_options' );
	// Render the output
	echo '<input type="text" class="datepicker" id="schedule_enddate" name="monday_options[schedule_enddate]" value="' . $options['schedule_enddate'] . '" />';
} // end schedule_enddate_callback
*/

function schedule_goal_callback() {
	$options = get_option( 'monday_options' );
	// Render the output
	echo '$ <input type="text" id="schedule_goal" name="monday_options[schedule_goal]" value="' . $options['schedule_goal'] . '" />';
} // end schedule_goal_callback

function schedule_current_callback() {
	$options = get_option( 'monday_options' );
	// Render the output 
	echo '$ <input type="text" id="schedule_current" name="monday_options[schedule_current]" value="' . $options['schedule_current'] . '" />';
} // end schedule_current_callback

function schedule_remaining_callback() {
	$options = get_option( 'monday_options' );
	$goal = $options['schedule_goal'];
	$current = $options['schedule_current'];
	$remaining = ($goal-$current);
	$remaining_percent = $current/$goal * 100;
	$progress = $remaining/$goal;
	// Render the output
	echo "$ ".number_format($remaining, 2);
} // end schedule_remaining_callback



function schedule_progress_callback() {
	$options = get_option( 'monday_options' );
	$goal = $options['schedule_goal'];
	$current = $options['schedule_current'];
	$remaining = ($goal-$current);
	$remaining_percent = $current/$goal * 100;
	$progress = $remaining/$goal;
	// Render the output ?>

	
    <div class="progress progress-striped active">
	    <div class="bar" style="width: <?php echo $remaining_percent; ?>%"><?php echo number_format($remaining_percent, 2); ?>%</div>
    </div>
<?php } // end schedule_progress_callback



function schedule_message_title_callback() {
	$options = get_option( 'monday_options' );
	// Render the output
	echo '<input type="text" id="schedule_message_title" name="monday_options[schedule_message_title]" value="' . $options['schedule_message_title'] . '" />';
} // end schedule_message_title_callback


function schedule_message_textarea_callback() {

$options = get_option( 'monday_options' );

// Render the output
echo '<textarea id="schedule_message" name="monday_options[schedule_message]" rows="5" cols="50">' . $options['schedule_message'] . '</textarea>';

} // end schedule_message_textarea_callback

function schedule_button_title_callback() {
	$options = get_option( 'monday_options' );
	// Render the output
	echo '<input type="text" id="schedule_button_title" name="monday_options[schedule_button_title]" value="' . $options['schedule_button_title'] . '" />';
} // end schedule_button_title_callback


function schedule_button_url_callback() {
	$options = get_option( 'monday_options' );

	// Next, we need to make sure the element is defined in the options. If not, we'll set an empty string.
	$url = '';
	if( isset( $options['schedule_button_url'] ) ) {
	$url = esc_url( $options['schedule_button_url'] );
	} // end if

	// Render the output
	echo '<input type="text" id="schedule_button_url" name="monday_options[schedule_button_url]" value="' . $url . '" />';
} // end schedule_button_url_callback

function schedule_link1_title_callback() {
	$options = get_option( 'monday_options' );
	// Render the output
	echo '<input type="text" id="schedule_link1_title" name="monday_options[schedule_link1_title]" value="' . $options['schedule_link1_title'] . '"  size="50" />';
} // end schedule_link1_title_callback


function schedule_link1_url_callback() {
	$options = get_option( 'monday_options' );

	// Next, we need to make sure the element is defined in the options. If not, we'll set an empty string.
	$url = '';
	if( isset( $options['schedule_link1_url'] ) ) {
	$url = esc_url( $options['schedule_link1_url'] );
	} // end if

	// Render the output
	echo '<input type="text" id="schedule_link1_url" name="monday_options[schedule_link1_url]" value="' . $url . '"  size="50" />';
} // end schedule_link1_url_callback


function schedule_link2_title_callback() {
	$options = get_option( 'monday_options' );
	// Render the output
	echo '<input type="text" id="schedule_link2_title" name="monday_options[schedule_link2_title]" value="' . $options['schedule_link2_title'] . '" size="50" />';
} // end schedule_button_title_callback


function schedule_link2_url_callback() {
	$options = get_option( 'monday_options' );

	// Next, we need to make sure the element is defined in the options. If not, we'll set an empty string.
	$url = '';
	if( isset( $options['schedule_link2_url'] ) ) {
	$url = esc_url( $options['schedule_link2_url'] );
	} // end if

	// Render the output
	echo '<input type="text" id="schedule_link2_url" name="monday_options[schedule_link2_url]" value="' . $url . '" size="50" />';
} // end schedule_button_url_callback


/* ------------------------------------------------------------------------ *
* Setting Callbacks
* ------------------------------------------------------------------------ */
 
/**
* Sanitization callback for the social options. Since each of the social options are text inputs,
* this function loops through the incoming option and strips all tags and slashes from the value
* before serializing it.
*
* @params $input The unsanitized collection of options.
*
* @returns The collection of sanitized values.
*/

function schedule_validate( $input ) {

// Create our array for storing the validated options
$output = array();

// Loop through each of the incoming options
foreach( $input as $key => $value ) {

// Check to see if the current option has a value. If so, process it.
if( isset( $input[$key] ) ) {

// Strip all HTML and PHP tags and properly handle quoted strings
$output[$key] = strip_tags( stripslashes( $input[ $key ] ) );

} // end if

} // end foreach

// Return the array processing any additional functions filtered by this action
return apply_filters( 'schedule_validate', $output, $input );

} // end schedule_validate

##########################################################################
// Determine if Schedule is on or not based on start/end/current time
##########################################################################

   

?>