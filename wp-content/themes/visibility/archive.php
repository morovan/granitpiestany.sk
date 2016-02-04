<?php get_header(); ?>

<div class="container">
  <div class="row">
    <div class="col-sm-8">
      <h1><?php
      if(is_category()){
        $category = get_the_category();
        _e('Articles category','lang');
        echo ' '.$category[0]->cat_name;
      }else if(is_author()){
        _e('Articles author','lang');
        echo ' <span itemprop="author">'.get_the_author().'</span>';
      }else if(is_tag()){
        $posttags = get_the_tags();
        _e('Articles containing the tag','lang');
        echo ' '.$posttags[0]->name;
      }else{
        if(is_day()){
          _e('Articles of the Day','lang');
          echo ' <time datetime="';
          the_time('Y-m-d');
          echo '" itemprop="datePublished">';
          the_time('j. F Y');
          echo '</time>';
        }else if(is_month()){
          _e('Articles of the Month','lang');
          echo ' <time datetime="';
          the_time('Y-m');
          echo '" itemprop="datePublished">';
          the_time('F Y');
          echo '</time>';
        }else if(is_year()){
          _e('Articles of the Year','lang');
          echo ' <time datetime="'.get_query_var('year').'" itemprop="datePublished">'.get_query_var('year').'</time>';
        }else{
          _e('Articles');
        }
      }
      ?></h1>

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
                  <div class="row">
                    <div class="col-sm-6">
                      <a href="<?php the_permalink(); ?>" class="btn btn-more"><?php _e('Read more','lang'); ?></a>
                    </div>
                    <div class="col-sm-6 text-right">
                      <div class="share">
                        <a onclick="nwindow();" target="ppw" class="social fb" href="https://www.facebook.com/sharer/sharer.php?u=<?php the_permalink(); ?>"><span class="sr-only">Facebook share</span><i class="fa fa-facebook"></i></a>
                        <a onclick="nwindow();" target="ppw" class="social gp" href="https://plus.google.com/share?url=<?php the_permalink(); ?>"><span class="sr-only">Google plus share</span><i class="fa fa-google-plus"></i></a>
                        <a onclick="nwindow();" target="ppw" class="social tw" href="https://twitter.com/share?url=<?php the_permalink(); ?>"><span class="sr-only">Tweet</span><i class="fa fa-twitter"></i></a>
                        <a onclick="nwindow();" target="ppw" class="social lin" href="https://www.linkedin.com/shareArticle?url=<?php the_permalink(); ?>"><span class="sr-only">Linkedin share</span><i class="fa fa-linkedin"></i></a>
                        <a href="mailto:?Subject=<?php the_title(); ?>&body=<?php the_permalink(); ?>" class="social mail"><span class="sr-only"><?php _e('Forward','lang'); ?></span><i class="fa fa-envelope"></i></a>
                        <div class="clear"></div>
                      </div>
                    </div>
                  </div>
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
    <div class="col-sm-4">
      <div class="sidebar">
        <?php get_sidebar(); ?>
      </div>
    </div>
  </div>
</div>
<?php get_footer(); ?>