<?php
/**
 * Display the contents of the color schemes page
 */
function swift_color_schemes_page(){
	?>
<div class="wrap clearfix">
	<style>
.ui-tabs .ui-tabs-nav,div.wrap {
	background: none
}

div.wrap {
	padding-bottom: 20px
}

.current-color-scheme {
	position: relative;
	width: 100%;
	float: left
}

.current-color-scheme div {
	float: left
}

.current-color-scheme form {
	position: absolute;
	top: 32%;
	left: 27.5%;
}

.current-color-scheme .button {
	-webkit-border-radius: 5px;
	color: #D00;
	font-size: 1.8em !important;
	font-weight: lighter !important;
	padding: 6px 10px;
	opacity: .8;
	-moz-border-radius: 5px;
	border-radius: 5px;
}

.color-schemes {
	padding: 10px;
	border: solid 1px #DDD;
	background: #f6f6f6;
	width: 385px;
	margin: 20px 9px 0;
	position: relative;
	float: left
}

.color-schemes img {
	float: left;
}

.color-schemes .scheme-colors {
	float: right;
	width: 75px
}

.color-schemes form {
	display: none
}

.color-schemes:hover form {
	display: inline-block;
	float: right;
	position: absolute;
	top: 48%;
	left: 32%
}

.color-schemes .button {
	padding: 10px;
	font-weight: bold;
	opacity: .9;
	color: #f00;
	-webkit-border-radius: 5px;
	-moz-border-radius: 5px;
	border-radius: 5px;
}
</style>
	<?php
	swift_admin_header();
	swift_import_color_scheme();
	swift_download_colors();
	swift_list_themes();
	?>
	<div class="clear"></div>

</div>

<?php
}
/**
 * Imports the color scheme
 * Reads the color settings from colors.php and updates theme to database
 */
function swift_import_color_scheme(){
	if( isset($_POST['scheme']) ){
		$dir = get_template_directory().'/colors/'.$_POST['scheme'];
		if( is_dir($dir)){
			include $dir.'/colors.php';
			global $swift_design_options,$swift_colors;
			foreach ($swift_colors as $key => $value) {
				$swift_design_options[$key] = $value;
			}
			$temp_options = get_option('SwiftOptions');
			$temp_options['design_options']	= $swift_design_options;
			update_option('SwiftOptions', $temp_options);
			if ( swift_write_file(TRUE) ) return;

		}
	}
}
function cmp($a, $b) {
    if ($a == $b) {
        return 0;
    }
    return ($a > $b) ? -1 : 1;
}

/**
 * List the color schemes.
 * Scans the color schmes in colors folder of the theme
 * and displays each color scheme.
 */
function swift_list_themes(){
	$colors_dir = get_template_directory().'/colors';
	if( is_dir(get_template_directory().'/colors') ){
		$schemes = scandir($colors_dir);
		foreach ($schemes as $scheme){
			//If not valid folder name, pass.
			if( !preg_match('/[\w_-]+/',$scheme) )
				continue;

			$scheme_dir = $colors_dir.'/'.$scheme.'/';
			if( is_dir($scheme_dir) && @include($scheme_dir.'/colors.php') ){
				include $scheme_dir.'/colors.php';
				$result = array_count_values($swift_colors);
				uasort($result,'cmp');
				$total_count = count($swift_colors) - $result["1"];
				?>
<div class="color-schemes clearfix">
	<img
		src="<?php echo get_template_directory_uri().'/colors/'.$scheme.'/screenshot.png';?>" />
	<div class="scheme-colors">
		<?php
		foreach($result as $color=>$count){
							if($color == '1' || $color == '') continue;
							$height = (1/(count($result)-1)*190).'px';
							echo '<div style="background:#'.$color.';height:'.$height.'"></div>';
						}
						?>
	</div>
	<form action="" method="post">
		<input type="hidden" value="<?php echo $scheme ?>" name="scheme"> <input
			type="submit" class="button" onClick="return confirm_color_import()"
			value="<?php printf( __( 'Use %s', 'swift' ), $scheme); ?>">
	</form>
</div>
<?php
			}
		}
	}else{
		_e( 'Couldn\'t find the color schemes directory', 'swift' );
		return;
	}
}
function download_colors(){
	if( isset($_POST['download']) ){
		GLOBAL $swift_design_options_init;
		GLOBAL $swift_design_options;
		$start	= array_keys($swift_design_options_init, 'color_options_start');
		$end	= array_keys($swift_design_options_init, 'color_options_end');

		$colors = array_slice( $swift_design_options_init, $start[0]+1, $end[0] - $start[0]-1 ) ;

		//print_r($colors);
		//		header("Cache-Control: public");
		//	header("Content-Description: File Transfer");
		header('Content-Type: text/plain');
		header("Content-Disposition: attachment; filename=colors.php");
		//header("Content-Type: application/octet-stream; ");
		//header("Content-Transfer-Encoding: binary");

		GLOBAL $current_user;
		$author = get_currentuserinfo();
		$output  = '<?php';
		$output .= "\n/*\n";
		$output .= "Scheme Name: Rainbow \n";
		$output .= "Scheme URI: http://SwiftThemes.Com \n";
		$output .= "Description: ".__( 'Describe your color scheme here, you could say how you picked the colors', 'swift' )."\n";
		$output .= "Author: {$current_user->user_nicename}\n";
		$output .= "Author URI: {$current_user->user_url}\n";
		$output .= "Version: 0.0.0\n";
		$output .= "Tags:\n\n";
		$output .= "License:\n";
		$output .= "License URI:\n\n";
		$output .= __( 'Add general comments here', 'swift' )."\n";
		$output .= "*/\n\n\n";

		$output .= 'GLOBAL $swift_colors;'."\n";
		$output .= '$swift_colors = array(';
		foreach($colors as $color){
			if(isset($color['id']))
				$output .= "\t'".$color['id']."' =>'".$swift_design_options[$color['id']]."',\n";
		}
		$output = substr($output,0,-2);	//get rid of the ; from the last array element
		$output .=  ");\n";
		$output .= "?>";

		echo $output;
	}
}
function swift_download_colors(){
	GLOBAL $swift_design_options;
	GLOBAL $swift_design_options_init;

	$start	= array_keys($swift_design_options_init, 'color_options_start');
	$end	= array_keys($swift_design_options_init, 'color_options_end');

	$colors = array_slice( $swift_design_options_init, $start[0]+1, $end[0] - $start[0]-1 ) ;

	$scheme = array();
	foreach($colors as $color){
		if( isset($color['id']) && isset($swift_design_options[$color['id']]) && $color['datatype'] =='color' )
			$scheme[] = $swift_design_options[$color['id']];
	}
	$result = array_count_values($scheme);
	uasort($result,'cmp');
	?>
<div class="current-color-scheme">
	<?php
	foreach($result as $color=>$count){
				if($color == '1' || $color == '') continue;
				$width = (1/(count($result))*100).'%';
				echo '<div style="background:#'.$color.';width:'.$width.';height:100px;"></div>';
			}
			?>
	<form action="" method="post">
		<input type="submit" class="button"
			value="<?php _e( 'Download your current color scheme', 'swift' ); ?>"
			name="download">
	</form>
</div>

<?php

}
?>