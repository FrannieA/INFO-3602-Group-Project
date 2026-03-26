<?php
/**
 * The template for displaying the footer
 * 
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package recipes_blog
 */

// Get the footer background color/image settings from customizer
$recipes_blog_footer_background_color = get_theme_mod('recipes_blog_footer_background_color_setting', '');
$recipes_blog_footer_background_image = get_theme_mod('recipes_blog_footer_background_image_setting');
$recipes_blog_footer_background_attachment = get_theme_mod('recipes_blog_footer_image_attachment_setting', 'scroll');

if (!is_front_page() || is_home()) {
    ?>
    </div>
    </div>
</div>
<?php } ?>

<footer id="colophon" class="site-footer">
    <?php if (get_theme_mod('recipes_blog_enable_footer_section', true)) { ?>
        <div class="site-footer-top" style="background-color: <?php echo esc_attr($recipes_blog_footer_background_color); ?>; <?php echo ($recipes_blog_footer_background_image) ? 'background-image: url(' . esc_url($recipes_blog_footer_background_image) . ');' : ''; ?> background-attachment: <?php echo esc_attr($recipes_blog_footer_background_attachment); ?>;">
            <div class="asterthemes-wrapper">
                <div class="footer-widgets-wrapper">

                    <?php
                    // Footer Widget
                    do_action('recipes_blog_footer_widget');
                    ?>

                </div>
            </div>
        </div>
    <?php } ?>
    <?php if (get_theme_mod('recipes_blog_enable_copyright_section', true)) { ?>
        <div class="site-footer-bottom">
            <div class="asterthemes-wrapper">
                <div class="site-footer-bottom-wrapper">
                    <div class="site-info">
                        <?php
                        do_action('recipes_blog_footer_copyright');
                        ?>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
</footer>

<?php
$recipes_blog_is_scroll_top_active = get_theme_mod( 'recipes_blog_scroll_top', true );
if ( $recipes_blog_is_scroll_top_active ) :
    $recipes_blog_scroll_shape = get_theme_mod( 'recipes_blog_scroll_top_shape', 'box' );
    $recipes_blog_scroll_position = get_theme_mod( 'recipes_blog_scroll_top_position', 'bottom-right' );
    ?>
    <style>
        #scroll-to-top {
            position: fixed;
            <?php
            switch ( $recipes_blog_scroll_position ) {
                case 'bottom-left':
                    echo 'bottom: 25px; left: 20px;';
                    break;
                case 'bottom-center':
                    echo 'bottom: 25px; left: 50%; transform: translateX(-50%);';
                    break;
                default: // 'bottom-right'
                    echo 'bottom: 25px; right: 90px;';
            }
            ?>
        }
    </style>
    <a href="#" id="scroll-to-top" class="recipes-blog-scroll-to-top <?php echo esc_attr($recipes_blog_scroll_shape); ?>"><i class="<?php echo esc_attr( get_theme_mod( 'recipes_blog_scroll_btn_icon', 'fas fa-chevron-up' ) ); ?>"></i></a>
<?php
endif;
?>
</div>

<?php wp_footer(); ?>

</body>
</html>