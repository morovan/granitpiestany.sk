<?php get_header(); ?>
  <div class="container post-detail">
  <?php if(have_posts()):while(have_posts()):the_post() ;?>
    <h1><div class="text-center"><?php the_title(); ?></div></h1>
    <?php if(has_post_thumbnail()): ?>
      <div class="hp-video single" data-toggle="modal" data-target="#video-<?php echo get_the_ID(); ?>">
        <div class="hp-article-img" style="background-image:url(<?php echo get_the_post_thumbnail_src(get_the_post_thumbnail($post_id,'full')); ?>)"><span class="ion-social-youtube-outline"></span></div>
        <?php the_content(); ?>
        <div class="share">
          <a onclick="nwindow();" target="ppw" class="social fb" href="https://www.facebook.com/sharer/sharer.php?u=<?php the_permalink(); ?>"><span class="sr-only">Facebook share</span><i class="fa fa-facebook"></i></a>
          <a onclick="nwindow();" target="ppw" class="social gp" href="https://plus.google.com/share?url=<?php the_permalink(); ?>"><span class="sr-only">Google plus share</span><i class="fa fa-google-plus"></i></a>
          <a onclick="nwindow();" target="ppw" class="social tw" href="https://twitter.com/share?url=<?php the_permalink(); ?>"><span class="sr-only">Tweet</span><i class="fa fa-twitter"></i></a>
          <a onclick="nwindow();" target="ppw" class="social lin" href="https://www.linkedin.com/shareArticle?url=<?php the_permalink(); ?>"><span class="sr-only">Linkedin share</span><i class="fa fa-linkedin"></i></a>
          <a href="mailto:?Subject=<?php the_title(); ?>&body=<?php the_permalink(); ?>" class="social mail"><span class="sr-only"><?php _e('Forward','lang'); ?></span><i class="fa fa-envelope"></i></a>
          <div class="clear"></div>
        </div>
      </div>
      <div class="modal fade" id="video-<?php echo get_the_ID(); ?>" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title"><?php the_title(); ?></h4>
            </div>
            <div class="modal-body">
              <video width="100%" height="490" class="c-video" controls>
                <?php if(get_field('video_file_mp4')){ ?><source src="<?php echo get_field('video_file_mp4'); ?>" type="video/mp4"><?php } ?>
                <?php if(get_field('video_file_ogg')){ ?><source src="<?php echo get_field('video_file_ogg'); ?>" type="video/ogg"><?php } ?>
                Your browser does not support the video tag.
              </video>
            </div>
          </div>
        </div>
      </div>
      <script type="text/javascript">
        $(function(){
          $('#video-<?php echo get_the_ID(); ?>').on('hidden.bs.modal',function(){
            $('#video-<?php echo get_the_ID(); ?> video').get(0).pause();
          });
        });
      </script>
    <?php endif; ?>
    <?php endwhile; else: ?>
    <h1><?php _e('Sorry, this page does not exist.','lang'); ?></h1>
    <p><a href="<?php echo get_home_url(); ?>"><?php _e('Go to home page','lang'); ?></a> <?php _e('or use search','lang'); ?>:</p>
    <?php
    get_search_form();
    ?>
  <?php endif; ?>
</div>
<?php get_footer(); ?>