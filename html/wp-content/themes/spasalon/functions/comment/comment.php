<?php
  // code for comment
  if ( ! function_exists( 'spa_comment' ) ) :
  
  function spa_comment( $comment, $args, $depth ) {
  $GLOBALS['comment'] = $comment;
  //get theme data
  global $data;
  
  //translations
  $leave_reply = $data['translation_reply_to_coment'] ? $data['translation_reply_to_coment'] : __('Reply','sis_spa');
  ?>
<li <?php comment_class(); ?> id="li-comment-<?php comment_ID() ?>">
  <div id="comment-<?php comment_ID(); ?>" class="comment-body <?php if ($comment->comment_approved == '0') echo 'pending-comment'; ?> clearfix">
    <div class="comment-details">
      <div class="comment-avatar">
        <?php echo get_avatar($comment, $size = '65'); ?>
      </div>
      <!-- /comment-avatar -->
      <div class="comment-author vcard">
        <div class="mycomment-author">
          <?php printf(('%s'), get_comment_author_link()) ?>
          <span class="comment-date">
          <a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ?>"><?php comment_date(); ?> at <?php comment_time();?></a>
          </span>
          <div class="reply">
            <?php comment_reply_link(array_merge( $args, array('reply_text' => $leave_reply ,'depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
          </div>
        </div>
        <!-- /comment-meta -->
        <div class="comment-content">
          <?php if ( $comment->comment_approved == '0' ) : ?>
          <em class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'sis_spa' ); ?></em>
          <br />
          <?php endif; ?>
          <div class="comment-text">
            <?php comment_text(); ?>
          </div>
          <!-- /comment-text -->
        </div>
        <!-- /comment-content -->
      </div>
      <!-- /comment-details -->
    </div>
    <!-- /comment -->
  </div>
  <?php
    }
    endif; 
?>