<?php
/*
Template Name: Template Aktivity
*/
get_header(); ?>
  <div class="our-hotels about-granit">
    <?php if (have_posts()):while (have_posts()):the_post(); ?>
      <h1><?php the_title() ?></h1>
      <section>
        <div class="row our-hotel">
          <div class="col-sm-6 col-lg-5 height-fix-to bckg-norepeat"<?php if (has_post_thumbnail()) { ?>
            style="background-image:url(<?php echo get_the_post_thumbnail_src(get_the_post_thumbnail($post_id, 'large')); ?>)"
          <?php } ?>></div>
          <div class="col-sm-6 col-lg-offset-1 height-fix-from">
            <div class="container-half">
              <?php
              if(get_field('about_granit_after_img')){
                echo do_shortcode(get_field('about_granit_after_img'));
              }
              ?>
            </div>
          </div>
        </div>
      </section>

      <div class="container about-granit-after-img">
        <?php
        echo do_shortcode(get_the_content());
        ?>
      </div>
    <?php endwhile;
    else: ?>
      <h1><?php _e('Sorry, this page does not exist.', 'lang'); ?></h1>
      <p>
        <a href="<?php echo get_home_url(); ?>"><?php _e('Go to home page', 'lang'); ?></a> <?php _e('or use search', 'lang'); ?>
        :</p>
      <?php
      get_search_form();
      ?>
    <?php endif; ?>
  </div>
<?php get_footer(); ?>