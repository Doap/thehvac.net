<?php

// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Post Meta-Data Template-Part File
 *
 * @file           post-meta.php
 * @package        Responsive
 * @author         Emil Uzelac
 * @copyright      2003 - 2014 CyberChimps
 * @license        license.txt
 * @version        Release: 1.1.0
 * @filesource     wp-content/themes/responsive/post-meta.php
 * @link           http://codex.wordpress.org/Templates
 * @since          available since Release 1.0
 */
?>
<?php if( is_single() ): ?>
	<?php //responsive_pro_featured_image(); ?>
	<h2 class="entry-title post-title"><?php the_title(); ?></h2>
<?php else: ?>
	<?php //responsive_pro_featured_image(); ?>
	<hr><h3 class="entry-title post-title"><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></h3>
<?php endif; ?>

<div class="post-meta">
	<?php
	responsive_pro_posted_on();
	responsive_pro_posted_by();
	responsive_pro_comments_link();
	?>
</div><!-- end of .post-meta -->
