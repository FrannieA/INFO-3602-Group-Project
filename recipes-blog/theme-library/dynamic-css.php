<?php

/**
 * Dynamic CSS
 */
function recipes_blog_dynamic_css() {
	$recipes_blog_primary_color = get_theme_mod( 'recipes_blog_primary_color', '#ff7a00' );

	$recipes_blog_site_title_font       = get_theme_mod( 'recipes_blog_site_title_font', 'Raleway' );
	$recipes_blog_site_description_font = get_theme_mod( 'recipes_blog_site_description_font', 'Raleway' );
	$recipes_blog_header_font           = get_theme_mod( 'recipes_blog_header_font', 'Play' );
	$recipes_blog_content_font             = get_theme_mod( 'recipes_blog_content_font', 'Readex Pro' );

	// Enqueue Google Fonts
	$recipes_blog_fonts_url = recipes_blog_get_fonts_url();
	if ( ! empty( $recipes_blog_fonts_url ) ) {
		wp_enqueue_style( 'recipes-blog-google-fonts', esc_url( $recipes_blog_fonts_url ), array(), null );
	}

	$recipes_blog_custom_css  = '';
	$recipes_blog_custom_css .= '
    /* Color */
    :root {
        --primary-color: ' . esc_attr( $recipes_blog_primary_color ) . ';
        --header-text-color: ' . esc_attr( '#' . get_header_textcolor() ) . ';
    }
    ';

	$recipes_blog_custom_css .= '
    /* Typography */
    :root {
        --font-heading: "' . esc_attr( $recipes_blog_header_font ) . '", serif;
        --font-main: -apple-system, BlinkMacSystemFont, "' . esc_attr( $recipes_blog_content_font ) . '", "Segoe UI", Roboto, Oxygen-Sans, Ubuntu, Cantarell, "Helvetica Neue", sans-serif;
    }

    body,
	button, input, select, optgroup, textarea, p {
        font-family: "' . esc_attr( $recipes_blog_content_font ) . '", serif;
	}

	.site-identity p.site-title, h1.site-title a, h1.site-title, p.site-title a, .site-branding h1.site-title a {
        font-family: "' . esc_attr( $recipes_blog_site_title_font ) . '", serif;
	}
    
	p.site-description {
        font-family: "' . esc_attr( $recipes_blog_site_description_font ) . '", serif !important;
	}
    ';

	wp_add_inline_style( 'recipes-blog-style', $recipes_blog_custom_css );
}
add_action( 'wp_enqueue_scripts', 'recipes_blog_dynamic_css', 99 );