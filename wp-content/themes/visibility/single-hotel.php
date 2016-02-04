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

<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false"></script>
<script type="text/javascript">
  function initialize(lat, lng, canvasId, content) {

    var customMapType = new google.maps.StyledMapType([{
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
    ],{
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

  <div class="our-hotels about-granit">
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
                <a href="<?php echo get_permalink($parent_page_id) ?>"><span class="ion-android-arrow-back"></span>&nbsp;<?php echo trans('back_to_hotels_lang', 'back to hotels') ?></a>
              </div>
              <?php endif; ?>
              </div>
              <div class="col-md-12">
                <h1>
                  <?php if(basename(get_permalink())!='nova-polianka'){ ?>
                  <?php echo trans('one_hotel_title_lang', 'About hotel'); ?>
                  <?php }else{ ?>
                  <?php echo trans('one_hospital_title_lang', 'About hospital'); ?>
                  <?php } ?>
                </h1>
              </div>
          </div>
      </div>
      <section>
        <div class="row our-hotel">
          <div class="col-sm-6 our-hotel our-hotel-img-wrap">
            <?php if(get_field('hotel_img')){ ?>
              <div class="our-hotel-img" style="background-image:url(<?php echo get_field('hotel_img'); ?>)">
                <?php if($map = get_field('hotel_map')){ ?>
                  <div class="our-hotel-img-sidebar">
                    <?php
                    if(get_field('hotel_img_2')){
                      if(get_field('hotel_img_1')){
                        echo '<div class="hotel-sidebar-img half hotel-sidebar-img-1" style="background-image:url('.get_field('hotel_img_1').')"></div><div class="hotel-sidebar-img half hotel-sidebar-img-2" style="background-image:url('.get_field('hotel_img_2').')"></div><div class="hotel-sidebar-map" data-toggle="modal" data-target="#hotel-sidebar-map-'.basename(get_permalink()).'" onclick="loadmap_'.get_the_ID().'();"></div>';
                      }else{
                        echo '<div class="hotel-sidebar-img hotel-sidebar-img-2" style="background-image:url('.get_field('hotel_img_2').')"></div><div class="hotel-sidebar-map two" data-toggle="modal" data-target="#hotel-sidebar-map-'.basename(get_permalink()).'" onclick="loadmap_'.get_the_ID().'();"></div>';
                      }
                    }else{
                      if(get_field('hotel_img_1')){
                        echo '<div class="hotel-sidebar-img hotel-sidebar-img-1" style="background-image:url('.get_field('hotel_img_1').')"></div><div class="hotel-sidebar-map two" data-toggle="modal" data-target="#hotel-sidebar-map-'.basename(get_permalink()).'" onclick="loadmap_'.get_the_ID().'();"></div>';
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
                    $(function(){
                      <?php if(get_field('hotel_img_1')){ ?>
                      $('.hotel-sidebar-img-1').html('<a href="<?php echo get_field('hotel_img_1'); ?>" data-rel="'+$('#gallery a').data('rel')+'"></a>');
                      <?php } if(get_field('hotel_img_2')){  ?>
                      $('.hotel-sidebar-img-2').html('<a href="<?php echo get_field('hotel_img_2'); ?>" data-rel="'+$('#gallery a').data('rel')+'"></a>');
                      <?php } ?>
                    });
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
                <?php } ?>
              </div>
            <?php } ?>
          </div>
          <div class="col-sm-6 our-hotel">
            <div class="container-half">
              <span class="text-uppercase"><?php if(basename(get_permalink())=='nova-polianka'){echo trans('hospital_lang', 'Hospital');}else{echo trans('hotel_lang', 'Hotel');} ?> Granit</span>
              <h2><?php the_title(); ?></h2>
              <?php
                if(get_field('subtittle_hotel')){
                  echo '<div class="subtittle">'.get_field('subtittle_hotel').'</div>';
                }
              ?>
              <p>
              <?php
              if (get_field('about_hotel_right')) {
                  echo get_field('about_hotel_right');
              }
              ?>
              </p>
              <div class="row">

                <div class="col-lg-5">
                  <?php if (get_field('hotel_url')) { ?>
                    <a class="btn btn-more no-margins"
                     href="<?php echo get_field('hotel_url'); ?>">
                    <?php if(basename(get_permalink())!='nova-polianka'){ ?>
                      <?php echo trans('hotel_url_lang', 'Hotel site') ?>
                    <?php }else{ ?>
                      <?php echo trans('hospital_url_lang', 'Hospital site') ?>
                    <?php } ?>
                    </a>
                    <?php } ?>
                </div>
                  <?php if(basename(get_permalink())!='nova-polianka'){ ?>
                    <div class="col-lg-6 col-lg-offset-1 our-hotel-links">
                      <a href="<?php the_permalink(); ?>#book"><span
                        class="ion-ios-calendar-outline ion"></span> <?php echo trans('hotel_reservation_lang', 'Hotel Reservation') ?>
                      </a>
                      <a href="<?php echo $offers_url.'?hotel=' . basename( get_permalink($post->ID)); ?>"><span
                        class="ion-ios-star-outline ion"></span> <?php echo trans('hotel_offers_lang', 'Hotel Offers'); ?>
                      </a>
                      <?php if (get_field('prices_doc')) {
                        echo '<a href="'.get_field('prices_doc').'" target="_blank"><span class="ion-social-euro-outline ion"></span> '.trans('prices_doc_lang', 'View prices').'</a>';
                      }
                      ?>
                    </div>
                    <?php } ?>
              </div>
            </div>
          </div>
        </div>
       </section>

        <div class="container single-hotel">

          <?php echo do_shortcode(get_the_content()); ?>
          <?php if(basename(get_permalink())!='nova-polianka'){ ?>
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
        <?php } ?>
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