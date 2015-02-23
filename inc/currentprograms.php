<?php
// Functiosn related to finding current program on air, last program and upcoming programs


function getMetaKey($day)
{
	$metaKey = "";
	switch($day)
	{

		case 'monday':
				$metaKey = "onair_monday";
				break;
		case 'tuesday':
				$metaKey = "onair_tuesday";
				break;
		case 'wednesday':
				$metaKey = "onair_wednesday";
				break;
		case 'thursday':
				$metaKey = "onair_thursday";
				break;
		case 'friday':
				$metaKey = "onair_friday";
				break;
		case 'saturday':								
				$metaKey = "onair_saturday";
				break;
		case 'sunday':
				$metaKey = "onair_sunday";
				break;
	}
	return $metaKey;
}



function postData( $day_meta_key, &$currentPostId, &$lastPostId, &$futurePostId
) {
	global $wpdb;
	$sql = 'SELECT wp.post_id, ' .
		'wp.meta_value as starttime, ' .
		'wpp2.meta_value as endtime, ' .
		'wpo.post_title ' .
		'FROM `wp_postmeta` AS wp, wp_postmeta AS wpp2, wp_posts AS wpo ' .
		"WHERE wpo.id=wp.post_id AND (wp.meta_key='onair_starttime') AND " .
		'wp.post_id in ' .
			'(SELECT wpp.post_id FROM ' .
			"wp_postmeta AS wpp WHERE wpp.meta_key='$day_meta_key') " .
		'AND ' .
			"(wpp2.meta_key = 'onair_endtime' AND wpp2.post_id = wp.post_id)";

	$post_data = $wpdb->get_results( $sql );
	$currentPost_starttime = '';
	$currentPost_endtime = '';
	$currentTime = strtotime( date( 'G:i' ) );
	$midnight = strtotime( '00:00' ); // its always the least
	for ( $i = 0; $i < count( $post_data ); $i++ ) {
		$postId = $post_data[ $i ]->post_id;
		$startTime = strtotime( $post_data[ $i ]->starttime );
		$endTime = strtotime( $post_data[ $i ]->endtime );
		$postTitle = $post_data[ $i ]->post_title;
		if ( ( $currentTime >= $startTime && $currentTime <= $endTime )
			|| ( $currentTime >= $startTime && $endTime == $midnight ) )
		{
			$currentPostId = $postId;
			$currentPost_starttime = $startTime;
			$currentPost_endtime = $endTime;
			break;
		}
	}

	$flag_nextday = 0;
	$flag_pastday = 0;

	//For future post falling on next day
	if ( $currentPost_endtime == $midnight ) {
		$next_day = strtolower( date( 'l', strtotime( 'tomorrow' ) ) );
		$meta_key = getMetaKey( $next_day );
		$sql = 'SELECT wpp.post_id, wpp.meta_value ' .
			'FROM wp_postmeta AS wpp ' .
			"WHERE wpp.meta_key = 'onair_starttime' " .
			'AND wpp.post_id IN ' .
				'(SELECT wp.post_id ' .
				'FROM wp_postmeta AS wp ' .
				"WHERE wp.meta_key = '$meta_key')" .
			'ORDER BY wpp.meta_value ASC limit 1';
		$next_post = $wpdb->get_results( $sql );
		$futurePostId = $next_post[0]->post_id;
		$flag_nextday = 1;
	}

	//For past post falling on previous day
	if ( $currentPost_starttime == $midnight ) {
		$previous_day = strtolower( date( 'l', strtotime( 'yesterday' ) ) );
		$meta_key = getMetaKey( $previous_day );
		$sql = 'SELECT wpp.post_id, wpp.meta_value ' .
			'FROM wp_postmeta AS wpp ' .
			"WHERE wpp.meta_key = 'onair_starttime' " .
			'AND wpp.post_id IN ' .
				'(SELECT wp.post_id ' .
				'FROM wp_postmeta AS wp ' .
				"WHERE wp.meta_key = '$meta_key')" .
			'ORDER BY wpp.meta_value DESC limit 1';
		$last_post = $wpdb->get_results( $sql );
		$lastPostId = $last_post[0]->post_id;
		$flag_pastday = 1;
	}

	for ( $i = 0; $i < count( $post_data ); $i++ ) {
		$postId = $post_data[ $i ]->post_id;
		$startTime = strtotime( $post_data[ $i ]->starttime );
		$endTime = strtotime( $post_data[ $i ]->endtime );
		$postTitle = $post_data[ $i ]->post_title;

		// Last post
		if ( $endTime == $currentPost_starttime && $flag_pastday == 0 ) {
			$lastPostId = $postId;
		}

		//Future post
		if ( $currentPost_endtime == $startTime && $flag_nextday == 0 ) {
			$futurePostId = $postId;
		}
	}
}
	
	function airTimeForGivenPost($postid)
	{
		$airdays = "";
		//$airdaysOld = $airdays;
		$onair_starttime = "";
		$onair_endtime = "";
		//$counter = "1";
		//$return_string = "";
		$onair_mon = get_post_meta($postid, 'onair_monday', TRUE);
		$onair_tue = get_post_meta($postid, 'onair_tuesday', TRUE);
		$onair_wed = get_post_meta($postid, 'onair_wednesday', TRUE);
		$onair_thu = get_post_meta($postid, 'onair_thursday', TRUE);
		$onair_fri = get_post_meta($postid, 'onair_friday', TRUE);
		$onair_sat = get_post_meta($postid, 'onair_saturday', TRUE);
		$onair_sun = get_post_meta($postid, 'onair_sunday', TRUE);
		$onair_starttime = get_post_meta($postid, 'onair_starttime', TRUE);
		$onair_endtime = get_post_meta($postid, 'onair_endtime', TRUE);
								
								
								

		if ( ! empty($onair_mon)) { 
		
			//weekday show or just mondays?
			if ( ! empty($onair_tue) && ! empty($onair_wed) && ! empty($onair_thu) && ! empty($onair_fri)){
				$airdays = 'Weekdays';
			} else {
				$airdays = 'Mondays';
			}
		
		 }
		if ( $airdays != "Weekdays") {
			// which weekdays?
			
			if (!empty($onair_tue)) 
			{ 
				$airdays .= (!empty($airdays))? ', Tuesdays' : 'Tuesdays' ; 
			}
			if (!empty($onair_wed)) 
			{ 
				$airdays .= (!empty($airdays))? ', Wednesdays' : 'Wednesdays' ; 
			}
			if (!empty($onair_thu)) 
			{ 
				$airdays .= (!empty($airdays))? ', Thursdays' : 'Thursdays' ; 
			}
			if (!empty($onair_fri)) 
			{ 
				$airdays .= (!empty($airdays))? ', Fridays' : 'Fridays' ; 
			}
			
		}
		
		if (!empty($onair_sat)) 
		{ 
			$airdays .= (!empty($airdays))? ', Saturdays' : 'Saturdays' ; 
		}
		if (!empty($onair_sun)) 
		{ 
			$airdays .= (!empty($airdays))? ', Sundays' : 'Sundays' ; 
		}
		
		
		
		if(!empty($airdays))
		{
			$airdays .= " ";
		//display time (different depending if it crosses over from am to pm
			$startmeridiem = (string)date("a", strtotime("{$onair_starttime}"));
			$endmeridiem = (string)date("a", strtotime("{$onair_endtime}"));
			
			
			//note, not displaying minutes in hour, yet.
			if ( $startmeridiem == $endmeridiem){
				$airdays .= date("g", strtotime("{$onair_starttime}")) . '-' . date("ga", strtotime("{$onair_endtime}"));
				//echo date("g", strtotime("{$onair_starttime} UTC")) . '-' . date("ga", strtotime("{$onair_endtime} UTC"));	
			} else {
				$airdays .= date("ga", strtotime("{$onair_starttime}")) . '-' . date("ga", strtotime("{$onair_endtime}"));
				//echo date("ga", strtotime("{$onair_starttime} UTC")) . '-' . date("ga", strtotime("{$onair_endtime} UTC"));
			}
		}
		
		return $airdays;
		//deal with multiple days/times and separators						
		//$counter++;	
	}


		function airTimings($postid)
		{

			global $wpdb;
			$sql = "
						select * from wp_postmeta as wpp where 
						wpp.meta_key='programid_mb' and 
						wpp.meta_value in (select wpp2.meta_value from wp_postmeta as wpp2 where wpp2.post_id='$postid' and wpp2.meta_key='programid_mb')
					";
			$data = $wpdb->get_results( $sql);
			$airTime = "";
			for($i=0;$i<count($data);$i++)
			{
				$timeT = airTimeForGivenPost($data[$i]->post_id);
				//echo "timeT:".$timeT;
				if(!empty($timeT))
				{
					if($airTime!="")
					{
						$airTime .=	", ".$timeT  ;
					}
					else
						$airTime .=	$timeT ;
				}

				//if(substr_count($airTime,"Weekdays ") > 1 )
				//{
					$airTime = implode(" ",array_unique(explode(" ",$airTime)));
				//}
				//$airTime = implode(' ,',array_unique(explode(' ', str_replace(",", "", $airTime))));
				//echo $timeT;

			}
			return $airTime;
		}
		
	
?>
