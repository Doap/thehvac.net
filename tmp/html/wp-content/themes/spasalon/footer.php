<?php $current_options=get_option('spa_theme_options'); 
  if($current_options['spa_custom_css']!='')
  { echo "<style type='text/css'>".$current_options['spa_custom_css']."</style>"; }
  
  if(is_home()){ } 
  
  else{?>
<!-- Footer Spacer Div -->
<div class="footer-blank"></div>
<?php }?>
<!-- End of Footer Spacer Div -->
<!-- Footer -->
<div class="row-fluid footer_full">
  <div class="container">
    <div class="row-fluid show-grid">
      <footer>
        <div class="span7">
          <p><?php echo $current_options['footer_tagline'] ; ?>
		  <?php if($current_options['footer_designedby'] != '' && is_home() || is_front_page()) { ?>
		  &nbsp;<a target="_blank" rel="nofollow" href="<?php echo esc_url($current_options['footer_url']);?>">
		  <?php echo $current_options['footer_designedby']; ?></a>
		  <?php } else{ echo $current_options['footer_designedby']; } ?></p>
        </div>
        <div class="span5">
          <ul class="footer_nav_links pull-right">
            <?php  if ( has_nav_menu( 'footer-menu' ) ) :
              wp_nav_menu( array(  'menu'       => 'footer-menu',
              'theme_location' => 'footer-menu',
              'depth'      => -1,
              'container'  => false,
              'menu_class' => '',
              'menu_id'=>'FooterMenu',
              'fallback_cb' => 'wp_page_menu',
              'walker' => new spasalon_nav_walker())
              );
              endif;?>				
          </ul>
        </div>
      </footer>
    </div>
  </div>
</div>
<!-- Close of Footer -->
<?php wp_footer();?>
</body>
</html>