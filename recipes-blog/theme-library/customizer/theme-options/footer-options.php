<?php

/**
 * Footer Options
 *
 * @package recipes_blog
 */

$wp_customize->add_section(
	'recipes_blog_footer_options',
	array(
		'panel' => 'recipes_blog_theme_options',
		'title' => esc_html__( 'Footer Options', 'recipes-blog' ),
	)
);

// Add Separator Custom Control
$wp_customize->add_setting( 'recipes_blog_footer_separators', array(
	'sanitize_callback' => 'sanitize_text_field',
) );

$wp_customize->add_control( new Recipes_Blog_Separator_Custom_Control( $wp_customize, 'recipes_blog_footer_separators', array(
	'label' => __( 'Footer Settings', 'recipes-blog' ),
	'section' => 'recipes_blog_footer_options',
	'settings' => 'recipes_blog_footer_separators',
)));

// Footer Section - Enable Section.
$wp_customize->add_setting(
	'recipes_blog_enable_footer_section',
	array(
		'default'           => true,
		'sanitize_callback' => 'recipes_blog_sanitize_switch',
	)
);

$wp_customize->add_control(
	new Recipes_Blog_Toggle_Switch_Custom_Control(
		$wp_customize,
		'recipes_blog_enable_footer_section',
		array(
			'label'    => esc_html__( 'Show / Hide Footer', 'recipes-blog' ),
			'section'  => 'recipes_blog_footer_options',
			'settings' => 'recipes_blog_enable_footer_section',
		)
	)
);

// column // 
$wp_customize->add_setting(
	'recipes_blog_footer_widget_column',
	array(
        'default'			=> '4',
		'capability'     	=> 'edit_theme_options',
		'sanitize_callback' => 'recipes_blog_sanitize_select',
		
	)
);	

$wp_customize->add_control(
	'recipes_blog_footer_widget_column',
	array(
		'label'   		=> __('Select Footer Widget Column','recipes-blog'),
		'description' => __('Note: Default footer widgets are shown. Add your preferred widgets in (Appearance > Widgets > Footer) to see changes.', 'recipes-blog'),	    'section' 		=> 'recipes_blog_footer_options',
		'type'			=> 'select',
		'choices'        => 
		array(
			'' => __( 'None', 'recipes-blog' ),
			'1' => __( '1 Column', 'recipes-blog' ),
			'2' => __( '2 Column', 'recipes-blog' ),
			'3' => __( '3 Column', 'recipes-blog' ),
			'4' => __( '4 Column', 'recipes-blog' )
		) 
	) 
);
//  Image // 
$wp_customize->add_setting('recipes_blog_footer_background_color_setting', array(
    'default' => '#1f1f1f',
    'sanitize_callback' => 'sanitize_hex_color',
));

$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'recipes_blog_footer_background_color_setting', array(
    'label' => __('Footer Background Color', 'recipes-blog'),
    'section' => 'recipes_blog_footer_options',
)));

// Footer Background Image Setting
$wp_customize->add_setting('recipes_blog_footer_background_image_setting', array(
    'default' => '',
    'sanitize_callback' => 'esc_url_raw',
));

$wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'recipes_blog_footer_background_image_setting', array(
    'label' => __('Footer Background Image', 'recipes-blog'),
    'section' => 'recipes_blog_footer_options',
)));

// Footer Background Attachment
$wp_customize->add_setting(
	'recipes_blog_footer_image_attachment_setting',
	array(
		'default'=> 'scroll',
		'sanitize_callback' => 'recipes_blog_sanitize_choices'
	)
);

$wp_customize->add_control(
	'recipes_blog_footer_image_attachment_setting',
	array(
		'type' => 'select',
		'label' => __('Footer Background Attatchment','recipes-blog'),
		'choices' => array(
			'fixed' => __('fixed','recipes-blog'),
			'scroll' => __('scroll','recipes-blog'),
		),
		'section'=> 'recipes_blog_footer_options',
  	)
);

$wp_customize->add_setting('footer_text_transform', array(
    'default' => 'none',
    'sanitize_callback' => 'sanitize_text_field',
));

// Add Footer Heading Text Transform Control
$wp_customize->add_control('footer_text_transform', array(
    'label' => __('Footer Heading Text Transform', 'recipes-blog'),
    'section' => 'recipes_blog_footer_options',
    'settings' => 'footer_text_transform',
    'type' => 'select',
    'choices' => array(
        'none' => __('None', 'recipes-blog'),
        'capitalize' => __('Capitalize', 'recipes-blog'),
        'uppercase' => __('Uppercase', 'recipes-blog'),
        'lowercase' => __('Lowercase', 'recipes-blog'),
    ),
));


// Footer Heading Alignment
$wp_customize->add_setting(
	'recipes_blog_footer_header_align',
	array(
		'default' 			=> 'left',
		'sanitize_callback' => 'sanitize_text_field'
	)
);

$wp_customize->add_control(
	'recipes_blog_footer_header_align',
	array(
		'label' => __('Footer Heading Alignment ','recipes-blog'),
		'section' => 'recipes_blog_footer_options',
		'type'			=> 'select',
		'choices' => 
		array(
			'left' => __('Left','recipes-blog'),
			'right' => __('Right','recipes-blog'),
			'center' => __('Center','recipes-blog'),
		),
	)
);

// Add Separator Custom Control
$wp_customize->add_setting( 'recipes_blog_copyright_separators', array(
	'sanitize_callback' => 'sanitize_text_field',
) );

$wp_customize->add_control( new Recipes_Blog_Separator_Custom_Control( $wp_customize, 'recipes_blog_copyright_separators', array(
	'label' => __( 'Copyright Settings', 'recipes-blog' ),
	'section' => 'recipes_blog_footer_options',
	'settings' => 'recipes_blog_copyright_separators',
)));

// Copyright Section - Enable Section.
$wp_customize->add_setting(
	'recipes_blog_enable_copyright_section',
	array(
		'default'           => true,
		'sanitize_callback' => 'recipes_blog_sanitize_switch',
	)
);

$wp_customize->add_control(
	new Recipes_Blog_Toggle_Switch_Custom_Control(
		$wp_customize,
		'recipes_blog_enable_copyright_section',
		array(
			'label'    => esc_html__( 'Show / Hide Copyright', 'recipes-blog' ),
			'section'  => 'recipes_blog_footer_options',
			'settings' => 'recipes_blog_enable_copyright_section',
		)
	)
);

$wp_customize->add_setting(
	'recipes_blog_footer_copyright_text',
	array(
		'default'           => '',
		'sanitize_callback' => 'wp_kses_post',
		'transport'         => 'refresh',
	)
);

$wp_customize->add_control(
	'recipes_blog_footer_copyright_text',
	array(
		'label'    => esc_html__( 'Copyright Text', 'recipes-blog' ),
		'section'  => 'recipes_blog_footer_options',
		'settings' => 'recipes_blog_footer_copyright_text',
		'type'     => 'textarea',
	)
);

//Copyright Alignment
$wp_customize->add_setting(
	'recipes_blog_footer_bottom_align',
	array(
		'default' 			=> 'center',
		'sanitize_callback' => 'sanitize_text_field'
	)
);

$wp_customize->add_control(
	'recipes_blog_footer_bottom_align',
	array(
		'label' => __('Copyright Alignment ','recipes-blog'),
		'section' => 'recipes_blog_footer_options',
		'type'			=> 'select',
		'choices' => 
		array(
			'left' => __('Left','recipes-blog'),
			'right' => __('Right','recipes-blog'),
			'center' => __('Center','recipes-blog'),
		),
	)
);

//Copyright Font Size
$wp_customize->add_setting( 
	'recipes_blog_copyright_font_size', 
	array(
		'default'           => 16,
		'sanitize_callback' => 'absint',
	)
);

$wp_customize->add_control( 'recipes_blog_copyright_font_size', 
	array(
		'type'        => 'number',
		'section'     => 'recipes_blog_footer_options',
		'label'       => __( 'Copyright Font Size ', 'recipes-blog' ),
		'input_attrs' => 
		array(
			'min'  => 10,
			'max'  => 100,
			'step' => 1,
		),
	)
);

// Add Separator Custom Control
$wp_customize->add_setting( 'recipes_blog_scroll_separators', array(
	'sanitize_callback' => 'sanitize_text_field',
) );

$wp_customize->add_control( new Recipes_Blog_Separator_Custom_Control( $wp_customize, 'recipes_blog_scroll_separators', array(
	'label' => __( 'Scroll Top Settings', 'recipes-blog' ),
	'section' => 'recipes_blog_footer_options',
	'settings' => 'recipes_blog_scroll_separators',
)));

// Footer Options - Scroll Top.
$wp_customize->add_setting(
	'recipes_blog_scroll_top',
	array(
		'sanitize_callback' => 'recipes_blog_sanitize_switch',
		'default'           => true,
	)
);

$wp_customize->add_control(
	new Recipes_Blog_Toggle_Switch_Custom_Control(
		$wp_customize,
		'recipes_blog_scroll_top',
		array(
			'label'   => esc_html__( 'Enable Scroll Top Button', 'recipes-blog' ),
			'section' => 'recipes_blog_footer_options',
		)
	)
);

// icon // 
$wp_customize->add_setting(
	'recipes_blog_scroll_btn_icon',
	array(
        'default' => 'fas fa-chevron-up',
		'sanitize_callback' => 'sanitize_text_field',
		'capability' => 'edit_theme_options',
		
	)
);	

$wp_customize->add_control(new Recipes_Blog_Change_Icon_Control($wp_customize, 
	'recipes_blog_scroll_btn_icon',
	array(
	    'label'   		=> __('Scroll Top Icon','recipes-blog'),
	    'section' 		=> 'recipes_blog_footer_options',
		'iconset' => 'fa',
	))  
);

$wp_customize->add_setting( 'recipes_blog_scroll_top_position', array(
    'default'           => 'bottom-right',
    'sanitize_callback' => 'recipes_blog_sanitize_scroll_top_position',
) );

// Add control for Scroll Top Button Position
$wp_customize->add_control( 'recipes_blog_scroll_top_position', array(
    'label'    => __( 'Scroll Top Button Position', 'recipes-blog' ),
    'section'  => 'recipes_blog_footer_options',
    'settings' => 'recipes_blog_scroll_top_position',
    'type'     => 'select',
    'choices'  => array(
        'bottom-right' => __( 'Bottom Right', 'recipes-blog' ),
        'bottom-left'  => __( 'Bottom Left', 'recipes-blog' ),
        'bottom-center'=> __( 'Bottom Center', 'recipes-blog' ),
    ),
) );

$wp_customize->add_setting( 'recipes_blog_scroll_top_shape', array(
	'default'           => 'box',
	'sanitize_callback' => 'sanitize_text_field',
));

$wp_customize->add_control( 'recipes_blog_scroll_top_shape', array(
	'label'    => __( 'Scroll to Top Button Shape', 'recipes-blog' ),
	'section'  => 'recipes_blog_footer_options',
	'settings' => 'recipes_blog_scroll_top_shape',
	'type'     => 'radio',
	'choices'  => array(
		'box'        => __( 'Box', 'recipes-blog' ),
		'curved-box' => __( 'Curved Box', 'recipes-blog' ),
		'circle'     => __( 'Circle', 'recipes-blog' ),
	),
));