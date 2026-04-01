<?php
/**
 * Template Name: Post & Reviews Page
 *
 * Parent page for the Post & Reviews section.
 * Displays three curated review sections directly — no shortcodes:
 *   Query 1 – Latest Reviews      (paginated, date DESC)
 *   Query 2 – Top Rated This Month (meta_value_num DESC, last 30 days)
 *   Query 3 – Super Budget Picks  (budget_score = 1)
 *
 * Child pages are shown as navigation cards at the bottom.
 *
 * @package recipes_blog
 */

get_header();

$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
?>

<main id="primary" class="site-main">
    <div class="container" style="max-width:1100px;margin:0 auto;padding:40px 20px 60px;">

        <!-- ─ Child page navigation cards  -->
        <?php
        $child_pages = get_pages( array(
            'parent'      => get_queried_object_id(),
            'sort_column' => 'menu_order',
            'sort_order'  => 'ASC',
        ) );

        if ( $child_pages ) : ?>
            <div class="review-child-nav" style="margin-top:5px; margin-bottom:48px;">
                <?php foreach ( $child_pages as $child_page ) :
                    $title_lower = strtolower( $child_page->post_title );
                    $icon        = ( strpos( $title_lower, 'write' ) !== false || strpos( $title_lower, 'submit' ) !== false ) ? '' : '';
                ?>
                    <a href="<?php echo esc_url( get_permalink( $child_page->ID ) ); ?>" class="review-child-card">
                        <span class="review-child-icon"><?php echo $icon; ?></span>
                        <span class="review-child-title"><?php echo esc_html( $child_page->post_title ); ?></span>
                        <span class="review-child-arrow">→</span>
                    </a>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>


        <?php
   
        while ( have_posts() ) : the_post();
            if ( get_the_content() ) :
        ?>
            <div class="entry-content review-page-intro"><?php the_content(); ?></div>
        <?php
            endif;
        endwhile;
        ?>

        <!--  Query 1: Latest Reviews  -->
        <h2 class="review-section-title" style="margin-top:16px;">Latest Reviews</h2>
        <?php
        $latest_query = new WP_Query( array(
            'post_type'      => 'recipe_review',
            'post_status'    => 'publish',
            'posts_per_page' => 9,
            'orderby'        => 'date',
            'order'          => 'DESC',
            'paged'          => $paged,
        ) );

        if ( $latest_query->have_posts() ) :
            echo '<div class="review-grid">';
            while ( $latest_query->have_posts() ) : $latest_query->the_post();
                recipe_reviews_render_card();
            endwhile;
            echo '</div>';
            recipe_reviews_render_pagination( $latest_query );
            wp_reset_postdata();
        else :
            echo '<p class="review-empty">' . esc_html__( 'No reviews yet. Be the first to share yours!', 'recipes-blog' ) . '</p>';
        endif;
        ?>

        <!--  Query 2: Top Rated This Month  -->
        <h2 class="review-section-title" style="margin-top:56px;">Top Rated This Month</h2>
        <?php
        $top_rated_query = new WP_Query( array(
            'post_type'      => 'recipe_review',
            'post_status'    => 'publish',
            'posts_per_page' => 3,
            'meta_key'       => '_review_star_rating',
            'orderby'        => 'meta_value_num',
            'order'          => 'DESC',
            'date_query'     => array(
                array( 'after' => '1 month ago', 'inclusive' => true ),
            ),
        ) );

        if ( $top_rated_query->have_posts() ) :
            echo '<div class="review-grid">';
            while ( $top_rated_query->have_posts() ) : $top_rated_query->the_post();
                recipe_reviews_render_card();
            endwhile;
            echo '</div>';
            wp_reset_postdata();
        else :
            echo '<p class="review-empty">' . esc_html__( 'No top-rated reviews for this month yet.', 'recipes-blog' ) . '</p>';
        endif;
        ?>

        <!--  Query 3: Super Budget Picks (budget_score = 1)  -->
        <h2 class="review-section-title" style="margin-top:56px;">Super Budget Picks</h2>
        <?php
        $budget_query = new WP_Query( array(
            'post_type'      => 'recipe_review',
            'post_status'    => 'publish',
            'posts_per_page' => 3,
            'orderby'        => 'date',
            'order'          => 'DESC',
            'meta_query'     => array(
                array(
                    'key'     => '_review_budget_score',
                    'value'   => 1,
                    'compare' => '=',
                    'type'    => 'NUMERIC',
                ),
            ),
        ) );

        if ( $budget_query->have_posts() ) :
            echo '<div class="review-grid">';
            while ( $budget_query->have_posts() ) : $budget_query->the_post();
                recipe_reviews_render_card();
            endwhile;
            echo '</div>';
            wp_reset_postdata();
        else :
            echo '<p class="review-empty">' . esc_html__( 'No super-cheap reviews yet — add the first one!', 'recipes-blog' ) . '</p>';
        endif;
        ?>

        
    </div>
</main>


<?php
if ( function_exists( 'recipes_blog_is_sidebar_enabled' ) && recipes_blog_is_sidebar_enabled() ) {
    get_sidebar();
}
get_footer();
?>
