<?php
/**
 * Plugin Name: SimmerDown - Ingredient Match
 * Description: Allows users to find recipes based on ingredients they have at home.
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

// Define plugin constants
define('SIMMERDOWN_IM_VERSION', '1.0.0');
define('SIMMERDOWN_IM_PATH', plugin_dir_path(__FILE__));
define('SIMMERDOWN_IM_URL', plugin_dir_url(__FILE__));

// Add admin menu
function simmerdown_im_admin_menu() {
    add_options_page(
        'Ingredient Match Settings',
        'Ingredient Match',
        'manage_options',
        'simmerdown-ingredient-match',
        'simmerdown_im_settings_page'
    );
}
add_action('admin_menu', 'simmerdown_im_admin_menu');

// Admin settings page
function simmerdown_im_settings_page() {
    ?>
    <div class="wrap">
        <h1>SimmerDown - Ingredient Match</h1>
        <hr>
        <h2>How to Use:</h2>
        <ol>
            <li><strong>Shortcode:</strong> Add <code>[ingredient_match]</code> to any page</li>
            <li><strong>Page Template:</strong> Create a new page and select "Ingredient Match" template</li>
        </ol>
    </div>
    <?php
}

// Register shortcode
function simmerdown_im_shortcode() {
    ob_start();
    $template_path = SIMMERDOWN_IM_PATH . 'templates/shortcode-form.php';
    if (file_exists($template_path)) {
        include $template_path;
    } else {
        echo '<p>Plugin template file not found. Please reinstall the plugin.</p>';
    }
    return ob_get_clean();
}
add_shortcode('ingredient_match', 'simmerdown_im_shortcode');

// Register page template
function simmerdown_im_register_template($templates) {
    $templates['ingredient-match-template.php'] = 'Ingredient Match';
    return $templates;
}
add_filter('theme_page_templates', 'simmerdown_im_register_template');

// Load page template
function simmerdown_im_load_template($template) {
    if (is_page_template('ingredient-match-template.php')) {
        $plugin_template = SIMMERDOWN_IM_PATH . 'templates/full-page-template.php';
        if (file_exists($plugin_template)) {
            return $plugin_template;
        }
    }
    return $template;
}
add_filter('template_include', 'simmerdown_im_load_template');

// Enqueue styles
function simmerdown_im_enqueue_styles() {
    wp_enqueue_style(
        'simmerdown-im-style',
        SIMMERDOWN_IM_URL . 'assets/style.css',
        array(),
        SIMMERDOWN_IM_VERSION
    );
}
add_action('wp_enqueue_scripts', 'simmerdown_im_enqueue_styles');

// Activation hook
function simmerdown_im_activate() {
    // Just to confirm plugin activated
    error_log('SimmerDown Ingredient Match plugin activated');
}
register_activation_hook(__FILE__, 'simmerdown_im_activate');