<?php
  // code to change length of blog excerpt
  function spa_get_the_other_excerpt(){
    global $post;
  $excerpt = get_the_content();
  $excerpt = preg_replace(" (\[.*?\])",'',$excerpt);
  $excerpt = strip_shortcodes($excerpt);
  $excerpt = strip_tags($excerpt);
  $original_len = strlen($excerpt);
  
  $excerpt = substr($excerpt, 0, 500);
  
  $excerpt = substr($excerpt, 0, strripos($excerpt, " "));
  
  $excerpt = trim(preg_replace( '/\s+/', ' ', $excerpt));
  
  $len=strlen($excerpt);
  
   
   if($original_len>500)
     $excerpt = $excerpt.'<a class="blog-readmore" href="'. get_permalink($post->ID) . '"> Read More</a>';
  return $excerpt;
  }
  // code to change length of service two column excerpt
  function get_service_two_excerpt(){
    global $post;
  $excerpt = get_the_content();
  $excerpt = preg_replace(" (\[.*?\])",'',$excerpt);
  $excerpt = strip_shortcodes($excerpt);
  $excerpt = strip_tags($excerpt);
  $original_len = strlen($excerpt);
  
  $excerpt = substr($excerpt, 0, 150);
  
  $excerpt = substr($excerpt, 0, strripos($excerpt, " "));
  
  $excerpt = trim(preg_replace( '/\s+/', ' ', $excerpt));
  
  $len=strlen($excerpt);
   if($original_len>150)
     $excerpt = $excerpt.'<a class="blog-readmore" href="'. get_permalink($post->ID) . '"> Read More</a>';
  return $excerpt;
  
  return $excerpt;
  }
  
  // code to change length of about us services section two column excerpt
  function aboutus_services_excerpt(){
    global $post;
  $excerpt = get_the_content();
  $excerpt = preg_replace(" (\[.*?\])",'',$excerpt);
  $excerpt = strip_shortcodes($excerpt);
  $excerpt = strip_tags($excerpt);
  $original_len = strlen($excerpt);
  
  $excerpt = substr($excerpt, 0, 220);
  
  $excerpt = substr($excerpt, 0, strripos($excerpt, " "));
  
  $excerpt = trim(preg_replace( '/\s+/', ' ', $excerpt));
  
  $len=strlen($excerpt);
  
  
  return $excerpt;
  }
  
  
  // code for service index excerpt
  function services_excerpt(){
    global $post;
  $excerpt = get_the_content();
  $excerpt = preg_replace(" (\[.*?\])",'',$excerpt);
  $excerpt = strip_shortcodes($excerpt);
  $excerpt = strip_tags($excerpt);
  $original_len = strlen($excerpt);
  
  $excerpt = substr($excerpt, 0, 169);
  
  $excerpt = substr($excerpt, 0, strripos($excerpt, " "));
  
  $excerpt = trim(preg_replace( '/\s+/', ' ', $excerpt));
  
  $len=strlen($excerpt);
  return $excerpt;
  }
  function spa_new_excerpt_more($more) {
         global $post;
  	return '<a class="blog-readmore " href="'. get_permalink($post->ID) . '"> '._e('Read More','sis_spa').'</a>';
  }
  add_filter('excerpt_more', 'spa_new_excerpt_more');
  //code for set the length of service excerpt
  function spa_new_excerpt_length($length) {
      return 40;
  }
  add_filter('excerpt_length', 'spa_new_excerpt_length');
  ?>