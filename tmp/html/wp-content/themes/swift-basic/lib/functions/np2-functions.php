<?php
/*
 * Created on Feb 2, 2013
*
* To change the template for this generated file go to
* Window - Preferences - PHPeclipse - PHP - Code Templates
*/
function swift_np2_authors_mosaic(){
	$args = array(
			'orderby'       => 'post_count',
			'order'         => '',
			'number'        => 9,
			'optioncount'   => false,
			'exclude_admin' => true,
			'show_fullname' => false,
			'hide_empty'    => true,
			'echo'          => true,
			'feed'          => '',
			'feed_image'    => '',
			'feed_type'     => '',
			'style'         => 'list',
			'html'          => true );
	// The Query
	$user_query = new WP_User_Query( $args );

	// User Loop
	if ( !empty( $user_query->results ) ) {
		$out ='<p class="section-title">Top authors</p><ul class="mosaic">';
		foreach ( $user_query->results as $user ) {
			//var_dump( $user);
			$out .= '<li><a href="'.esc_url( get_author_posts_url( $user->ID ) ).'" rel="author">' . get_avatar($user->ID, 115) . '</a>';
			$out .=	'<div class="tooltip">About <strong>'.$user->display_name.'</strong><br />';
			$out .=	get_the_author_meta( 'description', $user->ID ).'<br />';
			$out .= $user->display_name.' '.sprintf(__('has written %d articles so far.','swift'),'<strong>'.get_the_author_posts($user->ID).'</strong>');
			$out .= '<br /><a href="'.esc_url( get_author_posts_url( $user->ID ) ).'" rel="author">'.__('Read them all','swift').'</a>';
			$out .= '</div></li>';
		}
		$out .='</ul>';
	} else {
		echo 'No users found.';
	}
	echo $out;
}

function swift_posts_mosaic($p,$title,$size,$class){
	GLOBAL 	$swift_exclude_post_ids;

	if ($p->have_posts()) :
	$out = '<p class="section-title">'.$title.'</p><ul class="mosaic clearfix">';
	while ($p->have_posts()) : $p->the_post();
	$swift_exclude_post_ids[] = get_the_ID();
	$out .= '<li>'.get_the_post_thumbnail(get_the_ID(), $size, array('class' => 'alignleft' ));
	$out .= '<div class="tooltip"><div class="heading"><strong>'.get_the_title().'</strong></div>';
	$out .= get_the_excerpt();
	$out .= '</div>';
	endwhile;
	$out .= '</ul>';
	endif;
	echo $out;
}
/*
 * <li>
<h4 class="post-title"><a href="<?php the_permalink() ?>" title="<?php the_title() ?>"><?php the_title() ?></a></h4>
<?php  the_post_thumbnail( array(60,37), array('class' => 'alignleft np-recent' )); echo substr(get_the_excerpt(),0,160);?>
<div class="clear"></div>
</li>
*/
function swift_np2_comments_mosaic(){
	global $wpdb;
	$comments = $wpdb->get_results("SELECT * FROM $wpdb->comments WHERE comment_approved = '1' ORDER BY comment_date_gmt DESC LIMIT 9");
	$out ='<p class="section-title">Recent comments</p><ul class="mosaic clearfix">';
	if ( $comments ) : foreach ( (array) $comments as $comment) :
	$author=wp_kses($comment->comment_author,'','');
	$content=wp_kses($comment->comment_content,'','');
	$out .= '<li class="clearfix">'.get_avatar($comment,$size = '115');
	$out .= '<div class="tooltip"><div class="heading">'.sprintf( _x( '%1$s on %2$s', 'author ON title', 'swift' ), $author, '<a href="'. get_comment_link($comment->comment_ID) . '"  title="'.$content.'">' . get_the_title($comment->comment_post_ID) . '</a>' ) . '</div>';
	$out .= $comment->comment_content.'<br>';
	$out .= '<span class="meta"><time class="entry-date" datetime="'.esc_attr( get_the_date( 'c' ) ).'" >'.esc_html( get_the_date() ).'</time></span></div></li>';
	endforeach; endif;

	echo $out;

}

function swift_np2_which($option,$mosaic,$count,$size,$class=''){
	GLOBAL $swift_exclude_post_ids;
	switch($option){
		case -6:
			if($mosaic)
				swift_np2_comments_mosaic();
			else
				swift_np2_comments();
			return FALSE;
			break;

		case -5:
			swift_np2_authors_mosaic();
			return FALSE;
			break;

		case -4:
			swift_np2_authors_mosaic();
			return FALSE;
			break;

		case -3:
			$posts = new WP_Query(array('posts_per_page' => $count, 'no_found_rows' => true, 'post_type' => 'post', 'post_status' => 'publish', 'ignore_sticky_posts' => true, 'orderby' => 'comment_count', 'order' => 'DESC'));
			swift_posts_mosaic($posts,__('Popular posts','swift'),$size,$class);
			//return $posts;
			break;

		case -2:
			$posts = new WP_Query(array('posts_per_page' => $count, 'post__not_in'=>$swift_exclude_post_ids, 'post_type' => 'post', 'no_found_rows' => true,'ignore_sticky_posts' => true, 'post_status' => 'publish'));
			swift_posts_mosaic($posts,__('Recent posts','swift'),$size,$class);
			//return $posts;
			break;

		case -1:
			$posts = new WP_Query(array('posts_per_page' => $count,'orderby'=>'rand', 'post__not_in'=>$swift_exclude_post_ids, 'post_type' => 'post', 'no_found_rows' => true,'ignore_sticky_posts' => true, 'post_status' => 'publish'));
			swift_posts_mosaic($posts,__('Random posts','swift'),$size,$class);
			//return $posts;
			break;

		default:
			$args = array('posts_per_page' => $count, 'post__not_in'=>$swift_exclude_post_ids, 'no_found_rows' => true,'ignore_sticky_posts' => true, 'post_status' => 'publish', 'post_type' => 'post');
			$args['category__in'] = $option;
			$title=__('Posts from','swift').'&nbsp;';
			foreach($option as $cat){
				$title .= '<a href="'.get_category_link($cat ).'" title="'.sprintf( __( 'View more posts from %s', 'swift' ), get_cat_name($cat) ).'">'.get_cat_name($cat).'</a>, ';
			}
			$title = rtrim($title,', ');
			$posts = new WP_Query($args);
			swift_posts_mosaic($posts,$title,$size,$class);
			//return $posts;
			break;

	}

}

?>