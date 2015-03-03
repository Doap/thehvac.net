<?php
function np_setup_cat_base(){
	?>
<div id="cat-base" class="sortable-container">
	<ul class="draggable clearfix">
		<li class="ui-state-default btn random"><input type="hidden"
			value="-6"> <?php _e( 'Recenet comments', 'swift' ); ?></li>
		<li class="ui-state-default btn random"><input type="hidden"
			value="-5"> <?php _e( 'Top authors', 'swift' ); ?></li>
		<li class="ui-state-default btn random"><input type="hidden"
			value="-4"> <?php _e( 'Random authors', 'swift' ); ?></li>
		<li class="ui-state-default btn random"><input type="hidden"
			value="-3"> <?php _e( 'Popular posts', 'swift' ); ?></li>
		<li class="ui-state-default btn recent"><input type="hidden"
			value="-2"> <?php _e( 'Recent posts', 'swift' ); ?></li>
		<li class="ui-state-default btn random"><input type="hidden"
			value="-1"> <?php _e( 'Random posts', 'swift' ); ?></li>
		<?php
		$categories = get_categories();
		foreach( $categories as $cat ){
?>
		<li class="ui-state-default btn"><input type="hidden"
			value="<?php echo $cat->term_id; ?>"> <?php echo $cat->name.' ( '.$cat->count. ' )'; ?>
		</li>
		<?php
				}
				?>
	</ul>
</div>
<?php }
function swift_options_input(){
?>
</td>
</tr>
</table>
<div id="tabs" class="clearfix">
	<ul id="tabs-nav" class="clearfix">
		<li><a href="#general-settings"><?php _e('General settings','swift')?>
		</a></li>
		<li><a href="#header-options"><?php _e('Header settings','swift')?> </a>
		</li>
		<li><a href="#homepage-options"><?php _e('Homepage settings','swift')?>
		</a></li>
		<li><a href="#post-meta"><?php _e('Single post options','swift')?> </a>
		</li>
		<li><a href="#ad-management"><?php _e('AD management','swift')?> </a>
		</li>
		<!--
		<li><a href="#np-layout"><?php _e('NEWS paper layout','swift')?> </a>
		</li>
		<li><a href="#np2-layout"><?php _e('NEWS paper layout 2','swift')?> </a>
		</li>
		-->
		<li><a href="#social-media"><?php _e('Social media','swift')?> </a></li>
	</ul>

	<div id="options" class="clearfix">
		<?php
		GLOBAL $swift_options_init,$swift_options;
		$swift_options_init = apply_filters( 'swift_options_init', $swift_options_init);
		$temp = get_option('SwiftOptions');
		$swift_opt = $temp['site_options'];
		foreach( $swift_options_init as $opt ){

		switch( $opt['type'] ){

			case 'heading':
				echo '<div id="'.$opt['id'].'" class="options clearfix">';
				break;

			case 'close':
				echo '</div>';
				break;

			case 'clear':
				echo '<div class="clear"></div>';
				break;
			case 'hidden':
				?>
		<input type="hidden" value="options"
			name="swift_options[<?php echo $opt['id']?>]">
		<?php
		break;

case 'explain':
	?>
		<div id="<?php echo $opt['id']?>" class="explain alert alert-info">
			<?php echo $opt['desc']?>
		</div>
		<?php
		break;

case 'text':
	?>
		<div class="text">
			<label for="<?php echo $opt['id']?>"><h4>
					<?php echo $opt['name']?>
				</h4> </label> <input type="text"
				name="swift_options[<?php echo $opt['id']?>]"
				id="<?php echo $opt['id']?>"
				value="<?php echo $swift_opt[$opt['id']];?>" /> <label
				for="<?php echo $opt['id']?>"><em><?php echo $opt['desc']?> </em> </label>
		</div>
		<?php
		break;

case 'textarea':
	?>
		<div class="textarea clearfix">
			<label for="<?php echo $opt['id']?>"><h4>
					<?php echo $opt['name']?>
				</h4> </label>
			<textarea rows="7" cols="50"
				name="swift_options[<?php echo $opt['id']?>]"
				id="<?php echo $opt['id']?>">
				<?php if ( isset( $swift_opt[ $opt['id'] ] ) && $swift_opt[ $opt['id'] ] != '' ) {
					echo stripslashes( esc_attr( $swift_opt[ $opt['id'] ] ) );
				} else { echo stripslashes($opt['default']);
} ?>
			</textarea>
			<label for="<?php echo $opt['id']?>"><em><?php echo $opt['desc']?> </em>
			</label>
		</div>
		<?php 			break;

case 'radio':
	?>
		<div class="radio clearfix" id="<?php echo $opt['id']?>">
			<h4>
				<?php echo $opt['name']?>
			</h4>
			<em><?php echo $opt['desc']?> </em>
			<?php 			foreach ( $opt['options'] as $choice ) {
				if ( isset( $swift_opt[ $opt['id'] ] ) && $swift_opt[ $opt['id'] ] == $choice ) {
						$checked = 'checked';
						$label_style = 'class="selected"';
					} else {
					$checked = ''	;
					$label_style = '';
					}
					?>
			<input type="radio" name="swift_options[<?php echo $opt['id']?>]"
				value="<?php echo $choice; ?>"
				id="<?php echo $opt['id'].$choice; ?>" <?php echo $checked ?>> <label
				for="<?php echo $opt['id'].$choice;; ?>" <?php echo $label_style;?>>
				<img
				src="<?php echo get_template_directory_uri().'/lib/admin/images/'.$opt['id'].'_'.$choice.'.png'; ?>"
				alt="<?php echo $choice?>" /> <?php echo $choice?>
			</label>
			<?php 			}
			?>
		</div>
		<?php
		break;

case 'checkbox':
	?>
		<div class="checkbox">
			<h4>
				<?php echo $opt['name']?>
			</h4>
			<input type="checkbox" name="swift_options[<?php echo $opt['id']?>]"
				value="true" <?php checked( $swift_opt[ $opt['id'] ], true ); ?>
				id="<?php echo $opt['id']; ?>" /> <label
				for="<?php echo $opt['id']?>"><em><?php echo $opt['desc']?> </em> </label>
		</div>
		<?php
		break;

case 'select':
	?>
		<div class="select">
			<label for="<?php echo $opt['id']?>"><h4>
					<?php echo $opt['name']?>
				</h4> </label> <select name="swift_options[<?php echo $opt['id']?>]">
				<?php 			foreach( $opt['options'] as $key => $choice ){
					?>
				<option value="<?php echo $key; ?>"
				<?php selected( $swift_opt[ $opt['id'] ], $key ); ?>>
					<?php echo $choice; ?>
				</option>
				<?php 			}
				?>
			</select> <label for="<?php echo $opt['id']?>"><em><?php echo $opt['desc']?>
			</em> </label>
		</div>
		<?php
		break;

case 'upload':
	?>
		<div class="upload">
			<label for="<?php echo $opt['id']?>"><h4>
					<?php echo $opt['name']?>
				</h4> </label> <input class="regular-text uploaded_url" type="text"
				name="swift_options[<?php echo $opt['id']?>]"
				value="<?php if ( isset( $swift_opt[ $opt['id'] ] ) && $swift_opt[ $opt['id'] ] != '' ) { echo stripslashes( esc_attr( $swift_opt[ $opt['id'] ] ) ); } else { echo stripslashes($opt['default']); } ?>" />
			<span id="<?php echo $opt['id']?>" class="image_upload_button button">Upload
				Image</span> <span title="<?php echo $opt['id']?>"
				id="reset_<?php echo $opt['id']?>" class="image_reset_button button">Remove</span>
			<input type="hidden" class="ajax_action_url"
				name="wp_ajax_action_url"
				value="<?php echo admin_url("admin-ajax.php"); ?>" /> <input
				type="hidden" class="image_preview_size"
				name="img_size_<?php echo $opt['id']?>"
				value="<?php echo $swift_opt[ $opt['id'] ];?>" /> <br /> <label><em><?php echo $opt['desc']?>
			</em> </label>

			<?php if( isset( $swift_opt[ $opt['id'] ] ) && $swift_opt[ $opt['id'] ] != '' ):?>
			<img class="swift_image_preview" id="image_<?php echo $opt['id'];?>"
				src="<?php echo $swift_opt[ $opt['id'] ];?>" style="max-width: 90%" />
			<?php endif;?>

		</div>


		<?php 		break;
		;
case 'cat_base':
	np_setup_cat_base();
	break;

case 'np-setup':
	include( SWIFT_ADMIN .'/np-setup.php');
	break;

case 'sortable':
	?>

		<div class="sortable-container" id="<?php echo $opt['id']?>-container">
			<label for="<?php echo $opt['id']?>"><h4>
					<?php echo $opt['name']?>
				</h4> </label>

			<ul class="sortable clearfix" id="<?php echo $opt['id']?>">
				<?php
				$sortable_options = $swift_opt[ $opt['id'] ];
				$size = count( $sortable_options );
				for( $i=0;$i<$size;$i++ ){
					if( $sortable_options[$i] == 'text'){
?>
				<li class="ui-state-default btn drag-text"><input class="position"
					type="text" name="text"
					value="<?php echo $sortable_options[$i+1]?>"></li>
				<?php 				$i++;
}elseif( $sortable_options[$i] != ''){
?>
				<li class="ui-state-default btn" id="1"><input type="hidden"
					value="<?php echo $sortable_options[$i] ?>"> <?php echo $sortable_options[$i] ?>
				</li>
				<?php 				}
			}
			?>
			</ul>
			<ul class="draggable clearfix">
				<?php 			foreach( $opt['options'] as $option ){
					if( $option == 'text'){
?>
				<li class="ui-state-default btn drag-text"><input class="position"
					type="text" name="text" value=""></li>
				<?php 				}else{
					?>
				<li class="ui-state-default btn" id="1"><input type="hidden"
					value="<?php echo $option ?>"> <?php echo $option ?></li>

				<?php
					}
}
?>


			</ul>
			<input id="<?php echo $opt['id']?>" type="hidden"
				name="swift_options[<?php echo $opt['id']?>]" value="">
		</div>
		<?php break;

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