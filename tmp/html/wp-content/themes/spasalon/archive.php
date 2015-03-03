<?php get_template_part('pink','header'); ?>
<div class="container">
  <div class="_blank"></div>
  <!-- Main --> 
  <div class="row-fluid">
    <div class="<?php if(!is_active_sidebar('sidebar-primary')){ echo 'span12'; }else { echo 'span8'; } ?>" >
      <h2 class="blog_detail_head">
        <?php if ( is_day() ) : ?>
        <?php  _e( "Daily Archives:", 'sis_spa' ); echo (get_the_date()); ?>
        <?php elseif ( is_month() ) : ?>
        <?php  _e( "Monthly Archives:", 'sis_spa' ); echo (get_the_date( 'F Y' )); ?>
        <?php elseif ( is_year() ) : ?>
        <?php  _e( "Yearly Archives:", 'sis_spa' );  echo (get_the_date( 'Y' )); ?>
        <?php else : ?>
        <?php _e( "Blog Archives", 'sis_spa' ); ?>
        <?php endif; ?>
      </h2>
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
          <h4 ><a  class="blog-heading" href="<?php the_permalink(); ?>"title="<?php the_title(); ?>"><?php the_title(); ?></a>
          </h4>
          <div class="blog_content">
            <p><?php echo spa_get_the_other_excerpt();?></p>
          </div>
          <br>
        </div>
      </div>
      <?php endwhile;?>		 
    </div>
    <?php get_sidebar();?>
  </div>
</div>
<?php  get_footer(); ?>