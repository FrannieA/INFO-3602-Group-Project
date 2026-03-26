<?php

/**
 * Color Option
 *
 * @package recipes_blog
 */

// Primary Color.
$wp_customize->add_setting(
	'recipes_blog_primary_color',
	array(
		'default'           => '#ff7a00',
		'sanitize_callback' => 'sanitize_hex_color',
	)
);

$wp_customize->add_control(
	new WP_Customize_Color_Control(
		$wp_customize,
		'recipes_blog_primary_color',
		array(
			'label'    => __( 'Primary Color', 'recipes-blog' ),
			'section'  => 'colors',
			'priority' => 5,
		)
	)
);