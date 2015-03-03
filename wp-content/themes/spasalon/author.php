<?php get_template_part('pink','header'); ?>
<div class="container">
  <div class="_blank"></div>
  <!---main-->
  <div class="row-fluid">
    <div class="<?php if(!is_active_sidebar('sidebar-primary')){ echo 'span12'; }else { echo 'span8'; } ?>" >
      <?php if ( have_posts() ) : ?>
      <?php the_post(); ?>
      <h2 class="blog_detail_head">
        <?php _e( 'Author Archives: ', 'sis_spa' ); echo get_the_author(); ?>
      </h2>
      <?php
        /* Since we called the_post() above, we need to
         * rewind the loop back to the beginning that way
         * we can run the loop properly, in full.
         */
        rewind_posts();?>
      <?php
        // If a user has filled out their description, show a bio on their entries.
        if ( get_the_author_meta( 'description' ) ) : ?>
      <div class="author-info">
        <div class="author-avatar">
          <?php echo get_avatar( get_the_author_meta( 'user_email' ), apply_filters( 'twentytwelve_author_bio_avatar_size', 60 ) ); ?>
        </div>
        <!-- .author-avatar -->
        <div class="author-description">
          <h2><?php printf( __( 'About %s', 'sis_spa' ), get_the_author() ); ?></h2>
          <p><?php the_author_meta( 'description' ); ?></p>
        </div>
        <!-- .author-description	-->
      </div>
      <!-- .author-info -->
      <?php endif; ?>
      <?php /* Start the Loop */ ?>
      <?php    while(have_posts()): the_post();?>
      <div class="media" id="blog-media">
        <div class="blog-icon-media">
          <?php $defalt_arg =array('class' => "blog-img" )?>
          <?php if(has_post_thumbnail()):?>
          <a class="pull-left" href="<?php the_permalink(); ?>"title="<?php the_title(); ?>"><?php the_post_thumbnail('', $defalt_arg); ?></a>
          <?php endif;?>
          <ul class="spa-blog-icon clearfix">
            <li class="admin-icon"> <a href="#"><?php the_author();?></a></li>
            <li class="calendar-icon"> <a href="#"><?php the_date('M j,Y');?> </a></li>
            <li class="blog-comment-icon">  <?php  comments_popup_link( __( 'Leave a comment', 'sis_spa' ),__( '1 Comment', 'sis_spa' ), __( '% Comments', 'sis_spa' ),'name' ); ?></li>
          </ul>
        </div>
        <div class="media-body">
          <h4 ><a  class="blog-heading" href="<?php the_permalink(); ?>"title="<?php the_title(); ?>"><?php the_title(); ?></a></h4>
          <div class="blog_content">
            <p><?php echo get_the_other_excerpt();?></p>
          </div>
          <br>
        </div>
      </div>
      <?php endwhile;?>	 
      <?php spa_content_nav( 'nav-below' ); ?>
      <?php endif; ?>
    </div>
    <?php get_sidebar(); ?>
  </div>
</div>
<?php get_footer(); ?>