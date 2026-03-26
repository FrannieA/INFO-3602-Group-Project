<?php

/**
 * Excerpt
 *
 * @package recipes_blog
 */

$wp_customize->add_section(
	'recipes_blog_excerpt_options',
	array(
		'panel' => 'recipes_blog_theme_options',
		'title' => esc_html__( 'Excerpt', 'recipes-blog' ),
	)
);

// Excerpt - Excerpt Length.
$wp_customize->add_setting(
	'recipes_blog_excerpt_length',
	array(
		'default'           => 20,
		'sanitize_callback' => 'absint',
		'transport'         => 'refresh',
	)
);

$wp_customize->add_control(
	'recipes_blog_excerpt_length',
	array(
		'label'       => esc_html__( 'Excerpt Length (no. of words)', 'recipes-blog' ),
		'section'     => 'recipes_blog_excerpt_options',
		'settings'    => 'recipes_blog_excerpt_length',
		'type'        => 'number',
		'input_attrs' => array(
			'min'  => 10,
			'max'  => 200,
			'step' => 1,
		),
	)
);