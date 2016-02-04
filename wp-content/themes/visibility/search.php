<?php
get_header(); ?>

<div class="container">

  <?php
  $url = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
  if(false!==strpos($url,'cat=1')): ?>
  <div class="row">
    <div class="col-sm-8">
  <?php endif; ?>
  <?php if($_GET['s']!=''){ ?>
      <h1><?php printf(__('Search results for: %s','lang'),'<span>'.get_search_query().'</span>'); ?></h1>

    <?php if(have_posts()):while(have_posts()):the_post() ;?>
    <?php if(get_post_type()!='theme-settings'){ ?>
      <section>
        <div class="post">
          <?php if(has_post_thumbnail()): ?>
          <div class="row">
            <div class="col-sm-4">
              <img src="<?php echo get_the_post_thumbnail_src(get_the_post_thumbnail($post_id,'large')); ?>" alt="<?php the_title(); ?>" class="post-thumbnail" width="100%">
            </div>
            <div class="col-sm-8">
          <?php endif; ?>
              <header>
                <a href="<?php the_permalink(); ?>">
                  <h1 class="text-left"><?php the_title(); ?></h1>
                </a>
              </header>
              <article>
                <p><?php echo get_the_excerpt(); ?></p>
              </article>
              <footer>
                <a href="<?php the_permalink(); ?>" class="btn btn-more"><?php _e('Read more','lang'); ?></a>
                <p>&nbsp;</p>
              </footer>
          <?php if(has_post_thumbnail()): ?>
            </div>
          </div>
          <?php endif; ?>
        </div>
      </section>
    <?php } ?>
    <?php endwhile; ?>
    <?php
    global $wp_query;

      $big = 999999999;
      $translated = __( 'Page', 'lang' );

      $pages = paginate_links( array(
        'base' => str_replace( $big,'%#%',esc_url(get_pagenum_link($big))),
        'format' => '?paged=%#%',
        'current' => max( 1, get_query_var('paged')),
        'total' => $wp_query->max_num_pages,
        'before_page_number' => '<span class="sr-only">'.$translated.' </span>',
        'prev_text' => '<span class="glyphicon glyphicon-chevron-left"></span><span class="pntext"> '.__("Previous",'lang').'</span>',
        'next_text' => '<span class="pntext">'.__("Next",'lang').' </span><span class="glyphicon glyphicon-chevron-right"></span>',
        'type' => 'array'
      ));
      if( is_array( $pages ) ) {
        $paged = ( get_query_var('paged') == 0 ) ? 1 : get_query_var('paged');
        echo '<nav class="text-center"><ul class="pagination">';
        foreach ( $pages as $page ) {
          echo "<li>$page</li>";
        }
        echo '</ul></nav>';
      }
      ?>
      <?php else: ?>
        <p><?php _e('Sorry, there are no results matching criteria.','lang'); ?></p>
        <?php if(false!==strpos($url,'cat=1')){
          add_filter('get_search_form','search_blog_form');
          get_search_form();
          remove_filter('get_search_form','search_blog_form');
        }else{
          get_search_form();
        }
        ?>
      <?php endif; ?>
  <?php }else{ ?>
    <h1><?php _e('Sorry, there are no results matching criteria.','lang'); ?></h1>
    <?php if(false!==strpos($url,'cat=1')){
      add_filter('get_search_form','search_blog_form');
      get_search_form();
      remove_filter('get_search_form','search_blog_form');
    }else{
      get_search_form();
    }
    ?>
  <?php } ?>
  <?php if(false!==strpos($url,'cat=1')): ?>
    </div>
    <div class="col-sm-4">
      <div class="sidebar">
        <?php get_sidebar(); ?>
      </div>
    </div>
  </div>
  <?php endif; ?>

</div>

<?php get_footer(); ?>