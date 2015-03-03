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
 * @copyright      2003 - 2013 ThemeID
 * @license        license.txt
 * @version        Release: 1.1.0
 * @filesource     wp-content/themes/responsive/post-meta.php
 * @link           http://codex.wordpress.org/Templates
 * @since          available since Release 1.0
 */
$autor_meta = get_post_meta( get_the_ID(), 'autor', true );
$intro_meta = get_post_meta( get_the_ID(), 'intro', true );
if ($intro_meta)
{
        $lines = explode("\n", $intro_meta);
        foreach ($lines as $line)
        {
                $intro .= '<li>' . $line . '</li>';
        }
        $intro = '<ul class="intro">' . $intro . '</ul>';
}
else
{
        $intro = '';
}
if ($autor_meta)
{
	$autor = '<p class="autor">Por: ' . $autor_meta . '</p>';	
}
else
{
$autor ='';
}
?>

<?php if( is_single() ): ?>
	<p class="antetitulo"><?php echo get_post_meta( get_the_ID(), 'antetitulo', true ); ?><p>
        <?php echo do_shortcode('<div style="position:relative;top:-10px;">[doap_animate type="fadeIn"][doap_heading style="flat-light" size="20" align="left" margin="0" class="fp-title-bar"]'.ucfirst(get_the_title()).'[/doap_heading][/doap_animate]</div>'); ?>
	<?php echo $intro; ?>
	<?php echo $autor; ?>
<?php else: ?>
	<h4 class="entry-title post-title"><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></h4>
<?php endif; ?>

<div class="post-meta">
	<?php
	responsive_pro_posted_on();
	responsive_pro_posted_by();
	responsive_pro_comments_link();
	?>
</div><!-- end of .post-meta -->
