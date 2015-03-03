<?php get_template_part('pink','header');?>
<!-- Container for products -->
<div class="container">
  <!-- Main --> 
  <div class="_blank"></div>
  <div class="row-fluid">
    <!-- Spa-Saloon main Content -->	
    <div class="<?php if(!is_active_sidebar('sidebar-primary')){ echo 'span12'; }else { echo 'span8'; } ?>">
      <!-- Blog-post-detail 1--> 
      <?php the_post();?>
      <h2 class="blog_detail_head"><?php the_title(); ?></h2>
      <?php $defalt_arg =array('class' => "blog-detail-img" )?>
      <?php if(has_post_thumbnail()):?>
      <div class="media" >
        <a href="<?php the_permalink(); ?>"title="<?php the_title(); ?>"><?php the_post_thumbnail('', $defalt_arg); ?>
        </a>
      </div>
      <?php endif;?>
      <div class="media" >       
        <div class="media-body">
          <div class="blog-detail-content"><?php the_content(); ?> </div>
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
    <?php get_sidebar(); ?>
  </div>
</div>
<?php get_footer();?>