<?php
/************************************************************


		THIS FILE AND ASSOCIATED CPT NEEDS TO BE DELETED


 *********************************************************/

get_header(); ?>

single-programs				

<?php while ( have_posts() ) : the_post(); ?>

		<div class="container">
			<div class="row content">					
				<div class="span8 single-news">

					<div class="content-padding-left-right-extra">
	 					<h1><?php the_title();?></h1>
	
		           	 	<?php the_content();?>
	
	
						<hr />	
	
						<div class="clearfix"></div>
	
								<p class="results-meta">
									<small><?php echo get_the_term_list( $post->ID, 'hosts', '<i class="meta-host"></i>&nbsp;Host: ', ', ', '' ); ?>
									</small>
								</p>
								
								<p>
								<span class="target-date">Air Date: <?php echo get_post_meta($post->ID, '_datepicker', true); ?></span>

								</p>
	
						<?php endwhile; // end of the loop. ?>
	
	
						<?php //comments_template(); ?>
						
						<div class="episode-list">
							<?php 
							
								$args = array( 'post_type' => 'episodes', 'posts_per_page' => 10, 'order_by'=> 'date', 'post_status' => 'publish' );
								$loop = new WP_Query( $args );
								while ( $loop->have_posts() ) : $loop->the_post();
							?>
								<ul>
									<li></li>
								</ul>
							<?php endwhile; ?>
						</div>
	
						<div class="clearfix"></div>
	
						<hr />
					</div><!-- content-padding -->
				</div><!-- /.span8 -->
				
				<?php get_sidebar(); ?>
      	
      	</div><!-- row content -->
      	<!-- container ends in sidebar-news.php -->


<?php get_footer(); ?>