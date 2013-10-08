<?php get_header(); ?>

<div class="whatpageisthis">home.php</div>		
	<!-- <div id="enable_javascript">Please enable your javascript to have a better view of the website. Click <a href="http://activatejavascript.org">here</a> to learn more about it.</div> -->
	<div class="container">
        <div class="row">	
            <div class="span8" id="content">

				<?php
					$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
					$args = array(
					  'paged' => $paged,
					  'ignore_sticky_posts' =>1,
					  'orderby' => 'date',
					  'order' => 'DESC'
					);
					
					query_posts($args); 
				?>

				<?php
				if (have_posts()) : while (have_posts()) : the_post();
				
				   if(!get_post_format()) {
				               get_template_part('format', 'standard');
			         } else {
				               get_template_part('format', get_post_format());
				          }

					endwhile;
					posts_nav_link();
					wp_reset_query();
					endif;
									     
					?>
					    
    		</div><!--#content .span8 -->
			<?php get_sidebar(); ?>
		</div><!-- row -->
	</div><!-- container -->
<?php get_footer(); ?>