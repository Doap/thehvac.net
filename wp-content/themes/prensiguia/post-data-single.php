<?php

// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Post Data Template-Part File
 *
 * @file           post-data.php
 * @package        Responsive
 * @author         Emil Uzelac
 * @copyright      2003 - 2014 CyberChimps
 * @license        license.txt
 * @version        Release: 1.1.0
 * @filesource     wp-content/themes/responsive/post-data.php
 * @link           http://codex.wordpress.org/Templates
 * @since          available since Release 1.0
 */
?>

<?php if( !is_page() && !is_search() ) { ?>

	<div class="post-data">
		<?php //responsive_pro_posted_in(); ?>
		<?php //responsive_pro_post_tags(); ?>
<?php
echo '<div id="tagbox" style="width:100%;max-width:100%;padding-left:2px;padding-bottom:6px;padding-top:4px;background-color:#ffffff;position:relative;font-size:1.1em;overflow:hidden;border-color:#606060;border-bottom:2px solid #606060;border-top:2px solid #606060;border-left:0px solid #fff;border-right:0px solid #fff;border-radius:0px;border-right:2px solid #fff;border-left:2px solid #fff;">';

echo get_the_term_list( $post->ID, 'post_tag', 'ETIQUETAS: ', ', ', '' ); ?>
<div style="position:relative;float:left;margin-right:10px;top:-2px;">
<img style="-webkit-user-select: none;height:12px;width:12px;" src="http://laprensa13.doap.us/images/tag.png">
</div>

<?php
echo '</div>';
$rel_posts = do_shortcode( '[manual_related_posts]' );
if ($rel_posts)
{
	//echo '<div style="height:10px;clear:both;"></div><div class="su-heading su-heading-style-modern-1-blue su-heading-align-left fp-title-bar" style="font-size:20px;margin-top:10px;margin-bottom:0px;"><div class="su-heading-inner" style="display:inline;"><div class="title-left">RELACIONADAS</div><div class="line-container"><div class="line"></div></div></div></div>';
	echo '<div style="height:10px;clear:both;"></div><div style="height:36px;background-color:#336699;width:100%;margin-bottom:0px;"><div style="font-family:StagSansBook;font-size:1.4em;font-weight:400;line-height:2.2em;color:#fff;margin-left:20px;;">RELACIONADAS</div></div>';
	echo $rel_posts;
}
//echo '<div style="left:30px;border-bottom:1px solid #606060;width:100%;"> <div style="max-width:30px;z-index:10000;height: 20px;float: left;padding-left:0px;padding-right:5px;left:0px;position:relative;top:0px;" id=destacados-sidebar><div style="font-size:.8em;width:130px;position:relative;float:left;"> </div> '.$storytags.'</div></div>';
?>
	</div><!-- end of .post-data -->

<?php } ?>

<?php edit_post_link( __( 'Editar', 'responsive' ), '<div class="post-edit">', '</div>' ); ?>
