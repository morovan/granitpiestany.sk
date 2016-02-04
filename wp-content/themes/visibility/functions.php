<?php

remove_action('woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
remove_action('woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);

remove_action('wp_head', 'wp_generator');

require_once 'shortcodes.php';

function theme_setup(){
  load_theme_textdomain('lang', get_template_directory() . '/languages');
  register_nav_menu('primary', __('Primary Menu', 'theme'));
  register_nav_menu('top', __('Top Menu', 'theme'));
  register_nav_menu('footer_primary', __('Footer Top Menu', 'theme'));
  register_nav_menu('footer_secondary', __('Footer Left Menu', 'theme'));
}
add_action('after_setup_theme', 'theme_setup');

add_theme_support('post-thumbnails');

function theme_widgets_init(){
  register_sidebar(array(
    'name'          => __('First Widget Area', 'lang'),
    'id'            => 'sidebar',
    'description'   => __('Area on blog sidebar'),
    'before_widget' => '<aside id="%1$s" class="widget %2$s">',
    'after_widget'  => '</aside>',
    'before_title'  => '<h3 class="widget-title">',
    'after_title'   => '</h3>',
    ));
}
add_action('widgets_init', 'theme_widgets_init');

function theme_wp_title($title, $sep){
  global $paged, $page;
    if (is_feed())
      return $title;
    $title .= get_bloginfo('name', 'display');
    $site_description = get_bloginfo('description', 'display');
    if ($site_description && (is_home() || is_front_page()))
      $title = "$title $sep $site_description";
    if ($paged >= 2 || $page >= 2)
      $title = "$title $sep " . sprintf(__('Page %s', 'lang'), max($paged, $page));

    return $title;
}
add_filter('wp_title', 'theme_wp_title', 10, 2);

function search_form($form){
  $form = '<form role="search" method="get" class="searchform form-inline" action="' . home_url('/') . '">
  <span class="sr-only">' . __('Search') . ':</span>
  <input class="form-control" type="text" value="' . get_search_query() . '" name="s" placeholder="' . esc_attr__('Search') . '">
  <input class="btn btn-primary" type="submit" value="' . esc_attr__('Search') . '">
  </form>';

  return $form;
}
add_filter('get_search_form', 'search_form');

function search_mobile_form($form){
  $form = '<form role="search" method="get" class="searchform-mobile" action="' . home_url('/') . '">
  <span class="sr-only">' . __('Search') . ':</span>
  <input type="text" value="' . get_search_query() . '" name="s" placeholder="' . esc_attr__('Search') . '">
  <button type="submit"><span class="sr-only">' . esc_attr__('Search') . '</span><span class="ion-ios-search"></span></button>
  <div class="clear"></div>
  </form>';

  return $form;
}
function fullsearch_form($form){
  $form = '<form role="search" method="get" class="searchform" action="' . home_url('/') . '">
  <div class="searchform-close"><span class="sr-only">' . __('Close') . '</span><span class="ion-ios-close-empty"></span></div>
  <div class="search-inputs">
  <span class="sr-only">' . __('Search') . ':</span>
  <input type="text" value="' . get_search_query() . '" name="s" placeholder="' . esc_attr__('Search') . '">
  <button type="submit"><span class="sr-only">' . esc_attr__('Search') . '</span><span class="ion-ios-search"></span></button>
  </div></form>';

  return $form;
}
function search_blog_form($form){$form = '<form role="search" method="get" class="searchform-blog" action="' . home_url('/') . '">
  <span class="sr-only">' . __('Search') . ':</span>
  <input class="form-control" type="text" value="' . get_search_query() . '" name="s" placeholder="' . __('Search in articles', 'lang') . '">
  <input type="hidden" value="1" name="cat">
  <input class="btn btn-primary" type="submit" value="' . esc_attr__('Search') . '">
  <div class="clear"></div>
  </form>';

  return $form;
}

class searchBlogForm extends WP_Widget{
  function __construct(){
    parent::__construct(false, __('Search in articles', 'lang'), array('description' => __('Search form for searching in articles', 'lang')));
  }

  function widget(){
    add_filter('get_search_form', 'search_blog_form');
    get_search_form();
    remove_filter('get_search_form', 'search_blog_form');
  }
}

function search_blog_register_widgets(){
  register_widget('searchBlogForm');
}

add_action('widgets_init', 'search_blog_register_widgets');

function custom_excerpt_length($length){
  return 25;
}

add_filter('excerpt_length', 'custom_excerpt_length', 999);

function new_excerpt_more($more){
  return '...';
}

add_filter('excerpt_more', 'new_excerpt_more');

function get_the_post_thumbnail_src($img){
  return (preg_match('~\bsrc="([^"]++)"~', $img, $matches)) ? $matches[1] : '';
}

function show_post($path){
  $post = get_page_by_path($path);
  $content = apply_filters('the_content', $post->post_content);
  $headline = apply_filters('the_title', $post->post_title);
  echo '<h2><span>' . $headline . '</span></h2><div class="content">' . $content . '</div>';
}

/* btn settings in admin menu */

add_action('admin_menu', 'translations_menu');
function translations_menu(){
  add_menu_page('Translations Options', __('Translations', 'lang'), 'manage_options', 'translations', 'translations_options', 'dashicons-translation');
}


function translations_options(){
  if(!current_user_can('manage_options')){
    wp_die(__('You don’t have enough permission to access this page.', 'lang'));
  }
  $posts = get_posts(array('post_type' => 'translations'));
  foreach($posts as $post){
    echo '<a href="' . get_site_url() . '/wp-admin/post.php?post=' . $post->ID . '&action=edit">Continue</a>';
    header('Location: ' . get_site_url() . '/wp-admin/post.php?post=' . $post->ID . '&action=edit');
  }
}


add_action('admin_menu', 'stats_menu');
function stats_menu(){
  add_menu_page('Stats Options', __('Stats', 'lang'), 'manage_options', 'stats', 'stats_options', 'dashicons-chart-area');
}


function stats_options(){
  $servername = "localhost";
  $dbname   = "granit";
  $username = "granit";
  $password = "visi0579";
  $conn = new mysqli($servername, $username, $password, $dbname);
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

header('Content-type: text/html; charset=utf-8');
echo '<style>.table1 td, .table1 th{padding: 5px 10px;}.table1 th{text-align: left; color:white;} .table1 tr:nth-child(2n){background:#eee;} </style>';
echo '<h1>Štatistiky</h1>';

$ms = $_POST['ms'];
if($ms=='1'){
  $mp = '2000-01-01';
}else if($ms=='2'){
  $mp = '2000-02-01';
}else if($ms=='3'){
  $mp = '2000-03-01';
}else if($ms=='4'){
  $mp = '2000-04-01';
}else if($ms=='5'){
  $mp = '2000-5-01';
}else if($ms=='6'){
  $mp = '2000-6-01';
}else if($ms=='7'){
  $mp = '2000-7-01';
}else if($ms=='8'){
  $mp = '2000-8-01';
}else if($ms=='9'){
  $mp = '2000-9-01';
}else if($ms=='10'){
  $mp = '2000-10-01';
}else if($ms=='1'){
  $mp = '2000-11-01';
}else if($ms=='12'){
  $mp = '2000-12-01';
}else{
  $mp = '2000-01-01';
}

$ys = $_POST['ys'];
if($ys==''){
  $ys = date(Y);
}

for ($xy = 2016; $xy <= date(Y); $xy++){
  if($ys==$xy){
    $yp = $xy.'-01-01';
  }
}

echo '<form method="post">Obdobie: mesiac <select name="ms""><option';
if($ms==1){echo ' selected';}
  echo '>1</option><option';
if($ms==2){echo ' selected';}
  echo '>2</option><option';
if($ms==3){echo ' selected';}
  echo '>3</option><option';
if($ms==4){echo ' selected';}
  echo '>4</option><option';
if($ms==5){echo ' selected';}
  echo '>5</option><option';
if($ms==6){echo ' selected';}
  echo '>6</option><option';
if($ms==7){echo ' selected';}
  echo '>7</option><option';
if($ms==8){echo ' selected';}
  echo '>8</option><option';
if($ms==9){echo ' selected';}
  echo '>9</option><option';
if($ms==10){echo ' selected';}
  echo '>10</option><option';
if($ms==11){echo ' selected';}
  echo '>11</option><option';
if($ms==12){echo ' selected';}
  echo '>12</option></select>';

  echo 'rok <select name="ys">';

for ($x = 2016; $x <= date(Y); $x++){
echo "<option";
  if($ys==$x){echo ' selected';}
    echo ">$x</option>";
}
echo '</select><input type="submit" value="Nastav"></form>';

$sql1 = "SELECT hotel, check_in, check_out, room, person, email, name, surname, phone, lang, url, message, createdAt FROM form WHERE MONTH(createdAt) = MONTH('".$mp."') AND YEAR(createdAt) = YEAR('".$yp."') ORDER BY id";
$result1 = $conn->query($sql1);
  if($result1->num_rows > 0){
    echo '<div class="table1" style="overflow: scroll; max-height:1000px;"><table border="1" cellpadding="0" cellspacing="0" style="background: #fff;width:1700px; border-collapse: collapse; border: 2px solid #0073AA; border-top: 1px #eee; border-right: 0px #eee;border-left: 0px #eee; box-shadow: 0px 0px 20px rgba(0,0,0,0.10)";"><caption style="text-align:left;"><h2>Rezervácie</h2></caption>';
    echo '<thead><tr style="background-color: #0073AA;border: 1px #eee">';
    echo "<th>Hotel</th>";
    echo "<th width='110px'>Príchod</th>";
    echo "<th width='110px'>Odchod</th>";
    echo "<th>Izby</th>";
    echo "<th>Osoby</th>";
    echo "<th>E-mail</th>";
    echo "<th>Meno</th>";
    echo "<th>Priezvisko</th>";
    echo "<th>Telefón</th>";
    echo "<th>Zvláštne požiadavky/poznámka</th>";
    echo "<th>Lang</th>";
    echo "<th>URL</th>";
    echo "<th width='140px'>Čas vytvorenia</th>";
    echo '</tr></thead><tbody>';
    // output data of each row
  while($row = $result1->fetch_assoc()) {
    $current_timestamp = strtotime($row["createdAt"]);
    echo '<tr style="border-right:1px #0073AA">';
    echo "<td>". $row["hotel"]. "</td>";
    echo "<td>". $row["check_in"]. "</td>";
    echo "<td>". $row["check_out"]. "</td>";
    echo "<td style='text-align: right;'>". $row["room"]. "</td>";
    echo "<td style='text-align: right;'>". $row["person"]. "</td>";
    echo "<td>". $row["email"]. "</td>";
    echo "<td>". $row["name"]. "</td>";
    echo "<td>". $row["surname"]. "</td>";
    echo "<td>". $row["phone"]. "</td>";
    echo "<td><textarea onclick='this.focus();this.select()' readonly='readonly' rows='2' style='background: #fff;width:280px;'>". $row["message"]. "</textarea></td>";
    echo "<td style='text-align: center;'>". $row["lang"]. "</td>";
    echo "<td><input type='text' value='". $row["url"]. "' onclick='this.focus();this.select()' readonly='readonly' style='background: #fff; direction:rtl;'></td>";
    echo "<td align='right'>". date( "j. n. Y | H:i:s", $current_timestamp). "</td>";
    echo '</tr>';
  }
  echo '</tbody></table></div>';
}
  else {
    echo "0 results";
  }


global $wpdb;
$results = $wpdb->get_results("SELECT email, lang, url, createdAt FROM nl");
while($row = mysql_fetch_array( $results )) {
  echo $row['email'];
  echo  $row['lang'];
}



$sql = "SELECT email, lang, url, createdAt FROM nl WHERE MONTH(createdAt) = MONTH('".$mp."') AND YEAR(createdAt) = YEAR('".$yp."') ORDER BY id";
$result = $conn->query($sql);
 if($result->num_rows > 0){
   echo '<div class="table1" style="overflow: scroll; max-height:1000px;"><table border="1" cellpadding="0" cellspacing="0" style="background:#fff; border-collapse: collapse; border: 2px solid #0073AA; border-top: 1px #eee; border-right: 0px #eee;border-left: 0px #eee; box-shadow: 0px 0px 20px rgba(0,0,0,0.10);" ><caption style="text-align: left;"><h2>Registrácie na Newsletter</h2></caption>';
   echo '<thead><tr style="background-color: #0073AA;">';
   echo "<th>E-mail</th>";
   echo "<th>Lang</th>";
   echo "<th>URL</th>";
   echo "<th>Čas vytvorenia</th>";
   echo '</tr></thead><tbody>';
// output data of each row
while($row = $result->fetch_assoc()) {
  $current_timestamp = strtotime($row["createdAt"]);
  echo '<tr>';
  echo "<td>". $row["email"]. "</td>";
  echo "<td>". $row["lang"]. "</td>";
  echo "<td>". $row["url"]. "</td>";
  echo "<td align='right'>". date( "j. n. Y | H:i:s", $current_timestamp). "</td>";
  echo '</tr>';
}
 echo '</tbody></table></div>';
 }else{
echo "0 results";
}

$conn->close();
}

add_action('admin_menu', 'my_plugin_menu');
function my_plugin_menu(){
    add_menu_page('My Plugin Options', __('Theme Settings', 'lang'), 'manage_options', 'theme-settings', 'my_plugin_options', get_template_directory_uri() . '/images/visibility.png');
}

function my_plugin_options(){
  if (!current_user_can('manage_options')) {
    wp_die(__('You don’t have enough permission to access this page.', 'lang'));
  }
  $posts = get_posts(array('post_type' => 'theme-settings'));
  if(count($posts) > 0):
    foreach($posts as $post){
      echo '<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script><form action="' . get_site_url() . '/wp-admin/post.php" id="gtts" style="position:fixed;z-index:100000;top:0;bottom:0;left:0;right:0;background:#fff url(' . get_template_directory_uri() . '/images/loading.gif) no-repeat center;"><input type="hidden" name="post" value="' . $post->ID . '"><input type="hidden" name="action" value="edit"><input type="submit" value="';
        _e('Go to settings', 'lang');
        echo '" style="text-decoration:underline;background:none;border:none;font-size:16px;color:#2B3146;position:fixed;z-index:100001;bottom:50px;width:100%;text-align:center;left:0"></form><script type="text/javascript">$(function(){$("#gtts").submit();});</script>';
    }
  else:
    _e('No Theme Settings found', 'lang');
  endif;
}

/* btn documentation in admin menu */

add_action('admin_menu', 'documentation_menu');
function documentation_menu(){
  add_menu_page('Documentation Options', __('Documentation', 'lang'), 'manage_options', 'documentation', 'documentation_options', get_template_directory_uri() . '/images/visibility.png');
}

function documentation_options(){
  if (!current_user_can('manage_options')){
    wp_die(__('You don’t have enough permission to access this page.', 'lang'));
  }
  echo '<a href="http://theme.visibility.sk/dokumentacia-03/">Continue</a>';
}

/* theme settings */

add_action('init', 'bs_post_types');
function bs_post_types(){
  $labels = array(
    'name'               => __('Theme Settings', 'lang'),
    'singular_name'      => __('Theme Settings', 'lang'),
    'add_new'            => __('Clear and create new', 'lang'),
    'add_new_item'       => __('Clear and create new', 'lang'),
    'edit_item'          => __('Theme Settings', 'lang'),
    'all_items'          => __('Theme Settings', 'lang'),
    'not_found'          => __('No Theme Settings found', 'lang'),
    'not_found_in_trash' => __('No Theme Settings found', 'lang'),
    'menu_name'          => __('Theme Settings', 'lang'),
  );
  $supports = array('title');  //title
  $slug = get_theme_mod('ts_permalink');
  $slug = (empty($slug)) ? 'theme-settings' : $slug;
  $args = array(
    'labels'             => $labels,
    'public'             => true,
    'publicly_queryable' => true,
    'show_ui'            => true,
    'show_in_menu'       => false, //true
    'query_var'          => true,
    'rewrite'            => array('slug' => $slug),
    'capability_type'    => 'post',
    'has_archive'        => true,
    'hierarchical'       => false,
    'menu_position'      => null,
    'supports'           => $supports,
  );
  register_post_type('theme-settings', $args);
}

/* translations */

add_action('init', 'translations_post_types');
function translations_post_types(){
  $labels = array(
    'name'               => __('Translations', 'lang'),
    'singular_name'      => __('Translations', 'lang'),
    'add_new'            => __('Clear and create new', 'lang'),
    'add_new_item'       => __('Clear and create new', 'lang'),
    'edit_item'          => __('Translations', 'lang'),
    'all_items'          => __('Translations', 'lang'),
    'not_found'          => __('Nothing found', 'lang'),
    'not_found_in_trash' => __('Nothing found', 'lang'),
    'menu_name'          => __('Translations', 'lang'),
  );
  $supports = array('title');  //title

  $args = array(
    'labels'             => $labels,
    'public'             => false,
    'publicly_queryable' => true,
    'show_ui'            => true,
    'show_in_menu'       => false, //true
    'query_var'          => true,
    'rewrite'            => array('slug' => 'translations'),
    'capability_type'    => 'post',
    'has_archive'        => false,
    'hierarchical'       => false,
    'supports'           => $supports,
  );
  register_post_type('translations', $args);
}

/* testimonials */

add_action('init', 'testimonials_post_types');
function testimonials_post_types(){
  $labels = array(
    'name'               => __('Testimonials', 'lang'),
    'singular_name'      => __('Testimonial', 'lang'),
    'add_new'            => __('Create new', 'lang'),
    'add_new_item'       => __('Create new', 'lang'),
    'edit_item'          => __('Edit', 'lang'),
    'view_item'          => __('View', 'lang'),
    'all_items'          => __('All', 'lang'),
    'not_found'          => __('Nothing found', 'lang'),
    'not_found_in_trash' => __('Nothing found', 'lang'),
    'menu_name'          => __('Testimonials', 'lang'),
  );
  $supports = array('title', 'editor', 'thumbnail');
  $args = array(
    'labels'             => $labels,
    'public'             => true,
    'publicly_queryable' => true,
    'show_ui'            => true,
    'show_in_menu'       => true,
    'query_var'          => true,
    'rewrite'            => array('slug' => 'testimonial'),
    'capability_type'    => 'page',
    'has_archive'        => true,
    'hierarchical'       => true,
    'menu_position'      => 22,
    'menu_icon'          => 'dashicons-format-quote',
    'supports'           => $supports,
  );
  register_post_type('testimonial', $args);
}

/* hotels */

add_action('init', 'hotels_post_types', 0);
function hotels_post_types(){
  $labels = array(
    'name'               => __('Hotels', 'lang'),
    'singular_name'      => __('Hotel', 'lang'),
    'add_new'            => __('Create new', 'lang'),
    'add_new_item'       => __('Create new', 'lang'),
    'edit_item'          => __('Edit', 'lang'),
    'view_item'          => __('View', 'lang'),
    'all_items'          => __('All', 'lang'),
    'not_found'          => __('Nothing found', 'lang'),
    'not_found_in_trash' => __('Nothing found', 'lang'),
    'menu_name'          => __('Hotels', 'lang'),
  );
  $supports = array('title', 'editor', 'thumbnail');
  $args = array(
    'labels'             => $labels,
    'public'             => true,
    'publicly_queryable' => true,
    'show_ui'            => true,
    'show_in_menu'       => true,
    'query_var'          => true,
    'rewrite'            => array('slug'       => 'hotel',
                                  'with_front' => false,
    ),
    'capability_type'    => 'page',
    'has_archive'        => false,
    'hierarchical'       => true,
    'menu_icon'          => 'dashicons-admin-home',
    'menu_position'      => 20,
    'supports'           => $supports,
  );
  register_post_type('hotel', $args);
  flush_rewrite_rules('hotel', $args);
}

/* events */

add_action('init', 'events_post_types');
function events_post_types(){
  $labels = array(
    'name'               => __('Events', 'lang'),
    'singular_name'      => __('Event', 'lang'),
    'add_new'            => __('Create new', 'lang'),
    'add_new_item'       => __('Create new', 'lang'),
    'edit_item'          => __('Edit', 'lang'),
    'view_item'          => __('View', 'lang'),
    'all_items'          => __('All', 'lang'),
    'not_found'          => __('Nothing found', 'lang'),
    'not_found_in_trash' => __('Nothing found', 'lang'),
    'menu_name'          => __('Events', 'lang'),
  );
  $supports = array('title', 'editor', 'thumbnail', 'page-attributes');
  $args = array(
    'labels'             => $labels,
    'public'             => true,
    'publicly_queryable' => true,
    'show_ui'            => true,
    'show_in_menu'       => true,
    'query_var'          => true,
    'rewrite'            => array('slug' => 'event'),
    'capability_type'    => 'page',
    'has_archive'        => true,
    'hierarchical'       => true,
    'menu_icon'          => 'dashicons-calendar-alt',
    'menu_position'      => 21,
    'supports'           => $supports,
  );
  register_post_type('event', $args);
  flush_rewrite_rules('event', $args);
}

/* hotel offers */

add_action('init', 'hotel_offers_post_types');
function hotel_offers_post_types(){
  $labels = array(
    'name'               => __('Hotel Offers', 'lang'),
    'singular_name'      => __('Hotel Offer', 'lang'),
    'add_new'            => __('Create new', 'lang'),
    'add_new_item'       => __('Create new', 'lang'),
    'edit_item'          => __('Edit', 'lang'),
    'view_item'          => __('View', 'lang'),
    'all_items'          => __('All', 'lang'),
    'not_found'          => __('Nothing found', 'lang'),
    'not_found_in_trash' => __('Nothing found', 'lang'),
    'menu_name'          => __('Hotel Offers', 'lang'),
  );
  $supports = array('title', 'editor', 'thumbnail', 'excerpt');
  $args = array(
    'labels'             => $labels,
    'public'             => true,
    'publicly_queryable' => true,
    'show_ui'            => true,
    'show_in_menu'       => true,
    'query_var'          => true,
    'rewrite'            => array('slug' => 'offer'),
    'capability_type'    => 'page',
    'has_archive'        => true,
    'hierarchical'       => true,
    'menu_icon'          => 'dashicons-tag',
    'menu_position'      => 5,
    'supports'           => $supports,
  );
  register_post_type('offer', $args);
  flush_rewrite_rules('offer', $args);
}

/* event offers */

add_action('init', 'event_offers_post_types');
function event_offers_post_types(){
  $labels = array(
    'name'               => __('Event Offers', 'lang'),
    'singular_name'      => __('Event Offer', 'lang'),
    'add_new'            => __('Create new', 'lang'),
    'add_new_item'       => __('Create new', 'lang'),
    'edit_item'          => __('Edit', 'lang'),
    'view_item'          => __('View', 'lang'),
    'all_items'          => __('All', 'lang'),
    'not_found'          => __('Nothing found', 'lang'),
    'not_found_in_trash' => __('Nothing found', 'lang'),
    'menu_name'          => __('Event Offers', 'lang'),
  );
  $supports = array('title', 'editor', 'thumbnail', 'page-attributes');
  $args = array(
    'labels'             => $labels,
    'public'             => true,
    'publicly_queryable' => true,
    'show_ui'            => true,
    'show_in_menu'       => true,
    'query_var'          => true,
    'rewrite'            => array('slug' => 'event-offer'),
    'capability_type'    => 'post',
    'has_archive'        => true,
    'hierarchical'       => false,
    'menu_icon'          => 'dashicons-tickets-alt',
    'menu_position'      => 6,
    'supports'           => $supports,
  );
  register_post_type('event-offer', $args);
  flush_rewrite_rules('event-offer', $args);
}

/* required plugins */

require_once dirname(__FILE__) . '/class-tgm-plugin-activation.php';

add_action('tgmpa_register', 'my_theme_register_required_plugins');
function my_theme_register_required_plugins(){
  $plugins = array(
    array(
      'name'               => 'Advanced Custom Fields', // The plugin name.
      'slug'               => 'advanced-custom-fields', // The plugin slug (typically the folder name).
      'source'             => 'https://downloads.wordpress.org/plugin/advanced-custom-fields.zip', // The plugin source.
      'required'           => true, // If false, the plugin is only 'recommended' instead of required.
      'version'            => '4.4.2', // E.g. 1.0.0. If set, the active plugin must be this version or higher.
      'force_activation'   => true, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
      'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
      'external_url'       => 'https://wordpress.org/plugins/advanced-custom-fields/', // If set, overrides default API URL and points to an external URL.
    ),

    array(
      'name'         => 'Contact Form 7',
      'slug'         => 'contact-form-7',
      'source'       => 'https://downloads.wordpress.org/plugin/contact-form-7.4.1.2.zip',
      'required'     => false,
      'external_url' => 'https://wordpress.org/plugins/contact-form-7/',
    ),

    array(
      'name'         => 'WordPress SEO by Yoast',
      'slug'         => 'wordpress-seo',
      'source'       => 'http://downloads.wordpress.org/plugin/wordpress-seo.latest-stable.zip',
      'required'     => false,
      'external_url' => 'https://wordpress.org/plugins/wordpress-seo/',
    ),

    array(
      'name'         => 'Responsive Lightbox by dFactory',
      'slug'         => 'responsive-lightbox',
      'source'       => 'http://downloads.wordpress.org/plugin/responsive-lightbox.latest-stable.zip',
      'required'     => false,
      'external_url' => 'https://wordpress.org/plugins/responsive-lightbox/',
    ),

    array(
      'name'         => 'TinyMCE Advanced',
      'slug'         => 'tinymce-advanced',
      'source'       => 'https://downloads.wordpress.org/plugin/tinymce-advanced.4.2.5.zip',
      'required'     => false,
      'external_url' => 'https://wordpress.org/plugins/tinymce-advanced/',
    ),
  );

  $config = array(
    'default_path' => '',                      // Default absolute path to pre-packaged plugins.
    'menu'         => 'tgmpa-install-plugins', // Menu slug.
    'has_notices'  => true,                    // Show admin notices or not.
    'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
    'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
    'is_automatic' => false,                   // Automatically activate plugins after installation or not.
    'message'      => '',                      // Message to output right before the plugins table.
    'strings'      => array(
      'page_title'                      => __('Install Required Plugins', 'tgmpa'),
      'menu_title'                      => __('Install Plugins', 'tgmpa'),
      'installing'                      => __('Installing Plugin: %s', 'tgmpa'), // %s = plugin name.
      'oops'                            => __('Something went wrong with the plugin API.', 'tgmpa'),
      'notice_can_install_required'     => _n_noop('This theme requires the following plugin: %1$s.', 'This theme requires the following plugins: %1$s.'), // %1$s = plugin name(s).
      'notice_can_install_recommended'  => _n_noop('This theme recommends the following plugin: %1$s.', 'This theme recommends the following plugins: %1$s.'), // %1$s = plugin name(s).
      'notice_cannot_install'           => _n_noop('Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', 'Sorry, but you do not have the correct permissions to install the %s plugins. Contact the administrator of this site for help on getting the plugins installed.'), // %1$s = plugin name(s).
      'notice_can_activate_required'    => _n_noop('The following required plugin is currently inactive: %1$s.', 'The following required plugins are currently inactive: %1$s.'), // %1$s = plugin name(s).
      'notice_can_activate_recommended' => _n_noop('The following recommended plugin is currently inactive: %1$s.', 'The following recommended plugins are currently inactive: %1$s.'), // %1$s = plugin name(s).
      'notice_cannot_activate'          => _n_noop('Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', 'Sorry, but you do not have the correct permissions to activate the %s plugins. Contact the administrator of this site for help on getting the plugins activated.'), // %1$s = plugin name(s).
      'notice_ask_to_update'            => _n_noop('The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.', 'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.'), // %1$s = plugin name(s).
      'notice_cannot_update'            => _n_noop('Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this site for help on getting the plugin updated.', 'Sorry, but you do not have the correct permissions to update the %s plugins. Contact the administrator of this site for help on getting the plugins updated.'), // %1$s = plugin name(s).
      'install_link'                    => _n_noop('Begin installing plugin', 'Begin installing plugins'),
      'activate_link'                   => _n_noop('Begin activating plugin', 'Begin activating plugins'),
      'return'                          => __('Return to Required Plugins Installer', 'tgmpa'),
      'plugin_activated'                => __('Plugin activated successfully.', 'tgmpa'),
      'complete'                        => __('All plugins installed and activated successfully. %s', 'tgmpa'), // %s = dashboard link.
      'nag_type'                        => 'updated' // Determines admin notice type - can only be 'updated', 'update-nag' or 'error'.
    )
  );
  tgmpa($plugins, $config);
}

if(function_exists("register_field_group")){
  if(strcmp(get_bloginfo('language'), 'sk-SK') == 0){
    register_field_group(array(
      'id'         => 'acf_blog',
      'title'      => 'Blog (články)',
      'fields'     => array(
        array(
          'key'           => 'field_555af34be75f8',
          'label'         => 'Nadpis stránky blogu',
          'name'          => 'blog_title',
          'type'          => 'text',
          'instructions'  => '',
          'required'      => 1,
          'default_value' => 'Blog',
          'placeholder'   => 'Nadpis stránky blogu',
          'prepend'       => '',
          'append'        => '',
          'formatting'    => 'html',
          'maxlength'     => '',
        ),
      ),
      'location'   => array(
        array(
          array(
            'param'    => 'post_type',
            'operator' => '==',
            'value'    => 'theme-settings',
            'order_no' => 0,
            'group_no' => 0,
          ),
        ),
      ),
      'options'    => array(
        'position'       => 'normal',
        'layout'         => 'default',
        'hide_on_screen' => array(),
      ),
      'menu_order' => 0,
    ));
  }else{
    register_field_group(array(
      'id'         => 'acf_blog',
      'title'      => 'Blog (articles)',
      'fields'     => array(
        array(
          'key'           => 'field_555af34be75f8',
          'label'         => 'Blog title',
          'name'          => 'blog_title',
          'type'          => 'text',
          'instructions'  => '',
          'required'      => 1,
          'default_value' => 'Blog',
          'placeholder'   => 'Blog title',
          'prepend'       => '',
          'append'        => '',
          'formatting'    => 'html',
          'maxlength'     => '',
        ),
      ),
      'location'   => array(
        array(
          array(
            'param'    => 'post_type',
            'operator' => '==',
            'value'    => 'theme-settings',
            'order_no' => 0,
            'group_no' => 0,
          ),
        ),
      ),
      'options'    => array(
        'position'       => 'normal',
        'layout'         => 'default',
        'hide_on_screen' => array(),
      ),
      'menu_order' => 0,
    ));
  }
  if(strcmp(get_bloginfo('language'), 'sk-SK') == 0){
    register_field_group(array(
      'id'         => 'acf_nastavenia-temy',
      'title'      => 'Nastavenia témy',
      'fields'     => array(
        array(
          'key'     => 'field_555b6d8eb916f',
          'label'   => 'Nastavenia témy',
          'name'    => '',
          'type'    => 'message',
          'message' => 'Zmeny v nastaveniach témy upravíte kliknutím na tlačidlo <span style="color:#2EA2CC">Aktualizovať</span>. Pri jazykových mutáciach je potrebné úpravy aplikovať vo všetkých jazykoch.
    <style type="text/css">
      .add-new-h2,#submitdiv .submitdelete,#minor-publishing,#submitdiv .hndle,#submitdiv .handlediv,#duplicate-action,#qts_sectionid{
        display:none !important;
      }
      #submitdiv{
        position:fixed;
      }
      #submitdiv,#major-publishing-actions{
        background:none;
        border:none;
        box-shadow:none;
      }
      .toplevel_page_theme-settings,.toplevel_page_theme-settings:hover{
        background:#0073aa;
        color:#fff !important;
      }
      .toplevel_page_theme-settings img{
        opacity:1 !important;
      }
      #publish{
        font-size:16px;
        padding:3px 25px 31px;
      }
    </style>',
        ),
      ),
        'location'   => array(
          array(
            array(
              'param'    => 'post_type',
              'operator' => '==',
              'value'    => 'theme-settings',
              'order_no' => 0,
              'group_no' => 0,
            ),
          ),
        ),
        'options'    => array(
          'position'       => 'acf_after_title',
          'layout'         => 'default',
          'hide_on_screen' => array(),
        ),
        'menu_order' => 0,
    ));
  }else{
    register_field_group(array(
      'id'         => 'acf_nastavenia-temy',
      'title'      => 'Theme settings',
      'fields'     => array(
        array(
          'key'     => 'field_555b6d8eb916f',
          'label'   => 'Theme settings',
          'name'    => '',
          'type'    => 'message',
            'message' => 'Changes will be updated after clicking to button <span style="color:#2EA2CC">Update</span>. In language mutation is the necessary adjustments to be applied in all languages.
        <style type="text/css">
          .add-new-h2,#submitdiv .submitdelete,#minor-publishing,#submitdiv .hndle,#submitdiv .handlediv{
            display:none !important;
          }
          #submitdiv{
            position:fixed;
          }
          #submitdiv,#major-publishing-actions{
            background:none;
            border:none;
            box-shadow:none;
          }
          .toplevel_page_theme-settings,.toplevel_page_theme-settings:hover{
            background:#0073aa;
            color:#fff !important;
          }
          .toplevel_page_theme-settings img{
            opacity:1 !important;
          }
          #publish{
            font-size:16px;
            padding:3px 25px 31px;
          }
        </style>',
        ),
      ),
      'location'   => array(
        array(
          array(
            'param'    => 'post_type',
            'operator' => '==',
            'value'    => 'theme-settings',
            'order_no' => 0,
            'group_no' => 0,
          ),
        ),
      ),
      'options'    => array(
        'position'       => 'acf_after_title',
        'layout'         => 'default',
        'hide_on_screen' => array(),
      ),
      'menu_order' => 0,
    ));
  }

  if(strcmp(get_bloginfo('language'), 'sk-SK') == 0){
    register_field_group(array(
      'id'         => 'acf_zahlavie',
      'title'      => 'Záhlavie',
      'fields'     => array(
        array(
          'key'           => 'field_555b6a0036df9',
          'label'         => 'Pridať ďalšie elementy v záhlaví (značka <head>) - JavaScript, Meta, CSS...',
          'name'          => 'head_other_elements',
          'type'          => 'textarea',
          'instructions'  => 'Môžete pridať/upraviť elementy v záhlaví. Môže sa jednať o ľubovolnú html značku, ktorá môže byť umiestnená v značke <head>. Napr. Google Analytics, Meta values, vlastné štýly...',
          'default_value' => '',
          'placeholder'   => '',
          'maxlength'     => '',
          'rows'          => '',
          'formatting'    => 'html',
        ),
        array(
          'key'           => 'field_555b6a0036dfa',
          'label'         => 'Pridať ďalšie elementy pod záhlavím (značka <body>) - JavaScript...',
          'name'          => 'body_other_elements',
          'type'          => 'textarea',
          'instructions'  => 'Môžete pridať/upraviť elementy pod záhlavím. Môže sa jednať o ľubovolnú html značku, ktorá môže byť umiestnená v značke <body>. Napr. Google Tag Manager, Facebook script fb-root...',
          'default_value' => '',
          'placeholder'   => '',
          'maxlength'     => '',
          'rows'          => '',
          'formatting'    => 'html',
        ),
      ),
      'location'   => array(
        array(
          array(
            'param'    => 'post_type',
            'operator' => '==',
            'value'    => 'theme-settings',
            'order_no' => 0,
            'group_no' => 0,
          ),
        ),
      ),
      'options'    => array(
        'position'       => 'normal',
        'layout'         => 'default',
        'hide_on_screen' => array(),
      ),
      'menu_order' => 0,
    ));
  }else{
    register_field_group(array(
      'id'         => 'acf_zahlavie',
      'title'      => 'Header',
      'fields'     => array(
        array(
          'key'           => 'field_555b6a0036df9',
          'label'         => 'Add other elements to the header (tag <head>) - JavaScript, Meta, CSS...',
          'name'          => 'head_other_elements',
          'type'          => 'textarea',
          'instructions'  => 'You can add/edit elements in the header. It can be an arbitrary HTML tags, that can be placed in the <head>. E.g. Google Analytics, Meta values, Custom styles...',
            'default_value' => '',
            'placeholder'   => '',
            'maxlength'     => '',
            'rows'          => '',
            'formatting'    => 'html',
        ),
        array(
          'key'           => 'field_555b6a0036dfa',
          'label'         => 'Add other elements to top of the body (tag <body>) - JavaScript...',
          'name'          => 'body_other_elements',
          'type'          => 'textarea',
          'instructions'  => 'You can add/edit elements to top of the body. It can be an arbitrary HTML tags, that can be placed in the <body>. E.g. Google Tag Manager, Facebook script fb-root...',
            'default_value' => '',
            'placeholder'   => '',
            'maxlength'     => '',
            'rows'          => '',
            'formatting'    => 'html',
        ),
      ),
      'location'   => array(
        array(
          array(
            'param'    => 'post_type',
            'operator' => '==',
            'value'    => 'theme-settings',
            'order_no' => 0,
            'group_no' => 0,
          ),
        ),
      ),
      'options'    => array(
        'position'       => 'normal',
        'layout'         => 'default',
        'hide_on_screen' => array(),
      ),
      'menu_order' => 0,
    ));
  }

  if(strcmp(get_bloginfo('language'), 'sk-SK') == 0){
    register_field_group(array(
      'id'         => 'acf_lista-eu-cookie-law',
      'title'      => 'Lišta s informáciou na zber cookies (EU Cookie Law)',
      'fields'     => array(
        array(
          'key'           => 'field_5655cc47eeb6a',
          'label'         => 'Zobrazenie lišty',
          'name'          => 'cookies_strip',
          'type'          => 'true_false',
          'message'       => 'Zapnutá',
          'default_value' => 0,
        ),
        array(
          'key'           => 'field_5655cbcbeeb68',
          'label'         => 'Farba tlačidla',
          'name'          => 'cookies_strip_btn_bg',
          'type'          => 'color_picker',
          'default_value' => '#3e5071',
        ),
        array(
          'key'           => 'field_5655cc20eeb69',
          'label'         => 'Farba tlačidla po prechode kurzora',
          'name'          => 'cookies_strip_btn_bg_hover',
          'type'          => 'color_picker',
          'default_value' => '#942b1e',
        ),
      ),
      'location'   => array(
        array(
          array(
            'param'    => 'post_type',
            'operator' => '==',
            'value'    => 'theme-settings',
            'order_no' => 0,
            'group_no' => 0,
          ),
        ),
      ),
      'options'    => array(
        'position'       => 'normal',
        'layout'         => 'default',
        'hide_on_screen' => array(),
      ),
      'menu_order' => 0,
    ));
  }else{
    register_field_group(array(
      'id'         => 'acf_lista-eu-cookie-law',
      'title'      => 'Information bar for the collection of cookies (EU Cookie Law)',
      'fields'     => array(
        array(
          'key'           => 'field_5655cc47eeb6a',
          'label'         => 'Displaying bar',
          'name'          => 'cookies_strip',
          'type'          => 'true_false',
          'message'       => 'On',
          'default_value' => 0,
        ),
        array(
          'key'           => 'field_5655cbcbeeb68',
          'label'         => 'Button color',
          'name'          => 'cookies_strip_btn_bg',
          'type'          => 'color_picker',
          'default_value' => '#3e5071',
        ),
        array(
          'key'           => 'field_5655cc20eeb69',
          'label'         => 'Button hover color',
          'name'          => 'cookies_strip_btn_bg_hover',
          'type'          => 'color_picker',
          'default_value' => '#942b1e',
        ),
      ),
      'location'   => array(
        array(
          array(
            'param'    => 'post_type',
            'operator' => '==',
            'value'    => 'theme-settings',
            'order_no' => 0,
            'group_no' => 0,
          ),
        ),
      ),
      'options'    => array(
        'position'       => 'normal',
        'layout'         => 'default',
        'hide_on_screen' => array(),
      ),
      'menu_order' => 0,
    ));
  }

  if(strcmp(get_bloginfo('language'), 'sk-SK') == 0){
    register_field_group(array(
      'id'         => 'acf_login',
      'title'      => 'Prihlásenie do administrácie',
      'fields'     => array(
        array(
          'key'           => 'field_56571c1535af3',
          'label'         => 'URL adresa na prihlásenie do administrácie. <span style="color:#f00">POZOR: po uložený je potrebné sa prihlásovať touto URL adresou</span>',
          'name'          => 'slug_to_login',
          'type'          => 'text',
          'instructions'  => '',
          'default_value' => 'enter',
          'placeholder'   => '',
          'prepend'       => get_site_url() . '/',
          'append'        => '',
          'formatting'    => 'html',
          'maxlength'     => '',
        ),
      ),
      'location'   => array(
        array(
          array(
            'param'    => 'post_type',
            'operator' => '==',
            'value'    => 'theme-settings',
            'order_no' => 0,
            'group_no' => 0,
          ),
        ),
      ),
      'options'    => array(
        'position'       => 'normal',
        'layout'         => 'default',
        'hide_on_screen' => array(),
      ),
      'menu_order' => 0,
    ));
  }else{
    register_field_group(array(
      'id'         => 'acf_login',
      'title'      => 'Prihlásenie do administrácie',
      'fields'     => array(
        array(
          'key'           => 'field_56571c1535af3',
          'label'         => 'URL adresa na prihlásenie do administrácie <span style="color:#f00">POZOR: po uložený je potrebné sa prihlásovať touto URL adresou</span>',
          'name'          => 'slug_to_login',
          'type'          => 'text',
          'instructions'  => '',
          'default_value' => 'enter',
          'placeholder'   => '',
          'prepend'       => get_site_url() . '/',
          'append'        => '',
          'formatting'    => 'html',
          'maxlength'     => '',
        ),
      ),
      'location'   => array(
        array(
          array(
            'param'    => 'post_type',
            'operator' => '==',
            'value'    => 'theme-settings',
            'order_no' => 0,
            'group_no' => 0,
          ),
        ),
      ),
      'options'    => array(
        'position'       => 'normal',
        'layout'         => 'default',
        'hide_on_screen' => array(),
      ),
      'menu_order' => 0,
    ));
  }
}


/* woocommerce */

$show_in_nav_menus = apply_filters('woocommerce_attribute_show_in_nav_menus', false, $name);

add_filter('woocommerce_attribute_show_in_nav_menus', 'wc_reg_for_menus', 1, 2);

function wc_reg_for_menus($register, $name = ''){
  if ($name == 'pa_types') $register = true;
  if ($name == 'pa_special-sales') $register = true;
  return $register;
}
add_filter('loop_shop_per_page', create_function('$cols', 'return 8;'), 20);
add_filter('woocommerce_variable_sale_price_html', 'wc_wc20_variation_price_format', 10, 2);
add_filter('woocommerce_variable_price_html', 'wc_wc20_variation_price_format', 10, 2);
function wc_wc20_variation_price_format($price, $product){
  // Main Price
  $prices = array($product->get_variation_price('min', true), $product->get_variation_price('max', true));
  $price = $prices[0] !== $prices[1] ? sprintf(__('From: %1$s', 'woocommerce'), wc_price($prices[0])) : wc_price($prices[0]);
  // Sale Price
  $prices = array($product->get_variation_regular_price('min', true), $product->get_variation_regular_price('max', true));
  sort($prices);
  $saleprice = $prices[0] !== $prices[1] ? sprintf(__('From: %1$s', 'woocommerce'), wc_price($prices[0])) : wc_price($prices[0]);

  if ($price !== $saleprice) {
    $price = '<del>' . $saleprice . '</del> <ins>' . $price . '</ins>';
  }

  return $price;
}


add_action('woocommerce_before_main_content', 'my_theme_wrapper_start', 10);
add_action('woocommerce_after_main_content', 'my_theme_wrapper_end', 10);

function my_theme_wrapper_start(){
  echo '<section id="main">';
}

function my_theme_wrapper_end(){
  echo '</section>';
}

add_theme_support('woocommerce');

if(!is_user_logged_in()){
  if(strpos(basename($_SERVER['REQUEST_URI']), 'wp-admin') !== false){
    wp_redirect(get_site_url() . '/404', 302);
    exit;
  }
  $pass = substr(md5(substr(get_bloginfo('name'), 2, -1)), 7, -5);
    if(strpos(basename($_SERVER['REQUEST_URI']), 'wp-login.php') !== false){
      if($_POST['log'] == ''){
        if($_GET['p'] != $pass){
          if($_GET['action'] != 'lostpassword'){
            if($_GET['interim-login'] != '1'){
              wp_redirect(get_site_url() . '/404', 302);
              exit;
            }
          }
        }
    }
  }
  $posts = get_posts(array('post_type' => 'theme-settings'));
  if(count($posts) > 0):
    foreach($posts as $post){
      if(get_field('slug_to_login', $post->ID)){
        $logkey = get_field('slug_to_login');
      }else{
        $logkey = 'enter';
      }
    }
  else:
    $logkey = 'enter';
  endif;
//    wp_reset_query();
  if(basename($_SERVER['REQUEST_URI']) == $logkey){
    wp_redirect(get_site_url() . '/wp-login.php?p=' . $pass, 302);
    exit;
  }
}

function trans($fieldName, $defaultValue){
  $posts = get_posts(array('post_type' => 'translations'));

  foreach ($posts as $post) :
    if (get_field($fieldName, $post->ID)) {
      return get_field($fieldName, $post->ID);
    }

  return $defaultValue;
    endforeach;
    return '';
}

function getUrlInTargetLanguage($targetLang){
  global $qtranslate_slug;

  return $qtranslate_slug->get_current_url($targetLang);
}
?>