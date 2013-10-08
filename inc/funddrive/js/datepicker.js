  jQuery(function() {
    jQuery( "#from" ).datepicker({
      defaultDate: "+1w",
      changeMonth: true,
	  dateFormat: "yy-mm-dd",
      numberOfMonths: 3,
      onClose: function( selectedDate ) {
        jQuery( "#to" ).datepicker( "option", "minDate", selectedDate );
      }
    });
    jQuery( "#to" ).datepicker({
      defaultDate: "+1w",
      changeMonth: true,
	  dateFormat: "yy-mm-dd",
      numberOfMonths: 3,
      onClose: function( selectedDate ) {
        jQuery( "#from" ).datepicker( "option", "maxDate", selectedDate );
      }
    });
    jQuery(document).ready(function($) {
	    $('.datepicker').datepicker({ dateFormat: "yy-mm-dd" });
	});
  });