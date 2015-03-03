<?php
/*
 * Created on Jan 12, 2013
*
* To change the template for this generated file go to
* Window - Preferences - PHPeclipse - PHP - Code Templates
*/

function swift_set_widths() {
	global $swift_design_options;
	$wrapper = $swift_design_options['wrapper_width']/100;
	echo '<div id="width-selector" class="btn btn-danger btn-large clearfix">';
	echo '<small style="font-size:12px;float:left"><em>Note: Widths are correct upto one pixel</em></small><h4 class="alignright btn btn-warning">Set content and sidebar widths</h4>' .
			'<div class="clear"></div>';
	echo '<ul class="alignleft"><li id="content-width">Content width is <strong >' . $swift_design_options['content_width'] . '% {'.(int)($swift_design_options['content_width']*$wrapper).'px}</strong></li>';
	echo '<li id="sb-width">Sidebar  width is <strong >' . (100 - $swift_design_options['content_width']) . '% {'.(int)((100 - $swift_design_options['content_width'])*$wrapper).'px}</strong></li>';
	echo '<li id="sb1-width">Sidebar 1 width is <strong >' . $swift_design_options['sb1_width'] . '% {'.(int)($swift_design_options['sb1_width']*$wrapper).'px}</strong></li>';
	echo '<li id="sb2-width">Sidebar 2 width is <strong >' . (100 - $swift_design_options['content_width'] - $swift_design_options['sb1_width']) . '% {'.(int)((100 - $swift_design_options['content_width'] - $swift_design_options['sb1_width'])*$wrapper).'px}</strong></li></ul>';
	echo '<div class="clear"></div><div id="slider-range"></div>';
	echo '</div>';
	?>
<div id="width-demo">
	<div id="content"></div>
	<div id="sidebar">
		<div id="sb1"></div>
		<div id="sb2"></div>
	</div>
</div>
<?php
}

function swift_gfonts() {
	global $swift_design_options;

	?>
<div id="selected_fonts" class="clearfix">
	<?php
	if(isset($swift_design_options['swift_gfonts']) && is_array($swift_design_options['swift_gfonts'])):
	foreach($swift_design_options['swift_gfonts'] as $font){
			$san_font = preg_replace('(\s)','_',$font[0]);
			$li = '<li id="li_'.$san_font.'" style="font-family:'.$font[0].'" class="btn"><strong>'.$font[0].'</strong><br><span>';
			if($font[1] && $font[2]){
				$li .= 'For blogname and tagline only';
			}else{
				if($font[1])
					$li .= 'For blogname only';
				if($font[2])
					$li .= 'For tagline only';
			}
			if(!$font[1] && !$font[2]){
				$li .= 'Load entire font';
			}
			$li .= '</span><span data="'.$san_font.'"class="remove"></li>';
			$input = '<input type="hidden" id="input_'.$san_font.'" name="swift_design_options[swift_gfonts][]" value="'.$font[0].','.$font[1].','.$font[2].'">';

			echo $li;
			echo $input;
		}
		endif;
		?>
</div>

<div id="font_demo">
	<input type="text" value="SwiftThemes" id="sample_text"><label
		for="sample_text">Preview text</label>
</div>
<div id="font_preview">
	<?php global $current_user;get_currentuserinfo();?>
	<h2>
		<?php bloginfo( 'name' ); ?>
	</h2>
	<p>
		Howdy
		<?php echo $current_user->display_name;?>
		,<br> Thank you for purchasing and using Swift on this blog. If you
		need <strong>any help with WordPress</strong>, feel free to drop me a
		mail at <strong>satish@swiftthemes.com</strong>.<br> <img
			src="<?php echo THEME_URI?>/lib/admin/images/idea.png">Do you know,
		we can optimize your blog to get <strong>90+ page speed score for only
			50$.</strong>
	</p>
</div>
<div id="font_optimization">
	<button type="button" id="addfont" style="margin-top: -4px"
		class="btn btn-primary btn-small alignright">Click Me!</button>
	<input type="checkbox" name="blogname" value="true" id="blogname"><label
		for="blogname">For blog name only</label> <input type="checkbox"
		name="blogname" value="true" id="tagline"><label for="tagline">For
		blog tag only</label>
</div>
<?php
$i=0;
if(!($json = get_transient('swift_fonts_json'))){
		$json = wp_remote_retrieve_body(wp_remote_get('https://www.googleapis.com/webfonts/v1/webfonts?key=AIzaSyDVKxwBB7u0r7p1jNtveJ-GA2EHvbGB6h4'));
		set_transient('swift_fonts_json',$json,86400);
	}
	//var_dump($json);
	$fonts = json_decode($json, true);
	$fonts = $fonts['items'];
	$count = count($fonts);
	$font_list='[';
	//var_dump($fonts);
	$i = 0;
	$step =6;
	echo '<ul id="infinite_scroll">';
	for($i;$i<$step;$i++){
		echo '<li style="font-family:'.$fonts[$i]['family'] .'" data="'.$fonts[$i]['family'].'">' . $fonts[$i]['family'] . '</li>';
		$font_list .='"'.$fonts[$i]['family'] .'",';
	}
	GLOBAL $swift_design_options;
	$selected_fonts = $swift_design_options['swift_gfonts'];
	if(isset($swift_design_options['swift_gfonts']) && is_array($swift_design_options['swift_gfonts'])):
	foreach ($swift_design_options['swift_gfonts'] as $font){
			$font_list .='"'.$font[0] .'",';
		}
		endif;
		$font_list .=']';
		echo '</ul>';
		?>
<script
	src="http://ajax.googleapis.com/ajax/libs/webfont/1/webfont.js"
	defer="true"></script>

<script type="text/javascript">
var font_list_start
font_list_start =<?php echo $font_list ?>
</script>
<style type="text/css">
#infinite_scroll {
	height: 240px;
	overflow-y: scroll;
	margin: 0 -20px 20px -20px;
	border: 1px solid #ccc;
}

#infinite_scroll a {
	font-weight: bold;
}

#infinite_scroll p {
	margin-bottom: 20px;
	width: 90%
}

#infinite_scroll li {
	padding: 15px 10px;
	border-bottom: dotted 1px #CCC;
	font-size: 24px
}

.loading {
	text-align: right;
	margin-top: -100px
}
</style>
<?php
}

?>
