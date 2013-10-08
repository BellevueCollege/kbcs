<?php
/**
 * Template Name: Car Donation
 *
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 */
  get_header(); ?>
<div class="whatpageisthis">template-car-donation.php</div>

<div class="row">
	<div class="span8" id="content">
		<?php while ( have_posts() ) : the_post(); ?>
		
        	<h1><?php the_title();?></h1>
		<p><a href="#faq" class="btn"><i class="icon-circle-arrow-down"></i> Car donation FAQ's</a></p>	
            <h2>Donation Form</h2>
            
      <iframe id="CarDonationsFrame" src ="" width="100%" height="530px" frameborder="0" seamless="seamless">
          <p>If you are seeing this message then your browser does not work with this donation form, so please 
        please call us directly to arrange your donation. We are sorry for this inconvenience.</p>
        </iframe>
      <script type="text/javascript">
          document.getElementById("CarDonationsFrame").src = "http://centerforcardonations.com/charitydonation.html?domain=" + document.domain;
        </script>

			<br id="faq" />
            <h2>Frequently Asked Questions</h2>
			<?php
           
			the_content();
			
			
		endwhile;

     
?>
        
  </div><!-- span8  #content -->
    
	<?php get_sidebar(); // sidebar 1 ?>

</div><!-- row -->


<?php get_footer(); ?>