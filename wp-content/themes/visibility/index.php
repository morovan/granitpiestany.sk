<?php get_header(); ?>

  <div class="container post-detail">
    <div class="row">
      <div class="col-sm-8">

        <?php if(have_posts()):while(have_posts()):the_post() ;?>
          <?php if(has_post_thumbnail()): ?>
            <img src="<?php echo get_the_post_thumbnail_src(get_the_post_thumbnail($post_id,'large')); ?>" alt="<?php the_title(); ?>" width="100%">
          <?php endif; ?>
          <h1><?php the_title(); ?></h1>
          <div class="post-meta">
            <?php
            $category = get_the_category();
            echo '<a href="';
            echo get_category_link($category[0]->cat_ID);
            echo '">';
            echo $category[0]->cat_name;
            echo '</a>'
            ?> | <?php the_time('j. F Y'); ?>
          </div>
          <?php the_content(); ?>
          <div class="share">
            <a onclick="nwindow();" target="ppw" class="social fb" href="https://www.facebook.com/sharer/sharer.php?u=<?php the_permalink(); ?>"><span class="sr-only">Facebook share</span><i class="fa fa-facebook"></i></a>
            <a onclick="nwindow();" target="ppw" class="social gp" href="https://plus.google.com/share?url=<?php the_permalink(); ?>"><span class="sr-only">Google plus share</span><i class="fa fa-google-plus"></i></a>
            <a onclick="nwindow();" target="ppw" class="social tw" href="https://twitter.com/share?url=<?php the_permalink(); ?>"><span class="sr-only">Tweet</span><i class="fa fa-twitter"></i></a>
            <a onclick="nwindow();" target="ppw" class="social lin" href="https://www.linkedin.com/shareArticle?url=<?php the_permalink(); ?>"><span class="sr-only">Linkedin share</span><i class="fa fa-linkedin"></i></a>
            <a href="mailto:?Subject=<?php the_title(); ?>&body=<?php the_permalink(); ?>" class="social mail"><span class="sr-only"><?php _e('Forward','lang'); ?></span><i class="fa fa-envelope"></i></a>
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
      <div class="col-sm-4">
        <div class="sidebar">
          <?php get_sidebar(); ?>
        </div>
      </div>
    </div>
  </div>
<?php get_footer(); ?>