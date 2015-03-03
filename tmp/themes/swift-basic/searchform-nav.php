<?php global $swift_options;?>
<?php
if( isset($swift_options['search_code']) && $search_code = $swift_options['search_code'] ):
echo '<div id="navsearch">'.stripslashes( $search_code ).'</div>';
else:
if(!$query=get_search_query())
	$query = __( 'Type and hit enter to Search', 'swift' );
?>
<form method="get" action="<?php echo home_url(); ?>/" id="navsearch">
	<input type="text" value="<?php echo $query; ?>" name="s"
		onfocus="if (this.value == '<?php echo $query; ?>') {this.value = '';}"
		onblur="if (this.value == '') {this.value = '<?php echo $query; ?>';}"
		class="textfield" /> <input type="hidden" value="GO" />
</form>

<?php endif;?>