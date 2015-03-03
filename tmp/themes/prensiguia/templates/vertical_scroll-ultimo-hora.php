<script type="text/javascript">
jQuery(function(){
	jQuery('#news-container').vTicker({ 
		speed: 300,  //speed
		pause: 3000,
		animation: 'fade',
		mousePause: true,
		direction: 'down',
		showItems: 30  //number of items
	});
});
</script>



<?php

$charstoshow=150;  //  This number can be changed..indicates how many characters of the excerpt to show

	
			add_action('wp_footer','rssmi_footer_scripts');  //  Don't mess with this
			add_action('wp_footer','vertical_scroll_footer_scripts'); //  Don't mess with this
		
		
			$readable .=  '	<div  id="news-container" class="v_scroller" style="padding:0px;margin:0px;"><ul class="wprssmi_rss_vs" style="width:100%;padding:0px;margin:0px;">';
			
			
				
	//  don't mess with this php code 
	$addmotion=1;			
	$showdesc=1;
	foreach($myarray as $items) {

	if ($pag!==1){ 	
		$total = $total +1;
		if ($maxperPage>0 && $total>=$maxperPage) break;
	}

	$idnum=$idnum +1;
	//  END don't mess with this php code 
	
	
	
	
	
				$readable .=  '<li style="background-color:#fff;width:100%;padding:0px;margin:0px;"><div style="padding:0px;margin:0px;">';
				$readable .=  '<h4><div class="title"><a '.$openWindow.' href='.$items["mylink"].'>'.$items["mytitle"].'</a></div></h4><div style="color:#000;">';
			
			if ($showdesc==1){
			
						$desc= esc_attr(strip_tags(@html_entity_decode($items["mydesc"], ENT_QUOTES, get_option('blog_charset'))));
						$desc = wp_html_excerpt( $desc, $charstoshow );
						if ( '[...]' == substr( $desc, -5 ) )
							$desc = substr( $desc, 0, -5 ) . '[&hellip;]';
							elseif ( '[&hellip;]' != substr( $desc, -10 ) )
								$desc .= ' [&hellip;]';
							$desc = esc_html( $desc );
				$readable .=  $desc.'<br/>';
			}

			if (!empty($items["mystrdate"])  && $showdate==1){
			 	$readable .=   date_i18n("D, M d, Y",$items["mystrdate"]).'<br />';
			}
				if (!empty($items["myGroup"])){
		    	$readable .=  '<span style="font-style:italic;">'.$attribution.''.$items["myGroup"].'</span>';
			}
			 
				$readable .=  '</div></div></li>';

		}

		$readable .=  '</ul></div>';
	
	
	


						



?>
