</div>
		</div><!-- container footer-widgets -->
</div><!-- wrapper container -->

		<div class="container" id="foot">
			<div class="row">

				<div class="span3">
                	
                     <div class="vcard">
                         <div class="org"><h4><a class="url fn n" href="<?php echo home_url(); ?>/">KBCS Radio</a></h4></div>
                         
                         <div class="adr">
                              <div class="street-address">3000 Landerholm Circle SE</div>
                              <span class="locality">Bellevue</span>,
                              <span class="region">WA</span>
                              <span class="postal-code">98007-6406</span>
                         </div>
                     
                     	<ul>    
                            <li><a href="<?php echo home_url(); ?>/about/contact/"><strong>Contact Us</strong></a></li>
                            <li><a href="<?php echo home_url(); ?>/about/directions/"><strong>Map &amp; directions</strong></a></li>
                        </ul>
                   </div><!-- .vcard -->
				</div><!-- span3 -->
                
                <div class="span3">
					
                    <h4>Music Requests</h4>
                    <ul>
					<li><a href="mailto:dj@kbcs.fm">dj@kbcs.fm</a></li>
					<li>425-564-2424</li>
					</ul>
                    
                    
					<h4>Listener comments</h4>
					<ul>
                    <li><a href="mailto:listenercomment@kbcs.fm">listenercomment@kbcs.fm</a></li>
                    <li>425-564-2000</li></ul>
                   
					
					<h4>News Department</h4>
                    <ul>
					<li><a href="mailto:dj@kbcs.fm">news@kbcs.fm</a></li>
					<li>425-564-6195</li>
					</ul>
				</div><!-- span3 -->
	
	
				<div class="span3">
					<h4>Connect</h4>
					<ul>
						<li><a href="<?php echo home_url(); ?>/support/advertise/">Advertise</a></li>
                        <li><a href="<?php echo home_url(); ?>/donate/">Donate</a></li>
						<li><a href="<?php echo home_url(); ?>/support/volunteer/">Volunteer</a></li>
						<li><a href="<?php echo home_url(); ?>/support/">More...</a></li>
					</ul>
				</div><!-- span3 -->
	
	
				<div class="span3">
					<h4>Newsletter sign-up</h4>
                    <form method="get" action="<?php echo home_url(); ?>/about/newsletter/">
                    <div class="input-append">
                    <label for="email" class="hide">E-mail</label>
                    <input class="span2" name="email" aria-required="true" placeholder="enter e-mail" required="required" id="email" type="email" />
                    <input type="submit" value="Next" class="btn btn-inverse" />
                    </div>
                    </form> 
                    
                    <div id="bclogo">
                	
                	<p class="bc-service">91.3 KBCS is a public service at</p>
                    <a href="https://www.bellevuecollege.edu"><img src="<?php bloginfo('stylesheet_directory'); ?>/img/bellevuecollege.png" alt="Bellevue College" /></a></div> <!--bclogo-->
   
				</div><!-- span3 -->
			</div><!-- row -->
		
		</div><!-- footer .container -->

<?php wp_footer(); ?>

<!-- <?php
$kbcs_site_version = wp_get_theme();
echo $kbcs_site_version->Name . " theme version " . $kbcs_site_version->Version;
?>  -->

</body>
</html>