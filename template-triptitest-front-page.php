<?php

/**
 * Template Name: Homepage tripti test
 *
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 */
 
 
 
get_header(); 





?>

<div class="whatpageisthis">front-page.php</div>
	
    <div class="container">
		<div class="row">
			<div class="span8" id="content">

				<?php 
					
					date_default_timezone_set('America/Los_Angeles');
					$day = strtolower(date('l'));
					
					$meta_key_day = getMetaKey($day);
					echo "\nday :".$meta_key_day;
					$currentPostId = "";
					$lastPostId = "";
					$futurePostId = "";
					
					$post_data = postData($meta_key_day, &$currentPostId, &$lastPostId, &$futurePostId);
					echo " \ncurrent post :".$currentPostId;
					echo " \nPast post :".$lastPostId;
					echo " \nFuture post id:".$futurePostId;
					
					?>

			</div><!-- #content span8 -->
	        <?php get_sidebar(); // sidebar 1 ?>
    	</div><!-- row -->
</div><!-- container -->          
<?php get_footer(); ?>

<?php
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



	function postData($day_meta_key,$currentPostId, $lastPostId, $futurePostId)
	{
		global $wpdb;
		$sql = "SELECT wp.post_id,wp.meta_value as starttime, wpp2.meta_value as endtime , wpo.post_title FROM `wp_postmeta` as wp,wp_postmeta as wpp2, wp_posts as wpo WHERE
				wpo.id=wp.post_id and
				(wp.meta_key='onair_starttime') and
				wp.post_id in 
				(
					select wpp.post_id from wp_postmeta as wpp where wpp.meta_key='$day_meta_key'
				) and
        		(wpp2.meta_key = 'onair_endtime' and wpp2.post_id = wp.post_id)	
				
				";

		$post_data = $wpdb->get_results( $sql);
		$currentPost_starttime = "";
		$currentPost_endtime = "";
		$currentTime = strtotime(date('G:i'));
		//$currentTime = strtotime("00:30");
		$midnight = strtotime("00:00");// its always the least 
		//echo "\ncurrent time:".$currentTime;
		for($i=0;$i<count($post_data);$i++)
		{
			$postId = $post_data[$i]->post_id;
			$startTime = strtotime($post_data[$i]->starttime);
			//echo "\n post id:".$postId;
			//echo "\n start time:".$startTime;
			$endTime = strtotime($post_data[$i]->endtime);
			//echo "\n end time :".$endTime;
			$postTitle = $post_data[$i]->post_title;
			if(($currentTime>=$startTime && $currentTime <= $endTime) || ($currentTime>=$startTime && $endTime == $midnight))
			{
				//This is the current post playing
				//echo "Current Post title :".$postTitle;

				$currentPostId = $postId ;
				//echo "current post id:".$currentPostId;
				$currentPost_starttime = $startTime;
				$currentPost_endtime = $endTime;
				break;
			}
			//else if()
		}
		
		$flag_nextday = 0;
		$flag_pastday = 0;
		

		if($currentPost_endtime == $midnight)//For future post falling on next day
		{
			$next_day = strtolower(date("l",strtotime("tomorrow")));
			//echo $next_day;
			$meta_key = getMetaKey($next_day);
			$sql = "select wpp.post_id,wpp.meta_value from wp_postmeta as wpp where wpp.meta_key = 'onair_starttime' and
			 wpp.post_id in (select wp.post_id from wp_postmeta as wp where wp.meta_key = '$meta_key')  order by wpp.meta_value ASC limit 1";
			 $next_post = $wpdb->get_results( $sql);
			 $futurePostId = $next_post[0]-> post_id;
			 //echo "Future post:".$futurePostId;
			 $flag_nextday = 1;
		}

		if($currentPost_starttime == $midnight)//For past post falling on previous day
		{
			$previous_day = strtolower(date("l",strtotime("yesterday")));
			$meta_key = getMetaKey($previous_day);
			$sql = "select wpp.post_id,wpp.meta_value from wp_postmeta as wpp where wpp.meta_key = 'onair_starttime' and
			 wpp.post_id in (select wp.post_id from wp_postmeta as wp where wp.meta_key = '$meta_key')  order by wpp.meta_value DESC limit 1";
			 $last_post = $wpdb->get_results( $sql);
			 $lastPostId = $last_post[0]-> post_id;
			 //echo "Past post id:".$lastPostId;
			 $flag_pastday = 1;
		}
		//echo "flag past :".$flag_pastday;
		//echo "future flag:".$flag_nextday;
		
		for($i=0;$i<count($post_data);$i++)
		{
			$postId = $post_data[$i]->post_id;
			$startTime = strtotime($post_data[$i]->starttime);
			$endTime = strtotime($post_data[$i]->endtime);
			$postTitle = $post_data[$i]->post_title;
			if($endTime == $currentPost_starttime && $flag_pastday == 0) // Last post
			{
				$lastPostId = $postId;
				//echo "Past post id:".$lastPostId;
			}

			if($currentPost_endtime == $startTime &&  $flag_nextday == 0)//Future post
			{
				$futurePostId = $postId;
				//echo "Future post:".$futurePostId;
			}
			
			
		}
		//return $myrows;
	}
?>