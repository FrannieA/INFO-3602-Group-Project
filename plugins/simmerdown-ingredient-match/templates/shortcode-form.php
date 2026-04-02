<?php
// Shortcode template for Ingredient Match
?>

<div class="simmerdown-im-container">
    <h1>Find Recipes by Ingredients</h1>
    <p>Enter the ingredients you have at home, separated by commas.</p>
    
    <form method="get" action="" style="margin: 30px 0;">
        <input type="text" 
               name="user_ingredients" 
               placeholder="e.g., tomato, onion, garlic, pasta"
               value="<?php echo isset($_GET['user_ingredients']) ? esc_attr($_GET['user_ingredients']) : ''; ?>"
               style="width: 70%; padding: 12px; font-size: 16px;">
        <button type="submit" style="padding: 12px 24px; background: #ff7a00; color: white; border: none; cursor: pointer;">
            Find Recipes
        </button>
    </form>
    
    <?php
    if (isset($_GET['user_ingredients']) && !empty($_GET['user_ingredients'])) {
        $ingredients_input = sanitize_text_field($_GET['user_ingredients']);
        $ingredients_array = array_map('trim', explode(',', $ingredients_input));
        
        echo '<h2>Recipes Matching Your Ingredients</h2>';
        echo '<p>You have: <strong>' . implode(', ', $ingredients_array) . '</strong></p>';
        
        $args = array(
            'post_type' => 'recipe',
            'posts_per_page' => 12,
            'paged' => get_query_var('paged') ?: 1,
            'meta_query' => array('relation' => 'OR')
        );
        
        foreach ($ingredients_array as $ingredient) {
            if (!empty($ingredient)) {
                $args['meta_query'][] = array(
                    'key' => '_recipe_ingredients',
                    'value' => $ingredient,
                    'compare' => 'LIKE'
                );
            }
        }
        
        $recipe_query = new WP_Query($args);
        
        if ($recipe_query->have_posts()) {
            echo '<div class="recipe-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 20px; margin-top: 20px;">';
            
            while ($recipe_query->have_posts()) {
                $recipe_query->the_post();
                $prep_time = get_post_meta(get_the_ID(), '_recipe_prep_time', true);
                $budget = get_post_meta(get_the_ID(), '_recipe_budget', true);
                $diet = get_post_meta(get_the_ID(), '_recipe_diet', true);
                
                $budget_text = '';
                if ($budget == 'budget') $budget_text = 'Budget';
                if ($budget == 'moderate') $budget_text = 'Moderate';
                
                $diet_text = '';
                if ($diet == 'vegetarian') $diet_text = 'Vegetarian';
                if ($diet == 'vegan') $diet_text = 'Vegan';
                if ($diet == 'gluten_free') $diet_text = 'Gluten-Free';
                ?>
                
                <div class="recipe-card" style="border: 1px solid #f5f5f51e; border-radius: 10px; overflow: hidden; background: #f5f5f51e;">
                    <?php if (has_post_thumbnail()) : ?>
                        <a href="<?php the_permalink(); ?>">
                            <?php the_post_thumbnail('medium', array('style' => 'width:100%; height:200px; object-fit:cover;')); ?>
                        </a>
                    <?php endif; ?>
                    <div style="padding: 15px;">
                        <h3 style="margin: 0 0 10px 0;">
                            <a href="<?php the_permalink(); ?>" style="text-decoration: none; color: white;"><?php the_title(); ?></a>
                        </h3>
                        <div style="display: flex; gap: 10px; margin-bottom: 10px; flex-wrap: wrap;">
                            <?php if ($prep_time): ?>
                                <span style="background: #0470bd; padding: 3px 8px; border-radius: 5px; font-size: 12px;"><?php echo $prep_time; ?> min</span>
                            <?php endif; ?>
                            <?php if ($budget_text): ?>
                                <span style="background: #e79107; padding: 3px 8px; border-radius: 5px; font-size: 12px;"><?php echo $budget_text; ?></span>
                            <?php endif; ?>
                            <?php if ($diet_text): ?>
                                <span style="background: #57bd04; padding: 3px 8px; border-radius: 5px; font-size: 12px;"><?php echo $diet_text; ?></span>
                            <?php endif; ?>
                        </div>
                        <a href="<?php the_permalink(); ?>" style="display: inline-block; background: #ff7a00; color: white; padding: 8px 15px; border-radius: 5px; text-decoration: none;">View Recipe →</a>
                    </div>
                </div>
                <?php
            }
            echo '</div>';
            
            echo '<div class="pagination" style="margin-top: 30px; text-align: center;">';
            echo paginate_links(array(
                'total' => $recipe_query->max_num_pages,
                'current' => max(1, get_query_var('paged')),
                'prev_text' => '« Previous',
                'next_text' => 'Next »'
            ));
            echo '</div>';
        } else {
            echo '<p style="background: #f5f5f51e; padding: 20px; text-align: center;">No recipes found. Try different ingredients.</p>';
        }
        wp_reset_postdata();
    } else {
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
                <div class="recipe-card" style="border: 1px solid #f5f5f51e; border-radius: 10px; overflow: hidden; background: #f5f5f51e;">
                    <?php if (has_post_thumbnail()) : ?>
                        <a href="<?php the_permalink(); ?>">
                            <?php the_post_thumbnail('medium', array('style' => 'width:100%; height:200px; object-fit:cover;')); ?>
                        </a>
                    <?php endif; ?>
                    <div style="padding: 15px;">
                        <h3><a href="<?php the_permalink(); ?>" style="text-decoration: none; color: white;"><?php the_title(); ?></a></h3>
                    </div>
                </div>
                <?php
            }
        }
        echo '</div>';
        wp_reset_postdata();
    }
    ?>
</div>