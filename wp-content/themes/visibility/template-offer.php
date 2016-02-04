<?php
/*
Template Name: Template Offer
*/
get_header(); ?>
  <div class="container template-hotel-offer">
  <h1><?php the_title() ?></h1>
    <?php
    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
    if (isset($_GET['hotel'])) {
      $slugs_to_get = array();
      $slugs_to_get = array_merge($slugs_to_get, (array)$_GET['hotel']);
      $ids = array();
      $meta_queries = array();
      $lang = qtrans_getLanguage();

      foreach ($slugs_to_get as $slug_to_get) {
        $args = array(
          'post_type'		=>	'hotel',
          'post_status'      => 'publish',
          'meta_query'	=>	array(
            array(
              'key' => '_qts_slug_'.$lang,
              'value'	=>	$slug_to_get
            )
          )
        );
        $my_posts = get_posts($args);
        foreach ($my_posts as $post_temp) {
          if(!in_array($post_temp->ID, $ids)){
            $ids[] = $post_temp->ID;
            array_push($meta_queries, array(
              'key'     => 'offer_for_hotel',
              'value'   =>  '"'.$post_temp->ID. '"' ,
              'compare' => 'LIKE'
            ));
          }
        }

      }
        if(count($ids) == 1){
          $meta_query_args = array(
            $meta_queries
          );
        }else{
          $meta_query_args = array(
              'relation' => 'OR',
              $meta_queries
          );
        }

        global $wpdb, $paged, $max_num_pages;
        $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
        $post_per_page = intval(get_query_var('posts_per_page'));
        $offset = ($paged - 1)*$post_per_page;

        $select = "SELECT * FROM `gr_posts` WHERE
        post_type='offer' AND post_status ='publish' AND ID
         IN(
        SELECT post_id FROM `gr_postmeta` WHERE meta_key='offer_for_hotel'
        AND (";
        foreach($meta_queries as $meta){
          $select .= "meta_value LIKE '%".$meta['value']."%' ";
          if(end($meta_queries) != $meta){
              $select .= 'OR ';
          }
        }
        $select .="))";
        $select_paged = $select." LIMIT ".$offset.", ".$post_per_page."; ";

        $the_posts = $wpdb->get_results($select_paged);
        $total_result = $wpdb->get_results( $select );

        $sql_posts_total = $wpdb->get_var( "SELECT FOUND_ROWS();" );
        $max_num_pages = ceil($sql_posts_total / $post_per_page);

    }else{
      $args = array(
        'post_type'      => 'offer',
        'posts_per_page' => get_option('posts_per_page', 5),
        'paged'          => $paged);
      $the_posts = get_posts($args);
      $wp_query = new WP_Query($args);
    }

    ?>
    <div class="row hotel-offer-filter">
      <form id="filter-hotel-offer" action="<?php the_permalink() ?>">
        <div class="col-sm-3 filter-text"><?php echo trans('filter_offers_in_lang', 'Filter offers in hotels:') ?></div>
        <?php
        $posts = get_posts(array('post_type' => 'hotel'));
        ?>
        <div class="col-sm-9">
          <?php
          foreach ($posts as $post) : ?>
            <?php if($post->post_title!='Nová Polianka'){ ?>
              <div class="pull-left">
                <input onchange="this.form.submit()" type="checkbox" name="hotel[]" id="filter-hotel-<?php echo $post->ID; ?>"
                   value="<?php echo basename(get_the_permalink($post->ID)); ?>"
                  <?php echo(isset($_GET['hotel']) && ((is_array($_GET['hotel']) && in_array(basename(get_the_permalink($post->ID)), $_GET['hotel'])) || $_GET['hotel'] == basename(get_the_permalink($post->ID))) ? ' checked' : (!isset($_GET['hotel']) ? ' checked' : '')) ?>/>
                  <label for="filter-hotel-<?php echo $post->ID; ?>"><?php echo $post->post_title; ?></label>
              </div>
            <?php } ?>
          <?php endforeach;
          ?>
            </div>
        </form>
    </div>
    <?php
    foreach ($the_posts as $post):
    setup_postdata($post);; ?>
    <div class="row hotel-offer">
      <div class="hotel-offer-inner clearfix">
        <?php if (has_post_thumbnail()): ?>
          <div class="col-md-3 col-sm-4">
            <a href="<?php the_permalink()?>"><div class="squater" style="background-image:url(<?php echo get_the_post_thumbnail_src(get_the_post_thumbnail($post_id, 'large')); ?>)"></div>
               </a>
          </div>
          <div class="col-md-9 col-sm-8">
          <?php else: ?>
            <div class="col-md-12">
              <?php endif; ?>
              <div class="hotel-offer-available"><?php echo trans('offer_available_in_lang', 'Offer is available in:') ?>
                <span>
                  <?php
                    if (get_field('offer_date_from')) {
                      echo date_i18n('j. n.', strtotime(get_field('offer_date_from')));
                    }
                    if (get_field('offer_date_to')) {
                      echo ' - ' . date_i18n('j. n. Y', strtotime(get_field('offer_date_to')));
                    }
                  ?>
                </span>
              </div>
              <div class="offer-for-hotel">
                <span>
                  <?php if (get_field('offer_for_hotel')) : ?>
                    <?php $hotels = get_field('offer_for_hotel'); ?>
                    <?php foreach($hotels as $hotel): ?>
                    <?php
                    echo '<a href="'.get_the_permalink($hotel->ID).'">'.__('Hotel GRANIT', 'lang').' '.$hotel->post_title.'</a>'; echo (end($hotels) != $hotel ? ', ': '')?>
                    <?php endforeach; ?>
                  <?php endif ?>
                </span>
              </div>

              <a href="<?php the_permalink()?>" class="hotel-offer-title"><h2><?php the_title(); ?></h2></a>

              <p class="hotel-offer-overflow"><?php echo get_the_excerpt(); ?></p>

              <div class="offer-price pull-left">
                <?php
                if (get_field('offer_price')) {
                  echo get_field('offer_price');
                }
                ?>
              </div>
              <div class="pull-left">
                <a class="btn btn-more"
                   href="<?php the_permalink(); ?>"><?php echo trans('more_about_offer_lang', 'More about offer') ?></a>
              </div>
            </div>
          </div>
        </div>
        <?php endforeach; ?>
        <?php
        global $wp_query;

        $big = 999999999;
        $translated = __('Page', 'lang');
        $pages = paginate_links(array(
          'base'               => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
          'format'             => '?paged=%#%',
          'current'            => max(1, get_query_var('paged')),
          'total'              => isset($max_num_pages) ? $max_num_pages : $wp_query->max_num_pages,
          'before_page_number' => '<span class="sr-only">' . $translated . ' </span>',
          'prev_text'          => '<span class="pntext"> <i class="ion-android-arrow-back"></i> </span>',
          'next_text'          => '<span class="pntext"> <i class="ion-android-arrow-forward"></i> </span>',
          'type'               => 'array'
        ));
        if (is_array($pages)) {
          $paged = (get_query_var('paged') == 0) ? 1 : get_query_var('paged');
          echo '<nav class="text-center"><ul class="pagination">';
          foreach ($pages as $page) {
            echo "<li>$page</li>";
          }
          echo '</ul></nav>';
        }
        ?>
<!--        --><?php //else: ?>
<!--            <h1>--><?php //_e('Sorry, this page does not exist.', 'lang'); ?><!--</h1>-->
<!--            <p>-->
<!--                <a href="--><?php //echo get_home_url(); ?><!--">--><?php //_e('Go to home page', 'lang'); ?><!--</a> --><?php //_e('or use search', 'lang'); ?>
<!--                :</p>-->
<!--            --><?php
//            get_search_form();
//            ?>
<!--        --><?php //endif; ?>
    </div>
<?php get_footer(); ?>