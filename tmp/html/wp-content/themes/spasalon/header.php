<!DOCTYPE html>
<html <?php language_attributes(); ?>>
  <head>
    <!--[if IE]>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    ``
    <![endif]-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta charset="<?php bloginfo('charset'); ?>" />
    <title><?php wp_title( '|', true, 'right' ); ?></title>
    <?php if(get_option('spa_theme_options')!='')			
      {
      	$spa_current_options=get_option('spa_theme_options');
      }
      ?>
    <?php if($spa_current_options['upload_image_favicon']!=''){?>
    <link rel="shortcut icon" href="<?php  echo $spa_current_options['upload_image_favicon']; ?>" />
    <?php }?>
    <link rel="profile" href="http://gmpg.org/xfn/11" />
    <link rel="stylesheet" href="<?php echo get_stylesheet_uri(); ?>" type="text/css" media="screen" />
    <?php wp_head(); ?>
  </head>
  <body <?php body_class(); ?>>
    <!-- Header -->
    <div class="container">
      <div class="navbar navbar-inverse" id="menu_position">
        <div class="navbar-inner">
          <div class="container">
            <a data-target=".navbar-inverse-collapse" data-toggle="collapse" class="btn btn-navbar">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            </a>
            <?php 	if($spa_current_options['upload_image']!='') { ?>
            <a href="<?php echo home_url( '/' ); ?>" class="brand">
            <img src="<?php echo $spa_current_options['upload_image']; ?>"  height="<?php echo $spa_current_options['height'].'px' ?>" width="<?php echo $spa_current_options['width'].'px'; ?>" alt="Spa Logo" class="logo-img" />
            </a>
            <?php  } else { ?>
            <a href="<?php echo home_url( '/' ); ?>" class="brand">
            <img src="<?php echo get_template_directory_uri();?>/images/spa_logo.png" alt="spasalon" /></a>
            <?php } ?>
            <div class="nav-collapse navbar-inverse-collapse collapse">
              <?php
                wp_nav_menu( array(  
                   'theme_location' => 'header-menu',
                  'container'  => 'nav-collapse collapse navbar-inverse-collapse',
                   'menu_class' => 'nav',
                   'fallback_cb' => 'spa_fallback_page_menu',
                   'walker' => new spasalon_nav_walker()
                	)
                	);
                ?> 
            </div>
            <!-- /.nav-collapse -->
          </div>
        </div>
        <!-- /navbar-inner -->
      </div>
    </div>