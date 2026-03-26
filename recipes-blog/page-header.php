<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! recipes_blog_has_page_header() ) {
    return;
}

$recipes_blog_classes = array( 'page-header' );
$recipes_blog_style = recipes_blog_page_header_style();

if ( $recipes_blog_style ) {
    $recipes_blog_classes[] = $recipes_blog_style . '-page-header';
}

$recipes_blog_visibility = get_theme_mod( 'recipes_blog_page_header_visibility', 'all-devices' );

if ( 'hide-all-devices' === $recipes_blog_visibility ) {
    // Don't show the header at all
    return;
}

if ( 'hide-tablet' === $recipes_blog_visibility ) {
    $recipes_blog_classes[] = 'hide-on-tablet';
} elseif ( 'hide-mobile' === $recipes_blog_visibility ) {
    $recipes_blog_classes[] = 'hide-on-mobile';
} elseif ( 'hide-tablet-mobile' === $recipes_blog_visibility ) {
    $recipes_blog_classes[] = 'hide-on-tablet-mobile';
}

$recipes_blog_PAGE_TITLE_background_color = get_theme_mod('recipes_blog_page_title_background_color_setting', '');

// Get the toggle switch value
$recipes_blog_background_image_enabled = get_theme_mod('recipes_blog_page_header_style', true);

// Add background image to the header if enabled
$recipes_blog_background_image = get_theme_mod( 'recipes_blog_page_header_background_image', '' );
$recipes_blog_background_height = get_theme_mod( 'recipes_blog_page_header_image_height', '200' );
$recipes_blog_inline_style = '';

if ( $recipes_blog_background_image_enabled && ! empty( $recipes_blog_background_image ) ) {
    $recipes_blog_inline_style .= 'background-image: url(' . esc_url( $recipes_blog_background_image ) . '); ';
    $recipes_blog_inline_style .= 'height: ' . esc_attr( $recipes_blog_background_height ) . 'px; ';
    $recipes_blog_inline_style .= 'background-size: cover; ';
    $recipes_blog_inline_style .= 'background-position: center center; ';

    // Add the unique class if the background image is set
    $recipes_blog_classes[] = 'has-background-image';
}

$recipes_blog_classes = implode( ' ', $recipes_blog_classes );
$recipes_blog_heading = get_theme_mod( 'recipes_blog_page_header_heading_tag', 'h1' );
$recipes_blog_heading = apply_filters( 'recipes_blog_page_header_heading', $recipes_blog_heading );

?>

<?php do_action( 'recipes_blog_before_page_header' ); ?>

<header class="<?php echo esc_attr( $recipes_blog_classes ); ?>" style="<?php echo esc_attr( $recipes_blog_inline_style ); ?> background-color: <?php echo esc_attr($recipes_blog_PAGE_TITLE_background_color); ?>;">

    <?php do_action( 'recipes_blog_before_page_header_inner' ); ?>

    <div class="asterthemes-wrapper page-header-inner">

        <?php if ( recipes_blog_has_page_header() ) : ?>

            <<?php echo esc_attr( $recipes_blog_heading ); ?> class="page-header-title">
                <?php echo wp_kses_post( recipes_blog_get_page_title() ); ?>
            </<?php echo esc_attr( $recipes_blog_heading ); ?>>

        <?php endif; ?>

        <?php if ( function_exists( 'recipes_blog_breadcrumb' ) ) : ?>
            <?php recipes_blog_breadcrumb(); ?>
        <?php endif; ?>

    </div><!-- .page-header-inner -->

    <?php do_action( 'recipes_blog_after_page_header_inner' ); ?>

</header><!-- .page-header -->

<?php do_action( 'recipes_blog_after_page_header' ); ?>