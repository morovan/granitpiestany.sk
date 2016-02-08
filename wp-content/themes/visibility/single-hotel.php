<?php get_header(); ?>

      <div class="container">

          <?php if (have_posts()):while (have_posts()): the_post(); ?>

        
              <span class="text-uppercase"><?php if(basename(get_permalink())=='nova-polianka'){echo trans('hospital_lang', 'Hospital');}else{echo trans('hotel_lang', 'Hotel');} ?> Granit</span>
              <h2><?php the_title(); ?></h2>
              <?php
                if(get_field('subtittle_hotel')){
                  echo '<div class="subtittle">'.get_field('subtittle_hotel').'</div>';
                }
              ?>
              
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

      <?php endwhile;else: ?>
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