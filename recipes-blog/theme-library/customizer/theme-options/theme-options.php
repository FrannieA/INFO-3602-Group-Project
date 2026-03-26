<?php

/**
 * Header Options
 *
 * @package recipes_blog
 */
// ---------------------------------------- GENERAL OPTIONBS ----------------------------------------------------


// ---------------------------------------- PRELOADER -----------------------------------------------


$wp_customize->add_section(
	'recipes_blog_general_options',
	array(
		'panel' => 'recipes_blog_theme_options',
		'title' => esc_html__( 'General Options', 'recipes-blog' ),
	)
);

	// Add Separator Custom Control
	$wp_customize->add_setting( 'recipes_blog_preloader_separator', array(
		'sanitize_callback' => 'sanitize_text_field',
	) );

	$wp_customize->add_control( new Recipes_Blog_Separator_Custom_Control( $wp_customize, 'recipes_blog_preloader_separator', array(
		'label' => __( 'Enable / Disable Site Preloader Section', 'recipes-blog' ),
		'section' => 'recipes_blog_general_options',
		'settings' => 'recipes_blog_preloader_separator',
	) ) );

// General Options - Enable Preloader.
$wp_customize->add_setting(
	'recipes_blog_enable_preloader',
	array(
		'sanitize_callback' => 'recipes_blog_sanitize_switch',
		'default'           => false,
	)
);

$wp_customize->add_control(
	new Recipes_Blog_Toggle_Switch_Custom_Control(
		$wp_customize,
		'recipes_blog_enable_preloader',
		array(
			'label'   => esc_html__( 'Enable Preloader', 'recipes-blog' ),
			'section' => 'recipes_blog_general_options',
		)
	)
);

// Preloader Style Setting
$wp_customize->add_setting(
    'recipes_blog_preloader_style',
    array(
        'default'           => 'style1',
        'sanitize_callback' => 'sanitize_text_field',
    )
);

$wp_customize->add_control(
    'recipes_blog_preloader_style',
    array(
        'type'     => 'select',
        'label'    => esc_html__('Select Preloader Styles', 'recipes-blog'),
		'active_callback' => 'recipes_blog_is_preloader_style',
        'section'  => 'recipes_blog_general_options',
        'choices'  => array(
            'style1' => esc_html__('Style 1', 'recipes-blog'),
            'style2' => esc_html__('Style 2', 'recipes-blog'),
            'style3' => esc_html__('Style 3', 'recipes-blog'),
        ),
    )
);


// Preloader Background Color Setting
$wp_customize->add_setting(
	'recipes_blog_preloader_background_color_setting',
	 array(
		'default' => '',
		'sanitize_callback' => 'sanitize_hex_color',
	)
);

$wp_customize->add_control(
	new WP_Customize_Color_Control(
		$wp_customize, 'recipes_blog_preloader_background_color_setting', 
		array(
			'label' => __('Preloader Background Color', 'recipes-blog'),
			'active_callback' => 'recipes_blog_is_preloader_style',
			'section' => 'recipes_blog_general_options',
		)
	)
);

// Preloader Background Image Setting
$wp_customize->add_setting(
	'recipes_blog_preloader_background_image_setting', 
	array(
		'default' => '',
		'sanitize_callback' => 'esc_url_raw',
	)
);

$wp_customize->add_control(
	new WP_Customize_Image_Control(
		$wp_customize, 'recipes_blog_preloader_background_image_setting',
		 array(
			'label' => __('Preloader Background Image', 'recipes-blog'),
			'active_callback' => 'recipes_blog_is_preloader_style',
			'section' => 'recipes_blog_general_options',
		)
	)
);

// ---------------------------------------- BREADCRUMB ----------------------------------------------------


// Add Separator Custom Control
$wp_customize->add_setting( 'recipes_blog_breadcrumb_separators', array(
	'sanitize_callback' => 'sanitize_text_field',
) );

$wp_customize->add_control( new Recipes_Blog_Separator_Custom_Control( $wp_customize, 'recipes_blog_breadcrumb_separators', array(
	'label' => __( 'Enable / Disable Breadcrumb Section', 'recipes-blog' ),
	'section' => 'recipes_blog_general_options',
	'settings' => 'recipes_blog_breadcrumb_separators',
)));


// Breadcrumb - Enable Breadcrumb.
$wp_customize->add_setting(
	'recipes_blog_enable_breadcrumb',
	array(
		'sanitize_callback' => 'recipes_blog_sanitize_switch',
		'default'           => true,
	)
);

$wp_customize->add_control(
	new Recipes_Blog_Toggle_Switch_Custom_Control(
		$wp_customize,
		'recipes_blog_enable_breadcrumb',
		array(
			'label'   => esc_html__( 'Enable Breadcrumb', 'recipes-blog' ),
			'section' => 'recipes_blog_general_options',
		)
	)
);

// Breadcrumb - Separator.
$wp_customize->add_setting(
	'recipes_blog_breadcrumb_separator',
	array(
		'sanitize_callback' => 'sanitize_text_field',
		'default'           => '/',
	)
);

$wp_customize->add_control(
	'recipes_blog_breadcrumb_separator',
	array(
		'label'           => esc_html__( 'Separator', 'recipes-blog' ),
		'active_callback' => 'recipes_blog_is_breadcrumb_enabled',
		'section'         => 'recipes_blog_general_options',
	)
);



// ---------------------------------------- PAGINATION ----------------------------------------------------


// Add Separator Custom Control
$wp_customize->add_setting( 'recipes_blog_pagination_separator', array(
	'sanitize_callback' => 'sanitize_text_field',
) );

$wp_customize->add_control( new Recipes_Blog_Separator_Custom_Control( $wp_customize, 'recipes_blog_pagination_separator', array(
	'label' => __( 'Enable / Disable Pagination Section', 'recipes-blog' ),
	'section' => 'recipes_blog_general_options',
	'settings' => 'recipes_blog_pagination_separator',
) ) );


// Pagination - Enable Pagination.
$wp_customize->add_setting(
	'recipes_blog_enable_pagination',
	array(
		'default'           => true,
		'sanitize_callback' => 'recipes_blog_sanitize_switch',
	)
);

$wp_customize->add_control(
	new Recipes_Blog_Toggle_Switch_Custom_Control(
		$wp_customize,
		'recipes_blog_enable_pagination',
		array(
			'label'    => esc_html__( 'Enable Pagination', 'recipes-blog' ),
			'section'  => 'recipes_blog_general_options',
			'settings' => 'recipes_blog_enable_pagination',
			'type'     => 'checkbox',
		)
	)
);

// Pagination - Pagination Type.
$wp_customize->add_setting(
	'recipes_blog_pagination_type',
	array(
		'default'           => 'default',
		'sanitize_callback' => 'recipes_blog_sanitize_select',
	)
);

$wp_customize->add_control(
	'recipes_blog_pagination_type',
	array(
		'label'           => esc_html__( 'Pagination Type', 'recipes-blog' ),
		'section'         => 'recipes_blog_general_options',
		'settings'        => 'recipes_blog_pagination_type',
		'active_callback' => 'recipes_blog_is_pagination_enabled',
		'type'            => 'select',
		'choices'         => array(
			'default' => __( 'Default (Older/Newer)', 'recipes-blog' ),
			'numeric' => __( 'Numeric', 'recipes-blog' ),
		),
	)
);



// ---------------------------------------- Website layout ----------------------------------------------------


// Add Separator Custom Control
$wp_customize->add_setting( 'recipes_blog_layuout_separator', array(
	'sanitize_callback' => 'sanitize_text_field',
) );

$wp_customize->add_control( new Recipes_Blog_Separator_Custom_Control( $wp_customize, 'recipes_blog_layuout_separator', array(
	'label' => __( 'Website Layout Setting', 'recipes-blog' ),
	'section' => 'recipes_blog_general_options',
	'settings' => 'recipes_blog_layuout_separator',
)));


$wp_customize->add_setting(
	'recipes_blog_website_layout',
	array(
		'sanitize_callback' => 'recipes_blog_sanitize_switch',
		'default'           => false,
	)
);

$wp_customize->add_control(
	new Recipes_Blog_Toggle_Switch_Custom_Control(
		$wp_customize,
		'recipes_blog_website_layout',
		array(
			'label'   => esc_html__('Boxed Layout', 'recipes-blog'),
			'section' => 'recipes_blog_general_options',
		)
	)
);


$wp_customize->add_setting('recipes_blog_layout_width_margin', array(
	'default'           => 50,
	'sanitize_callback' => 'recipes_blog_sanitize_range_value',
));

$wp_customize->add_control(new Recipes_Blog_Customize_Range_Control($wp_customize, 'recipes_blog_layout_width_margin', array(
		'label'       => __('Set Width', 'recipes-blog'),
		'description' => __('Adjust the width around the website layout by moving the slider. Use this setting to customize the appearance of your site to fit your design preferences.', 'recipes-blog'),
		'section'     => 'recipes_blog_general_options',
		'settings'    => 'recipes_blog_layout_width_margin',
		'active_callback' => 'recipes_blog_is_layout_enabled',
		'input_attrs' => array(
			'min'  => 0,
			'max'  => 130,
			'step' => 1,
		),
)));


// ---------------------------------------- HEADER OPTIONS ----------------------------------------------------	


$wp_customize->add_section(
	'recipes_blog_header_options',
	array(
		'panel' => 'recipes_blog_theme_options',
		'title' => esc_html__( 'Header Options', 'recipes-blog' ),
	)
);


// Add setting for sticky header
$wp_customize->add_setting(
	'recipes_blog_enable_sticky_header',
	array(
		'sanitize_callback' => 'recipes_blog_sanitize_switch',
		'default'           => false,
	)
);

// Add control for sticky header setting
$wp_customize->add_control(
	new Recipes_Blog_Toggle_Switch_Custom_Control(
		$wp_customize,
		'recipes_blog_enable_sticky_header',
		array(
			'label'   => esc_html__( 'Enable Sticky Menu', 'recipes-blog' ),
			'section' => 'recipes_blog_header_options',
		)
	)
);

// Header Options - Enable Topbar.
$wp_customize->add_setting(
	'recipes_blog_enable_topbar',
	array(
		'sanitize_callback' => 'recipes_blog_sanitize_switch',
		'default'           => true,
	)
);

$wp_customize->add_control(
	new Recipes_Blog_Toggle_Switch_Custom_Control(
		$wp_customize,
		'recipes_blog_enable_topbar',
		array(
			'label'   => esc_html__( 'Enable Topbar', 'recipes-blog' ),
			'section' => 'recipes_blog_header_options',
		)
	)
);

// Header Options - Welcome Text.
$wp_customize->add_setting(
	'recipes_blog_welcome_topbar_text',
	array(
		'default'           => '',
		'sanitize_callback' => 'sanitize_text_field',
	)
);

$wp_customize->add_control(
	'recipes_blog_welcome_topbar_text',
	array(
		'label'           => esc_html__( 'Topbar Text', 'recipes-blog' ),
		'section'         => 'recipes_blog_header_options',
		'type'            => 'text',
		'active_callback' => 'recipes_blog_is_topbar_enabled',
	)
);

// Add Separator Custom Control
$wp_customize->add_setting( 'recipes_blog_menu_separator', array(
	'sanitize_callback' => 'sanitize_text_field',
) );

$wp_customize->add_control( new Recipes_Blog_Separator_Custom_Control( $wp_customize, 'recipes_blog_menu_separator', array(
	'label' => __( 'Menu Settings', 'recipes-blog' ),
	'section' => 'recipes_blog_header_options',
	'settings' => 'recipes_blog_menu_separator',
)));

$wp_customize->add_setting( 'recipes_blog_menu_font_size', array(
    'default'           => 15,
    'sanitize_callback' => 'absint',
) );

// Add control for site title size
$wp_customize->add_control( 'recipes_blog_menu_font_size', array(
    'type'        => 'number',
    'section'     => 'recipes_blog_header_options',
    'label'       => __( 'Menu Font Size ', 'recipes-blog' ),
    'input_attrs' => array(
        'min'  => 10,
        'max'  => 100,
        'step' => 1,
    ),
));

// Add setting for menu text transform
$wp_customize->add_setting('menu_text_transform', array(
    'default'           => 'capitalize', // Default value for text transform
    'sanitize_callback' => 'sanitize_text_field',
));

// Add control for menu text transform
$wp_customize->add_control('menu_text_transform', array(
    'type'     => 'select',
    'section'  => 'recipes_blog_header_options', // Section where the control will appear
    'label'    => __('Menu Text Transform', 'recipes-blog'),
    'choices'  => array(
        'none'       => __('None', 'recipes-blog'),
        'capitalize' => __('Capitalize', 'recipes-blog'),
        'uppercase'  => __('Uppercase', 'recipes-blog'),
        'lowercase'  => __('Lowercase', 'recipes-blog'),
    ),
));

// Menu Text Color 
$wp_customize->add_setting(
	'recipes_blog_menu_text_color', 
	array(
		'default' => '',
		'sanitize_callback' => 'sanitize_hex_color',
	)
);

$wp_customize->add_control(
	new WP_Customize_Color_Control(
		$wp_customize, 
		'recipes_blog_menu_text_color', 
		array(
			'label' => __('Menu Color', 'recipes-blog'),
			'section' => 'recipes_blog_header_options',
		)
	)
);

// Sub Menu Text Color 
$wp_customize->add_setting(
	'recipes_blog_sub_menu_text_color', 
	array(
		'default' => '',
		'sanitize_callback' => 'sanitize_hex_color',
	)
);

$wp_customize->add_control(
	new WP_Customize_Color_Control(
		$wp_customize, 
		'recipes_blog_sub_menu_text_color', 
		array(
			'label' => __('Sub Menu Color', 'recipes-blog'),
			'section' => 'recipes_blog_header_options',
		)
	)
);

// ----------------------------------------SITE IDENTITY----------------------------------------------------

$wp_customize->add_setting( 'recipes_blog_site_title_size', array(
    'default'           => 40, // Default font size in pixels
    'sanitize_callback' => 'absint', // Sanitize the input as a positive integer
) );

// Add control for site title size
$wp_customize->add_control( 'recipes_blog_site_title_size', array(
    'type'        => 'number',
    'section'     => 'title_tagline', // You can change this section to your preferred section
    'label'       => __( 'Site Title Font Size ', 'recipes-blog' ),
    'input_attrs' => array(
        'min'  => 10,
        'max'  => 100,
        'step' => 1,
    ),
) );

// Site Logo - Enable Setting.
$wp_customize->add_setting(
	'recipes_blog_enable_site_logo',
	array(
		'default'           => true, // Default is to display the logo.
		'sanitize_callback' => 'recipes_blog_sanitize_switch', // Sanitize using a custom switch function.
	)
);

$wp_customize->add_control(
	new Recipes_Blog_Toggle_Switch_Custom_Control(
		$wp_customize,
		'recipes_blog_enable_site_logo',
		array(
			'label'    => esc_html__( 'Enable Site Logo', 'recipes-blog' ),
			'section'  => 'title_tagline', // Section to add this control.
			'settings' => 'recipes_blog_enable_site_logo',
		)
	)
);

// Site Title - Enable Setting.
$wp_customize->add_setting(
	'recipes_blog_enable_site_title_setting',
	array(
		'default'           => false,
		'sanitize_callback' => 'recipes_blog_sanitize_switch',
	)
);

$wp_customize->add_control(
	new Recipes_Blog_Toggle_Switch_Custom_Control(
		$wp_customize,
		'recipes_blog_enable_site_title_setting',
		array(
			'label'    => esc_html__( 'Enable Site Title', 'recipes-blog' ),
			'section'  => 'title_tagline',
			'settings' => 'recipes_blog_enable_site_title_setting',
		)
	)
);


// Tagline - Enable Setting.
$wp_customize->add_setting(
	'recipes_blog_enable_tagline_setting',
	array(
		'default'           => false,
		'sanitize_callback' => 'recipes_blog_sanitize_switch',
	)
);

$wp_customize->add_control(
	new Recipes_Blog_Toggle_Switch_Custom_Control(
		$wp_customize,
		'recipes_blog_enable_tagline_setting',
		array(
			'label'    => esc_html__( 'Enable Tagline', 'recipes-blog' ),
			'section'  => 'title_tagline',
			'settings' => 'recipes_blog_enable_tagline_setting',
		)
	)
);

$wp_customize->add_setting('recipes_blog_site_logo_width', array(
    'default'           => 200,
    'sanitize_callback' => 'recipes_blog_sanitize_range_value',
));

$wp_customize->add_control(new Recipes_Blog_Customize_Range_Control($wp_customize, 'recipes_blog_site_logo_width', array(
    'label'       => __('Adjust Site Logo Width', 'recipes-blog'),
    'description' => __('This setting controls the Width of Site Logo', 'recipes-blog'),
    'section'     => 'title_tagline',
    'settings'    => 'recipes_blog_site_logo_width',
    'input_attrs' => array(
        'min'  => 0,
        'max'  => 400,
        'step' => 5,
    ),
)));

// ---------------------------------------- ANIMATION ----------------------------------------------------

$wp_customize->add_setting( 'recipes_blog_animation_separator', array(
	'sanitize_callback' => 'sanitize_text_field',
) );
$wp_customize->add_control( new Recipes_Blog_Separator_Custom_Control( $wp_customize, 'recipes_blog_animation_separator', array(
	'label' => __( 'Enable / Disable Animation', 'recipes-blog' ),
	'section' => 'recipes_blog_general_options',
	'settings' => 'recipes_blog_animation_separator',
) ) );
// Animation Enable / Disable
$wp_customize->add_setting('recipes_blog_enable_animation',array(
		'default'           => true,
		'sanitize_callback' => 'recipes_blog_sanitize_switch',
	)
);
$wp_customize->add_control(
	new Recipes_Blog_Toggle_Switch_Custom_Control($wp_customize,'recipes_blog_enable_animation',array(
			'label'   => esc_html__( 'Enable Animation', 'recipes-blog' ),
			'section' => 'recipes_blog_general_options',
		)
	)
);