<?php
/*
Template Name: Template Contact
*/
get_header(); ?>
<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false"></script>
  <script type="text/javascript">
    function initialize(lat, lng, canvasId, content){
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
  </script>
<div class="container page-contact">
  <?php if(have_posts()):while(have_posts()):the_post(); ?>
    <?php if(has_post_thumbnail()): ?>
      <img src="<?php echo get_the_post_thumbnail_src(get_the_post_thumbnail($post_id,'large')); ?>" alt="<?php the_title(); ?>" class="post-thumbnail" width="100%">
    <?php endif; ?>
    <h1><?php the_title(); ?></h1>
    <?php echo do_shortcode(get_the_content()); ?>
    <?php endwhile; else: ?>
      <h1><?php _e('Sorry, this page does not exist.','lang'); ?></h1>
      <p><a href="<?php echo get_home_url(); ?>"><?php _e('Go to home page','lang'); ?></a> <?php _e('or use search','lang'); ?>:</p>
      <?php
       get_search_form();
      ?>
    <?php endif; ?>
    <?php query_posts('post_type=hotel');if(have_posts()):while(have_posts()):the_post(); ?>
    <div class="row contact-hotel-detail">
      <div class="col-md-6">
        HOTEL GRANIT
        <h3>
         <?php the_title() ?>
        </h3>
        <div class="subtittle_contact">
        <?php
          if(get_field('subtittle_hotel')){
            echo get_field('subtittle_hotel');
          }
        ?></div>
        <p><br>
          <?php
          if($map = get_field('hotel_map')){
            echo (isset($map['address']) ? $map['address'] : '');
          }
          ?>
          <br/><br/>
          <?php
          if(get_field('hotel_phone')){
            echo get_field('hotel_phone');
          }
          ?><br/>
        <a href="mailto:<?php echo (get_field('hotel_email') ? get_field('hotel_email') : '')?>"><?php echo (get_field('hotel_email') ? get_field('hotel_email') : ''); ?></a><br/>
        <a target="_blank" href="<?php echo (get_field('hotel_url') ? get_field('hotel_url') : '')?>"><?php if(basename(get_permalink())!='nova-polianka'){ echo trans('hotel_url_lang', 'Hotel site'); }else{ echo trans('hospital_url_lang', 'Hospital site'); } ?></a>
        </p>
      </div>
      <div class="col-md-6">
        <div class="map-canvas" id="map-canvas-<?php echo basename(get_permalink()); ?>"></div>
          <script type="text/javascript">
            <?php if($map = get_field('hotel_map')):
              echo 'initialize('.$map['lat'].', '.$map['lng'].', "map-canvas-'.basename(get_permalink()).'", "'.$map['address'].'");';
            endif; ?>
          </script>
      </div>
    </div>
    <?php endwhile;endif;wp_reset_query(); ?>
</div>
<?php get_footer(); ?>