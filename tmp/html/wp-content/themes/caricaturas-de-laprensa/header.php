<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @file      header.php
 * @package   max-magazine
 * @author    Sami Ch.
 * @link 	  http://gazpo.com
 */
?>
<!DOCTYPE html>
<!--[if lt IE 7 ]> <html class="no-js ie6" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 7 ]>    <html class="no-js ie7" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 8 ]>    <html class="no-js ie8" <?php language_attributes(); ?>> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--> <html class="no-js" <?php language_attributes(); ?>> <!--<![endif]-->
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="viewport" content="width=device-width" />
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

<title><?php wp_title('&#124;', true, 'right'); ?><?php bloginfo('name'); ?></title>


<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
<?php 
if ( is_singular() && get_option( 'thread_comments' ) )
		wp_enqueue_script( 'comment-reply' );
		
wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<div id="container" class="hfeed">

<div id="header">	

	<?php
	/**
	* Check if the logo image is set in theme options.
	*/
	?>
	<div class="header-wrap">
		<div class="logo">
			<?php if (max_magazine_get_option( 'logo_url' )) { ?>
				<h1>
					<a href="<?php echo home_url(); ?>" title="<?php bloginfo('name'); ?>">
						<img src="<?php echo max_magazine_get_option( 'logo_url' ); ?>" alt="<?php bloginfo( 'name' ); ?>" />
					</a>
				</h1>	
			<?php } else {?>
				<h1 class="site-title">
					<a href="<?php echo home_url(); ?>" title="<?php bloginfo('name'); ?>">
						<?php bloginfo('name'); ?>
					</a>
				</h1> 
				<h3>
					<?php bloginfo('description'); ?>
				</h3>
			<?php } ?>	
		</div>	<!-- /logo -->
		
		<?php if (max_magazine_get_option( 'ad468' )) {?>
			<div class="ad468">	
				<?php echo max_magazine_get_option( 'ad468' ); ?>	
			</div>
		<?php } ?>
		
	</div><!-- /wrap -->
	
	<div id="nav">	
		<?php wp_nav_menu( array( 'theme_location' => 'primary', 'fallback_cb' => 'max_magazine_menu_fallback',) ); ?>		
	</div>
	
	<div class="clear"></div>
	
</div> <!-- /header -->

<div id="content-container">