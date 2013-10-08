<?php




##############################




/**
* This function introduces the Fund Drive menu as a top-level Wordpress Menu
*/

function kbcs_funddrive_menu() {

add_menu_page(
'Fund Drive Options',	// The value used to populate the browser's title bar when the menu page is active
'Fund Drive',	// The text of the menu in the administrator's sidebar
'administrator',	// What roles are able to access the menu
'funddrive_menu',	// The ID used to bind submenu items to this menu
'kbcs_funddrive_display'	// The callback function used to render this menu
);

} // end kbcs_funddrive_menu
add_action( 'admin_menu', 'kbcs_funddrive_menu' );

/**
* Renders a simple page to display for the theme menu defined above.
*/
function kbcs_funddrive_display( $active_tab = '' ) {
?>

<!-- Create a header in the default WordPress 'wrap' container -->
	<div class="wrap funddrive_screen">
		<div id="icon-themes" class="icon32"></div>
		
		<h2><?php _e( 'Fund Drive Settings', 'funddrive' ); ?></h2>
	
		<?php settings_errors(); ?>
	
		<h2 class="nav-tab-wrapper">
			<a href="?page=funddrive_menu&tab=input_examples" class="nav-tab input_examples nav-tab-active"><?php _e( 'Fund Drive Settings', 'funddrive' ); ?></a>
		</h2>
	
		<form method="post" action="options.php">
			<?php
			
				settings_fields( 'funddrive_settings' );
				do_settings_sections( 'funddrive_settings' );
				
				submit_button();
			
			?>
		</form>
	
	</div><!-- /.wrap -->

<?php } // end kbcs_funddrive_display

/* ------------------------------------------------------------------------ *
* Setting Registration
* ------------------------------------------------------------------------ */

/**
* Provides default values for the Input Options.
*/
function kbcs_funddrive_default_options() {

$defaults = array(
'input_example'	=>	'',
'textarea_example'	=>	'',
'checkbox_example'	=>	'',
'radio_example'	=>	'',
'time_options'	=>	'default'	
);

return apply_filters( 'kbcs_funddrive_default_options', $defaults );

} // end kbcs_funddrive_default_options

/**
* Initializes the theme's input example by registering the Sections,
* Fields, and Settings. This particular group of options is used to demonstration
* validation and sanitization.
*
* This function is registered with the 'admin_init' hook.
*/
function kbcs_initialize_funddrive_options() {

if( false == get_option( 'funddrive_settings' ) ) {	
add_option( 'kbcs_funddrive_options_input_examples', apply_filters( 'kbcs_funddrive_default_options', kbcs_funddrive_default_options() ) );
} // end if

	add_settings_section(
		'funddrive_details_section',
		__( 'Fund Drive Details', 'funddrive' ),
		'funddrive_details_callback',
		'funddrive_settings'
	);
	
	add_settings_field(	
		'funddrive_startdate',	// String for use in the 'id' attribute of tags.
		__( 'Start/End Dates', 'funddrive' ),	//Title of the field.
		'funddrive_startdate_callback',	//Function that fills the field with the desired inputs as part of the larger form. 
		'funddrive_settings',	//The menu page on which to display this field. 
		'funddrive_details_section'	// The section of the settings page in which to show the box 
	);
/*
	add_settings_field(	
		'funddrive_on_off',	// String for use in the 'id' attribute of tags.
		'Fund Drive On/Off',	//Title of the field.
		'funddrive_on_off_callback',	//Function that fills the field with the desired inputs as part of the larger form. 
		'funddrive_settings',	//The menu page on which to display this field. 
		'funddrive_details_section'	// The section of the settings page in which to show the box 
	);
*/		
/*	
	add_settings_field(	
		'funddrive_enddate',	
		__( 'End Date', 'funddrive' ),	
		'funddrive_enddate_callback',	
		'funddrive_settings',	
		'funddrive_details_section'	
	);
*/	
	add_settings_field(	
		'funddrive_goal',	
		__( 'Goal', 'funddrive' ),	
		'funddrive_goal_callback',	
		'funddrive_settings',	
		'funddrive_details_section'	
	);
	
	add_settings_field(	
		'funddrive_current',	
		__( 'Current', 'funddrive' ),	
		'funddrive_current_callback',	
		'funddrive_settings',	
		'funddrive_details_section'	
	);
	

	add_settings_field(	
		'funddrive_remaining',	
		__( 'Remaining', 'funddrive' ),	
		'funddrive_remaining_callback',	
		'funddrive_settings',	
		'funddrive_details_section'	
	);
	
	add_settings_field(	
		'funddrive_progress',	
		__( 'Progress', 'funddrive' ),	
		'funddrive_progress_callback',	
		'funddrive_settings',	
		'funddrive_details_section'	
	);
		
	// Fund Drive Message settings
	add_settings_section(
		'funddrive_message_section',
		__( 'Fund Drive Message', 'funddrive' ),
		'funddrive_message_callback',
		'funddrive_settings'
	);

	add_settings_field(	
		'Message Title',	
		__( 'Message Title', 'funddrive' ),	
		'funddrive_message_title_callback',	
		'funddrive_settings',	
		'funddrive_message_section'	
	);
	add_settings_field(	
		'Message Content',	
		__( 'Message Content', 'funddrive' ),	
		'funddrive_message_textarea_callback',	
		'funddrive_settings',	
		'funddrive_message_section'	
	);

	add_settings_field(	
		'funddrive_button_title',	
		'Button title:',	
		'funddrive_button_title_callback',	
		'funddrive_settings',	
		'funddrive_message_section'	
	);

	add_settings_field(	
		'funddrive_button_url',	
		'Button URL:',	
		'funddrive_button_url_callback',	
		'funddrive_settings',	
		'funddrive_message_section'	
	);

	add_settings_field(	
		'funddrive_button2_title',	
		'Button2 title:',	
		'funddrive_button2_title_callback',	
		'funddrive_settings',	
		'funddrive_message_section'	
	);

	add_settings_field(	
		'funddrive_button2_url',	
		'Button2 URL:',	
		'funddrive_button2_url_callback',	
		'funddrive_settings',	
		'funddrive_message_section'	
	);
	
	// Register all the settings
	register_setting(
		'funddrive_settings',
		'funddrive_settings',
		'funddrive_validate'
	);

} // end kbcs_initialize_funddrive_options
add_action( 'admin_init', 'kbcs_initialize_funddrive_options' );

/* ------------------------------------------------------------------------ *
* Section Callbacks
* ------------------------------------------------------------------------ */

/**
* This function provides a simple description for the Input Examples page.
*
* It's called from the 'sandbox_theme_intialize_input_examples_options' function by being passed as a parameter
* in the add_settings_section function.
*/
function funddrive_details_callback() {
//echo '<p>' . __( 'Provides examples of the five basic element types.', 'funddrive' ) . '</p>';
} // end funddrive_general_options_callback

function funddrive_message_callback() {
//echo '<p>' . __( 'Provides examples of the five basic element types.', 'funddrive' ) . '</p>';
} // end funddrive_general_options_callback

/* ------------------------------------------------------------------------ *
* Field Callbacks
* ------------------------------------------------------------------------ */

function funddrive_startdate_callback() {
	$options = get_option( 'funddrive_settings' );
	// Render the output
	echo 'Start date: ';
	echo '<input type="text" id="from" name="funddrive_settings[funddrive_startdate]" value="' . $options['funddrive_startdate'] . '" class="datepicker" />';
	echo ' End date: ';
	echo '<input type="text" id="to" name="funddrive_settings[funddrive_enddate]" value="' . $options['funddrive_enddate'] . '" class="datepicker" />';
	?>
	

<?php } // end funddrive_startdate_callback

/*
function funddrive_on_off_callback() {
	$options = get_option( 'funddrive_settings' );
	$start_date = $options['funddrive_startdate'];	
	$end_date = $options['funddrive_enddate'];
	$current_date = date("Y-m-d");
	
    if($current_date > $start_date && $current_date < $end_date)
        echo "true";
    else
        echo "false";
} // end funddrive_on_off_callback
*/



/*
function funddrive_enddate_callback() {
	$options = get_option( 'funddrive_settings' );
	// Render the output
	echo '<input type="text" class="datepicker" id="funddrive_enddate" name="funddrive_settings[funddrive_enddate]" value="' . $options['funddrive_enddate'] . '" />';
} // end funddrive_enddate_callback
*/

function funddrive_goal_callback() {
	$options = get_option( 'funddrive_settings' );
	// Render the output
	echo '$ <input type="text" id="funddrive_goal" name="funddrive_settings[funddrive_goal]" value="' . $options['funddrive_goal'] . '" />';
} // end funddrive_goal_callback

function funddrive_current_callback() {
	$options = get_option( 'funddrive_settings' );
	// Render the output 
	echo '$ <input type="text" id="funddrive_current" name="funddrive_settings[funddrive_current]" value="' . $options['funddrive_current'] . '" />';
} // end funddrive_current_callback

function funddrive_remaining_callback() {
	$options = get_option( 'funddrive_settings' );
	$goal = $options['funddrive_goal'];
	$current = $options['funddrive_current'];
	$remaining = ($goal-$current);
	$remaining_percent = $current/$goal * 100;
	$progress = $remaining/$goal;
	// Render the output
	echo "$ ".number_format($remaining, 2);
} // end funddrive_remaining_callback



function funddrive_progress_callback() {
	$options = get_option( 'funddrive_settings' );
	$goal = $options['funddrive_goal'];
	$current = $options['funddrive_current'];
	$remaining = ($goal-$current);
	$remaining_percent = $current/$goal * 100;
	$progress = $remaining/$goal;
	// Render the output ?>

	
    <div class="progress progress-striped active">
	    <div class="bar" style="width: <?php echo $remaining_percent; ?>%"><?php echo number_format($remaining_percent, 2); ?>%</div>
    </div>
<?php } // end funddrive_progress_callback



function funddrive_message_title_callback() {
	$options = get_option( 'funddrive_settings' );
	// Render the output
	echo '<input type="text" id="funddrive_message_title" name="funddrive_settings[funddrive_message_title]" value="' . $options['funddrive_message_title'] . '" />';
} // end funddrive_message_title_callback


function funddrive_message_textarea_callback() {

$options = get_option( 'funddrive_settings' );

// Render the output
echo '<textarea id="funddrive_message" name="funddrive_settings[funddrive_message]" rows="5" cols="50">' . $options['funddrive_message'] . '</textarea>';

} // end funddrive_message_textarea_callback

function funddrive_button_title_callback() {
	$options = get_option( 'funddrive_settings' );
	// Render the output
	echo '<input type="text" id="funddrive_button_title" name="funddrive_settings[funddrive_button_title]" value="' . $options['funddrive_button_title'] . '" />';
} // end funddrive_button_title_callback


function funddrive_button_url_callback() {
	$options = get_option( 'funddrive_settings' );

	// Next, we need to make sure the element is defined in the options. If not, we'll set an empty string.
	$url = '';
	if( isset( $options['funddrive_button_url'] ) ) {
	$url = esc_url( $options['funddrive_button_url'] );
	} // end if

	// Render the output
	echo '<input type="text" id="funddrive_button_url" name="funddrive_settings[funddrive_button_url]" value="' . $url . '" />';
} // end funddrive_button_url_callback

function funddrive_button2_title_callback() {
	$options = get_option( 'funddrive_settings' );
	// Render the output
	echo '<input type="text" id="funddrive_button2_title" name="funddrive_settings[funddrive_button2_title]" value="' . $options['funddrive_button2_title'] . '"  size="50" />';
} // end funddrive_button2_title_callback


function funddrive_button2_url_callback() {
	$options = get_option( 'funddrive_settings' );

	// Next, we need to make sure the element is defined in the options. If not, we'll set an empty string.
	$url = '';
	if( isset( $options['funddrive_button2_url'] ) ) {
	$url = esc_url( $options['funddrive_button2_url'] );
	} // end if

	// Render the output
	echo '<input type="text" id="funddrive_button2_url" name="funddrive_settings[funddrive_button2_url]" value="' . $url . '"  size="50" />';
} // end funddrive_button2_url_callback




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

function funddrive_validate( $input ) {

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
return apply_filters( 'funddrive_validate', $output, $input );

} // end funddrive_validate

##########################################################################
// Determine if Fund Drive is on or not based on start/end/current time
##########################################################################

   

?>