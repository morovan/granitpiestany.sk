<?php
/*
  Template Name: Template Horezza News
  */
get_header(); ?>


<div class="container page-horezza-news">
  <div class="row">
    <h1><?php the_title() ?></h1>
  </div>
  <?php
    $args = array(
      'post_type' => 'horezza-news',
      'posts_per_page' => 1
    );
    query_posts('post_type=horezza-news&posts_per_page=1');if(have_posts()):while(have_posts()):the_post();
  ?>
    <div class="row horezza-news-first">
      <?php if(has_post_thumbnail()): ?>
        <div class="col-md-5">
          <img src="<?php echo get_the_post_thumbnail_src(get_the_post_thumbnail($post_id,'large')); ?>" alt="<?php the_title(); ?>" class="img-responsive" width="100%">
        </div>
        <div class="col-md-6 col-md-offset-1">
          <?php else: ?>
          <div class="col-md-12">
            <?php endif;  ?>
            <a class="dark-brown" href="<?php the_permalink() ?>"><span>HOREZZA NEWS</span><h2><?php the_title(); ?></h2></a>
            <p>
              <?php echo do_shortcode(get_the_content()); ?>
            </p>
            <?php if(get_field('horezza_download')): ?>
            <a href="<?php echo "http://$_SERVER[HTTP_HOST]/hn/".get_field('horezza_download')?>" target="_blank" class="btn btn-more no-margins m-top-40"><?php echo trans('read_all_horezza_lang', 'Read all')?></a>
            <?php endif;  ?>
          </div>
        </div>
         <?php
          endwhile;endif;wp_reset_query();
        ?>
    <div class="row">
      <div class="col-md-10 col-md-offset-1">
        <div class="carousel-wrap">
          <div id="carousel-horezza" class="owl-carousel">
            <?php
              query_posts('post_type=horezza-news&posts_per_page=-1');if(have_posts()):while(have_posts()):the_post();
            ?>
            <div class="item">
              <div class="item-inner">
                <a href="<?php the_permalink() ?>">
                  <?php if(has_post_thumbnail()): ?>
                    <img src="<?php echo get_the_post_thumbnail_src(get_the_post_thumbnail($post_id,'large')); ?>" alt="<?php the_title(); ?>" class="post-thumbnail" width="100%">
                  <?php endif; ?>
                  <h3><?php the_title(); ?></h3>
                </a>
              </div>
            </div>
            <?php
              endwhile;endif;wp_reset_query();
            ?>
          </div>
            <a data-slide="prev" role="button" href="#carousel-horezza" class="left carousel-control">
              <span class="ion ion-android-arrow-back"></span>
            </a>
            <a data-slide="next" role="button" href="#carousel-horezza" class="right carousel-control">
              <span class="ion ion-android-arrow-forward"></span>
            </a>
        </div>
      </div>
    </div>
</div>
<script type="text/javascript">
  $(document).ready(function() {
    var owl = $("#carousel-horezza");

      owl.owlCarousel({
        itemsCustom : [
          [1, 6],
          [1000, 6]
        ]
      });

        $(".carousel-wrap .right").click(function(){
          owl.trigger('owl.next');
          return false;
        });
        $(".carousel-wrap .left").click(function(){
          owl.trigger('owl.prev');
          return false;
        });
  });
</script>
<?php get_footer(); ?>