<?php 
/**
 * Template Name: Search Page
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 */
require_once( 'inc/pagination.class.php' );

get_header(); ?>

<div class="whatpageisthis">search.php</div>
<div class="row">
	<div class="span8" id="content">
		<h1 class="search-page-title">
			<?php
			/* Search Count */
			$allsearch = new WP_Query("s=$s&showposts=-1");
			$key = esc_html($s, 1);
			$count = $allsearch->post_count; 
			_e(''); 
			_e('<span class="search-terms">"'); 
			echo $key; _e('"</span>');
			?> Search Results <?php 
			_e('<small class="hide"> ('); 
			echo $count . ' '; 
			_e('results)</small>'); 
			wp_reset_query(); 
			?>
		</h1>
		<div id="playlist-results">
			<?php
			$count = $allsearch->post_count;
			$searchParameter = get_search_query();
			$searchPosttype = esc_attr($_GET["post_type"]);
			$searchP = $searchParameter;
			$searchP = trim($searchP);
			$searchP = str_replace(' ', '%20', $searchP);
			$searchP = str_replace("\'", '%27', $searchP);
			$searchP = str_replace('\"','%22', $searchP);
			$wpQuerySearchResults  = $allsearch->get_posts();
			$posts = $wpQuerySearchResults;


			if (count($posts)) {

				// Create the pagination object
				$pagination = new pagination($posts, (isset($_GET['page']) ? esc_attr($_GET['page']) : 1), 15);
				// Parse through the pagination class
				$postsPages = $pagination->getResults();
				// If we have items 
				if (count($postsPages) != 0) {
					// Create the page numbers
					echo $pageNumbers = '<div class="pagination"><ul>'.$pagination->getLinks(array("s"=>$searchParameter,"post_type"=>$searchPosttype)).'</ul></div>';
					// Loop through all the items in the array
					?>
				
				<?php
					for($i=0;$i<count($postsPages);$i++) {

						if(isset($postsPages[$i] -> ID) && !empty($postsPages[$i] -> ID)) { ?>
							<h3 class="search-result-item"><a href="<?php echo get_permalink($postsPages[$i] -> ID) ?>" rel="bookmark" title="Permanent Link to <?php  ?>"><?php echo get_the_title($postsPages[$i] -> ID); ?></a>
							</h3>
							<p class="search-item-description">
								<?php echo substr(strip_tags($postsPages[$i]->post_content), 0, 250);?>
							</p><!-- .search-item-description -->	
					<?php
						}

						if(isset($postsPages[$i] -> playlistId)) {
							$titleArtistSeparator = " ";
							$current_datetime = strtotime("today");
							$playlistItemTimestamp = 0;
							if(!empty($postsPages[$i] -> timestamp))
									$playlistItemTimestamp = strtotime($postsPages[$i] -> timestamp);

								if ($postsPages[$i] -> title != "MIC BREAK")  {
										//separator only used if there is a title and an artist
										
										if ($postsPages[$i] -> artist != "" && $postsPages[$i] -> title !="")
										{
											$titleArtistSeparator = " : ";

										}
								?>
							<h3 class="search-result-item"><a href="<?php echo home_url(); ?>/episode/?playId=<?php echo $postsPages[$i] -> playlistId; ?>"> <?php  echo ($postsPages[$i] -> artist) .$titleArtistSeparator .$posts[$i] -> title ; ?></a></h3>
							<p class="search-item-description"><strong>Aired: <?php echo date("j F Y  h:ia",strtotime($postsPages[$i] ->timestamp));?></strong> </p>
							<?php			
							}
						}
					}
					// print out the page numbers beneath the results
					echo $pageNumbers;
				}
			}
		else
		{
	?>
			<div class="alert alert-block" id="no-search-results">
				<h4>Oh, snap!</h4>
				We couldn't find any pages or content with the keywords you searched for.
			</div>
	<?php
			}
	?>
		</div>
	</div><!-- span8 #content -->
	<?php get_sidebar(); // sidebar 1 ?>

</div><!-- row -->

<?php get_footer();
