<?php
/**
 * Footer Social Icons
 *
 * @package recipes_blog
 */

$wp_customize->add_section(
	'recipes_blog_footer_icon_options',
	array(
		'panel' => 'recipes_blog_theme_options',
		'title' => esc_html__( 'Footer Social Icons', 'recipes-blog' ),
	)
);

// Add Separator Custom Control
$wp_customize->add_setting( 'recipes_blog_footer_icon_separators', array(
	'sanitize_callback' => 'sanitize_text_field',
) );

$wp_customize->add_control( new Recipes_Blog_Separator_Custom_Control( $wp_customize, 'recipes_blog_footer_icon_separators', array(
	'label' => __( 'Footer Icon Settings', 'recipes-blog' ),
	'section' => 'recipes_blog_footer_icon_options',
	'settings' => 'recipes_blog_footer_icon_separators',
)));

// Footer Section - Enable Section.
$wp_customize->add_setting(
	'recipes_blog_enable_footer_icon_section',
	array(
		'default'           => true,
		'sanitize_callback' => 'recipes_blog_sanitize_switch',
	)
);

$wp_customize->add_control(
	new Recipes_Blog_Toggle_Switch_Custom_Control(
		$wp_customize,
		'recipes_blog_enable_footer_icon_section',
		array(
			'label'    => esc_html__( 'Show / Hide Footer Icon', 'recipes-blog' ),
			'section'  => 'recipes_blog_footer_icon_options',
			'settings' => 'recipes_blog_enable_footer_icon_section',
		)
	)
);

// Add setting for Facebook Link
$wp_customize->add_setting(
	'recipes_blog_footer_facebook_link',
	array(
		'default'           => 'https://www.facebook.com/',
		'sanitize_callback' => 'esc_url_raw',
	)
);

$wp_customize->add_control(
	'recipes_blog_footer_facebook_link',
	array(
		'label'           => esc_html__( 'Facebook Link', 'recipes-blog'  ),
		'section'         => 'recipes_blog_footer_icon_options',
		'settings'        => 'recipes_blog_footer_facebook_link',
		'type'      => 'url'
	)
);

// Add setting for Facebook Icon Changing
$wp_customize->add_setting(
	'recipes_blog_facebook_icon',
	array(
        'default' => 'fab fa-facebook-f',
		'sanitize_callback' => 'sanitize_text_field',
		'capability' => 'edit_theme_options',
		
	)
);	

$wp_customize->add_control(new Recipes_Blog_Change_Icon_Control($wp_customize, 
	'recipes_blog_facebook_icon',
	array(
	    'label'   		=> __('Facebook Icon','recipes-blog'),
	    'section' 		=> 'recipes_blog_footer_icon_options',
		'iconset' => 'fb',
	))  
);


// Add setting for Twitter Link
$wp_customize->add_setting(
	'recipes_blog_footer_twitter_link',
	array(
		'default'           => 'https://x.com/',
		'sanitize_callback' => 'esc_url_raw',
	)
);

$wp_customize->add_control(
	'recipes_blog_footer_twitter_link',
	array(
		'label'           => esc_html__( 'Twitter Link', 'recipes-blog'  ),
		'section'         => 'recipes_blog_footer_icon_options',
		'settings'        => 'recipes_blog_footer_twitter_link',
		'type'      => 'url'
	)
);

// Add setting for Twitter Icon Changing
$wp_customize->add_setting(
	'recipes_blog_twitter_icon',
	array(
        'default' => 'fab fa-twitter',
		'sanitize_callback' => 'sanitize_text_field',
		'capability' => 'edit_theme_options',
		
	)
);	

$wp_customize->add_control(new Recipes_Blog_Change_Icon_Control($wp_customize, 
	'recipes_blog_twitter_icon',
	array(
	    'label'   		=> __('Twitter Icon','recipes-blog'),
	    'section' 		=> 'recipes_blog_footer_icon_options',
		'iconset' => 'fb',
	))  
);

// Add setting for Instagram Link
$wp_customize->add_setting(
	'recipes_blog_footer_instagram_link',
	array(
		'default'           => 'https://www.instagram.com/',
		'sanitize_callback' => 'esc_url_raw',
	)
);

$wp_customize->add_control(
	'recipes_blog_footer_instagram_link',
	array(
		'label'           => esc_html__( 'Instagram Link', 'recipes-blog'  ),
		'section'         => 'recipes_blog_footer_icon_options',
		'settings'        => 'recipes_blog_footer_instagram_link',
		'type'      => 'url'
	)
);

// Add setting for Instagram Icon Changing
$wp_customize->add_setting(
	'recipes_blog_instagram_icon',
	array(
        'default' => 'fab fa-instagram',
		'sanitize_callback' => 'sanitize_text_field',
		'capability' => 'edit_theme_options',
		
	)
);	

$wp_customize->add_control(new Recipes_Blog_Change_Icon_Control($wp_customize, 
	'recipes_blog_instagram_icon',
	array(
	    'label'   		=> __('Instagram Icon','recipes-blog'),
	    'section' 		=> 'recipes_blog_footer_icon_options',
		'iconset' => 'fb',
	))  
);

// Add setting for Linkedin Link
$wp_customize->add_setting(
	'recipes_blog_footer_linkedin_link',
	array(
		'default'           => 'https://in.linkedin.com/',
		'sanitize_callback' => 'esc_url_raw',
	)
);

$wp_customize->add_control(
	'recipes_blog_footer_linkedin_link',
	array(
		'label'           => esc_html__( 'Linkedin Link', 'recipes-blog'  ),
		'section'         => 'recipes_blog_footer_icon_options',
		'settings'        => 'recipes_blog_footer_linkedin_link',
		'type'      => 'url'
	)
);

// Add setting for Linkedin Icon Changing
$wp_customize->add_setting(
	'recipes_blog_linkedin_icon',
	array(
        'default' => 'fab fa-linkedin',
		'sanitize_callback' => 'sanitize_text_field',
		'capability' => 'edit_theme_options',
		
	)
);	

$wp_customize->add_control(new Recipes_Blog_Change_Icon_Control($wp_customize, 
	'recipes_blog_linkedin_icon',
	array(
	    'label'   		=> __('Linkedin Icon','recipes-blog'),
	    'section' 		=> 'recipes_blog_footer_icon_options',
		'iconset' => 'fb',
	))  
);

// Add setting for Youtube Link
$wp_customize->add_setting(
	'recipes_blog_footer_youtube_link',
	array(
		'default'           => 'https://www.youtube.com/',
		'sanitize_callback' => 'esc_url_raw',
	)
);

$wp_customize->add_control(
	'recipes_blog_footer_youtube_link',
	array(
		'label'           => esc_html__( 'Youtube Link', 'recipes-blog'  ),
		'section'         => 'recipes_blog_footer_icon_options',
		'settings'        => 'recipes_blog_footer_youtube_link',
		'type'      => 'url'
	)
);

// Add setting for Youtube Icon Changing
$wp_customize->add_setting(
	'recipes_blog_youtube_icon',
	array(
        'default' => 'fab fa-youtube',
		'sanitize_callback' => 'sanitize_text_field',
		'capability' => 'edit_theme_options',
		
	)
);	

$wp_customize->add_control(new Recipes_Blog_Change_Icon_Control($wp_customize, 
	'recipes_blog_youtube_icon',
	array(
	    'label'   		=> __('Youtube Icon','recipes-blog'),
	    'section' 		=> 'recipes_blog_footer_icon_options',
		'iconset' => 'fb',
	))  
);

//Icon Alignment
$wp_customize->add_setting(
	'recipes_blog_footer_social_align',
	array(
		'default' 			=> 'center',
		'sanitize_callback' => 'sanitize_text_field'
	)
);

$wp_customize->add_control(
	'recipes_blog_footer_social_align',
	array(
		'label' => __('Icon Alignment ','recipes-blog'),
		'section' => 'recipes_blog_footer_icon_options',
		'type'			=> 'select',
		'choices' => 
		array(
			'left' => __('Left','recipes-blog'),
			'right' => __('Right','recipes-blog'),
			'center' => __('Center','recipes-blog'),
		),
	)
);