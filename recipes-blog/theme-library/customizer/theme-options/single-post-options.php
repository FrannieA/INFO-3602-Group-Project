<?php

/**
 * Single Post Options
 *
 * @package recipes_blog
 */

$wp_customize->add_section(
	'recipes_blog_single_post_options',
	array(
		'title' => esc_html__( 'Single Post Options', 'recipes-blog' ),
		'panel' => 'recipes_blog_theme_options',
	)
);


// Post Options - Show / Hide Date.
$wp_customize->add_setting(
	'recipes_blog_single_post_hide_date',
	array(
		'default'           => true,
		'sanitize_callback' => 'recipes_blog_sanitize_switch',
	)
);

$wp_customize->add_control(
	new Recipes_Blog_Toggle_Switch_Custom_Control(
		$wp_customize,
		'recipes_blog_single_post_hide_date',
		array(
			'label'   => esc_html__( 'Show / Hide Date', 'recipes-blog' ),
			'section' => 'recipes_blog_single_post_options',
		)
	)
);

// Post Options - Show / Hide Author.
$wp_customize->add_setting(
	'recipes_blog_single_post_hide_author',
	array(
		'default'           => true,
		'sanitize_callback' => 'recipes_blog_sanitize_switch',
	)
);

$wp_customize->add_control(
	new Recipes_Blog_Toggle_Switch_Custom_Control(
		$wp_customize,
		'recipes_blog_single_post_hide_author',
		array(
			'label'   => esc_html__( 'Show / Hide Author', 'recipes-blog' ),
			'section' => 'recipes_blog_single_post_options',
		)
	)
);

// Post Options - Show / Hide Comments.
$wp_customize->add_setting(
	'recipes_blog_single_post_hide_comments',
	array(
		'default'           => true,
		'sanitize_callback' => 'recipes_blog_sanitize_switch',
	)
);

$wp_customize->add_control(
	new Recipes_Blog_Toggle_Switch_Custom_Control(
		$wp_customize,
		'recipes_blog_single_post_hide_comments',
		array(
			'label'   => esc_html__( 'Show / Hide Comments', 'recipes-blog' ),
			'section' => 'recipes_blog_single_post_options',
		)
	)
);

// Post Options - Show / Hide Time.
$wp_customize->add_setting(
	'recipes_blog_single_post_hide_time',
	array(
		'default'           => true,
		'sanitize_callback' => 'recipes_blog_sanitize_switch',
	)
);

$wp_customize->add_control(
	new Recipes_Blog_Toggle_Switch_Custom_Control(
		$wp_customize,
		'recipes_blog_single_post_hide_time',
		array(
			'label'   => esc_html__( 'Show / Hide Time', 'recipes-blog' ),
			'section' => 'recipes_blog_single_post_options',
		)
	)
);

// Post Options - Show / Hide Category.
$wp_customize->add_setting(
	'recipes_blog_single_post_hide_category',
	array(
		'default'           => true,
		'sanitize_callback' => 'recipes_blog_sanitize_switch',
	)
);

$wp_customize->add_control(
	new Recipes_Blog_Toggle_Switch_Custom_Control(
		$wp_customize,
		'recipes_blog_single_post_hide_category',
		array(
			'label'   => esc_html__( 'Show / Hide Category', 'recipes-blog' ),
			'section' => 'recipes_blog_single_post_options',
		)
	)
);

// Post Options - Show / Hide Tag.
$wp_customize->add_setting(
	'recipes_blog_post_hide_tags',
	array(
		'default'           => true,
		'sanitize_callback' => 'recipes_blog_sanitize_switch',
	)
);

$wp_customize->add_control(
	new Recipes_Blog_Toggle_Switch_Custom_Control(
		$wp_customize,
		'recipes_blog_post_hide_tags',
		array(
			'label'   => esc_html__( 'Show / Hide Tag', 'recipes-blog' ),
			'section' => 'recipes_blog_single_post_options',
		)
	)
);

// Post Options - Comment Title.
$wp_customize->add_setting(
	'recipes_blog_blog_post_comment_title',
	array(
		'default'=> 'Leave a Reply',
		'sanitize_callback'	=> 'sanitize_text_field'
	)
);

$wp_customize->add_control(
	'recipes_blog_blog_post_comment_title',
	array(
		'label'	=> __('Comment Title','recipes-blog'),
		'input_attrs' => array(
			'placeholder' => __( 'Leave a Reply', 'recipes-blog' ),
		),
		'section'=> 'recipes_blog_single_post_options',
		'type'=> 'text'
	)
);