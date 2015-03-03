<?php
/**
 * Swift Options Initialization
 *
 * We define our theme options array here.
 */
$cats = get_categories( );
$cat_names = $cat_ids = array();
$cat_names[0] = __( 'Show recent posts', 'swift' );
foreach( $cats as $cat ){
	$cat_names[$cat->cat_ID] = $cat->name;
}
GLOBAL $swift_options_init;
$swift_options_init[] = array( 'name' => __( 'tag', 'swift' ),
		'id' => 'which',
		'value' => 'options',
		'type' => 'hidden',
		'datatype' => 'none');

$swift_options_init[] = array( 'name' => __( 'General settings', 'swift' ),
		'id' => 'general-settings',
		'type' => 'heading',
		'datatype' => 'none');


$swift_options_init[] = array( 'name' => __('Custom favicon', 'swift' ),
		'desc' => sprintf( __('Upload or specify the URL of your favicon which is visible in browser favorites and tabs %s( Must be a .png or .ico file - 16px by 16px ).%s', 'swift' ), '<strong>', '</strong>' ),
		'id' => 'favicon',
		'default' => '',
		'type' => 'upload',
		'datatype' => 'uri');

$swift_options_init[] = array( 'name' => __('Header scripts', 'swift' ),
		'desc' => __('If you need to add scripts to your header (like Mint tracking code or BSA script ), you should enter them here. They will be added before the &lt;/head&gt; tag.', 'swift' ).'<br /><br />'.
		sprintf( __('%sNote%s: You can add multiple scripts.', 'swift' ), '<strong>', '</strong>' ),
		'id' => 'header_scripts',
		'default' => '',
		'type' => 'textarea',
		'datatype' => 'js');

$swift_options_init[] = array( 'name' => __('Footer scripts', 'swift' ),
		'desc' => __('Paste your Google Analytics (and/or any other) tracking code here. These scripts will be added in the footer section before the &lt;/body&gt; tag.', 'swift' ).'<br /><br />'.
		sprintf( __('%sNote%s: You can add multiple scripts.', 'swift' ), '<strong>', '</strong>' ),
		'id' => 'footer_scripts',
		'default' => '',
		'type' => 'textarea',
		'datatype' => 'js');

$swift_options_init[] = array( 'name' => __('About us', 'swift' ),
		'desc' => __('If you are using the content width slider in combination with the full width magazine layout, information or AD added here will be shown adjacent to the slider.', 'swift' ),
		'id' => 'about_us',
		'default' => '',
		'type' => 'textarea',
		'datatype' => 'js');

$swift_options_init[] = array( 'name' => __('Default thumbnail image', 'swift' ),
		'desc' => __('Upload an image to be used as thumbnail when the post doesn\'t have one. If you are using the full width slider, the image should be at least 940px wide.', 'swift' ),
		'id' => 'default_thumb',
		'default' => get_template_directory_uri().'/images/default.png',
		'type' => 'upload',
		'datatype' => 'uri' );

$swift_options_init[] = array( 'type' => 'close',
		'datatype' => 'none' ); // Closing general-settings


/* Header Options */

$swift_options_init[] = array( 'name' => __( 'Header Options', 'swift' ),
		'id' => 'header-options',
		'type' => 'heading',
		'datatype' => 'none' );

$swift_options_init[] = array( 'name' => __('Upload Logo', 'swift' ),
		'desc' => __('Upload a logo for your site, or specify an image URL directly.', 'swift' ),
		'id' => 'logo',
		'default' => NULL,
		'type' => 'upload',
		'datatype' => 'uri');


$swift_options_init[] = array( 'name' => __( 'Logo position', 'swift' ),
		'desc' => __( '', 'swift' ),
		'id' => 'logo_position',
		'default' => 'left',
		'type' => 'radio',
		'options' => array( 'left' => 'left', 'center' => 'center', 'right' => 'right' ),
		'datatype' => 'predefined' );

$swift_options_init[] = array( 'name' => __( 'Enter your custom search code', 'swift' ),
		'desc' => sprintf( __( 'If you have a custom search code, such as %sAdsense for Search%s, add it here.', 'swift' ), '<strong>', '</strong>' ),
		'id' => 'search_code',
		'type' => 'textarea',
		'default'=> '',
		'datatype' => 'javascript' );

$swift_options_init[] = array(  'name' => __( 'Show search form in navigation', 'swift' ),
		'desc' => __( 'Check this box to show search form in navigation below logo', 'swift' ),
		'id' => 'nav_search_enable',
		'type' => 'checkbox',
		'default' => true,
		'datatype' => 'bool' );

$swift_options_init[] = array(  'name' => __( 'Show RSS links in navigation', 'swift' ),
		'desc' => __( 'Check this box to show RSS links in navigation above logo', 'swift' ),
		'id' => 'rss_links_enable',
		'type' => 'checkbox',
		'default' => true,
		'datatype' => 'bool' );

$swift_options_init[] = array( 'type' => 'close',
		'datatype' => 'none' ); // Closing header-options


$swift_options_init[] = array( 'name' => __( 'Homepage Options', 'swift' ),
		'id' => 'homepage-options',
		'type' => 'heading',
		'datatype' => 'none' );

$swift_options_init[] = array(  'name' => __( 'Enable featured post slider', 'swift' ),
		'desc' => __( 'Check this box to enable featured post slider on home page.', 'swift' ),
		'id' => 'slider_enable',
		'type' => 'checkbox',
		'default' => true,
		'datatype' => 'bool' );

$swift_options_init[] = array( 'name' => __( 'Featured post slider style', 'swift' ),
		'desc' => __( 'Choose between the two sliders in SWIFT', 'swift' ),
		'id' => 'slider_style',
		'default' => 'content-width',
		'type' => 'radio',
		'options' => array( 'content-width' => 'content-width', 'full-width' => 'full-width' ),
		'datatype' => 'predefined' );

$swift_options_init[] = array( 'name' => __( 'Featured slider category', 'swift' ),
		'desc' => __( 'Select the featured post slider category', 'swift' ),
		'id' => 'featured_cat_home',
		'default' => '',
		'type' => 'select',
		'options' => $cat_names,
		'datatype' => 'predefined' );

$swift_options_init[] = array( 'name' => __('Number of featured posts', 'swift' ),
		'desc' => __('Select the number of featured posts to be displayed in the slider.', 'swift' ),
		'id' => 'featured_posts_number_home',
		'default' => 3,
		'type' => 'select',
		'options' => array( 1=>1, 2=>2, 3=>3, 4=>4, 5=>5, 6=>6, 7=>7, 8=>8, 9=>9, 10=>10, 11=>11, 12=>12, 13=>13, 14=>14, 15=>15, 16=>16, 17=>17, 18=>18, 19=>19, 20=>20),
		'datatype' => 'predefined' );

$swift_options_init[] = array( 'name' => __( 'Slider speed', 'swift' ),
		'desc' => __( 'Set the slider speed in milli seconds, ie., 1000 for one second.', 'swift' ),
		'id' => 'slider_speed',
		'default' => '5000',
		'type' => 'text',
		'datatype' => 'int' );

$swift_options_init[] = array( 'name' => __( 'Slider transition style', 'swift' ),
		'desc' => sprintf( __( 'Available styles: %s. The default is %s.', 'swift' ), 'fold, fade, sliceDown, random', 'random'),
		'id' => 'slider_transition',
		'default' => 'random',
		'type' => 'text',
		'datatype' => 'text' );

$swift_options_init[] = array(  'name' => __( 'Skip posts shown in slider from WP loop', 'swift' ),
		'desc' => __( 'Check this box to avoid duplicate content on homepage ( Useful when using full width slider ).', 'swift' ),
		'id' => 'skip_posts',
		'type' => 'checkbox',
		'default' => FALSE,
		'datatype' => 'bool' );


$swift_options_init[] = array(  'name' => __( 'Enable excerpts on home page', 'swift' ),
		'desc' => __( 'Check this box to enable excerpts on homepage.', 'swift' ),
		'id' => 'excerpts_enable',
		'type' => 'checkbox',
		'default' => true,
		'datatype' => 'bool' );

$swift_options_init[] = array(  'name' => __( 'Number of full length posts', 'swift' ),
		'desc' => 'If you enabled excerpts, select the number of full length posts you would like to show before excerpts',
		'id' => 'full_length_posts',
		'default' => 1,
		'type' => 'select',
		'options' => array( 0=>0,1=>1, 2=>2, 3=>3, 4=>4, 5=>5, 6=>6, 7=>7, 8=>8, 9=>9, 10=>10, 11=>11, 12=>12, 13=>13, 14=>14, 15=>15, 16=>16, 17=>17, 18=>18, 19=>19, 20=>20),
		'datatype' => 'predefined' );


$swift_options_init[] = array(  'name' => __( 'Change "Continue reading" button text here', 'swift' ),
		'desc' => '',
		'id' => 'continue_reading_button_text',
		'type' => 'text',
		'default' => __( 'Continue reading &rarr;', 'swift' ),
		'datatype' => 'text' );

$swift_options_init[] = array(  'name' => __( 'Display thumbnails', 'swift' ),
		'desc' => __( 'Check this box to display thumbnails when excerpts are enabled. (Applicable only to blog layout)', 'swift' ),
		'id' => 'excerpts_thumbs_enable',
		'type' => 'checkbox',
		'default' => true,
		'datatype' => 'bool' );


$swift_options_init[] = array( 'name' => __( 'Home page, after post content', 'swift' ),
		'desc' => __( 'Set the meta line to be displayed above title', 'swift' ),
		'id' => 'home_blog_meta',
		'default' => array( 'text', __( 'posted on', 'swift' ).' ' , 'date', 'text', ' '.__( 'by', 'swift' ).' ', 'author' ),
		'type' => 'sortable',
		'options' => array( 'text', 'author', 'tags', 'categories', 'date' ),
		'datatype' => 'sortable' );

$swift_options_init[] = array( 'type' => 'close',
		'datatype' => 'none' ); // Closing homepage-options



$swift_options_init[] = array( 'name' => __( 'Post meta', 'swift' ),
		'id' => 'post-meta',
		'type' => 'heading',
		'datatype' => 'none' );


$swift_options_init[] = array( 'name' => __( 'Related posts title', 'swift' ),
		'desc' => __( 'If you are using YARPP with custom template included in swift, set the related posts title here.', 'swift' ),
		'id' => 'yarpp_title',
		'default' => __( 'Related posts', 'swift' ),
		'type' => 'text',
		'datatype' => 'text' );


$swift_options_init[] = array( 'name' => __( 'Post meta', 'swift' ),
		'id' => 'post-meta-explanation',
		'type' => 'explain',
		'desc' => sprintf( __( 'Post meta is the administrative information provided along with the post, this includes %sauthor of the post, published date, how the post is categorized etc.%s This is usually displayed around the post title or at the end of the post.', 'swift' ), '<strong>', '</strong>' ).'<br /><br />'.
		sprintf( __( 'Here you can configure the post meta info displayed in single post page. Simply %sDrag and Drop%s the tags you want to add to your Post. The Blank Box could be used to enter filler text like Written by: \'Author tag\' or Filed under: \'Categories\' etc. These tags can be placed both above and below the post title. Drag and Drop them to adjust them.', 'swift' ), '<strong>', '</strong>' ),
		'datatype' => 'none' );


$swift_options_init[] = array( 'name' => __( 'Single page, above title', 'swift' ),
		'desc' => __( 'Set the meta line to be displayed above title', 'swift' ),
		'id' => 'single_above_title',
		'default' => array( 'text', __( 'posted on&nbsp;', 'swift' ).' ', 'date', 'text', ' '.__( 'by&nbsp;', 'swift' ), 'author' ),
		'type' => 'sortable',
		'options' => array( 'text', 'author', 'tags', 'categories', 'date' ),
		'datatype' => 'sortable' );

$swift_options_init[] = array( 'name' => __( 'Single page, below title', 'swift' ),
		'desc' => __( 'Set the meta line to be displayed below title', 'swift' ),
		'id' => 'single_below_title',
		'default' => array( 'text', __( 'Filed under&nbsp;', 'swift' ).' ', 'categories' ),
		'type' => 'sortable',
		'options' => array( 'text', 'author', 'tags', 'categories', 'date' ),
		'datatype' => 'sortable' );

$swift_options_init[] = array( 'type' => 'close',
		'datatype' => 'none' ); // Closing post-meta


$swift_options_init[] = array( 'name' => __( 'Ad management', 'swift' ),
		'id' => 'ad-management',
		'type' => 'heading',
		'datatype' => 'none' );


$swift_options_init[] = array( 'name' => __( 'SwiftThemes.Com affiliate ID', 'swift' ),
		'desc' => __( 'Enter your affiliate ID to include your affiliate link in footer. (The number after r= in your affiliate link is the affiliate ID.)', 'swift' ),
		'id' => 'affiliate_id',
		'default' => '2078',
		'type' => 'text',
		'datatype' => 'text' );

$swift_options_init[] = array( 'name' => __( 'Ad management explanation', 'swift' ),
		'id' => 'ad-management-explanation',
		'type' => 'explain',
		'desc' => __( 'Use the options below to display ads in different locations on your site. You can add ads from any ad network, and any number of ads in a given location.', 'swift' ).'<br /><br />'.
		sprintf( __( 'To add ads to the sidebar and footer, use %sone of the several text widgets provided with Swift%s.', 'swift'), '<strong>', '</strong>' ),
		'datatype' => 'none' );

$swift_options_init[] = array(  'name' => __('Ad Code for responsive layouts', 'swift' ),
		'desc' => __('Rigid sizes of Ads break the responsive layout. Here you can enter the Ad code for smaller Ads, this will be used in place of below nav ad, below title, and after post content', 'swift' ),
		'id' => 'ads_for_mobile',
		'type' => 'textarea',
		'default' => '',
		'datatype' => 'javascript');


$swift_options_init[] = array(  'name' => __('Enable the ad area above the header', 'swift' ),
		'desc' => __('Check this box and enter the ad code below to display an advertisement above the top navigation', 'swift' ),
		'id' => 'above_header_ad_enable',
		'type' => 'checkbox',
		'default' => false,
		'datatype' => 'bool');

$swift_options_init[] = array(    'name' => __('Ad Code', 'swift' ),
		'desc' => __('Enter your ad code here, preferably 468*60 ad', 'swift' ),
		'id' => 'above_header_ad',
		'type' => 'textarea',
		'default' => '',
		'datatype' => 'javascript');

$swift_options_init[] = array(  'name' => __('Enable the header ad area', 'swift' ),
		'desc' => __('Check this box and enter the ad code below to display an advertisement next to the blog name/logo.', 'swift' ),
		'id' => 'header_ad_enable',
		'type' => 'checkbox',
		'default' => false,
		'datatype' => 'bool');

$swift_options_init[] = array(    'name' => __('Ad Code', 'swift' ),
		'desc' => __('Enter your ad code here, preferably 468*60 ad', 'swift' ),
		'id' => 'header_ad',
		'type' => 'textarea',
		'default' => '',
		'datatype' => 'javascript');


$swift_options_init[] = array(  'name' => __('Enable the ad area below the bottom navigation', 'swift' ),
		'desc' => __('Check this box and enter the ad code below to display an advertisement below the bottom navigation.', 'swift' ),
		'id' => 'nav_ad_enable',
		'type' => 'checkbox',
		'default' => false,
		'datatype' => 'bool');

$swift_options_init[] = array(    'name' => __('Ad Code', 'swift' ),
		'desc' => __('Enter your ad code here, preferably a 728*15 link list unit, or a 728*90 lead-board ad.', 'swift' ),
		'id' => 'nav_ad',
		'type' => 'textarea',
		'default' => '',
		'datatype' => 'javascript');


$swift_options_init[] = array(  'name' => __('Enable the ad area below title on single post page', 'swift' ),
		'desc' => __('Check this box and enter the ad code below to display an advertisement below the post title on single post pages.', 'swift' ),
		'id' => 'before_content_ad_enable',
		'type' => 'checkbox',
		'default' => false,
		'datatype' => 'bool');

$swift_options_init[] = array(    'name' => __('Ad Code', 'swift' ),
		'desc' => __('Enter your ad code here, preferably a 468*60 ad to be displayed between the post\'s title and content, or a 120*600 skyscraper ad float-positioned to the left or the right of the post content. To float a skyscraper ad surround the ad code like this: &lt;div style=\'float: left; clear: left; margin: 0px 10px 10px 0px;\'&gt;AD CODE HERE&lt;/div&gt; or &lt;div style=\'float: right; clear: right; margin: 0px 0px 10px 10px;\'&gt;AD CODE HERE&lt;/div&gt;', 'swift' ),
		'id' => 'before_content_ad',
		'type' => 'textarea',
		'default' => '',
		'datatype' => 'javascript');

$swift_options_init[] = array(  'name' => __('Enable the ad area after first paragraph', 'swift' ),
		'desc' => __('Check this box and enter the ad code below to display an advertisement after the first paragraph single post pages.', 'swift' ),
		'id' => 'after_first_p_ad_enable',
		'type' => 'checkbox',
		'default' => false,
		'datatype' => 'bool');

$swift_options_init[] = array(    'name' => __('Ad Code', 'swift' ),
		'desc' => __('Enter your ad code here, preferably a 468*60 ad to be displayed between the post\'s title and content, or a 120*600 skyscraper ad float-positioned to the left or the right of the post content. To float a skyscraper ad surround the ad code like this: &lt;div style=\'float: left; clear: left; margin: 0px 10px 10px 0px;\'&gt;AD CODE HERE&lt;/div&gt; or &lt;div style=\'float: right; clear: right; margin: 0px 0px 10px 10px;\'&gt;AD CODE HERE&lt;/div&gt;', 'swift' ),
		'id' => 'after_first_p_ad',
		'type' => 'textarea',
		'default' => '',
		'datatype' => 'javascript');


$swift_options_init[] = array(  'name' => __('Enable the ad area between the post content', 'swift' ),
		'desc' => __('Check this box and enter the ad code below to display an advertisement between the post content on single post pages.', 'swift' ),
		'id' => 'between_content_ad_enable',
		'type' => 'checkbox',
		'default' => false,
		'datatype' => 'bool');

$swift_options_init[] = array(    'name' => __('Ad Code', 'swift' ),
		'desc' => __('Enter your ad code here, preferably a 468*60 ad to be displayed between the post\'s content. For best results clear and center it surrounding the ad code like this: &lt;div style=\'clear: both; text-align: center; margin: 10px 0px 0px 0px;\'&gt;AD CODE HERE&lt;/div&gt;', 'swift' ),
		'id' => 'between_content_ad',
		'type' => 'textarea',
		'default' => '',
		'datatype' => 'javascript');


$swift_options_init[] = array(  'name' => __('Enable the ad area below the post text', 'swift' ),
		'desc' => __('Check this box and enter the ad code below to display an advertisement after the post content on single post pages.', 'swift' ),
		'id' => 'after_content_ad_enable',
		'type' => 'checkbox',
		'default' => false,
		'datatype' => 'bool');

$swift_options_init[] = array(    'name' => __('Ad Code', 'swift' ),
		'desc' => __('Enter your ad code here, preferably a 468*60 ad to be displayed after the post\'s content. For best results clear and center it surrounding the ad code like this: &lt;div style=\'clear: both; text-align: center; margin: 10px 0px 0px 0px;\'&gt;AD CODE HERE&lt;/div&gt;', 'swift' ),
		'id' => 'after_content_ad',
		'type' => 'textarea',
		'default' => '',
		'datatype' => 'javascript');

$swift_options_init[] = array(  'name' => __('Enable the ad area above the footer widgets', 'swift' ),
		'desc' => __('Check this box and enter the ad code below to display an advertisement above the footer widgets.', 'swift' ),
		'id' => 'footer_ad_enable',
		'type' => 'checkbox',
		'default' => false,
		'datatype' => 'bool');

$swift_options_init[] = array(    'name' => __('Ad Code', 'swift' ),
		'desc' => __('Enter your ad code here, preferably a 768*90 ad to be displayed above the footer widgets.', 'swift' ),
		'id' => 'footer_ad',
		'type' => 'textarea',
		'default' => '',
		'datatype' => 'javascript');

$swift_options_init[] = array(  'name' => __('Enable the ad area above the images in gallery', 'swift' ),
		'desc' => __('Check this box and enter the ad code below to display an advertisement above the image in image.php template', 'swift' ),
		'id' => 'image_above_ad_enable',
		'type' => 'checkbox',
		'default' => false,
		'datatype' => 'bool');

$swift_options_init[] = array(    'name' => __('Ad Code', 'swift' ),
		'desc' => __('Enter your ad code here, preferably a 768*90 ad to be displayed above the image in image.php template.', 'swift' ),
		'id' => 'image_above_ad',
		'type' => 'textarea',
		'default' => '',
		'datatype' => 'javascript');

$swift_options_init[] = array(  'name' => __('Enable the ad area below the images in gallery', 'swift' ),
		'desc' => __('Check this box and enter the ad code below to display an advertisement below the image in image.php template', 'swift' ),
		'id' => 'image_below_ad_enable',
		'type' => 'checkbox',
		'default' => false,
		'datatype' => 'bool');

$swift_options_init[] = array(    'name' => __('Ad Code', 'swift' ),
		'desc' => __('Enter your ad code here, preferably a 768*90 ad to be displayed below the image in image.php template.', 'swift' ),
		'id' => 'image_below_ad',
		'type' => 'textarea',
		'default' => '',
		'datatype' => 'javascript');

$swift_options_init[] = array( 'type' => 'close',
		'datatype' => 'none' ); // Closing ad-management
/*
$swift_options_init[] = array( 'name' => __( 'NEWS paper layout', 'swift' ),
		'id' => 'np-layout',
		'type' => 'heading',
		'datatype' => 'none' );

$swift_options_init[] = array( 'name' => __( 'NEWS paper setup', 'swift' ),
		'id' => 'np-setup-explanation',
		'type' => 'explain',
		'desc' => '<h3>'.__( 'Setting up the NEWS paper layout', 'swift' ).'</h3>
		<ol>'.
		'<li>'.sprintf( __( 'Create a new blank page, and select the template as "%sNEWS paper layout%s". Publish it.', 'swift' ), '<strong>', '</strong>' ).'</li>
		<li>'.__( 'Create another blank page, say "blog" and publish it.', 'swift' ).'</li>
		<li>'.__( 'Now set each section of the options page up by filling the options below.', 'swift' ).'</li>
		<li>'.sprintf( __( 'You can go to the page created in step 1 and see if everything is coming correctly, %sadjust the number of posts in each section so that there are no uneven gaps%s.', 'swift' ), '<strong>', '</strong>' ).'</li>
		<li>'.sprintf( __( 'Once you are satisfied with the look, go to %1$s, set %2$s to %3$sstatic page%4$s, then select the page you created in step 1 as the new "Front page" and the page you created in step 2 as the new "Posts page".', 'swift'), '<em><a href="options-reading.php">'.__( 'Settings', 'default' ).' &rarr; '.__( 'Reading', 'default' ).'</a></em>', '<strong>'.__( 'Front page displays', 'default' ).'</strong>', '<strong>', '</strong>' ).'</li>
		</ol>',
		'datatype' => 'none' );

$swift_options_init[] = array( 'name' => __('Number of popular posts', 'swift' ),
		'desc' => __('Select the number of popular posts to be displayed to the left of the slider.', 'swift' ),
		'id' => 'np_popular_posts_number',
		'default' => 6,
		'type' => 'select',
		'options' => array( 1=>1, 2=>2, 3=>3, 4=>4, 5=>5, 6=>6, 7=>7, 8=>8, 9=>9, 10=>10, 11=>11, 12=>12, 13=>13, 14=>14, 15=>15, 16=>16, 17=>17, 18=>18, 19=>19, 20=>20),
		'datatype' => 'predefined' );

$swift_options_init[] = array( 'name' => __('Popular posts title', 'swift' ),
		'desc' => __('Enter a title for the popular posts displayed on the left of the slider', 'swift' ),
		'id' => 'np_popular_posts_title',
		'default' => __('Popular this month', 'swift' ),
		'type' => 'text',
		'datatype' => 'text' );

$swift_options_init[] = array( 'name' => __('Show popular posts from last X days', 'swift' ),
		'desc' => __('Enter the value of X above', 'swift' ),
		'id' => 'np_popular_posts_age',
		'default' => '30',
		'type' => 'text',
		'datatype' => 'int' );


$swift_options_init[] = array( 'name' => __('Number of posts in slider', 'swift' ),
		'desc' => __('Select the number of featured posts to be displayed in the slider.', 'swift' ),
		'id' => 'np_slider_posts_number',
		'default' => 3,
		'type' => 'select',
		'options' => array( 1=>1, 2=>2, 3=>3, 4=>4, 5=>5, 6=>6, 7=>7, 8=>8, 9=>9, 10=>10, 11=>11, 12=>12, 13=>13, 14=>14, 15=>15, 16=>16, 17=>17, 18=>18, 19=>19, 20=>20),
		'datatype' => 'int' );

$swift_options_init[] = array( 'name' => __('Number of posts below slider', 'swift' ),
		'desc' => __('Select the number of featured posts to be displayed below the slider.', 'swift' ),
		'id' => 'np_slider_below_posts_number',
		'default' => 2,
		'type' => 'select',
		'options' => array( 1=>1, 2=>2, 3=>3, 4=>4, 5=>5, 6=>6, 7=>7, 8=>8, 9=>9, 10=>10, 11=>11, 12=>12, 13=>13, 14=>14, 15=>15, 16=>16, 17=>17, 18=>18, 19=>19, 20=>20),
		'datatype' => 'int' );

$swift_options_init[] = array( 'name' => __('Title for posts below slider', 'swift' ),
		'desc' => __('Enter a title for the posts displayed below the slider', 'swift' ),
		'id' => 'np_slider_below_title',
		'default' => __('Random posts', 'swift' ),
		'type' => 'text',
		'datatype' => 'text' );

$swift_options_init[] = array( 'name' => __('Title for posts adjacent to slider', 'swift' ),
		'desc' => __('Enter a title for the posts displayed adjacent to the slider', 'swift' ),
		'id' => 'np_adjacent_slider_title',
		'default' => __('Recent posts', 'swift' ),
		'type' => 'text',
		'datatype' => 'text' );

$swift_options_init[] = array( 'name' => __('Number of posts adjacent to slider', 'swift' ),
		'desc' => __('Select the number of posts to be displayed adjacent to the slider.', 'swift' ),
		'id' => 'np_slider_adjacent_posts_number',
		'default' => 5,
		'type' => 'select',
		'options' => array( 1=>1, 2=>2, 3=>3, 4=>4, 5=>5, 6=>6, 7=>7, 8=>8, 9=>9, 10=>10, 11=>11, 12=>12, 13=>13, 14=>14, 15=>15, 16=>16, 17=>17, 18=>18, 19=>19, 20=>20),
		'datatype' => 'int' );

$swift_options_init[] = array(  'name' => __('Enable the ad area above tabbed posts', 'swift' ),
		'desc' => __('Check this box and enter the ad code below to display an advertisement above the tabbed posts.', 'swift' ),
		'id' => 'np_above_tabbed_posts_ad_enable',
		'type' => 'checkbox',
		'default' => false,
		'datatype' => 'bool');

$swift_options_init[] = array(    'name' => __('Ad Code', 'swift' ),
		'desc' => __('Enter your ad code here, preferably a 768*90 ad to be displayed above the tabbed posts.', 'swift' ),
		'id' => 'np_above_tabbed_posts_ad',
		'type' => 'textarea',
		'default' => '',
		'datatype' => 'javascript');

$swift_options_init[] = array( 'type' => 'clear',
		'datatype' => 'none' );


$swift_options_init[] = array( 'name' => __( 'NEWS paper setup', 'swift' ),
		'id' => 'np-setup-explanation',
		'type' => 'explain',
		'desc' => sprintf( __( 'Here you can configure which posts are displayed in the NEWS paper layout. Simply %sDrag and Drop%s the category you want in the specified location. %sRandom posts%s and %sRecent posts%s should not be combined with any other categories. They can only be used in the area under and to the right of the slider.', 'swift' ), '<strong>', '</strong>', '<strong>', '</strong>', '<strong>', '</strong>' ).'<br /><br />'.
		sprintf( __( '%sNote%s: Number of posts in each category or shown along with the name for your reference.', 'swift' ), '<strong>', '</strong>' ),
		'datatype' => 'none' );

$swift_options_init[] = array( 'name' => __( 'Slider posts categories', 'swift' ),
		'id' => 'np_slider_cats',
		'type' => 'np-setup',
		'default' => '',
		'datatype' => 'text' );


$swift_options_init[] = array( 'name' => __( 'Posts below slider', 'swift' ),
		'id' => 'np_slider_below_cats',
		'type' => 'np-setup',
		'default' => '',
		'datatype' => 'text' );

$swift_options_init[] = array( 'name' => __( 'Posts adjacent to slider', 'swift' ),
		'id' => 'np_slider_adjacent_cats',
		'type' => 'np-setup',
		'default' => '',
		'datatype' => 'text' );

$swift_options_init[] = array( 'name' => __( 'Posts in tabbed format', 'swift' ),
		'id' => 'np_tabbed_cats',
		'type' => 'np-setup',
		'default' => '',
		'datatype' => 'sortable_array' );

$swift_options_init[] = array( 'name' => __( 'Posts in mag format', 'swift' ),
		'id' => 'np_mag_cats',
		'type' => 'np-setup',
		'default' => '',
		'datatype' => 'sortable_array' );

$swift_options_init[] = array( 'name' => __( 'NEWS paper layout', 'swift' ),
		'id' => 'cat-base',
		'type' => 'cat_base',
		'default' => '',
		'datatype' => 'none' );

$swift_options_init[] = array( 'type' => 'close',
		'datatype' => 'none' ); // Closing News paper layout


$swift_options_init[] = array( 'name' => __( 'NEWS paper layout 2', 'swift' ),
		'id' => 'np2-layout',
		'type' => 'heading',
		'datatype' => 'none' );
$swift_options_init[] = array( 'name' => __( 'NEWS paper setup', 'swift' ),
		'id' => 'np2-setup-explanation',
		'type' => 'explain',
		'desc' => '<h3>'.__( 'Setting up the NEWS paper layout', 'swift' ).'</h3>
		<ol>'.
		'<li>'.__('This news paper layout is designed for site width 1102px, setting site width to anyting other than this is not advisable','swift').
		'<li>'.sprintf( __( 'Create a new blank page, and select the template as "%sNEWS paper layout 2%s". Publish it.', 'swift' ), '<strong>', '</strong>' ).'</li>
		<li>'.__( 'Create another blank page, say "blog" and publish it.', 'swift' ).'</li>
		<li>'.__( 'Now set each section of the options page up by filling the options below.', 'swift' ).'</li>
		<li>'.sprintf( __( 'You can go to the page created in step 1 and see if everything is coming correctly, %sadjust the number of posts in each section so that there are no uneven gaps%s.', 'swift' ), '<strong>', '</strong>' ).'</li>
		<li>'.sprintf( __( 'Once you are satisfied with the look, go to %1$s, set %2$s to %3$sstatic page%4$s, then select the page you created in step 1 as the new "Front page" and the page you created in step 2 as the new "Posts page".', 'swift'), '<em><a href="options-reading.php">'.__( 'Settings', 'default' ).' &rarr; '.__( 'Reading', 'default' ).'</a></em>', '<strong>'.__( 'Front page displays', 'default' ).'</strong>', '<strong>', '</strong>' ).'</li>
		</ol>',
		'datatype' => 'none' );

$swift_options_init[] = array(  'name' => __('Enable the ad area below the slider', 'swift' ),
		'desc' => __('Check this box and enter the ad code below to display an advertisement below the sldier', 'swift' ),
		'id' => 'np2_below_slider_ad_enable',
		'type' => 'checkbox',
		'default' => false,
		'datatype' => 'bool');

$swift_options_init[] = array(    'name' => __('Ad Code', 'swift' ),
		'desc' => __('Enter your ad code here, preferably 760*90px ad', 'swift' ),
		'id' => 'np2_below_slider_ad',
		'type' => 'textarea',
		'default' => '',
		'datatype' => 'javascript');

$swift_options_init[] = array(  'name' => __('Enable the ad area above the filmstrip', 'swift' ),
		'desc' => __('Check this box and enter the ad code below to display an advertisement above the film strip', 'swift' ),
		'id' => 'np2_above_fs2_ad_enable',
		'type' => 'checkbox',
		'default' => false,
		'datatype' => 'bool');

$swift_options_init[] = array(    'name' => __('Ad Code', 'swift' ),
		'desc' => __('Enter your ad code here, preferably 760*90px ad', 'swift' ),
		'id' => 'np2_above_fs2_ad',
		'type' => 'textarea',
		'default' => '',
		'datatype' => 'javascript');

$swift_options_init[] = array( 'name' => __( 'For slider', 'swift' ),
		'id' => 'np2_slider_cats',
		'type' => 'np-setup',
		'default' => '',
		'datatype' => 'sortable_array' );

$swift_options_init[] = array( 'name' => __( 'For mosaic adjacent to slider', 'swift' ),
		'id' => 'np2_mosaic_slider_adjacent',
		'type' => 'np-setup',
		'default' => '',
		'datatype' => 'sortable_array' );

$swift_options_init[] = array( 'name' => __( 'For film strip', 'swift' ),
		'id' => 'np2_fs_1',
		'type' => 'np-setup',
		'default' => '',
		'datatype' => 'sortable_array' );


$swift_options_init[] = array( 'name' => __( 'For mag columns', 'swift' ),
		'id' => 'np2_mag_cats',
		'type' => 'np-setup',
		'default' => '',
		'datatype' => 'sortable_array' );

$swift_options_init[] = array( 'name' => __( 'NEWS paper layout', 'swift' ),
		'id' => 'cat-base',
		'type' => 'cat_base',
		'default' => '',
		'datatype' => 'none' );

$swift_options_init[] = array( 'type' => 'close',
		'datatype' => 'none' ); // Closing ad-management

*/
$swift_options_init[] = array( 'name' => __( 'Social media', 'swift' ),
		'id' => 'social-media',
		'type' => 'heading',
		'datatype' => 'none');


$swift_options_init[] = array( 'name' => __('Feedburner ID', 'swift' ),
		'desc' => sprintf( __('Enter your Feedburner ID. If your Feedburner URL is http://feeds.feedburner.com/SwiftThemes, then your feed ID is %sSwiftThemes%s.', 'swift' ), '<strong>', '</strong>' ),
		'id' => 'feedburnerid',
		'default' => '',
		'type' => 'text',
		'datatype' => 'text' );

$swift_options_init[] = array( 'name' => __('Twitter', 'swift' ),
		'desc' => sprintf( __('Enter your Twitter user name (without the \'@\'). Example: %sswiftthemes%s.', 'swift' ), '<strong>', '</strong>' ),
		'id' => 'sm_twitter',
		'default' => '',
		'type' => 'text',
		'datatype' => 'text' );

$swift_options_init[] = array( 'name' => __( 'Google +1', 'swift' ),
		'desc' => sprintf( __('URL of the page that will receive +1 clicks. This is usually your home page. Example: %shttp://swiftthemes.com%s.', 'swift' ), '<strong>', '</strong>' ),
		'id' => 'sm_gplus',
		'default' => '',
		'type' => 'text',
		'datatype' => 'url' );

$swift_options_init[] = array( 'name' => __('Facebook Page ID', 'swift' ),
		'desc' => sprintf( __('Enter your Facebook Page ID. If your Facebook Page is https://www.facebook.com/SwiftThemes, then your Page ID is %sSwiftThemes%s.', 'swift' ), '<strong>', '</strong>' ),
		'id' => 'sm_fb_page_id',
		'default' => '',
		'type' => 'text',
		'datatype' => 'text' );
$swift_options_init[] = array( 'type' => 'close',
		'datatype' => 'none' ); // Social media