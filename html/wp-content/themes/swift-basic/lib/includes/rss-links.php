<?php GLOBAL $swift_options;?>
<ul id="rss-links">
	<li><a
		href="<?php if ( $swift_options['feedburnerid'] <> "" ) { echo "http://feeds.feedburner.com/".$swift_options['feedburnerid']; } else { echo get_bloginfo_rss('rss2_url'); } ?>"
		class="posts-feed" title="<?php _e( 'Posts feed', 'swift' )?>"><?php _e( 'Posts', 'swift' ); ?>
	</a></li>
	<li><a href="<?php bloginfo('comments_rss2_url'); ?>"
		class="comments-feed" title="<?php _e( 'Comments feed', 'swift' )?>"><?php _e( 'Comments', 'swift' ); ?>
	</a></li>
	<?php if ($swift_options['feedburnerid']) { ?>
	<li><a
		href="http://feedburner.google.com/fb/a/mailverify?uri=<?php echo $swift_options['feedburnerid']; ?>"
		class="email-feed"
		title="<?php _e( 'Subscribe via eMail', 'swift' )?>" target="_blank"><?php _e( 'Email', 'swift' ); ?>
	</a></li>
	<?php } ?>
</ul>
