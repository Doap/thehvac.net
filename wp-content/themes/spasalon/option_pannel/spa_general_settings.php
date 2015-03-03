<?php  $current_options=get_option('spa_theme_options');  if(isset($_POST['spasalon_settings_save_2']))  {		  if($_POST['spasalon_settings_save_2'] == 1)   {  	/*nonce field implement*/  	if ( empty($_POST) || !wp_verify_nonce($_POST['spa_gernalsetting_nonce_customization'],'spa_customization_nonce_gernalsetting') )  	{  	   print 'Sorry, your nonce did not verify.';  	   exit;  	}  	else   	{  		$current_options['upload_image']=sanitize_text_field($_POST['upload_image']);  		$current_options['call_us']=sanitize_text_field($_POST['call_us']);  		$current_options['call_us_text']=sanitize_text_field($_POST['call_us_text']);  		  	    $current_options['width']=sanitize_text_field($_POST['width']);  		$current_options['upload_image_favicon']=sanitize_text_field($_POST['upload_image_favicon']);  		$current_options['spa_custom_css'] = sanitize_text_field($_POST['spa_custom_css']);  	  		update_option('spa_theme_options' ,stripslashes_deep($current_options));  		  	}      }  if($_POST['spasalon_settings_save_2'] == 2)    {  	do_action('spa_restore_data', '2');		   }  }      ?><form method="post" action = ""  id="theme_options_home_2">  <?php wp_nonce_field('spa_customization_nonce_gernalsetting','spa_gernalsetting_nonce_customization'); ?>  <div class="postbox" id="spasalon_footer_custmization">    <div title="Click to toggle" class="handlediv"><br></div>    <h3 class="hndle">      <span>        <?php _e('Settings','sis_spa');?>         <span class="postbox-title-action">    </h3>    <div class="inside">    <p><h4 class="heading"><?php _e('Custom Logo','sis_spa');?></h4>    <input type="text" class="inputwidth" value="<?php if($current_options['upload_image']!='') { echo esc_attr($current_options['upload_image']); } ?>" id="upload_image1" name="upload_image" size="36" />    <input type="button" id="upload_button" value="Custom Logo" class="upload_image_button" class="upload_button" />    <span class="icon help">    <span class="tooltip"><?php  _e('The placeholder image that will be used as a custom logo','sis_spa');?></span></span>    </span>    <?php if($current_options['upload_image']!=''){ ?>    <img  src="<?php echo $current_options['upload_image'];?>" height="60px" width="250px" />    <?php  } ?>				    </p>    <p><h4 class="heading"><?php _e('Header Logo width','sis_spa');?></h4>    <input class="inputwidth" type="text" value="<?php if($current_options['width']!='') { echo esc_attr($current_options['width']); } ?>" id="width" name="width" onkeyup="this.value=this.value.replace(/\D/g,'')"/>    <span class="icon help">    <span class="tooltip"><?php _e('The width of the header logo image.','sis_spa'); ?></span></span>    </span>    </p>    <p><h4 class="heading"><?php _e('Custom Favicon','sis_spa'); ?></h4>    <input type="text" class="inputwidth" value="<?php if($current_options['upload_image_favicon']!='') { echo esc_attr($current_options['upload_image_favicon']); } ?>" name="upload_image_favicon" size="36" class="upload has-file"/>    <input type="button" value="Custom Fevicon" class="upload_image_button" id="upload_button">    <span class="icon help">    <span class="tooltip"><?php _e('The placeholder image that will be used if a featured image isnt specified.','sis_spa')?></span></span>    </span>    </p>    <p><h4 class="heading"><?php _e('Call Us Number','sis_spa'); ?></h4>    <input type="text" class="inputwidth" value="<?php if($current_options['call_us']!='') { echo esc_attr($current_options['call_us']); } ?>" name="call_us"  maxlength="20" id="call_us"/>    <span class="icon help">    <span class="tooltip"><?php _e('Enter call us number.','sis_spa')?></span></span>    </span>    </p>    <p><h4 class="heading"><?php  _e('Call Us Text','sis_spa'); ?></h4>    <input type="text" class="inputwidth" value="<?php if($current_options['call_us_text']!='') { echo esc_attr($current_options['call_us_text']); } ?>" name="call_us_text" size="36" id="call_us_text"/>    <span class="icon help">    <span class="tooltip"><?php  _e('Enter call us Text.','sis_spa')?></span></span>    </span>    </p>		    </div>	  </div>  <div class="postbox" id="Basic_setting_custom_css">    <div title="Click to toggle" class="handlediv"><br></div>    <h3 class="hndle"><span><?php _e('Custom CSS','sis_spa');?><span class="postbox-title-action">    </h3>    <div class="inside">      <p>      <h4 class="heading"><?php _e('Enter your Custom css','sis_spa');?></h4>      <textarea rows="5" cols="75" name="spa_custom_css" id="spa_custom_css"><?php if($current_options['spa_custom_css']!='') { echo esc_attr($current_options['spa_custom_css']); } ?></textarea>      <span class="icon help">      <span class="tooltip"><?php  _e('Enter Custom CSS Code For Example: #service { color:#000;}','sis_spa');?></span>      </span>							      </p>    </div>  </div>  <!---DATA SAVE------>  <div id="busiprof_optionsframework-submit">    <input type="hidden" value="1" id="spasalon_settings_save_2" name="spasalon_settings_save_2" />    <input type="button" class="button-primary"  value= "<?php _e('Save Changes', 'sis_spa');?>" onclick="datasave_home('2')"/>									    <input type="button" class="reset-button button-secondary"  value="<?php _e('Restore Defaults','sis_spa');?>" onclick="reset_data_home('2')" />    <div id="success_message_reset_2" style="display:none;width:300px;padding-left:150px;">      <?php _e('Data reset sucessfully','sis_spa');?>    </div>    <div id="success_message_save_2" style="display:none;width:300px;">      <?php _e('Data save sucessfully','sis_spa');?>    </div>  </div></form>