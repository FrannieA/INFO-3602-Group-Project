<?php

/**
 * Front Page Options
 *
 * @package Recipes Blog
 */

$wp_customize->add_panel(
	'recipes_blog_front_page_options',
	array(
		'title'    => esc_html__( 'Front Page Options', 'recipes-blog' ),
		'priority' => 20,
	)
);

// Banner Section.
require get_template_directory() . '/theme-library/customizer/front-page-options/banner.php';

// Menus Section Section.
require get_template_directory() . '/theme-library/customizer/front-page-options/menus-section.php';