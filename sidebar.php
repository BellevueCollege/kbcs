<?php
### Sidebar - Contains Sub Page navigation
### Automatically appears if sub-nav exists
?>
<aside class="sidebar span4">
	<div class="navbar sidebar-audio-buttons hidden-phone">
		<div class="navbar-inner">
			<div class="container">
				<ul class="nav">
					<li>
						<a href="https://www.radiorethink.com/tuner/?stationCode=kbcs&stream=hi" class="streamlive" onClick="gaplusu('send', 'event', 'Outbound', 'Sidebar', 'Live Stream');"><i class="icon-volume-up"></i> Live Stream</a>
					</li>
					<li>
						<a href="//kbcs.fm/program/">Audio & Playlist Archives</a>
					</li>
				</ul><!-- nav -->
			</div><!-- container -->
		</div><!-- navbar-inner -->
	</div><!-- navbar now-playing -->

	<div style="width:100%; border: 1px solid #ddd">
		<div class="nowplaying hidden-phone">
			<strong><a href="<?php echo home_url(); ?>/live-playlist/">Now Playing</a>:</strong>
		</div> <!--#nowplaying-->

		<iframe src="//widgets.spinitron.com/widget/now-playing-v2?station=kbcs&num=5&sharing=1&cover=1&player=1&merch=0&non-music=1" width="100%" frameborder="0" allow="encrypted-media"></iframe>
	</div>

	<div id="social-links">
		<div role ="button">
			<a class="btn btn-primary btn-block" href="https://www.facebook.com/KBCSBellevueSeattle"><i class="icon-facebook"></i> Facebook</a>
		</div>
		<div role="button">
			<a class="btn btn-info btn-block" href="https://twitter.com/KBCS"><i class="icon-twitter"></i> Twitter</a>
		</div>
		<div role="button">
			<a class="btn btn-default btn-block" href="https://bellevuecollegefoundation.thankyou4caring.org/kbcs/email_communication">Newsletter</a>
		</div>
	</div>
	<?php
	$args = array(
		'post_type' => 'ads',
		'post_status' => 'publish',
		'posts_per_page' => 1,
		'orderby' => 'date',
		'order' => 'ASC'
		
	);
	$query = new WP_Query( $args );

	while ( $query->have_posts() ) : $query->the_post(); ?>
		<div role= id="ad-manager">
			<a href="<?php echo get_post_meta(get_the_id(), '_links_to', true);?>">
				<?php echo the_post_thumbnail("sidebar-ad"); ?>
			</a>
			<small style="display: block;">KBCS thanks our sponsors</small>
		</div><!-- ad-manager -->

	<?php endwhile; 
	wp_reset_postdata(); ?>
	<?php dynamic_sidebar( 'Events Widget Area' ); ?>

	<?php dynamic_sidebar( 'Sidebar Bottom' ); ?>
</aside><!-- sidebar span4 -->
