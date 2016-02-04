<?php
/*
Template Name: Video
*/
get_header(); ?>

<div class="container">
  <?php if(have_posts()):while(have_posts()):the_post(); ?>
  <?php if(has_post_thumbnail()): ?>
    <img src="<?php echo get_the_post_thumbnail_src(get_the_post_thumbnail($post_id,'large')); ?>" alt="<?php the_title(); ?>" class="post-thumbnail" width="100%">
  <?php endif; ?>
  <h1><?php the_title(); ?></h1>
  <?php echo do_shortcode(get_the_content()); ?>
  <?php endwhile;endif; ?>
  <?php $p=0;$pb=0; ?>
  <?php
  query_posts('post_type=video&posts_per_page=-1');if(have_posts()):while(have_posts()):the_post();
    if(has_post_thumbnail()){if(get_field('video_file_mp4')){ ?>
      <?php if($p==0){echo '<div class="row">';} ?>
      <div class="col-sm-4">
        <h2 class="videos-mh"><?php the_title(); ?></h2>
        <div class="hp-video" data-toggle="modal" data-target="#video-<?php echo get_the_ID(); ?>">
          <div class="hp-article-img" style="background-image:url(<?php echo get_the_post_thumbnail_src(get_the_post_thumbnail($post_id,'full')); ?>)"><span class="ion-social-youtube-outline"></span></div>
        </div>
        <br>
        <?php echo do_shortcode(get_the_content()); ?>
      </div>
      <div class="modal fade" id="video-<?php echo get_the_ID(); ?>" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title"><?php the_title(); ?></h4>
            </div>
            <div class="modal-body">
            </div>
          </div>
        </div>
      </div>
      <script type="text/javascript">
        $(function(){
          $('#video-<?php echo get_the_ID(); ?>').on('shown.bs.modal',function(){
            $('#video-<?php echo get_the_ID(); ?> .modal-body').html('<video width="100%" height="490" class="c-video" controls><?php if(get_field("video_file_mp4")){ ?><source src="<?php echo get_field("video_file_mp4"); ?>" type="video/mp4"><?php }  if(get_field("video_file_ogg")){ ?><source src="<?php echo get_field("video_file_ogg"); ?>" type="video/ogg"><?php } ?>Your browser does not support the video tag.</video>');
            $('#video-<?php echo get_the_ID(); ?> video').get(0).play();
          })
          $('#video-<?php echo get_the_ID(); ?>').on('hidden.bs.modal',function(){
            $('#video-<?php echo get_the_ID(); ?> video').get(0).pause();
            $('#video-<?php echo get_the_ID(); ?> .modal-body').html('');
          });
        });
      </script>
      <?php if($p==2){echo '</div>';} ?>
      <?php $p++;$pb++ ?>
      <?php if($p==3){$p=0;} ?>
    <?php }}
  endwhile;endif;wp_reset_query();
  ?>
  <?php if($pb%3!=0){echo '</div>';} ?>
</div>

<?php get_footer(); ?>