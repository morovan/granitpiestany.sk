<?php
/*
Template Name: Template Offer
*/
get_header(); ?>
  <div class="container template-hotel-offer">
  <h1><?php the_title() ?></h1>
    <?php
    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
    
      $args = array(
        'post_type'      => 'offer',
        'posts_per_page' => get_option('posts_per_page', 5),
        'paged'          => $paged);
      $the_posts = get_posts($args);
      $wp_query = new WP_Query($args);


    ?>
    <?php
    foreach ($the_posts as $post):
    setup_postdata($post);; ?>
    <div class="row hotel-offer">
      <div class="hotel-offer-inner clearfix">
        <?php if (has_post_thumbnail()): ?>
          <div class="col-md-3 col-sm-4">
            <a href="<?php the_permalink()?>"><div class="squater" style="background-image:url(<?php echo get_the_post_thumbnail_src(get_the_post_thumbnail($post_id, 'large')); ?>)"></div>
               </a>
          </div>
          <div class="col-md-9 col-sm-8">
          <?php else: ?>
            <div class="col-md-12">
              <?php endif; ?>
              <div class="hotel-offer-available"><?php echo trans('offer_available_in_lang', 'Offer is available in:') ?>
                <span>
                  <?php
                    if (get_field('offer_date_from')) {
                      echo date_i18n('j. n.', strtotime(get_field('offer_date_from')));
                    }
                    if (get_field('offer_date_to')) {
                      echo ' - ' . date_i18n('j. n. Y', strtotime(get_field('offer_date_to')));
                    }
                  ?>
                </span>
              </div>

              <a href="<?php the_permalink()?>" class="hotel-offer-title"><h2><?php the_title(); ?></h2></a>

              <p class="hotel-offer-overflow"><?php echo get_the_excerpt(); ?></p>

              <div class="offer-price pull-left">
                <?php
                if (get_field('offer_price')) {
                  echo get_field('offer_price');
                }
                if (get_field('offer_price_2')) {
                  echo get_field('offer_price_2');
                }
                ?>
              </div>
              <div class="pull-left">
                <a class="btn btn-more"
                   href="<?php the_permalink(); ?>"><?php echo trans('more_about_offer_lang', 'More about offer') ?></a>
              </div>
            </div>
          </div>
        </div>
        <?php endforeach; ?>
        <?php
        global $wp_query;

        $big = 999999999;
        $translated = __('Page', 'lang');
        $pages = paginate_links(array(
          'base'               => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
          'format'             => '?paged=%#%',
          'current'            => max(1, get_query_var('paged')),
          'total'              => isset($max_num_pages) ? $max_num_pages : $wp_query->max_num_pages,
          'before_page_number' => '<span class="sr-only">' . $translated . ' </span>',
          'prev_text'          => '<span class="pntext"> <i class="ion-android-arrow-back"></i> </span>',
          'next_text'          => '<span class="pntext"> <i class="ion-android-arrow-forward"></i> </span>',
          'type'               => 'array'
        ));
        if (is_array($pages)) {
          $paged = (get_query_var('paged') == 0) ? 1 : get_query_var('paged');
          echo '<nav class="text-center"><ul class="pagination">';
          foreach ($pages as $page) {
            echo "<li>$page</li>";
          }
          echo '</ul></nav>';
        }
        ?>
    </div>
<?php get_footer(); ?>