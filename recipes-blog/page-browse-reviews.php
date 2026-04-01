<?php
/**
 * Template Name: Browse Reviews Child Page
 *
 * Child page of Post & Reviews.
 * A simple paginated archive of every published recipe_review,
 * sorted newest first. Uses recipe_reviews_render_card() directly
 * — no shortcodes.
 *
 * @package recipes_blog
 */

get_header();

$paged       = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
$all_reviews = new WP_Query( array(
    'post_type'      => 'recipe_review',
    'post_status'    => 'publish',
    'posts_per_page' => 12,
    'orderby'        => 'date',
    'order'          => 'DESC',
    'paged'          => $paged,
) );
?>

<main id="primary" class="site-main">
    <div class="container" style="max-width:1100px;margin:0 auto;padding:40px 20px 60px;">

        <?php if ( $all_reviews->have_posts() ) : ?>

            <div class="review-grid">
                <?php
                while ( $all_reviews->have_posts() ) : $all_reviews->the_post();
                    recipe_reviews_render_card();
                endwhile;
                wp_reset_postdata();
                ?>
            </div>

            <?php recipe_reviews_render_pagination( $all_reviews ); ?>

        <?php else : ?>
            <p class="review-empty"><?php esc_html_e( 'No reviews yet. Be the first to share yours!', 'recipes-blog' ); ?></p>
        <?php endif; ?>

    </div>
</main>

<?php
if ( function_exists( 'recipes_blog_is_sidebar_enabled' ) && recipes_blog_is_sidebar_enabled() ) {
    get_sidebar();
}
get_footer();
?>
