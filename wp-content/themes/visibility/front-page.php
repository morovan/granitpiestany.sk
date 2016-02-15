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
    <div class="col-sm-6 fpip-col">
      <div class="fpip">
        <div class="fpip-wrap" id="slide2"></div>
        <div class="fpip-wrap" id="slide3"></div>
        <div class="fpip-wrap" id="slide4"></div>
        <div class="fpip-wrap" id="slide5"></div>
      </div>
    </div>
    <div class="col-sm-6 ">
      <div class="col-md-8 col-sm-offset-2">
        <div class="fpip-content">
          <h1><span>Hotel Granit </span>Pieštany <span>kúpeľný ústav</span></h1>
          <div class="m-top-20">
            <p class="fp-para">Našim klientom sa snažíme vytvoriť podmienky na nezabudnuteľný pobyt, počas ktorého si oddýchnu a načerpajú novú energiu. Držíme sa nášho motta „Váš domov mimo domova“ a veríme, že počas pobytu u nás sa cítia komfortne a príjemne.</p>
            <a href='/booking' class='btn btn-more no-margins m-top-40 '>rezervujte si ubytovanie</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?php
$posts = get_posts(array('post_type' => 'offer','posts_per_page' => 3));
  
  $no_offer = 0;
  
  foreach ( $posts as $post ) :
    
    $no_offer++;
  
  endforeach;
  ?>

  <div class="row hotels<?php
    
    if($no_offer==0){
      echo ' sr-only';
    }
    ?>">
    <?php
  

  foreach ( $posts as $post ) : ?>
    <?php the_post($post); ?>
    <div class="<?php
    
    if($no_offer==3){
      echo 'col-sm-6 col-md-3';
    }else if($no_offer==2){
      echo 'col-sm-6 col-md-4';
    }else{
      echo 'col-sm-6';
    }
    ?>">
      <section>
        <a href="<?php the_permalink(); ?>" class="hotel">
          <div class="row">
            <div class="col-sm-4 col-lg-6 text-center">
              <?php if(has_post_thumbnail()){ ?>
                <div class="hotel-img" style="background-image:url(<?php echo get_the_post_thumbnail_src(get_the_post_thumbnail($post_id,'large')); ?>)">
                </div>
                <div class="btn btn-more hidden-btn text-center" ref="<?php the_permalink(); ?>#book-offer-detail"><?php echo trans('more_information', 'More information') ?></div>
              <?php } ?>
            </div>
            <div class="col-sm-8 col-lg-6 fpage">
              <div class="browny">
                <?php
                if (get_field('offer_date_from')) {
                  echo date_i18n('j. n.', strtotime(get_field('offer_date_from')));
                }
                if (get_field('offer_date_to')) {
                  echo ' - ' . date_i18n('j. n. Y', strtotime(get_field('offer_date_to')));
                }
                ?>

              </div>
              <p><?php echo get_the_excerpt(); ?></p>
              <div class="offer-price pull-left">
                <?php
                if (get_field('offer_price')) {
                  echo get_field('offer_price');
                }
                ?>
              </div>
            </div>
          </div>
        </a>
      </section>
    </div>
    <?php endforeach; ?>
    <div class="<?php
    
    if($no_offer==3){
      echo 'col-sm-6 col-md-3';
    }else if($no_offer==2){
      echo 'col-sm-6 col-md-4';
    }else{
      echo 'col-sm-6';
    }
    ?>">
      <section>
        <a href="<?php the_permalink(); ?>" class="hotel more">
         viac
        </a>
      </section>
    </div>
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

  <div class="row hide-p">

    <a href="<?php
    if(get_field('button1_href')){
      echo do_shortcode(get_field('button1_href'));
    }
    ?>" class="fp-btns col-md-4 "<?php
    if(get_field('button1_pozadie')){
      echo ' style="background-image: url('.get_field('button1_pozadie').')"';
    }
    ?>>
      <div class=" text-center fp-padding">
        <div class="fp-d"><?php
          if(get_field('button1_title')){
            echo do_shortcode(get_field('button1_title'));
          }
          ?></div>
        <h3><?php
          if(get_field('button1_h3')){
            echo do_shortcode(get_field('button1_h3'));
          }
          ?></h3>
        <div class="btn fp-hide">Viac informácií</div>
        <div class="fp-plusko"></div>
      </div>
    </a>

    <a href="<?php
    if(get_field('button2_href')){
      echo do_shortcode(get_field('button2_href'));
    }
    ?>" class="fp-btns col-md-4 "<?php
    if(get_field('button2_pozadie')){
      echo ' style="background-image: url('.get_field('button2_pozadie').')"';
    }
    ?>>
      <div class=" text-center fp-padding">
        <div class="fp-d"><?php
          if(get_field('button2_title')){
            echo do_shortcode(get_field('button2_title'));
          }
          ?></div>
        <h3><?php
          if(get_field('button2_h3')){
            echo do_shortcode(get_field('button2_h3'));
          }
          ?></h3>
        <div class="btn fp-hide">Viac informácií</div>
        <div class="fp-plusko"></div>
      </div>
    </a>

    <a href="<?php
    if(get_field('button3_href')){
      echo do_shortcode(get_field('button3_href'));
    }
    ?>" class="fp-btns col-md-4 "<?php
    if(get_field('button3_pozadie')){
      echo ' style="background-image: url('.get_field('button3_pozadie').')"';
    }
    ?>>
      <div class=" text-center fp-padding">
        <div class="fp-d"><?php
          if(get_field('button3_title')){
            echo do_shortcode(get_field('button3_title'));
          }
          ?></div>
        <h3><?php
          if(get_field('button3_h3')){
            echo do_shortcode(get_field('button3_h3'));
          }
          ?></h3>
        <div class="btn fp-hide">Viac informácií</div>
        <div class="fp-plusko"></div>
      </div>
    </a>
  </div>
  <?php endwhile;else:?>
    <p><?php _e('Sorry, this page does not exist.','lang'); ?></p>
  <?php endif;wp_reset_query(); ?>
<?php get_footer(); ?>