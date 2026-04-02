<?php
/**
 * Template Name: Ingredient Match
 * Description: Find recipes based on ingredients you have at home
 */

get_header();
?>

<div class="container">
    <h1>Find Recipes by Ingredients</h1>
    <p>Enter the ingredients you have at home, separated by commas.</p>
    
    <!-- Search Form -->
    <form method="get" action="" style="margin: 30px 0;">
        <input type="text" 
               name="user_ingredients" 
               placeholder="e.g., tomato, onion, garlic, pasta"
               value="<?php echo isset($_GET['user_ingredients']) ? esc_attr($_GET['user_ingredients']) : ''; ?>"
               style="width: 70%; padding: 12px; font-size: 16px;">
        <button type="submit" style="padding: 12px 24px; background: #4CAF50; color: white; border: none; cursor: pointer;">
            Find Recipes
        </button>
    </form>
    
    <?php
    // Check for submitted ingredients
    if (isset($_GET['user_ingredients']) && !empty($_GET['user_ingredients'])) {
        
        // Clean up the input
        $ingredients_input = sanitize_text_field($_GET['user_ingredients']);
        $ingredients_array = array_map('trim', explode(',', $ingredients_input));
        
        echo '<h2>Recipes Matching Your Ingredients</h2>';
        echo '<p>You have: <strong>' . implode(', ', $ingredients_array) . '</strong></p>';
        
        // Build the query - find recipes that contain ANY of these ingredients
        $args = array(
            'post_type' => 'recipe',
            'posts_per_page' => 12,
            'paged' => get_query_var('paged') ?: 1,
            'meta_query' => array('relation' => 'OR')
        );
        
        // Add each ingredient as a separate LIKE condition
        foreach ($ingredients_array as $ingredient) {
            if (!empty($ingredient)) {
                $args['meta_query'][] = array(
                    'key' => '_recipe_ingredients',
                    'value' => $ingredient,
                    'compare' => 'LIKE'
                );
            }
        }
        
        // Run query
        $recipe_query = new WP_Query($args);
        
        if ($recipe_query->have_posts()) {
            echo '<div class="recipe-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 20px; margin-top: 20px;">';
            
            while ($recipe_query->have_posts()) {
                $recipe_query->the_post();
                ?>
                <div class="recipe-card" style="border: 1px solid #ddd; padding: 15px; border-radius: 8px;">
                    <?php if (has_post_thumbnail()) : ?>
                        <a href="<?php the_permalink(); ?>">
                            <?php the_post_thumbnail('medium', array('style' => 'width:100%; height:200px; object-fit:cover; border-radius:5px;')); ?>
                        </a>
                    <?php endif; ?>
                    <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                    <p><?php echo wp_trim_words(get_the_excerpt(), 20); ?></p>
                    <a href="<?php the_permalink(); ?>" style="color: #4CAF50;">View Recipe →</a>
                </div>
                <?php
            }
            echo '</div>';
            
            // Pagination
            echo '<div class="pagination" style="margin-top: 30px; text-align: center;">';
            echo paginate_links(array(
                'total' => $recipe_query->max_num_pages,
                'current' => max(1, get_query_var('paged')),
                'prev_text' => '« Previous',
                'next_text' => 'Next »'
            ));
            echo '</div>';
            
        } else {
            echo '<p style="background: #fff3cd; padding: 15px; border-radius: 5px;">No recipes found with those ingredients. Try different ingredients or check out our <a href="' . home_url('/recipes') . '">all recipes page</a>.</p>';
        }
        
        wp_reset_postdata();
    } else {
        // Example recipes when no search yet
        echo '<h3>Popular Recipes</h3>';
        echo '<div class="recipe-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 20px;">';
        
        $popular_args = array(
            'post_type' => 'recipe',
            'posts_per_page' => 6,
            'orderby' => 'comment_count',
            'order' => 'DESC'
        );
        $popular_query = new WP_Query($popular_args);
        
        if ($popular_query->have_posts()) {
            while ($popular_query->have_posts()) {
                $popular_query->the_post();
                ?>
                <div class="recipe-card" style="border: 1px solid #ddd; padding: 15px; border-radius: 8px;">
                    <?php if (has_post_thumbnail()) : ?>
                        <a href="<?php the_permalink(); ?>">
                            <?php the_post_thumbnail('medium', array('style' => 'width:100%; height:200px; object-fit:cover; border-radius:5px;')); ?>
                        </a>
                    <?php endif; ?>
                    <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                </div>
                <?php
            }
        }
        echo '</div>';
        wp_reset_postdata();
    }
    ?>
</div>

<?php get_footer(); ?>