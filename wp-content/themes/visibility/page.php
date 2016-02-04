<?php get_header(); ?>

<div class="container">

  <?php if(have_posts()):while(have_posts()):the_post(); ?>
    <?php if(has_post_thumbnail()): ?>
      <img src="<?php echo get_the_post_thumbnail_src(get_the_post_thumbnail($post_id,'large')); ?>" alt="<?php the_title(); ?>" class="post-thumbnail" width="100%">
    <?php endif; ?>
    <h1><?php the_title(); ?></h1>
    <?php the_content(); ?>
  <?php endwhile; else: ?>
    <h1><?php _e('Sorry, this page does not exist.','lang'); ?></h1>
    <p><a href="<?php echo get_home_url(); ?>"><?php _e('Go to home page','lang'); ?></a> <?php _e('or use search','lang'); ?>:</p>
    <?php
      get_search_form();
    ?>
  <?php endif; ?>
    
</div>

<?php get_footer(); ?>