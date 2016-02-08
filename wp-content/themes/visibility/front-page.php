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

<?php if(have_posts()):while(have_posts()):the_post();
$id_fp = get_the_ID();
if(get_field('fb_url')){
  $fb_url = get_field('fb_url');
}
endwhile;endif; ?>
<div class="fpip-container">
  <div class="row">
    <div class="col-sm-6">
      <div class="fpip">
        <div class="fpip-wrap" id="slide2"></div>
        <div class="fpip-wrap" id="slide3"></div>
        <div class="fpip-wrap" id="slide4"></div>
        <div class="fpip-wrap" id="slide5"></div>
      </div>
    </div>
    <div class="col-sm-6">
      <div class="fpip-content">
        <h1>Granit Pieštany</h1>
      </div>
    </div>
  </div>
</div>

  <div class="row hotels">
    <?php
  $posts = get_posts(array('post_type' => 'offer'));

  foreach ( $posts as $post ) : ?>
    <?php the_post($post); ?>
    <div class="col-sm-6 col-md-3">
      <section>
        <div class="hotel">
            <header>
            <?php if(has_post_thumbnail()){ ?>
              <div class="hotel-img" style="background-image:url(<?php echo get_the_post_thumbnail_src(get_the_post_thumbnail($post_id,'large')); ?>)">
                <div class="toggle to-open"><span class="ion-android-arrow-up"></span></div>
              </div>
            <?php } ?>
            <a href="<?php the_permalink(); ?>">
              <div>
                <h1><?php the_title(); ?></h1>
              </div>
            </a>
          </header>
          <article>
            <p><?php echo get_the_excerpt(); ?></p>
          </article>
          <footer>
            <a href="<?php the_permalink(); ?>#book"><span class="ion-ios-calendar-outline ion"></span> <?php echo trans('hotel_reservation_lang', 'Hotel Reservation') ?> </a>
            <a href="<?php echo $offers_url.'?hotel='.basename(get_the_permalink()); ?>"><span class="ion-ios-star-outline ion"></span> <?php echo trans('hotel_offers_lang', 'Hotel Offers') ?></a>
            <?php if(get_field('hotel_url')){ ?>
              <a href="<?php echo get_field('hotel_url'); ?>"><span class="ion-ios-information-outline ion"></span> <?php echo trans('hotel_url_lang', 'Hotel site') ?></a>
            <?php } ?>
          </footer>
          <div class="toggle to-close"><span class="ion-android-arrow-down"></span></div>
        </div>
      </section>
    </div>
    <?php endforeach; ?>
  </div>
  <div class="hotel-alt"></div>
  <?php $args = array(
      'page_id' => $id_fp
    );
     query_posts($args);if(have_posts()):while(have_posts()):the_post(); ?>
    <?php if(get_field('introduction_img1')){
    if(get_field('introduction_img2') && get_field('introduction_img3') && get_field('introduction_img4') && get_field('introduction_img5')){ ?>
    <style type="text/css">
      .fpip{
        background-image:url(<?php echo get_field('introduction_img1'); ?>);
      }
      .fpip-wrap{
        display:none;
        position:absolute;
        width:100%;
        height:100%;
        top:0;
        left:0;
        background-size:cover;
      }
      #slide2{
        background-image:url(<?php echo get_field('introduction_img2'); ?>);
      }
      #slide3{
        background-image:url(<?php echo get_field('introduction_img3'); ?>);
      }
      #slide4{
        background-image:url(<?php echo get_field('introduction_img4'); ?>);
      }
      #slide5{
        background-image:url(<?php echo get_field('introduction_img5'); ?>);
      }
    </style>
    <div class="sr-only">
      <img src="<?php echo get_field('introduction_img2'); ?>" alt="">
      <img src="<?php echo get_field('introduction_img3'); ?>" alt="">
      <img src="<?php echo get_field('introduction_img4'); ?>" alt="">
      <img src="<?php echo get_field('introduction_img5'); ?>" alt="">
    </div>
    <script type="text/javascript">
      function slider(){
        $('#slide5').fadeOut(2000);
        setTimeout(function(){
          $('#slide2').fadeIn(2000);
        },5000);
        setTimeout(function(){
          $('#slide3').fadeIn(2000);
          setTimeout(function(){
            $('#slide2').hide();
          },2000);
        },10000);
        setTimeout(function(){
          $('#slide4').fadeIn(2000);
          setTimeout(function(){
            $('#slide3').hide();
          },2000);
        },15000);
        setTimeout(function(){
          $('#slide5').fadeIn(2000);
          setTimeout(function(){
            $('#slide4').hide();
          },2000);
        },20000);
      }
      $(function(){
        slider();
        setInterval(function(){
          slider();
        },25000);
      });
    </script>
    <?php }else{ ?>
      <style type="text/css">
        .fpip{
          background-image:url(<?php echo get_field('introduction_img1'); ?>);
        }
      </style>
    <?php }} ?>
    <?php if(has_post_thumbnail()): ?>
      <img src="<?php echo get_the_post_thumbnail_src(get_the_post_thumbnail($post_id,'large')); ?>" alt="<?php the_title(); ?>" class="post-thumbnail" width="100%">
    <?php endif; ?>
    
    <div class="container fp-cont">
      <?php echo do_shortcode(get_the_content()); ?>
    </div>
    <?php if(get_field('fp_script')){echo '<script type="text/javascript">'.get_field('fp_script').'</script>';} ?>
  <?php endwhile;else:?>
    <p><?php _e('Sorry, this page does not exist.','lang'); ?></p>
  <?php endif;wp_reset_query(); ?>
    
<?php get_footer(); ?>