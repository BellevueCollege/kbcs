<?php 
/**
 * Template Name: TEST Search Page
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 */
 

get_header(); ?>
<div class="whatpageisthis">search.php</div>
<div class="row">

	<div class="span8" id="content">
			<h1 class="search-page-title"><?php /* Search Count */ $allsearch = &new WP_Query("s=$s&posts_per_page=-1"); $key = esc_html($s, 1); $count = $allsearch->post_count; _e(''); _e('<span class="search-terms">"'); echo $key; _e('"</span>');?> Search Results <?php _e('<small class="hide"> ('); echo $count . ' '; _e('results)</small>'); wp_reset_query(); ?> </h1>

       <div id="playlist-results">
        	<?php
        	$count = $allsearch->post_count;
        	echo "count from wordpress:".$count; 
        	$searchParameter = $_GET["s"];
        	$url = "http://kbcsweb.bellevuecollege.edu/play/api/search/?title=".$searchParameter;
        	$wpQuerySearchResults  = $posts;
        	echo "count from my code :".count($posts);
        	exit();
        	$playlistResults = file_get_contents ($url);
        	$playlistResults = json_decode($playlistResults);
        	 
        	
        	$posts = array_merge($posts,$playlistResults);
        	//echo print_r($playlistResults,true);
        	//exit();

        	if(count($posts)<1)
        	{
        		?>
        		<div class="alert alert-block" id="no-search-results">
       				<h4>Oh, snap!</h4>
    				We couldn't find any pages or content with the keywords you searched for.
    			</div>
			<?php
        	}
        	else
        	{
	        	for($i=0;$i<count($posts);$i++)
	        	{
	        		//echo "\nplaylist id :".$posts[$i] -> playlistId;
	        		//echo "\npost id :".$posts[$i] -> ID;
	        		if(isset($posts[$i] -> ID) && !empty($posts[$i] -> ID))
	        		{
	        			//echo "SUGAR\n";
	        			?>
	        			<h3 class="search-result-item"><a href="<?php echo get_permalink($posts[$i] -> ID) ?>" rel="bookmark" title="Permanent Link to <?php  ?>"><?php echo get_the_title($posts[$i] -> ID); ?></a>
						</h3>
	                    <p class="search-item-description">
							<?php echo substr(strip_tags($posts[$i]->post_content), 0, 250);?>
						</p><!-- .search-item-description -->	
				<?php
					}
					if(isset($posts[$i] -> playlistId))
					{
						$titleArtistSeparator = " ";
						if ($posts[$i] -> title != "MIC BREAK")  {
									//separator only used if there is a title and an artist
									
									if ($posts[$i] -> artist != "" && $posts[$i] -> title !="")
									{
										 $titleArtistSeparator = " : ";

									}
							 ?>
						<h3 class="search-result-item"><a href="<?php echo home_url(); ?>/episode/?playId=<?php echo $posts[$i] -> playlistId; ?>"> <?php  echo ($posts[$i] -> artist) .$titleArtistSeparator .$posts[$i] -> title ; ?></a></h3>
						<p class="search-item-description"><strong>Aired: <?php echo date("j F Y  h:ia",strtotime($posts[$i] ->timestamp));?></strong> </p>
	<?php			
						}
					}
	        	 }
	?>
	
			<div class="navigation">
				<div class="alignleft"><?php next_posts_link('&laquo; Older Entries') ?></div>
				<div class="alignright"><?php previous_posts_link('Newer Entries &raquo;') ?></div>
			</div>
	
<?php       }
?>
 </div>
 <?php


        	//exit();

/*
        	if (have_posts()) : ?>
			
					<?php while (have_posts()) : the_post(); ?>
							<h3 class="search-result-item"><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a>
							</h3>
                            <p class="search-item-description">
								<?php echo substr(strip_tags($post->post_content), 0, 250);?>
							</p><!-- .search-item-description -->							
					<?php endwhile; ?>
	
    
    	<!--playlist results how up here-->        
        <div id="playlist-results">
        </div> <!-- #playlist-results-->
        
        		
					<div class="navigation">
						<div class="alignleft"><?php next_posts_link('&laquo; Older Entries') ?></div>
						<div class="alignright"><?php previous_posts_link('Newer Entries &raquo;') ?></div>
					</div>
			
				<?php else : ?>
			
                <div class="alert alert-block" id="no-search-results">
       				<h4>Oh, snap!</h4>
    				We couldn't find any pages or content with the keywords you searched for.
    			</div>
    
    
    
			<?php endif; ?>

	*/
   ?>               
 
	</div><!-- span8 #content -->
    <?php get_sidebar(); // sidebar 1 ?>
    
</div><!-- row -->



 
        
        
        
<?php get_footer(); ?>