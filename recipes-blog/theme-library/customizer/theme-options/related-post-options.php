<?php

/**
 * Related Post Options
 *
 * @package recipes_blog
 */

$wp_customize->add_section(
	'recipes_blog_related_post_options',
	array(
		'title' => esc_html__( 'Related Post Options', 'recipes-blog' ),
		'panel' => 'recipes_blog_theme_options',
	)
);

// Add Separator Custom Control
$wp_customize->add_setting( 'recipes_blog_related_post_separator', array(
	'sanitize_callback' => 'sanitize_text_field',
) );

$wp_customize->add_control( new Recipes_Blog_Separator_Custom_Control( $wp_customize, 'recipes_blog_related_post_separator', array(
	'label' => __( 'Enable / Disable Related Post Section', 'recipes-blog' ),
	'section' => 'recipes_blog_related_post_options',
	'settings' => 'recipes_blog_related_post_separator',
) ) );

// Post Options - Show / Hide Related Posts.
$wp_customize->add_setting(
	'recipes_blog_post_hide_related_posts',
	array(
		'default'           => true,
		'sanitize_callback' => 'recipes_blog_sanitize_switch',
	)
);

$wp_customize->add_control(
	new Recipes_Blog_Toggle_Switch_Custom_Control(
		$wp_customize,
		'recipes_blog_post_hide_related_posts',
		array(
			'label'   => esc_html__( 'Show / Hide Related Posts', 'recipes-blog' ),
			'section' => 'recipes_blog_related_post_options',
		)
	)
);

// Register setting for number of related posts
$wp_customize->add_setting(
	'recipes_blog_related_posts_count',
	array(
		'default'           => 3,
		'sanitize_callback' => 'absint',
	)
);

// Add control for number of related posts
$wp_customize->add_control(
	'recipes_blog_related_posts_count',
	array(
		'type'        => 'number',
		'label'       => esc_html__( 'Number of Related Posts to Display', 'recipes-blog' ),
		'section'     => 'recipes_blog_related_post_options',
		'input_attrs' => array(
			'min'  => 1,
			'max'  => 5,
			'step' => 1,
		),
	)
);

// Post Options - Related Post Label.
$wp_customize->add_setting(
	'recipes_blog_post_related_post_label',
	array(
		'default'           => 'Related Posts',
		'sanitize_callback' => 'sanitize_text_field',
	)
);

$wp_customize->add_control(
	'recipes_blog_post_related_post_label',
	array(
		'label'    => esc_html__( 'Related Posts Label', 'recipes-blog' ),
		'section'  => 'recipes_blog_related_post_options',
		'settings' => 'recipes_blog_post_related_post_label',
		'type'     => 'text',
	)
);