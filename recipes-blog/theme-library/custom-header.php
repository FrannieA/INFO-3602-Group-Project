<?php
/**
 * Sample implementation of the Custom Header feature
 *
 * @link https://developer.wordpress.org/themes/functionality/custom-headers/
 *
 * @package recipes_blog
 */

function recipes_blog_custom_header_setup() {
	add_theme_support( 'custom-header', apply_filters( 'recipes_blog_custom_header_args', array(
		'default-image'      => get_parent_theme_file_uri() . '/resource/img/banner.png',
		'default-text-color'     => 'fff',
		'header-text' 			 =>	false,
		'width'                  => 1360,
		'height'                 => 110,
		'flex-width'         	=> true,
        'flex-height'        	=> true,
		'wp-head-callback'       => 'recipes_blog_header_style',
	) ) );

	register_default_headers( array(
		'default-image' => array(
			'url'           => '%s/resource/img/banner.png',
			'thumbnail_url' => '%s/resource/img/banner.png',
			'description'   => __( 'Default Header Image', 'recipes-blog' ),
		),
	) );
}

add_action( 'after_setup_theme', 'recipes_blog_custom_header_setup' );

if ( ! function_exists( 'recipes_blog_header_style' ) ) :

add_action( 'wp_enqueue_scripts', 'recipes_blog_header_style' );
function recipes_blog_header_style() {
	if ( get_header_image() ) :
	$recipes_blog_custom_css = "
        .bottom-header-outer-wrapper{
			background-image:url('".esc_url(get_header_image())."') !important;
			background-position: center top;
		}";
	   	wp_add_inline_style( 'recipes-blog-style', $recipes_blog_custom_css );
	endif;
}
endif;