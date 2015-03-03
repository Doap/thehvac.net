<?php
/**
 * The Theme Options page
 *
 * This page is implemented using the Settings API
 * http://codex.wordpress.org/Settings_API
 * Big thanks to Chip Bennett for the great article on how to implement the Settings API
 * http://www.chipbennett.net/2011/02/17/incorporating-the-settings-api-in-wordpress-themes/
 * 
 * @file      theme-options.php
 * @package   Max-Mag
 * @author    Sami Ch.
 * @link 	  http://gazpo.com
 */

 /**
 * Properly enqueue styles and scripts for our theme options page.
 *
 * This function is attached to the admin_enqueue_scripts action hook.
 *
 * @since Twenty Eleven 1.0
 *
 */
 
function max_magazine_admin_enqueue_scripts( $hook_suffix ) {
	wp_enqueue_style( 'max_magazine_theme_options', get_template_directory_uri() . '/settings/theme-options.css', false, '1.0' );
	wp_enqueue_script( 'max_magazine_theme_options', get_template_directory_uri() . '/settings/theme-options.js', array( 'jquery' ), '1.0' );
}
add_action( 'admin_print_styles-appearance_page_theme_options', 'max_magazine_admin_enqueue_scripts' );


global $pagenow;
if( ( 'themes.php' == $pagenow ) && ( isset( $_GET['activated'] ) && ( $_GET['activated'] == 'true' ) ) ) :


/**
 * Set default options on activation
 */
function max_magazine_init_options() {
	$options = get_option( 'max_magazine_options' );
	if ( false === $options ) {
		$options = max_magazine_default_options();
	}
	update_option( 'max_magazine_options', $options );
}

add_action( 'after_setup_theme', 'max_magazine_init_options', 9 );
endif;

/**
 * Register the theme options setting
 */
function max_magazine_register_settings() {
	register_setting( 'max_magazine_options', 'max_magazine_options', 'max_magazine_validate_options' );	
}
add_action( 'admin_init', 'max_magazine_register_settings' );

/**
 * Register the options page
 */
function max_magazine_theme_add_page() {
	add_theme_page( __( 'Theme Options', 'max-magazine' ), __( 'Theme Options', 'max-magazine' ), 'edit_theme_options', 'theme_options', 'max_magazine_theme_options_page' );
}
add_action( 'admin_menu', 'max_magazine_theme_add_page');

/**
 * Set custom RSS feed links.
 *
 */
function max_magazine_custom_feed( $output, $feed ) {
	$options = get_option('max_magazine_options');
	$url = $options['rss_url'];	
	if ( $url ) {
		$outputarray = array( 'rss' => $url, 'rss2' => $url, 'atom' => $url, 'rdf' => $url, 'comments_rss2' => '' );
		$outputarray[$feed] = $url;
		$output = $outputarray[$feed];
	}
	return $output;
}
add_filter( 'feed_link', 'max_magazine_custom_feed', 1, 2 );

/**
 * Set custom Favicon.
 *
 */
function max_magazine_custom_favicon() {
	$options = get_option('max_magazine_options');
	$favicon_url = $options['favicon_url'];	
	
    if (!empty($favicon_url)) {
		echo '<link rel="shortcut icon" href="'. $favicon_url. '" />	'. "\n";
	}
}

add_action('wp_head', 'max_magazine_custom_favicon');

/**
 * Set custom CSS.
 *
 */
function max_magazine_inline_css() {
    $options = get_option('max_magazine_options');
	$inline_css = $options['inline_css'];
    if (!empty($inline_css)) {
		echo '<!-- Custom CSS Styles -->' . "\n";
        echo '<style type="text/css" media="screen">' . "\n";
		echo $inline_css . "\n";
		echo '</style>' . "\n";
	}
}
add_action('wp_head', 'max_magazine_inline_css');


/**
 * Add tracking code in the footer.
 *
 */
function max_magazine_stats_tracker() {
    $options = get_option('max_magazine_options');
	$stats_tracker = $options['stats_tracker'];
    if (!empty($stats_tracker)) {
        echo $stats_tracker;
	}
}
add_action('wp_footer', 'max_magazine_stats_tracker');

/**
 * Set meta description.
 *
 */
function max_magazine_meta_desc() {
    $options = get_option('max_magazine_options');
	$meta_desc = $options['meta_desc'];
    
	if (!empty($meta_desc)) {
		echo '<meta name="description" content=" '. $meta_desc .'"  />' . "\n";
	}
}
add_action('wp_head', 'max_magazine_meta_desc');


/**
 * Set Google site verfication code
 *
 */
function max_magazine_google_verification() {
    $options = get_option('max_magazine_options');
	$google_verification = $options['google_verification'];
   
   if (!empty($google_verification)) {
		echo '<meta name="google-site-verification" content="' . $google_verification . '" />' . "\n";
	}
}
add_action('wp_head', 'max_magazine_google_verification');


/**
 * Set Bing site verfication code
 *
 */
function max_magazine_bing_verification() {	
    $options = get_option('max_magazine_options');
	$bing_verification = $options['bing_verification'];	
	
    if (!empty($bing_verification)) {
        echo '<meta name="msvalidate.01" content="' . $bing_verification . '" />' . "\n";
	}
}
add_action('wp_head', 'max_magazine_bing_verification');


/**
 * Output the options page
 */
function max_magazine_theme_options_page() { ?>
	
	<div id="gazpo-admin" class="wrap"> 		
			<div class="header">	
				<div class="gazpo-logo">
					<a href="<?php echo esc_url(__('http://gazpo.com/', 'max-magazine')); ?>" title="<?php _e('Visit gazpo.com', 'max-magazine'); ?>" target="_blank">
						<img src="<?php echo get_template_directory_uri(); ?>/settings/images/logo.png" alt="gazpo.com" />
					</a>
				</div>	
				
				<div class="theme-info">		
					<h3>Max Responsive Theme</h3>			
					<ul>
						<li class="docs">
							<a href="<?php echo esc_url(__('http://gazpo.com/2012/07/max', 'max-magazine')); ?>" title="<?php _e('Theme Support', 'max-magazine'); ?>" target="_blank"><?php printf(__('Theme Support', 'max-magazine')); ?></a>
						</li>
						
						<li class="support">
							<a href="<?php echo esc_url(__('http://gazpo.com/contact/', 'max-magazine')); ?>" title="<?php _e('Contact', 'max-magazine'); ?>" target="_blank"><?php printf(__('Contact', 'max-magazine')); ?></a>
						</li>				
					</ul>
				</div>
			</div><!-- /header -->
			
			<div class="options-form">
			
				<?php $theme_name = function_exists('wp_get_theme') ? wp_get_theme() : ''; ?>
				<?php screen_icon(); echo "<h2>" . $theme_name ." ". __('Theme Options', 'max-magazine') . "</h2>"; ?>
					
					<?php if ( isset( $_GET['settings-updated'] ) ) : ?>
						<div class="updated fade"><p><?php _e('Theme settings updated successfully', 'max-magazine'); ?></p></div>
					<?php endif; ?>
				
					<form action="options.php" method="post">
						
						<?php settings_fields( 'max_magazine_options' ); ?>
						<?php $options = get_option('max_magazine_options'); ?>		
			
						<div class="options_blocks">
					
					<h3 class="block_title"><a href="#"><?php _e('Homepage Settings', 'max-magazine'); ?></a></h3>
					<div class="block">
											 
						<div class="field">
							<label for="max_magazine_options[logo_url]"><?php _e('Logo URL:', 'max-magazine'); ?></label>
							<input id="max_magazine_options[logo_url]" name="max_magazine_options[logo_url]" type="text" value="<?php echo esc_attr($options['logo_url']); ?>" />
							
							<span><?php _e( 'Enter full URL of logo image starting with <strong>http:// </strong>.', 'max-magazine' ); ?></span>
						</div>
						
						<div class="field">
							<label for="max_magazine_options[favicon_url]"><?php _e('Favicon URL', 'max-magazine'); ?></label>
							<input id="max_magazine_options[favicon_url]" name="max_magazine_options[favicon_url]" type="text" value="<?php echo esc_attr($options['favicon_url']); ?>" />
							
							<span><?php _e( 'Enter full URL of favicon image starting with <strong>http:// </strong>.', 'max-magazine' ); ?></span>
						</div>
						
						<div class="field">
							<label for="max_magazine_options[rss_url]"><?php _e('Custom RSS URL', 'max-magazine'); ?></label>
							<input id="max_magazine_options[rss_url]" name="max_magazine_options[rss_url]" type="text" value="<?php echo esc_attr($options['rss_url']); ?>" />
							<span><?php _e( 'Enter full URL of RSS Feeds link starting with <strong>http:// </strong>. Leave blank to use default RSS Feeds.', 'max-magazine' ); ?></span>
						</div>
						
						<div class="field">
							<label for="max_magazine_options[show_slider]"><?php _e('Enable Slider', 'max-magazine'); ?></label>
							<input id="max_magazine_options[show_slider]" name="max_magazine_options[show_slider]" type="checkbox" value="1" <?php isset($options['show_slider']) ? checked( '1', $options['show_slider'] ) : checked('0', '1'); ?> />							
							<span><?php _e( 'Check to enable the slider on homepage.', 'max-magazine' ); ?></span>
						</div>
						
						<div class="field">														
							<label for="max_magazine_options[slider_category]"><?php _e('Slider Category', 'max-magazine'); ?></label>
							<?php 
							$categories = get_categories( array( 'hide_empty' => 1, 'hierarchical' => 0 ) );  ?>
							<select id="slider_category" name="max_magazine_options[slider_category]">
								<option <?php selected( 0 == $options['slider_category'] ); ?> value="0"><?php _e( '--none--', 'max-magazine' ); ?></option>
								<?php foreach( $categories as $category ) : ?>
								<option <?php selected( $category->term_id == $options['slider_category'] ); ?> value="<?php echo $category->term_id; ?>"><?php echo $category->cat_name; ?></option>
								<?php endforeach; ?>
							</select>						
							 <span><?php _e( 'Select the category for the slider. Select <strong>none</strong> to show latest posts.', 'max-magazine' ); ?></span>					
						</div>
						
						<div class="field">
							<label for="max_magazine_options[show_carousel]"><?php _e('Enable Carousel', 'max-magazine'); ?></label>
							<input id="max_magazine_options[show_carousel]" name="max_magazine_options[show_carousel]" type="checkbox" value="1" <?php isset($options['show_carousel']) ? checked( '1', $options['show_carousel'] ) : checked('0', '1'); ?> />
							<span><?php _e( 'Check to enable the carousel on homepage.', 'max-magazine' ); ?></span>					
						</div>
	
						<div class="field">														
							<label for="max_magazine_options[carousel_category]"><?php _e('Carousel Category', 'max-magazine'); ?></label>
							<?php 
							$categories = get_categories( array( 'hide_empty' => 1, 'hierarchical' => 0 ) );  ?>
							<select id="carousel_category" name="max_magazine_options[carousel_category]">
								<option <?php selected( 0 == $options['carousel_category'] ); ?> value="0"><?php _e( '--none--', 'max-magazine' ); ?></option>
								<?php foreach( $categories as $category ) : ?>
								<option <?php selected( $category->term_id == $options['carousel_category'] ); ?> value="<?php echo $category->term_id; ?>"><?php echo $category->cat_name; ?></option>
								<?php endforeach; ?>
							</select>						
							 <span><?php _e( 'Select the category for the carousel. Select <strong>none</strong> to show latest posts.', 'max-magazine' ); ?></span>				
						</div>	

						<div class="field">
							<label for="max_magazine_options[show_feat_cats]"><?php _e('Enable Featured Categories', 'max-magazine'); ?></label>
							<input id="max_magazine_options[show_feat_cats]" name="max_magazine_options[show_feat_cats]" type="checkbox" value="1" <?php isset($options['show_feat_cats']) ? checked( '1', $options['show_feat_cats'] ) : checked('0', '1'); ?> />
							 
							<span><?php _e( 'Check to enable the featured categories.', 'max-magazine' ); ?></span>
						</div>
						
						<div class="field">														
							<label for="max_magazine_options[feat_cat1]"><?php _e('Featured Category 1', 'max-magazine'); ?></label>
							<?php 
							$categories = get_categories( array( 'hide_empty' => 1, 'hierarchical' => 0 ) );  ?>
							<select id="feat_cat1" name="max_magazine_options[feat_cat1]">
								<option <?php selected( 0 == $options['feat_cat1'] ); ?> value="0"><?php _e( '--none--', 'max-magazine' ); ?></option>
								<?php foreach( $categories as $category ) : ?>
								<option <?php selected( $category->term_id == $options['feat_cat1'] ); ?> value="<?php echo $category->term_id; ?>"><?php echo $category->cat_name; ?></option>
								<?php endforeach; ?>
							</select>						
							<span><?php _e( 'Select the first featured category.', 'max-magazine' ); ?></span>				
						</div>	
						
						<div class="field">														
							<label for="max_magazine_options[feat_cat2]"><?php _e('Featured Category 2', 'max-magazine'); ?></label>
							<?php 
							$categories = get_categories( array( 'hide_empty' => 1, 'hierarchical' => 0 ) );  ?>
							<select id="feat_cat2" name="max_magazine_options[feat_cat2]">
								<option <?php selected( 0 == $options['feat_cat2'] ); ?> value="0"><?php _e( '--none--', 'max-magazine' ); ?></option>
								<?php foreach( $categories as $category ) : ?>
								<option <?php selected( $category->term_id == $options['feat_cat2'] ); ?> value="<?php echo $category->term_id; ?>"><?php echo $category->cat_name; ?></option>
								<?php endforeach; ?>
							</select>						
							<span><?php _e( 'Select the second featured category.', 'max-magazine' ); ?></span>				
						</div>
						
						<div class="field">														
							<label for="max_magazine_options[feat_cat3]"><?php _e('Featured Category 3', 'max-magazine'); ?></label>
							<?php 
							$categories = get_categories( array( 'hide_empty' => 1, 'hierarchical' => 0 ) );  ?>
							<select id="feat_cat3" name="max_magazine_options[feat_cat3]">
								<option <?php selected( 0 == $options['feat_cat3'] ); ?> value="0"><?php _e( '--none--', 'max-magazine' ); ?></option>
								<?php foreach( $categories as $category ) : ?>
								<option <?php selected( $category->term_id == $options['feat_cat3'] ); ?> value="<?php echo $category->term_id; ?>"><?php echo $category->cat_name; ?></option>
								<?php endforeach; ?>
							</select>						
							<span><?php _e( 'Select the third featured category.', 'max-magazine' ); ?></span>				
						</div>
						
						<div class="field">														
							<label for="max_magazine_options[feat_cat4]"><?php _e('Featured Category 4', 'max-magazine'); ?></label>
							<?php 
							$categories = get_categories( array( 'hide_empty' => 1, 'hierarchical' => 0 ) );  ?>
							<select id="feat_cat4" name="max_magazine_options[feat_cat4]">
								<option <?php selected( 0 == $options['feat_cat4'] ); ?> value="0"><?php _e( '--none--', 'max-magazine' ); ?></option>
								<?php foreach( $categories as $category ) : ?>
								<option <?php selected( $category->term_id == $options['feat_cat4'] ); ?> value="<?php echo $category->term_id; ?>"><?php echo $category->cat_name; ?></option>
								<?php endforeach; ?>
							</select>						
							<span><?php _e( 'Select the forth featured category.', 'max-magazine' ); ?></span>				
						</div>
						
						<div class="field">
							<label for="max_magazine_options[show_posts_list]"><?php _e('Latest Posts List', 'max-magazine'); ?></label>
							<input id="max_magazine_options[show_posts_list]" name="max_magazine_options[show_posts_list]" type="checkbox" value="1" <?php isset($options['show_posts_list']) ? checked( '1', $options['show_posts_list'] ) : checked('0', '1'); ?> />
							<span><?php _e( 'Check to show latest posts list on homepage.', 'max-magazine' ); ?></span>
						</div>
						
						<div class="submit">
							<input type="submit" name="max_magazine_options[submit]" class="button-primary" value="<?php _e( 'Save Settings', 'max-magazine' ); ?>" />
                        </div>
						
					</div><!-- /block -->
					
					<h3 class="block_title"><a href="#"><?php _e('Post and Page Settings', 'max-magazine'); ?></a></h3>
					<div class="block">
						
						<div class="field">
							<label for="max_magazine_options[show_author]"><?php _e('Display Author Info', 'max-magazine'); ?></label>
							 <input id="max_magazine_options[show_author]" name="max_magazine_options[show_author]" type="checkbox" value="1" <?php isset($options['show_author']) ? checked( '1', $options['show_author'] ) : checked('0', '1'); ?> />
							<span><?php _e( 'Check to display the author information in the post.', 'max-magazine' ); ?></span>
						</div>
						
						<div class="field">
							<label for="max_magazine_options[show_page_comments]"><?php _e('Enable comments on pages', 'max-magazine'); ?></label>
							 <input id="max_magazine_options[show_page_comments]" name="max_magazine_options[show_page_comments]" type="checkbox" value="1" <?php isset($options['show_page_comments']) ? checked( '1', $options['show_page_comments'] ) : checked('0', '1'); ?> />
							<span><?php _e( 'Check to enable the comments on pages.', 'max-magazine' ); ?></span>
						</div>
						
						<div class="field">
							<label for="max_magazine_options[show_media_comments]"><?php _e('Enable comments on media', 'max-magazine'); ?></label>
							 <input id="max_magazine_options[show_media_comments]" name="max_magazine_options[show_media_comments]" type="checkbox" value="1" <?php isset($options['show_media_comments']) ? checked( '1', $options['show_media_comments'] ) : checked('0', '1'); ?> />
							<span><?php _e( 'Check to enable the comments on media posts.', 'max-magazine' ); ?></span>
						</div>									
						
						<div class="submit">
							<input type="submit" name="max_magazine_options[submit]" class="button-primary" value="<?php _e( 'Save Settings', 'max-magazine' ); ?>" />
                        </div>
					
					</div><!-- /block -->
					
					<h3 class="block_title"><a href="#"><?php _e('Ads and Custom Styles', 'max-magazine'); ?></a></h3>
					<div class="block">
						
						<div class="field">
							<label for="max_magazine_options[ad468]"><?php _e('Header ad code.', 'max-magazine'); ?></label>
							 <textarea id="max_magazine_options[ad468]" class="textarea" cols="50" rows="30" name="max_magazine_options[ad468]"><?php echo esc_attr($options['ad468']); ?></textarea>
							  <span><?php _e( 'Enter complete code for header ad.', 'max-magazine' ); ?></span>							
						</div>
						
						<div class="field">
							<label for="max_magazine_options[inline_css]"><?php _e('Enter your custom CSS styles.', 'max-magazine'); ?></label>
							 <textarea id="max_magazine_options[inline_css]" class="textarea" cols="50" rows="30" name="max_magazine_options[inline_css]"><?php echo esc_attr($options['inline_css']); ?></textarea>
							 <span><?php _e( 'You can enter custom CSS styles. It will overwrite the default style.', 'max-magazine' ); ?></span>							
						</div>
						
						<div class="submit">
							<input type="submit" name="max_magazine_options[submit]" class="button-primary" value="<?php _e( 'Save Settings', 'max-magazine' ); ?>" />
                        </div>
					
					</div><!-- /block -->
					
					<h3 class="block_title"><a href="#"><?php _e('Webmaster Tools', 'max-magazine'); ?></a></h3>
					<div class="block">
						
						<div class="field">
							<label for="max_magazine_options[meta_desc]"><?php _e('Meta Description', 'max-magazine'); ?></label>
							<textarea id="max_magazine_options[meta_desc]" class="textarea" cols="50" rows="10" name="max_magazine_options[meta_desc]"><?php echo esc_attr($options['meta_desc']); ?></textarea>
							<span><?php _e( 'A short description of your site for the META Description tag. Keep it less than 149 characters.', 'max-magazine' ); ?></span>
						</div>
						
						<div class="field">
							<label for="max_magazine_options[stats_tracker]"><?php _e('Statistics Tracking Code', 'max-magazine'); ?></label>
							<textarea id="max_magazine_options[stats_tracker]" class="textarea" cols="50" rows="10" name="max_magazine_options[stats_tracker]"><?php echo esc_attr($options['stats_tracker']); ?></textarea>
							<span><?php _e( 'If you want to add any tracking code (eg. Google Analytics). It will appear in the header of the theme.', 'max-magazine' ); ?></span>
						</div>
						
						<div class="field">
							<label for="max_magazine_options[google_verification]"><?php _e('Google Site Verification', 'max-magazine'); ?></label>
							<input id="max_magazine_options[google_verification]" type="text" name="max_magazine_options[google_verification]" value="<?php echo esc_attr($options['google_verification']); ?>" />
							<span><?php _e( 'Enter your ID only.', 'max-magazine' ); ?></span>
						</div>
						
						<div class="field">
							<label for="max_magazine_options[bing_verification]"><?php _e('Bing Site Verification', 'max-magazine'); ?></label>
							<input id="max_magazine_options[bing_verification]" type="text" name="max_magazine_options[bing_verification]" value="<?php echo esc_attr($options['bing_verification']); ?>" />
							<span><?php _e( 'Enter the ID only. <strong>Yahoo</strong> search is powered by Bing, so it will be automatically verified by Yahoo as well.', 'max-magazine' ); ?></span>
						</div>
						
						<div class="submit">
							<input type="submit" name="max_magazine_options[submit]" class="button-primary" value="<?php _e( 'Save Settings', 'max-magazine' ); ?>" />
                        </div>						
						
					</div><!-- /block -->
					
					<h3 class="support_title"><?php _e('Support us', 'max-magazine'); ?></h3>
					<div class="support-block">
						<div class="field">
							<p><strong><?php _e('Did you like this theme?', 'max-magazine') ?></strong></p>
							<p><?php _e( 'Please consider making a small donation to support our continued WordPress theme development. It takes real time and money to develop themes and make them available for free.', 'max-magazine' ); ?></p>	
							<p>
								<a href="<?php echo esc_url(__('http://gazpo.com/donate', 'max-magazine')); ?>" title="<?php _e('Visit gazpo.com', 'max-magazine'); ?>" target="_blank">
									Link for the donation.
								</a>								
							</p>
							
						</div>
					</div><!-- /block -->			
					
					
				</div> <!-- /option_blocks -->			
						
						<input type="submit" name="max_magazine_options[submit]" class="button-primary" value="<?php _e( 'Save Settings', 'max-magazine' ); ?>" />
						<input type="submit" name="max_magazine_options[reset]" class="button-secondary" value="<?php _e( 'Reset Defaults', 'max-magazine' ); ?>" />
					</form>
		
			</div> <!-- /options-form -->
	</div> <!-- /gazpo-admin -->
	<?php
}

/**
 * Return default array of options
 */
 
function max_magazine_default_options() {
	$options = array(
		'logo_url' => get_template_directory_uri().'/images/logo.png',
		'favicon_url' => '',
		'rss_url' => '',
		'show_slider' => 1,
		'slider_category' => 0,
		'show_carousel' => 1,
		'carousel_category'=> 0,
		'show_feat_cats' => 1,
		'feat_cat1'=> 0,
		'feat_cat2'=> 0,
		'feat_cat3'=> 0,
		'feat_cat4'=> 0,
		'show_posts_list' => 1,
		'show_author' => 1,
		'show_page_comments' => 1,
		'show_media_comments' => 1,
		'ad468' => '<a href='.get_site_url().'><img src='.get_template_directory_uri().'/images/ad468.png /></a>',
		'inline_css' => '',
		'meta_desc' => '',
		'stats_tracker' => '',
		'google_verification' => '',
		'bing_verification' => '',
	);
	return $options;
}

/**
 * Sanitize and validate options
 */
function max_magazine_validate_options( $input ) {
	$submit = ( ! empty( $input['submit'] ) ? true : false );
	$reset = ( ! empty( $input['reset'] ) ? true : false );
	if( $submit ) :
	
		$input['logo_url'] = esc_url_raw($input['logo_url']);
		$input['favicon_url'] = esc_url_raw($input['favicon_url']);
		$input['rss_url'] = esc_url_raw($input['rss_url']);
		
		if ( ! isset( $input['show_slider'] ) )
			$input['show_slider'] = null;
			$input['show_slider'] = ( $input['show_slider'] == 1 ? 1 : 0 );
	
		if ( ! isset( $input['show_carousel'] ) )
			$input['show_carousel'] = null;
			$input['show_carousel'] = ( $input['show_carousel'] == 1 ? 1 : 0 );
		
		if ( ! isset( $input['show_feat_cats'] ) )
			$input['show_feat_cats'] = null;
			$input['show_feat_cats'] = ( $input['show_feat_cats'] == 1 ? 1 : 0 );
	
		if ( ! isset( $input['show_author'] ) )
			$input['show_author'] = null;
			$input['show_author'] = ( $input['show_author'] == 1 ? 1 : 0 );
		
		if ( ! isset( $input['show_page_comments'] ) )
			$input['show_page_comments'] = null;
			$input['show_page_comments'] = ( $input['show_page_comments'] == 1 ? 1 : 0 );
		
		if ( ! isset( $input['show_media_comments'] ) )
			$input['show_media_comments'] = null;
			$input['show_media_comments'] = ( $input['show_media_comments'] == 1 ? 1 : 0 );
		
		if ( ! isset( $input['show_posts_list'] ) )
			$input['show_posts_list'] = null;
			$input['show_posts_list'] = ( $input['show_posts_list'] == 1 ? 1 : 0 );
		
		$input['ad468'] = wp_kses_stripslashes($input['ad468']);
		$input['inline_css'] = wp_kses_stripslashes($input['inline_css']);
		$input['meta_desc'] = wp_kses_stripslashes($input['meta_desc']);
	
		$input['google_verification'] = wp_filter_post_kses($input['google_verification']);
		$input['bing_verification'] = wp_filter_post_kses($input['bing_verification']);
	
		$input['stats_tracker'] = wp_kses_stripslashes($input['stats_tracker']);
	
		$categories = get_categories( array( 'hide_empty' => 0, 'hierarchical' => 0 ) );
		$cat_ids = array();
		foreach( $categories as $category )
			$cat_ids[] = $category->term_id;
			
		if( !in_array( $input['slider_category'], $cat_ids ) && ( $input['slider_category'] != 0 ) )
			$input['slider_category'] = $options['slider_category'];
			
		if( !in_array( $input['carousel_category'], $cat_ids ) && ( $input['carousel_category'] != 0 ) )
			$input['carousel_category'] = $options['carousel_category'];
		
		if( !in_array( $input['feat_cat1'], $cat_ids ) && ( $input['feat_cat1'] != 0 ) )
			$input['feat_cat1'] = $options['feat_cat1'];
		
		if( !in_array( $input['feat_cat2'], $cat_ids ) && ( $input['feat_cat2'] != 0 ) )
			$input['feat_cat2'] = $options['feat_cat2'];
			
		if( !in_array( $input['feat_cat3'], $cat_ids ) && ( $input['feat_cat3'] != 0 ) )
			$input['feat_cat3'] = $options['feat_cat3'];
			
		if( !in_array( $input['feat_cat4'], $cat_ids ) && ( $input['feat_cat4'] != 0 ) )
			$input['feat_cat4'] = $options['feat_cat4'];

		return $input;
		
	elseif( $reset ) :
	
		$input = max_magazine_default_options();
		return $input;
		
	endif;
}

if ( ! function_exists( 'max_magazine_get_option' ) ) :
/**
 * Used to output theme options is an elegant way
 * @uses get_option() To retrieve the options array
 */
function max_magazine_get_option( $option ) {
	$options = get_option( 'max_magazine_options', max_magazine_default_options() );
	return $options[ $option ];
}
endif;