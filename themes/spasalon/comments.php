<?php if ( post_password_required() ) : ?>
<p class="nopassword"><?php _e( 'This post is password protected. Enter the password to view any comments.', 'sis_spa' ); ?>
</p>
<?php return;endif;?>
<?php if ( have_comments() ) : ?>
<div class="comment_mn">
  <fieldset><?php printf( _n( '<p style="color: #f22853; margin-bottom: 30px; margin-top:20px;">One thought on &ldquo;%2$s&rdquo;', '<p style="color: #f22853; margin-top:20px;">%1$s thoughts on &ldquo;%2$s&rdquo;</p>', get_comments_number(), 'sis_spa' ),number_format_i18n( get_comments_number() ),  get_the_title()  );?>
  </fieldset>
  <?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) :  ?>
  <nav id="comment-nav-above">
    <h1 class="assistive-text"><?php _e( 'Comment navigation', 'sis_spa' ); ?></h1>
    <div class="nav-previous"><?php previous_comments_link( __( '&larr; Older Comments', 'sis_spa' ) ); ?></div>
    <div class="nav-next"><?php next_comments_link( __( 'Newer Comments &rarr;', 'sis_spa' ) ); ?></div>
  </nav>
  <?php endif;  ?>
  <?php wp_list_comments( array( 'callback' => 'spa_comment' ) );?>
</div>
<!-- comment_mn -->
<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // are there comments to navigate through ?>
<nav id="comment-nav-below">
  <h1 class="assistive-text"><?php _e( 'Comment navigation', 'sis_spa' ); ?></h1>
  <div class="nav-previous"><?php previous_comments_link( __( '&larr; Older Comments', 'sis_spa' ) ); ?></div>
  <div class="nav-next"><?php next_comments_link( __( 'Newer Comments &rarr;', 'sis_spa' ) ); ?></div>
</nav>
<?php endif;  ?>
<?php elseif ( ! comments_open()  && post_type_supports( get_post_type(), 'comments' ) ) :
  _e('<p id="comment">'.__('comments are closed','sis_sps'),'</p>','sis_spa');?>
<?php endif; ?>
<?php if ('open' == $post->comment_status) : ?>
<?php if ( get_option('comment_registration') && !$user_ID ) : ?>
<p><?php _e('You must be','sis_spa' ); ?><a href="<?php echo get_option('siteurl'); ?>/wp-login.php?redirect_to=<?php echo urlencode(get_permalink()); ?>"><?php _e('logged in','sis_spa');?></a> <?php _e('to post a comment.','sis_spa');?></p>
<?php else : ?>
<?php $fields=array(
  'author' => '<label for="author" class="blog-form-feild">'.__('Name','sis_spa'),'*</label>
               <input type="text" name="author" id="author" value=""   placeholder="' . __('Name','sis_spa') . '" class="span8 cmt_input_bg" tabindex="1" />',   
  'email'  => '<label for="email" class="blog-form-feild">'.__('Mail','sis_spa').__('will not be published','sis_spa'),'</label>
               <input type="text" name="email" id="email" value="" placeholder="' . __('email','sis_spa') .'"  tabindex="2" class="span8 cmt_input_bg" />',
  'url'    => ' <label for="url" class="blog-form-feild">'.__('Website','sis_spa'),'</label>
                <input type="text" name="url" id="url" value="" placeholder="' . __('website','sis_spa') . '"  tabindex="3" class="span8 cmt_input_bg" />'
  );
  
  function my_fields($fields) {
  
  return $fields;
  }
  add_filter('comment_form_default_fields','my_fields');
  
  $defaults = array(
   'fields'               => apply_filters( 'comment_form_default_fields', $fields ),
  'comment_field'        => ' <label for="url" class="blog-form-feild">Comment</label><p class="comment-form-comment"><textarea name="comment" id="comment" rows="3" placeholder="' .__('Comment','sis_spa') . '" class="span8 cmt_input_bg" tabindex="4"></textarea></p>',
  
  'logged_in_as' => '<p class="logged-in-as">' . __( "Logged in as ",'sis_spa' ).'<a href="'. admin_url( 'profile.php' ).'">'.$user_identity.'</a>'. '<a href="'. wp_logout_url( get_permalink() ).'" title="Log out of this account">'.__('Log out?','sis_spa').'</a>' . '</p>',
  'comment_notes_after'  => '<dl class="form-allowed-tags"></dl>',
  'id_form'              => 'commentform',
  'id_submit'            => 'blog-form-post',
  );
  ?>
<?php comment_form($defaults) ;?> 
<?php endif; // If registration required and not logged in ?>
<?php endif;  ?>