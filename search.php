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
	<main class="span8" id="content">
	<h1 class="inner-heading">
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
					echo $pageNumbers = '<nav aria-label="Pages" class="pagination"><ul>'.$pagination->getLinks(array("s"=>$searchParameter,"post_type"=>$searchPosttype)).'</ul></nav>';
					// Loop through all the items in the array
					?>

				<?php
					for($i=0;$i<count($postsPages);$i++) {

						if(isset($postsPages[$i] -> ID) && !empty($postsPages[$i] -> ID)) { ?>
						<article>
							<h2 class="search-result-item"><a href="<?php echo get_permalink($postsPages[$i] -> ID) ?>" rel="bookmark" title="Permanent Link to <?php  ?>"><?php echo get_the_title($postsPages[$i] -> ID); ?></a>
							</h2>
							<p class="search-item-description">
								<?php echo substr(strip_tags($postsPages[$i]->post_content), 0, 250);?>
							</p><!-- .search-item-description -->
						</article>
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
							<article>
								<h2 class="search-result-item"><a href="<?php echo home_url(); ?>/episode/?playId=<?php echo $postsPages[$i] -> playlistId; ?>"> <?php  echo ($postsPages[$i] -> artist) .$titleArtistSeparator .$posts[$i] -> title ; ?></a></h2>
								<p class="search-item-description"><strong>Aired: <?php echo date("j F Y  h:ia",strtotime($postsPages[$i] ->timestamp));?></strong> </p>
							</article>
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
				<h2>Oh, snap!</h2>
				<p>We couldn't find any pages or content with the keywords you searched for.</p>
			</div>
	<?php
			}
	?>
	</main><!-- span8 #content -->
	<?php get_sidebar(); // sidebar 1 ?>

</div><!-- row -->

<?php get_footer();
