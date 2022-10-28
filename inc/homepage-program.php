<?php
/**
 * Class: Get Current Programs
 * 
 */
class Homepage_Program {
	public $programs_today;
	public $last_program_id;
	public $current_program_id;
	public $next_program_id;

	/**
	 * Get the meta key for the current day
	 *
	 * @param string $day The day of the week.
	 * @return string The meta key for the current day.
	 */
	public static function get_meta_key( $day ) {
		return 'onair_' . $day;
	}

	public static function get_meta_key_today() {
		$day = strtolower( date( 'l' ) );
		return self::get_meta_key( $day );
	}

	public static function get_day_from_meta_key( $meta_key, $capitalize = false ) {
		$day = ltrim( $meta_key, 'onair_' );
		return $capitalize ? ucfirst( $day ) : $day;
	}

	public static function timestamp_to_utc( $timestamp ) {
		$utc = new DateTimeZone('UTC');
		$date = new DateTime( date( 'Y-m-d H:i:s', $timestamp ), new DateTimeZone('America/Los_Angeles') );
		$date->setTimezone( $utc );
		return $date->format( 'U' );
	}

	/**
	 * Get Current Program ID
	 * 
	 * @param string $day_meta_key The meta key for the current day.
	 */
	public function get_program_ids( $day_meta_key ) {
		/**
		 * Query the Posts
		 */

		//build query args
		$args = array(
			'post_type' => 'programs',
			'post_status' => 'publish',
			'posts_per_page' => -1,
			'fields' => 'ids',
			'meta_query' => array(
				'relation' => 'AND',
				array(
					'key' => 'onair_starttime',
					'value' => '',
					'compare' => '!=',
				),
				array(
					'key' => 'onair_endtime',
					'value' => '',
					'compare' => '!=',
				),
				array(
					'key' => 'air_days',
					'value' => $day_meta_key,
					'compare' => 'LIKE',
				),
			),
			'orderby' => 'meta_value',
			'meta_key' => 'onair_starttime',
			'order' => 'ASC',
		);
		return get_posts( $args );
	}

	/**
	 * Get the current program
	 *
	 * @param string $day_meta_key The meta key for the current day (defaults to today).
	 * @return array The current program id, start time, and end time
	 */
	public function get_current_program( $day_meta_key = false ) {

		// Get the meta key for the current day.
		$day_meta_key = $day_meta_key ? $day_meta_key : self::get_meta_key_today();

		// Get the program IDs that may be relevant
		$program_ids = $this->get_program_ids( $day_meta_key );

		// Get Current Time and Midnight
		$now = current_time( 'timestamp' );
		$midnight = strtotime( 'midnight today', $now );

		// Find and output the current program as array
		foreach ( $program_ids as $id ) {

			// Get Start and End Times
			$start_time = get_field('onair_starttime', $id );
			$end_time   = get_field('onair_endtime', $id );
			$start_time = strtotime( $start_time, $now );
			$end_time = strtotime( $end_time, $now );

			if ( ( $now >= $start_time && $now < $end_time ) ||
				( $now >= $start_time && $end_time === $midnight ) ) {
				return array(
					'id' => $id, 
					'start_time' => $start_time,
					'end_time' => $end_time,
				);
			}
		}
		return false;
	}

	/**
	 * Get the next program
	 *
	 * @peram array $current_program The current program id, start time, and end time.
	 * @return array The next program id, start time, and end time
	 * 
	 */
	public function get_next_program( $current_program ) {
		// Get Current Time and Midnight
		$now = current_time( 'timestamp' );
		$midnight = strtotime( 'midnight today', $now );

		// If the current program is the last program of the day, get the first program of the next day.
		if ( $current_program[ 'end_time' ] === $midnight ) {
			$next_day = strtolower( date( 'l', strtotime( 'tomorrow', $now ) ) );
			$next_day_meta_key = self::get_meta_key( $next_day );

			$args = array(
				'post_type' => 'programs',
				'post_status' => 'publish',
				'posts_per_page' => 1,
				'fields' => 'ids',
				'meta_query' => array(
					'relation' => 'AND',
					array(
						'key' => 'onair_starttime',
						'value' => '',
						'compare' => '!=',
					),
					array(
						'key' => 'onair_endtime',
						'value' => '',
						'compare' => '!=',
					),
					array(
						'key' => 'air_days',
						'value' => next_day_meta_key,
						'compare' => 'LIKE',
					),
				),
				'orderby' => 'meta_value',
				'meta_key' => 'onair_starttime',
				'order' => 'ASC',
			);
			$id = get_posts( $args );
			$start_time = get_field('onair_starttime', $id );
			$end_time   = get_field('onair_endtime', $id );
			$start_time = strtotime( $start_time, $now );
			$end_time = strtotime( $end_time, $now );
			return array(
				'id' => $id, 
				'start_time' => $start_time,
				'end_time' => $end_time,
			);
		} else {
			// Get the next program in sequence
			$program_ids = $this->programs_today ?? $this->get_program_ids( self::get_meta_key_today() );
			
			foreach( $program_ids as $id ) {
				$start_time = get_field('onair_starttime', $id );
				$end_time   = get_field('onair_endtime', $id );
				$start_time = strtotime( $start_time, $now );
				$end_time = strtotime( $end_time, $now );
				if ( $start_time === $current_program[ 'end_time' ] ) {
					return array(
						'id' => $id, 
						'start_time' => $start_time,
						'end_time' => $end_time,
					);
				}
			}
		}

	}
	/**
	 * Get the last (previous) program
	 * 
	 * @peram array $current_program The current program id, start time, and end time.
	 * @return array The last program id, start time, and end time
	 */
	public function get_last_program( $current_program ) {
		// Get Current Time and Midnight
		$now = current_time( 'timestamp' );
		$midnight = strtotime( 'midnight today', $now );

		if ( $current_program[ 'start_time' ] === $midnight ) {
			$last_day = strtolower( date( 'l', strtotime( 'yesterday', $now ) ) );
			$last_day_meta_key = self::get_meta_key( $last_day );

			$args = array(
				'post_type' => 'programs',
				'post_status' => 'publish',
				'posts_per_page' => 1,
				'fields' => 'ids',
				'meta_query' => array(
					'relation' => 'AND',
					array(
						'key' => 'onair_starttime',
						'value' => '',
						'compare' => '!=',
					),
					array(
						'key' => 'onair_endtime',
						'value' => '',
						'compare' => '!=',
					),
					array(
						'key' => 'air_days',
						'value' => $last_day_meta_key,
						'compare' => 'LIKE',
					),
				),
				'orderby' => 'meta_value',
				'meta_key' => 'onair_starttime',
				'order' => 'DESC',
			);
			$id = get_posts( $args );
			$start_time = get_field('onair_starttime', $id );
			$end_time   = get_field('onair_endtime', $id );
			$start_time = strtotime( $start_time, $now );
			$end_time = strtotime( $end_time, $now );
			return array(
				'id' => $id, 
				'start_time' => $start_time,
				'end_time' => $end_time,
			);
		} else {
			// Get the next program in sequence
			$program_ids = $this->programs_today ?? $this->get_program_ids( self::get_meta_key_today() );
			
			foreach( $program_ids as $id ) {
				$start_time = get_field('onair_starttime', $id );
				$end_time   = get_field('onair_endtime', $id );
				$start_time = strtotime( $start_time, $now );
				$end_time = strtotime( $end_time, $now );
				if ( $end_time === $current_program[ 'start_time' ] ) {
					return array(
						'id' => $id, 
						'start_time' => $start_time,
						'end_time' => $end_time,
					);
				}
			}
		}

	}

	/**
	 * Get Program Airtimes by Program ID
	 * 
	 * @param int $id The program ID
	 * @return string The airtimes
	 */
	public static function get_airtimes_for_display( $id ) {
		$output_string = '';
		$program_ext_id = get_post_meta( $id, 'programid_mb', true );

		// Get programs that share the same external program id
		$args = array(
			'post_type' => 'programs',
			'post_status' => 'publish',
			'posts_per_page' => -1,
			'fields' => 'ids',
			'meta_query' => array(
				'relation' => 'AND',
				array(
					'key' => 'onair_starttime',
					'value' => '',
					'compare' => '!=',
				),
				array(
					'key' => 'onair_endtime',
					'value' => '',
					'compare' => '!=',
				),
				array(
					'key' => 'programid_mb',
					'value' => $program_ext_id,
					'compare' => '=',
				),
			),
			'orderby' => 'meta_value',
			'meta_key' => 'onair_starttime',
			'order' => 'ASC',
		);
		$airtime_ids = get_posts( $args );


		foreach ( $airtime_ids as $airtime_id ) {
			// Get the airtimes for each day
			$airdays = get_field( 'air_days', $airtime_id );
			$airdays = array_map( function( $day ) {
				return self::get_day_from_meta_key( $day );
			}, $airdays );

			// If the airdays array includes monday - friday, add 'Weekdays' to output string
			if ( in_array( 'monday', $airdays ) && in_array( 'tuesday', $airdays ) && in_array( 'wednesday', $airdays ) && in_array( 'thursday', $airdays ) && in_array( 'friday', $airdays ) ) {
				$output_string .= 'Weekdays, ';

				// Remove monday - friday from the airdays array
				$airdays = array_diff( $airdays, array( 'monday', 'tuesday', 'wednesday', 'thursday', 'friday' ) );
			}

			// Add each day to the output string
			foreach ( $airdays as $airday ) {
				$output_string .= ucfirst( $airday ) . 's, ';
			}

			// Remove trailing comma from output string
			$output_string = rtrim( $output_string, ', ' ) . ' ';

			// Add Times to output string
			$start_time = get_post_meta( $airtime_id, 'onair_starttime', true );
			$end_time   = get_post_meta( $airtime_id, 'onair_endtime', true );
			//display time (different depending if it crosses over from am to pm
			$startmeridiem = (string)date("a", strtotime("{$start_time}"));
			$endmeridiem = (string)date("a", strtotime("{$end_time}"));
			
			
			if ( $startmeridiem === $endmeridiem ) {
				$output_string .= date("g", strtotime("{$start_time}")) . '-' . date("ga", strtotime("{$end_time}"));
			} else {
				$output_string .= date("ga", strtotime("{$start_time}")) . '-' . date("ga", strtotime("{$end_time}"));
			}
			// Add comma between multiple airtimes
			$output_string .= ', ';
		}
		return rtrim( $output_string, ', ' );

	}
}
