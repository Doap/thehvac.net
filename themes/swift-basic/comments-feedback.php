<?php
/**
 * The template for displaying Comments.
 *
 * The area of the page that contains both current comments
 * and the comment form. The actual display of comments is
 * handled by the callback fucntion swift_comment() located
 * in lib/functions/modified-core-functions.php
 *
 * @package Swift
 * @since Swift 6.0
 */
?>
<div id="comments">
	<?php if ( post_password_required() ) : ?>
	<p class="nopassword">
		<?php _e( 'This post is password protected. Enter the password to view any comments.', 'swift' ); ?>
	</p>
</div>
<!-- #comments -->
<?php
/* Stop the rest of comments.php from being processed,
 * but don't kill the script entirely -- we still have
* to fully load the template.
*/
return;
endif;
?>

<?php // You can start editing here -- including this comment! ?>

<?php if ( have_comments() ) : ?>
<h4 id="comments-title">
	<?php
	printf( _n( 'One thought on &ldquo;%2$s&rdquo;', '%1$s thoughts on &ldquo;%2$s&rdquo;', get_comments_number(), 'swift' ),
	number_format_i18n( get_comments_number() ), '<span>' . get_the_title() . '</span>' );
	?>
</h4>

<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // are there comments to navigate through ?>
<div class="page-link">
	<?php paginate_comments_links(  ) ?>
</div>
<div class="clear"></div>

<?php endif; // check for comment navigation ?>

<ol class="commentlist fb">
	<?php
	/* Loop through and list the comments. Tell wp_list_comments()
	 * to use swift_comment() to format the comments.
	* If you want to overload this in a child theme then you can
	* define swift_comment() and that will be used instead.
	* See swift_comment() in swift/lib/functions/modified-core-fucntions.php for more.
	*/
	$args= array( 'avatar_size' => 64,
				  'callback' => 'swift_comment',
				  'per_page' =>100);
				wp_list_comments( $args );
				?>
</ol>

<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // are there comments to navigate through ?>
<div class="page-link">
	<?php paginate_comments_links(  ) ?>
</div>
<div class="clear"></div>
<?php endif; // check for comment navigation ?>

<?php
/* If there are no comments and comments are closed, let's leave a little note, shall we?
 * But we don't want the note on pages or post types that do not support comments.
*/
elseif ( ! comments_open() && ! is_page() && post_type_supports( get_post_type(), 'comments' ) ) :
?>
<?php if(!is_page()):?>
<p class="nocomments">
	<?php _e( 'Comments are closed.', 'swift' ); ?>
</p>
<?php endif;?>
<?php endif; ?>
<?php comment_form( array('comment_notes_after'=>'<div class="form-allowed-tags">' . sprintf( __( 'You may use these <abbr title="HyperText Markup Language">HTML</abbr> tags and attributes: %s' ), ' <code>' . allowed_tags() . '</code>' ) . '</div>')); ?>

</div>
<!-- #comments -->
