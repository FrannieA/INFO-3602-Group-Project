<?php
// Login Form Template
?>

<div class="simmerdown-reg-container">
    <?php
    $error = get_transient('simmerdown_login_error');
    if ($error) {
        echo '<div class="simmerdown-reg-msg error">' . esc_html($error) . '</div>';
        delete_transient('simmerdown_login_error');
    }
    
    if (is_user_logged_in()) {
        $current_user = wp_get_current_user();
        echo '<div class="simmerdown-reg-msg success">';
        echo 'You are logged in as ' . esc_html($current_user->display_name) . '. ';
        echo '<a href="' . wp_logout_url(home_url()) . '">Logout?</a>';
        echo '</div>';
        echo '<a href="' . home_url('/write-review') . '" class="simmerdown-reg-btn">Write a Review</a>';
        return;
    }
    ?>
    
    <div class="simmerdown-reg-form-wrapper">
        <h3>Login to SimmerDown</h3>
        
        <form method="post" action="" class="simmerdown-reg-form">
            <?php wp_nonce_field('simmerdown_login_action', 'login_nonce'); ?>
            
            <div class="simmerdown-reg-field">
                <label for="login_username">Username or Email *</label>
                <input type="text" id="login_username" name="username" required>
            </div>
            
            <div class="simmerdown-reg-field">
                <label for="login_password">Password *</label>
                <input type="password" id="login_password" name="password" required>
            </div>
            
            <div class="simmerdown-reg-field checkbox">
                <label>
                    <input type="checkbox" name="remember"> Remember Me
                </label>
            </div>
            
            <button type="submit" name="simmerdown_login" class="simmerdown-reg-submit">
                Login
            </button>
            
            <p class="simmerdown-reg-register-link">
                Don't have an account? <a href="<?php echo home_url('/register'); ?>">Register here</a>
            </p>
        </form>
    </div>
</div>