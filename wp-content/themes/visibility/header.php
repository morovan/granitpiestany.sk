<!DOCTYPE html><html lang="<?php echo substr(get_locale(),0,-3); ?>"><head><!--
    _        _
   | | _    | |
   | || | _ | |
 _ | || || || |
| || || || || |
| || || || || |                                            internet marketing agency
| || || || || |   __        __ _   _____ _   ____    _   _      _  _______ __     __
| || || || || |   \ \      / /| | / ___/| | |  _ \  | | | |    | ||__   __|\ \   / /
| || || || || |    \ \    / / | || |__  | | | |_> | | | | |    | |   | |    \ \ / /
| || || || || |     \ \  / /  | | \__ \ | | |  _ <  | | | |    | |   | |     \ ˇ /
| || || || || |      \ \/ /   | | ___| || | | |_> | | | | |___ | |   | |      | |
|_||_||_||_||_|       \__/    |_|/____/ |_| |____/  |_| |_____||_|   |_|      |_|

                                 www.visibility.sk

--><meta charset="utf-8"><meta http-equiv="X-UA-Compatible" content="IE=edge"><title><?php wp_title( '|', true, 'right' ); ?></title><meta name="viewport" content="width=device-width, initial-scale=1.0"><meta name="author" content="<?php echo get_bloginfo('name'); ?>"><link rel="icon" href="<?php echo get_site_url(); ?>/favicon.ico"><link href='https://fonts.googleapis.com/css?family=PT+Serif:400,700italic,700,400italic&subset=latin,latin-ext' rel='stylesheet' type='text/css'><link href="<?php bloginfo('stylesheet_url');?>" rel="stylesheet"><!--[if lt IE 9]><link href="<?php echo get_template_directory_uri(); ?>/ie.min.css" rel="stylesheet"><script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script><![endif]--><script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script><script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/bootstrap/js/bootstrap.min.js"></script><script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/main.js"></script><!--[if lt IE 9]><script src="<?php echo get_template_directory_uri(); ?>/js/ie.js"></script><![endif]-->
<!-- booking start -->
<link href="<?php echo get_template_directory_uri(); ?>/booking.css" rel="stylesheet"><script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/booking.js"></script>
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/picker/picker.js"></script><script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/picker/picker.date.js"></script>
<?php if(get_locale()!='en_US'){ ?><script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/picker/languages/<?php echo get_locale(); ?>.js"></script><?php } ?>
  <link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/js/owl-carousel/owl.carousel.css">
<!-- booking end -->
  <script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/owl-carousel/owl.carousel.min.js"></script>
<?php wp_head();
query_posts('post_type=theme-settings');if(have_posts()):while(have_posts()):the_post();

if(get_field('cookies_strip')){
  echo '<script src="//s3-eu-west-1.amazonaws.com/fucking-eu-cookies/cz.js" async></script><style type="text/css">.fucking-eu-cookies{z-index:10000 !important;padding:3px !important;background:#fff !important;position:absolute !important;width:100%}.fucking-eu-cookies button{background:';
  if(get_field('cookies_strip_btn_bg')){
    echo get_field('cookies_strip_btn_bg');
  }else{
    echo '#3e5071';
  }
  echo ';padding:0 8px;color:#fff;border:none;border-radius:4px}.fucking-eu-cookies button:hover{background:';
  if(get_field('cookies_strip_btn_bg_hover')){
    echo get_field('cookies_strip_btn_bg_hover');
  }else{
    echo '#942b1e';
  }
  echo '}</style><script>var fucking_eu_config = {"l18n": {"text": "';
  _e('This website uses cookies to provide services, personalization of advertising and analytics. By using this website you agree with use of cookies.','lang');
  echo '","accept": "';
  _e('Continue','lang');
  echo '","more": "';
  _e('More information','lang');
  echo '","link": "https://www.google.com/intl/';
  echo substr(get_locale(),0,-3);
  echo '/policies/technologies/cookies/"}};</script>';
}

if(get_field('head_other_elements')){
  echo get_field('head_other_elements').'
';
}

endwhile;endif;wp_reset_query();
?>
</head>
<body role="document" itemscope itemtype="http://schema.org/WebPage"<?php if(current_user_can('manage_options')){if(is_front_page()){body_class("admin home");}else{body_class("admin");}}elseif(is_front_page()){body_class("home");} ?>><div style="position:fixed;left:0;top:0;width:100%;height:100%;background:#fff;z-index:10000" id="loader"></div>
<?php

query_posts('post_type=theme-settings');if(have_posts()):while(have_posts()):the_post();

if(get_field('body_other_elements')){
  echo get_field('body_other_elements').'
';
}

endwhile;endif;wp_reset_query();

?><div id="fb-root"></div>
<div id="totop"><span class="go-up ion-ios-arrow-thin-up" aria-hidden="true"></span><span class="sr-only"><?php echo __( 'Top', 'lang' ); ?></span></div>
<div class="print-header">
  <img src="<?php echo get_template_directory_uri(); ?>/images/logo-md.png" alt="<?php echo get_bloginfo('name'); ?>" width="174" height="181">
  <div>
    <span><?php echo get_bloginfo('name'); ?></span>
    www.<?php echo $_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI']; ?>
  </div>
  <div class="clear"></div>
</div>
<header>
  <div id="fullsearch">
    <?php
    add_filter('get_search_form','fullsearch_form');
    get_search_form();
    remove_filter('get_search_form','fullsearch_form');
    ?>
  </div>
  <div class="navbar navbar-fixed-top" role="navigation">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
        <span class="sr-only"><?php echo __( 'Toggle navigation', 'lang' ); ?></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <h1><a class="navbar-brand" href="<?php echo get_site_url(); ?>"><img src="<?php echo get_template_directory_uri(); ?>/images/logo-md.png" alt="<?php echo get_bloginfo('name'); ?>" width="174" height="181"></a></h1>
      <div class="booking-btn<?php if(basename($_SERVER['REQUEST_URI'])=='booking'){echo ' sr-only';} ?>"><span class="ion-android-calendar"></span><span class="booking-text"><?php echo trans('book_your_acc_lang', 'Book your accommodation'); ?></span></div>
    </div>
    <div class="header-top text-right">
      <?php query_posts('post_type=theme-settings');if(have_posts()):while(have_posts()):the_post(); ?>
      <div class="contact-info">
        <a href="tel:<?php if(get_field('tel')){echo get_field('tel');} ?>"><span class="ion-ios-telephone-outline ion"></span> <?php if(get_field('tel_space')){echo get_field('tel_space');} ?></a>
      </div>
      <div class="contact-info">
        <a href="mailto:<?php if(get_field('email')){echo get_field('email');} ?>"><span class="ion-ios-email-outline ion"></span> info@granithotels.sk</a>
      </div>
      <?php endwhile;endif;wp_reset_query(); ?>
      <div class="menu-top-menu-container">
        <ul class="nav navbar-nav lang without-sub-menu">
          <li class="search-menu menu-item"><span class="search-menu-wrap"><span class="ion-ios-search" aria-hidden="true"></span><span class="sr-only"><?php __('Search'); ?></span></span></li>
          <?php /* _e('<!--:en--><li id="menu-item-18" class="qtranxs-lang-menu qtranxs-lang-menu-sk menu-item menu-item-type-custom menu-item-object-custom"><a title="Slovenčina" href="'.getUrlInTargetLanguage("sk").'?lang=sk">SK</a></li><!--:--><!--:sk--><li id="menu-item-19" class="qtranxs-lang-menu qtranxs-lang-menu-en menu-item menu-item-type-custom menu-item-object-custom"><a title="English" href="'.getUrlInTargetLanguage("en").'?lang=en">EN</a></li><!--:-->'); */ ?>
        </ul>
      </div>
      <?php
        // wp_nav_menu(array('theme_location'=>'top','items_wrap'=>'<ul class="nav navbar-nav lang"><li class="search-menu menu-item"><span class="search-menu-wrap"><span class="ion-ios-search" aria-hidden="true"></span><span class="sr-only">'.__('Search').'</span></span></li>%3$s</ul>'));
      ?>
    </div>
    <div class="navbar-collapse collapse">
      <?php
        add_filter('get_search_form','search_mobile_form');
        get_search_form();
        remove_filter('get_search_form','search_mobile_form');
        wp_nav_menu(array('theme_location'=>'primary','items_wrap'=>'<ul class="nav navbar-nav">%3$s</li></ul>'));
      ?>
    </div>
    <label class="header-booking-btn<?php if(basename($_SERVER['REQUEST_URI'])=='booking'){echo ' sr-only';} ?>" for="booking">
      <!--[if lt IE 9]><noscript><a href="<?php echo get_site_url(); ?>/booking"></noscript><![endif]--><span class="btn btn-primary"><?php echo trans('book_your_acc_lang', 'Book your accommodation'); ?></span><!--[if lt IE 9]><noscript></a></noscript><![endif]-->
    </label>
    <input type="checkbox" id="booking" class="sr-only"><div class="booking">
      <div class="booking-close"><span class="ion-android-close"></span></div>
      <div class="text-center booking-info-text">
        <span class="ion-ios-information-outline ion"></span> <?php echo trans('fill_all_required_field_lang', 'Please fill in all these fields, reception will contact you.');?>
      </div>
      <div class="booking-form-wrap">
        <div class="booking-form" id="header">
          <?php include 'booking.php'; ?>
        </div>
      </div>
    </div>
  </div>
  <div class="alt-navbar"><?php if(is_front_page()){ ?>
    
  <?php } ?></div>
</header>
<article>