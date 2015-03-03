<?php
  add_action('admin_init','spa_meta_init');
  
  function spa_meta_init()
  {
       foreach (array('post','page') as $type) 
  	{
  		add_meta_box('my_all_meta', 'Description', 'spa_meta_banner', $type, 'normal', 'high');
  	}
  	add_action('save_post','spa_meta_save');
  }
  // code for banner description
  function spa_meta_banner()
  {
   //wp_nonce_field( plugin_basename( __FILE__ ), 'spasalon_noncename' );
  	global $post ;
   
  	$b_description= get_post_meta( get_the_ID(), 'banner_description', true );
  	$h_one= get_post_meta( get_the_ID(), 'heading_one', true );
  	$h_two= get_post_meta( get_the_ID(), 'heading_two', true );?>
<p><label><?php _e('Banner Description','sis_spa');?></label></p>
<p><textarea name="meta_banner_description" id="meta_banner_description" style="width:100%; height:100px;padding: 10px;" placeholder="Enter product banner description"  rows="3" cols="10" ><?php if (!empty($b_description)) echo $b_description; ?></textarea>
</p>
<p><label><?php _e('Banner Heading One','sis_spa');?></label></p>
<p><input name="meta_heading_one" id="meta_heading_one" placeholder="Enter text for product banner heading one" 
  type="text" value="<?php if (!empty($h_one)) echo $h_one; ?>"></input></p>
<p><label><?php _e('Banner Heading Two','sis_spa');?></label></p>
<p><input  name="meta_heading_two" id="meta_heading_two" placeholder="Enter text for product banner heading two" 
  type="text" value="<?php if (!empty($h_two)) echo $h_two;?>"></input></p>
<?php 	
  }
  function spa_meta_save($post_id) 
  {
  	 
     
       if ( ! current_user_can( 'edit_page', $post_id ) ){
          return ;
    } 
  	
  if(isset( $_POST['post_ID'])){
    $post_ID = $_POST['post_ID'];
  
   $banner_description =  sanitize_text_field($_POST['meta_banner_description']) ;
    
  
    $heading_one = sanitize_text_field($_POST['meta_heading_one']) ;
     $heading_two = sanitize_text_field($_POST['meta_heading_two']) ;
  
  } else {
    $post_ID = null;
  
   $banner_description =  null;
  
    $heading_one = null;
     $heading_two = null;
  }
    
      add_post_meta($post_ID, 'banner_description', $banner_description, true) or 
  	update_post_meta($post_ID, 'banner_description', $banner_description);
  	
  	add_post_meta($post_ID, 'heading_one', $heading_one, true) or 
  	update_post_meta($post_ID, 'heading_one', $heading_one);
  	
      add_post_meta($post_ID, 'heading_two', $heading_two, true) or 
  	update_post_meta($post_ID, 'heading_two', $heading_two);
  	
  }?>