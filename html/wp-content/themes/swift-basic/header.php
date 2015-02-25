<?php
GLOBAL $swift_options;
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package Swift
 * @subpackage Template
 * @since 6.0
 */
?>
<!DOCTYPE html>
<!--[if IE 6]>
<html id="ie6" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 7]>
<html id="ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html id="ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 6) | !(IE 7) | !(IE 8)  ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
<meta charset="<?php bloginfo('charset'); ?>" />
<title><?php swift_document_title() ?></title>
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="stylesheet" type="text/css" media="all"
	href="<?php echo get_stylesheet_uri(); ?>" />
<meta name="viewport" content="width=device-width">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<?php if(  isset($swift_options['favicon']) && $swift_options['favicon'] != '' ){ ?>
<link rel="shortcut icon" href="<?php echo $swift_options['favicon'];?>" />
<?php }?>
<!--[if lt IE 9]>
<script src="<?php echo get_template_directory_uri(); ?>/js/html5.js" type="text/javascript"></script>
<![endif]-->
<?php
/* We add some JavaScript to pages with the comment form
 * to support sites with threaded comments (when in use).
*/
if ( is_singular() && get_option( 'thread_comments' ) )
	wp_enqueue_script( 'comment-reply' );

/* Always have wp_head() just before the closing </head>
 * tag of your theme, or you will break many plugins, which
* generally use this hook to add elements to <head> such
* as styles, scripts, and meta tags.
*/
wp_head();
?>
</head>
<body <?php body_class(); ?> id="top">
	<?php swift_before_html() ?>
	<div id="wrapper" class="clearfix">
		<!-- This div will be closed in the footer.php file -->
		<?php swift_before_header() ?>
		<div id="header-container">
			<header id="header" class="clearfix">
				<?php swift_header() ?>
			</header>
		</div>
		<?php swift_after_header() ?>

		<div id="main" class="hybrid">
			<!-- Will be closed in footer.php -->
			<?php swift_before_main()?>
			<?php if( !($swift_options['slider_enable'] == TRUE && $swift_options['slider_style'] == 'full-width' && ( is_home() && $paged < 2  ) ) ):?>
			<div id="left" class="clearfix">
				<!-- Will be closed in sidebar.php, in the page templates if we are not using sidebar  -->
				<?php endif;?>