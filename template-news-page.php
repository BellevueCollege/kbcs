<?php
/**
 * Template Name: News Page Template
 *
 * A custom template for displaying news posts with editable content at the top
 * and pagination.
 */

get_header();
?>

<div class="whatpageisthis">news-template.php</div>

<div class="container">
    <div class="row">
        <main class="span8" id="content">
            <h1 class="inner-heading"><?php the_title(); ?></h1>
            <?php the_content(); ?>

            <div class="news-posts-section">
                <?php
                // Get current page
                $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

                // Set up the query for news posts
                // Adjust the category ID based on your news category
                $news_query = new WP_Query(array(
                    'post_type' => 'post',
                    'category_name' => 'news-and-ideas',
                    'post_status' => 'publish',
                    'posts_per_page' => 10,
                    'paged' => $paged
                ));

                // Start the loop
                if ( $news_query->have_posts() ) :
                    while ( $news_query->have_posts() ) : $news_query->the_post();
                ?>
                        <article id="post-<?php the_ID(); ?>" <?php post_class('lcp-post'); ?>>
                            <h2 class="post-title">
                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                            </h2>

                            <div class="media">
                                <?php if (has_post_thumbnail()) : ?>
                                    <div class="thumb media-left">
                                        <a href="<?php the_permalink(); ?>">
                                            <?php the_post_thumbnail('thumbnail'); ?>
                                        </a>
                                    </div>
                                <?php else : ?>
                                    <div class="no-media"></div>
                                <?php endif; ?>

                                <div class="media-content">
                                    <div class="post-meta" aria-hidden="true">
                                        <span class="post-date"><?php echo get_the_date(); ?></span>
                                    </div>

                                    <div class="post-excerpt">
                                        <?php the_excerpt(); ?>
                                    </div>
                                </div>
                            </div>
                        </article>
                <?php
                    endwhile;

                    // Pagination
                    get_pagination($news_query);

                    // Restore original post data
                    wp_reset_postdata();

                else :
                    echo '<p>No news posts found.</p>';
                endif;
                ?>
            </div>
        </main><!-- #content .span8 -->

        <?php get_sidebar(); ?>
    </div><!-- row -->
</div><!-- container -->

<?php get_footer(); ?>
