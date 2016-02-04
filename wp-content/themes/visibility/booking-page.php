<?php
/*
Template Name: Booking page
*/

get_header(); ?>

<div class="container">
  <?php if(have_posts()):while(have_posts()):the_post(); ?>
    <?php if(has_post_thumbnail()): ?>
      <img src="<?php echo get_the_post_thumbnail_src(get_the_post_thumbnail($post_id,'large')); ?>" alt="<?php the_title(); ?>" class="post-thumbnail" width="100%">
    <?php endif; ?>
    <h1><?php the_title(); ?></h1>
    <?php if($_GET['booking_error']=='conn'){ ?>
    <h2>Chyba pri odosielaní formuláru</h2>
    <p>Je nám ľúto, ale pri odosielaní formuláru nastala chyba :(</p>
    <p>Prosím kontaktujte nás na e-mail <a href="mailto:info@granit.sk">info@granit.sk</a></p>
    <?php }else if($_GET['booking_error']=='required'){ ?>
    <h2>Chyba pri odosielaní formuláru</h2>
    <p>Nevyplnili ste povinné polia.</p>
    <p>Prosím vyplňte všetky povinné polia.</p>
    <?php } ?>
    <div class="booking outthere">
      <div class="booking-form" id="booking-page">
        <div class="text-center">
          <span class="ion-ios-information-outline ion"></span> Prosíme, vyplňte všetky uvedené políčka, recepcia Vás bude následne kontaktovať.
        </div>
        <div class="booking-form-wrap">
          <?php $hotel=1;include 'booking.php'; ?>
        </div>
      </div>
    </div>
    <div class="share">
      <a href="javascript:window.print();" class="social print"><span class="sr-only"><?php _e('Print','lang'); ?></span><i class="fa fa-print"></i></a>
      <div class="clear"></div>
    </div>
  <?php endwhile; else: ?>
    <h1><?php _e('Sorry, this page does not exist.','lang'); ?></h1>
    <p><a href="<?php echo get_home_url(); ?>"><?php _e('Go to home page','lang'); ?></a> <?php _e('or use search','lang'); ?>:</p>
    <?php
      get_search_form();
    ?>
  <?php endif; ?>
</div>
<?php get_footer(); ?>