<?php

function do_atomic( $tag = '', $arg = '' ) {
	if ( empty( $tag ) )
		return false;

	/* Get the args passed into the function and remove $tag. */
	$args = func_get_args();
	array_splice( $args, 0, 1 );

	/* Do actions on the basic hook. */
	do_action_ref_array( "{$tag}", $args );

	/* Loop through context array and fire actions on a contextual scale. */
	foreach ( (array)swift_get_context() as $context )
		do_action_ref_array( "{$tag}_{$context}", $args );
}

function apply_atomic( $tag = '', $value = '' ) {

	if ( empty( $tag ) )
		return false;
	/* Get the args passed into the function and remove $tag. */
	$args = func_get_args();
	array_splice( $args, 0, 1 );

	/* Apply filters on the basic hook. */
	$value = $args[0] = apply_filters_ref_array( "{$tag}", $args );

	/* Loop through context array and apply filters on a contextual scale. */
	foreach ( (array)swift_get_context() as $context )
		$value = $args[0] = apply_filters_ref_array( "{$tag}_{$context}", $args );

	/* Return the final value once all filters have been applied. */
	return $value;
}
?>