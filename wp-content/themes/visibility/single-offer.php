<?php get_header(); ?>

    <div class="our-hotels">
      <?php
      global $post;
      $post_type_object = get_post_type_object($post->post_type);
      $page_id = null;
      query_posts(array(
        'post_type'    => 'page',
        'meta_key'     => '_wp_page_template',
        'meta_value'   => 'template-' . $post_type_object->name . '.php',
        'meta_compare' => '=='
      ));
        if (have_posts()):while (have_posts()):the_post();
          $parent_page_id = get_the_ID();
        endwhile;endif;
        wp_reset_query();
        ?>
        <div class="container">
          <div class="row">
            <?php if (have_posts()):while (have_posts()):
              the_post(); ?>
            <div class="col-md-12">
              <?php if (isset($parent_page_id)) : ?>
                <?php
                $parent = get_post($parent_page_id);
                ?>

                  <div class="go-back-wrap">
                    <a href="<?php echo get_permalink($parent_page_id) ?>"><span
                      class="ion-android-arrow-back"></span>&nbsp;<?php echo trans('back_to_offers_lang', 'back to offers') ?>
                    </a>
                  </div>
                  <?php endif; ?>
            </div>
            <div class="col-md-12">
                <h1><?php echo trans('one_offer_title_lang', 'Offer'); ?></h1>
            </div>
          </div>
        </div>
        <section>
          <div class="row our-hotel our-hotel-detail">
            <div class="col-sm-6 our-hotel our-hotel-img-wrap">
              <?php if (has_post_thumbnail()) { ?>
                <div class="our-hotel-img" style="background-image:url(<?php echo get_the_post_thumbnail_src(get_the_post_thumbnail($post_id, 'large')); ?>)">
                  </div>
                  <?php } ?>
                </div>
                <div class="col-sm-6 our-hotel">
                  <div class="container-half">
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
                      <div class="offer-for-hotel">
                      <span>
                        <?php if (get_field('offer_for_hotel')) : ?>
                          <?php $hotels = get_field('offer_for_hotel'); ?>
                          <?php foreach ($hotels as $hotel): ?>
                            <?php
                            echo '<a href="' . get_the_permalink($hotel->ID) . '">' . __('Hotel GRANIT', 'lang') . ' ' . $hotel->post_title . '</a>';
                            echo(end($hotels) != $hotel ? ', ' : '') ?>
                          <?php endforeach; ?>
                        <?php endif ?>
                      </span>
                      </div>
                      <h2><?php the_title(); ?></h2>
                      <p><?php
                        if (get_field('hotel_offer_excerpt')) {
                          echo get_field('hotel_offer_excerpt');
                        }
                        ?>
                      </p>
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
                      <div class="offer-book-btn">
                        <a class="btn btn-more" ref="<?php the_permalink(); ?>#book-offer-detail"><?php echo trans('reserve_offer_lang', 'RESERVE OFFER') ?></a>
                      </div>
                    </div>
                </div>
            </div>
            <div class="container our-hotel our-hotel-detail">
              <h3 class="text-center"><?php echo trans('what_offer_includes_lang', 'What offer includes') ?></h3>
              <div class="row">
                <div class="col-md-7">
                  <?php echo do_shortcode(get_the_content()); ?>
                </div>
                <div class="col-md-5">
                  <div class="booking outthere half">
                    <div class="booking-form" id="book-offer-detail">
                      <div class="text-center h4"><?php echo trans('offer_booking_title_lang', 'Reserve package') ?></div>
                        <div class="text-center">
                          <span class="ion-ios-information-outline ion"></span> Prosíme, vyplňte všetky
                          uvedené políčka, recepcia Vás bude následne kontaktovať.
                            </div>
                            <div class="booking-form-wrap">
                              <?php $hotel = (isset($hotels) && count($hotels) == 1 ? basename( get_permalink($hotels[0]->ID)) : '');
                              include 'booking.php'; ?>
                            </div>
                        </div>
                    </div>
                      <div class="text-after-booking">
                        <?php
                        if (get_field('text_after_booking')) {
                          echo do_shortcode(get_field('text_after_booking'));
                        }
                        ?>
                      </div>
                    </div>
                </div>
            </div>
        </section>
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