<?php
/**
 * Recipes Blog functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package recipes_blog
 */

if ( ! defined( 'RECIPES_BLOG_VERSION' ) ) {
	define( 'RECIPES_BLOG_VERSION', '1.0.0' );
}
$recipes_blog_theme_data = wp_get_theme();

if( ! defined( 'RECIPES_BLOG_THEME_VERSION' ) ) define ( 'RECIPES_BLOG_THEME_VERSION', $recipes_blog_theme_data->get( 'Version' ) );
if( ! defined( 'RECIPES_BLOG_THEME_NAME' ) ) define( 'RECIPES_BLOG_THEME_NAME', $recipes_blog_theme_data->get( 'Name' ) );

if ( ! function_exists( 'recipes_blog_setup' ) ) :
	
	function recipes_blog_setup() {
		
		load_theme_textdomain( 'recipes-blog', get_template_directory() . '/languages' );

		add_theme_support( 'woocommerce' );

		add_theme_support( 'automatic-feed-links' );
		
		add_theme_support( 'title-tag' );

		add_theme_support( 'post-thumbnails' );

		register_nav_menus(
			array(
				'primary' => esc_html__( 'Primary', 'recipes-blog' ),
			)
		);

		add_theme_support(
			'html5',
			array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
				'style',
				'script',
				'woocommerce',
			)
		);

		add_theme_support( 'post-formats', array(
			'image',
			'video',
			'gallery',
			'audio', 
		) );

		add_theme_support(
			'custom-background',
			apply_filters(
				'recipes_blog_custom_background_args',
				array(
					'default-color' => '101010',
					'default-image' => '',
				)
			)
		);

		add_theme_support( 'customize-selective-refresh-widgets' );

		add_theme_support(
			'custom-logo',
			array(
				'height'      => 250,
				'width'       => 250,
				'flex-width'  => true,
				'flex-height' => true,
			)
		);

		add_theme_support( 'align-wide' );

		add_theme_support( 'responsive-embeds' );
	}
endif;
add_action( 'after_setup_theme', 'recipes_blog_setup' );

function recipes_blog_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'recipes_blog_content_width', 640 );
}
add_action( 'after_setup_theme', 'recipes_blog_content_width', 0 );

function recipes_blog_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'recipes-blog' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'recipes-blog' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title"><span>',
			'after_title'   => '</span></h2>',
		)
	);

	// Regsiter 4 footer widgets.
	$recipes_blog_footer_widget_column = get_theme_mod('recipes_blog_footer_widget_column','4');
	for ($i=1; $i<=$recipes_blog_footer_widget_column; $i++) {
		register_sidebar( array(
			'name' => __( 'Footer  ', 'recipes-blog' )  . $i,
			'id' => 'recipes-blog-footer-widget-' . $i,
			'description' => __( 'The Footer Widget Area', 'recipes-blog' )  . $i,
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget' => '</aside>',
			'before_title' => '<div class="widget-header"><h4 class="widget-title">',
			'after_title' => '</h4></div>',
		) );
	}
}
add_action( 'widgets_init', 'recipes_blog_widgets_init' );

//Change number of products per page 
add_filter( 'loop_shop_per_page', 'recipes_blog_products_per_page' );
function recipes_blog_products_per_page( $cols ) {
  	return  get_theme_mod( 'recipes_blog_products_per_page',9);
}

// Change number or products per row 
add_filter('loop_shop_columns', 'recipes_blog_loop_columns');
	if (!function_exists('recipes_blog_loop_columns')) {
	function recipes_blog_loop_columns() {
		return get_theme_mod( 'recipes_blog_products_per_row', 3 );
	}
}

/**
 * Enqueue scripts and styles.
 */
function recipes_blog_scripts() {
	// Append .min if SCRIPT_DEBUG is false.
	$min = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';

	// Slick style.
	wp_enqueue_style( 'recipes-blog-slick-style', get_template_directory_uri() . '/resource/css/slick' . $min . '.css', array(), '1.8.1' );

	// Fontawesome style.
	wp_enqueue_style( 'font-awesome-css', esc_url(get_template_directory_uri())."/resource/css/fontawesome-all.css" );

	// Main style.
	wp_enqueue_style( 'recipes-blog-style', get_template_directory_uri() . '/style.css', array(), RECIPES_BLOG_VERSION );

	// RTL style.
	wp_style_add_data('recipes-blog-style', 'rtl', 'replace');

	if (get_theme_mod('recipes_blog_enable_animation', true) == true){
		// Animate CSS
		wp_enqueue_style( 'animate-style', get_template_directory_uri() . '/resource/css/animate.css' );
		// Wow script.
		wp_enqueue_script( 'wow-jquery', get_template_directory_uri() . '/resource/js/wow.js', array('jquery'),'' ,true );
	}
	
	// Navigation script.
	wp_enqueue_script( 'recipes-blog-navigation-script', get_template_directory_uri() . '/resource/js/navigation' . $min . '.js', array(), RECIPES_BLOG_VERSION, true );

	// Slick script.
	wp_enqueue_script( 'recipes-blog-slick-script', get_template_directory_uri() . '/resource/js/slick' . $min . '.js', array( 'jquery' ), '1.8.1', true );


	// Custom script.
	wp_enqueue_script( 'recipes-blog-custom-script', get_template_directory_uri() . '/resource/js/custom.js', array( 'jquery' ), RECIPES_BLOG_VERSION, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	// Include the file.
	require_once get_theme_file_path( 'theme-library/function-files/wptt-webfont-loader.php' );

	// Load the webfont.
	wp_enqueue_style(
		'play',
		wptt_get_webfont_url( 'https://fonts.googleapis.com/css2?family=Play:wght@400;700&display=swap' ),
		array(),
		'1.0'
	);

	// Load the webfont.
	wp_enqueue_style(
		'readex',
		wptt_get_webfont_url( 'https://fonts.googleapis.com/css2?family=Readex+Pro:wght@200;300;400;500;600;700&display=swap' ),
		array(),
		'1.0'
	);

}
add_action( 'wp_enqueue_scripts', 'recipes_blog_scripts' );

/**
 * Change number or products per row to 3
 */
add_filter('loop_shop_columns', 'recipes_blog_loop_columns', 999);
if (!function_exists('recipes_blog_loop_columns')) {
	function recipes_blog_loop_columns() {
		return 3; // 3 products per row
	}
}

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/theme-library/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/theme-library/function-files/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/theme-library/function-files/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/theme-library/customizer.php';

/**
 * Breadcrumb
 */
require get_template_directory() . '/theme-library/function-files/class-breadcrumb-trail.php';

/**
 * Google Fonts
 */
require get_template_directory() . '/theme-library/function-files/google-fonts.php';

/**
 * Dynamic CSS
 */
require get_template_directory() . '/theme-library/dynamic-css.php';

/**
 * Getting Started
*/
require get_template_directory() . '/theme-library/getting-started/getting-started.php';

function recipes_blog_links_setup() {
	if ( ! defined( 'RECIPES_BLOG_PREMIUM_PAGE' ) ) {
	define('RECIPES_BLOG_PREMIUM_PAGE',__('https://asterthemes.com/products/recipes-bloggers-wordpress-theme','recipes-blog'));
	}
	if ( ! defined( 'RECIPES_BLOG_THEME_PAGE' ) ) {
		define('RECIPES_BLOG_THEME_PAGE',__('https://asterthemes.com/products/recipes-blog','recipes-blog'));
	}
	if ( ! defined( 'RECIPES_BLOG_SUPPORT' ) ) {
	define('RECIPES_BLOG_SUPPORT',__('https://wordpress.org/support/theme/recipes-blog/','recipes-blog'));
	}
	if ( ! defined( 'RECIPES_BLOG_REVIEW' ) ) {
	define('RECIPES_BLOG_REVIEW',__('https://wordpress.org/support/theme/recipes-blog/reviews/','recipes-blog'));
	}
	if ( ! defined( 'RECIPES_BLOG_PRO_DEMO' ) ) {
	define('RECIPES_BLOG_PRO_DEMO',__('https://demo.asterthemes.com/recipes-blog/','recipes-blog'));
	}
	if ( ! defined( 'RECIPES_BLOG_THEME_DOCUMENTATION' ) ) {
	define('RECIPES_BLOG_THEME_DOCUMENTATION',__('https://demo.asterthemes.com/docs/recipes-blog-free/','recipes-blog'));
	}
	if ( ! defined( 'RECIPES_BLOG_PREMIUM_DOCUMENTATION' ) ) {
	define('RECIPES_BLOG_PREMIUM_DOCUMENTATION',__('https://demo.asterthemes.com/docs/recipes-blog-pro/','recipes-blog'));
	}
	if ( ! defined( 'RECIPES_BLOG_BUNDLE_PAGE' ) ) {
		define('RECIPES_BLOG_BUNDLE_PAGE',__('https://asterthemes.com/products/wp-theme-bundle','recipes-blog'));
	}
}
add_action('after_setup_theme', 'recipes_blog_links_setup');

/**
 * Demo Import
*/
add_action( 'init', 'recipes_blog_load_theme_wizard' );
function recipes_blog_load_theme_wizard() {
    require get_parent_theme_file_path( '/theme-wizard/config.php' );
}

/**
 * Customizer Settings Functions
*/
require get_template_directory() . '/theme-library/function-files/customizer-settings-functions.php';

// Enqueue Customizer live preview script
function recipes_blog_customizer_live_preview() {
    wp_enqueue_script(
        'recipes-blog-customizer',
        get_template_directory_uri() . '/js/customizer.js',
        array('jquery', 'customize-preview'),
        '',
        true
    );
}
add_action('customize_preview_init', 'recipes_blog_customizer_live_preview');

// Featured Image Dimension
function recipes_blog_blog_post_featured_image_dimension(){
	if(get_theme_mod('recipes_blog_blog_post_featured_image_dimension') == 'custom' ) {
		return true;
	}
	return false;
}

// Enqueue SimmerDown's CSS for home
function simmerdown_enqueue_homepage_styles() {
    if ( is_front_page() ) {
        wp_enqueue_style(
            'simmerdown-homepage',
            get_template_directory_uri() . '/simmerdown-homepage.css',
            array( 'recipes-blog-style' ),
            '1.0.0'
        );
    }
}
add_action( 'wp_enqueue_scripts', 'simmerdown_enqueue_homepage_styles' );
