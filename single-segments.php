<?php
/**
 * Segment Post Template 
 */

get_header(); ?>
<div class="whatpageisthis">single-segments.php</div>	

<div class="container">
		<div class="row">
			<div class="span8" id="content">
            <?php while ( have_posts() ) : the_post(); ?>
            <h1><?php the_title();?></h1>
            
            <div class="row-fluid program-item">
                <div class="span3">
                    <?php if ( has_post_thumbnail() ) {  
                        the_post_thumbnail("programs-thumb");
                        
                    } else {
                        ?>
                        <?php $upload_dir = wp_upload_dir(); ?>

                            <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/program-hero-generic-180x150.jpg" alt="photo of cds in KBCS library" width="180" height="150" />
                        <?php	
                    }
                    ?>
                </div>
                <div class="span9">
                   
                     
                   
                        <?php the_content(); ?>

                   
                    
                </div><!-- span9-->
                
            </div>		<!-- row-fluid-->	
                            
             <?php endwhile;  ?>               
	
					<!--audio archives go here-->
					<div id="audio"></div><!--#episodes-->		
							

					
			</div><!-- #content span8 -->
	        <?php get_sidebar(); // sidebar 1 ?>
    	</div><!-- row -->
</div><!-- container -->  



        
<?php get_footer(); ?>