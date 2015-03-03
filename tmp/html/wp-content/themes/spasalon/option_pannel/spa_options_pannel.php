<?php wp_enqueue_script('modal-form',get_template_directory_uri('template_directory').'/option_pannel/js/bootstrap-modal.js'); ?> 
<?php wp_enqueue_script('jquery-ui-accordion'); ?> 
<?php wp_enqueue_style('jquery-ui-css',get_template_directory_uri('template_directory').'/option_pannel/css/jquery-ui.css'); ?>
<?php wp_enqueue_script('jquery-ui-js',get_template_directory_uri('template_directory').'/option_pannel/js/jquery-ui.js'); ?> 

 	 
<div id="wpbody">
  <div id="wpbody-content">
    <!-- header div is start -->
    <div id="busiprof-themepromo" style="width:97%;color:#FFFFFF;margin-right:10px;">
      <div id="company-logo" style="float:right;margin-top:2px; font-size:18px;color:#000000;text-shadow:#fff 0px 1px 0, #000 0 -1px 0;">
        <center><strong>SpaSalon Lite By</strong></center>
        &nbsp;<a href="http://www.webriti.com/" target="_blank"><img src="<?php echo get_template_directory_uri('template_directory').'/option_pannel/images/png.png' ?> " /></a>
      </div>
      <h2 style="margin-bottom:10px;"><?php _e("Upgrade to Spasalon Pro!",'sis_spa') ; ?></h2>
      <div id="pro-connect" style="margin-bottom:5px;padding:5px;">
        <a class="btn btn-large btn-success" href="#myModal"  data-toggle="modal"><strong>Upgrade to Pro</strong></a>&nbsp;&nbsp;
        <a class="btn btn-large btn-info" href="http://wordpress.org/themes/spasalon" target="_blank"><strong>Rate SpaSalon</strong></a>
        <!-- Modal -->
        <div id="myModal" class="modal hide" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="background:transparent;border:0px;">
          <div class="modal-header" style="border:0px;">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true" ><img src="<?php echo get_template_directory_uri('template_directory').'/option_pannel/images/close_256.png' ?> " /></button>
            <h4 id="myModalLabel"></h4>
          </div>
          <div class="modal-body" align="center" style="color:#333333;margin:0px;" align="center">
            <div id="spasalon-pro" style="background:#FFFFFF; border:3px solid #ddd" >
              <div id="title">
                <h2 style="background:#6BB3D1;margin-top:0%;padding-bottom:10px;padding-top:10px;color:#FFFFFF">SpaSalon-Pro</h2>
              </div>
              <table class="table table-hover table-bordered" style="font-size:13px;margin-bottom:0px;" >
                <thead class="alert alert-info">
                  <tr>
                    <th >
                      <h4>&nbsp;</h4>
                    </th>
                    <th style="text-align: center;">
                      <p>Features</p>
                    </th>
                    <th style="text-align: center;">
                      <p style="color:#F22853;">Free</p>
                    </th>
                    <th style="text-align: center;">
                      <p style="color:#F22853;">Premium</p>
                    </th>
                  </tr>
                </thead>
                <tbody>
                  <tr style="height:6px;">
                    <td>&nbsp;</td>
                    <td>
                      <p><b>Intuitive Option Panel</b><span class="icon help" style="float:right">
                        <span class="tooltip"><?php  _e('Customize theme with intutive option panel.','sis_spa');?></span></span>
                      </p>
                    </td>
                    <td style="text-align: center;">
                      <p><img src="<?php echo get_template_directory_uri('template_directory').'/option_pannel/images/icon_check.png' ?> " /></p>
                    </td>
                    <td style="text-align: center;">
                      <p><img src="<?php echo get_template_directory_uri('template_directory').'/option_pannel/images/icon_check.png' ?> " /></p>
                    </td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td>
                      <p><b>Translation Ready</b><span class="icon help" style="float:right">
                        <span class="tooltip"><?php  _e('Translate the theme into your own language.','sis_spa');?></span></span>
                      </p>
                    </td>
                    <td style="text-align: center;">
                      <p><img src="<?php echo get_template_directory_uri('template_directory').'/option_pannel/images/icon_check.png' ?> " /></p>
                    </td>
                    <td style="text-align: center;">
                      <p><img src="<?php echo get_template_directory_uri('template_directory').'/option_pannel/images/icon_check.png' ?> " /></p>
                    </td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td>
                      <p><b>Customizable Home Page</b><span class="icon help" style="float:right">
                        <span class="tooltip"><?php  _e('Customize the Home Page by adding you own Images and Text.','sis_spa');?></span></span>
                      </p>
                    </td>
                    <td style="text-align: center;">
                      <p><img src="<?php echo get_template_directory_uri('template_directory').'/option_pannel/images/icon_check.png' ?> " /></p>
                    </td>
                    <td style="text-align: center;">
                      <p><img src="<?php echo get_template_directory_uri('template_directory').'/option_pannel/images/icon_check.png' ?> " /></p>
                    </td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td>
                      <p><b>Responsive Home Page Slider</b><span class="icon help" style="float:right">
                        <span class="tooltip"><?php  _e('Showcase your most important services with the Home Page Slider.','sis_spa');?></span></span> 
                      </p>
                    </td>
                    <td style="text-align: center;">
                      <p><img src="<?php echo get_template_directory_uri('template_directory').'/option_pannel/images/cross.png' ?> " /></p>
                    </td>
                    <td style="text-align: center;">
                      <p><img src="<?php echo get_template_directory_uri('template_directory').'/option_pannel/images/icon_check.png' ?> " /></p>
                    </td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td>
                      <p><b>Page Templates</b><span class="icon help" style="float:right">
                        <span class="tooltip"><?php  _e('Number of Page Templates which come with the Theme','sis_spa');?></span></span> 
                      </p>
                    </td>
                    <td style="text-align: center;">
                      <p>2</p>
                    </td>
                    <td style="text-align: center;">
                      <p>6</p>
                    </td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td>
                      <p><b>About Us Template</b><span class="icon help" style="float:right">
                        <span class="tooltip"><?php  _e('Showcase the team behind your business with About Us Template.','sis_spa');?></span></span>
                      </p>
                    </td>
                    <td style="text-align: center;">
                      <p><img src="<?php echo get_template_directory_uri('template_directory').'/option_pannel/images/cross.png' ?> " /></p>
                    </td>
                    <td style="text-align: center;">
                      <p><img src="<?php echo get_template_directory_uri('template_directory').'/option_pannel/images/icon_check.png' ?> " /></p>
                    </td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td>
                      <p><b>Services Template</b><span class="icon help" style="float:right">
                        <span class="tooltip"><?php  _e('Showcase different services which your business offers.It is available in single column and two column layout','sis_spa');?></span></span> 
                      </p>
                    </td>
                    <td style="text-align: center;">
                      <p><img src="<?php echo get_template_directory_uri('template_directory').'/option_pannel/images/cross.png' ?> " /></p>
                    </td>
                    <td style="text-align: center;">
                      <p><img src="<?php echo get_template_directory_uri('template_directory').'/option_pannel/images/icon_check.png' ?> " /></p>
                    </td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td>
                      <p><b>Products Temalate</b> <span class="icon help" style="float:right">
                        <span class="tooltip"><?php  _e('Showcase different products which you offer.','sis_spa');?></span></span>
                      </p>
                    </td>
                    <td style="text-align: center;">
                      <p><img src="<?php echo get_template_directory_uri('template_directory').'/option_pannel/images/cross.png' ?> " /></p>
                    </td>
                    <td style="text-align: center;">
                      <p><img src="<?php echo get_template_directory_uri('template_directory').'/option_pannel/images/icon_check.png' ?> " /></p>
                    </td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td>
                      <p><b>Custom Widgets </b><span class="icon help" style="float:right">
                        <span class="tooltip"><?php  _e('Customize the sidebar with the included widgets','sis_spa');?></span></span> 
                      </p>
                    </td>
                    <td style="text-align: center;">
                      <p><img src="<?php echo get_template_directory_uri('template_directory').'/option_pannel/images/cross.png' ?> " /></p>
                    </td>
                    <td style="text-align: center;">
                      <p><img src="<?php echo get_template_directory_uri('template_directory').'/option_pannel/images/icon_check.png' ?> " /></p>
                    </td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td>
                      <p><b>Theme Support </b><span class="icon help" style="float:right">
                        <span class="tooltip"><?php  _e('Get our fast and friendly support.','sis_spa');?></span></span>
                      </p>
                    </td>
                    <td style="text-align: center;">
                      <p>Via Wordpress Forums</p>
                    </td>
                    <td style="text-align: center;">
                      <p>Private Forums with Email Support</p>
                    </td>
                  </tr>
                  <tr class="alert alert-info">
                    <td>&nbsp;</td>
                    <td style="text-align: center;">
                      <p>Get the Premium Version</p>
                    </td>
                    <td style="text-align: center;"><img src="<?php echo get_template_directory_uri('template_directory').'/option_pannel/images/arrow1.png' ?> " /></td>
                    <td style="text-align: center;"><a class="btn  btn-success" href="http://www.webriti.com/index.php/spasalon/" target = "_blank"> <strong>Get the Premium Version</strong></a></td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
        <!-- header div is end -->
      </div>
    </div>
    <div  class="wrap">
      <div class="icon32" id="icon-themes"><br></div>
      <h2 class="nav-tab-wrapper">				
        <a href="#spasalon-option-homepage"  class="nav-tab nav-tab-active" id="spasalon-option-homepage-tab"><?php _e("Home",'sis_spa') ; ?></a>
        <a href="#spasalon-option-general"  class="nav-tab"  id="spasalon-option-general-tab"><?php _e("General",'sis_spa') ; ?></a>
        <a href="#spasalon-option-typography" class="nav-tab" id="spasalon-option-typography-tab"><?php _e("Typography",'sis_spa') ; ?></a>
		<a href="#spasalon-banner" class="nav-tab" id="spasalon-banner-tab"><?php _e("Banner Customization",'sis_spa') ; ?></a>
        <a href="#spasalon-option-footercustmization" class="nav-tab" id="spasalon-option-footercustmization-tab"><?php _e("Footer Custmization",'sis_spa') ; ?></a>
        <a href="#spasalon-help" class="nav-tab" id="spasalon-help-tab"><?php _e("Help & Support",'sis_spa') ; ?></a>
        <a href="#spasalon-subscribe" class="nav-tab" id="spasalon-subscribe-tab"><?php _e("Subscribe a New Letter",'sis_spa') ; ?></a>
		
      </h2>
      <div class="updated" >
        <p><strong></strong></p>
        <p><strong><?php _e("This theme recommends the following plugin: ",'sis_spa') ; ?><a href="http://wordpress.org/plugins/appointment-calendar/" target="_blank"> <em><?php _e("appointment calendar",'sis_spa') ; ?></em></a>.</strong></p>
        <p></p>
      </div>
      <div id="busiprof_optionsframework-metabox" class="metabox-holder">
        <div id="busiprof_optionsframework" class="postbox">
          <!--	<form action="#" method="post"> -->
          <div class="postbox group" style="width:962px;display: active; background:white" id="spasalon-option-homepage"  >
            <h3><?php _e("Home",'sis_spa') ; ?> </h3>
            <br>
            <?php require_once('spa_home.php');?>
          </div>
          <div class="group" style="width:962px;display: none; background:white" id="spasalon-option-general" >
            <h3><?php _e("General Settings",'sis_spa') ; ?></h3>
            <br>
            <?php require_once('spa_general_settings.php'); ?>						
          </div>
          <div class="postbox group" style="width:962px;display: none; background:white" id="spasalon-option-typography" >
            <h3><?php _e("Typography",'sis_spa') ; ?></h3>
            <br>
            <?php require_once('spa_typography.php')?>
          </div>
          <div class="postbox group" style="width:962px;display: none; background:white" id="spasalon-option-footercustmization"  >
            <h3><?php _e("Footer Custmization",'sis_spa') ; ?></h3>
            <br>
            <?php require_once('spa_footer_customization.php')?>
          </div>
          <div class="postbox group" style="width:962px;display: none; background:white" id="spasalon-help"  >
            <h3><?php _e("Help and Support",'sis_spa') ; ?></h3>
            <br>
            <?php require_once('help.php')?>
          </div>
          <div class="postbox group" style="width:962px;display: none; background:white" id="spasalon-subscribe"  >
            <h3><?php _e("Subscribe a New Letter",'sis_spa') ; ?></h3>
            <br>
            <?php require_once('subscribe.php')?>
          </div>
		  <div class="postbox group" style="width:962px;display: none; background:white" id="spasalon-banner"  >
            <h2><?php _e("Settings for configuring the banner header for category,archive,tags and 404 page templates",'sis_spa') ; ?></h2>
            <br>
            <?php require_once('banner.php')?>
          </div>
		  
        </div>
      </div>
      <div id="busiprof_optionsframework-sidebar">
        
      </div>
    </div>
  </div>
</div>