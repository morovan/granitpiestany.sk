<?php get_header(); ?>
<div class="container">
  <h1 class="blog-title"><?php
    query_posts('post_type=theme-settings');if(have_posts()):while(have_posts()):the_post();
      if(get_field('blog_title')){
        echo do_shortcode(get_field('blog_title'));
      }
    endwhile;endif;wp_reset_query();
    ?></h1>
  <div class="row">
    <div class="col-sm-8">
      <?php if(have_posts()):while(have_posts()):the_post() ;?>
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
                <div class="post-meta">
                  <?php
                  $category = get_the_category();
                  echo '<a href="';
                  echo get_category_link($category[0]->cat_ID);
                  echo '">';
                  echo $category[0]->cat_name;
                  echo '</a>'
                  ?> |
                  <?php
                  echo ' <time datetime="';
                  the_time('Y-m-d');
                  echo '" itemprop="datePublished">';
                  the_time('j. F Y');
                  echo '</time>';
                  ?>
                </div>
                <a href="<?php the_permalink(); ?>">
                  <h1 class="text-left"><?php the_title(); ?></h1>
                </a>
              </header>
              <article>
                <p><?php echo get_the_excerpt(); ?></p>
              </article>
              <footer>
                <a href="<?php the_permalink(); ?>" class="btn btn-more"><?php _e('Read more','lang'); ?></a>
              </footer>
            <?php if(has_post_thumbnail()): ?>
              </div>
            </div>
            <?php endif; ?>
          </div>
        </section>
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
      <?php endif; ?>

    </div>
    <div class="col-sm-4 col-lg-3 col-lg-offset-1">
      <div class="sidebar">
        <?php get_sidebar(); ?>
      </div> 
    </div>
  </div>
</div>

<?php get_footer(); ?>