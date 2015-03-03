jQuery(function ($) {
	$('.of-radio-img-img').click(function () {
		$(this).parent().parent().parent().find('.of-radio-img-img').removeClass('of-radio-img-selected');
		$(this).addClass('of-radio-img-selected');
	});
});

/**
 * Typography script piggy backing in the Skin selector class
 */
// TODO Rewrite the script into it's own class extension of the select opitions
jQuery(document).ready(function ($) {

	// Script to hide show the Google Heading Font input depending on value of the Heading select
	var font = $('#customize-control-font_heading select').val();
	if (font != 'google') {
		$('#customize-control-google_font_heading').hide();
	}
	else {
		$('#customize-control-google_font_heading').show();
	}
	$('#customize-control-font_heading select').change(function () {
		var font_change = $(this).val();
		if (font_change != 'google') {
			$('#customize-control-google_font_heading').hide();
		}
		else {
			$('#customize-control-google_font_heading').show();
		}
	});

	// Script to show hide the Google Text Font input depending on the value of the Text select
	var text = $('#customize-control-font_text select').val();
	if (text != 'google') {
		$('#customize-control-google_font_text').hide();
	}
	else {
		$('#customize-control-google_font_text').show();
	}
	$('#customize-control-font_text select').change(function () {
		var text_change = $(this).val();
		if (text_change != 'google') {
			$('#customize-control-google_font_text').hide();
		}
		else {
			$('#customize-control-google_font_text').show();
		}
	});
});

/* Hide/show WP frontpage option when custom front page toggle is on/off */
jQuery(document).ready( function ( $ ) {

	var front_page_checkbox = $('#customize-control-front_page input');
	var custom_page = $('#customize-control-featured_area_layout, #customize-control-home_headline, #customize-control-home_subheadline, #customize-control-home_content_area, #customize-control-cta_url, #customize-control-cta_text, #customize-control-featured_content');
	var wp_front_page = $('#customize-control-show_on_front, #customize-control-page_on_front, #customize-control-page_for_posts');
	// On load: Hide the below option is toggle is on.
	if ( front_page_checkbox.val() == 0 ) {
		custom_page.hide();
	} else {
		wp_front_page.hide();
	}

	// Hide and show on change.
	front_page_checkbox.change( function () {
		if ( front_page_checkbox.is( ':checked' ) ) {
			wp_front_page.hide();
			custom_page.show();
		} else {
			wp_front_page.show();
			custom_page.hide();
		}
	} );
} );

/* Hide/show menu gradients when menu gradient toggle is on/off */
jQuery(document).ready(function ($) {

	var gradient_checkbox = $('#customize-control-menu_gradients_checkbox input');
	var gradient_colorpickers = $('#customize-control-menu_background_colorpicker_2, #customize-control-menu_item_colorpicker_2, #customize-control-menu_item_hover_colorpicker_2');
	// On load: Hide the below option is toggle is on.
	if ( gradient_checkbox.val() == 1 ) {
		gradient_colorpickers.show();
	} else {
		gradient_colorpickers.hide();
	}

	// Hide and show on change.
	gradient_checkbox.change( function () {
		if ( gradient_checkbox.is( ':checked' ) ) {
			gradient_colorpickers.show();
		} else {
			gradient_colorpickers.hide();
		}
	} );
} );