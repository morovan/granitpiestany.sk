<?php get_header(); ?>
  <div class="container post-detail position-detail">
    <div class="row">
      <div class="col-sm-12">
        <?php if (have_posts()):while (have_posts()):the_post(); ?>
        <h1><?php the_title(); ?></h1><br>
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
    </div>
    <div class="row">
      <div class="col-md-12">
        <div class='cta bg-brown'>
          <div
            class='cta-heading text-center'><?php echo trans('cta_interesting_about_position_lang', 'Are you interesting in?') ?></div>
          <div class='cta-body text-center'><?php echo trans('cta_send_to_email_lang', 'Please send email to: ') ?>
            <?php
            if (get_field('position_cta_email')) {
              echo '<a
                href="mailto:' . get_field('position_cta_email') . '">' . get_field('position_cta_email') . '</a>';
            } else {
              echo '<a
                href="mailto:info@granithotels.sk">info@granithotels.sk</a>';
            }
            ?>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="share m-top-40">
        <a onclick="nwindow();" target="ppw" class="social fb"
         href="https://www.facebook.com/sharer/sharer.php?u=<?php the_permalink(); ?>"><span
          class="sr-only">Facebook share</span><i class="fa fa-facebook"></i></a>
        <a onclick="nwindow();" target="ppw" class="social gp"
         href="https://plus.google.com/share?url=<?php the_permalink(); ?>"><span class="sr-only">Google plus share</span><i
          class="fa fa-google-plus"></i></a>
        <a onclick="nwindow();" target="ppw" class="social tw"
         href="https://twitter.com/share?url=<?php the_permalink(); ?>"><span
          class="sr-only">Tweet</span><i class="fa fa-twitter"></i></a>
        <a onclick="nwindow();" target="ppw" class="social lin"
         href="https://www.linkedin.com/shareArticle?url=<?php the_permalink(); ?>"><span
          class="sr-only">Linkedin share</span><i class="fa fa-linkedin"></i></a>
        <a href="mailto:?Subject=<?php the_title(); ?>&body=<?php the_permalink(); ?>"
          class="social mail"><span class="sr-only"><?php _e('Forward', 'lang'); ?></span><i
          class="fa fa-envelope"></i></a>
        <div class="clear"></div>
      </div>
    </div>
  </div>
<?php get_footer(); ?>