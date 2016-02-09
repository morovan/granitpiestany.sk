</article>
<footer>
  <div class="footer">
    <div class="container">
      <div class="footer-hotels">
        <?php
        $posts = get_posts(array('post_type' => 'hotel'));
        foreach ( $posts as $post ): ?>
        <?php if(get_field('hotel_url')){ echo '<a href="'.get_field('hotel_url').'">'; }else{ echo '<div class="hotel-not-url">'; } ?>
          <div>
            <?php if(basename(get_permalink())=='nova-polianka'){echo trans('hospital_lang', 'Hospital');}else{echo trans('hotel_lang', 'Hotel');} ?> Granit
            <strong><?php the_title(); ?></strong>
            <?php
              if(get_field('subtittle_hotel')){
                echo get_field('subtittle_hotel');
              }
            ?>
          </div>
        <?php if(get_field('hotel_url')){ echo '</a>'; }else{ echo '</div>'; } ?>
        <?php the_post($post); ?>
        <?php endforeach; ?>
        <div class="clear"></div>
      </div>
      <div class="row">
        <div class="col-md-9">
          <?php wp_nav_menu(array('theme_location'=>'footer_primary','items_wrap'=>'<ul class="nav navbar-nav">%3$s</li></ul>')); ?>
          <div class="row">
            <div class="col-md-5 col-sm-6">

            </div>
            <div class="col-md-5 col-sm-6">
              <?php echo trans('subscribe_text_lang', 'Subscribe to the newsletter and get overview for special offers.'); ?>
              <form action="http://<?php echo "$_SERVER[HTTP_HOST]"; ?>/send.php" method="post" enctype="multipart/form-data" target="send_target" onsubmit="startUpload();">
                <input type="text" name="name" class="sr-only">
                <input type="email" name="email" class="form-control" placeholder="<?php echo trans('subscribe_placeholder_lang', 'Enter your e-mail'); ?>">
                <input type="hidden" name="url" value="http://<?php echo $_SERVER[HTTP_HOST].$_SERVER['REQUEST_URI']; ?>">
                <input type="hidden" name="lang" value="<?php echo substr(get_locale(),0,-3); ?>">
                <input type="submit" value="<?php echo trans('subscribe_lang', 'Subscribe'); ?>" class="btn btn-primary">
                <div class="clear"></div>
              </form>
              <iframe id="send_target" name="send_target" src="http://<?php echo "$_SERVER[HTTP_HOST]"; ?>/n.php" border="0" class="send-to-nl"></iframe>
            </div>
          </div>
        </div>
        <div class="col-md-3 footer-right">
          <div class="text-right">
           <a href="https://www.facebook.com/Granit-Hotels-914412015308240/" target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/images/facebook.png" alt="Facebook"></a>
          </div>
          <?php query_posts('post_type=theme-settings');if(have_posts()):while(have_posts()):the_post(); ?>
          <div class="contact-info">
            <a href="tel:<?php if(get_field('tel')){echo get_field('tel');} ?>"><span class="ion-ios-telephone-outline ion"></span> <?php if(get_field('tel_space')){echo get_field('tel_space');} ?></a>
          </div>
          <div class="contact-info">
            <a href="mailto:<?php if(get_field('email')){echo get_field('email');} ?>"><span class="ion-ios-email-outline ion"></span> <?php if(get_field('email')){echo get_field('email');} ?></a>
          </div>
          <?php endwhile;endif;wp_reset_query(); ?>
        </div>
      </div>
    </div>
  </div>
  <div class="copiright">
    <div class="container">
      <div class="row">
        <div class="col-xs-7">
          Copyright &copy; 2015 HOREZZA, a.s. <?php echo trans('rights_lang', 'All&nbsp;rights&nbsp;reserved'); ?>
        </div>
        <div class="col-xs-5 text-right">
          by VISIBILITY
        </div>
      </div>
    </div>
  </div>
</footer>
<?php wp_footer(); ?>
<style type="text/css">#loader{display:none;}</style></body></html>