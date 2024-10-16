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
	<main class="span8" id="content">
		<?php while ( have_posts() ) : the_post(); ?>
		
			<h1><?php the_title();?></h1>
			<p><a href="#faq" class="btn"><i class="icon-circle-arrow-down"></i> Car donation FAQ's</a></p>	
			<h2>Donation Form</h2>
			<iframe src=" https://admin.charitableautoresources.com/Donate/CharityFormResponsive.aspx?CCD=BCS " frameborder="0" height="900" style="width: 100%;">
				<p>A browser that supports iframes is required to view the donation form. Since your browser does not support iframes, click on the following link to donate your car or other vehicle:
					<a href=" http://www.charitableautoresources.com/CarDonationInfo.aspx?CCD=BCS "></a></p>
			</iframe>

			<br id="faq" />
			<h2>Frequently Asked Questions</h2>
			<?php the_content();

		endwhile; ?>

	</main><!-- span8  #content -->

	<?php get_sidebar(); // sidebar 1 ?>

</div><!-- row -->


<?php get_footer(); ?>