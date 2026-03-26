<?php

/**
 * Typography Setting
 *
 * @package recipes_blog
 */

// Typography Setting
$wp_customize->add_section(
    'recipes_blog_typography_setting',
    array(
        'panel' => 'recipes_blog_theme_options',
        'title' => esc_html__( 'Typography Setting', 'recipes-blog' ),
    )
);

$wp_customize->add_setting(
    'recipes_blog_site_title_font',
    array(
        'default'           => 'Raleway',
        'sanitize_callback' => 'recipes_blog_sanitize_google_fonts',
    )
);

$wp_customize->add_control(
    'recipes_blog_site_title_font',
    array(
        'label'    => esc_html__( 'Site Title Font Family', 'recipes-blog' ),
        'section'  => 'recipes_blog_typography_setting',
        'settings' => 'recipes_blog_site_title_font',
        'type'     => 'select',
        'choices'  => recipes_blog_get_all_google_font_families(),
    )
);

// Typography - Site Description Font.
$wp_customize->add_setting(
	'recipes_blog_site_description_font',
	array(
		'default'           => 'Raleway',
		'sanitize_callback' => 'recipes_blog_sanitize_google_fonts',
	)
);

$wp_customize->add_control(
	'recipes_blog_site_description_font',
	array(
		'label'    => esc_html__( 'Site Description Font Family', 'recipes-blog' ),
		'section'  => 'recipes_blog_typography_setting',
		'settings' => 'recipes_blog_site_description_font',
		'type'     => 'select',
		'choices'  => recipes_blog_get_all_google_font_families(),
	)
);

// Typography - Header Font.
$wp_customize->add_setting(
	'recipes_blog_header_font',
	array(
		'default'           => 'Play',
		'sanitize_callback' => 'recipes_blog_sanitize_google_fonts',
	)
);

$wp_customize->add_control(
	'recipes_blog_header_font',
	array(
		'label'    => esc_html__( 'Heading Font Family', 'recipes-blog' ),
		'section'  => 'recipes_blog_typography_setting',
		'settings' => 'recipes_blog_header_font',
		'type'     => 'select',
		'choices'  => recipes_blog_get_all_google_font_families(),
	)
);

// Typography - Body Font.
$wp_customize->add_setting(
	'recipes_blog_content_font',
	array(
		'default'           => 'Readex Pro',
		'sanitize_callback' => 'recipes_blog_sanitize_google_fonts',
	)
);

$wp_customize->add_control(
	'recipes_blog_content_font',
	array(
		'label'    => esc_html__( 'Content Font Family', 'recipes-blog' ),
		'section'  => 'recipes_blog_typography_setting',
		'settings' => 'recipes_blog_content_font',
		'type'     => 'select',
		'choices'  => recipes_blog_get_all_google_font_families(),
	)
);
