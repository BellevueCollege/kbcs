<?php

/** *
 * Template Name: Schedule Page
 *

 */
 
 get_header(); ?>
	<div class="container">
		<div class="row">
			<?php //get_sidebar(); // sidebar 1 ?>

			<div class="span8 results-list ">
				<h1>Schedule</h1>

					<?php
					$args = array(
						'post_type' => 'programs',
						'posts_per_page' => -1,
						//'meta_key' => 'onairstarttime',
						//'orderby' => 'meta_value',
						'order' => 'ASC',
						);
					
					$query = new WP_Query( $args ); ?>

						<table>
							<tr>
								<th>&nbsp;</th>								
								<th>Monday</th>								
								<th>Tuesday</th>								
								<th>Wednesday</th>								
								<th>Thursday</th>								
								<th>Friday</th>								
								<th>Saturday</th>								
								<th>Sunday</th>								
							</tr>
							<tr>
								<td>
								
								</td>
							</tr>
						<?php while ( $query->have_posts() ) : $query->the_post(); ?>							
		
								<td>
									<?php 
										//$prog_start_time = get_post_meta($post->ID, 'onairstarttime', true);
										//$prog_start_time_formatted = date("g:i a", strtotime("{$prog_start_time} UTC"));
										
										//echo $prog_start_time_formatted 
									?> 
								</td>

								<td>
									<?php //the_title(); ?>
								</td>
								
								<td>
								</td>
								
								<td>
								
<?php 
/*
				$key="onaircheckbox_group";

				if(get_post_meta($post->ID, $key, true))

				{?>

				<span class="label">On Air:</span> 

				<?php  

				echo get_post_meta($post->ID, $key, true);

				} ?><br />
		
		*/
		?>		
												
								<?php
								/* 
										$prog_start_time = get_post_meta($post->ID, 'onairstarttime', true);
										$prog_start_time_formatted = date("g:i a", strtotime("{$prog_start_time} UTC"));
										$prog_end_time = get_post_meta($post->ID, 'onairendtime', true);
										$prog_end_time_formatted = date("g:i a", strtotime("{$prog_end_time} UTC"));
								$value = get_post_meta($post->ID, 'onaircheckbox_group', true);

									if($value == 'Monday') {
										echo $prog_start_time_formatted ?> - <?php $prog_end_time_formatted ?> |  <?php the_title(); ?>;
<?php
									} elseif($value == 'sleeping') {
										echo '<a href="http://domain.tld/sleeping/">Nap Supplies</a>';
									} elseif($value == 'eating') {
										echo '<a href="http://domain.tld/eating/">Dieting Advice</a>';
									} else {
										echo 'fail';
									}

	
?>



				*/						
			?>							
										
<?php
//$custom = get_post_meta($post->ID, 'onaircheckbox_group', true);
//echo $custom[0];
?>

								</td>

	 
									
<?php	
/*

$onair = get_post_meta($post->ID, 'onaircheckbox_group', true);

	if ($onair) { ?>
		<?php foreach($onair as $airing) { ?>
			<span><?php echo  $airing; ?></span> | 
		<?php } 
	} ?>
										
*/
?>

<?php
/*
if ( !empty( $person ) ) {
  foreach ( $person as $cast ) {
    echo "<li>$cast</li>";
  }
} else {
  echo "<li>This play has no cast members.</li>";
}
*/
?>
										
<?php 
	$post_meta_data = get_post_custom($post->ID);
	$custom_checkbox_group = unserialize($post_meta_data['onaircheckbox_group'][0]); 																			
	
	    echo '<ul class="custom_repeatable">';  
    foreach ($custom_checkbox_group as $string){  
        echo '<li>'.$string. the_title(); '</li>';  
    }  
    echo '</ul>';  
?>	 
	 								
								
								</td>
							</tr>
					<?php endwhile; ?>
						</table>
					<?php // Reset Post Data
						wp_reset_postdata();
					
					?>


<?php
$post_meta_data = get_post_custom($post->ID); 
echo $post_meta_data;

?>

			</div><!-- span8 -->
		</div><!-- row -->
</div><!-- container -->          
<?php get_footer(); ?>