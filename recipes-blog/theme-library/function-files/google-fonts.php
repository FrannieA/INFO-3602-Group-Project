<?php
function recipes_blog_get_all_google_fonts() {
    $recipes_blog_webfonts_json = get_template_directory() . '/theme-library/google-webfonts.json';
    if ( ! file_exists( $recipes_blog_webfonts_json ) ) {
        return array();
    }

    $recipes_blog_fonts_json_data = file_get_contents( $recipes_blog_webfonts_json );
    if ( false === $recipes_blog_fonts_json_data ) {
        return array();
    }

    $recipes_blog_all_fonts = json_decode( $recipes_blog_fonts_json_data, true );
    if ( json_last_error() !== JSON_ERROR_NONE ) {
        return array();
    }

    $recipes_blog_google_fonts = array();
    foreach ( $recipes_blog_all_fonts as $recipes_blog_font ) {
        $recipes_blog_google_fonts[ $recipes_blog_font['family'] ] = array(
            'family'   => $recipes_blog_font['family'],
            'variants' => $recipes_blog_font['variants'],
        );
    }
    return $recipes_blog_google_fonts;
}


function recipes_blog_get_all_google_font_families() {
    $recipes_blog_google_fonts  = recipes_blog_get_all_google_fonts();
    $recipes_blog_font_families = array();
    foreach ( $recipes_blog_google_fonts as $recipes_blog_font ) {
        $recipes_blog_font_families[ $recipes_blog_font['family'] ] = $recipes_blog_font['family'];
    }
    return $recipes_blog_font_families;
}

function recipes_blog_get_fonts_url() {
    $recipes_blog_fonts_url = '';
    $recipes_blog_fonts     = array();

    $recipes_blog_all_fonts = recipes_blog_get_all_google_fonts();

    if ( ! empty( get_theme_mod( 'recipes_blog_site_title_font', 'Raleway' ) ) ) {
        $recipes_blog_fonts[] = get_theme_mod( 'recipes_blog_site_title_font', 'Raleway' );
    }

    if ( ! empty( get_theme_mod( 'recipes_blog_site_description_font', 'Raleway' ) ) ) {
        $recipes_blog_fonts[] = get_theme_mod( 'recipes_blog_site_description_font', 'Raleway' );
    }

    if ( ! empty( get_theme_mod( 'recipes_blog_header_font', 'Epilogue' ) ) ) {
        $recipes_blog_fonts[] = get_theme_mod( 'recipes_blog_header_font', 'Epilogue' );
    }

    if ( ! empty( get_theme_mod( 'recipes_blog_content_font', 'Raleway' ) ) ) {
        $recipes_blog_fonts[] = get_theme_mod( 'recipes_blog_content_font', 'Raleway' );
    }

    $recipes_blog_fonts = array_unique( $recipes_blog_fonts );

    foreach ( $recipes_blog_fonts as $recipes_blog_font ) {
        $recipes_blog_variants      = $recipes_blog_all_fonts[ $recipes_blog_font ]['variants'];
        $recipes_blog_font_family[] = $recipes_blog_font . ':' . implode( ',', $recipes_blog_variants );
    }

    $recipes_blog_query_args = array(
        'family' => urlencode( implode( '|', $recipes_blog_font_family ) ),
    );

    if ( ! empty( $recipes_blog_font_family ) ) {
        $recipes_blog_fonts_url = add_query_arg( $recipes_blog_query_args, 'https://fonts.googleapis.com/css' );
    }

    return $recipes_blog_fonts_url;
}