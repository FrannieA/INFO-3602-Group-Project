<?php

/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package recipes_blog
 */

function recipes_blog_customize_css() {
    ?>
    <style type="text/css">
        :root {
            --primary-color: <?php echo esc_html( get_theme_mod( 'recipes_blog_primary_color', '#ff7a00' ) ); ?>;
        }
    </style>
    <?php
}
add_action( 'wp_head', 'recipes_blog_customize_css' );

function add_custom_script_in_footer() {
    if ( get_theme_mod( 'recipes_blog_enable_sticky_header', false ) ) {
        ?>
        <script>
            jQuery(document).ready(function($) {
                $(window).on('scroll', function() {
                    var scroll = $(window).scrollTop();
                    if (scroll > 0) {
                        $('.navigation-menus.hello').addClass('is-sticky');
                    } else {
                        $('.navigation-menus.hello').removeClass('is-sticky');
                    }
                });
            });
        </script>
        <?php
    }
}
add_action( 'wp_footer', 'add_custom_script_in_footer' );

function recipes_blog_enqueue_selected_fonts() {
    $recipes_blog_fonts_url = recipes_blog_get_fonts_url();
    if (!empty($recipes_blog_fonts_url)) {
        wp_enqueue_style('recipes-blog-google-fonts', $recipes_blog_fonts_url, array(), null);
    }
}
add_action('wp_enqueue_scripts', 'recipes_blog_enqueue_selected_fonts');

function recipes_blog_layout_customizer_css() {
    $recipes_blog_margin = get_theme_mod('recipes_blog_layout_width_margin', 50);
    ?>
    <style type="text/css">
        body.site-boxed--layout #page  {
            margin: 0 <?php echo esc_attr($recipes_blog_margin); ?>px;
        }
    </style>
    <?php
}
add_action('wp_head', 'recipes_blog_layout_customizer_css');

function recipes_blog_blog_layout_customizer_css() {
    // Retrieve the blog layout option
    $recipes_blog_blog_layout_option = get_theme_mod('recipes_blog_blog_layout_option_setting', 'Left');

    // Initialize custom CSS variable
    $recipes_blog_custom_css = '';

    // Generate custom CSS based on the layout option
    if ($recipes_blog_blog_layout_option === 'Default') {
        $recipes_blog_custom_css .= '.mag-post-detail { text-align: center; }';
    } elseif ($recipes_blog_blog_layout_option === 'Left') {
        $recipes_blog_custom_css .= '.mag-post-detail { text-align: left; }';
    } elseif ($recipes_blog_blog_layout_option === 'Right') {
        $recipes_blog_custom_css .= '.mag-post-detail { text-align: right; }';
    }

    // Output the combined CSS
    ?>
    <style type="text/css">
        <?php echo wp_kses($recipes_blog_custom_css, array( 'style' => array(), 'text-align' => array() )); ?>
    </style>
    <?php
}
add_action('wp_head', 'recipes_blog_blog_layout_customizer_css');

// Featured Image Dimension
function recipes_blog_custom_featured_image_css() {
    $recipes_blog_dimension = get_theme_mod('recipes_blog_blog_post_featured_image_dimension', 'default');
    $recipes_blog_width = get_theme_mod('recipes_blog_blog_post_featured_image_custom_width', '');
    $recipes_blog_height = get_theme_mod('recipes_blog_blog_post_featured_image_custom_height', '');
    
    if ($recipes_blog_dimension === 'custom' && $recipes_blog_width && $recipes_blog_height) {
        $recipes_blog_custom_css = "body:not(.single-post) .mag-post-single .mag-post-img img { width: {$recipes_blog_width}px !important; height: {$recipes_blog_height}px !important; }";
        wp_add_inline_style('recipes-blog-style', $recipes_blog_custom_css);
    }
}
add_action('wp_enqueue_scripts', 'recipes_blog_custom_featured_image_css');

// Featured Image Border Radius
function recipes_blog_featured_image_border_radius_css() {
    $recipes_blog_featured_image_border_radius = get_theme_mod('recipes_blog_featured_image_border_radius', 10);
    ?>
    <style type="text/css">  
        .mag-post-single img {
            border-radius: <?php echo esc_attr($recipes_blog_featured_image_border_radius); ?>px;
        }
    </style>
    <?php
}
add_action('wp_head', 'recipes_blog_featured_image_border_radius_css');

function recipes_blog_sidebar_width_customizer_css() {
    $recipes_blog_sidebar_width = get_theme_mod('recipes_blog_sidebar_width', '30');
    ?>
    <style type="text/css">
        .right-sidebar .asterthemes-wrapper .asterthemes-page {
            grid-template-columns: auto <?php echo esc_attr($recipes_blog_sidebar_width); ?>%;
        }
        .left-sidebar .asterthemes-wrapper .asterthemes-page {
            grid-template-columns: <?php echo esc_attr($recipes_blog_sidebar_width); ?>% auto;
        }
    </style>
    <?php
}
add_action('wp_head', 'recipes_blog_sidebar_width_customizer_css');

if ( ! function_exists( 'recipes_blog_get_page_title' ) ) {
    function recipes_blog_get_page_title() {
        $recipes_blog_title = '';

        if (is_404()) {
            $recipes_blog_title = esc_html__('Page Not Found', 'recipes-blog');
        } elseif (is_search()) {
            $recipes_blog_title = esc_html__('Search Results for: ', 'recipes-blog') . esc_html(get_search_query());
        } elseif (is_home() && !is_front_page()) {
            $recipes_blog_title = esc_html__('Blogs', 'recipes-blog');
        } elseif (function_exists('is_shop') && is_shop()) {
            $recipes_blog_title = esc_html__('Shop', 'recipes-blog');
        } elseif (is_page()) {
            $recipes_blog_title = get_the_title();
        } elseif (is_single()) {
            $recipes_blog_title = get_the_title();
        } elseif (is_archive()) {
            $recipes_blog_title = get_the_archive_title();
        } else {
            $recipes_blog_title = get_the_archive_title();
        }

        return apply_filters('recipes_blog_page_title', $recipes_blog_title);
    }
}

if ( ! function_exists( 'recipes_blog_has_page_header' ) ) {
    function recipes_blog_has_page_header() {
        // Default to true (display header)
        $recipes_blog_return = true;

        // Custom conditions for disabling the header
        if ('hide-all-devices' === get_theme_mod('recipes_blog_page_header_visibility', 'all-devices')) {
            $recipes_blog_return = false;
        }

        // Apply filters and return
        return apply_filters('recipes_blog_display_page_header', $recipes_blog_return);
    }
}

if ( ! function_exists( 'recipes_blog_page_header_style' ) ) {
    function recipes_blog_page_header_style() {
        $recipes_blog_style = get_theme_mod('recipes_blog_page_header_style', 'default');
        return apply_filters('recipes_blog_page_header_style', $recipes_blog_style);
    }
}

function recipes_blog_page_title_customizer_css() {
    $recipes_blog_layout_option = get_theme_mod('recipes_blog_page_header_layout', 'left');
    ?>
    <style type="text/css">
        .asterthemes-wrapper.page-header-inner {
            <?php if ($recipes_blog_layout_option === 'flex') : ?>
                display: flex;
                justify-content: space-between;
                align-items: center;
            <?php else : ?>
                text-align: <?php echo esc_attr($recipes_blog_layout_option); ?>;
            <?php endif; ?>
        }
    </style>
    <?php
}
add_action('wp_head', 'recipes_blog_page_title_customizer_css');

function recipes_blog_pagetitle_height_css() {
    $recipes_blog_height = get_theme_mod('recipes_blog_pagetitle_height', 50);
    ?>
    <style type="text/css">
        header.page-header {
            padding: <?php echo esc_attr($recipes_blog_height); ?>px 0;
        }
    </style>
    <?php
}
add_action('wp_head', 'recipes_blog_pagetitle_height_css');

function recipes_blog_site_logo_width() {
    $recipes_blog_site_logo_width = get_theme_mod('recipes_blog_site_logo_width', 200);
    ?>
    <style type="text/css">
        .site-logo img {
            max-width: <?php echo esc_attr($recipes_blog_site_logo_width); ?>px;
        }
    </style>
    <?php
}
add_action('wp_head', 'recipes_blog_site_logo_width');

function recipes_blog_menu_font_size_css() {
    $recipes_blog_menu_font_size = get_theme_mod('recipes_blog_menu_font_size', 15);
    ?>
    <style type="text/css">
        .main-navigation a {
            font-size: <?php echo esc_attr($recipes_blog_menu_font_size); ?>px;
        }
    </style>
    <?php
}
add_action('wp_head', 'recipes_blog_menu_font_size_css');

function recipes_blog_sidebar_widget_font_size_css() {
    $recipes_blog_sidebar_widget_font_size = get_theme_mod('recipes_blog_sidebar_widget_font_size', 24);
    ?>
    <style type="text/css">
        h2.wp-block-heading,aside#secondary .widgettitle,aside#secondary .widget-title {
            font-size: <?php echo esc_attr($recipes_blog_sidebar_widget_font_size); ?>px;
        }
    </style>
    <?php
}
add_action('wp_head', 'recipes_blog_sidebar_widget_font_size_css');

// Woocommerce Related Products Settings
function recipes_blog_related_product_css() {
    $recipes_blog_related_product_show_hide = get_theme_mod('recipes_blog_related_product_show_hide', true);

    if ( $recipes_blog_related_product_show_hide != true) {
        ?>
        <style type="text/css">
            .related.products {
                display: none;
            }
        </style>
        <?php
    }
}
add_action('wp_head', 'recipes_blog_related_product_css');

// Woocommerce Product Sale Position 
function recipes_blog_product_sale_position_customizer_css() {
    $recipes_blog_layout_option = get_theme_mod('recipes_blog_product_sale_position', 'left');
    ?>
    <style type="text/css">
        .woocommerce ul.products li.product .onsale{
            <?php if ($recipes_blog_layout_option === 'left') : ?>
                right: auto;
                left: 15px;
            <?php else : ?>
                left: auto;
                right: 15px;
            <?php endif; ?>
        }
    </style>
    <?php
}
add_action('wp_head', 'recipes_blog_product_sale_position_customizer_css');  

//Footer Social Icon Alignment
function recipes_blog_footer_icons_alignment_css() {
    $recipes_blog_footer_social_align = get_theme_mod( 'recipes_blog_footer_social_align', 'center' );   
    ?>
    <style type="text/css">
        .socialicons {
            text-align: <?php echo esc_attr( $recipes_blog_footer_social_align ); ?> 
        }

        /* Mobile Specific */
        @media screen and (max-width: 575px) {
            .socialicons {
                text-align: center;
            }
        }
    </style>
    <?php
}
add_action( 'wp_head', 'recipes_blog_footer_icons_alignment_css' );

//Copyright Alignment
function recipes_blog_footer_copyright_alignment_css() {
    $recipes_blog_footer_bottom_align = get_theme_mod( 'recipes_blog_footer_bottom_align', 'center' );   
    ?>
    <style type="text/css">
        .site-footer .site-footer-bottom .site-footer-bottom-wrapper {
            justify-content: <?php echo esc_attr( $recipes_blog_footer_bottom_align ); ?> 
        }

        /* Mobile Specific */
        @media screen and (max-width: 575px) {
            .site-footer .site-footer-bottom .site-footer-bottom-wrapper {
                justify-content: center;
                text-align:center;
            }
        }
    </style>
    <?php
}
add_action( 'wp_head', 'recipes_blog_footer_copyright_alignment_css' );

//Copyright Font Size
function recipes_blog_copyright_font_size_css() {
    $recipes_blog_copyright_font_size = get_theme_mod('recipes_blog_copyright_font_size', 16);
    ?>
    <style type="text/css">
        .site-footer-bottom .site-info span {
            font-size: <?php echo esc_attr($recipes_blog_copyright_font_size); ?>px;
        }
    </style>
    <?php
}
add_action('wp_head', 'recipes_blog_copyright_font_size_css');

// Preloader Background Color Setting
function recipes_blog_preloader_background_colors_css() {
    $recipes_blog_preloader_background_color_setting = get_theme_mod('recipes_blog_preloader_background_color_setting', '');
        // Only output CSS if a color is set
        if (empty($recipes_blog_preloader_background_color_setting)) {
            return;
        }
    ?>
    <style type="text/css">
        #loader {
            background-color: <?php echo esc_attr($recipes_blog_preloader_background_color_setting); ?>;
        }
    </style>
    <?php
}
add_action('wp_head', 'recipes_blog_preloader_background_colors_css');

// Preloader Background Image Setting
function recipes_blog_preloader_background_image_css() {
    $recipes_blog_preloader_background_image_setting = get_theme_mod('recipes_blog_preloader_background_image_setting', '');
        // Only output CSS if the background image is set
        if (empty($recipes_blog_preloader_background_image_setting)) {
            return;
        }
    ?>
    <style type="text/css">
        #loader {
            background-image: url('<?php echo esc_url($recipes_blog_preloader_background_image_setting); ?>');
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
        }
    </style>
    <?php
}
add_action('wp_head', 'recipes_blog_preloader_background_image_css');

//Footer Heading Alignment
function recipes_blog_footer_heading_alignment_css() {
    $recipes_blog_footer_header_align = get_theme_mod( 'recipes_blog_footer_header_align', 'left' );   
    ?>
    <style type="text/css">
        .site-footer h4, footer#colophon h2.wp-block-heading, footer#colophon .widgettitle, footer#colophon .widget-title {
            text-align: <?php echo esc_attr( $recipes_blog_footer_header_align ); ?> 
        }
    </style>
    <?php
}
add_action( 'wp_head', 'recipes_blog_footer_heading_alignment_css' );

//First Capital Letter
function recipes_blog_show_first_caps() {
	$recipes_blog_first_caps = get_theme_mod('recipes_blog_show_first_caps', false);
	$recipes_blog_css = '';
	if ( $recipes_blog_first_caps ) {
	$recipes_blog_css .= '
		.mag-post-single .mag-post-detail .mag-post-excerpt p:first-of-type::first-letter {
		    font-size: 55px;
			font-weight: 600;
			margin-right: 6px;
			line-height: 1;
			display: inline-block;
			vertical-align: baseline;
		}';
	} else {
		$recipes_blog_css .= '
		.mag-post-single .mag-post-detail .mag-post-excerpt p:first-of-type::first-letter {
			display: none;
		}';
	}
	wp_add_inline_style( 'recipes-blog-style', $recipes_blog_css );
}
add_action( 'wp_enqueue_scripts', 'recipes_blog_show_first_caps' );

// Banner Button Color
function recipes_blog_banner_button_color_css() {
    $btn_color = get_theme_mod('recipes_blog_banner_btn_color');
    $btn_bg_color = get_theme_mod('recipes_blog_banner_btn_bg_color');
    $btn_border_color = get_theme_mod('recipes_blog_banner_btn_border_color');

    $custom_css = '';
    if ( !empty($btn_color) ) {
        $custom_css .= "
        .banner-slider-btn a.asterthemes-button{
            color: {$btn_color};
        }";
    }
    if ( !empty($btn_bg_color) ) {
        $custom_css .= "
        .banner-slider-btn a.asterthemes-button{
            background-color: {$btn_bg_color};
        }";
    }
     if ( !empty($btn_border_color) ) {
        $custom_css .= "
        .banner-slider-btn a.asterthemes-button{
            border: 2px solid {$btn_border_color};
        }";
    }

    wp_add_inline_style('recipes-blog-style', $custom_css);
}
add_action('wp_enqueue_scripts','recipes_blog_banner_button_color_css');