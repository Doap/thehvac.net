<?php
$deportes = get_terms('deportes', array(
	'fields' => 'all',
	'orderby' => 'count',
	'hide_empty' => 1
) );
	
$ligas = get_terms('ligas', array(
	'fields' => 'all',
	'orderby' => 'count',
	'hide_empty' => 1
) );
$i=0;
//var_dump($deportes);
//var_dump($ligas);
foreach ($ligas as $liga )
{
	$liga_name = $liga->name;
	$liga_term_id = $liga->term_id;
	echo '<div style="height:20px;clear:both;"></div>';
	echo '<div style="width:300px;height:400px">Liga : ' . $liga_name . ' TERM_ID: ' . $liga_term_id;
	$equipos_in_liga = $wpdb->get_col( "SELECT DISTINCT meta_value FROM $wpdb->postmeta where meta_key = 'equipo' AND post_id IN (SELECT DISTINCT post_id FROM $wpdb->postmeta where meta_key = 'liga' and meta_value = $liga_term_id);" );
	foreach ($equipos_in_liga as $el_equipo)
	{
//		echo PHP_EOL . PHP_EOL . PHP_EOL . 'EQUIPO ' . $el_equipo . '____________________  liga ' . $liga_name . '_______________________________________';
			$last3_posts = $wpdb->get_col( "SELECT DISTINCT post_id FROM $wpdb->postmeta where meta_key IN ('en_casa', 'visitante') and meta_value = $el_equipo ORDER BY ABS(post_id) DESC LIMIT 3;" );
			foreach ($last3_posts as $lastpost)
			{
				$last3[$el_equipo][]=$lastpost;
			}
$last3_vals = implode(',', $last3_posts);
$post_relacionado = $wpdb->get_var("SELECT DISTINCT meta_value FROM $wpdb->postmeta where meta_key = 'post_relacionado' and post_id IN ($last3_vals) order by abs(meta_value) DESC LIMIT 1;");
$post_relacionado_link = ($post_relacionado) ? '<a href="'. get_the_permalink($post_relacionado) . '"><div class="resultados_link">' . get_the_title($post_relacionado) . '</div></a>' : '';
$equipo_info = get_term_by('id', $el_equipo, 'equipos', ARRAY_A);
	echo '<div style="height:20px;clear:both;"></div>';
echo '<div style="width:100%;background-color:#ccc;">' . $equipo_info['name'] . '</div>';
//echo '<div style="clear:both;">' . var_dump($last3) . '</div>';
//var_dump($last3);
$args = array(
	'post_type' => 'marcador',
	'post_status' => 'publish',
	'post__in' => $last3[$el_equipo],
	'posts_per_page' => 3
//	'tag_id' => 24124
//	'post__in'  => get_option( 'sticky_posts' ),
//	'ignore_sticky_posts' => 1
);
//$story_count = 0;
//wp_reset_query();
//echo ' IS FRONT PAGES? = ' . is_front_page();
$marc_query = new WP_Query( $args );

//echo '<div style="clear:both;">' . var_dump($marc_query) . '</div>';
//var_dump($marc_query);
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
if ($home_meta_id)
{
wp_reset_query();
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
	$away_team_sport = get_post_meta( $post->ID, 'deporte', true );
}
}
else
{
	echo 'NO LOGOS FOUND';
//	var_dump($away_logos);
}
$away_logo = $away_team_thumb_id['0'];
//$away_logo_thumb_array = wp_get_attachment_image_src( $away_logo, 'thumbnail' );
//$away_logo_thumb = $away_logo_thumb_array[0];
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
wp_reset_query();
$home_logos = new WP_Query( $args );
if( $home_logos->have_posts() ) 
{
while ( $home_logos->have_posts() )
{
	$home_logos->the_post();
	$home_team_logo_id = $post->ID;
//	$home_team_thumb_id[] = get_post_thumbnail_id($home_team_logo_id);
	$home_team_sport = get_post_meta( $post->ID, 'deporte', true );
}
}
else
{
	echo 'NO LOGOS FOUND';
//	var_dump($home_logos);
}
$home_logo = $home_team_thumb_id['0'];
//$home_logo_thumb_array = wp_get_attachment_image_src( $home_logo, '150,150' );
//$home_logo_thumb = $home_logo_thumb_array[0];
if ( $home_team_sport <> $away_team_sport  || !isset($home_team_sport) || !isset($away_team_sport) )
{
	$deporte_icon = '';
}
else
{
	$deporte_icon = $home_team_sport;
}
//echo 'HELLO';
//echo PHP_EOL . '<div style="top:17px;position:relative;"><img src="http://laprensa13.doap.us/wp-content/themes/noticias/core/icons/' . $deporte_icon . '.png" alt="futbol" width="22" height="22" class="alignleft size-thumbnail wp-image-1146384" /></div>';
//echo PHP_EOL . '<div style="top:21px;left:-9px;position:relative;font-size:1.2em;font-weight:900;color:#fff;">'. $game_status . '</div>';
//echo PHP_EOL . '<div id="scoreboard-strip" style="border:0px;max-width:100%;"></div>';
echo PHP_EOL . '<div style="clear:both;"></div>';
echo PHP_EOL . '<div class="shawn-marcador" style="width:100%;position:relative;float:left;border: 1px solid #ccc;">';
echo PHP_EOL . '<div class="shawn-marcador-inner" style="width:100%;height:30px;position:relative;float:left;">';
echo PHP_EOL . '<div style="text-align:center;line-height:5;width:120px;height:30px;color:#606060;font:Arial;font-size:12px;font-weight:900;position:relative;float:left;">'. $home_meta . '</div>';
//echo '<div>'. $home_logo. '</div>';
//echo PHP_EOL . '<div style="padding-right:4px;padding-left:4px;position:relative;float:left;width:89x;height:80px;"><img src="' . $home_logo_thumb . '" style="width:89px;height:80px;"></div>';
echo PHP_EOL . '<div style="line-height:1.6;'. $home_color . 'color:#fff;font-family:Arial;font-size:12px;font-weight:bold;width:30px;height:30px;text-align:center;vertical-align:middle;position:relative;float:left;">'. $home_score_meta . '</div>';
echo PHP_EOL . '<div style="line-height:1.6;' . $away_color . 'color:#fff;font-family:Arial;font-size:12px;font-weight:bold;width:30px;height:30px;text-align:center;vertical-align:middle;position:relative;float:left;">'. $away_score_meta . '</div>';
//echo '<div>'. $away_logo. '</div>';
//echo PHP_EOL . '<div style="padding-left:4px;padding-right:4px;position:relative;float:left;width:89px;height:80px;"><img src="' . $away_logo_thumb . '" style="width:89px;height:80px;"></div>';
echo PHP_EOL . '<div style="text-align:center;line-height:5;width:120px;height:30px;color:#606060;font:Arial;font-size:12px;font-weight:900;position:relative;float:left">'. $away_meta . '</div>';
echo PHP_EOL . '</div>';
echo PHP_EOL . '<div style="clear:both;"></div>';
//echo PHP_EOL . '<div style="display:table-cell;border-top: 1px solid #ccc;border-collapse:collapse;width:100%;min-height:10px;color:#606060;font:Arial;font-size:12px;font-weight:400;text-align:center;position:relative;float:left">'. $game_title . '</div>';
echo PHP_EOL . '</div>';

}
}
echo $post_relacionado_link;
}
else
{
//echo '<div> NO HAY MARCADORES ' . $marcador_key . '</div>' . var_dump($marc_query);
}
	}
}
echo '</div>';
//wp_reset_query();
?>
