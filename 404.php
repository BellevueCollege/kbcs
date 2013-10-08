<?php get_header(); ?>

<div class="row">
	<div class="span8" id="content">
        	<div class="row">
            	<div class="span4">
                	<div id="error404-goodnews">
                    	<h1 class="entry-title">Great News</h1> 
                    	<p>The Puppy is Not Lost!</p>
                    </div><!--#404goodnews-->
                    <div id="error404-badnews">
                    	<h2>Bad News</h2>
                    	<p>The page you were looking for could not be found.</p>
                    </div><!-- #404badnews -->
                </div> <!--.span4-->
                <div class="span4 cut-gutter-left">
                	
                	<img src="<?php bloginfo('stylesheet_directory'); ?>/img/ocalla.jpg" alt="Ocalla" />
                   
                </div><!--.span4-->
                
            </div> <!-- .row -->
            
            <div class="well">
            <p><strong>Here are some hints to help you find what you were looking for:</strong></p>
            <ul>
                <li> search for what you were looking for</li>
                <li> use the navigation links above</li>
                <li> if you typed the web address, make sure you typed it correctly</li>
            </ul>
			</div>
	</div><!-- #content span8 -->
	<?php get_sidebar(); ?>
</div><!-- row -->

<?php get_footer(); ?>