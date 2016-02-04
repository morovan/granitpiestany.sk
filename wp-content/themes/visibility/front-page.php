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
                <?php
                if(basename(get_permalink())=='nova-polianka'){echo trans('hospital_lang', 'Hospital');}else{echo trans('hotel_lang', 'Hotel');} ?> Granit
                <h1><?php the_title(); ?></h1>
                <?php
                  if(get_field('subtittle_hotel')){
                    echo get_field('subtittle_hotel');
                  }
                ?>
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
  <div class="row full-width">
    <div class="col-sm-6 col-md-3">
      <div class="main-sections">
        <div class="row header">
          <div class="col-xs-6">
            <h2><?php echo trans('newest_post_lang','Newest posts'); ?></h2>
          </div>
          <div class="col-xs-6 text-right">
            <a href="<?php echo get_permalink(get_option('page_for_posts')); ?>"><span class="ion-android-arrow-forward"></span> <?php echo __('All articles','lang'); ?></a>
          </div>
        </div>
      </div>
      <?php query_posts('posts_per_page=1');if(have_posts()):while(have_posts()):the_post(); ?>
      <a href="<?php the_permalink() ?>" class="hp-article row">
        <?php if(has_post_thumbnail()): ?>
        <div class="col-xs-6">
          <div class="hp-article-img" style="background-image:url(<?php echo get_the_post_thumbnail_src(get_the_post_thumbnail($post_id,'medium')); ?>)"></div>
        </div>
        <div class="col-xs-6">
        <?php else: ?>
        <div class="col-xs-12">
        <?php endif; ?>
          <div class="hp-article-text">
            <?php
            echo ' <time datetime="';
            the_time('Y-m-d');
            echo '" itemprop="datePublished">';
            the_time('j. F Y');
            echo '</time>';
            ?>
            <h3><?php the_title(); ?></h3>
          </div>
        </div>
      </a>
      <?php endwhile;endif;wp_reset_query(); ?>
    </div>
    <div class="col-sm-6 col-md-3">
      <div class="main-sections">
        <div class="row header">
          <div class="col-xs-6">
            <h2><?php echo trans('granit_videos_lang','Granit videos'); ?></h2>
          </div>
          <div class="col-xs-6 text-right">
            <a href="<?php
            $args = array(
              'post_type'  => 'page',
              'meta_query' => array(
                array(
                  'key'   => '_wp_page_template',
                  'value' => 'template-video.php'
                )
              )
            );
            query_posts($args);if(have_posts()):while(have_posts()):the_post(); echo get_the_permalink(); endwhile;endif;wp_reset_query(); ?>"><span class="ion-android-arrow-forward"></span> <?php echo trans('granit_videos_all_lang','All videos'); ?></a>
          </div>
        </div>
      </div>
      <?php query_posts('post_type=video&posts_per_page=1&order=ASC');if(have_posts()):while(have_posts()):the_post(); ?>
        <?php if(has_post_thumbnail()){if(get_field('video_file_mp4')){ ?>
        <div class="hp-video" data-toggle="modal" data-target="#video-<?php echo get_the_ID(); ?>">
          <div class="hp-article-img" style="background-image:url(<?php echo get_the_post_thumbnail_src(get_the_post_thumbnail($post_id,'full')); ?>)"><span class="ion-social-youtube-outline"></span></div>
        </div>
        <div class="modal fade" id="video-<?php echo get_the_ID(); ?>" tabindex="-1" role="dialog">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><?php the_title(); ?></h4>
              </div>
              <div class="modal-body">
              </div>
            </div>
          </div>
        </div>
          <script type="text/javascript">
            $(function(){
              $('#video-<?php echo get_the_ID(); ?>').on('shown.bs.modal',function(){
                $('#video-<?php echo get_the_ID(); ?> .modal-body').html('<video width="100%" height="490" class="c-video" controls><?php if(get_field("video_file_mp4")){ ?><source src="<?php echo get_field("video_file_mp4"); ?>" type="video/mp4"><?php }  if(get_field("video_file_ogg")){ ?><source src="<?php echo get_field("video_file_ogg"); ?>" type="video/ogg"><?php } ?>Your browser does not support the video tag.</video>');
                $('#video-<?php echo get_the_ID(); ?> video').get(0).play();
              })
              $('#video-<?php echo get_the_ID(); ?>').on('hidden.bs.modal',function(){
                $('#video-<?php echo get_the_ID(); ?> video').get(0).pause();
                $('#video-<?php echo get_the_ID(); ?> .modal-body').html('');
              });
            });
          </script>
        <?php }} ?>
      <?php endwhile;endif;wp_reset_query(); ?>
    </div>
    <div class="col-sm-6 col-md-3">
      <div class="main-sections">
        <div class="row header">
          <div class="col-xs-6">
            <h2>HOREZZA news</h2>
          </div>
          <div class="col-xs-6 text-right">
            <a href="<?php
            $args = array(
              'post_type'  => 'page',
              'meta_query' => array(
                array(
                  'key'   => '_wp_page_template',
                  'value' => 'template-horezza-news.php'
                )
              )
            );
            query_posts($args);if(have_posts()):while(have_posts()):the_post(); echo get_the_permalink(); endwhile;endif;wp_reset_query(); ?>"><span class="ion-android-arrow-forward"></span> <?php echo trans('horezza_news_all_lang','All news'); ?></a>
          </div>
        </div>
      </div>
      <div class="hp-hn-wrap">
        <div class="carousel-wrap hp-hn">
          <div id="carousel-horezza" class="owl-carousel">
            <?php query_posts('post_type=horezza-news&posts_per_page=-1');if(have_posts()):while(have_posts()):the_post(); ?>
              <div class="item">
                <div class="item-inner">
                  <a href="<?php the_permalink() ?>">
                    <?php if(has_post_thumbnail()): ?>
                      <div class="hn-car-img-wrap"><img src="<?php echo get_the_post_thumbnail_src(get_the_post_thumbnail($post_id,'large')); ?>" alt="<?php the_title(); ?>" class="post-thumbnail" width="100%"></div>
                    <?php endif; ?>
                    <h3><?php the_title(); ?></h3>
                  </a>
                </div>
              </div>
            <?php endwhile;endif;wp_reset_query(); ?>
          </div>
          <a data-slide="prev" role="button" href="#carousel-horezza" class="left carousel-control">
              <span class="ion ion-android-arrow-back"></span>
          </a>
          <a data-slide="next" role="button" href="#carousel-horezza" class="right carousel-control">
              <span class="ion ion-android-arrow-forward"></span>
          </a>
        </div>
      </div>
    </div>
    <div class="col-sm-6 col-md-3">
      <?php if($fb_url){ ?>
        <div class="facebook-wrap" ></div>
        <script type="text/javascript">
          (function(d, s, id){
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) return;
            js = d.createElement(s); js.id = id;
            js.src = "//connect.facebook.net/sk_SK/sdk.js#xfbml=1&version=v2.2";
            fjs.parentNode.insertBefore(js, fjs);
          }(document, 'script', 'facebook-jssdk'));
          $(function(){
            $fb_url = '<?php echo $fb_url; ?>';
            $data_width = $('.facebook-wrap').width()*1-1;
            $('.facebook-wrap').html('<div class="fb-page" data-href="'+$fb_url+'" data-tabs="timeline" data-width="'+$data_width+'" data-height="350" data-small-header="false" data-adapt-container-width="true" data-hide-cover="true" data-show-facepile="true"></div>');
            $(window).resize(function(){
              $data_width = $('.facebook-wrap').width()*1-1;
              $('.facebook-wrap').html('<div class="fb-page" data-href="'+$fb_url+'" data-tabs="timeline" data-width="'+$data_width+'" data-height="350" data-small-header="false" data-adapt-container-width="true" data-hide-cover="true" data-show-facepile="true"></div>');
              FB.XFBML.parse();
            });
          });
        </script>
      <?php } ?>
    </div>
  </div>
  <?php $args = array(
      'page_id' => $id_fp
    );
     query_posts($args);if(have_posts()):while(have_posts()):the_post(); ?>
    <?php if(get_field('introduction_img1')){
    if(get_field('introduction_img2') && get_field('introduction_img3') && get_field('introduction_img4') && get_field('introduction_img5')){ ?>
    <style type="text/css">
      .home .alt-navbar{
        background-image:url(<?php echo get_field('introduction_img1'); ?>);
      }
      .alt-navbar-slider-wrap{
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
        .home .alt-navbar{
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
    
<script type="text/javascript">
  $(document).ready(function() {

      var owl = $("#carousel-horezza");
      owl.owlCarousel({
        itemsCustom : [
          [1, 2],
          [1000, 2]
        ]
      });
      $(".carousel-wrap .right").click(function(){
          owl.trigger('owl.next');
          return false;
      });
      $(".carousel-wrap .left").click(function(){
          owl.trigger('owl.prev');
          return false;
      });

  });
</script>
<?php get_footer(); ?>