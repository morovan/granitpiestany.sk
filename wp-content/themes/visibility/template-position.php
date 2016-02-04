<?php
/*
Template Name: Template Position
*/
get_header(); ?>

  <div class="our-hotels positions">
    <?php if (have_posts()):while (have_posts()):the_post(); ?>
    <h1><?php the_title() ?></h1>
    <section>
      <div class="row our-hotel">
        <div class="col-sm-6 our-hotel our-hotel-img-wrap">
          <?php if (has_post_thumbnail()) { ?>
          <div class="our-hotel-img"
            style="background-image:url(<?php echo get_the_post_thumbnail_src(get_the_post_thumbnail($post_id, 'large')); ?>)">
          </div>
          <?php } ?>
        </div>
        <div class="col-sm-6 our-hotel">
          <div class="container-half">
            <div class="row">
              <div class="col-md-12">
              <?php
              the_content();
              ?>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="pull-left">
                  <a class="btn btn-more no-margins m-top-20"
                    href="<?php the_permalink(); ?>#position-table"><?php echo trans('positions_lang', 'Positions') ?></a>
                </div>
              </div>
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
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="panel-group" id="position-table" role="tablist" aria-multiselectable="true">
          <?php
            query_posts('post_type=position&posts_per_page=-1');
            if (have_posts()):while (have_posts()):the_post();
          ?>
          <div class="panel panel-position">
            <div class="panel-heading" role="tab" id="heading-<?php the_ID() ?>">
              <div class="row panel-title">
                <a class="col-sm-3 position-title collapsed"
                 role="button" data-toggle="collapse" data-parent="#accordion"
                 aria-expanded="true" aria-controls="collapse-<?php the_ID() ?>"
                 href="#collapse-<?php the_ID() ?>"
                  ><h3>
                  <?php the_title(); ?>
                </h3>
                </a>
                <span class="col-sm-3 position-for-hotel">
                <?php if (get_field('position_horel')) : ?>
                  <?php $hotels = get_field('position_horel'); ?>
                  <?php foreach ($hotels as $hotel): ?>
                    <?php
                    echo 'Hotel GRANIT ' . '<span>' . $hotel->post_title . '</span>';
                    echo(end($hotels) != $hotel ? ', ' : '') ?>
                  <?php endforeach; ?>
                <?php endif ?>
                </span>
                <span class="col-sm-3">
                  <?php
                  if (get_field('position_type')) {
                    echo get_field('position_type');
                  }
                  ?>
                </span>
                <span class="col-sm-3 text-right">
                  <a class="panel-close p-r-25"
                     data-href="heading-<?php the_ID() ?>"><span
                    class="ion-android-close"></span>
                  </a>
                  <a class="more p-r-25" data-href="heading-<?php the_ID() ?>">
                    <span class="ion-android-arrow-forward"></span>
                    <?php echo trans('position_read_more_lang', 'Read more'); ?>
                  </a>
                </span>
              </div>
            </div>
            <div id="collapse-<?php the_ID() ?>" class="panel-collapse collapse" role="tabpanel"
              aria-labelledby="heading-<?php the_ID() ?>">
              <div class="panel-body">
                <?php if (get_field('position_horel')) { ?>
                <?php $hotels = get_field('position_horel'); ?>
                <?php foreach ($hotels as $hotel): ?>
                  <?php
                    $args = array(
                      'post_type' => 'hotel',
                      'p'         => $hotel->ID
                    );
                  $posts_hotel = get_posts($args); ?>
                  <h4><?php echo trans('position_place_lang', 'Position for hotel'); ?></h4>
                  <p>
                    <?php foreach ($posts_hotel as $post_hotel): ?>
                    <?php echo 'Hotel GRANIT';
                      the_title(); ?>
                    <?php if ($map = get_field('hotel_map')) : ?>
                    <?php echo ' ' . $map['address']; ?>
                    <?php endif;
                      endforeach; ?>
                    <?php endforeach; ?>
                  </p> <?php } ?>

                  <?php the_content(); ?>

                  <h4><?php echo trans('position_type_lang', 'Contract type'); ?></h4>
                  <p>
                    <?php
                      if (get_field('position_type')) {
                        echo get_field('position_type');
                      }
                      ?>
                  </p>
                  <div class='cta bg-brown'>
                    <div
                      class='cta-heading text-center'><?php echo trans('cta_interesting_about_position_lang', 'Are you interesting in?') ?>
                    </div>
                    <div class='cta-body text-center'><?php echo trans('cta_send_to_email_lang', 'Please send email to: ') ?>
                      <?php
                        if (get_field('position_cta_email')) {
                          echo '<a
                            href="mailto:' . get_field('position_cta_email') . '">' . get_field('position_cta_email') . '</a>';
                        }else{
                          echo '<a
                          href="mailto:info@granithotels.sk">info@granithotels.sk</a>';
                        }
                      ?>
                    </div>
                  </div>
              </div>
            </div>
          </div>
          <?php
            endwhile;endif;
            wp_reset_query();
          ?>
      </div>
    </div>
  </div>
  <p>&nbsp;</p>
  <?php if(get_field('career_under_positions')){ echo do_shortcode(get_field('career_under_positions')); } ?>
</div>

<script type="text/javascript">
  $(document).ready(function () {
    $('#position-table').on('show.bs.collapse', function () {
      $('#position-table .in').collapse('hide');
    });

    $('#position-table').on('show.bs.collapse', function (e) {
      $(e.target).prev('.panel-heading').addClass('active');
    })
    .on('hide.bs.collapse', function (e) {
      $(e.target).prev('.panel-heading').removeClass('active');
    });

    $('a.panel-close, a.more').click(function () {
      var $this = $(this);
      var heading = $this.data('href');
      $("#" + heading).find('.position-title').trigger('click');
    })
  });
</script>
<?php get_footer(); ?>