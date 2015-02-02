<?php 	get_header();
  $current_options=get_option('spa_theme_options');
$call_us=$current_options['call_us'];  
$call_us_text=$current_options['call_us_text'];  
  if(is_category()){
  $bd=$current_options['banner_description_category'];
  $h1=$current_options['banner_title_one_category'];
  $h2=$current_options['banner_title_two_category'];
  }else if(is_archive())
  {
  $bd=$current_options['banner_description_author'];
  $h1=$current_options['banner_title_one_author'];
  $h2=$current_options['banner_title_two_author'];
  }
  else if(is_404())
  {
  $bd=$current_options['banner_description_404'];
  $h1=$current_options['banner_title_one_404'];
  $h2=$current_options['banner_title_two_404'];
  }
  else if(is_tag())
  {
  $bd=$current_options['banner_description_tag'];
  $h1=$current_options['banner_title_one_tag'];
  $h2=$current_options['banner_title_two_tag'];
  }
  else if(is_search())
  {
  $bd=$current_options['banner_description_tag'];
  $h1=$current_options['banner_title_one_tag'];
  $h2=$current_options['banner_title_two_tag']; 
  }
  else{  $bd=get_post_meta( $post->ID, 'banner_description', true );
  $h1=get_post_meta( $post->ID, 'heading_one', true );
  $h2=get_post_meta( $post->ID, 'heading_two', true );
  }
  ?>
<!-- pink strip --> 
<div class="container">
  <div class="pink-container">
    <div class="row-fluid">
      <div class="span3" id="pink_strip">
        <dl class="pink_title">
         <dt><?php if($h1!=''){ echo $h1; } else{ 
		  _e("GET YOURSELF",'sis_spa');} ?>
		  </dt>
          <dt>
            <div class="pink-head"><?php if($h2!='') { echo $h2;} else{ 
              _e("REFRESHED",'sis_spa');} ?></div>
          </dt>
          <dd></dd>
        </dl>
      </div>
      <div class="span6" id="banner_desc">
        <p><?php if($bd!=''){ echo $bd;}  else{ 
          _e(" Banner Description Donec justo odio, lobortis eget congue sed, rutrum sit amet mauris. Curabitur sed lectus nulla. Curabitur sed lectus nulla.lobortis eget congue sed, rutrum sit amet mauris. Curabitur sed lectus nulla rutrum sit amet mauris ",'sis_spa');}?></p>
      </div>
      <div class="spa_tag">
        <span>
          
          <p><?php if($call_us_text){ echo $call_us_text; ?> <?php if($call_us!=''){ echo $call_us;}  else{ echo '1234567890'; } } ?></p>
        </span>
      </div>
    </div>
  </div>
</div>
<!-- End of pink strip -->