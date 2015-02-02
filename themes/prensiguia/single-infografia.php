<?php

// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Single Posts Template
 *
 *
 * @file           single.php
 * @package        Responsive
 * @author         Emil Uzelac
 * @copyright      2003 - 2013 ThemeID
 * @license        license.txt
 * @version        Release: 1.0
 * @filesource     wp-content/themes/responsive/single.php
 * @link           http://codex.wordpress.org/Theme_Development#Single_Post_.28single.php.29
 * @since          available since Release 1.0
 */
$img = get_post_thumbnail_id($post->ID);
$image_attributes = wp_get_attachment_image_src( $img, 'full' );
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php the_title(); ?> - Infograf&iacute;a &bull; LA PRENSA. El Diario de los Nicaragüenses. Nicaragua</title>
</head>
<body>
<div align="center">
<img src="<?php echo $image_attributes[0]; ?>" width="<?php echo $image_attributes[1]; ?>" height="<?php echo $image_attributes[2]; ?>">  
</div>
</body>
</html>
<?php
?>

