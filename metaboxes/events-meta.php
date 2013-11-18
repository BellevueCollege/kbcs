<div class="my_meta_control">

	<?php while($mb->have_fields_and_multi('events')): ?>
	<?php $mb->the_group_open(); ?>

<!-- http://wordpress.stackexchange.com/questions/1794/need-help-in-saving-taxonomy-terms-85-solved-just-need-some-help -->
		<ul>
			<li>
		        <?php $mb->the_field('event_start_date'); ?>
		        <label>Start Date</label>
		        <input type="text" name="<?php $mb->the_name(); ?>" value="<?php $mb->the_value(); ?>" class="datepicker" />
			</li>
                
			<li>
		        <?php $mb->the_field('event_start_time'); ?>
		        <label>Start Time</label>
		        <input type="text" name="<?php $mb->the_name(); ?>" value="<?php $mb->the_value(); ?>" class="timepicker" />
				<em>(hh:mm pm)</em>
			</li>

			<li>
		        <?php $mb->the_field('event_end_time'); ?>
		        <label>End Time</label>
		        <input type="text" name="<?php $mb->the_name(); ?>" value="<?php $mb->the_value(); ?>" class="timepicker" />
				<em>(hh:mm pm)</em>
			</li>
		</ul>
		    
	<p>
		<a style="float:right; margin:0px 10px;" href="#" class="dodelete button">Remove Entry</a>
		<br />
	</p>
	
	<?php $mb->the_group_close(); ?>
	<?php endwhile; ?>

	<p>
		<a href="#" class="docopy-events button">Add Event Occurance</a> 
		<input type="submit" class="button-primary" name="save" value="Save">
	</p>
</div>

<script type="text/javascript">
//<![CDATA[
 
jQuery(function($) {
        $.wpalchemy.bind('wpa_copy', function(the_clone) {
                $('.datepicker', the_clone);
                $('.datepicker').not('.hasDatePicker').datepicker();
                //console.log(the_clone);
        });
});
 
//]]>
</script>


                
<?php /*

<script type="text/javascript">

jQuery(document).ready(function() {
    jQuery('.my_meta_control').datepicker({
        dateFormat : 'dd-mm-yy'
    });
});

</script>
*/ ?>