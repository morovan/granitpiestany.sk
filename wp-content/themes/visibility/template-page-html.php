<?php
/*
Template Name: Page (HTML)
*/
get_header(); ?>

  <div class="container">

    <?php if(have_posts()):while(have_posts()):the_post(); ?>
      <?php if(has_post_thumbnail()): ?>
        <img src="<?php echo get_the_post_thumbnail_src(get_the_post_thumbnail($post_id,'large')); ?>" alt="<?php the_title(); ?>" class="post-thumbnail" width="100%">
      <?php endif; ?>
      <h1><?php the_title(); ?></h1>
      <?php echo do_shortcode(get_the_content()); ?>
      <?php

      query_posts('post_type=hotel');if(have_posts()):while(have_posts()):the_post();

        if(get_field('hotel_mapa')){
          var_dump( get_field('hotel_mapa'));
        }

      endwhile;endif;wp_reset_query();

      ?>
    <?php endwhile; else: ?>
      <h1><?php _e('Sorry, this page does not exist.','lang'); ?></h1>
      <p><a href="<?php echo get_home_url(); ?>"><?php _e('Go to home page','lang'); ?></a> <?php _e('or use search','lang'); ?>:</p>
      <?php
      get_search_form();
      ?>
    <?php endif; ?>

  </div>

<?php get_footer(); ?>