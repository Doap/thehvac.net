<?php
$args = array(
	'post_type' => 'marcador',
	'post_status' => 'publish',
//	'meta_key' => 'activo_en_deportes',
//	'meta_value' => 1,
	'meta_query' => array(
		array(
		'key' => $marcador_key,
	        'value' => 1,
	        'compare' => '='
                     )
        ),
	'posts_per_page' => 1
//	'tag_id' => 24124
//	'post__in'  => get_option( 'sticky_posts' ),
//	'ignore_sticky_posts' => 1
);
//$story_count = 0;
//wp_reset_query();
//echo ' IS FRONT PAGES? = ' . is_front_page();
$marc_query = new WP_Query( $args );
if( $marc_query->have_posts() ) 
{
while ( $marc_query->have_posts() )
{
	$marc_query->the_post();
//if (has_post_thumbnail()) echo 'HAS POST THUMBNAIL!';
	if ( $marcador_key == 'activo_en_portada' && has_post_thumbnail() )
	{
		$marcador_image_array = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'full' );
		$marcador_image = $marcador_image_array[0];
		$marcador_img = 'background:url(\'' . $marcador_image . '\');width:280px;height:153px;';
//		$macador_background = 'background:url("' . $marcador_image . '");';
//		echo '<a href="'. $marcador_image . '">IMAGE</a>';
	}
	else
	{
		$marcador_img = 'background-color:#ccc;width:278px;height:153px;';
	}
$home_meta_id = get_post_meta( $post->ID, 'en_casa', true );
$away_meta_id = get_post_meta( $post->ID, 'visitante', true );
$related_post = get_post_meta( $post->ID, 'post_relacionado', true );
$home_meta_array = get_term($home_meta_id, 'equipos', 'ARRAY_A');
$away_meta_array = get_term($away_meta_id, 'equipos', 'ARRAY_A');
$home_meta = $home_meta_array['name'];
$away_meta = $away_meta_array['name'];
//$home_logo = $home_team_thumb_id['0'];
$home_score_meta = get_post_meta( $post->ID, 'puntos_en_casa', true );
$away_score_meta = get_post_meta( $post->ID, 'puntos_visitante', true );
$game_title = ucfirst(get_the_title());
$game_status = get_doap_excerpt('10');
if ($home_score_meta > $away_score_meta)
{
	$home_color='background-color:#333;';
	$away_color='background-color:#606060;';
}
elseif ($home_score_meta < $away_score_meta)
{
	$home_color='background-color:#606060;';
	$away_color='background-color:#333;';
}
else
{
	$home_color='background-color:#333;';
	$away_color='background-color:#333;';
}
}
}
else
{
//echo '<div> NO HAY MARCADORES ' . $marcador_key . '</div>' . var_dump($marc_query);
}
if ($home_meta_id)
{
//wp_reset_query();
$args = array(
	'posts_per_page' => 1,
	'post_type' => 'logo',
//	'tag_id' => $away_meta_array['term_id']
//	'equipos' => $away_meta_array['term_id']
	'tax_query' => array(
        array(
            'taxonomy' => 'equipos',
            'field' => 'id',
            'terms' => $away_meta_array['term_id']
        ),
    )
);
$away_logos = new WP_Query( $args );
if( $away_logos->have_posts() ) 
{
while ( $away_logos->have_posts() )
{
	$away_logos->the_post();
	$away_team_logo_id = $post->ID;
	$away_team_thumb_id[] = get_post_thumbnail_id($away_team_logo_id);
	$away_team_sport = get_post_meta( $post->ID, 'deporte', true );
}
}
else
{
	echo 'NO LOGOS FOUND';
//	var_dump($away_logos);
}
$away_logo = $away_team_thumb_id['0'];
$away_logo_thumb_array = wp_get_attachment_image_src( $away_logo, 'thumbnail' );
$away_logo_thumb = $away_logo_thumb_array[0];
$args = array(
	'posts_per_page' => 1,
	'post_type' => 'logo',
//	'tag_id' => $home_meta_array['term_id']
	'tax_query' => array(
        array(
            'taxonomy' => 'equipos',
            'field' => 'id',
            'terms' => $home_meta_array['term_id']
        ),
    )
);
//wp_reset_query();
$home_logos = new WP_Query( $args );
if( $home_logos->have_posts() ) 
{
while ( $home_logos->have_posts() )
{
	$home_logos->the_post();
	$home_team_logo_id = $post->ID;
	$home_team_thumb_id[] = get_post_thumbnail_id($home_team_logo_id);
	$home_team_sport = get_post_meta( $post->ID, 'deporte', true );
}
}
else
{
	echo 'NO LOGOS FOUND';
//	var_dump($home_logos);
}
$home_logo = $home_team_thumb_id['0'];
$home_logo_thumb_array = wp_get_attachment_image_src( $home_logo, '150,150' );
$home_logo_thumb = $home_logo_thumb_array[0];
if ( $home_team_sport <> $away_team_sport  || !isset($home_team_sport) || !isset($away_team_sport) )
{
	$deporte_icon = '';
}
else
{
	$deporte_icon = $home_team_sport;
}
if ( !$laprensa_home && $marcador_key == 'activo_en_deportes')
{
//echo 'HELLO';
echo '<div style="top:17px;position:relative;"><img src="http://laprensa13.doap.us/wp-content/themes/noticias/core/icons/' . $deporte_icon . '.png" alt="futbol" width="22" height="22" class="alignleft size-thumbnail wp-image-1146384" /></div>';
echo '<div style="top:21px;left:-9px;position:relative;font-size:1.2em;font-weight:900;color:#fff;">'. $game_status . '</div>';
echo '<div id="scoreboard-strip" style="border:0px;max-width:100%;"></div>';
echo '<div style="clear:both;"></div>';
echo '<div class="shawn-marcador" style="width:100%;position:relative;float:left;border: 1px solid #ccc;">';
echo '<div class="shawn-marcador-inner" style="width:100%;height:80px;position:relative;float:left;">';
echo '<div style="text-align:center;line-height:5;width:130px;height:80px;color:#606060;font:Arial;font-size:22;font-weight:900;position:relative;float:left;">'. $home_meta . '</div>';
//echo '<div>'. $home_logo. '</div>';
echo '<div style="padding-right:4px;padding-left:4px;position:relative;float:left;width:89x;height:80px;"><img src="' . $home_logo_thumb . '" style="width:89px;height:80px;"></div>';
echo '<div style="line-height:1.6;'. $home_color . 'color:#fff;font-family:Arial;font-size:3.5em;font-weight:bold;width:100px;height:80px;text-align:center;vertical-align:middle;position:relative;float:left;">'. $home_score_meta . '</div>';
echo '<div style="line-height:1.6;' . $away_color . 'color:#fff;font-family:Arial;font-size:3.5em;font-weight:bold;width:100px;height:80px;text-align:center;vertical-align:middle;position:relative;float:left;">'. $away_score_meta . '</div>';
//echo '<div>'. $away_logo. '</div>';
echo '<div style="padding-left:4px;padding-right:4px;position:relative;float:left;width:89px;height:80px;"><img src="' . $away_logo_thumb . '" style="width:89px;height:80px;"></div>';
echo '<div style="text-align:center;line-height:5;width:130px;height:80px;color:#606060;font:Arial;font-size:22;font-weight:900;position:relative;float:left">'. $away_meta . '</div>';
echo '</div>';
echo '<div style="clear:both;"></div>';
echo '<div style="display:table-cell;border-top: 1px solid #ccc;border-collapse:collapse;width:100%;min-height:10px;color:#606060;font:Arial;font-size:22;font-weight:400;text-align:center;position:relative;float:left">'. $game_title . '</div>';
echo '</div>';

}
}
if ( is_front_page() && $home_meta_id && $marcador_key = 'activo_en_portada')
{
//	$max_width = ($even == $left_300_story) ? 'width:340px;' : 'width:213px;';
//		echo '<div style="position:absolute;display:block;bottom:0px;left:0px;height:30px;width:100%;max-width:100%;color:#fff;background:rgba(0, 0, 0, 0.5);border-radius:0;opacity:1;font-size:11pt;"><div><div style="position:absolute;width:60px;margin:0px 5px 5px 0px;padding:5px;color:#fff;"> ' . $posted_time . '</div>';
//	$theexcerpt = ($even == $left_300_story ) ? get_doap_excerpt(7, 1) : get_doap_excerpt(50,1);
	$font_size = ( 1 == 1 ) ? 'font-size:13pt;' : 'font-size:14px;';
	$title_height = ( 1 == 1 ) ? 'height:30px;line-height:1.5;' : 'height:20px;line-height:1;';
	$bottom_height = ( 1 == 1 ) ? 'height:40px;line-height:1.5;' : 'height:20px;line-height:1;';
	$font_color= ( 1 == 1 ) ? 'color:#fff;' : 'color:#fff;';
//	$margin_right = ($even == 4) ? 'margin-right:0px;' : 'margin-right:7px;';
//	$padding_left = ($even == $left_300_story ) ? 'padding-left:8px;' : 'padding-left:0px;';
	$background = ( 1 == 1) ? 'background:rgba(0, 0, 0, 0.5);' : 'background:rgba(3, 3, 3, 0.75);';
//	$excerpt_align= ($even == $left_300_story ) ? 'text-align:left;' : 'text-align:justify;';
//	$post_url = get_permalink($marcador_post);
	//$top_text = '<div style="z-index:10;position:absolute;' . $font_color . $background . 'border-radius:0;opacity:1;font-family:Arial;' . $font_size . 'text-align:center;padding:2px 5px 2px 5px;' . $title_height . '">' . $game_status. '</div>';
	//$top_text = '<div style="z-index:10;width:100%;height:30px;' . $font_color . $background . 'border-radius:0;opacity:1;font-family:Arial;' . $font_size . 'text-align:center;' . $title_height . '">' . $game_status. '</div>';
	$top_text = '<div style="z-index:10;width:100%;height:30px;background-color:#333;' . $font_color . 'border-radius:0;opacity:1;font-family:Arial;' . $font_size . 'text-align:center;' . $title_height . '">' . $game_status. '</div>';
//	$bottom_text = ($even == $left_300_story ) ? $theexcerpt : $title;
//	echo '<a href="' . $post_url . '">';
	echo '<div style="width:280px;height:281px;position:relative;float:left;border: 1px solid #ccc;margin-right:8px;">';
	echo '<div><img src="http://laprensa13.doap.us/wp-content/uploads/sites/2/2014/06/laprensa-280x34-1.png"></div>';
	echo $top_text . PHP_EOL;
	echo '<div class="marcador-portada" style="' . $marcador_img . '">';
//	echo '<div style="clear:both;"></div>';
	//echo '<div style="padding-right:4px;padding-left:4px;position:relative;float:left;width:89x;height:80px;"><img src="' . $home_logo_thumb . '" style="width:89px;height:80px;"></div>';
	echo '<div style="position:relative;float:left;width:50%;margin-top:20px;margin-bottom:10px;height:80px;"><div style="width:89px;margin:0px auto 0px auto;"><img src="' . $home_logo_thumb . '" style="width:89px;height:80px;"></div></div>';
	echo '<div style="position:relative;float:right;width:50%;margin-top:20px;margin-bottom:10px;height:80px;"><div style="width:89px;margin:0px auto 0px auto;"><img src="' . $away_logo_thumb . '" style="margin-left:auto;margin-right:auto;width:89px;height:80px;"></div></div>';
	//echo '<div style="padding-left:4px;padding-right:4px;position:relative;float:right;width:89px;height:80px;"><img src="' . $away_logo_thumb . '" style="width:89px;height:80px;"></div>';
	echo '<div style="width:100%;height:30px;">';
	echo '<div style="line-height:1.6;color:#fff;font-family:Arial;font-size:1em;font-weight:bold;width:50%;text-align:center;vertical-align:middle;position:relative;float:left;">'. $home_meta . '</div>';
	echo '<div style="line-height:1.6;color:#fff;font-family:Arial;font-size:1em;font-weight:bold;width:50%;text-align:center;vertical-align:middle;position:relative;float:right;">'. $away_meta . '</div>';
	echo '</div>';
	echo '</div>';
//	echo '<div style="clear:both;"></div>';
	echo '<div style="width:100%;height:30px;background-color:#333;">';
	echo '<div style="line-height:1.6;color:#fff;font-family:Arial;font-size:1.2em;width:50%;text-align:center;vertical-align:middle;position:relative;float:left;">'. $home_score_meta . '</div>';
	echo '<div style="line-height:1.6;color:#fff;font-family:Arial;font-size:1.2em;width:50%;text-align:center;vertical-align:middle;position:relative;float:right;">'. $away_score_meta . '</div>';
	echo '</div>';
//	echo '<div style="clear:both;"></div>';
//	echo '<div style="' . $max_width . 'position:relative;margin-top:0px;margin-bottom:0px;border: 1px solid #ccc;">' . PHP_EOL;
//	echo '<div style="margin: 0px;position:absolute;display:block;bottom:0px;left:0px;height:35px;' . $max_width . $background . 'color:#fff;border-radius:0;opacity:1;' . $font_size . 'font-family:Arial;text-align:left;">';
	echo '<div><img src="http://laprensa13.doap.us/wp-content/uploads/sites/2/2014/06/laprensa-280x34-1.png"></div>';
	echo '</div>';
//	echo '<div class="mas-en-titles"><p><a href="' . $post_url . '">'. $title . '</a></p></div>' . PHP_EOL;
	$post_relacionado = get_post($related_post);
	if ($post_relacionado)
	{
		//echo 'HAY POST RELACIONADO';
		echo '<div id="story-no-clear" style="margin-right:4px;">';
		include(STYLESHEETPATH . '/templates/marcador-post.php');
		echo '</div>';
	}
	else
	{
		echo 'NO HAY POST RELACIONADO';
	}
}
if ( is_front_page() && $home_meta_id && $marcador_key = 'futbol_total_home_slider')
{
	$slide = array(
        	'image' => $attach_url,
        	'link'  => get_permalink( $related_post ),
        	'attach_id'  => $thumb,
        );

 $slides[] = $slide;
$fb_slider = Su_Shortcodes::futbol_slider(,,$slides);
echo $fb_slider;
}
//wp_reset_query();
wp_reset_postdata();
?>
