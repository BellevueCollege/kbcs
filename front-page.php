<?php
get_header();
?>
<div class="whatpageisthis">front-page.php</div>
<div class="container">
	<div class="row">
	<h1 class="title sr-only">KBCS - Home</h1>
		<main class="span8" id="content">
			<section label="On-Air">
				<div id="hero-onair">On air</div>
					<div id="hero-block" class="loading">
						<div class="row-fluid" id="hero-text-wrapper">
							<div class="loading">Loading...</div>
							<div class="span9" id="hero-text">
								<div class="inner">
									<h2 id="hero-title"></h2>
									<p id="hero-host" class="hostedby"></p>
									<p id="hero-airtimes" class="program-days-times"></p>
									<ul id="hero-links">
										<li>
											<a href="https://www.radiorethink.com/tuner/?stationCode=kbcs&stream=hi" class="streamlive" onClick="gaplusu('send', 'event', 'Outbound', 'Homepage Jumbotron', 'Live Stream');">
												<i class="icon-volume-up"></i>Listen live
											</a>
										</li>
										<li>
											<a href="<?php echo home_url(); ?>/live-playlist/">
												<i class="icon-th-list"></i>View Playlist
											</a>
										</li>
										<li>
											<a id="hero-link" href="" title="">
												<i class="icon-list-alt"></i>View Program page
											</a>
										</li>
									</ul>
								</div> <!-- inner -->
							</div> <!-- hero-text -->
						</div> <!-- row-fluid -->
						<div id="hero-image">
							<img src="<?php echo get_stylesheet_directory_uri(); ?>/img/program-hero-generic.jpg" alt="photo of cds in KBCS library" />
						</div> <!-- hero-image -->
					</div> <!-- hero-block -->
					<ul id="hero-past-future" class="loading">
						<li id="hero-past">
							<a id="hero-past-link" href="">
								<p class="inner">
									<em><span class="corner"></span>Last Show</em>
									<span id="hero-past-time"></span>
									<span id="hero-past-title"></span>
								</p>
							</a>
						</li>
						<li id="hero-future">
							<a id="hero-future-link" href="">
								<p class="inner">
									<em><span class="corner"></span>Next Show</em>
									<span id="hero-future-time"></span>
									<span id="hero-future-title"></span>
								</p>
							</a>
						</li>
					</ul>
					<p id="schedulelink"><a href="program/"><i class="icon-calendar"></i>Weekly Schedule</a></p>
			</section> <!-- On-Air -->
			<?php
			$sticky = get_option( 'sticky_posts' );
			$args = array(
				'post_type' => 'post',
				'order_by'=> 'date',
				'order' => 'DESC',
				'post__in'  =>  $sticky,
				'category_name' => 'home-featured',
				'post_status' => 'publish'
			);

			$loop = new WP_Query( $args );
			while ( $loop->have_posts() ) : $loop->the_post();

			if ( $sticky ) {
			?>
			<article class="media"> 
				<h2 <?php post_class() ?>><a href="<?php the_permalink(); ?>"><?php the_title();?></a></h2>
				<div class="pull-left" ?>">
				<?php
					if ( has_post_thumbnail() ) {
						the_post_thumbnail( 'thumbnail', array( 'class' => 'media-object' ) );
							if( get_post( get_post_thumbnail_id() )->post_excerpt ) { ?>
					<span class="featured-caption media-object"><?php echo get_post( get_post_thumbnail_id() )->post_excerpt ?></span>
							<?php } ?>
					<?php } ?>
				</div>
				<div class="media-body">
					<div class="media-content">
						<p><small><?php the_time( 'F j, Y' ); ?> - <?php the_time( 'g:i a' ); ?></small></p>
						<?php the_excerpt(); ?>
					</div> <!-- media-content -->
					<?php if ( ! is_single( $post ) ) { ?>
					<?php } ?>
				</div> <!-- media-body -->
			</article> <!-- media -->
			
			<?php
			}
			endwhile;
			wp_reset_postdata();

			$args = array(
				'post_type' => 'post',
				'order_by'=> 'date',
				'order' => 'DESC',
				'post__not_in' => get_option( 'sticky_posts' ),
				'ignore_sticky_posts' => 1,
				'category_name' => 'home-featured',
				'post_status' => 'publish'
			);

			$loop = new WP_Query( $args );
			while ( $loop->have_posts() ) : $loop->the_post();

			if( get_post_format() ) {
				get_template_part( 'format', get_post_format() );
			} else {
				get_template_part( 'format', 'standard' );
			}

			endwhile;
			wp_reset_postdata();
			?>
		</main> <!-- content -->
		<?php get_sidebar(); ?>
	</div> <!-- row -->
</div> <!-- container -->
<script type="text/javascript">
	jQuery(function() { jQuery("#hero-past-future .title").equalHeights(); });
</script>
<?php get_footer(); ?>
