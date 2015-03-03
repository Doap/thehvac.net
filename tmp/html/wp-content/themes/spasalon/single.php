<?php get_template_part('pink','header'); ?>
<!-- Container for products -->
<div class="container">
  <!-- Main --> 
  <div class="row-fluid">
    <div class="_blank"></div>
    <!-- Spa-Saloon main Content --> 
    <div class="<?php if(!is_active_sidebar('sidebar-primary')){ echo 'span12'; }else { echo 'span8'; } ?> " id="post_single">
      <!--  	  Blog-post-detail 1--> 
      <?php the_post();?>
      <h2 class="blog_detail_head"><?php the_title(); ?></h2>
      <?php $defalt_arg =array('class' => "blog-detail-img" )?>
      <?php if(has_post_thumbnail()):?>
      <div class="media" >
        <a class="blog_detail_head" href="<?php the_permalink(); ?>"title="<?php the_title(); ?>"><?php the_post_thumbnail('', $defalt_arg); ?></a>
      </div>
      <?php endif;?>
      <div class="media" >
        <div class="span3" id="blog-post-icons">
          <ul class="spa-blog-icon clearfix">
            <li class="admin-icon"> <a href="<?php the_permalink(); ?>"><?php the_author();?></a></li>
            <li class="calendar-icon">  <a href="<?php the_permalink(); ?>"><?php the_date('M j,Y');?> </a></li>
            <li class="blog-comment-icon"> <?php  comments_popup_link( __( "Leave a comment", 'sis_spa' ),__( "1 Comment", 'sis_spa' ), __( "% Comments", 'sis_spa' ),'name' ); ?></li>
          </ul>
        </div>
        <div class="media-body">
          <div class="blog-detail-content">
            <p><?php the_content(); ?> </p>
          </div>
          <?php if(wp_link_pages(array('echo'=>0))):?>
          <div class="pagination pagination-large">
            <ul class="page-numbers"><?php 
              $args=array('before' => '<li>'.__('Pages:'),'after' => '</li>');
              wp_link_pages($args); ?></ul>
          </div>
          <?php endif;?> 
          <?php comments_template( '', true );?>
        </div>
      </div>
    </div>
    <!-- /Spa-Saloon main Content -->
    <div class="sidebar-topspacer"></div>
    <?php get_sidebar();?>
  </div>
</div>
<?php get_footer();?>