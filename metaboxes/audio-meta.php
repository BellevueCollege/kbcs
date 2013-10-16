<div class="my_meta_control">

	<?php while($mb->have_fields_and_multi('airdate_group')): ?>
	<?php $mb->the_group_open(); ?>


<!-- http://wordpress.stackexchange.com/questions/1794/need-help-in-saving-taxonomy-terms-85-solved-just-need-some-help -->

		<label>Program</label>
		    <?php $terms = get_terms('programs', 'hide_empty=0'); ?>
		    <?php $mb->the_field('program_terms'); ?>
		    <select name="<?php $mb->the_name(); ?>">
		    <option value='' <?php if (!count($terms)) echo "selected";?>>Not Assigned</option>
		    <?php foreach ($terms as $term): ?>
		    <option value="<?php echo $term->term_id; ?>"<?php $mb->the_select_state($term->term_id); ?><?php echo '>' . $term->name; ?></option>
		    <?php endforeach; ?>
		    </select>

<p>
	<?php $mb->the_field('_fulldate'); ?>
	<input type="text" class="datepicker" name="<?php $mb->the_name(); ?>" value="<?php $mb->the_value(); ?>" />
</p>

	
        <?php $mb->the_field('air_date'); ?>
        <label>Air Date</label>
        <input type="text" name="<?php $mb->the_name(); ?>" value="<?php $mb->the_value(); ?>" class="datepicker" />
	
		    
	<p>
		<a style="float:right; margin:0px 10px;" href="#" class="dodelete button">Remove Entry</a>
		<br />
	</p>
	
	<?php $mb->the_group_close(); ?>
	<?php endwhile; ?>

	<p>
		<a href="#" class="docopy-airdate_group button">Add Air Date</a> 
		<input type="submit" class="button-primary" name="save" value="Save">
	</p>
</div>

<script>

jQuery(function() {

jQuery( ".datepicker" ).datepicker();

});

</script>

<!-- <script type="text/javascript">
//<![CDATA[
 
jQuery(function($) {
        $.wpalchemy.bind('wpa_copy', function(the_clone) {
                $('.datepicker', the_clone).css('display','none');
                //console.log(the_clone);
        });
});
 
//]]>
</script> -->
