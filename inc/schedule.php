<?php 
$prefix = 'schedule_';

$fields = array(
		array(
		    'label' => 'Repeatable',
		    'desc'  => 'A description for the field.',
		    'id'    => $prefix . 'repeatable',
		    'type'  => 'repeatable',
		    'sanitizer' => array(
		        'date' => 'sanitize_text_field',
		        'programs' => ''
		    ),
		    'repeatable_fields' => array (
		        'date' => array(
			        'label' => 'Date',  
			        'desc'  => 'A description for the field.',  
			        'id'    => $prefix.'date',  
			        'type'  => 'date'  
		        ),
		        'programs' => array(
		            'label' => 'Program',
		            'id' => 'programs',
		            'type' => 'tax_select'
		        )
		    )
		)

);

/**
 * Instantiate the class with all variables to create a meta box
 * var $id string meta box id
 * var $title string title
 * var $fields array fields
 * var $page string|array post type to add meta box to
 * var $js bool including javascript or not
 */
$sample_box = new custom_add_meta_box( 'schedule_meta_box', 'Daily Schedule', $fields, 'schedule', true );

?>