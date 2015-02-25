<?php get_template_part('pink','header'); ?>
<div class="container">
  <div class="_blank"></div>
  <div class="row-fluid">
    <div class="<?php if(!is_active_sidebar('sidebar-primary')){ echo 'span12'; }else { echo 'span8'; } ?>" id="main-content">
      <?php if ( have_posts() ) : ?>
      <h2><?php printf( __( "Search Results for:", 'sis_spa' ), '<span>' . get_search_query() . '</span>' ); ?></h2>
      <?php /* Start the Loop */ ?>
      <?php while ( have_posts() ) : the_post(); ?>
      <div class="media" id="blog-media">
        <div class="blog-icon-media">
          <?php $defalt_arg =array('class' => "blog-img" )?>
          <?php if(has_post_thumbnail()):?>
          <a class="pull-left" href="<?php the_permalink(); ?>"title="<?php the_title(); ?>"><?php the_post_thumbnail('', $defalt_arg); ?></a>
          <?php endif;?>
          <ul class="blog-icons clearfix">
            <li><i class="icon-user"></i> <a href="#"><?php the_author();?></a></li>
            <li><i class="icon-calendar"></i> <a href="#"><?php the_date('M j,Y');?> </a></li>
            <li><i class="icon-comment"></i>  <?php  comments_popup_link( __( "Leave a comment", 'sis_spa' ),__( "1 Comment", 'sis_spa' ), __( "% Comments", 'sis_spa' ),'name' ); ?></li>
          </ul>
        </div>
        <div class="media-body">
        <h4 class="blog-detail-head"><a href="<?php the_permalink(); ?>"title="<?php get_search_query(); ?>"></a></h4>
          <div class="blog_content">
            <p><?php the_excerpt();?></p>
          </div>
          <br>
        </div>
      </div>
      <?php endwhile; ?><?php else : ?>
      <h2 class="blog-heading"><?php _e( "Nothing Found", 'sis_spa' ); ?></h2>
      <div class="">
        <p><?php _e( "Sorry, but nothing matched your search criteria. Please try again with some different keywords.", 'sis_spa' ); ?></p>
        <?php get_search_form(); ?>
      </div>
      <!-- .blog_con_mn -->
      <?php endif; ?>
    </div>
    <?php get_sidebar();?>
  </div>
</div>
<div class="_blank"></div>
<div class="_blank"></div>
<div class="_blank"></div>
<div class="_blank"></div>
<div class="_blank"></div>
<?php  get_footer() ?>