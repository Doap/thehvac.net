<?php
/**
 * The template for displaying search forms.
 *
 * @file      searchform.php
 * @package   max-magazine
 * @author    Sami Ch.
 * @link 	  http://gazpo.com
 */
?>
 
<form method="get" id="searchform" action="<?php echo home_url( '/' ); ?>">
	<div>
		<input class="searchfield" type="text" value="<?php _e('Search', 'max-magazine');?>" name="s" id="s" onfocus="if (this.value == 'Search') {this.value = '';}" onblur="if (this.value == '') {this.value = 'Search';}" />
	</div>
</form>
