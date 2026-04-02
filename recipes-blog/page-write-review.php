<?php
/**
 * Template Name: Write a Review Child Page
 * Description: Child page of Post & Reviews. Renders the review submission form.
 * Child page of Post & Reviews.
 * Renders the submission form by calling recipe_reviews_render_form()
 * Login is required; guests see a login/register prompt instead.

 */

get_header();
?>

<main id="primary" class="site-main">
    <div class="container" style="max-width:1100px;margin:0 auto;padding:40px 20px 60px;">

        <p style="margin-bottom:24px;color:#fff;font-size:15px;">
             <h2 class="review-section-title" style="margin-top:16px;"> Tried a recipe? Rate it, leave a tip, and suggest modifications to help the community! </h2>
            
            <?php if ( ! is_user_logged_in() ) : ?>
                <br><strong>
                    <?php printf(
                        esc_html__( 'You need to %1$s or %2$s to submit a review.', 'recipes-blog' ),
                        '<a href="' . esc_url( wp_login_url( get_permalink() ) ) . '">' . esc_html__( 'log in', 'recipes-blog' ) . '</a>',
                        '<a href="' . esc_url( wp_registration_url() ) . '">' . esc_html__( 'register', 'recipes-blog' ) . '</a>'
                    ); ?>
                </strong>
            <?php endif; ?>
        </p>

        <?php recipe_reviews_render_form(); ?>

    </div>
</main>

<?php
if ( function_exists( 'recipes_blog_is_sidebar_enabled' ) && recipes_blog_is_sidebar_enabled() ) {
    get_sidebar();
}
get_footer();
?>
