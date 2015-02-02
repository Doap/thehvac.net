<?php /*

  This file is part of a child theme called Wherebananas.
  Functions in this file will be loaded before the parent theme's functions.
  For more information, please read https://codex.wordpress.org/Child_Themes.

  Add your own functions below this line.
  ========================================== */ 


add_shortcode('iframe', array('iframe_shortcode', 'shortcode'));
class iframe_shortcode {
    function shortcode($atts, $content=null) {
          extract(shortcode_atts(array(
               'url'      => '',
               'scrolling'      => 'no',
               'width'      => '100%',
               'height'      => '500',
               'frameborder'      => '0',
               'marginheight'      => '0',
          ), $atts));
          if (empty($url)) return '<!-- Iframe: You did not enter a valid URL -->';
     return '<iframe src="'.$url.'" title="" width="'.$width.'" height="'.$height.'" scrolling="'.$scrolling.'" frameborder="'.$frameborder.'" marginheight="'.$marginheight.'" allowfullscreen><a href="'.$url.'" target="_blank">'.$url.'</a></iframe>';
    }
}



function get_doap_limit_chars($string, $limit, $dots=NULL) {
 //       $words = str_word_count($string, 2);
//preg_match_all('/[\pL\pN\pPd]+/u', $string, $words);
        $words = mb_str_word_count($string, 2);
//var_dump($words);
        if ($dots && strlen($string) > 0)
        {
                $dots = '...';
        }
        if (strlen($string) > $limit)
        {
                $wc_start = array_keys($words);
//var_dump($wc_start);
                foreach ($wc_start as $wc_pos)
                {
                        $word_end = $wc_pos - 1;
                        if ($word_end <= $limit)
                        {
                                $string_end = $word_end;
                        }
                }
                $string = mb_substr($string,0,$string_end) . $dots;
        }
        return $string;

}


// Ajax View Counter of Tbl top_ten
function view_hits_function($atts , $content=null) {
	global $wpdb;
	$table_name = $wpdb->prefix . "top_ten";
	// echo $table_name;
	$myid = get_the_ID();
	// echo 'the ID ' .$myid;

        return ($wpdb->get_var($wpdb->prepare("SELECT cntaccess FROM $table_name WHERE postnumber = '$myid'")));

        }
add_shortcode("view_hits","view_hits_function");


function doapsearchform( $form ) {

    $form = '<form role="search" method="get" id="searchform" action="' . home_url( '/' ) . '" >
    <div><label class="screen-reader-text" for="s">' . __('Buscar noticias:') . '</label>
    <input type="text" value="' . get_search_query() . '" name="s" id="s" />
    <input type="submit" id="searchsubmit" value="'. esc_attr__('Ir') .'" />
    </div>
    </form>';

    return $form;
}

add_shortcode('doapsearch', 'doapsearchform');


function wpbeginner_display_gravatar() { 
	global $current_user;
	get_currentuserinfo();
	// Get User Email Address
	$getuseremail = $current_user->user_email;
	// Convert email into md5 hash and set image size to 32 px
	$usergravatar = 'http://www.gravatar.com/avatar/' . md5($getuseremail) . '?s=32';
	echo '<img src="' . $usergravatar . '" class="wpb_gravatar" />';
} 
