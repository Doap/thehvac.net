<?php $spa_current_options=get_option('spa_theme_options'); ?>
<style>
  .navbar .nav > li > a
  {	
  font-size:<?php echo $spa_current_options['spa_menu_typography']['navigation_px'].'px'; ?>; 
  font-family:<?php echo $spa_current_options['spa_menu_typography']['font_family_navigation']; ?>;
  font-style:<?php echo $spa_current_options['spa_menu_typography']['font_style_navigation']; ?>;
  color:<?php echo $spa_current_options['spa_menu_typography']['color_navigation']; ?>;
  }
  .blog-heading {
  color:<?php echo $spa_current_options['spa_post_title_typography']['color_post_title']; ?>;
  font-size:<?php echo $spa_current_options['spa_post_title_typography']['post_title_px'].'px'; ?>;
  font-family:<?php echo $spa_current_options['spa_post_title_typography']['font_family_post_title']; ?>;
  font-style:<?php echo $spa_current_options['spa_post_title_typography']['font_style_post_title']; ?>;
  }
  .blog_content p
  {
  color:<?php echo $spa_current_options['spa_post_entry_typography']['color_post_entry']; ?>;
  font-size:<?php echo $spa_current_options['spa_post_entry_typography']['post_entry_px'].'px'; ?>;
  font-family:<?php echo $spa_current_options['spa_post_entry_typography']['font_family_post_entry']; ?>;
  font-style:<?php echo $spa_current_options['spa_post_entry_typography']['font_style_post_entry']; ?>;
  }
  .spa-widget-title {
  color:<?php echo $spa_current_options['spa_sidebar_widget_titles']['color_sidebar_widget_titles']; ?>;
  font-size:<?php echo $spa_current_options['spa_sidebar_widget_titles']['sidebar_widget_titles_px'].'px'; ?>;
  font-family:<?php echo $spa_current_options['spa_sidebar_widget_titles']['font_family_sidebar_widget_titles']; ?>;
  font-style:<?php echo $spa_current_options['spa_sidebar_widget_titles']['font_style_sidebar_widget_titles']; ?>;
  }
  .blog-icons li a {
  color:<?php echo $spa_current_options['spa_post_meta_typography']['color_post_meta']; ?>;
  font-size:<?php echo $spa_current_options['spa_post_meta_typography']['post_meta_px'].'px'; ?>;
  font-family:<?php echo $spa_current_options['spa_post_meta_typography']['font_family_post_meta']; ?>;
  font-style:<?php echo $spa_current_options['spa_post_meta_typography']['font_style_post_meta']; ?>;
  }
  .blog-icons li{
  font-size:<?php echo $spa_current_options['spa_post_meta_typography']['post_meta_px'].'px'; ?>;
  color:<?php echo $spa_current_options['spa_post_meta_typography']['color_post_meta']; ?>;
  font-family:<?php echo $spa_current_options['spa_post_meta_typography']['font_family_post_meta']; ?>;
  }
  .jumbotron h1{
  font-size:<?php echo $spa_current_options['spa_home_Title']['home_title_px'].'px !important'; ?>;
  font-family:<?php echo $spa_current_options['spa_home_Title']['home_font_family']. '!important'; ?>;
  font-style:<?php echo $spa_current_options['spa_home_Title']['home_font_style'].'!important'; ?>;
  }
  .jumbotron h1.home_product_tagline{
  font-size:<?php echo $spa_current_options['spa_product_Title']['product_title_px'].'px !important'; ?>;
  font-family:<?php echo $spa_current_options['spa_product_Title']['product_font_family']. '!important'; ?>;
  font-style:<?php echo $spa_current_options['spa_product_Title']['product_font_style'].'!important'; ?>;
  }
</style>