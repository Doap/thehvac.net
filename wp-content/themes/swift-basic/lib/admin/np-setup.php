<div class="sortable-container" id="<?php echo $opt['id']?>-container">
	<label for="<?php echo $opt['id']?>"><h4>
			<?php echo $opt['name']?>
		</h4>
	</label>

	<ul class="sortable clearfix" id="<?php echo $opt['id']?>">
		<?php
		$sortable_options = $swift_opt[ $opt['id'] ];
		if(!is_array($sortable_options))
			$sortable_options = split( ',', $sortable_options );

		$size = count( $sortable_options );
		$out = '';
		for( $i=0;$i<$size;$i++ ){
			if($sortable_options[$i] == -6){
				$out .= '<li class="ui-state-default btn btn-primary recent"><input type="hidden" value="-6">'.__( 'Recent comments', 'swift' ).'</li>';
				continue;
			}elseif($sortable_options[$i] == -5){
				$out .= '<li class="ui-state-default btn btn-primary recent"><input type="hidden" value="-5">'.__( 'Top authors', 'swift' ).'</li>';
				continue;
			}elseif($sortable_options[$i] == -4){
				$out .= '<li class="ui-state-default btn btn-primary recent"><input type="hidden" value="-4">'.__( 'Random authors', 'swift' ).'</li>';
				continue;
			}elseif($sortable_options[$i] == -3){
				$out .= '<li class="ui-state-default btn btn-primary recent"><input type="hidden" value="-3">'.__( 'Popular posts', 'swift' ).'</li>';
				continue;
			}elseif($sortable_options[$i] == -2){
				$out .= '<li class="ui-state-default btn btn-primary recent"><input type="hidden" value="-2">'.__( 'Recent posts', 'swift' ).'</li>';
				continue;
			}elseif($sortable_options[$i] == -1){
				$out .= '<li class="ui-state-default btn btn-primary recent"><input type="hidden" value="-1">'.__( 'Random posts', 'swift' ).'</li>';
				continue;
			}
			elseif( $sortable_options[$i] != '' ){
				$out .= '<li class="ui-state-default btn btn-primary recent"><input type="hidden" value="'.$sortable_options[$i].'">'.get_cat_name($sortable_options[$i]).'</li>';
			}
		}
		echo $out;
		?>
	</ul>
	<input id="<?php echo $opt['id']?>" type="hidden"
		name="swift_options[<?php echo $opt['id']?>]" value="">

</div>



