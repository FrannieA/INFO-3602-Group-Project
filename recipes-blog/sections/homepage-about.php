<?php
/**
 * SimmerDown - About / Intro + CTA Homepage Section
 *
 * Displays:
 *   1. About explaining SimmerDown's mission
 *   2. Three value-proposition cards (icons + text)
 *   3. Call-to-action: Register (logged-out) or Submit a Recipe (logged-in)
 *
 * @package recipes_blog
 */
?>

<section id="sd-about" class="sd-section sd-about-section">
    <div class="asterthemes-wrapper">

        <div class="sd-about-inner">

            <!-- ── Left: Mission Text ── -->
            <div class="sd-about-text">
                <span class="sd-section-label"><?php esc_html_e( 'Our Mission', 'recipes-blog' ); ?></span>
                <h2 class="sd-section-title">
                    <?php esc_html_e( 'Healthy Eating Shouldn\'t Cost a Fortune', 'recipes-blog' ); ?>
                </h2>
                <p>
                    <?php esc_html_e( 'SimmerDown was built for students, young adults, and families who want to eat well without draining their wallets. Every recipe is designed to be quick, nutritious, and made from ingredients you can actually find and afford.', 'recipes-blog' ); ?>
                </p>
                <p>
                    <?php esc_html_e( 'Browse by what\'s in your fridge, your dietary needs, or how much time you have. Cook with confidence — no chef required.', 'recipes-blog' ); ?>
                </p>

                <div class="sd-about-cta">
                    <?php if ( is_user_logged_in() ) : ?>
                        <a href="<?php echo esc_url( admin_url( 'post-new.php?post_type=recipe' ) ); ?>" class="sd-btn">
                            <i class="fas fa-plus" aria-hidden="true"></i>
                            <?php esc_html_e( 'Submit a Recipe', 'recipes-blog' ); ?>
                        </a>
                        <a href="<?php echo esc_url( get_post_type_archive_link( 'recipe' ) ); ?>" class="sd-btn sd-btn--outline">
                            <?php esc_html_e( 'Browse Recipes', 'recipes-blog' ); ?>
                        </a>
                    <?php else : ?>
                        <a href="<?php echo esc_url( wp_registration_url() ); ?>" class="sd-btn">
                            <i class="fas fa-user-plus" aria-hidden="true"></i>
                            <?php esc_html_e( 'Join the Community', 'recipes-blog' ); ?>
                        </a>
                        <a href="<?php echo esc_url( wp_login_url() ); ?>" class="sd-btn sd-btn--outline">
                            <?php esc_html_e( 'Sign In', 'recipes-blog' ); ?>
                        </a>
                    <?php endif; ?>
                </div>
            </div>

            <!-- ── Right: Value Cards ── -->
            <div class="sd-value-cards">

                <div class="sd-value-card">
                    <div class="sd-value-card__icon">
                        <i class="fas fa-piggy-bank" aria-hidden="true"></i>
                    </div>
                    <h3><?php esc_html_e( 'Budget Friendly', 'recipes-blog' ); ?></h3>
                    <p><?php esc_html_e( 'Every recipe includes an estimated cost so you know exactly what you\'re spending before you start cooking.', 'recipes-blog' ); ?></p>
                </div>

                <div class="sd-value-card">
                    <div class="sd-value-card__icon">
                        <i class="fas fa-clock" aria-hidden="true"></i>
                    </div>
                    <h3><?php esc_html_e( 'Quick to Make', 'recipes-blog' ); ?></h3>
                    <p><?php esc_html_e( 'Filter by preparation time and find meals that fit your schedule — from 10-minute snacks to Sunday batch cooks.', 'recipes-blog' ); ?></p>
                </div>

                <div class="sd-value-card">
                    <div class="sd-value-card__icon">
                        <i class="fas fa-leaf" aria-hidden="true"></i>
                    </div>
                    <h3><?php esc_html_e( 'Reduce Waste', 'recipes-blog' ); ?></h3>
                    <p><?php esc_html_e( 'Search by ingredients you already have at home and turn what\'s left in your fridge into something delicious.', 'recipes-blog' ); ?></p>
                </div>

                <div class="sd-value-card">
                    <div class="sd-value-card__icon">
                        <i class="fas fa-users" aria-hidden="true"></i>
                    </div>
                    <h3><?php esc_html_e( 'Community Recipes', 'recipes-blog' ); ?></h3>
                    <p><?php esc_html_e( 'Home cooks from across the Caribbean and beyond share their favourite budget meals. Join them and add your own.', 'recipes-blog' ); ?></p>
                </div>

            </div>

        </div>

    </div>
</section>


<!-- ── Registration / Community CTA Banner ── -->
<?php if ( ! is_user_logged_in() ) : ?>
<section id="sd-cta" class="sd-cta-section">
    <div class="asterthemes-wrapper">
        <div class="sd-cta-inner">
            <div class="sd-cta-text">
                <h2><?php esc_html_e( 'Ready to Start Cooking Smart?', 'recipes-blog' ); ?></h2>
                <p><?php esc_html_e( 'Create a free account to save recipes, submit your own creations, and join a community of budget-conscious cooks.', 'recipes-blog' ); ?></p>
            </div>
            <div class="sd-cta-actions">
                <a href="<?php echo esc_url( wp_registration_url() ); ?>" class="sd-btn sd-btn--white">
                    <i class="fas fa-user-plus" aria-hidden="true"></i>
                    <?php esc_html_e( 'Create Free Account', 'recipes-blog' ); ?>
                </a>
                <a href="<?php echo esc_url( get_post_type_archive_link( 'recipe' ) ); ?>" class="sd-btn sd-btn--white-outline">
                    <?php esc_html_e( 'Browse Without Signing Up', 'recipes-blog' ); ?>
                </a>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>
