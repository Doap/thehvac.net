<?php
/**
 * This file generates the stylesheet whenever the theme options are updated.
 */


function swift_generate_stylesheet(){
	GLOBAL $wp_filesystem;
	GLOBAL $swift_font_stack;
	GLOBAL $swift_options;
	GLOBAL $swift_design_options;
	$temp = get_option('SwiftOptions');
	$d_o = $temp['design_options'];
	$css = '';
	$wrapper = $d_o['wrapper_width'];

	if(isset($d_o['content_width']) && $d_o['content_width']){
		$content = (int)($wrapper * $d_o['content_width']/100);
	}

	if(isset($d_o['cn_ws']) && $d_o['cn_ws']!=0){
		$columns = $d_o['cn_ws'] ;
	}else{
		$columns = 3;
	}

	if( $d_o['blog_or_mag'] == 'magazine-full' ){
		$mag_wrapper_width = $wrapper;
	}else{
		$mag_wrapper_width = $content;
	}
	/* As different browsers interpret fractions differently, we make sure that magboxes width
	 * is always a integer.
	*
	* $temp_content - 20px padding - padding of mag boxes
	*/

	$rogue_pixels = ( $mag_wrapper_width - 20 - 20*( $columns - 1) ) % $columns;

	if ( $rogue_pixels != 0 ) {

		// For full width magazing layout we change the wrapper width.
		// Content width for the other magazne layout.

		if( $d_o['blog_or_mag'] == 'magazine-full' ){
			$mag_wrapper_width = $wrapper = $wrapper + ( $columns - $rogue_pixels );
		} else {
			$mag_wrapper_width = $content = $content + ( $columns - $rogue_pixels );
		}
	}

	// Finally calculate the width of thumbnail and mag box

	$mag1 = ( $mag_wrapper_width - $columns * 22 ) / $columns;

	// Corrected content width is adjusted to sb2
	if(isset($d_o['sb1_width']) && $d_o['sb1_width']){
		$sb1 = (int)($wrapper * $d_o['sb1_width']/100);
		$sb2 = $wrapper - $content - $sb1;
		$sidebar = $sb1+$sb2;
	}

	// Add the width of magazine box to the options table, so that we can use it in
	// the_post_thumbnail()

	$dimensions = get_option('swift_dimensions');

	if($d_o['enable_fixed_height_mag'])
		$dimensions['mag1'] = array( $mag1-20, (int)(($mag1-20)/1.62) );
	else
		$dimensions['mag1'] = array( $mag1-20, NULL );


	if( $d_o['blog_or_mag'] == 'magazine-full' ){
		$temp_content = $wrapper;
	} else {
		$temp_content = $content;
	}

	if($d_o['layout'] == 'fluid'){
		$css .= "#wrapper{width:98%}\n";
		$css .= ".hybrid,#content.full-width{width:100%}\n";
		$css .= "#content.full-width img{max-width:96%;height:auto}\n";
		$content = 960;
	}elseif( $d_o['layout'] == 'hybrid'){
		$css .= "#wrapper{width:100%}\n";
		$css .= ".hybrid,#content.full-width{width:{$wrapper}px; margin:auto}\n";
		$css .= "#content.full-width img{max-width:".($wrapper-42)."px;height:auto}\n";

	}else{
		$css .= "#wrapper,#content.full-width,.hybrid{width:{$wrapper}px}\n";
		$css .= "#content.full-width img{max-width:".($wrapper-42)."px;height:auto}\n";
	}

	if( $d_o['sb_position'] == 'centered' ){
		$css .= '	#left{float:right}
				#sb1 .div-content{margin-top:20px}
				#sb2 .div-content{margin-top:20px}';
	}elseif( $d_o['sb_position'] == 'left' ){
		$css .="#content{float:right}\n";
	}

	if($d_o['layout'] == 'fluid' && $d_o['sb_position'] == 'centered'){
		$css .='#left{width:84.3%}
				#content{width:73.5%}
				#sb1{width:26.5%}
				#sb2{width:15.7%}
				#content .div-content{padding:0 10px}
				#sb1 .div-content{padding:0 10px!important;margin-top:20px}
				#sb2 .div-content{padding:0 10px!important;margin-top:20px}
				';
	}

	if(isset($d_o['content_slider_height']) && $d_o['content_slider_height'] != '' )
		$dimensions['content_width_slider'] = array($content-38, $d_o['content_slider_height'] );//20+2*8+2*1
	else
		$dimensions['content_width_slider'] = array($content-38, ( int ) ( ( $content-38 ) / 1.62 ) );//20+2*8+2*1

	if( $d_o['blog_or_mag'] == 'magazine-full' && $d_o['layout'] != 'fluid'){
		$css .= 'body.blog.mag-full #content{width:'.($temp_content).'px}';
	}

	if( $d_o['blog_or_mag_archives'] == 'magazine-full' && $d_o['layout'] != 'fluid'){
		$css .= 'body.archive #content{width:'.($temp_content).'px}';
	}


	if(isset($d_o['full_slider_height']) && $d_o['full_slider_height'] != '' )
		$dimensions['full_width_slider'] = array($wrapper-38, $d_o['full_slider_height'] );//20+2*8+2*1
	else
		$dimensions['full_width_slider'] = array($wrapper-38, (int)(($wrapper-38)/2) );

	if($d_o['layout'] != 'fixed'){
		$css .= '.is-sticky{width:100%}';
	}
	if($d_o['layout'] != 'fluid'){

		$css .= "#content{width:{$content}px}\n";
		$css .= "#sidebar-container,#about-us,#sticky{width:{$sidebar}px}\n";
		$css .= "#sb1{width:{$sb1}px}\n";
		$css .= '#sb2{width:'.$sb2.'px}';
		$css .= '.mag1{width:'.$mag1.'px}';
		$css .= '.mag1 img.thumb{width:'.($mag1).'px;height:'.(int)($mag1/1.62).'px}';

		$dimensions['content'] 	= $content - 10;
		$dimensions['ws_nonsticky'] = $dimensions['wsb'] = $dimensions['wst'] = $sidebar - 20;
		$dimensions['ns1'] 		= $sb1 - 20;
		$dimensions['ns2'] 		= $sb2 - 20;
		$dimensions['footer-1']  = $dimensions['footer-2']  = $dimensions['footer-3']  = $dimensions['footer-4']  = (int)($wrapper/4 - 20);
		$dimensions['np2-sb'] = ($wrapper - 20)/6 -10;
		$dimensions['page_temp_l'] = $dimensions['page_temp_r'] = (int)($wrapper*.25 -20);

		$dimensions['np2_slider'] = array( (int)((($wrapper -20)/6*5 -10)/5*3-10-18), (int)((($wrapper -20)/6*5 -10)/5*2-10-18 ));

		$temp = ($wrapper*.8 -20)*3/5 - 10 - 18;

		$dimensions['np_slider'] 		= array( (int)$temp, (int)($temp/1.62) );

		update_option( 'swift_dimensions', $dimensions );
		$css .= 'body.bbPress #content,body.buddyPress #content{width:'.(int)($wrapper*(.7)).'px}';
		$css .= 'body.bbPress #sidebar-container,body.buddyPress #sidebar-container{width:'.($wrapper - (int)($wrapper*.7)).'px}';

		$css .= "#full-width-slider .flexslider{width:{$dimensions['full_width_slider'][0]}px!important;height:{$dimensions['full_width_slider'][1]}px}";
		$css .= "#content-width-slider .flexslider{width:".($dimensions['content_width_slider'][0])."px!important;height:{$dimensions['content_width_slider'][1]}px}";
	}else{
		if($d_o['blog_or_mag'] == 'magazine-full')
			$css .= 'body.mag-full #content, body.mag-full #content{width:100%}';

		//		$css .= 'article.mag1{width:'.((100- 2*$columns) / $columns).'%;padding:0;overflow:hidden}';
		$css .= 'article.temp.mag1{margin-right:1%;margin-left:1%}';
		$css .= '.mag1 img{width:100%;height:auto}';
		$css .=	'.temp.mag1.omega{margin-right:0!important}';
	}

	$css .= '.temp.mag1 .entry-summary{height:'.$d_o['mag_content_height'].'px;overflow:hidden}';

	if( isset($swift_options['logo_position']) && $swift_options['logo_position'] == 'center'){
		if(isset($swift_options['logo']) && $swift_options['logo'] != ''){
			$size = getimagesize($swift_options['logo']);
			$css .= 'img#logo{margin:auto;display:block;width:'.$size[0].'px;height:'.$size[1].'px}';
		}
		$css .= '#branding hgroup{text-align:center;width:100%}';
	}elseif($swift_options['logo_position'] == 'left'){
		$css .= 'img#logo{float:left;}';
		$css .= '#header-ad{float:right}';
	}else{
		$css .= 'img#logo{float:right;}';
		$css .= '#header-ad{float:left;}';
	}



	/* nagative margin will overlap with isdebars in centered and left sidebars layout
	 * This is a fix for it.
	*/
	if( $d_o['sb_position'] != 'right' ){
		$css .= 'li.comment .avatar{padding:5px;float:left;margin:0 10px 0 0;}';
	}

	/*
	 * Adding the navigation CSS
	*/

	if( $d_o['nav_style'] == 'bordered' ){
		$filename = THEME_DIR .'/css/bordered-nav.css';
	}else{
		$filename = THEME_DIR .'/css/solid-nav.css';
	}
	$css .= $wp_filesystem->get_contents( $filename ) ;

	if( isset($d_o['disable_form_styling']) && !$d_o['disable_form_styling'] )
		$css .= $wp_filesystem->get_contents( THEME_DIR.'/css/form-styling.css' )."\n" ;

	if( isset($d_o['disable_table_styling']) && !$d_o['disable_table_styling'] )
		$css .= $wp_filesystem->get_contents( THEME_DIR.'/css/table-styling.css' )."\n" ;

	/*
	 * Adding shortcodes CSS
	*/
	if(!$d_o['disable_shortcode_css']){
		$filename = THEME_DIR .'/css/shortcodes.css';
		//$css .= $wp_filesystem->get_contents( $filename ) ;
	}
	if(!$d_o['disable_infobox_icons']){
		$filename = THEME_DIR .'/css/infobox-icons.css';
		//$css .= $wp_filesystem->get_contents( $filename ) ;
	}
	if(!$d_o['disable_feedback_template']){
		$filename = THEME_DIR .'/css/feedback-page-template.css';
		//$css .= $wp_filesystem->get_contents( $filename ) ;
	}
	if(!$d_o['disable_feedback_mosaic_template']){
		$filename = THEME_DIR .'/css/feedback-mosaic-page-template.css';
		//$css .= $wp_filesystem->get_contents( $filename ) ;
	}

	if( isset( $d_o['enable_custom_colors'] ) && $d_o['enable_custom_colors'] ):

	if(isset($d_o['default_colors']) && $d_o['default_colors']):
	$css .= "/* Layout and default colors */ \n";
	$css .= "body{background:#{$d_o['body_bg']};color:#{$d_o['body']};}";
	$css .= "body a{color:#{$d_o['body_a']};}\n";
	$css .= "body a:hover{color:#{$d_o['body_a_h']};}\n";
	//$css .= "body a:visited{color:#{$d_o['body_a_v']};}\n";
	$css .= "#wrapper{background:#{$d_o['wrapper_bg']};}\n";
	$css .= "#main{background:#{$d_o['main_bg']};}\n";
	$css .= "#sidebar-container,#sticky{background:#{$d_o['sb_bg']};}\n";
	$css .= "#footer-container{background:#{$d_o['fo_bg']};}\n";
	$css .= "#copyright-container{background:#{$d_o['copy_bg']};}\n";
	$css .= "#above-header-ad-container{background:#{$d_o['above_header_ad_bg']};}\n";
	$css .= "#nav-ad-container{background:#{$d_o['nav_ad_bg']};}\n";
	$css .= "#footer-ad-container{background:#{$d_o['fo_ad_bg']};}\n";
	endif;

	if(isset($d_o['header_colors']) && $d_o['header_colors']):
	$css .= "/* Header and nav menu colors */\n";
	$css .= "#header-container{background:#{$d_o['header_bg']};}\n";
	$css .= "#site-title a{color:#{$d_o['blog_name']};}\n";
	$css .= "#site-description {color:#{$d_o['blog_tagline']};}\n";
	endif;

	/* Bordered nav styling */
	if($d_o['nav_style'] == 'bordered'):

	if(isset($d_o['b_nav_above_logo']) && $d_o['b_nav_above_logo']):

	$css .= "/*above logo*/\n";
	$css .= "#above-logo-container{background:#{$d_o['nav_a_bg']};}\n";
	$css .= "#above-logo-container{border-bottom:solid 5px #{$d_o['nav_a_thick_border']};}\n";
	$css .= "#above-logo-container .nav li a{color:#{$d_o['nav_a_menu_a']};background-color:#{$d_o['nav_a_menu_a_bg']};border-color:#{$d_o['nav_a_menu_a_bg']}}\n";
	$css .= "#above-logo-container .nav li a:hover,
	#above-logo-container .nav li:hover a,
	#above-logo-container .nav li.current-menu-item a{color:#{$d_o['nav_a_menu_a_h']};background:#{$d_o['nav_a_menu_a_h_bg']};border-color:#{$d_o['nav_a_menu_a_sep']}!important}\n";
	$css .= "#above-logo-container .nav li ul {border-color:#{$d_o['nav_a_menu_a_sep']}!important}\n";
	$css .= "#above-logo-container .nav li:hover a,.nav ul{border-color:#{$d_o['nav_a_thick_border']};}\n";
	$css .= "#above-logo-container .nav li:hover ul a{color:#{$d_o['nav_a_menu_dropdown_a']};background-color:#{$d_o['nav_a_menu_dropdown_a_bg']}}\n";
	$css .= "#above-logo-container .nav li:hover ul a:hover{color:#{$d_o['nav_a_menu_dropdown_a_h']};background-color:#{$d_o['nav_a_menu_dropdown_a_h_bg']}}\n";

	endif;

	if(isset($d_o['b_nav_below_logo']) && $d_o['b_nav_below_logo']):
	$css .= "/*Below logo*/\n";
	$css .= "#below-logo-container{background:#{$d_o['nav_b_bg']};}\n";
	$css .= "#below-logo-container{border-bottom:solid 1px #{$d_o['nav_b_thin_border']};border-top:solid 5px #{$d_o['nav_b_thick_border']}}\n";
	$css .= "#below-logo-container .nav li a{color:#{$d_o['nav_b_menu_a']};background-color:#{$d_o['nav_b_menu_a_bg']};border-color:#{$d_o['nav_b_menu_a_bg']}}\n";
	$css .= "#below-logo-container .nav li a:hover,
	#below-logo-container .nav li:hover a,
	#below-logo-container .nav li.current-menu-item a{color:#{$d_o['nav_b_menu_a_h']};background-color:#{$d_o['nav_b_menu_a_h_bg']};border-color:#{$d_o['nav_b_menu_a_sep']}!important}\n";
	$css .= "#below-logo-container .nav li ul {border-color:#{$d_o['nav_b_menu_a_sep']}!important}\n";
	$css .= "#below-logo-container .nav li:hover a,.nav ul{border-color:#{$d_o['nav_b_thick_border']};}\n";
	$css .= "#below-logo-container .nav li:hover ul a{color:#{$d_o['nav_b_menu_dropdown_a']};background-color:#{$d_o['nav_b_menu_dropdown_a_bg']}}\n";
	$css .= "#below-logo-container .nav li:hover ul a:hover{color:#{$d_o['nav_b_menu_dropdown_a_h']};background-color:#{$d_o['nav_b_menu_dropdown_a_h_bg']}}\n";
	endif;

	else:

	//Solid nav colors
	if(isset($d_o['s_nav_above_logo']) && $d_o['s_nav_above_logo']):

	$css .= "/* Above logo*/\n";
	$css .= "#above-logo-container{background:#{$d_o['nav1_a_bg']};}\n";
	$css .= "#above-logo-container .nav li a{color:#{$d_o['nav1_a_menu_a']};background-color:#{$d_o['nav1_a_menu_a_bg']};}\n";
	$css .= "#above-logo-container .nav li a:hover{color:#{$d_o['nav1_a_menu_a_h']};}\n";
	$css .= "#above-logo-container .nav li a:hover,
	#above-logo-container .nav li:hover a,
	#above-logo-container .nav li.current-menu-item a {background-color:#{$d_o['nav1_a_menu_a_h_bg']}}\n";
	$css .= "#above-logo-container .nav li:hover ul,#above-logo-container .nav li:hover a {background:#{$d_o['nav1_a_menu_a_h_bg']}}\n";
	//$css .= "#above-logo-container .nav li:hover ul a{background-color:#{$d_o['nav1_a_menu_dropdown_a_bg']};color:#{$d_o['nav1_a_menu_dropdown_a']}}\n";
	$css .= "#above-logo-container .nav li:hover ul a:hover{background-color:#{$d_o['nav1_a_menu_dropdown_a_h_bg']};}\n";
	$css .= "#above-logo-container .nav li:hover ul a:hover{color:#{$d_o['nav1_a_menu_dropdown_a_h']};background-color:#{$d_o['nav1_a_menu_dropdown_a_h_bg']}}\n";
	endif;

	if(isset($d_o['s_nav_below_logo']) && $d_o['s_nav_below_logo']):
	$css .= "/* Below logo */\n";
	$css .= "#below-logo-container{background:#{$d_o['nav1_b_bg']};}\n";
	$css .= "#below-logo-container .nav li a{color:#{$d_o['nav1_b_menu_a']};background-color:#{$d_o['nav1_b_menu_a_bg']};}\n";
	$css .= "#below-logo-container .nav li a:hover{color:#{$d_o['nav1_b_menu_a_h']};}\n";
	$css .= "#below-logo-container .nav li a:hover,
	#below-logo-container .nav li:hover a,
	#below-logo-container .nav li.current-menu-item a {background-color:#{$d_o['nav1_b_menu_a_h_bg']}}\n";
	$css .= "#below-logo-container .nav li:hover ul,#below-logo-container .nav li:hover a {background-color:#{$d_o['nav1_b_menu_a_h_bg']}}\n";
	//$css .= "#below-logo-container .nav li:hover ul a{background-color:#{$d_o['nav1_b_menu_dropdown_a_bg']};color:#{$d_o['nav1_b_menu_dropdown_a']}}\n";
	$css .= "#below-logo-container .nav li:hover ul a:hover{background-color:#{$d_o['nav1_b_menu_dropdown_a_h_bg']};}\n";
	$css .= "#below-logo-container .nav li:hover ul a:hover{color:#{$d_o['nav1_b_menu_dropdown_a_h']};background-color:#{$d_o['nav1_b_menu_dropdown_a_h_bg']}}\n";
	endif;

	endif;

	if(isset($d_o['post_colors']) && $d_o['post_colors']):
	/* Post title colors */
	$css .= "h2.entry-title a,h1.entry-title{color:#{$d_o['post_title']};}\n";
	$css .= ".entry-meta{color:#{$d_o['post_meta']};}\n";
	$css .= ".entry-meta{color:#{$d_o['post_meta']};}\n";
	$css .= ".entry-content blockquote{border-color:#{$d_o['post_blockquote_border']}}\n";
	$css .= ".wp-caption{background:#{$d_o['img_caption_bg']};border-color:#{$d_o['img_caption_border']}}\n";
	$css .= ".tags a{background:#{$d_o['post_tag_bg']};color:#{$d_o['post_tag']}}";
	$css .= ".tags a:hover{background:#{$d_o['post_tag_bg_h']};color:#{$d_o['post_tag']}}";
	endif;

	if(isset($d_o['newspaper_colors']) && $d_o['newspaper_colors']):
	/* News paper layout colors */
	$css .= ".np-section-title{background:#{$d_o['np_section_title_bg']};color:#{$d_o['np_section_title']};}";
	$css .= "#np-popular{background:{$d_o['np_popular_bg']}}";
	endif;

	if(isset($d_o['sidebar_colors']) && $d_o['sidebar_colors']):
	/* Sidebar widget colors */
	$css .= ".widget{background:#{$d_o['sb_w_bg']};border-color:#{$d_o['sb_w_border']};color:#{$d_o['sb_w']};}\n";
	$css .= ".widget a{color:#{$d_o['sb_w_a']};}\n";
	$css .= ".widget a:hover{color:#{$d_o['sb_w_a_h']};}\n";
	$css .= "p.widget-title{background:#{$d_o['sb_w_title_bg']};color:#{$d_o['sb_w_title']};border-color:#{$d_o['sb_w_title_border']}}\n";
	$css .= ".widget li{border-color:#{$d_o['sb_w_li_border']};}\n";
	$css .= ".widget li:hover{background:#{$d_o['sb_w_li_hover_bg']};}\n";
	$css .= ".widget .thumb,.widget .avatar{background:#{$d_o['sb_w_thumb_bg']};border-color:#{$d_o['sb_w_thumb_border']}}\n";

	$css .= ".widget .nopadding{background:#{$d_o['sb_w_bg']}}\n";
	$css .= ".meta a{color:#{$d_o['sb_date']}}\n";
	endif;


	if(isset($d_o['footer_colors']) && $d_o['footer_colors']):
	/* Footer widget colors */
	$css .= ".footer .widget{background:#{$d_o['fo_w_bg']};border-color:#{$d_o['fo_w_border']};color:#{$d_o['fo_w']};}\n";
	$css .= ".footer .widget a{color:#{$d_o['fo_w']};}\n";
	$css .= ".footer .widget a:hover{color:#{$d_o['fo_w_a_h']};}\n";
	$css .= ".footer p.widget-title{background:#{$d_o['fo_w_title_bg']};border-color:#{$d_o['fo_w_title_border']};color:#{$d_o['fo_w_title']};}\n";
	$css .= ".footer .widget li{border-color:#{$d_o['fo_w_li_border']};}\n";
	$css .= ".footer .widget li:hover{background:#{$d_o['fo_w_li_hover_bg']};}\n";
	$css .= ".footer .widget .thumb,#footer .avatar{background:#{$d_o['fo_w_thumb_bg']};border-color:#{$d_o['fo_w_thumb_border']}}\n";

	$css .= ".footer .widget .nopadding{background:#{$d_o['fo_w_bg']}}\n";
	$css .= ".footer .meta a{color:#{$d_o['fo_date']}}\n";

	if(isset($d_o['subscribe_widget_colors']) && $d_o['subscribe_widget_colors'])
		/* Widget styling */
		$css .= ".widget_subscribe_box{color:#{$d_o['sub_widget']};background-color:#{$d_o['sub_widget_bg']};border-color:{$d_o['sub_widget_ribbon_bg']};}\n";
	$css .=".sm-love{background:#{$d_o['sub_widget_ribbon_bg']};}\n";
	endif;

	if(isset($d_o['comemnt_colors']) &&$d_o['comemnt_colors']):
	/* Comments colors */
	$css .= "li.comment,
	li.pingback,
	li.trackback{background:#{$d_o['comment_bg']};border-color:#{$d_o['comment_border']};color:#{$d_o['comment']};}\n";
	$css .= "li.comment a,
	li.pingback a,
	li.trackback a{color:#{$d_o['comment_a']};}\n";


	$css .= "li.comment a:hover,
	li.pingback a:hover,
	li.trackback a:hover{color:#{$d_o['comment_a_h']};}\n";

	$css .= "li.comment .avatar{background:#{$d_o['comment_border']};}\n"; //Avatar background is same as comemnt border


	$css .= "li.comment.bypostauthor,
	ul.children li.comment.bypostauthor{border-left-color:#{$d_o['author_comment_bg']};}\n";
	$css .= "li.comment.bypostauthor .postauthor-avatar .avatar{background:#{$d_o['author_comment_bg']}!important;}\n";
	/*
	 $css .= ".reply{background:#{$d_o['comment_reply_bg']};}\n";
	$css .= ".reply a{color:#{$d_o['comment_reply']};}\n";
	$css .= ".reply:hover{background:#{$d_o['comment_reply_h_bg']};}\n";
	*/
	$css .= "#respond{background:#{$d_o['comment_form_bg']};}\n";
	$css .= "#commentform input,
	#commentform textarea{background:#{$d_o['comment_form_field_bg']};border-color:#{$d_o['comment_form_field_border']}}\n";

	$css .= "li.comment,li.pingback,li.trackback,li.comment .avatar{-moz-box-shadow: inset 0 2px 50px #{$d_o['comment_shadow']};-webkit-box-shadow: inset 0 2px 50px #{$d_o['comment_shadow']};box-shadow: inset 0 2px 50px #{$d_o['comment_shadow']};}\n";
	endif;



	/* Copyright colors */
	if(isset($d_o['copyright_colors']) && $d_o['copyright_colors']):
	$css .="#copyright-container{border-color:#{$d_o['copyright_border']};color:#{$d_o['copyright']}}\n";
	$css .="#copyright-container a{color:#{$d_o['copyright_a']}}\n";
	$css .="#copyright-container a:hover{color:#{$d_o['copyright_a_h']}}\n";
	endif;

	/* Magazine boxes */
	if(isset($d_o['mag_colors']) && $d_o['mag_colors']):
	$css .= "article.mag1 {background:#{$d_o['mag1_bg']};border-color:#{$d_o['mag1_border']};}";
	$css .= "article.mag1 img{background:#{$d_o['mag1_thumb_bg']};}";
	$css .= "article.mag1 footer{background:#{$d_o['mag1_footer_bg']};color:#{$d_o['mag1_footer']}}";
	$css .= "article.mag1 footer a{color:#{$d_o['mag1_footer']}}";

	$css .= "#rp-sm{background:#{$d_o['rp_bg']};border-color:#{$d_o['post_nav_bg']};}";
	$css .= "#nav-single{background:#{$d_o['post_nav_bg']};}";
	$css .= "#nav-single a{;color:#{$d_o['post_nav_a']};border:none}";
	$css .= "#nav-single a:hover{}";
	$css .= "#related-posts li a{color:#{$d_o['rp_a']};}";
	$css .= "#related-posts .posted-on,
	#related-posts .posted-on a{color:#{$d_o['rp_meta']}}";
	$css .= "#related-posts img{background:#{$d_o['rp_thumb_bg']};border-color:#{$d_o['rp_thumb_border']}}";
	endif;

	/* Author BIO */
	if(isset($d_o['author_bio_colors']) && $d_o['author_bio_colors']):
	$css .= "#author-info{background:#{$d_o['ab_bg']};border-color:#{$d_o['ab_border']};color:#{$d_o['ab']};}";
	$css .= "#author-info a{color:#{$d_o['ab_a']};}";
	$css .= "#author-info a:hover{color:#{$d_o['ab_a_hover']};}";
	$css .= "footer #author-info .avatar{background:#{$d_o['ab_avatar_bg']};}";
	endif;

	if(isset($d_o['generic_element_colors']) && $d_o['generic_element_colors'] ):
	/* Generic elements */
	$css .= "a.btn,a.comment-reply-link,.btn,
	#commentform input#submit,#searchsubmit,input[type=submit] {border: 1px solid #{$d_o['button_border']};border-bottom-color: #{$d_o['button_bottom_border']};
	color: #{$d_o['button_text']} !important;


	/*Background*/
	background-color: #{$d_o['button_bg']}; /*Fallback*/
	background: -webkit-gradient(
	linear,
	left top,
	left bottom,
	color-stop(.2, #{$d_o['button_gradient_start']}),
	color-stop(1, #{$d_o['button_gradient_stop']})
	);
	background: -moz-linear-gradient(
	center top,
	#{$d_o['button_gradient_start']} 20%,
	#{$d_o['button_gradient_stop']} 100%
	);
}
a.btn:hover,.btn:hover,a.comment-reply-link:hover,
#commentform input#submit:hover,#searchsubmit:hover,input[type=submit]:hover {

/*Background*/
background-color: #{$d_o['button_bg']}; /*Fallback*/
background: -webkit-gradient(
linear,
left top,
left bottom,
color-stop(.2, #{$d_o['button_gradient_stop']}),
color-stop(1, #{$d_o['button_gradient_start']})
);
background: -moz-linear-gradient(
center top,
#{$d_o['button_gradient_stop']} 20%,
#{$d_o['button_gradient_start']} 100%
);
}";

	$css .= "
	footer.home.entry-meta,
	.wp-pagenavi,
	.page-link{border-color:#{$d_o['generic_border_light']};}";

	$css .="
	.wp-pagenavi a,
	.wp-pagenavi span.current,
	.page-link a,
	a.page-numbers,
	.page-numbers.current{border-color:#{$d_o['generic_border_dark']};}";

	$css .="
	.wp-pagenavi a:hover,
	.wp-pagenavi span.current,
	.page-link a:hover,
	a.page-numbers:hover,
	.page-numbers.current{background:#{$d_o['generic_border_light']};border-color:#{$d_o['generic_border_dark']}}";
	endif;

	if(isset($d_o['slider_colors']) && $d_o['slider_colors']):
	// Slider colors //
	$css .= ".flexslider{background:#{$d_o['slider_bg']};border-color:#{$d_o['slider_border']}}";
	$css .= ".flex-caption{background:#{$d_o['slide_caption_bg']};color:#{$d_o['slide_caption']};opacity:.7}";
	$css .= ".flex-caption a{color:#{$d_o['slide_caption']};}";
	endif;

	if(isset($d_o['tabs_widget_colors']) && $d_o['tabs_widget_colors']):
	// Swift tabs widget //
	$css .= ".widget_swift_tabs .shortcode-tabs{background:#{$d_o['tabs_border']}}";
	$css .= ".widget_swift_tabs .tab_titles li.nav-tab a{color:#{$d_o['tabs_title']}!important;}";
	$css .= ".widget_swift_tabs .tab_titles li.nav-tab.ui-tabs-selected a,
	.widget_swift_tabs .tab_titles li a:hover,
	.widget_swift_tabs .tab{background:#{$d_o['tabs_bg']}!important;color:#{$d_o['tabs']};}";
	$css .= ".widget_swift_tabs .tab a{color:#{$d_o['tabs_a']};}";
	$css .= ".widget_swift_tabs .tab a:hover{color:#{$d_o['tabs_a_h']};}";
	endif;

	if(isset($d_o['table_colors']) && $d_o['table_colors']):
	// Table styling widget //
	$css .= ".entry-content tr th,
	.entry-content thead th {background:#{$d_o['t_head_bg']};color:#{$d_o['t_head']}}";
	$css .= ".entry-content tr td {background:#{$d_o['t_even_row_bg']}}";
	$css .= ".entry-content tr:nth-child(odd) td {background:#{$d_o['t_odd_row_bg']}}";

	$css .= ".entry-content table,.entry-content tr td{color:#{$d_o['t_text']};border-color:#{$d_o['t_border']}}";

	// Misc //
	$css .= ".blog-thumb{background:#{$d_o['blog_thumb_bg']};border-color:#{$d_o['blog_thumb_border']};}";

	endif;

	endif;

	/* Fonts */

	/*body*/
	if( $d_o['body_font_enable'] ){
		if( $d_o['body_font_family'] == 'Use default')
			$d_o['body_font_family'] = 'Georgia';
		$css .= "body{font:{$d_o['body_font_style']} {$d_o['body_font_weight']} {$d_o['body_font_size']}{$d_o['body_font_size_unit']}/{$d_o['body_font_lh']}{$d_o['body_font_lh_unit']} {$d_o['body_font_family']};text-transform:{$d_o['body_font_transform']};}";
	}

	$css .= ".entry-content,
	.entry-summary,
	.widget,
	.comment{text-align:{$d_o['body_text_align']};}";

	/* blog title */
	if( $d_o['blog_name_font_enable'] ){

		if( $d_o['blog_name_font_family'] == 'Use default')
			$d_o['blog_name_font_family'] = 'Georgia';
		$css .= "#site-title {font:{$d_o['blog_name_font_style']} {$d_o['blog_name_font_weight']} {$d_o['blog_name_font_size']}{$d_o['blog_name_font_size_unit']}/{$d_o['blog_name_font_lh']}{$d_o['blog_name_font_lh_unit']} {$d_o['blog_name_font_family']};text-transform:{$d_o['blog_name_font_transform']}}";
	}

	/* Blog tag line */
	if( $d_o['blog_tagline_font_enable'] ){
		if( $d_o['blog_tagline_font_family'] == 'Use default')
			$d_o['blog_tagline_font_family'] = 'Georgia';
		$css .= "#site-description {font:{$d_o['blog_tagline_font_style']} {$d_o['blog_tagline_font_weight']} {$d_o['blog_tagline_font_size']}{$d_o['blog_tagline_font_size_unit']}/{$d_o['blog_tagline_font_lh']}{$d_o['blog_tagline_font_lh_unit']} {$d_o['blog_tagline_font_family']};text-transform:{$d_o['blog_tagline_font_transform']}}";

	}

	/* Navigation */
	if( $d_o['nav_a_font_enable'] ){
		if( $d_o['nav_a_font_family'] == 'Use default')
			$d_o['nav_a_font_family'] = 'Georgia';
		$css .= "#above-logo-container .navigation {font:{$d_o['nav_a_font_style']} {$d_o['nav_a_font_weight']} {$d_o['nav_a_font_size']}{$d_o['nav_a_font_size_unit']}/1.625em {$d_o['nav_a_font_family']};text-transform:{$d_o['nav_a_font_transform']}}";

		/* RSS icons height depends on the nav font height */
		//	if($d_o['nav_a_font_size_unit'] == 'px')
		$height = (1.625/2)*$d_o['nav_a_font_size']."{$d_o['nav_a_font_size_unit']}";
		$css .= "#rss-links li a{padding:{$height}}";

	}
	if( $d_o['nav_b_font_enable'] ){
		if( $d_o['nav_b_font_family'] == 'Use default')
			$d_o['nav_b_font_family'] = 'Georgia';
		$css .= "#below-logo-container .navigation {font:{$d_o['nav_b_font_style']} {$d_o['nav_b_font_weight']} {$d_o['nav_b_font_size']}{$d_o['nav_b_font_size_unit']}/1.625em {$d_o['nav_b_font_family']};text-transform:{$d_o['nav_b_font_transform']}}";

	}
	/* Heading font */
	if( $d_o['heading_tags_enable'] ){
		$css .= "h1,h2,h3,h4,h5,h6{font-family:{$d_o['heading_tags_family']};font-weight:{$d_o['heading_tags_weight']};font-style:{$d_o['heading_tags_style']};text-transform:{$d_o['heading_tags_transform']}}";
	}


	/* Home page post title (BLOG) */
	if( $d_o['home_post_title_enable'] ){
		if( $d_o['home_post_title_family'] == 'Use default')
			$d_o['home_post_title_family'] = 'Georgia';
		$css .= "h2.entry-title{font:{$d_o['home_post_title_style']} {$d_o['home_post_title_weight']} {$d_o['home_post_title_size']}{$d_o['home_post_title_size_unit']}/{$d_o['home_post_title_lh']}{$d_o['home_post_title_lh_unit']} {$d_o['home_post_title_family']};text-transform:{$d_o['home_post_title_transform']}}";
	}

	/* Home page post title (MAGAZINE) */
	if( $d_o['home_post_title_mag_enable'] ){
		if( $d_o['home_post_title_mag_family'] == 'Use default')
			$d_o['home_post_title_mag_family'] = 'Georgia';
		$css .= "article.mag1 h2.entry-title{font:{$d_o['home_post_title_mag_style']} {$d_o['home_post_title_mag_weight']} {$d_o['home_post_title_mag_size']}{$d_o['home_post_title_mag_size_unit']}/{$d_o['home_post_title_mag_lh']}{$d_o['home_post_title_mag_lh_unit']} {$d_o['home_post_title_mag_family']};text-transform:{$d_o['home_post_title_mag_transform']}}";
	}

	/* Single page post title */
	if( $d_o['single_post_title_enable'] ){
		if( $d_o['single_post_title_family'] == 'Use default')
			$d_o['single_post_title_family'] = 'Georgia';
		$css .= "h1.entry-title{font:{$d_o['single_post_title_style']} {$d_o['single_post_title_weight']} {$d_o['single_post_title_size']}{$d_o['single_post_title_size_unit']}/{$d_o['single_post_title_lh']}{$d_o['single_post_title_lh_unit']} {$d_o['single_post_title_family']};text-transform:{$d_o['single_post_title_transform']}}";
	}

	/* Post meta *
	 if( $d_o['post_meta_font_enable'] ){
	if( $d_o['post_meta_font_family'] == 'Use default')
		$d_o['post_meta_font_family'] = 'Georgia';
	$css .= ".single-meta-above-title,
	.single-meta-below-title,
	.single-meta-above-title a,
	.single-meta-below-title a,
	.meta a{font:{$d_o['post_meta_font_style']} {$d_o['post_meta_font_weight']} {$d_o['post_meta_font_size']}{$d_o['post_meta_font_size_unit']}/{$d_o['post_meta_font_lh']}{$d_o['post_meta_font_lh_unit']} {$d_o['post_meta_font_family']};text-transform:{$d_o['post_meta_font_transform']}}";
	}

	/* Sidebar title */
	if( $d_o['sidebar_title_font_enable'] ){
		if( $d_o['sidebar_title_font_family'] == 'Use default')
			$d_o['sidebar_title_font_family'] = 'Georgia';
		$css .= "p.widget-title{font:{$d_o['sidebar_title_font_style']} {$d_o['sidebar_title_font_weight']} {$d_o['sidebar_title_font_size']}{$d_o['sidebar_title_font_size_unit']}/{$d_o['sidebar_title_font_lh']}{$d_o['sidebar_title_font_lh_unit']} {$d_o['sidebar_title_font_family']};text-transform:{$d_o['sidebar_title_font_transform']}}";
	}

	/* Sidebar widget */
	if( $d_o['sidebar_widget_font_enable'] ){
		if( $d_o['sidebar_widget_font_family'] == 'Use default')
			$d_o['sidebar_widget_font_family'] = 'Georgia';
		$css .= "#sidebar .widget{font:{$d_o['sidebar_widget_font_style']} {$d_o['sidebar_widget_font_weight']} {$d_o['sidebar_widget_font_size']}{$d_o['sidebar_widget_font_size_unit']}/{$d_o['sidebar_widget_font_lh']}{$d_o['sidebar_widget_font_lh_unit']} {$d_o['sidebar_widget_font_family']};text-transform:{$d_o['sidebar_widget_font_transform']}}";
	}

	/* Footer title */
	if( $d_o['footer_title_font_enable'] ){
		if( $d_o['footer_title_font_family'] == 'Use default')
			$d_o['footer_title_font_family'] = 'Georgia';
		$css .= "#footer p.widget-title{font:{$d_o['footer_title_font_style']} {$d_o['footer_title_font_weight']} {$d_o['footer_title_font_size']}{$d_o['footer_title_font_size_unit']}/{$d_o['footer_title_font_lh']}{$d_o['footer_title_font_lh_unit']} {$d_o['footer_title_font_family']};text-transform:{$d_o['footer_title_font_transform']}}";
	}

	/* Footer widget */
	if( $d_o['footer_widget_font_enable'] ){
		if( $d_o['footer_widget_font_family'] == 'Use default')
			$d_o['footer_widget_font_family'] = 'Georgia';
		$css .= "#footer .widget{font:{$d_o['footer_widget_font_style']} {$d_o['footer_widget_font_weight']} {$d_o['footer_widget_font_size']}{$d_o['footer_widget_font_size_unit']}/{$d_o['footer_widget_font_lh']}{$d_o['footer_widget_font_lh_unit']} {$d_o['footer_widget_font_family']};text-transform:{$d_o['footer_widget_font_transform']}}";
	}

	/* Copyright container */
	if( $d_o['copyright_font_enable'] ){
		if( $d_o['copyright_font_family'] == 'Use default')
			$d_o['copyright_font_family'] = 'Georgia';
		$css .= "#copyright{font:{$d_o['copyright_font_style']} {$d_o['copyright_font_weight']} {$d_o['copyright_font_size']}{$d_o['copyright_font_size_unit']}/{$d_o['copyright_font_lh']}{$d_o['copyright_font_lh_unit']} {$d_o['copyright_font_family']};text-transform:{$d_o['copyright_font_transform']}}";
	}
	/* Background images */
	if( isset( $d_o['body_bg_image'] ) && $d_o['body_bg_image'] )
		$css .= 'body{background:#'.$d_o['body_bg'].' url("'.$d_o['body_bg_image'].'") '.$d_o['body_bg_image_repeat'].' '.$d_o['body_bg_image_p_l'].' '.$d_o['body_bg_image_p_t'].' ;}'."\n";

	if( isset( $d_o['wrapper_bg_image'] ) && $d_o['wrapper_bg_image'] )
		$css .= '#wrapper{background:#'.$d_o['wrapper_bg'].' url("'.$d_o['wrapper_bg_image'].'") '.$d_o['wrapper_bg_image_repeat'].' '.$d_o['wrapper_bg_image_p_l'].' '.$d_o['wrapper_bg_image_p_t'].' ;}'."\n";

	if( isset( $d_o['main_bg_image'] ) && $d_o['main_bg_image'] )
		$css .= '#main{background:#'.$d_o['main_bg'].' url("'.$d_o['main_bg_image'].'") '.$d_o['main_bg_image_repeat'].' '.$d_o['main_bg_image_p_l'].' '.$d_o['main_bg_image_p_t'].' ;}'."\n";

	if( isset( $d_o['header_bg_image'] ) && $d_o['header_bg_image'] )
		$css .= '#header-container{background:#'.$d_o['header_bg'].' url("'.$d_o['header_bg_image'].'") '.$d_o['header_bg_image_repeat'].' '.$d_o['header_bg_image_p_l'].' '.$d_o['header_bg_image_p_t'].' ;}'."\n";

	if( isset( $d_o['sidebar_bg_image'] ) && $d_o['sidebar_bg_image'] )
		$css .= '#sidebar-container{background:#'.$d_o['sb_bg'].' url("'.$d_o['sidebar_bg_image'].'") '.$d_o['sidebar_bg_image_repeat'].' '.$d_o['sidebar_bg_image_p_l'].' '.$d_o['sidebar_bg_image_p_t'].' ;}'."\n";

	if( isset( $d_o['footer_bg_image'] ) && $d_o['footer_bg_image'] )
		$css .= '#footer-container{background:#'.$d_o['fo_bg'].' url("'.$d_o['footer_bg_image'].'") '.$d_o['footer_bg_image_repeat'].' '.$d_o['footer_bg_image_p_l'].' '.$d_o['footer_bg_image_p_t'].' ;}'."\n";


	if( $d_o['bordered_nav_border_remove'] )
		$css .= '#above-logo-container,#below-logo-container{border-width:0}';

	/* Rounded corners */
	if( isset( $d_o['solid_nav_rounded']) && !$d_o['solid_nav_rounded'] )
		$css .= '#above-logo-container,#below-logo-container{border-radius:0;-moz-border-radius: 0 ;-webkit-border-radius:0;}';

	if( isset( $d_o['mag1_rounded'] ) && $d_o['mag1_rounded'] )
		$css .= '.mag1{border-radius:5px;-moz-border-radius: 5px ;-webkit-border-radius: 5px;}';

	if( isset( $d_o['sb_widget_rounded'] ) && $d_o['sb_widget_rounded'] )
		$css .= '.widget{border-radius:5px;-moz-border-radius: 5px ;-webkit-border-radius: 5px;}';

	if( isset( $d_o['footer_widget_rounded'] ) && $d_o['footer_widget_rounded'] )
		$css .= '#footer .widget{border-radius:5px;-moz-border-radius: 5px ;-webkit-border-radius: 5px;}';


	if( isset( $d_o['comment_rounded'] ) && $d_o['comment_rounded'] ){
		$css .= 'li.comment,li.pingback,li.trackback,li.comment .avatar{border-radius:5px;-moz-border-radius: 5px ;-webkit-border-radius: 5px;}';
		$css .='li.comment li.comment{-moz-border-radius-topright:0;
				-webkit-border-top-right-radius:0;
				border-top-right-radius:0;
				-moz-border-radius-bottomright:0;
				-webkit-border-bottom-right-radius:0;
				border-bottom-right-radius:0;}';

	}

	if( isset( $d_o['header-height'] ) && $d_o['header-height'] !=0 ){
		$css .= "#branding{height:{$d_o['header-height']}px;}";
	}

	/* Including base64images */
	$css .= $wp_filesystem->get_contents( THEME_DIR.'/css/base64img/comment-icon.txt' )."\n" ;
	$css .= $wp_filesystem->get_contents( THEME_DIR.'/css/base64img/rss-subscribe.txt' )."\n" ;
	$css .= $wp_filesystem->get_contents( THEME_DIR.'/css/base64img/breadcrumbs-home-icon.txt' ) ."\n";
	if($swift_options['rss_links_enable'])
		$css .= $wp_filesystem->get_contents( THEME_DIR.'/css/base64img/rss-links.txt' ) ."\n";

	/* Mobile colors */
	if( isset( $d_o['enable_custom_colors_mobile']) && $d_o['enable_custom_colors_mobile'] ):
	$css .= '@media screen and (max-width: 640px){ ';
	$css .= '#below-logo-container,#above-logo-container,.pull_w,.navigation,.nav{background-color:#'.$d_o['mo_nav_bg'].'!important}';
	$css .= '.pull{background-color:#'.$d_o['mo_nav_icon_bg'].'!important}';
	$css .= '.nav,.nav li a{border-color:#'.$d_o['mo_nav_icon_bg'].'!important;}';
	$css .= '#below-logo-container a{color:#'.$d_o['mo_nav_a'].';}';
	$css .= '}';
	endif;

	/* User CSS */
	if( isset( $d_o['enable_user_css'] ) && $d_o['enable_user_css'] ){
		$css .= $d_o['user_css'];
	}

	return $css;

}