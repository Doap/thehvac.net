<?php get_template_part('pink','header'); ?>
<div class="container">
  <!-- Main --> 
  <div class="_blank"></div>
  <div class="row-fluid">
    <div class="<?php if(!is_active_sidebar('sidebar-primary')){ echo 'span12'; }else { echo 'span8'; } ?>" id="main-content">
      <?php  $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
        $args = array( 'post_type' => 'post','paged'=>$paged);
        
        $post_type_data = new WP_Query( $args );
        while($post_type_data ->have_posts()):
        $post_type_data ->the_post();?>
      <div id="post-<?php the_ID(); ?>" <?php post_class('class-name'); ?>>
        <div class="media" id="blog-media">
          <div class="blog-icon-media">
            <?php $defalt_arg =array('class' => "blog-img" )?>
            <?php if(has_post_thumbnail()):?>
            <a class="pull-left" href="<?php the_permalink(); ?>"title="<?php the_title(); ?>"><?php the_post_thumbnail('blog-left-thumb', $defalt_arg); ?></a>
            <?php endif;?>
            <ul class="spa-blog-icon clearfix" id="blog-left-icons">
              <li class="admin-icon"><a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) );?>"><?php the_author();?></a></li>
              <li class="calendar-icon"> <?php echo get_the_date('M j,Y');?></li>
              <li class="blog-comment-icon">  <?php  comments_popup_link( __( 'Leave a comment', 'sis_spa' ),__( '1 Comment', 'sis_spa' ), __( '% Comments', 'sis_spa' ) ); ?></li>
            </ul>
          </div>
          <div class="media-body">
            <h4>
              <a href="<?php the_permalink(); ?>"title="<?php the_title(); ?>" class="blog-heading"><?php the_title(); ?></a>
            </h4>
            <div class="blog_content">
              <p><?php echo spa_get_the_other_excerpt();?></p>
              <span> <?php the_tags('<b>Tags:</b>',', ');?> </span>
            </div>
          </div>
        </div>
      </div>
      <?php endwhile;?>
      <div class="span12">
        <div class="span3"></div>
        <div class="span8">
          <?php	$Webriti_pagination = new Webriti_pagination();
            $Webriti_pagination->Webriti_page($paged, $post_type_data);		?>
        </div>
      </div>
    </div>
    <?php get_sidebar();?>
  </div>
</div>
<?php get_footer();?>