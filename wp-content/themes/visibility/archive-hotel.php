<?php get_header(); ?>

<?php
$args = array(
  'post_type'  => 'page',
  'meta_query' => array(
    array(
      'key'   => '_wp_page_template',
      'value' => 'template-offer.php'
    )
  )
);
query_posts($args);if(have_posts()):while(have_posts()):the_post(); $offers_url = get_the_permalink(); endwhile;endif;wp_reset_query(); ?>
<div class="our-hotels about-granit">
  <?php

//        global $post;
    var_dump($post);
    var_dump($wp_query->post);
    var_dump($wp_query);
    $post_type_object = get_post_type_object($post->post_type);
    $page_id = null;
    $posts = get_posts(array(
      'post_type'    => 'page',
      'meta_key'     => '_wp_page_template',
      'meta_value'   => 'template-' . $post_type_object->name . '.php',
      'meta_compare' => '=='
    ));
      foreach($posts as $post){
      $parent_page_id = $post->ID;
      }
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
             <a href="<?php echo get_permalink($parent_page_id) ?>"><span class="ion-android-arrow-back"></span>&nbsp;<?php echo trans('back_to_offers_lang', 'back to offers') ?>
             </a>
           </div>
             <?php endif; ?>
      </div>
      <div class="col-md-12">
        <h1><?php echo trans('one_hotel_title_lang', 'About hotel'); ?></h1>
      </div>
    </div>
 </div>
  <section>
    <div class="row our-hotel">
      <div class="col-sm-6 our-hotel our-hotel-img-wrap">
        <?php if (has_post_thumbnail()) { ?>
          <div class="our-hotel-img"
            style="background-image:url(<?php echo get_the_post_thumbnail_src(get_the_post_thumbnail($post_id, 'large')); ?>)">
          </div>
      </div>
        <?php } ?>
    </div>
      <div class="col-sm-6 our-hotel">
        <div class="container-half">
          HOTEL GRANIT
          <h2><?php the_title(); ?></h2>
          <p>
          <?php
          if(get_field('about_hotel_right')){
            echo get_field('about_hotel_right');
          }
          ?>
          </p>
          <div class="row">
            <div class="col-md-5">
              <?php if (get_field('hotel_url')) { ?>
                <a class="btn btn-more no-margins"
                  href="<?php echo get_field('hotel_url'); ?>"><?php echo trans('hotel_url_lang', 'Hotel site') ?></a>
              <?php } ?>
            </div>
            <div class="col-md-6 col-sm-offset-1 our-hotel-links">
              <a href="<?php the_permalink(); ?>#book"><span
                class="ion-ios-calendar-outline ion"></span> <?php echo trans('hotel_reservation_lang', 'Hotel Reservation') ?>
              </a>
              <a href="<?php echo $offers_url.'?hotel=' . basename( get_permalink($post->ID)); ?>"><span
                class="ion-ios-star-outline ion"></span> <?php echo trans('hotel_offers_lang', 'Hotel Offers') ?>
              </a>
           </div>
          </div>
        </div>
      </div>
    </div>
  </section>
    <div class="container single-hotel">
      <?php echo do_shortcode(get_the_content()); ?>
        <div class="booking outthere">
          <div class="booking-form" id="book">
            <div class="text-center">
              <span class="ion-ios-information-outline ion"></span> Prosíme, vyplňte všetky uvedené
                políčka, recepcia Vás bude následne kontaktovať.
            </div>
            <div class="booking-form-wrap">
              <?php $hotel = basename( get_permalink($post->ID));
              include 'booking.php'; ?>
            </div>
          </div>
        </div>
    </div>
    <?php endwhile;
    else: ?>
      <div class="container">
        <div class="row">
          <h1><?php _e('Sorry, this page does not exist.', 'lang'); ?></h1>
          <p>
            <a href="<?php echo get_home_url(); ?>"><?php _e('Go to home page', 'lang'); ?></a> <?php _e('or use search', 'lang'); ?>
            :</p>
          <?php
          get_search_form();
          ?>
        </div>
      </div>
  <?php endif; ?>
  </div>
<?php get_footer(); ?>