<?php 
/**
 * Template Name: Single Event 
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 */


global $booking, $wpdb, $wp_query;
get_header();
?>
<div class="whatpageisthis">page.php</div>

<div class="row">
	<div class="span8" id="content">
				<h2><?php the_title(); ?></h2>
				<?php if ( !have_posts() ) : ?>
					<p><?php $event_ptype = get_post_type_object( 'incsub_event' ); echo $event_ptype->labels->not_found; ?></p>
				<?php else: ?>
					<div class="wpmudevevents-list">
				   
					<?php while ( have_posts() ) : the_post(); ?>
						<div>
							<?php echo get_the_content(); ?>
						</div>
						
						<div class="event <?php echo Eab_Template::get_status_class($post); ?>">
							<?php echo my_custom_get_event_details($post); ?>
						</div>
					<?php endwhile; ?>
					</div>
				<?php endif; ?>
			<?php posts_nav_link(); ?>
	</div><!-- span8  #content -->
    
	<?php get_sidebar(); // sidebar 1 ?>

</div><!-- row -->
<?php
get_footer();

// Customize Events Plus functionality by overriding default functions
// Most functions are in /lib/class_eab_template.php
 
function my_custom_get_event_details ($post) {
	$content = '';
	$data = Eab_Options::get_instance();
	$event = ($post instanceof Eab_EventModel) ? $post : new Eab_EventModel($post);
	
	$content .= '<div class="wpmudevevents-date-custom">' . my_custom_get_event_dates($event) . '</div>';
 
	if ($event->has_venue()) {
		$venue = $event->get_venue_location(Eab_EventModel::VENUE_AS_ADDRESS);
		$content .= "<div class='wpmudevevents-location'>{$venue}</div>";
	}
	if ($event->is_premium()) {
		$price = $event->get_price();
		$currency = $data->get_option('currency');
		$amount = is_numeric($price) ? number_format($price, 2) : $price;
		$content .= apply_filters('eab-events-event_details-price', "<div class='wpmudevevents-price'>{$currency} {$amount}</div>", $event->get_id());
	}
	$data = apply_filters('eab-events-after_event_details', '', $event);
	if ($data) {
		$content .= '<div class="wpmudevevents-additional_details">' . $data . '</div>';
	}
	
	return $content;
}
 
 
function my_custom_get_event_dates ($post) {
		$content = '';
		$event = ($post instanceof Eab_EventModel) ? $post : new Eab_EventModel($post);

		$start_dates = $event->get_start_dates();
		if (!$start_dates) return $content;
		foreach ($start_dates as $key => $start) {
			$start = $event->get_start_timestamp($key);
			$end = $event->get_end_timestamp($key);

			$end_date_str = (date('Y-m-d', $start) != date('Y-m-d', $end))
				? date_i18n(get_option('date_format'), $end) : ''
			;

			$content .= $key ? __(' and ', Eab_EventsHub::TEXT_DOMAIN) : '';

			// Differentiate start/end date equality
			if ($end_date_str) {
				// Start and end day stamps differ
				$start_string = $event->has_no_start_time($key)
					? sprintf(__('On <span class="wpmudevevents-date_format-start">%s</span>', Eab_EventsHub::TEXT_DOMAIN), date_i18n(get_option('date_format'), $start))
					: sprintf(__('On %s <span class="wpmudevevents-date_format-start">from %s</span>', Eab_EventsHub::TEXT_DOMAIN), date_i18n(get_option('date_format'), $start), date_i18n(get_option('time_format'), $start))
				;
				$end_string = $event->has_no_end_time($key)
					? sprintf(__('<span class="wpmudevevents-date_format-end">to %s</span><br />', Eab_EventsHub::TEXT_DOMAIN), '<span class="wpmudevevents-date_format-end_date">' . $end_date_str . '</span>')
					: sprintf(__('<span class="wpmudevevents-date_format-end">to %s</span><br />', Eab_EventsHub::TEXT_DOMAIN), '<span class="wpmudevevents-date_format-end_date">' . $end_date_str . '</span> <span class="wpmudevevents-date_format-end_time">' . date_i18n(get_option('time_format'), $end) . '</span>')
				;
			} else {
				// The start and end day stamps do NOT differ
				if (eab_current_time() > $start) {
					// In the past
					$start_string = $event->has_no_start_time($key)
						? sprintf(__('Took place on <span class="wpmudevevents-date_format-start">%s</span>', Eab_EventsHub::TEXT_DOMAIN), date_i18n(get_option('date_format'), $start))
						: sprintf(__('Took place on %s <span class="wpmudevevents-date_format-start">from %s</span>', Eab_EventsHub::TEXT_DOMAIN), date_i18n(get_option('date_format'), $start), date_i18n(get_option('time_format'), $start))
					;
				} else {
					// Now, or in the future
					$start_string = $event->has_no_start_time($key)
						? sprintf(__('<div class="wpmudevevents-date_format-start">%s</div>', Eab_EventsHub::TEXT_DOMAIN), date_i18n(get_option('date_format'), $start))
						: sprintf(__('<div class="wpmudevevents-date_format-start">%s</div>', Eab_EventsHub::TEXT_DOMAIN), date_i18n(get_option('date_format'), $start), date_i18n(get_option('time_format'), $start))
					;
				}
				$end_string = $event->has_no_end_time($key)
					? ''
					: sprintf(__('<span class="wpmudevevents-date_format-end">to %s</span><br />', Eab_EventsHub::TEXT_DOMAIN), '<span class="wpmudevevents-date_format-end_date">' . $end_date_str . '</span> <span class="wpmudevevents-date_format-end_time">' . date_i18n(get_option('time_format'), $end) . '</span>')
				;
			}
			$content .= apply_filters('eab-events-event_date_string', "{$start_string} {$end_string}", $event->get_id(), $start, $end);
			/*
			$content .= apply_filters('eab-events-event_date_string', sprintf(
				__('On %s <span class="wpmudevevents-date_format-start">from %s</span> <span class="wpmudevevents-date_format-end">to %s</span><br />', Eab_EventsHub::TEXT_DOMAIN),
				'<span class="wpmudevevents-date_format-start_date">' . date_i18n(get_option('date_format'), $start) . '</span>',
				'<span class="wpmudevevents-date_format-start_time">' . date_i18n(get_option('time_format'), $start) . '</span>',
				'<span class="wpmudevevents-date_format-end_date">' . $end_date_str . '</span> <span class="wpmudevevents-date_format-end_time">' . date_i18n(get_option('time_format'), $end) . '</span>'
			), $event->get_id(), $start, $end);
			*/
		}
		return $content;
	}