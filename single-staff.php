<?php
/**
 * Segment Post Template 
 */

get_header(); ?>
<div class="whatpageisthis">single-staff.php</div>	

<div class="container">
		<div class="row">
			<main class="span8" id="content">
            <?php while ( have_posts() ) : the_post(); ?>
            <h1><?php the_title();?></h1>


            
            
            <div class="row-fluid program-item">
                <div class="span3">
                    <?php if ( has_post_thumbnail() ) {  
                        the_post_thumbnail("staff-thumbnail"); ?>
              			<span class="featured-caption media-object"><?php echo get_post( get_post_thumbnail_id() )->post_excerpt ?></span>
					<?php
                    } else {
                        echo '<img src="' . get_bloginfo( 'stylesheet_directory' ) . '/img/thumbnail-default.png" />';
                    }
                    ?>
                </div>
                <div class="span9">
					<?php
						if(get_post_meta($post->ID, 'staff_role', true !='')) {
							echo '<p class="staff-role">' . get_post_meta($post->ID, 'staff_role', TRUE) . '</p>'; ?>
							
							
					<?php } ?>

					<?php
						if(get_post_meta($post->ID, 'staff_email', true !='')) {
							echo '<p class="staff-email">' . get_post_meta($post->ID, 'staff_email', TRUE) . '</p>';?>
							
					<?php } ?> 
					<?php
						if(get_post_meta($post->ID, 'staff_phone', true !='')) {
							echo '<p class="staff-phone">' .get_post_meta($post->ID, 'staff_phone', TRUE) . '</p>'; ?>
							
							
					<?php } ?>

                    <?php the_content(); ?>

                </div><!-- span9-->
                
            </div>		<!-- row-fluid-->	
                            
             <?php endwhile;  ?>               
							

					
			</main><!-- #content span8 -->
	        <?php get_sidebar(); // sidebar 1 ?>
    	</div><!-- row -->
</div><!-- container -->  



        
<?php get_footer(); ?>