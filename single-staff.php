<?php
/**
 * Segment Post Template 
 */

get_header(); ?>
<div class="whatpageisthis">single-staff.php</div>	

<div class="container">
		<div class="row">
			<div class="span8" id="content">
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
					

					<?php

						function getPrograms($post_id)
						{
							global $wpdb;
							$sql = "select meta_value from wp_postmeta where `meta_key` LIKE  '_custom_post_type_onomies_relationship' and post_id = '$post_id'";
							$data = $wpdb->get_results($sql);
							$programs = array();
							for($i=0;$i<count($data);$i++)
							{
								$postid = $data[$i] -> meta_value;
								if(!empty($postid))
									$programs[] = get_the_title($postid);
						
							}
							if(count($programs)>0)
								$programs = implode(",", $programs);
							return $programs;
						
						}
						

						$programs= getPrograms($post->ID);
						if(count($programs)>0)
						{
							echo '<p class="host-of"> Hosts: '.$programs . '</p>' ; ?>
					
					<?php } ?>


                    <?php the_content(); ?>

                </div><!-- span9-->
                
            </div>		<!-- row-fluid-->	
                            
             <?php endwhile;  ?>               
							

					
			</div><!-- #content span8 -->
	        <?php get_sidebar(); // sidebar 1 ?>
    	</div><!-- row -->
</div><!-- container -->  



        
<?php get_footer(); ?>