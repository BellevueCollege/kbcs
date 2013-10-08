<?php

/** *
 * Template Name: Home Page
 *

 */
 
 get_header(); ?>

	<div class="container">




		<div class="row">
			<?php get_sidebar(); // sidebar 1 ?>

			<div class="span8 results-list ">
						<ul>

							<?php 
								// Create a new instance
			
			
								$newsPosts = new WP_Query();
				                $newsPosts->query( array(
				                	'showposts'=>3, 
				                	'post_type'=>'blog',// only query News post type
				                	'order_by'=> 'date',
				                	'post_status' => 'publish', 
				                	'offset'=>'0',
									//'relation' => 'AND',
				                	//'tax_query'=> array( 
				                	//	array(
				                	//		'taxonomy'  => 'news_type', 
				                	//		'field' => 'id', 
				                	//		'terms' => '204', // exclude media posts in the news-cat custom taxonomy 
				                	//		'operator'  => 'NOT IN'),
				                	//		), 
				                		) 
				                	);
				                	
								// The Loop
									while ($newsPosts->have_posts()) : $newsPosts->the_post(); // loop for posts
							?>
						<h2 <?php post_class() ?>>							
							<a href="<?php the_permalink(); ?>"><?php the_title();?></a>
						</h2>
							<p class="news-thumb"><a href="<?php the_permalink(); ?>"><?php the_post_thumbnail(); ?></a></p>
							<p><?php echo get_the_excerpt(); ?></p>
							<!-- <p style="color: green;"><?php echo get_permalink(); ?></p> -->
								<p class="results-meta">
									<small>
									<i class="results-meta-date"></i>
									&nbsp; Published: <?php the_time(get_option('date_format')); ?>
									</small>
								</p>
						
						<hr />
							<?php endwhile; ?>
							<?php	wp_reset_postdata(); ?>


							</ul>

			</div><!-- span8 -->
		</div><!-- row -->
</div><!-- container -->          
<?php get_footer(); ?>