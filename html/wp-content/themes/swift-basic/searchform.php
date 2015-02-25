<?php
if(!$query=get_search_query())
	$query = __( 'Search the site', 'swift' ).'&hellip;';
?>
<form method="get" id="searchform" action="<?php echo home_url(); ?>/">
	<fieldset>
		<input type="text" value="<?php echo $query; ?>" name="s"
			onfocus="if (this.value == '<?php echo $query; ?>') {this.value = '';}"
			onblur="if (this.value == '') {this.value = '<?php echo $query; ?>';}"
			class="radius3  alignleft" name="s" id="s" /> <input type="submit"
			class="btn small success alignleft" id="searchsubmit"
			value="<?php _e( 'Search', 'swift')?>" />
	</fieldset>
</form>
