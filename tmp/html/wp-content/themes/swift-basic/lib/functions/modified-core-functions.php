<?php
/*
 * This file contains slightly modified version of the core functions
*/

if ( 1 || !function_exists( 'get_avatar' ) ) :
/**
 * Retrieve the avatar for a user who provided a user ID or email address.
*
* Added data-gravatr-hash to the img tag
* @todo include rating
*
* @since 2.5
* @param int|string|object $id_or_email A user ID,  email address, or comment object
* @param int $size Size of the avatar image
* @param string $default URL to a default image to use if no avatar is available
* @param string $alt Alternate text to use in image tag. Defaults to blank
* @return string <img> tag for the user's avatar
*/
function swift_get_avatar( $id_or_email, $size = '96', $default = '', $alt = false ) {
	if ( ! get_option('show_avatars') )
		return false;

	if ( false === $alt)
		$safe_alt = '';
	else
		$safe_alt = esc_attr( $alt );

	if ( !is_numeric($size) )
		$size = '96';

	$email = '';
	if ( is_numeric($id_or_email) ) {
		$id = (int) $id_or_email;
		$user = get_userdata($id);
		if ( $user )
			$email = $user->user_email;
	} elseif ( is_object($id_or_email) ) {
		// No avatar for pingbacks or trackbacks
		$allowed_comment_types = apply_filters( 'get_avatar_comment_types', array( 'comment' ) );
		if ( ! empty( $id_or_email->comment_type ) && ! in_array( $id_or_email->comment_type, (array) $allowed_comment_types ) )
			return false;

		if ( !empty($id_or_email->user_id) ) {
			$id = (int) $id_or_email->user_id;
			$user = get_userdata($id);
			if ( $user)
				$email = $user->user_email;
		} elseif ( !empty($id_or_email->comment_author_email) ) {
			$email = $id_or_email->comment_author_email;
		}
	} else {
		$email = $id_or_email;
	}

	if ( empty($default) ) {
		$avatar_default = get_option('avatar_default');
		if ( empty($avatar_default) )
			$default = 'mystery';
		else
			$default = $avatar_default;
	}

	if ( !empty($email) )
		$email_hash = md5( strtolower( $email ) );

	if ( is_ssl() ) {
		$host = 'https://secure.gravatar.com';
	} else {
		if ( !empty($email) )
			$host = sprintf( "http://%d.gravatar.com", ( hexdec( $email_hash[0] ) % 2 ) );
		else
			$host = 'http://0.gravatar.com';
	}

	if ( 'mystery' == $default )
		$default = "$host/avatar/ad516503a11cd5ca435acc9bb6523536?s={$size}"; // ad516503a11cd5ca435acc9bb6523536 == md5('unknown@gravatar.com')
	elseif ( 'blank' == $default )
	$default = includes_url('images/blank.gif');
	elseif ( !empty($email) && 'gravatar_default' == $default )
	$default = '';
	elseif ( 'gravatar_default' == $default )
	$default = "$host/avatar/s={$size}";
	elseif ( empty($email) )
	$default = "$host/avatar/?d=$default&amp;s={$size}";
	elseif ( strpos($default, 'http://') === 0 )
	$default = add_query_arg( 's', $size, $default );


	if ( !empty($email) ) {
		//$out = "$host/avatar/";
		$out  = $email_hash;
		$out .= '?s='.$size;
		$out .= '&amp;d=' . urlencode( $default );

		$rating = get_option('avatar_rating');
		if ( !empty( $rating ) )
			$out .= "&amp;r={$rating}";

		$avatar = "<img alt='{$safe_alt}' src='{$default}' class='avatar avatar-{$size} photo' height='{$size}' width='{$size}' data-gravatar-hash='{$out}' />";
	} else {
		$avatar = "<img alt='{$safe_alt}' src='{$default}' class='avatar avatar-{$size} photo avatar-default' height='{$size}' width='{$size}' />";
	}

	return apply_filters('get_avatar', $avatar, $id_or_email, $size, $default, $alt);
}
endif;

/**
 *
 * Callback function for wp_list_comments, used in comments.php
 * Copied the original start_el fucntion from wp-includes/comments-template.php and
 * Changed the order of comments meta and added a class to the div containing avatar.
 * @param unknown_type $comment
 * @param unknown_type $args
 * @param unknown_type $depth
 */
function swift_comment($comment, $args, $depth) {
	$depth++;
	GLOBAL $post;
	$GLOBALS['comment_depth'] = $depth;
	$GLOBALS['comment'] = $comment;
	extract($args, EXTR_SKIP);

	if ( 'div' == $args['style'] ) {
		$tag = 'div';
		$add_below = 'comment';
	} else {
		$tag = 'li';
		$add_below = 'div-comment';
	}

	if ( $comment->user_id > 0 && $user = get_userdata($comment->user_id) ) {
		// For comment authors who are the author of the post
		if ( $post = get_post($post->ID) ) {
			if ( $comment->user_id === $post->post_author )
				$avatar_class = 'bypostauthor';
			$avatar_container_class = 'postauthor-avatar';
		}
	}
	else
		$avatar_container_class = '';

	?>
<<?php echo $tag ?> <?php comment_class(empty( $args['has_children'] ) ?
'' : 'parent') ?> id="comment-<?php comment_ID() ?>">
<?php if ( 'div' != $args['style'] ) : ?>
<div id="div-comment-<?php comment_ID() ?>" class="comment-body">
	<?php endif; ?>
	<div class="comment-author vcard <?php echo $avatar_container_class?>">
		<?php  if ($args['avatar_size'] != 0) echo swift_get_avatar( $comment, $args['avatar_size'] ); ?>
		<?php printf(__('<cite class="fn">%s </cite> <span class="says">says:</span>'), get_comment_author_link()) ?>

		<div class="comment-meta commentmetadata">
			<a
				href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ?>">
				<?php
				/* translators: 1: date, 2: time */
				printf( __('%1$s at %2$s'), get_comment_date(),  get_comment_time()) ?>
			</a>
			<?php edit_comment_link(__('(Edit)'),'&nbsp;&nbsp;','' );
			?>
		</div>

	</div>
	<?php if ($comment->comment_approved == '0') : ?>
	<em class="comment-awaiting-moderation"><?php _e('Your comment is awaiting moderation.') ?>
	</em> <br />
	<?php endif; ?>


	<div class="comment-content">
		<?php comment_text() ?>
	</div>

	<div class="reply">
		<?php comment_reply_link(array_merge( $args, array('add_below' => $add_below, 'depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
	</div>
	<div class="clear"></div>
	<?php if ( 'div' != $args['style'] ) : ?>
</div>
<?php endif; ?>
<?php
}
?>
