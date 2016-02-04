<?php
/*
Template Name: Template Our Hotels
*/
get_header(); ?>

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

<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false"></script>
  <script type="text/javascript">
    function initialize(lat, lng, canvasId, content) {
      
      var customMapType = new google.maps.StyledMapType([
        {
          "featureType": "landscape",
          "elementType": "all",
          "stylers":[{
            "hue": "#FFBB00"
          },{
            "saturation": 43.4
          },{
            "lightness": 37.6
          },{
            "gamma": 1
          }]
        },{
          "featureType": "poi",
          "elementType": "all",
          "stylers":[{
            "hue": "#88ff00"
          }]
        },{
          "featureType": "road.highway",
          "elementType": "all",
          "stylers":[{
            "hue": "#FFC200"
          },{
            "saturation": -61.8
          },{
            "lightness": 45.6
          },{
            "gamma": 1
          }]
        },{
          "featureType": "road.arterial",
          "elementType": "all",
          "stylers":[{
            "hue": "#FF0300"
          },{
            "saturation": -100
          },{
            "lightness": 51.2
          },{
            "gamma": 1
          }]
        },{
          "featureType": "road.local",
          "elementType": "all",
          "stylers":[{
            "hue": "#FF0300"
          },{
            "saturation": -100
          },{
            "lightness": 52
          },{
            "gamma": 1
          }]
        },{
          "featureType": "water",
          "elementType": "all",
          "stylers":[{
            "hue": "#0078FF"
          },{
            "saturation": -13.2
          },{
            "lightness": 2.4
          },{
            "gamma": 1
          }]
        }
        ], {
          name: 'Custom Style'
      });
      var customMapTypeId = 'custom_style';
  
      var mapOptions = {
        zoom: 8,
        center: new google.maps.LatLng(lat, lng),
        disableDefaultUI: true,
        zoomControl: true,
        scaleControl: true,
        mapTypeControlOptions: {
          mapTypeIds: [google.maps.MapTypeId.ROADMAP, customMapTypeId]
        }
      };
      var map = new google.maps.Map(document.getElementById(canvasId),
        mapOptions);
        
      map.mapTypes.set(customMapTypeId, customMapType);
      map.setMapTypeId(customMapTypeId);

      var infowindow = new google.maps.InfoWindow({
        content: content
      });

      var image = '<?php echo get_template_directory_uri(); ?>/images/granit-marker.png';
      var latLngObj = new google.maps.LatLng(lat,lng);
      var markerObj = new google.maps.Marker({
        position: latLngObj,
        animation: google.maps.Animation.DROP,
        map: map,
        icon: image
      });

      google.maps.event.addListener(markerObj, 'click', toggleBounce);

      function toggleBounce() {
        if(markerObj.getAnimation() !== null){
          markerObj.setAnimation(null);
        }else{
          markerObj.setAnimation(google.maps.Animation.BOUNCE);
          infowindow.open(map,markerObj);
        }
      }
    }

    $(window).resize(function(){
      $('.map-canvas.dynamic-height').height($(window).height()-140+'px');
    });
  </script>

<div class="our-hotels">

  
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
    
  <?php
  $posts_loop = new WP_Query(array('post_type' => 'hotel'));
  $i = 1;

  while($posts_loop->have_posts()) : ?>
    <?php $posts_loop->the_post()?>
    <section>
      <div class="row our-hotel">
<!--        --><?php //if($i % 2 == 1): ?>
        <div class="col-sm-6 our-hotel our-hotel-img-wrap<?php echo ($i % 2 == 0 ? ' pull-right' : ''); echo ' '.basename(get_permalink()); ?>">
          <?php if(get_field('hotel_img')){ ?>
            <div class="our-hotel-img" style="background-image:url(<?php echo get_field('hotel_img'); ?>)">
              <?php if($map = get_field('hotel_map')){ ?>
                <div class="our-hotel-img-sidebar clicable">
                  <?php
                  if(get_field('hotel_img_2')){
                    if(get_field('hotel_img_1')){
                      echo '<div class="hotel-sidebar-img half" style="background-image:url('.get_field('hotel_img_1').')" data-toggle="modal" data-target="#hotel-gallery-1-'.basename(get_permalink()).'"></div><div class="hotel-sidebar-img half" style="background-image:url('.get_field('hotel_img_2').')" data-toggle="modal" data-target="#hotel-gallery-2-'.basename(get_permalink()).'"></div><div class="hotel-sidebar-map" data-toggle="modal" data-target="#hotel-sidebar-map-'.basename(get_permalink()).'" onclick="loadmap_'.get_the_ID().'();"></div>';
                    }else{
                      echo '<div class="hotel-sidebar-img" style="background-image:url('.get_field('hotel_img_2').')" data-toggle="modal" data-target="#hotel-gallery-2-'.basename(get_permalink()).'"></div><div class="hotel-sidebar-map two" data-toggle="modal" data-target="#hotel-sidebar-map-'.basename(get_permalink()).'" onclick="loadmap_'.get_the_ID().'();"></div>';
                    }
                  }else{
                    if(get_field('hotel_img_1')){
                      echo '<div class="hotel-sidebar-img" style="background-image:url('.get_field('hotel_img_1').')" data-toggle="modal" data-target="#hotel-gallery-1-'.basename(get_permalink()).'"></div><div class="hotel-sidebar-map two" data-toggle="modal" data-target="#hotel-sidebar-map-'.basename(get_permalink()).'" onclick="loadmap_'.get_the_ID().'();"></div>';
                    }else{
                      echo '<div class="hotel-sidebar-map three" data-toggle="modal" data-target="#hotel-sidebar-map-'.basename(get_permalink()).'" onclick="loadmap_'.get_the_ID().'();"></div>';
                    }
                  }
                  ?></div>
                <script type="text/javascript">
                  function loadmap_<?php echo get_the_ID(); ?>(){
                    setTimeout(function(){
                      <?php echo 'initialize('.$map['lat'].', '.$map['lng'].', "map-canvas-'.basename(get_permalink()).'", "'.$map['address'].'");'; ?>
                      $('.map-canvas.dynamic-height').height($(window).height()-140+'px');
                    },500);
                  }
                </script>
                <div class="modal fade" id="hotel-sidebar-map-<?php echo basename(get_permalink()); ?>" tabindex="-1" role="dialog">
                  <div class="modal-dialog modal-full">
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title"><?php echo (isset($map['address']) ? $map['address'] : ''); ?></h4>
                      </div>
                      <div class="modal-body">
                        <div class="map-canvas dynamic-height" id="map-canvas-<?php echo basename(get_permalink()); ?>"></div>
                      </div>
                    </div>
                  </div>
                </div>
                <?php if(get_field('hotel_img_1')){ ?>
                <div class="modal fade" id="hotel-gallery-1-<?php echo basename(get_permalink()); ?>" tabindex="-1" role="dialog">
                  <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title"><?php the_title(); ?></h4>
                      </div>
                      <div class="modal-body">
                        <img src="<?php echo get_field('hotel_img_1'); ?>" width="100%" alt="<?php the_title(); ?>">
                      </div>
                      <?php if(get_field('hotel_img_2')){ ?>
                      <div class="modal-footer gallery-footer">
                        <div class="row">
                          <div class="col-sm-6">
                            <span class="ion-android-arrow-back"></span>
                          </div>
                          <div class="col-sm-4 text-left">
                            <span class="ion-android-arrow-forward clicable" data-toggle="modal" data-dismiss="modal" data-target="#hotel-gallery-2-<?php echo basename(get_permalink()); ?>"></span>
                          </div>
                          <div class="col-sm-2 more-gallery">
                            <a href="<?php the_permalink()?>#gallery"><?php echo trans('more_photos_lang', 'More photos'); ?></a>
                          </div>
                        </div>
                      </div>
                      <?php } ?>
                    </div>
                  </div>
                </div>
                <?php } ?>
                <?php if(get_field('hotel_img_2')){ ?>
                  <div class="modal fade" id="hotel-gallery-2-<?php echo basename(get_permalink()); ?>" tabindex="-1" role="dialog">
                    <div class="modal-dialog modal-lg">
                      <div class="modal-content">
                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                          <h4 class="modal-title"><?php the_title(); ?></h4>
                        </div>
                        <div class="modal-body">
                          <img src="<?php echo get_field('hotel_img_2'); ?>" width="100%" alt="<?php the_title(); ?>">
                        </div>
                        <?php if(get_field('hotel_img_1')){ ?>
                          <div class="modal-footer gallery-footer">
                            <div class="row">
                              <div class="col-sm-6">
                                <span class="ion-android-arrow-back clicable" data-toggle="modal" data-dismiss="modal" data-target="#hotel-gallery-1-<?php echo basename(get_permalink()); ?>"></span>
                              </div>
                              <div class="col-sm-4 text-left">
                                <span class="ion-android-arrow-forward"></span>
                              </div>
                              <div class="col-sm-2 more-gallery">
                                <a href="<?php the_permalink()?>#gallery"><?php echo trans('more_photos_lang', 'More photos'); ?></a>
                              </div>
                            </div>
                          </div>
                        <?php } ?>
                      </div>
                    </div>
                  </div>
                <?php } ?>
              <?php } ?>
            </div>
          <?php } ?>
        </div>
<!--        --><?php //endif; ?>
        <div class="col-sm-6 our-hotel">
          <div class="container-half <?php echo ($i % 2 == 0 ? 'container-right' : ''); ?>">
            <a href="<?php the_permalink()?>" class="dark-brown">
              <span class="text-uppercase"><?php if(basename(get_permalink())=='nova-polianka'){echo trans('hospital_lang', 'Hospital');}else{echo trans('hotel_lang', 'Hotel');} ?> Granit</span>
              <h2><?php the_title(); ?></h2>
              <?php
                if(get_field('subtittle_hotel')){
                  echo '<div class="subtittle">'.get_field('subtittle_hotel').'</div>';
                }
              ?>
            </a>
            <p>
            <?php
            if (get_field('about_hotel_right')) {
              echo get_field('about_hotel_right');
            }
            ?>
            </p>
            <div class="row">

              <div class="col-lg-5">
                <a class="btn btn-more no-margins" href="<?php the_permalink(); ?>">
                  <?php if(basename(get_permalink())!='nova-polianka'){ ?>
                    <?php echo trans('more_about_hotel_lang', 'More about hotel') ?>
                  <?php }else{ ?>
                    <?php echo trans('more_about_hospital_lang', 'More about hospotal') ?>
                  <?php } ?>
                </a>
              </div>

              <div class="col-lg-6 col-lg-offset-1 our-hotel-links">
                <?php if(basename(get_permalink())!='nova-polianka'){ ?><a href="<?php the_permalink(); ?>#book"><span class="ion-ios-calendar-outline ion"></span> <?php echo trans('hotel_reservation_lang', 'Hotel Reservation') ?> </a>
                  <a href="<?php echo $offers_url.'?hotel='.basename(get_the_permalink()); ?>"><span class="ion-ios-star-outline ion"></span> <?php echo trans('hotel_offers_lang', 'Hotel Offers'); ?></a>
                  <?php if(get_field('hotel_url')){ ?>
                  <a href="<?php echo get_field('hotel_url'); ?>"><span class="ion-ios-information-outline ion"></span> <?php echo trans('hotel_url_lang', 'Hotel site'); ?></a>
                  <?php } ?>
                <?php }else{ ?>
                  <?php if(get_field('hotel_url')){ ?>
                  <a href="<?php echo get_field('hotel_url'); ?>"><span class="ion-ios-information-outline ion"></span> <?php echo trans('hospital_url_lang', 'Hospital site'); ?></a>
                  <?php } ?>
                <?php } ?>
              </div>

            </div>

          </div>
        </div>
      </div>
    </section>
    <?php $i++; ?>
 <?php endwhile; ?>
  <?php wp_reset_postdata();?>

</div>

<?php get_footer(); ?>