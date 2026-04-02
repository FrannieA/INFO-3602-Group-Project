<?php
// Registration Form Template
?>

<div class="simmerdown-reg-container">
    <?php
    // Show success/error messages
    $error = get_transient('simmerdown_reg_error');
    if ($error) {
        echo '<div class="simmerdown-reg-msg error">' . wp_kses_post($error) . '</div>';
        delete_transient('simmerdown_reg_error');
    }
    
    if (is_user_logged_in()) {
        $current_user = wp_get_current_user();
        echo '<div class="simmerdown-reg-msg success">';
        echo 'Welcome back, ' . esc_html($current_user->display_name) . '! ';
        echo '<a href="' . wp_logout_url(home_url()) . '">Logout?</a>';
        echo '</div>';
        echo '<a href="' . home_url('/write-review') . '" class="simmerdown-reg-btn">Write a Review</a>';
        return;
    }
    ?>
    
    <div class="simmerdown-reg-form-wrapper">
        <h3>Create a SimmerDown Account</h3>
        <p>Join our community to share recipe reviews, save favorites, and get budget cooking tips!</p>
        
        <form method="post" action="" class="simmerdown-reg-form">
            <?php wp_nonce_field('simmerdown_register_action', 'register_nonce'); ?>
            
            <div class="simmerdown-reg-field">
                <label for="reg_username">Username *</label>
                <input type="text" id="reg_username" name="username" required>
            </div>
            
            <div class="simmerdown-reg-field">
                <label for="reg_email">Email Address *</label>
                <input type="email" id="reg_email" name="email" required>
            </div>
            
            <div class="simmerdown-reg-field">
                <label for="reg_password">Password *</label>
                <input type="password" id="reg_password" name="password" required>
                <small>At least 6 characters</small>
            </div>
            
            <div class="simmerdown-reg-field">
                <label for="reg_confirm_password">Confirm Password *</label>
                <input type="password" id="reg_confirm_password" name="confirm_password" required>
            </div>
            
            <button type="submit" name="simmerdown_register" class="simmerdown-reg-submit">
                Create Account
            </button>
            
            <p class="simmerdown-reg-login-link">
                Already have an account? <a href="<?php echo home_url('/login'); ?>">Login here</a>
            </p>
        </form>
    </div>
</div>