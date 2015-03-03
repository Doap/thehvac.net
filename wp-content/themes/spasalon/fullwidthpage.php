<?php 
    // Template Name: fullwidthpage
    ?>
<?php get_template_part('pink','header'); ?>


<!-- Container for products -->
<div class="container">
    <!-- Main --> 
    <div class="_blank"></div>
    <div class="row-fluid">
        <div class="span12">
            <?php the_post();?>
            <h2 class="blog_detail_head"><?php the_title(); ?></h2>
            <?php $defalt_arg =array('class' => "full-width-img" )?>
            <?php if(has_post_thumbnail()):?>
            <div class="media" >
                <a href="<?php the_permalink(); ?>"title="<?php the_title(); ?>"><?php the_post_thumbnail('', $defalt_arg); ?></a>
            </div>
            <?php endif;?> 
            <div class="media-body">
                <div class="fullwidth-content">
                    <p><?php the_content(); ?> </p>
                </div>
            </div>
        </div>
    </div>
</div>
<?php get_footer();?>