<?php

/**
 * WooCommerce Settings
 *
 * @package recipes_blog
 */

$wp_customize->add_section(
	'recipes_blog_woocommerce_settings',
	array(
		'panel' => 'recipes_blog_theme_options',
		'title' => esc_html__( 'WooCommerce Settings', 'recipes-blog' ),
	)
);

//WooCommerce - Products per page.
$wp_customize->add_setting( 'recipes_blog_products_per_page', array(
    'default'           => 9,
    'sanitize_callback' => 'absint',
));

$wp_customize->add_control( 'recipes_blog_products_per_page', array(
    'type'        => 'number',
    'section'     => 'recipes_blog_woocommerce_settings',
    'label'       => __( 'Products Per Page', 'recipes-blog' ),
    'input_attrs' => array(
        'min'  => 0,
        'max'  => 50,
        'step' => 1,
    ),
));

//WooCommerce - Products per row.
$wp_customize->add_setting( 'recipes_blog_products_per_row', array(
    'default'           => '3',
    'sanitize_callback' => 'recipes_blog_sanitize_choices',
) );

$wp_customize->add_control( 'recipes_blog_products_per_row', array(
    'label'    => __( 'Products Per Row', 'recipes-blog' ),
    'section'  => 'recipes_blog_woocommerce_settings',
    'settings' => 'recipes_blog_products_per_row',
    'type'     => 'select',
    'choices'  => array(
        '2' => '2',
		'3' => '3',
		'4' => '4',
    ),
) );

//WooCommerce - Show / Hide Related Product.
$wp_customize->add_setting(
	'recipes_blog_related_product_show_hide',
	array(
		'default'           => true,
		'sanitize_callback' => 'recipes_blog_sanitize_switch',
	)
);

$wp_customize->add_control(
	new Recipes_Blog_Toggle_Switch_Custom_Control(
		$wp_customize,
		'recipes_blog_related_product_show_hide',
		array(
			'label'   => esc_html__( 'Show / Hide Related product', 'recipes-blog' ),
			'section' => 'recipes_blog_woocommerce_settings',
		)
	)
);

//WooCommerce - Product Sale Position.
$wp_customize->add_setting(
	'recipes_blog_product_sale_position', 
	array(
		'default' => 'left',
		'sanitize_callback' => 'sanitize_text_field',
	)
);

$wp_customize->add_control(
	'recipes_blog_product_sale_position', 
	array(
		'label' => __('Product Sale Position', 'recipes-blog'),
		'section' => 'recipes_blog_woocommerce_settings',
		'settings' => 'recipes_blog_product_sale_position',
		'type' => 'radio',
		'choices' => 
	array(
		'left' => __('Left', 'recipes-blog'),
		'right' => __('Right', 'recipes-blog'),
	),
));