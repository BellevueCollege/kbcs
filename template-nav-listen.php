<?php
/**
 * Template Name: Listen Navigation Page
 *
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 */
get_header(); ?>
<div class="whatpageisthis">template-nav-listen.php</div>

<div class="row">
	<main class="span8" id="content">
	<h1 class="inner-heading"><?php the_title(); ?></h1>
	<?php

    $args = [
      "post_type" => "page",
      "posts_per_page" => -1,
      "orderby" => "menu_order title",
      "post_status" => "publish",
      "post_parent" => $post->ID,
      ];
    $loop = new WP_Query($args);
    while ($loop->have_posts()):
        $loop->the_post(); ?>
            <section class="nav-section">
               	<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                <?php
                the_excerpt();
                edit_post_link("edit", "<small>", "</small>");
                ?>
    		</section>
            <?php
    endwhile;
    wp_reset_query();

    while (have_posts()):
        the_post();
    	the_content();
    endwhile;

  ?>


    </main><!-- span8  #content -->

	<?php get_sidebar();
// sidebar 1
?>

</div><!-- row -->


<?php get_footer(); ?>
