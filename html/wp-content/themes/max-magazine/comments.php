<?php
/**
 * The template for displaying Comments.
 *
 * The area of the page that contains both current comments
 * and the comment form. The actual display of comments is
 * handled by a callback to max_magazine_comments() which is
 * located in the functions.php file.
 *
 * @file      comments.php
 * @package   max-magazine
 * @author    Sami Ch.
 * @link 	  http://gazpo.com
 */
?>
	<div id="comments">
	<?php if ( post_password_required() ) : ?>
		<p class="nopassword"><?php _e( 'This post is password protected. Enter the password to view any comments.', 'max-magazine' ); ?></p>
	</div><!-- #comments -->
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
		<h2 id="comments-title">
			<?php
				printf( _n( 'One thought on &ldquo;%2$s&rdquo;', '%1$s thoughts on &ldquo;%2$s&rdquo;', get_comments_number(), 'max-magazine' ),
					number_format_i18n( get_comments_number() ), '<span>' . get_the_title() . '</span>' );
			?>
		</h2>

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // are there comments to navigate through ?>
		<div id="comment-nav-above">
			<h1 class="assistive-text"><?php _e( 'Comment navigation', 'max-magazine' ); ?></h1>
			<div class="nav-previous"><?php previous_comments_link( __( '&larr; Older Comments', 'max-magazine' ) ); ?></div>
			<div class="nav-next"><?php next_comments_link( __( 'Newer Comments &rarr;', 'max-magazine' ) ); ?></div>
		</div>
		<?php endif; // check for comment navigation ?>

		<ol class="commentlist">
			<?php
				/* Loop through and list the comments. Tell wp_list_comments()
				 * to use max_magazine_comments() to format the comments.
				 * If you want to overload this in a child theme then you can
				 * define max_magazine_comments() and that will be used instead.
				 * See max_magazine_comments() in functions.php for more.
				 */
				wp_list_comments( array( 'callback' => 'max_magazine_comments' ) );
			?>
		</ol>

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // are there comments to navigate through ?>
		<div id="comment-nav-below">
			<h1 class="assistive-text"><?php _e( 'Comment navigation', 'max-magazine' ); ?></h1>
			<div class="nav-previous"><?php previous_comments_link( __( '&larr; Older Comments', 'max-magazine' ) ); ?></div>
			<div class="nav-next"><?php next_comments_link( __( 'Newer Comments &rarr;', 'max-magazine' ) ); ?></div>
		</div>
		<?php endif; // check for comment navigation ?>

	<?php
		/* If there are no comments and comments are closed, let's leave a little note, shall we?
		 * But we don't want the note on pages or post types that do not support comments.
		 */
		elseif ( ! comments_open() && ! is_page() && post_type_supports( get_post_type(), 'comments' ) ) :
	?>
		
	<?php endif; ?> <!-- /have_comments -->

	<?php if (comments_open()) : ?>

    <?php
    $fields = array(
        'author' => '<p class="comment-form-author">' . '<input id="author" name="author" type="text" value="' . esc_attr($commenter['comment_author']) . '" size="30" />'.'<label for="author">' . __('Name','max-magazine') . '</label> ' . ( $req ? '<span class="required">*</span>' : '' ) . '</p>',
		
        'email' => '<p class="comment-form-email">'.'<input id="email" name="email" type="text" value="' . esc_attr($commenter['comment_author_email']) . '" size="30" />'.'<label for="email">' . __('E-mail','max-magazine') . '</label> ' . ( $req ? '<span class="required">*</span>' : '' ) .'</p>',
		
        'url' => '<p class="comment-form-url">'.'<input id="url" name="url" type="text" value="' . esc_attr($commenter['comment_author_url']) . '" size="30" />'.'<label for="url">' . __('Website','max-magazine') . '</label>' . '</p>',
    );

    $defaults = array('fields' => apply_filters('comment_form_default_fields', $fields));

    comment_form($defaults);
    ?>

    <?php endif; ?> <!-- /comments_open -->
	
</div><!-- /comments -->
