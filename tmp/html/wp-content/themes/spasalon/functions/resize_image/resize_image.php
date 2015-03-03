<?php
  //normal post type 
  add_image_size('blog-left-thumb',150,87,false);
  add_image_size('blog-widget-thumb',67,39,false);
  
  //slider post type
  add_image_size('index-slider-thumb',366,155,false);
  
  add_image_size('page-image',1170,800,false);
  
  //code for normal post types
  add_filter( 'intermediate_image_sizes', 'spa_size');
  function spa_size($sizes){
  
  
  
    $type = get_post_type($_REQUEST['post_id']);
  
    foreach($sizes as $key => $value){
        if($type=='post'  && $value != 'blog-left-thumb' && $value != 'blog-widget-thumb'  ){
            unset($sizes[$key]);
        }
  else if($type=='page'  &&  $value != 'page-image'){
            unset($sizes[$key]);
        }
  
  
    }
    return $sizes;
  }
?>