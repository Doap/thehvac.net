<?php
  $current_options=get_option('spa_theme_options');
  if(isset($_POST['spasalon_settings_save_7']))
  {		
  if($_POST['spasalon_settings_save_7'] == 1) 
  {
  	/*nonce field implement*/
  	if ( empty($_POST) || !wp_verify_nonce($_POST['spa_banner_nonce_customization'],'spa_customization_nonce_banner') )
  	{
  	   print 'Sorry, your nonce did not verify.';
  	   exit;
  	}
  	else 
  	{
		// save category banner details
  		$current_options['banner_title_one_category']=sanitize_text_field($_POST['banner_title_one_category']);
		$current_options['banner_title_two_category']=sanitize_text_field($_POST['banner_title_two_category']);
  		$current_options['banner_description_category']=sanitize_text_field($_POST['banner_description_category']);
  		
		// save Author banner Details 
		$current_options['banner_title_one_author']=sanitize_text_field($_POST['banner_title_one_author']);
		$current_options['banner_title_two_author']=sanitize_text_field($_POST['banner_title_two_author']);
  		$current_options['banner_description_author']=sanitize_text_field($_POST['banner_description_author']);
  		
		// save 404 banner Details
		$current_options['banner_title_one_404']=sanitize_text_field($_POST['banner_title_one_404']);
		$current_options['banner_title_two_404']=sanitize_text_field($_POST['banner_title_two_404']);
  		$current_options['banner_description_404']=sanitize_text_field($_POST['banner_description_404']);
  		
		// save tag banner details
		$current_options['banner_title_one_tag']=sanitize_text_field($_POST['banner_title_one_tag']);
		$current_options['banner_title_two_tag']=sanitize_text_field($_POST['banner_title_two_tag']);
  		$current_options['banner_description_tag']=sanitize_text_field($_POST['banner_description_tag']);
  		
		// save Search banner details
		$current_options['banner_title_one_search']=sanitize_text_field($_POST['banner_title_one_search']);
		$current_options['banner_title_two_search']=sanitize_text_field($_POST['banner_title_two_search']);
  		$current_options['banner_description_search']=sanitize_text_field($_POST['banner_description_search']);
  		
  		update_option('spa_theme_options' ,stripslashes_deep($current_options));
  		
  	}
     }
  
   if($_POST['spasalon_settings_save_7'] == 2) 
   {
  	do_action('spa_restore_data', 2);		
   }
  }
  
  
  ?>

<form method="post" action = ""  id="theme_options_home_7" style="margin-top:40px;">
  <?php wp_nonce_field('spa_customization_nonce_banner','spa_banner_nonce_customization'); ?>
  <div class="postbox" id="spasalon_banner_custmization">
   <div title="Click to toggle" class="handlediv"><br></div>
   
   
  <div id="accordion">
  <h3><b><?php _e('Banner Configuration For Category Template','sis_spa'); ?></b></h3>
  <div>
    <div class="inside">
    <p><h4 class="heading"><?php _e('Category Banner Tagline One','sis_spa');?></h4>
    <input type="text" class="inputwidth" name="banner_title_one_category" id="banner_title_one_category" value="<?php if($current_options['banner_title_one_category']!='') { echo esc_attr($current_options['banner_title_one_category']); } ?>"/>
    </span>
    </p>
	<p><h4 class="heading"><?php _e('Category Banner Tagline Two','sis_spa');?></h4>
    <input type="text" class="inputwidth" name="banner_title_two_category" id="banner_title_two_category" value="<?php if($current_options['banner_title_two_category']!='') { echo esc_attr($current_options['banner_title_two_category']); } ?>"/>
    </span>
    </p>
    <p><h4 class="heading"><?php _e('Category Banner Description','sis_spa');?></h4>
    <textarea class="inputwidth" style="height:100px;" name="banner_description_category" id="banner_description_category" > <?php if($current_options['banner_description_category']!='') { echo esc_attr($current_options['banner_description_category']); } ?></textarea>
    </span>
    </p>
    </div> 
  </div>
  
  <h3><b><?php _e('Banner Configuration For Author Template','sis_spa'); ?></b></h3>
  <div>
     <div class="inside">
    <p><h4 class="heading"><?php _e('Author Banner Tagline One','sis_spa');?></h4>
    <input type="text" class="inputwidth" name="banner_title_one_author" id="banner_title_one_author" value="<?php if($current_options['banner_title_one_author']!='') { echo esc_attr($current_options['banner_title_one_author']); } ?>"/>
    </span>
    </p>
	<p><h4 class="heading"><?php _e('Author Banner Tagline Two','sis_spa');?></h4>
    <input type="text" class="inputwidth" name="banner_title_two_author" id="banner_title_two_author" value="<?php if($current_options['banner_title_two_author']!='') { echo esc_attr($current_options['banner_title_two_author']); } ?>"/>
    </span>
    </p>
    <p><h4 class="heading"><?php _e('Author Banner Description','sis_spa');?></h4>
    <textarea class="inputwidth" style="height:100px;" name="banner_description_author" id="banner_description_author" > <?php if($current_options['banner_description_author']!='') { echo esc_attr($current_options['banner_description_author']); } ?></textarea>
    </span>
    </p>
   
    </div>
  </div>
 
 <h3><b><?php _e('Banner Configuration For 404 Template','sis_spa'); ?></b></h3>
  <div>
     <div class="inside">
    <p><h4 class="heading"><?php _e('404 Banner Tagline One','sis_spa');?></h4>
    <input type="text" class="inputwidth" name="banner_title_one_404" id="banner_title_one_404" value="<?php if($current_options['banner_title_one_404']!='') { echo esc_attr($current_options['banner_title_one_404']); } ?>"/>
    </span>
    </p>
	<p><h4 class="heading"><?php _e('404 Banner Tagline Two','sis_spa');?></h4>
    <input type="text" class="inputwidth" name="banner_title_two_404" id="banner_title_two_404" value="<?php if($current_options['banner_title_two_404']!='') { echo esc_attr($current_options['banner_title_two_404']); } ?>"/>
    </span>
    </p>
    <p><h4 class="heading"><?php _e('404 Banner Description','sis_spa');?></h4>
    <textarea class="inputwidth" style="height:100px;" name="banner_description_404" id="banner_description_404" > <?php if($current_options['banner_description_404']!='') { echo esc_attr($current_options['banner_description_404']); } ?></textarea>
    </span>
    </p>
    </div>
  </div>
  
  <h3><b><?php _e('Banner Configuration For Tag Template','sis_spa'); ?></b></h3>
  <div>
     <div class="inside">
    <p><h4 class="heading"><?php _e('Tag Banner Tagline One','sis_spa');?></h4>
    <input type="text" class="inputwidth" name="banner_title_one_tag" id="banner_title_one_tag" value="<?php if($current_options['banner_title_one_tag']!='') { echo esc_attr($current_options['banner_title_one_tag']); } ?>"/>
    </span>
    </p>
	<p><h4 class="heading"><?php _e('Tag Banner Tagline Two','sis_spa');?></h4>
    <input type="text" class="inputwidth" name="banner_title_two_tag" id="banner_title_two_tag" value="<?php if($current_options['banner_title_two_tag']!='') { echo esc_attr($current_options['banner_title_two_tag']); } ?>"/>
    </span>
    </p>
    <p><h4 class="heading"><?php _e('Tag Banner Description','sis_spa');?></h4>
    <textarea class="inputwidth" style="height:100px;" name="banner_description_tag" id="banner_description_tag" > <?php if($current_options['banner_description_tag']!='') { echo esc_attr($current_options['banner_description_tag']); } ?></textarea>
    </span>
    </p>
   </div>
  </div>
  
  <h3><b><?php _e('Banner Configuration For Search Template','sis_spa'); ?></b></h3>
  <div>
     <div class="inside">
    <p><h4 class="heading"><?php _e('Search Banner Tagline One','sis_spa');?></h4>
    <input type="text" class="inputwidth" name="banner_title_one_search" id="banner_title_one_search" value="<?php if($current_options['banner_title_one_search']!='') { echo esc_attr($current_options['banner_title_one_search']); } ?>"/>
    </span>
    </p>
	<p><h4 class="heading"><?php _e('Search Banner Tagline Two','sis_spa');?></h4>
    <input type="text" class="inputwidth" name="banner_title_two_search" id="banner_title_two_search" value="<?php if($current_options['banner_title_two_search']!='') { echo esc_attr($current_options['banner_title_two_search']); } ?>"/>
    </span>
    </p>
    <p><h4 class="heading"><?php _e('Search Banner Description','sis_spa');?></h4>
    <textarea class="inputwidth" style="height:100px;" name="banner_description_search" id="banner_description_search" > <?php if($current_options['banner_description_search']!='') { echo esc_attr($current_options['banner_description_search']); } ?></textarea>
    </span>
    </p>
    </div>
  </div>










 </div>
 
  </div>
  <!---DATA SAVE------>
  <div id="busiprof_optionsframework-submit">
    <input type="hidden" value="1" id="spasalon_settings_save_7" name="spasalon_settings_save_7" />
    <input type="button" class="button-primary"  value= "<?php _e('Save Changes', 'sis_spa');?>" onclick="datasave_home('7')"/>									
    <input type="button" class="reset-button button-secondary"  value="<?php _e('Restore Defaults','sis_spa');?>" onclick="reset_data_home('7')" />
    <div id="success_message_reset_7" style="display:none;width:300px;">
      <?php _e('Data reset sucessfully','sis_spa');?>
    </div>
    <div id="success_message_save_7" style="display:none;width:300px;">
      <?php _e('Data save sucessfully','sis_spa');?>
    </div>
  </div>
</form>