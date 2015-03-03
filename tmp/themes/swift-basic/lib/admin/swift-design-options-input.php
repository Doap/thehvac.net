<?php
add_action('admin_print_scripts', 'my_action_javascript',99);

function my_action_javascript() {
	?>
<script
	src="http://ajax.googleapis.com/ajax/libs/webfont/1/webfont.js"></script>
<?php
}
function swift_design_options_input() {
?>
</td>
</tr>
</table>
<div id="tabs" class="clearfix">
	<ul id="tabs-nav" class="tab-list">
		<li><a href="#layout-options"><?php _e('Layout options','swift')?> </a>
		</li>
		<!--
		<li><a href="#background-images"><?php _e('Background images','swift')?>
		</a></li>
		-->
		<li><a href="#color-options"><?php _e('Color options','swift')?> </a>
		</li>
		<!--
		<li><a href="#font-options"><?php _e('Font options','swift')?> </a></li>
		-->
		<li><a href="#rounded-corners"><?php _e('Rounded corners','swift')?> </a>
		</li>
		<li><a href="#user-css"><?php _e('User CSS','swift')?> </a></li>
		<li><a href="#plugin-compatibility"><?php _e('Plugin compatibility','swift')?>
		</a></li>
		<li><a href="#thumbnail-sizes"><?php _e('Thumbnail sizes','swift')?> </a>
		</li>
		<li><a href="#sticky-elements"><?php _e('Sticky Elements','swift')?> </a>
		</li>
		<li><a href="#advanced"><?php _e('Advanced','swift')?> </a></li>
	</ul>
	<div id="options" class="clearfix">
		<?php

		$count = 0;
		GLOBAL $swift_image_repeat, $swift_font_stack, $swift_font_unit, $swift_font_style, $swift_font_weight;
		GLOBAL $swift_text_transform, $swift_design_options_init, $swift_options_init, $swift_design_options;
		$swift_design_options_init = apply_filters('swift_design_options_init', $swift_design_options_init);
		$swift_design_opt = $swift_design_options;
		/*
		 if (isset ($swift_design_opt['fontstack1']) || isset ($swift_design_opt['fontstack2']))
			array_unshift($swift_font_stack, array (
					$swift_design_opt['fontstack1'],
					''
			), array (
			$swift_design_opt['fontstack2'],
					''
		));
		*/
		foreach ($swift_design_options_init as $opt) {

		switch ($opt['type']) {

			case 'heading' :
				echo '<div id="' . $opt['id'] . '" class="options clearfix">';
				break;

			case 'sub-heading' :
				if ($count % 3 == 1)
					$class = 'alpha';
				if ($count % 3 == 2)
					$class = '';
				if ($count % 3 == 0)
					$class = 'omega';
				?>
		<div class="color-group clearfix" id="<?php echo $opt['id']?>">
			<div class="color-heading clearfix">
				<input type="checkbox"
					value="<?php

				if (isset ($swift_design_opt[$opt['id']]) && $swift_design_opt[$opt['id']] != '') {
					echo stripslashes(esc_attr($swift_design_opt[$opt['id']]));
				} else {
					echo stripslashes($opt['default']);
				}
?>"
					name="swift_design_options[<?php echo $opt['id']?>]"
					id="<?php echo $opt['id']?>_"
					<?php checked( $swift_design_opt[ $opt['id'] ], TRUE ); ?>><label
					for="<?php echo $opt['id']?>_"><p>
						<?php echo $opt['name'] ?>
					</p> </label><a></a>
				<div class="clear"></div>
			</div>
			<?php

			$count++;
			break;

case 'close' :
	echo '</div>';
	break;

case 'hr' :
	echo '<hr>';
	break;

case 'clear' :
	echo '<div class="clear"></div>';
	break;

case 'hidden' :
	?>
			<input type="hidden" id="<?php echo $opt['id']?>"
				value="<?php if(isset($swift_design_opt[$opt['id']])){echo $swift_design_opt[$opt['id']];}else{echo $opt['default'];}?>"
				name="swift_design_options[<?php echo $opt['id']?>]">
			<?php

			break;

case 'explain' :
	?>
			<div id="<?php echo $opt['id']?>" class="explain alert alert-info">
				<?php echo $opt['desc']?>
			</div>
			<?php

			break;
case 'text' :
	?>
			<div class="text">
				<label for="<?php echo $opt['id']?>"><h4>
						<?php echo $opt['name']?>
					</h4> </label> <input type="text"
					name="swift_design_options[<?php echo $opt['id']?>]"
					id="<?php echo $opt['id']?>"
					value="<?php if ( isset( $swift_design_opt[ $opt['id'] ] ) && $swift_design_opt[ $opt['id'] ] != '' ) { echo stripslashes( esc_attr( $swift_design_opt[ $opt['id'] ] ) ); } else { echo stripslashes($opt['default']); } ?>" />
				<label for="<?php echo $opt['id']?>"><em><?php echo $opt['desc']?> </em>
				</label>
			</div>
			<?php

			break;

case 'color' :
	?>

			<div class="color clearfix">
				<input type="text"
					name="swift_design_options[<?php echo $opt['id']?>]"
					id="<?php echo $opt['id']?>" class="color"
					value="<?php if ( isset( $swift_design_opt[ $opt['id'] ] ) && $swift_design_opt[ $opt['id'] ] != '' ) { echo stripslashes( esc_attr( $swift_design_opt[ $opt['id'] ] ) ); } else { echo stripslashes($opt['default']); } ?>" />
				<label for="<?php echo $opt['id']?>"><?php echo $opt['name']?> </label>
			</div>

			<?php

			break;

case 'textarea' :
	?>
			<div class="textarea clearfix">
				<label for="<?php echo $opt['id']?>"><h4>
						<?php echo $opt['name']?>
					</h4> </label>
				<textarea rows="7" cols="50"
					name="swift_design_options[<?php echo $opt['id']?>]"
					id="<?php echo $opt['id']?>">
					<?php if ( isset( $swift_design_opt[ $opt['id'] ] ) && $swift_design_opt[ $opt['id'] ] != '' ) {
						echo stripslashes( esc_attr( $swift_design_opt[ $opt['id'] ] ) );
					} else { echo stripslashes($opt['default']);
} ?>
				</textarea>
				<label for="<?php echo $opt['id']?>"><em><?php echo $opt['desc']?> </em>
				</label>
			</div>
			<?php

			break;

case 'radio' :
	?>
			<div class="radio clearfix" id="<?php echo $opt['id']?>">
				<h4>
					<?php echo $opt['name']?>
				</h4>
				<?php

				foreach ($opt['options'] as $key => $choice) {
					if (isset ($swift_design_opt[$opt['id']]) && $swift_design_opt[$opt['id']] == $key) {
						$checked = 'checked';
						$label_style = 'class="selected"';
					} else {
						$checked = '';
						$label_style = '';
					}
					?>
				<input type="radio"
					name="swift_design_options[<?php echo $opt['id']?>]"
					value="<?php echo $choice; ?>"
					id="<?php echo $opt['id'].$choice; ?>" <?php echo $checked ?>> <label
					for="<?php echo $opt['id'].$choice;; ?>" <?php echo $label_style?>><img
					src="<?php echo get_template_directory_uri().'/lib/admin/images/'.$opt['id'].'_'.$choice.'.png'; ?>"
					alt="<?php echo $choice?>" /> <?php echo $choice?> </label>
				<?php

				}
				?>
				<em><?php echo $opt['desc']?> </em>
			</div>
			<?php

			break;

case 'checkbox' :
	?>
			<div class="checkbox">
				<h4>
					<?php echo $opt['name']?>
				</h4>
				<input type="checkbox"
					name="swift_design_options[<?php echo $opt['id']?>]" value="true"
					<?php checked( $swift_design_opt[ $opt['id'] ], true ); ?>
					id="<?php echo $opt['id']; ?>" /> <label
					for="<?php echo $opt['id']?>"><em><?php echo $opt['desc']?> </em> </label>
			</div>
			<?php

			break;

case 'select' :
	?>
			<div class="select">
				<label for="<?php echo $opt['id']?>"><h4>
						<?php echo $opt['name']?>
						<?php echo $swift_design_opt[ $opt['id'] ]?>
					</h4> </label> <select
					name="swift__design_options[<?php echo $opt['id']?>]">
					<?php

					foreach ($opt['options'] as $key => $choice) {
					if (isset ($swift_design_opt[$opt['id']]) && $swift_design_opt[$opt['id']] == $key) {
						$selected = 'selected="yes"';
					} else {
						$selected = '';
					}
					?>
					<option value="<?php echo $key; ?>"
					<?php selected( $swift_design_opt[ $opt['id'] ], $key ); ?>>
						<?php echo $choice; ?>
					</option>
					<?php

				}
				?>
				</select> <em><?php echo $opt['desc']?> </em>
			</div>
			<?php

			break;

case 'upload' :
	?>
			<div class="backgrounds">
				<label for="<?php echo $opt['id']?>"><h4>
						<?php echo $opt['name']?>
					</h4> <em><?php echo $opt['desc']?> </em><br /> </label> <input
					class="regular-text uploaded_url" type="text"
					name="swift_design_options[<?php echo $opt['id']?>]"
					value="<?php if ( isset( $swift_design_opt[ $opt['id'] ] ) && $swift_design_opt[ $opt['id'] ] != '' ) { echo stripslashes( esc_attr( $swift_design_opt[ $opt['id'] ] ) ); } else { echo stripslashes($opt['default']); } ?>" />
				<span id="<?php echo $opt['id']?>"
					class="image_upload_button button">Upload Image</span> <span
					title="<?php echo $opt['id']?>" id="reset_<?php echo $opt['id']?>"
					class="image_reset_button button">Remove</span> <input
					type="hidden" class="ajax_action_url" name="wp_ajax_action_url"
					value="<?php echo admin_url("admin-ajax.php"); ?>" /> <input
					type="hidden" class="image_preview_size"
					name="img_size_<?php echo $opt['id']?>"
					value="<?php echo $swift_design_opt[ $opt['id'] ];?>" /> <br /> <br />
				<label for="<?php echo $opt['id']?>_p_t"><?php _e( 'Top:', 'swift' ); ?>
				</label> <input type="text" class="secondary"
					name="swift_design_options[<?php echo $opt['id']?>_p_t]"
					value="<?php if ( isset( $swift_design_opt[ $opt['id'].'_p_t' ] ) && $swift_design_opt[ $opt['id'].'_p_t' ] != '' ) { echo stripslashes( esc_attr( $swift_design_opt[ $opt['id'].'_p_t' ] ) ); } ?>">

				<label for="<?php echo $opt['id']?>_p_l"><?php _e( 'Left:', 'swift' ); ?>
				</label> <input type="text" class="secondary"
					name="swift_design_options[<?php echo $opt['id']?>_p_l]"
					value="<?php if ( isset( $swift_design_opt[ $opt['id'].'_p_l' ] ) && $swift_design_opt[ $opt['id'].'_p_l' ] != '' ) { echo stripslashes( esc_attr( $swift_design_opt[ $opt['id'].'_p_l' ] ) ); } ?>">

				<label for="<?php echo $opt['id']?>_repeat"><?php _e( 'Repeat:', 'swift' ); ?>
				</label> <select
					name="swift_design_options[<?php echo $opt['id']?>_repeat]"
					class="secondary">
					<?php

					foreach ($swift_image_repeat as $key => $repeat) {
					if (isset ($swift_design_opt[$opt['id'] . '_repeat']) && $swift_design_opt[$opt['id'] . '_repeat'] == $key) {
						$selected = 'selected="yes"';
					} else {
						$selected = '';
					}
					?>
					<option value="<?php echo esc_attr($key); ?>"
					<?php echo $selected ?>>
						<?php echo esc_attr($repeat); ?>
					</option>
					<?php

				}
				?>
				</select>

				<?php if( isset( $swift_design_opt[ $opt['id'] ] ) && $swift_design_opt[ $opt['id'] ] != '' ):?>
				<img class="swift_image_preview" id="image_<?php echo $opt['id'];?>"
					src="<?php echo $swift_design_opt[ $opt['id'] ];?>"
					style="max-width: 90%" />
				<?php endif;?>

			</div>


			<?php

			break;

case 'thumb_size' :
	?>
			<div class="text">
				<label for="<?php echo $opt['id']?>"><h4>
						<?php echo $opt['name']?>
					</h4> </label> <input type="text"
					name="swift_design_options[<?php echo $opt['id']?>_width]"
					id="<?php echo $opt['id']?>"
					value="<?php if ( isset( $swift_design_opt[ $opt['id'].'_width' ] ) && $swift_design_opt[ $opt['id'].'_width' ] != '' ) { echo (int)( $swift_design_opt[ $opt['id'].'_width' ] ) ; } ?>" />
				<span class="alignleft">&nbsp;*&nbsp;</span><input type="text"
					name="swift_design_options[<?php echo $opt['id']?>]_height"
					id="<?php echo $opt['id']?>"
					value="<?php if ( isset( $swift_design_opt[ $opt['id'].'_height' ] ) && $swift_design_opt[ $opt['id'].'_height' ] != '' ) { echo (int)( $swift_design_opt[ $opt['id'].'_height' ] ) ; } ?>" />
				px<label for="<?php echo $opt['id']?>"><em><?php echo $opt['desc']?>
				</em> </label>
			</div>
			<div class="clear"></div>
			<?php

			break;

case 'font' :
	?>
			<div class="font">
				<h4>
					<?php echo $opt['name']?>
				</h4>
				<?php

				if (isset ($swift_design_opt[$opt['id'] . '_enable']) && $swift_design_opt[$opt['id'] . '_enable'] == true) {
					$checked = 'checked';
				} else {
					$checked = '';
				}
				?>
				<input type="checkbox"
					name="swift_design_options[<?php echo $opt['id']?>_enable]"
					value="true" <?php echo $checked?>
					id="<?php echo $opt['id'].'_enable'; ?>" /> <label
					for="<?php echo $opt['id']?>_enable"><?php printf( __( 'Enable custom font for %s', 'swift' ), $opt['name'] ); ?></em>
				</label> <br /> <br /> <label for="<?php echo $opt['id']?>_family"><?php _e( 'FontFamily', 'swift' ); ?>
				</label> <select
					name="swift_design_options[<?php echo $opt['id']?>_family]"
					style="width: 48%">
					<?php

					foreach ($swift_font_stack as $font) {
					if (isset ($swift_design_opt[$opt['id'] . '_family']) && $swift_design_opt[$opt['id'] . '_family'] == $font[0]) {
						$selected = 'selected="yes"';
					} else {
						$selected = '';
					}
					?>
					<option value="<?php echo esc_attr($font[0]); ?>"
					<?php echo $selected ?>>
						<?php echo esc_attr($font[0]).' '.$font[1]; ?>
					</option>
					<?php

				}
				?>
				</select> <label for="<?php echo $opt['id']?>_size"><?php _e( 'Size', 'swift' ); ?>
				</label> <input type="text" id="<?php echo $opt['id']?>_size"
					class="text"
					name="swift_design_options[<?php echo $opt['id']?>_size]"
					value="<?php if(isset($swift_design_opt[ $opt['id'].'_size' ]))echo $swift_design_opt[ $opt['id'].'_size' ] ?>">
				<select
					name="swift_design_options[<?php echo $opt['id']?>_size_unit]">
					<?php

					foreach ($swift_font_unit as $key => $unit) {
					if (isset ($swift_design_opt[$opt['id'] . '_size_unit']) && $swift_design_opt[$opt['id'] . '_size_unit'] == $key) {
						$selected = 'selected="yes"';
					} else {
						$selected = '';
					}
					?>
					<option value="<?php echo esc_attr($key); ?>"
					<?php echo $selected ?>>
						<?php echo esc_attr($unit); ?>
					</option>
					<?php

				}
				?>
				</select> <label for="<?php echo $opt['id']?>_lh"><?php _e( 'LineHeight', 'swift' ); ?>
				</label> <input type="text" class="text"
					id="<?php echo $opt['id']?>_lh"
					name="swift_design_options[<?php echo $opt['id']?>_lh]"
					value="<?php if( isset($swift_design_opt[ $opt['id'].'_lh' ]) )echo $swift_design_opt[ $opt['id'].'_lh' ] ?>">
				<select name="swift_design_options[<?php echo $opt['id']?>_lh_unit]">
					<?php

					foreach ($swift_font_unit as $key => $unit) {
					if (isset ($swift_design_opt[$opt['id'] . '_lh_unit']) && $swift_design_opt[$opt['id'] . '_lh_unit'] == $key) {
						$selected = 'selected="yes"';
					} else {
						$selected = '';
					}
					?>
					<option value="<?php echo esc_attr($key); ?>"
					<?php echo $selected ?>>
						<?php echo esc_attr($unit); ?>
					</option>
					<?php

				}
				?>
				</select> <br /> <br /> <label for="<?php echo $opt['id']?>_weight"><?php _e( 'Font weight', 'swift' ); ?>
				</label> <select
					name="swift_design_options[<?php echo $opt['id']?>_weight]"
					id="<?php echo $opt['id']?>_weight">
					<?php

					foreach ($swift_font_weight as $key => $weight) {
					if (isset ($swift_design_opt[$opt['id'] . '_weight']) && $swift_design_opt[$opt['id'] . '_weight'] == $key) {
						$selected = 'selected="yes"';
					} else {
						$selected = '';
					}
					?>
					<option value="<?php echo esc_attr($key); ?>"
					<?php echo $selected ?>>
						<?php echo esc_attr($weight); ?>
					</option>
					<?php

				}
				?>
				</select> <label for="<?php echo $opt['id']?>_transform"><?php _e( 'Text transform', 'swift' ); ?>
				</label> <select
					name="swift_design_options[<?php echo $opt['id']?>_transform]"
					id="<?php echo $opt['id']?>_transform">
					<?php

					foreach ($swift_text_transform as $key => $transform) {
					if (isset ($swift_design_opt[$opt['id'] . '_weight']) && $swift_design_opt[$opt['id'] . '_transform'] == $transform) {
						$selected = 'selected="yes"';
					} else {
						$selected = '';
					}
					?>
					<option value="<?php echo esc_attr($key); ?>"
					<?php echo $selected ?>>
						<?php echo esc_attr($transform); ?>
					</option>
					<?php

				}
				?>
				</select> <label for="<?php echo $opt['id']?>_style"><?php _e( 'Font style', 'swift' ); ?>
				</label> <select
					name="swift_design_options[<?php echo $opt['id']?>_style]"
					id="<?php echo $opt['id']?>_style">
					<?php

					foreach ($swift_font_style as $key => $style) {
					if (isset ($swift_design_opt[$opt['id'] . '_weight']) && $swift_design_opt[$opt['id'] . '_style'] == $style) {
						$selected = 'selected="yes"';
					} else {
						$selected = '';
					}
					?>
					<option value="<?php echo esc_attr($key); ?>"
					<?php echo $selected ?>>
						<?php echo esc_attr($style); ?>
					</option>
					<?php

				}
				?>
				</select>
			</div>

			<?php


			break;

case 'function' :
	$opt['id'] ();
	break;

case 'sortable' :
	?>

			<div class="sortable-container">
				<label for="<?php echo $opt['id']?>"><h4>
						<?php echo $opt['name']?>
					</h4> </label>

				<ul class="sortable clearfix" id="<?php echo $opt['id']?>">
					<?php

					$sortable_options = $swift_design_opt[$opt['id']];
					$size = count($sortable_options);

					for ($i = 0; $i < $size; $i++) {
					if ($sortable_options[$i] == 'text') {
?>
					<li class="ui-state-default"><input class="position" type="text"
						name="text" value="<?php echo $sortable_options[$i+1]?>"></li>
					<?php

					$i++;
					}
					elseif ($sortable_options[$i] != '') {
?>
					<li class="ui-state-default" id="1"><input type="hidden"
						value="<?php echo $sortable_options[$i] ?>"> <?php echo $sortable_options[$i] ?>
					</li>
					<?php

					}
				}
?>
				</ul>
				<ul class="draggable clearfix">
					<?php

				foreach ($opt['options'] as $option) {
					if ($option == 'text') {
?>
					<li class="ui-state-default"><input class="position" type="text"
						name="text" value=""></li>
					<?php

					} else {
?>
					<li class="ui-state-default" id="1"><input type="hidden"
						value="<?php echo $option ?>"> <?php echo $option ?></li>

					<?php

					}
				}
?>


				</ul>
				<input id="<?php echo $opt['id']?>" type="hidden"
					name="swift_design_options[<?php echo $opt['id']?>]" value="">
			</div>
			<?php

				break;
		}

	}
?>
		</div>
		<!-- /#options -->
	</div>
	<!-- /#tabs -->

	<td>

	<tr>
		<table>
			<?php

}
?>