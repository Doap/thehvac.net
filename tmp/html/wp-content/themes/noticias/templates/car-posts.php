<?php
//wp_reset_query();
global $wp_query;
//$args = array_merge( $wp_query->query_vars, array( 'meta_query' => array( array( 'key' => 'breves', 'compare' => 'NOT EXISTS' ) ), 'post__not_in' => $feat_post ) );
$args = array_merge( $wp_query->query_vars, array( 'cat' => $themaincat, 'meta_query' => array( 'relation' => 'OR', array( 'key' => 'destacado', 'compare' => 'NOT EXISTS' ), array( 'key' => 'destacado', 'value' => 0, 'type' => 'NUMERIC' ) ), 'post__not_in' => $feat_post ) );
//$args = array_merge( $wp_query->query_vars, array( 'offset' => $posts_offset, 'cat' => $themaincat, 'meta_query' => array( 'relation' => 'OR', array( 'key' => 'destacado', 'compare' => 'NOT EXISTS' ), array( 'key' => 'destacado', 'value' => 0, 'type' => 'NUMERIC' ) ), 'post__not_in' => $feat_post ) );
//$args = array( 'post__not_in' => $feat_post );
//$args = array_merge( $wp_query->query_vars, array( 'post__not_in' => array(get_option( 'sticky_posts' ), $feat_post ) ) );
remove_filter('posts_clauses', 'filterEdiciones');
$the_query = new WP_Query( $args );
//var_dump($query);
//query_posts( $args );
//var_dump($args);
//var_dump($the_query);
//var_dump($feat_post);
$even = 0; 
//echo do_shortcode('[doap_heading style="modern-1-blue" size="20" align="left" margin="0" class="fp-title-bar"]<a href="http://noticias.laprensa.com.ni/nacionales/page/2"><div class="title-left">MÁS EN ' . mb_strtoupper($single_cat_title) . '</div><div class="line-container"><div class="line"></div></div></a>[/doap_heading]');
if ($themaincat <> 1672)
{
echo '<div style="height:10px;clear:both;"></div>';
}
echo '<div class="su heading su-heading-style-modern-1-blue su-heading-align-left fp-title-bar" style="font-size:20px;margin:8px 5px 4px 4px"><a href="http://noticias.laprensa.com.ni/' . $single_cat_url . '"><div id="des-sec" class="title-left" style="margin-left:4px;">' . $sub_cat_title . '</div><div id="des-dot" class="twodots"></div></a></div>';
echo '<div style="height:5px;clear:both;"></div>';
	if( $the_query->have_posts() ) 
	{
//var_dump($query);
		get_template_part( 'deportes-loop-header' ); 
//echo 'max posts = ' . $max_posts;
		while( $the_query->have_posts() && $even < $max_posts )
		{ 
			$the_query->the_post();

$even++;
$float='left';
echo '<div style="clear:both;"></div>';
responsive_entry_before(); 
echo '<div id="su-post-' . get_the_ID() . '" class="su-post" style="position:relative;margin:5px">';
responsive_entry_top(); 
//get_template_part( 'category-meta' ); 
$theexcerpt = get_the_excerpt();
$thepermalink = get_the_permalink();

?>
				<div class="post-entry">
<?php
$gmt_timestamp = get_post_time('U', true); 
if ( has_post_thumbnail() ) {

$feat_image = wp_get_attachment_url( get_post_thumbnail_id($post->ID) );

$feat_image_array = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'responsive-150' );
$post_url = get_permalink($post->ID);
$feat_image = $feat_image_array[0];
echo '<div style="position:relative;float:left;max-width:150px;margin:0px 50px 5px 0px;">' . PHP_EOL . '<a href="' . $post_url . '"><img src="' . $feat_image . '"></a>' . PHP_EOL;
echo '</div>';

} else { ?>
<?php $current_category = single_cat_title("", false); ?>
<div style="width:100%;height:200px;margin-left:auto;margin-right:auto;"><img src="http://laprensa13.doap.us/wp-content/uploads/sites/2/2014/04/laprensanota-<?php echo strtolower($current_category); ?>.jpg" draggable="false"> </div><div style="clear:both;"></div><?php } ?> 
					<?php
echo do_shortcode('<a href="' . $thepermalink . '" title="Haz clic aqui para leer el nota completo.">[doap_animate type="fadeIn"][doap_heading style="modern-1-blue" size="25" align="left" margin="0" class="fp-title-bar"]'.ucfirst(get_the_title()).'[/doap_heading][/doap_animate]</a>'); 
if ($themaincat = 1672)
{
//	date_default_timezone_set('America/Managua');
//	echo date("F j, Y", strtotime($post->post_date)); 
	echo '<div class="date-tags">' . get_the_date("F j, Y") . ' - ' . get_the_term_list( $post->ID, 'post_tag', 'Etiquetas: ', ', ', '' ) . '</div>'; 
	echo '<div class="cari-comments">' . writeComments("black", $post->ID) . '</div>';
}
					if( responsive_pro_get_option( 'archive_post_excerpts' ) ) {
					//	add_filter( 'excerpt_more', 'responsive_pro_excerpt_more_text' );
					//	add_filter( 'excerpt_length', 'responsive_pro_excerpt_more_length' );
						echo "<div style=float:left;position:relative;width:100%;>";
                                                //$the_excerpt = get_the_excerpt(); //echo $the_excerpt;
                                                $the_excerpt = $post->post_excerpt; //echo $the_excerpt;
                                          //      $the_content = strip_tags(get_the_content()); //echo $the_content;
                                               // the_excerpt();
                                        echo "</div>";
						remove_filter( 'excerpt_more', 'responsive_pro_excerpt_more_text' );
						remove_filter( 'excerpt_length', 'responsive_pro_excerpt_more_length' );
					}
					else {
					//	add_filter( 'excerpt_more', 'responsive_pro_excerpt_more_text' );
					//	add_filter( 'excerpt_length', 'responsive_pro_excerpt_more_length' );
					 echo "<div style=max-float:left;position:relative;>";
                                                $the_excerpt = $post->post_excerpt; //echo $the_excerpt;
                                                //$the_excerpt = get_the_excerpt(); //echo $the_excerpt;
                                                //$the_content = get_the_content(); //echo $the_content;
                                                echo $the_excerpt;
                                        echo "</div>";
						remove_filter( 'excerpt_more', 'responsive_pro_excerpt_more_text' );
						remove_filter( 'excerpt_length', 'responsive_pro_excerpt_more_length' );
					}
/*
 ?><div id="cat-tax">
<?php
 $taxonomies = get_object_taxonomies( get_post_type(), 'objects' );
                                                foreach( $taxonomies as $id => $taxonomy ) :
                                                        $terms_list = get_the_term_list( 0, $id, '', ', ' );
                                                        echo "<br>";
                                                        if ( strlen( $terms_list ) > 0 ) : ?>
                                                        <span class="tcp-product-taxonomy tcp-product-taxonomy-<?php echo $taxonomy->name;?>"><?php echo $taxonomy->labels->singular_name; ?>:
                                                        <?php echo $terms_list;?>
                                                        </span>
                                                        <?php endif;
                                                endforeach;?></div>

<?php
*/


					wp_link_pages( array( 'before' => '<div class="pagination">' . __( 'Pages:', 'responsive' ), 'after' => '</div>' ) );
					?>
				</div>
<hr style="margin:0px;">
				<!-- end of .post-entry -->




				<?php //get_template_part( 'post-data' ); ?>

				<?php responsive_entry_bottom(); ?>
			</div><!-- end of #post-<?php the_ID(); ?> -->
			<?php responsive_entry_after(); 
	}
        //        echo '<div style="position:relative;float:left;">'; wpbeginner_numeric_posts_nav(); echo '</div>';
		//get_template_part( 'loop-nav' );
}
	else
	{
		get_template_part( 'loop-no-posts' );
	}
