<div style="padding:10px;background-color:#fff;">
<ul class="su-posts su-posts-list-loop">
<?php
// Posts are found
if ( $posts->have_posts() ) {
        while ( $posts->have_posts() ) {
                $posts->the_post();
                global $post;
?>
<div title="<?php echo ('de '); the_date('','',''); ?>" style="width:100%;margin-bottom:3px;"><li class="fa fa-star" style="color:#369" id="su-post-<?php the_ID(); ?>" class="su-post"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>  <?php //the_date('','',''); ?></li></div>
<?php
        }
}
// Posts not found
else {
?>
<li><?php _e( 'Posts not found', 'su' ) ?></li>
<?php
}
?>
</ul>
</div>
