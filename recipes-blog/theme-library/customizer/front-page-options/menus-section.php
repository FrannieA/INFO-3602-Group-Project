<?php

/**
 * menus Section
 *
 * @package recipes_blog
 */

$wp_customize->add_section(
	'recipes_blog_menu_section',
	array(
		'panel'    => 'recipes_blog_front_page_options',
		'title'    => esc_html__( 'Menus Section', 'recipes-blog' ),
		'priority' => 10,
	)
);

// Menus Section - Enable Section.
$wp_customize->add_setting(
	'recipes_blog_enable_menus_section',
	array(
		'default'           => false,
		'sanitize_callback' => 'recipes_blog_sanitize_switch',
	)
);

$wp_customize->add_control(
	new Recipes_Blog_Toggle_Switch_Custom_Control(
		$wp_customize,
		'recipes_blog_enable_menus_section',
		array(
			'label'    => esc_html__( 'Enable Menus Section', 'recipes-blog' ),
			'section'  => 'recipes_blog_menu_section',
			'settings' => 'recipes_blog_enable_menus_section',
		)
	)
);

if ( isset( $wp_customize->selective_refresh ) ) {
	$wp_customize->selective_refresh->add_partial(
		'recipes_blog_enable_menus_section',
		array(
			'selector' => '#recipes_blog_menus_section .section-link',
			'settings' => 'recipes_blog_enable_menus_section',
		)
	);
}

// Trending Products Section
$wp_customize->add_setting(
	'recipes_blog_heading_menus_section',
	array(
		'default'           => '',
		'sanitize_callback' => 'sanitize_text_field',
	)
);

$wp_customize->add_control(
	'recipes_blog_heading_menus_section',
	array(
		'label'           => esc_html__( 'Heading', 'recipes-blog' ),
		'section'         => 'recipes_blog_menu_section',
		'settings'        => 'recipes_blog_heading_menus_section',
		'type'            => 'text',
		'active_callback' => 'recipes_blog_is_menus_section_enabled',
	)
);

$wp_customize->add_setting(
	'recipes_blog_menus_number',
	array(
	    'default'=> '',
	    'sanitize_callback' => 'sanitize_text_field'
));
$wp_customize->add_control(
	'recipes_blog_menus_number',
	array(
	    'label' => esc_html__('No of Tabs to show','recipes-blog'),
	    'section'=> 'recipes_blog_menu_section',
	    'type' => 'number',
	    'input_attrs' => array(
	    'step'  => 1,
			'min'  => 0,
			'max'  => 5,
	    ),
	    'active_callback' => 'recipes_blog_is_menus_section_enabled',
	)
);

$recipes_blog_featured_post = get_theme_mod('recipes_blog_menus_number');
for ( $recipes_blog_j = 1; $recipes_blog_j <= $recipes_blog_featured_post; $recipes_blog_j++ ) {

    $wp_customize->add_setting(
    	'recipes_blog_menus_text'.$recipes_blog_j,
    	array(
	        'default'=> '',
	        'sanitize_callback' => 'sanitize_text_field'
    	)
    );
    $wp_customize->add_control(
    	'recipes_blog_menus_text'.$recipes_blog_j,
    	array(
	        'label' => esc_html__('Tab ','recipes-blog').$recipes_blog_j,
	        'section'=> 'recipes_blog_menu_section',
	        'type'=> 'text',
	        'active_callback' => 'recipes_blog_is_menus_section_enabled',
    	)
    );

    $recipes_blog_categories = get_categories();
        $recipes_blog_cat_posts = array();
            $recipes_blog_i = 0;
            $recipes_blog_cat_posts[]='Menus';
        foreach($recipes_blog_categories as $recipes_blog_category){
            if($recipes_blog_i==0){
            $recipes_blog_default = $recipes_blog_category->slug;
            $recipes_blog_i++;
        }
        $recipes_blog_cat_posts[$recipes_blog_category->slug] = $recipes_blog_category->name;
    }

    $wp_customize->add_setting(
    	'recipes_blog_menus_category'.$recipes_blog_j,
    	array(
	        'default'   => 'Menus',
	        'sanitize_callback' => 'recipes_blog_sanitize_choices',
    	)
    );
    $wp_customize->add_control(
    	'recipes_blog_menus_category'.$recipes_blog_j,
    	array(
	        'type'    => 'select',
	        'choices' => $recipes_blog_cat_posts,
	        'label' => __('Select Category to display projects','recipes-blog'),
	        'section' => 'recipes_blog_menu_section',
	        'active_callback' => 'recipes_blog_is_menus_section_enabled',
    	)
    );
}