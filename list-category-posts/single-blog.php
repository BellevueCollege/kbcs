<div class="whatpageisthis">list-category-posts/single-blog.php</div>	
<div class="span8 lcat" id="content">


		<?php 
			$query = new WP_Query( array(
				'category' => '',
				'posts_per_page' => 10,
                'post_type' => 'blog',
                'category_name' => 'news-and-ideas'
            ) ); 
		?>
		<?php 
		if ( have_posts() ) : while ( have_posts() ) : the_post(); 

		if(!get_post_format()) {
				               get_template_part('format', 'standard');
			         } else {
				               get_template_part('format', get_post_format());
				          }

					endwhile;
					posts_nav_link();
					wp_reset_query();
					endif; ?>


</div><!--#content .span8 -->