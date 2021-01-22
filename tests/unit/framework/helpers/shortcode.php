<?php
/**
 * @param  string  $name
 * @param  array  $attributes
 *
 * @return string
 */
function generate_shortcode( $name, $attributes ) {
	$shortcode = sprintf( '[%s', $name );

	foreach ( $attributes as $key => $value ) {
		// remove quotes
		$value     = str_replace( [ '"', "'" ], '', var_export( $value, true ) );
		$shortcode .= sprintf( ' %s="%s"', $key, $value );
	}

	$shortcode .= ']';

	return $shortcode;
}
