<?php
/**
 * Template Name: Search Page
 */
get_header(); ?>

<div class="whatpageisthis">search.php</div>
<div class="row">
<main class="span8" id="content">
    <h1 class="inner-heading">
        <?php
        $search_query = get_search_query();
        $allsearch = new WP_Query(array(
            's' => $search_query,
            'posts_per_page' => -1,
            'post_status' => 'publish'
        ));
        $count = $allsearch->post_count;
        ?>
        <span class="search-terms">"<?php echo esc_html($search_query); ?>"</span>
        Search Results
        <small class="hide">(<?php echo $count; ?> results)</small>
        <?php wp_reset_postdata(); ?>
    </h1>
    <?php
    // Main paginated search query
    $paged = get_query_var('paged') ? get_query_var('paged') : 1;
    $search_results = new WP_Query(array(
        's' => $search_query,
        'posts_per_page' => 10,
        'paged' => $paged,
        'post_status' => 'publish'
    ));

    if ($search_results->have_posts()) :
        while ($search_results->have_posts()) : $search_results->the_post(); ?>
            <article class="search-result-item">
                <div class="media-left">
                    <img src="<?php echo get_the_post_thumbnail_url(); ?>" alt="<?php the_title(); ?>">
                </div>
                <div class="search-item-description">
                    <h2>
                        <a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a>
                    </h2>
                    <small>Posted on <?php the_time('F j, Y'); ?> by <?php the_author(); ?></small>
                    <p>
                        <?php if (get_the_excerpt()) : ?>
                            <?php echo get_the_excerpt(); ?>
                        <?php else : ?>
                            <?php echo wp_trim_words(strip_tags(get_the_content()), 50, '...'); ?>
                        <?php endif; ?>
                    </p>
                </div>
            </article>
        <?php endwhile;

        // Pagination
        get_pagination($search_results);

        wp_reset_postdata();
    else : ?>
        <div class="alert alert-block" id="no-search-results">
            <h2>Oh, snap!</h2>
            We couldn't find any pages or content with the keywords you searched for.
        </div>
    <?php endif; ?>
</main><!-- span8 #content -->
<?php get_sidebar(); ?>
</div><!-- row -->
<?php get_footer(); ?>
