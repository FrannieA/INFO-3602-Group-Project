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


/**
 * Register Recipe Custom Post Type
 */
function simmerdown_register_recipe_cpt() {
    $labels = array(
        'name'                  => _x( 'Recipes', 'Post Type General Name', 'recipes-blog' ),
        'singular_name'         => _x( 'Recipe', 'Post Type Singular Name', 'recipes-blog' ),
        'menu_name'             => __( 'Recipes', 'recipes-blog' ),
        'name_admin_bar'        => __( 'Recipe', 'recipes-blog' ),
        'archives'              => __( 'Recipe Archives', 'recipes-blog' ),
        'attributes'            => __( 'Recipe Attributes', 'recipes-blog' ),
        'parent_item_colon'     => __( 'Parent Recipe:', 'recipes-blog' ),
        'all_items'             => __( 'All Recipes', 'recipes-blog' ),
        'add_new_item'          => __( 'Add New Recipe', 'recipes-blog' ),
        'add_new'               => __( 'Add New', 'recipes-blog' ),
        'new_item'              => __( 'New Recipe', 'recipes-blog' ),
        'edit_item'             => __( 'Edit Recipe', 'recipes-blog' ),
        'update_item'           => __( 'Update Recipe', 'recipes-blog' ),
        'view_item'             => __( 'View Recipe', 'recipes-blog' ),
        'view_items'            => __( 'View Recipes', 'recipes-blog' ),
        'search_items'          => __( 'Search Recipe', 'recipes-blog' ),
        'not_found'             => __( 'Not found', 'recipes-blog' ),
        'not_found_in_trash'    => __( 'Not found in Trash', 'recipes-blog' ),
        'featured_image'        => __( 'Featured Image', 'recipes-blog' ),
        'set_featured_image'    => __( 'Set featured image', 'recipes-blog' ),
        'remove_featured_image' => __( 'Remove featured image', 'recipes-blog' ),
        'use_featured_image'    => __( 'Use as featured image', 'recipes-blog' ),
        'insert_into_item'      => __( 'Insert into recipe', 'recipes-blog' ),
        'uploaded_to_this_item' => __( 'Uploaded to this recipe', 'recipes-blog' ),
        'items_list'            => __( 'Recipes list', 'recipes-blog' ),
        'items_list_navigation' => __( 'Recipes list navigation', 'recipes-blog' ),
        'filter_items_list'     => __( 'Filter recipes list', 'recipes-blog' ),
    );
    
    $args = array(
        'label'                 => __( 'Recipe', 'recipes-blog' ),
        'description'           => __( 'Recipe posts for budget healthy meals', 'recipes-blog' ),
        'labels'                => $labels,
        'supports'              => array( 'title', 'editor', 'excerpt', 'thumbnail', 'comments', 'custom-fields' ),
        'taxonomies'            => array( 'category', 'post_tag' ),
        'hierarchical'          => false,
        'public'                => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'menu_position'         => 5,
        'menu_icon'             => 'dashicons-carrot',
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => true,
        'can_export'            => true,
        'has_archive'           => true,
        'rewrite'               => array( 'slug' => 'recipes' ),
        'exclude_from_search'   => false,
        'publicly_queryable'    => true,
        'capability_type'       => 'post',
        'show_in_rest'          => true,  // Important for Gutenberg editor
    );
    
    register_post_type( 'recipe', $args );
}
add_action( 'init', 'simmerdown_register_recipe_cpt', 0 );

/**
 * Add Ingredients Meta Box for Recipes
 */
function simmerdown_add_recipe_metaboxes() {
    add_meta_box(
        'simmerdown_recipe_ingredients',
        'Recipe Ingredients',
        'simmerdown_recipe_ingredients_callback',
        'recipe',
        'normal',
        'high'
    );
}
add_action( 'add_meta_boxes', 'simmerdown_add_recipe_metaboxes' );

/**
 * Ingredients Meta Box HTML
 */
function simmerdown_recipe_ingredients_callback( $post ) {
    wp_nonce_field( 'simmerdown_recipe_ingredients', 'simmerdown_recipe_ingredients_nonce' );
    $ingredients = get_post_meta( $post->ID, '_recipe_ingredients', true );
    ?>
    <p>
        <label for="recipe_ingredients">Enter ingredients (separate with commas):</label>
        <textarea id="recipe_ingredients" name="recipe_ingredients" rows="5" style="width:100%;"><?php echo esc_textarea( $ingredients ); ?></textarea>
        <span class="description">Example: tomatoes, onion, garlic, olive oil, pasta, salt</span>
    </p>
    <?php
}

/**
 * Save Ingredients Meta Box Data
 */
function simmerdown_save_recipe_ingredients( $post_id ) {
    // Check nonce
    if ( ! isset( $_POST['simmerdown_recipe_ingredients_nonce'] ) ) {
        return;
    }
    
    if ( ! wp_verify_nonce( $_POST['simmerdown_recipe_ingredients_nonce'], 'simmerdown_recipe_ingredients' ) ) {
        return;
    }
    
    // Check autosave
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }
    
    // Check permissions
    if ( isset( $_POST['post_type'] ) && 'recipe' == $_POST['post_type'] ) {
        if ( ! current_user_can( 'edit_page', $post_id ) ) {
            return;
        }
    }
    
    // Save the ingredients
    if ( isset( $_POST['recipe_ingredients'] ) ) {
        update_post_meta( $post_id, '_recipe_ingredients', sanitize_textarea_field( $_POST['recipe_ingredients'] ) );
    }
}
add_action( 'save_post_recipe', 'simmerdown_save_recipe_ingredients' );

/**
 * Add Prep Time Meta Box
 */
function simmerdown_add_prep_time_metabox() {
    add_meta_box(
        'simmerdown_recipe_prep_time',
        'Preparation Time',
        'simmerdown_prep_time_callback',
        'recipe',
        'side',
        'default'
    );
}
add_action( 'add_meta_boxes', 'simmerdown_add_prep_time_metabox' );

function simmerdown_prep_time_callback( $post ) {
    $prep_time = get_post_meta( $post->ID, '_recipe_prep_time', true );
    ?>
    <p>
        <label for="recipe_prep_time">Time in minutes:</label>
        <input type="number" id="recipe_prep_time" name="recipe_prep_time" value="<?php echo esc_attr( $prep_time ); ?>" style="width:100%;">
        <span class="description">e.g., 30 for 30 minutes</span>
    </p>
    <?php
}

function simmerdown_save_prep_time( $post_id ) {
    if ( isset( $_POST['recipe_prep_time'] ) ) {
        update_post_meta( $post_id, '_recipe_prep_time', intval( $_POST['recipe_prep_time'] ) );
    }
}
add_action( 'save_post_recipe', 'simmerdown_save_prep_time' );

/**
 * Add Budget Category Meta Box
 */
function simmerdown_add_budget_metabox() {
    add_meta_box(
        'simmerdown_recipe_budget',
        'Budget Category',
        'simmerdown_budget_callback',
        'recipe',
        'side',
        'default'
    );
}
add_action( 'add_meta_boxes', 'simmerdown_add_budget_metabox' );

function simmerdown_budget_callback( $post ) {
    $budget = get_post_meta( $post->ID, '_recipe_budget', true );
    ?>
    <p>
        <select id="recipe_budget" name="recipe_budget" style="width:100%;">
            <option value="budget" <?php selected( $budget, 'budget' ); ?>>💰 Budget (Under $5)</option>
            <option value="moderate" <?php selected( $budget, 'moderate' ); ?>>💰💰 Moderate ($5-$10)</option>
            <option value="splurge" <?php selected( $budget, 'splurge' ); ?>>💰💰💰 Splurge ($10+)</option>
        </select>
    </p>
    <?php
}

function simmerdown_save_budget( $post_id ) {
    if ( isset( $_POST['recipe_budget'] ) ) {
        update_post_meta( $post_id, '_recipe_budget', sanitize_text_field( $_POST['recipe_budget'] ) );
    }
}
add_action( 'save_post_recipe', 'simmerdown_save_budget' );


/**
 * Add Dietary Preferences Meta Box
 */
function simmerdown_add_diet_metabox() {
    add_meta_box(
        'simmerdown_recipe_diet',
        'Dietary Preferences',
        'simmerdown_diet_callback',
        'recipe',
        'side',
        'default'
    );
}
add_action( 'add_meta_boxes', 'simmerdown_add_diet_metabox' );

function simmerdown_diet_callback( $post ) {
    $diet = get_post_meta( $post->ID, '_recipe_diet', true );
    ?>
    <p>
        <select id="recipe_diet" name="recipe_diet" style="width:100%;">
            <option value="">None / Any</option>
            <option value="vegetarian" <?php selected( $diet, 'vegetarian' ); ?>>Vegetarian</option>
            <option value="vegan" <?php selected( $diet, 'vegan' ); ?>>Vegan</option>
            <option value="gluten_free" <?php selected( $diet, 'gluten_free' ); ?>>Gluten-Free</option>
            <option value="dairy_free" <?php selected( $diet, 'dairy_free' ); ?>>Dairy-Free</option>
        </select>
    </p>
    <?php
}

function simmerdown_save_diet( $post_id ) {
    if ( isset( $_POST['recipe_diet'] ) ) {
        update_post_meta( $post_id, '_recipe_diet', sanitize_text_field( $_POST['recipe_diet'] ) );
    }
}
add_action( 'save_post_recipe', 'simmerdown_save_diet' );
