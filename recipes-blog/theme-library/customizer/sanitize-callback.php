<?php

function recipes_blog_sanitize_select( $recipes_blog_input, $recipes_blog_setting ) {
	$recipes_blog_input = sanitize_key( $recipes_blog_input );
	$recipes_blog_choices = $recipes_blog_setting->manager->get_control( $recipes_blog_setting->id )->choices;
	return ( array_key_exists( $recipes_blog_input, $recipes_blog_choices ) ? $recipes_blog_input : $recipes_blog_setting->default );
}

function recipes_blog_sanitize_switch( $recipes_blog_input ) {
	if ( true === $recipes_blog_input ) {
		return true;
	} else {
		return false;
	}
}

function recipes_blog_sanitize_google_fonts( $recipes_blog_input, $recipes_blog_setting ) {
	$recipes_blog_choices = $recipes_blog_setting->manager->get_control( $recipes_blog_setting->id )->choices;
	return ( array_key_exists( $recipes_blog_input, $recipes_blog_choices ) ? $recipes_blog_input : $recipes_blog_setting->default );
}

function recipes_blog_sanitize_choices( $recipes_blog_input, $recipes_blog_setting ) {
    global $wp_customize;
    $control = $wp_customize->get_control( $recipes_blog_setting->id );
    if ( array_key_exists( $recipes_blog_input, $control->choices ) ) {
        return $recipes_blog_input;
    } else {
        return $recipes_blog_setting->default;
    }
}

/**
 * Sanitize HTML input.
 *
 * @param string $recipes_blog_input HTML input to sanitize.
 * @return string Sanitized HTML.
 */
function recipes_blog_sanitize_html( $recipes_blog_input ) {
    return wp_kses_post( $recipes_blog_input );
}

/**
 * Sanitize URL input.
 *
 * @param string $recipes_blog_input URL input to sanitize.
 * @return string Sanitized URL.
 */
function recipes_blog_sanitize_url( $recipes_blog_input ) {
    return esc_url_raw( $recipes_blog_input );
}

// Sanitize Scroll Top Position
function recipes_blog_sanitize_scroll_top_position( $recipes_blog_input ) {
    $valid_positions = array( 'bottom-right', 'bottom-left', 'bottom-center' );
    if ( in_array( $recipes_blog_input, $valid_positions ) ) {
        return $recipes_blog_input;
    } else {
        return 'bottom-right'; // Default to bottom-right if invalid value
    }
}

function recipes_blog_sanitize_range_value( $recipes_blog_number, $recipes_blog_setting ) {

	// Ensure input is an absolute integer.
	$recipes_blog_number = absint( $recipes_blog_number );

	// Get the input attributes associated with the setting.
	$recipes_blog_atts = $recipes_blog_setting->manager->get_control( $recipes_blog_setting->id )->input_attrs;

	// Get minimum number in the range.
	$recipes_blog_min = ( isset( $recipes_blog_atts['min'] ) ? $recipes_blog_atts['min'] : $recipes_blog_number );

	// Get maximum number in the range.
	$recipes_blog_max = ( isset( $recipes_blog_atts['max'] ) ? $recipes_blog_atts['max'] : $recipes_blog_number );

	// Get step.
	$recipes_blog_step = ( isset( $recipes_blog_atts['step'] ) ? $recipes_blog_atts['step'] : 1 );

	// If the number is within the valid range, return it; otherwise, return the default.
	return ( $recipes_blog_min <= $recipes_blog_number && $recipes_blog_number <= $recipes_blog_max && is_int( $recipes_blog_number / $recipes_blog_step ) ? $recipes_blog_number : $recipes_blog_setting->default );
}