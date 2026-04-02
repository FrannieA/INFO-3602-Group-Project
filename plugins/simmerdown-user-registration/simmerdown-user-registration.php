<?php
/**
 * Plugin Name: SimmerDown - User Registration
 * Description: Front-end user registration and login for SimmerDown site.
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

// Define constants
define('SIMMERDOWN_REG_PATH', plugin_dir_path(__FILE__));
define('SIMMERDOWN_REG_URL', plugin_dir_url(__FILE__));

// Enqueue styles
function simmerdown_reg_enqueue_styles() {
    wp_enqueue_style(
        'simmerdown-reg-style',
        SIMMERDOWN_REG_URL . 'assets/style.css',
        array(),
        '1.0.0'
    );
}
add_action('wp_enqueue_scripts', 'simmerdown_reg_enqueue_styles');

// Register shortcodes
function simmerdown_registration_form_shortcode() {
    ob_start();
    include SIMMERDOWN_REG_PATH . 'templates/registration-form.php';
    return ob_get_clean();
}
add_shortcode('register_form', 'simmerdown_registration_form_shortcode');

function simmerdown_login_form_shortcode() {
    ob_start();
    include SIMMERDOWN_REG_PATH . 'templates/login-form.php';
    return ob_get_clean();
}
add_shortcode('login_form', 'simmerdown_login_form_shortcode');

// Handle registration POST
function simmerdown_handle_registration() {
    if (!isset($_POST['simmerdown_register']) || !wp_verify_nonce($_POST['register_nonce'], 'simmerdown_register_action')) {
        return;
    }
    
    $username = sanitize_user($_POST['username']);
    $email = sanitize_email($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    
    $errors = array();
    
    if (empty($username)) $errors[] = 'Username is required.';
    if (empty($email)) $errors[] = 'Email is required.';
    if (empty($password)) $errors[] = 'Password is required.';
    if ($password !== $confirm_password) $errors[] = 'Passwords do not match.';
    if (username_exists($username)) $errors[] = 'Username already exists.';
    if (email_exists($email)) $errors[] = 'Email already registered.';
    if (strlen($password) < 6) $errors[] = 'Password must be at least 6 characters.';
    
    if (empty($errors)) {
        $user_id = wp_create_user($username, $password, $email);
        
        if (!is_wp_error($user_id)) {
            // Assign recipe_reviewer role (from Franchesca's plugin)
            $user = new WP_User($user_id);
            $user->set_role('recipe_reviewer');
            
            // Auto-login the user
            wp_set_current_user($user_id);
            wp_set_auth_cookie($user_id);
            
            // Store success message
            set_transient('simmerdown_reg_success', 'Registration successful! Welcome ' . $username, 30);
            
            // Redirect to write review page
            wp_redirect(home_url('/write-a-review'));
            exit;
        } else {
            set_transient('simmerdown_reg_error', $user_id->get_error_message(), 30);
        }
    } else {
        set_transient('simmerdown_reg_error', implode('<br>', $errors), 30);
    }
    
    wp_redirect(get_permalink());
    exit;
}
add_action('init', 'simmerdown_handle_registration');

// Handle login
function simmerdown_handle_login() {
    if (!isset($_POST['simmerdown_login']) || !wp_verify_nonce($_POST['login_nonce'], 'simmerdown_login_action')) {
        return;
    }
    
    $username = sanitize_user($_POST['username']);
    $password = $_POST['password'];
    $remember = isset($_POST['remember']) ? true : false;
    
    $creds = array(
        'user_login' => $username,
        'user_password' => $password,
        'remember' => $remember
    );
    
    $user = wp_signon($creds, false);
    
    if (is_wp_error($user)) {
        set_transient('simmerdown_login_error', 'Invalid username or password.', 30);
        wp_redirect(get_permalink());
        exit;
    } else {
        wp_redirect(home_url('/write-a-review'));
        exit;
    }
}
add_action('init', 'simmerdown_handle_login');

// Handle logout
function simmerdown_handle_logout() {
    if (isset($_GET['simmerdown_logout']) && $_GET['simmerdown_logout'] == 'true') {
        wp_logout();
        wp_redirect(home_url());
        exit;
    }
}
add_action('init', 'simmerdown_handle_logout');