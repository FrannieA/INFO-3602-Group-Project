<?php
/**
 * Plugin Name: SimmerDown – Post & Reviews
 * Description: Adds a Recipe Review custom post type, star-rating meta, and a front-end user submission form for the Budget Healthy Recipes site.

 */

if ( ! defined( 'ABSPATH' ) ) exit;

/*  Register Custom Post Type = recipe_review */
add_action( 'init', 'recipe_reviews_register_cpt' );
function recipe_reviews_register_cpt() {
    $labels = array(
        'name'               => __( 'Recipe Reviews',        'recipes-blog' ),
        'singular_name'      => __( 'Recipe Review',         'recipes-blog' ),
        'add_new'            => __( 'Add New Review',        'recipes-blog' ),
        'add_new_item'       => __( 'Add New Recipe Review', 'recipes-blog' ),
        'edit_item'          => __( 'Edit Recipe Review',    'recipes-blog' ),
        'new_item'           => __( 'New Recipe Review',     'recipes-blog' ),
        'view_item'          => __( 'View Recipe Review',    'recipes-blog' ),
        'search_items'       => __( 'Search Reviews',        'recipes-blog' ),
        'not_found'          => __( 'No reviews found',      'recipes-blog' ),
        'not_found_in_trash' => __( 'No reviews found in Trash', 'recipes-blog' ),
        'menu_name'          => __( 'Recipe Reviews',        'recipes-blog' ),
    );

    register_post_type( 'recipe_review', array(
        'labels'          => $labels,
        'public'          => true,
        'has_archive'     => true,
        'rewrite'         => array( 'slug' => 'recipe-reviews' ),
        'show_in_rest'    => true,
        'supports'        => array( 'title', 'editor', 'author', 'thumbnail', 'comments', 'custom-fields' ),
        'menu_icon'       => 'dashicons-star-filled',
        'capability_type' => 'post',
        'map_meta_cap'    => true,
    ) );
}

/* Add Meta Box */
add_action( 'add_meta_boxes', 'recipe_reviews_add_meta_box' );
function recipe_reviews_add_meta_box() {
    add_meta_box(
        'recipe_review_details',
        __( 'Review Details', 'recipes-blog' ),
        'recipe_reviews_meta_box_html',
        'recipe_review',
        'normal',
        'high'
    );
}

function recipe_reviews_meta_box_html( $post ) {
    wp_nonce_field( 'recipe_reviews_save_meta', 'recipe_reviews_nonce' );

    $star_rating   = get_post_meta( $post->ID, '_review_star_rating',   true );
    $budget_score  = get_post_meta( $post->ID, '_review_budget_score',  true );
    $recipe_link   = get_post_meta( $post->ID, '_review_recipe_link',   true );
    $reviewer_tip  = get_post_meta( $post->ID, '_review_reviewer_tip',  true );
    $modifications = get_post_meta( $post->ID, '_review_modifications', true );
    ?>
    <table class="form-table">
        <tr>
            <th><label for="review_star_rating"><?php esc_html_e( 'Star Rating (1–5)', 'recipes-blog' ); ?></label></th>
            <td>
                <select name="review_star_rating" id="review_star_rating">
                    <?php for ( $i = 1; $i <= 5; $i++ ) : ?>
                        <option value="<?php echo $i; ?>" <?php selected( $star_rating, $i ); ?>><?php echo $i; ?> ★</option>
                    <?php endfor; ?>
                </select>
            </td>
        </tr>
        <tr>
            <th><label for="review_budget_score"><?php esc_html_e( 'Budget Score (1–5)', 'recipes-blog' ); ?></label></th>
            <td>
                <select name="review_budget_score" id="review_budget_score">
                    <?php for ( $i = 1; $i <= 5; $i++ ) : ?>
                        <option value="<?php echo $i; ?>" <?php selected( $budget_score, $i ); ?>><?php echo $i; ?> 💰</option>
                    <?php endfor; ?>
                </select>
                <p class="description"><?php esc_html_e( '1 = Very Cheap, 5 = Moderately Priced', 'recipes-blog' ); ?></p>
            </td>
        </tr>
        <tr>
            <th><label for="review_recipe_link"><?php esc_html_e( 'Related Recipe (URL)', 'recipes-blog' ); ?></label></th>
            <td><input type="url" name="review_recipe_link" id="review_recipe_link" value="<?php echo esc_url( $recipe_link ); ?>" class="widefat" /></td>
        </tr>
        <tr>
            <th><label for="review_reviewer_tip"><?php esc_html_e( 'Reviewer Tip', 'recipes-blog' ); ?></label></th>
            <td><textarea name="review_reviewer_tip" id="review_reviewer_tip" rows="3" class="widefat"><?php echo esc_textarea( $reviewer_tip ); ?></textarea></td>
        </tr>
        <tr>
            <th><label for="review_modifications"><?php esc_html_e( 'Suggested Modifications', 'recipes-blog' ); ?></label></th>
            <td><textarea name="review_modifications" id="review_modifications" rows="3" class="widefat"><?php echo esc_textarea( $modifications ); ?></textarea></td>
        </tr>
    </table>
    <?php
}

add_action( 'save_post_recipe_review', 'recipe_reviews_save_meta' );
function recipe_reviews_save_meta( $post_id ) {
    if ( ! isset( $_POST['recipe_reviews_nonce'] ) ) return;
    if ( ! wp_verify_nonce( $_POST['recipe_reviews_nonce'], 'recipe_reviews_save_meta' ) ) return;
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
    if ( ! current_user_can( 'edit_post', $post_id ) ) return;

    $fields = array(
        '_review_star_rating'   => array( 'input' => 'review_star_rating',   'sanitize' => 'absint' ),
        '_review_budget_score'  => array( 'input' => 'review_budget_score',  'sanitize' => 'absint' ),
        '_review_recipe_link'   => array( 'input' => 'review_recipe_link',   'sanitize' => 'esc_url_raw' ),
        '_review_reviewer_tip'  => array( 'input' => 'review_reviewer_tip',  'sanitize' => 'sanitize_text_field' ),
        '_review_modifications' => array( 'input' => 'review_modifications', 'sanitize' => 'sanitize_textarea_field' ),
    );

    foreach ( $fields as $meta_key => $config ) {
        if ( isset( $_POST[ $config['input'] ] ) ) {
            update_post_meta( $post_id, $meta_key, $config['sanitize']( $_POST[ $config['input'] ] ) );
        }
    }
}

/* User Roles*/
register_activation_hook( __FILE__, 'recipe_reviews_setup_roles' );
function recipe_reviews_setup_roles() {
    // Editor: can approve and manage recipe reviews
    $editor = get_role( 'editor' );
    if ( $editor ) {
        $editor->add_cap( 'publish_posts' );
        $editor->add_cap( 'edit_others_posts' );
        $editor->add_cap( 'delete_others_posts' );
        $editor->add_cap( 'edit_published_posts' );
    }

    // Custom role: Recipe Reviewer — can submit but not publish (pending moderation)
    if ( ! get_role( 'recipe_reviewer' ) ) {
        add_role( 'recipe_reviewer', __( 'Recipe Reviewer', 'recipes-blog' ), array(
            'read'          => true,
            'edit_posts'    => true,
            'delete_posts'  => false,
            'publish_posts' => false,
            'upload_files'  => true,
        ) );
    }
}

register_deactivation_hook( __FILE__, 'recipe_reviews_cleanup_roles' );
function recipe_reviews_cleanup_roles() {
    remove_role( 'recipe_reviewer' );
}

/* Frontend processing */

/**
 * Handle the review submission POST and return an HTML message string,
 * or an empty string if the form hasn't been submitted yet.
 */
function recipe_reviews_handle_submission() {
    if ( ! isset( $_POST['review_submit'] ) ) {
        return '';
    }
    if ( ! wp_verify_nonce( $_POST['review_form_nonce'], 'recipe_reviews_submit' ) ) {
        return '<div class="review-msg error">' . esc_html__( 'Security check failed. Please try again.', 'recipes-blog' ) . '</div>';
    }

    $title   = sanitize_text_field( $_POST['review_title']       ?? '' );
    $content = sanitize_textarea_field( $_POST['review_content'] ?? '' );
    $rating  = absint( $_POST['review_rating']                   ?? 0 );
    $budget  = absint( $_POST['review_budget']                   ?? 0 );
    $url     = esc_url_raw( $_POST['review_recipe_url']          ?? '' );
    $tip     = sanitize_text_field( $_POST['review_tip']         ?? '' );
    $mods    = sanitize_textarea_field( $_POST['review_mods']    ?? '' );

    if ( empty( $title ) || empty( $content ) || ! $rating ) {
        return '<div class="review-msg error">' . esc_html__( 'Please fill in all required fields.', 'recipes-blog' ) . '</div>';
    }

    $post_id = wp_insert_post( array(
        'post_type'    => 'recipe_review',
        'post_title'   => $title,
        'post_content' => $content,
        'post_status'  => 'pending',
        'post_author'  => get_current_user_id(),
    ) );

    if ( is_wp_error( $post_id ) ) {
        return '<div class="review-msg error">' . esc_html__( 'There was an error submitting your review. Please try again.', 'recipes-blog' ) . '</div>';
    }

    update_post_meta( $post_id, '_review_star_rating',   $rating );
    update_post_meta( $post_id, '_review_budget_score',  $budget );
    update_post_meta( $post_id, '_review_recipe_link',   $url );
    update_post_meta( $post_id, '_review_reviewer_tip',  $tip );
    update_post_meta( $post_id, '_review_modifications', $mods );

    return '<div class="review-msg success">' . esc_html__( 'Thank you! Your review has been submitted and is pending approval.', 'recipes-blog' ) . '</div>';
}

/**
 * Render the review submission form HTML.
 * Call this function directly inside a page template.
 */
function recipe_reviews_render_form() {
    if ( ! is_user_logged_in() ) {
        echo '<div class="review-login-notice"><p>' .
            sprintf(
                __( 'You must be <a href="%s">logged in</a> to submit a review.', 'recipes-blog' ),
                esc_url( wp_login_url( get_permalink() ) )
            ) .
            '</p></div>';
        return;
    }

    $message = recipe_reviews_handle_submission();
    if ( $message ) echo $message;
    ?>
    <div class="review-form-wrap">
        <h3 class="review-form-title"><?php esc_html_e( 'Share Your Review', 'recipes-blog' ); ?></h3>
        <form class="review-form" method="post" action="">
            <?php wp_nonce_field( 'recipe_reviews_submit', 'review_form_nonce' ); ?>

            <div class="review-field-group">
                <label for="review_title"><?php esc_html_e( 'Review Title *', 'recipes-blog' ); ?></label>
                <input type="text" id="review_title" name="review_title" required
                       placeholder="<?php esc_attr_e( 'e.g. Best Budget Pasta Ever!', 'recipes-blog' ); ?>">
            </div>

            <div class="review-field-row">
                <div class="review-field-group">
                    <label><?php esc_html_e( 'Overall Rating *', 'recipes-blog' ); ?></label>
                    <div class="review-star-picker">
                        <?php for ( $i = 5; $i >= 1; $i-- ) : ?>
                            <input type="radio" id="star_<?php echo $i; ?>" name="review_rating"
                                   value="<?php echo $i; ?>" <?php if ( $i === 5 ) echo 'required'; ?>>
                            <label for="star_<?php echo $i; ?>" title="<?php echo $i; ?> stars">★</label>
                        <?php endfor; ?>
                    </div>
                </div>
                <div class="review-field-group">
                    <label><?php esc_html_e( 'Budget Score *', 'recipes-blog' ); ?></label>
                    <div class="review-budget-picker">
                        <?php for ( $i = 1; $i <= 5; $i++ ) : ?>
                            <label class="review-budget-btn">
                                <input type="radio" name="review_budget" value="<?php echo $i; ?>"
                                       <?php if ( $i === 1 ) echo 'required'; ?>>
                                <?php echo '<span class="budget-active">' . str_repeat( '$', $i ) . '</span><span class="budget-dim">' . str_repeat( '$', 5 - $i ) . '</span>'; ?>
                            </label>
                        <?php endfor; ?>
                    </div>
                    <p class="review-helper"><?php esc_html_e( '$ = Very cheap · $$$$$ = Moderate', 'recipes-blog' ); ?></p>
                </div>
            </div>

            <div class="review-field-group">
                <label for="review_recipe_url"><?php esc_html_e( 'Recipe URL (optional)', 'recipes-blog' ); ?></label>
                <input type="url" id="review_recipe_url" name="review_recipe_url" placeholder="https://...">
            </div>

            <div class="review-field-group">
                <label for="review_content"><?php esc_html_e( 'Your Review *', 'recipes-blog' ); ?></label>
                <textarea id="review_content" name="review_content" rows="5" required
                          placeholder="<?php esc_attr_e( 'Share your experience with this recipe…', 'recipes-blog' ); ?>"></textarea>
            </div>

            <div class="review-field-group">
                <label for="review_tip"><?php esc_html_e( 'Your Best Tip', 'recipes-blog' ); ?></label>
                <input type="text" id="review_tip" name="review_tip"
                       placeholder="<?php esc_attr_e( 'e.g. Use day-old bread for better texture', 'recipes-blog' ); ?>">
            </div>

            <div class="review-field-group">
                <label for="review_mods"><?php esc_html_e( 'Suggested Modifications', 'recipes-blog' ); ?></label>
                <textarea id="review_mods" name="review_mods" rows="3"
                          placeholder="<?php esc_attr_e( 'e.g. Swap chicken for chickpeas for a vegan version', 'recipes-blog' ); ?>"></textarea>
            </div>

            <button type="submit" name="review_submit" class="review-submit-btn">
                <?php esc_html_e( 'Submit Review', 'recipes-blog' ); ?>
            </button>
        </form>
    </div>
    <?php
}

/* Render a single review card = called in the loop */
function recipe_reviews_render_card() {
    $rating  = intval( get_post_meta( get_the_ID(), '_review_star_rating',   true ) );
    $budget  = intval( get_post_meta( get_the_ID(), '_review_budget_score',  true ) );
    $tip     = get_post_meta( get_the_ID(), '_review_reviewer_tip',  true );
    $mods    = get_post_meta( get_the_ID(), '_review_modifications', true );
    $rec_url = get_post_meta( get_the_ID(), '_review_recipe_link',   true );
    ?>
    <article class="review-card">
        <?php if ( has_post_thumbnail() ) : ?>
            <div class="review-card-thumb">
                <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail( 'medium' ); ?></a>
            </div>
        <?php endif; ?>
        <div class="review-card-body">
            <div class="review-card-meta">
                <span class="review-stars" aria-label="<?php echo esc_attr( $rating . ' out of 5 stars' ); ?>">
                    <?php for ( $i = 1; $i <= 5; $i++ ) : ?>
                        <span class="star <?php echo ( $i <= $rating ) ? 'filled' : 'empty'; ?>">
                            <?php echo ( $i <= $rating ) ? '★' : '☆'; ?>
                        </span>
                    <?php endfor; ?>
                </span>
                <?php if ( $budget ) : ?>
                    <span class="review-budget-label" title="Budget Score">
                        <?php echo esc_html( str_repeat( '$', $budget ) ); ?>
                    </span>
                <?php endif; ?>
            </div>

            <h3 class="review-card-title">
                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
            </h3>
            <p class="review-card-byline">
                By <strong><?php the_author(); ?></strong> &middot; <?php echo get_the_date( 'M j, Y' ); ?>
            </p>
            <div class="review-card-excerpt"><?php the_excerpt(); ?></div>

            <?php if ( $tip ) : ?>
                <div class="review-card-tip"><span>Tips:</span><?php echo esc_html( $tip ); ?></div>
            <?php endif; ?>
            <?php if ( $mods ) : ?>
                <div class="review-card-mods"><span>Modifications:</span><em><?php echo esc_html( $mods ); ?></em></div>
            <?php endif; ?>

            <div class="review-card-footer">
                <a href="<?php the_permalink(); ?>" class="review-read-more">
                    <?php esc_html_e( 'Read Full Review', 'recipes-blog' ); ?>
                </a>
                <?php if ( $rec_url ) : ?>
                    <a href="<?php echo esc_url( $rec_url ); ?>" class="review-recipe-link"
                       target="_blank" rel="noopener">
                        <?php esc_html_e( 'View Recipe', 'recipes-blog' ); ?>
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </article>
    <?php
}

/* Render pagination*/
function recipe_reviews_render_pagination( $query ) {
    $paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
    echo '<div class="review-pagination">';
    echo paginate_links( array(
        'total'     => $query->max_num_pages,
        'current'   => $paged,
        'format'    => '?paged=%#%',
        'prev_text' => __( '« Prev', 'recipes-blog' ),
        'next_text' => __( 'Next »', 'recipes-blog' ),
    ) );
    echo '</div>';
}

/* Frontend assets */
add_action( 'wp_enqueue_scripts', 'recipe_reviews_enqueue_assets' );
function recipe_reviews_enqueue_assets() {
    wp_enqueue_style(
        'recipe-reviews-styles',
        plugin_dir_url( __FILE__ ) . 'assets/css/reviews.css',
        array(),
        '2.0.0'
    );
    wp_enqueue_script(
        'recipe-reviews-scripts',
        plugin_dir_url( __FILE__ ) . 'assets/js/reviews.js',
        array( 'jquery' ),
        '2.0.0',
        true
    );
}

/* Hooks */
register_activation_hook( __FILE__, function () {
    recipe_reviews_register_cpt();
    recipe_reviews_setup_roles();
    flush_rewrite_rules();
} );
register_deactivation_hook( __FILE__, function () {
    recipe_reviews_cleanup_roles();
    flush_rewrite_rules();
} );
