<?php

/**
 * Sidebar Position
 *
 * @package recipes_blog
 */

$wp_customize->add_section(
	'recipes_blog_sidebar_position',
	array(
		'title' => esc_html__( 'Sidebar Position', 'recipes-blog' ),
		'panel' => 'recipes_blog_theme_options',
	)
);


// Add Separator Custom Control
$wp_customize->add_setting( 'recipes_blog_global_sidebar_separator', array(
	'sanitize_callback' => 'sanitize_text_field',
) );

$wp_customize->add_control( new Recipes_Blog_Separator_Custom_Control( $wp_customize, 'recipes_blog_global_sidebar_separator', array(
	'label' => __( 'Global Sidebar Position', 'recipes-blog' ),
	'section' => 'recipes_blog_sidebar_position',
	'settings' => 'recipes_blog_global_sidebar_separator',
)));

// Sidebar Position - Global Sidebar Position.
$wp_customize->add_setting(
	'recipes_blog_sidebar_position',
	array(
		'sanitize_callback' => 'recipes_blog_sanitize_select',
		'default'           => 'right-sidebar',
	)
);

$wp_customize->add_control(
	'recipes_blog_sidebar_position',
	array(
		'label'   => esc_html__( 'Select Sidebar Position', 'recipes-blog' ),
		'section' => 'recipes_blog_sidebar_position',
		'type'    => 'select',
		'choices' => array(
			'right-sidebar' => esc_html__( 'Right Sidebar', 'recipes-blog' ),
			'left-sidebar'  => esc_html__( 'Left Sidebar', 'recipes-blog' ),
			'no-sidebar'    => esc_html__( 'No Sidebar', 'recipes-blog' ),
		),
	)
);


// Add Separator Custom Control
$wp_customize->add_setting( 'recipes_blog_post_sidebar_separator', array(
	'sanitize_callback' => 'sanitize_text_field',
) );

$wp_customize->add_control( new Recipes_Blog_Separator_Custom_Control( $wp_customize, 'recipes_blog_post_sidebar_separator', array(
	'label' => __( 'Post Sidebar Position', 'recipes-blog' ),
	'section' => 'recipes_blog_sidebar_position',
	'settings' => 'recipes_blog_post_sidebar_separator',
)));


// Sidebar Position - Post Sidebar Position.
$wp_customize->add_setting(
	'recipes_blog_post_sidebar_position',
	array(
		'sanitize_callback' => 'recipes_blog_sanitize_select',
		'default'           => 'right-sidebar',
	)
);

$wp_customize->add_control(
	'recipes_blog_post_sidebar_position',
	array(
		'label'   => esc_html__( 'Select Sidebar Position', 'recipes-blog' ),
		'section' => 'recipes_blog_sidebar_position',
		'type'    => 'select',
		'choices' => array(
			'right-sidebar' => esc_html__( 'Right Sidebar', 'recipes-blog' ),
			'left-sidebar'  => esc_html__( 'Left Sidebar', 'recipes-blog' ),
			'no-sidebar'    => esc_html__( 'No Sidebar', 'recipes-blog' ),
		),
	)
);


// Add Separator Custom Control
$wp_customize->add_setting( 'recipes_blog_page_sidebar_separator', array(
	'sanitize_callback' => 'sanitize_text_field',
) );

$wp_customize->add_control( new Recipes_Blog_Separator_Custom_Control( $wp_customize, 'recipes_blog_page_sidebar_separator', array(
	'label' => __( 'Page Sidebar Position', 'recipes-blog' ),
	'section' => 'recipes_blog_sidebar_position',
	'settings' => 'recipes_blog_page_sidebar_separator',
)));


// Sidebar Position - Page Sidebar Position.
$wp_customize->add_setting(
	'recipes_blog_page_sidebar_position',
	array(
		'sanitize_callback' => 'recipes_blog_sanitize_select',
		'default'           => 'right-sidebar',
	)
);

$wp_customize->add_control(
	'recipes_blog_page_sidebar_position',
	array(
		'label'   => esc_html__( 'Select Sidebar Position', 'recipes-blog' ),
		'section' => 'recipes_blog_sidebar_position',
		'type'    => 'select',
		'choices' => array(
			'right-sidebar' => esc_html__( 'Right Sidebar', 'recipes-blog' ),
			'left-sidebar'  => esc_html__( 'Left Sidebar', 'recipes-blog' ),
			'no-sidebar'    => esc_html__( 'No Sidebar', 'recipes-blog' ),
		),
	)
);

// Add Separator Custom Control
$wp_customize->add_setting( 'recipes_blog_sidebar_width_separator', array(
	'sanitize_callback' => 'sanitize_text_field',
) );

$wp_customize->add_control( new Recipes_Blog_Separator_Custom_Control( $wp_customize, 'recipes_blog_sidebar_width_separator', array(
	'label' => __( 'Sidebar Width Setting', 'recipes-blog' ),
	'section' => 'recipes_blog_sidebar_position',
	'settings' => 'recipes_blog_sidebar_width_separator',
)));


$wp_customize->add_setting( 'recipes_blog_sidebar_width', array(
	'default'           => '30',
	'sanitize_callback' => 'recipes_blog_sanitize_range_value',
) );

$wp_customize->add_control(new Recipes_Blog_Customize_Range_Control($wp_customize, 'recipes_blog_sidebar_width', array(
	'section'     => 'recipes_blog_sidebar_position',
	'label'       => __( 'Adjust Sidebar Width', 'recipes-blog' ),
	'description' => __( 'Adjust the width of the sidebar.', 'recipes-blog' ),
	'input_attrs' => array(
		'min'  => 10,
		'max'  => 50,
		'step' => 1,
	),
)));
$wp_customize->add_setting( 'recipes_blog_sidebar_widget_font_size', array(
    'default'           => 24,
    'sanitize_callback' => 'absint',
) );

// Add control for site title size
$wp_customize->add_control( 'recipes_blog_sidebar_widget_font_size', array(
    'type'        => 'number',
    'section'     => 'recipes_blog_sidebar_position',
    'label'       => __( 'Sidebar Widgets Heading Font Size ', 'recipes-blog' ),
    'input_attrs' => array(
        'min'  => 10,
        'max'  => 100,
        'step' => 1,
    ),
));