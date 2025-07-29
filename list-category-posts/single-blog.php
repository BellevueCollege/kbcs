<?php
$lcp_display_output = '';

// Category title
$lcp_display_output .= '<div class="category-title">';
$lcp_display_output .= $this->get_category_link("h1"); // Semantic heading for category title
$lcp_display_output .= "</div>";

// Conditional title
$lcp_display_output .= $this->get_conditional_title();

// Posts Loop
global $post;
while (have_posts()):
    the_post();

    // Post container with or without thumbnail
    $lcp_display_output .=
        '<article id="post-' . get_the_ID() . '" class="lcp-post">';
    $lcp_display_output .= $this->get_post_title($post, "h2"); // Semantic post title

    // Container
    $lcp_display_output .= '<div class="media">';

    if (has_post_thumbnail($post->ID)) {
        $lcp_display_output .= '<div class="thumb media-left">';
        $lcp_display_output .= $this->get_thumbnail($post); // Get thumbnail
        $lcp_display_output .= "</div>";
    } else {
        $lcp_display_output .= '<div class="no-media"></div>';
    }

    // Post content container
    $lcp_display_output .= '<div class="media-content">';

    // Meta information with proper ARIA-hidden for visual metadata
    $lcp_display_output .= '<div class="post-meta" aria-hidden="true">';
    $lcp_display_output .=
        '<span class="post-date">' . $this->get_date($post) . "</span>";
    $lcp_display_output .= "</div>";

    // Post excerpt or content
    $lcp_display_output .= '<div class="post-excerpt">';
    $lcp_display_output .= $this->get_excerpt($post, "p", "lcp_excerpt");
    $lcp_display_output .= "</div>";

    // Read more link
    $lcp_display_output .= '<div class="post-read-more">';
    $lcp_display_output .= $this->get_posts_morelink($post);
    $lcp_display_output .= "</div>";

    $lcp_display_output .= "</div>"; // End of post-content

    $lcp_display_output .= "</article>"; // End of lcp-post
endwhile;

// Output result
$this->lcp_output = $lcp_display_output;
?>
