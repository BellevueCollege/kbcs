<?php
/**
* // Staff archive page
* Template Name: Staff Directory Page
*/

get_header(); ?>

<?php
/**
 * Get staff members by type
 *
 * @param string|array $term_slugs Single term slug or array of term slugs
 * @return WP_Query Query object with results
 */
function get_staff_by_type($term_slugs) {
    $args = array(
        'post_type' => 'staff',
        'posts_per_page' => -1,
        'order' => 'ASC',
        'orderby'=> 'title',
        'post_status' => 'publish',
        'tax_query'=> array(
            array(
                'taxonomy'  => 'staff_type',
                'field' => 'slug',
                'terms' => $term_slugs,
                'operator'  => 'IN'),
            )
    );

    return new WP_Query($args);
}

/**
 * Display staff member HTML
 *
 * @param int|null $post_id Post ID (optional, defaults to current post)
 * @param array $options Display options
 *        - show_excerpt: Whether to show the post excerpt (default: false)
 *        - show_breaks: Whether to add <br/> tags after meta fields (default: false)
 */
function display_staff_member($post_id = null, $options = array()) {
    // Set defaults
    $defaults = array(
        'show_excerpt' => false,
        'show_breaks' => false
    );
    $options = array_merge($defaults, $options);

    // Use current post if no ID specified
    if (is_null($post_id)) {
        global $post;
        $post_id = $post->ID;
    } else {
        $post = get_post($post_id);
    }

    // Break tag based on options
    $br = $options['show_breaks'] ? '<br/>' : '';
    ?>

    <section class="media">
        <?php
            if (has_post_thumbnail($post_id)) {
                echo get_the_post_thumbnail($post_id, 'thumbnail', array('class' => 'media-object'));
            } else { ?>
                <img src="<?php echo get_bloginfo('stylesheet_directory'); ?>/img/thumbnail-default.png" alt="<?php echo get_the_title($post_id); ?>" />
        <?php } ?>

        <div class="media-body">
            <h2 class="media-heading"><a href="<?php echo get_permalink($post_id); ?>"><?php echo get_the_title($post_id); ?></a></h2>

            <?php
                if (get_post_meta($post_id, 'staff_role', true) != '') {
                    echo '<p class="staff-role">' . get_post_meta($post_id, 'staff_role', true) . '</p>' . $br;
                }

                $programs = get_related_programs($post_id);
                if ($programs) {
                    echo '<p class="host-of"><strong>Hosts:</strong> ' . $programs . '</p>' . $br;
                }

                if (get_post_meta($post_id, 'staff_email', true) != '') {
                    echo '<p class="staff-email"><a href="mailto:' . get_post_meta($post_id, 'staff_email', true) . '">' . get_post_meta($post_id, 'staff_email', true) . '</a></p>' . $br;
                }

                if (get_post_meta($post_id, 'staff_phone', true) != '') {
                    echo '<p class="staff-phone">' . get_post_meta($post_id, 'staff_phone', true) . '</p>' . $br;
                }

                if ($options['show_excerpt']) {
                    echo '<div class="media-content">' . get_the_excerpt($post_id) . '</div>';
                }
            ?>
        </div><!-- media-body -->
    </section><!-- media -->
    <hr />
    <?php
}
?>


<div class="whatpageisthis">template-staff-directory.php</div>

			<div class="container">
				<div class="row">
					<main class="span8" id="content">
							<h1 class="sr-only">Staff, Volunteers, and Affiliates</h1>

							    <ul class="nav nav-tabs" id="myTab">
									<li class="active"><a href="#kbcs_staff" data-toggle="tab">Staff</a></li>
								    <li><a href="#music_hosts" data-toggle="tab">Hosts</a></li>
								    <li><a href="#news_hosts" data-toggle="tab">News</a></li>
							    </ul>

							    <div class="tab-content">
								    <div class="active tab-pane" id="kbcs_staff">
										<!-- KBCS Staff Tab -->
										<?php
                                            $loop = get_staff_by_type('kbcs-staff');
                                            while ($loop->have_posts()) : $loop->the_post();
                                                display_staff_member();
                                            endwhile;
                                            wp_reset_postdata();
                                        ?>
								    </div><!-- tab-pane kbcs_staff -->

<!-- News Hosts Tab -->
								    <div class="tab-pane" id="news_hosts">
												<?php
                                            $loop = get_staff_by_type('news-host');
                                            while ($loop->have_posts()) : $loop->the_post();
                                                display_staff_member(null, array('show_excerpt' => true, 'show_breaks' => true));
                                            endwhile;
                                            wp_reset_postdata();
                                        ?>
								    </div><!-- .tab-pane #news_hosts -->

<!-- Music Hosts Tab -->
								    <div class="tab-pane" id="music_hosts">
										<?php
                                            $loop = get_staff_by_type('music-host');
                                            while ($loop->have_posts()) : $loop->the_post();
                                                display_staff_member(null, array('show_excerpt' => true, 'show_breaks' => true));
                                            endwhile;
                                            wp_reset_postdata();
                                        ?>
								    </div><!-- music_hosts -->

							    </div><!-- tab-pane tab-content -->


						<script>
							jQuery('#myTab a').click(function (e) {
								e.preventDefault();
							jQuery(this).tab('show');
							})
						</script>


						<script>
                            jQuery(document).ready(function() {
                                // Function to show active tab and hide others using the hidden attribute
                                function updateTabVisibility() {
                                    // Get active tab's target
                                    var activeTabTarget = jQuery('.tab-pane.active').attr('id');

                                    // Hide all inactive tabs with the hidden attribute
                                    jQuery('.tab-pane').each(function() {
                                        if (jQuery(this).attr('id') !== activeTabTarget) {
                                            jQuery(this).prop('hidden', true);
                                        } else {
                                            jQuery(this).prop('hidden', false);
                                        }
                                    });
                                }

                                // Handle tab clicks
                                jQuery('#myTab a').click(function(e) {
                                    e.preventDefault();
                                    jQuery(this).tab('show');
                                });

                                // Update visibility when tab is shown
                                jQuery('a[data-toggle="tab"]').on('shown', function(e) {
                                    // Save the latest tab to localStorage
                                    localStorage.setItem('lastTab', jQuery(e.target).attr('href'));

                                    // Update tab visibility
                                    updateTabVisibility();
                                });

                                // Go to the latest tab, if it exists
                                var lastTab = localStorage.getItem('lastTab');
                                if (lastTab) {
                                    jQuery('a[href="' + lastTab + '"]').tab('show');
                                }

                                // Initial visibility update
                                updateTabVisibility();
                            });
                        </script>
					</main><!-- #content .span8 -->
				<?php get_sidebar(); ?>
				</div><!-- row -->
			</div><!-- container -->
<?php get_footer();
