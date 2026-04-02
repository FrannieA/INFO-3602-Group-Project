<?php
/**
 * SimmerDown - Featured Recipes Homepage Section
 *
 * CUSTOM QUERY #1 (Documented):
 * Purpose  : Display the 6 most recently published recipes on the homepage,
 *            ordered by date descending. Pulls prep_time, budget, and
 *            difficulty custom fields for each card.
 * Post Type: recipe (custom)
 * Args     : posts_per_page = 6, orderby = date, order = DESC
 * Output   : Responsive card grid with meta badges and pagination link.
 *
 * @package recipes_blog
 */

if ( ! post_type_exists( 'recipe' ) ) {
    return; // Safety check — CPT must be registered
}
?>

<section id="sd-featured-recipes" class="sd-section sd-featured-recipes">
    <div class="asterthemes-wrapper">

        <div class="sd-section-header">
            <span class="sd-section-label"><?php esc_html_e( 'Fresh &amp; Affordable', 'recipes-blog' ); ?></span>
            <h2 class="sd-section-title"><?php esc_html_e( 'Featured Recipes', 'recipes-blog' ); ?></h2>
            <p class="sd-section-desc"><?php esc_html_e( 'Simple meals that prove eating well does not have to be expensive.', 'recipes-blog' ); ?></p>
        </div>

        <?php
        /**
         * CUSTOM QUERY #1
         * Fetches the 6 latest published recipes for homepage display.
         * post_status = publish ensures drafts are excluded.
         * no_found_rows = true speeds up the query (no pagination needed here).
         */
        $sd_featured_query = new WP_Query( array(
            'post_type'      => 'recipe',
            'post_status'    => 'publish',
            'posts_per_page' => 6,
            'orderby'        => 'date',
            'order'          => 'DESC',
            'no_found_rows'  => true,
        ) );

        if ( $sd_featured_query->have_posts() ) : ?>

            <div class="sd-recipe-grid">
                <?php while ( $sd_featured_query->have_posts() ) : $sd_featured_query->the_post();
                    $post_id    = get_the_ID();
                    $prep_time  = get_post_meta( $post_id, '_sd_prep_time',  true );
                    $cook_time  = get_post_meta( $post_id, '_sd_cook_time',  true );
                    $budget     = get_post_meta( $post_id, '_sd_budget',     true );
                    $difficulty = get_post_meta( $post_id, '_sd_difficulty', true );
                    $total_time = ( intval( $prep_time ) + intval( $cook_time ) );
                ?>
                    <article class="sd-recipe-card">
                        <a href="<?php the_permalink(); ?>" class="sd-recipe-card__img-link">
                            <?php if ( has_post_thumbnail() ) : ?>
                                <?php the_post_thumbnail( 'medium_large', array( 'class' => 'sd-recipe-card__img', 'loading' => 'lazy' ) ); ?>
                            <?php else : ?>
                                <div class="sd-recipe-card__img sd-recipe-card__img--placeholder">
                                    <span class="dashicons dashicons-food"></span>
                                </div>
                            <?php endif; ?>

                            <?php if ( $difficulty ) : ?>
                                <span class="sd-badge sd-badge--<?php echo esc_attr( $difficulty ); ?>">
                                    <?php echo esc_html( ucfirst( $difficulty ) ); ?>
                                </span>
                            <?php endif; ?>
                        </a>

                        <div class="sd-recipe-card__body">
                            <?php
                            $meal_types = get_the_terms( $post_id, 'meal_type' );
                            if ( $meal_types && ! is_wp_error( $meal_types ) ) : ?>
                                <span class="sd-recipe-card__type"><?php echo esc_html( $meal_types[0]->name ); ?></span>
                            <?php endif; ?>

                            <h3 class="sd-recipe-card__title">
                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                            </h3>

                            <p class="sd-recipe-card__excerpt">
                                <?php echo wp_trim_words( get_the_excerpt(), 12, '…' ); ?>
                            </p>

                            <div class="sd-recipe-card__meta">
                                <?php if ( $total_time > 0 ) : ?>
                                    <span class="sd-meta-item">
                                        <i class="fas fa-clock" aria-hidden="true"></i>
                                        <?php printf( esc_html__( '%d min', 'recipes-blog' ), $total_time ); ?>
                                    </span>
                                <?php endif; ?>

                                <?php if ( $budget ) : ?>
                                    <span class="sd-meta-item">
                                        <i class="fas fa-dollar-sign" aria-hidden="true"></i>
                                        <?php printf( esc_html__( 'TTD $%s', 'recipes-blog' ), esc_html( $budget ) ); ?>
                                    </span>
                                <?php endif; ?>
                            </div>

                            <a href="<?php the_permalink(); ?>" class="sd-recipe-card__link">
                                <?php esc_html_e( 'View Recipe', 'recipes-blog' ); ?>
                                <i class="fas fa-arrow-right" aria-hidden="true"></i>
                            </a>
                        </div>
                    </article>

                <?php endwhile; wp_reset_postdata(); ?>
            </div>

            <div class="sd-section-footer">
                <a href="<?php echo esc_url( get_post_type_archive_link( 'recipe' ) ); ?>" class="sd-btn sd-btn--outline">
                    <?php esc_html_e( 'Browse All Recipes', 'recipes-blog' ); ?>
                    <i class="fas fa-utensils" aria-hidden="true"></i>
                </a>
            </div>

        <?php else : ?>

            <div class="sd-empty-state">
                <i class="fas fa-utensils sd-empty-state__icon" aria-hidden="true"></i>
                <p><?php esc_html_e( 'Recipes are coming soon — check back shortly!', 'recipes-blog' ); ?></p>
                <?php if ( current_user_can( 'edit_posts' ) ) : ?>
                    <a href="<?php echo esc_url( admin_url( 'post-new.php?post_type=recipe' ) ); ?>" class="sd-btn">
                        <?php esc_html_e( 'Add Your First Recipe', 'recipes-blog' ); ?>
                    </a>
                <?php endif; ?>
            </div>

        <?php endif; ?>

    </div>
</section>
