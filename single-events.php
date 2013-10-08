<?php get_header(); ?>

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

    <article id="event-<?php the_ID(); ?>">
        <h1><?php the_title(); ?></h1>
        <section class="event_container">
            <?php the_content(); ?>
            <section class="event_desc">
              
             </section>
          </section>
     </article>
<?php endwhile; endif; ?>

<?php get_footer(); ?>