jQuery(function(jQuery) {

	jQuery('#sortable-table tbody').sortable({
		axis: 'y',
		handle: '.column-order img',
		placeholder: 'ui-state-highlight',
		forcePlaceholderSize: true,
		update: function(event, ui) {
			var theOrder = jQuery(this).sortable('toArray');

			var data = {
				action: 'staff_update_post_order',
				postType: jQuery(this).attr('data-post-type'),
				order: theOrder
			};

			jQuery.post(ajaxurl, data);
		}
	}).disableSelection();

});