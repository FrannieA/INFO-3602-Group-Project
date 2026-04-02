<?php
/**
 * Template Name: Recipes & Filter Page
 * Description: Browse recipes with filters and ingredient matching
 */

get_header();
?>

<div style="max-width: 1400px; margin: 0 auto; padding: 20px; width: 95%;">
    
    <h1>Browse Recipes</h1>
    
    <!-- FILTER SECTION -->
    <div class="filters-section" style="background: #f5f5f51e; padding: 20px; border-radius: 10px; margin-bottom: 30px;">
        <h3>Filter Recipes</h3>
        
        <form method="get" action="" id="filter-form">
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px;">
                
                <!-- Ingredient Match (your feature!) -->
                <div>
                    <label>Ingredients you have:</label>
                    <input type="text" 
                           name="ingredients" 
                           placeholder="tomato, onion, rice"
                           value="<?php echo isset($_GET['ingredients']) ? esc_attr($_GET['ingredients']) : ''; ?>"
                           style="width: 100%; padding: 8px;">
                </div>
                
                <!-- Dietary Filter -->
                <div>
                    <label>Dietary:</label>
                    <select name="diet" style="width: 100%; padding: 8px;">
                        <option value="">All</option>
                        <option value="vegetarian" <?php selected(isset($_GET['diet']) && $_GET['diet'] == 'vegetarian'); ?>>Vegetarian</option>
                        <option value="vegan" <?php selected(isset($_GET['diet']) && $_GET['diet'] == 'vegan'); ?>>Vegan</option>
                        <option value="gluten_free" <?php selected(isset($_GET['diet']) && $_GET['diet'] == 'gluten_free'); ?>>Gluten-Free</option>
                    </select>
                </div>
                
                <!-- Max Prep Time -->
                <div>
                    <label>Max Prep Time:</label>
                    <select name="max_time" style="width: 100%; padding: 8px;">
                        <option value="">Any time</option>
                        <option value="15" <?php selected(isset($_GET['max_time']) && $_GET['max_time'] == '15'); ?>>Under 15 min</option>
                        <option value="30" <?php selected(isset($_GET['max_time']) && $_GET['max_time'] == '30'); ?>>Under 30 min</option>
                        <option value="60" <?php selected(isset($_GET['max_time']) && $_GET['max_time'] == '60'); ?>>Under 60 min</option>
                    </select>
                </div>
                
                <!-- Budget Filter -->
                <div>
                    <label>Budget:</label>
                    <select name="budget" style="width: 100%; padding: 8px;">
                        <option value="">Any budget</option>
                        <option value="budget" <?php selected(isset($_GET['budget']) && $_GET['budget'] == 'budget'); ?>>💰 Budget (Under $5)</option>
                        <option value="moderate" <?php selected(isset($_GET['budget']) && $_GET['budget'] == 'moderate'); ?>>💰💰 Moderate ($5-$10)</option>
                    </select>
                </div>
            </div>
            
            <div style="margin-top: 15px;">
                <button type="submit" style="background: #ff7a00; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer;">Apply Filters</button>
                <a href="<?php echo get_permalink(); ?>" style="margin-left: 10px;">Clear Filters</a>
            </div>
        </form>
    </div>
    
    <!-- RESULTS SECTION -->
    <?php
    // Build the query based on filters
    $args = array(
        'post_type' => 'recipe',
        'posts_per_page' => 6,  // Show 6 per page for pagination
        'paged' => get_query_var('paged') ?: 1,
        'meta_query' => array(),
        'tax_query' => array(),
    );
    
    // 1. INGREDIENT MATCH (your complex query)
    if (isset($_GET['ingredients']) && !empty($_GET['ingredients'])) {
        $ingredients_array = array_map('trim', explode(',', sanitize_text_field($_GET['ingredients'])));
        
        $args['meta_query'][] = array('relation' => 'OR');
        
        foreach ($ingredients_array as $ingredient) {
            if (!empty($ingredient)) {
                $args['meta_query'][] = array(
                    'key' => '_recipe_ingredients',
                    'value' => $ingredient,
                    'compare' => 'LIKE'
                );
            }
        }
    }
    
    // 2. DIETARY FILTER
    if (isset($_GET['diet']) && !empty($_GET['diet'])) {
        $args['meta_query'][] = array(
            'key' => '_recipe_diet',
            'value' => sanitize_text_field($_GET['diet']),
            'compare' => '='
        );
    }
    
    // 3. PREP TIME FILTER
    if (isset($_GET['max_time']) && !empty($_GET['max_time'])) {
        $args['meta_query'][] = array(
            'key' => '_recipe_prep_time',
            'value' => intval($_GET['max_time']),
            'type' => 'NUMERIC',
            'compare' => '<='
        );
    }
    
    // 4. BUDGET FILTER
    if (isset($_GET['budget']) && !empty($_GET['budget'])) {
        $args['meta_query'][] = array(
            'key' => '_recipe_budget',
            'value' => sanitize_text_field($_GET['budget']),
            'compare' => '='
        );
    }
    
    // Run the query
    $recipe_query = new WP_Query($args);
    
    // Show results count
    echo '<div style="margin-bottom: 20px;">';
    echo '<strong>' . $recipe_query->found_posts . '</strong> recipes found';
    if (isset($_GET['ingredients']) && !empty($_GET['ingredients'])) {
        echo ' with ingredients: <em>' . esc_html($_GET['ingredients']) . '</em>';
    }
    echo '</div>';
    
    // Display recipes
    if ($recipe_query->have_posts()) {
        echo '<div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: 30px;">';
        
        while ($recipe_query->have_posts()) {
            $recipe_query->the_post();
            
            // Get recipe meta
            $prep_time = get_post_meta(get_the_ID(), '_recipe_prep_time', true);
            $budget = get_post_meta(get_the_ID(), '_recipe_budget', true);
            $diet = get_post_meta(get_the_ID(), '_recipe_diet', true);
            
            // Budget badge text
            $budget_text = '';
            if ($budget == 'budget') $budget_text = 'Budget';
            if ($budget == 'moderate') $budget_text = 'Moderate';
            
            // Diet badge
            $diet_text = '';
            if ($diet == 'vegetarian') $diet_text = 'Vegetarian';
            if ($diet == 'vegan') $diet_text = 'Vegan';
            if ($diet == 'gluten_free') $diet_text = 'Gluten-Free';
            ?>
            
            <div class="recipe-card" style="border: 1px solid #f5f5f51e; border-radius: 10px; overflow: hidden; background: #f5f5f51e; box-shadow: 0 2px 5px rgba(0,0,0,0.1);">
                <?php if (has_post_thumbnail()) : ?>
                    <a href="<?php the_permalink(); ?>">
                        <?php the_post_thumbnail('medium', array('style' => 'width:100%; height:200px; object-fit:cover;')); ?>
                    </a>
                <?php else: ?>
                    <div style="width:100%; height:200px; background: #ddd; display: flex; align-items: center; justify-content: center; color: #999;">
                        No Image
                    </div>
                <?php endif; ?>
                
                <div style="padding: 15px;">
                    <h3 style="margin: 0 0 10px 0;">
                        <a href="<?php the_permalink(); ?>" style="text-decoration: none; color: white;"><?php the_title(); ?></a>
                    </h3>
                    
                    <div style="display: flex; gap: 10px; margin-bottom: 10px; flex-wrap: wrap;">
                        <?php if ($prep_time): ?>
                            <span style="background: #0470bd; padding: 3px 8px; border-radius: 5px; font-size: 12px;">⏱️ <?php echo $prep_time; ?> min</span>
                        <?php endif; ?>
                        <?php if ($budget_text): ?>
                            <span style="background: #e79107; padding: 3px 8px; border-radius: 5px; font-size: 12px;"><?php echo $budget_text; ?></span>
                        <?php endif; ?>
                        <?php if ($diet_text): ?>
                            <span style="background: #57bd04; padding: 3px 8px; border-radius: 5px; font-size: 12px;"><?php echo $diet_text; ?></span>
                        <?php endif; ?>
                    </div>
                    
                    <p style="color: #666; font-size: 14px;"><?php echo wp_trim_words(get_the_excerpt(), 20); ?></p>
                    
                    <a href="<?php the_permalink(); ?>" style="display: inline-block; background: #ff7a00; color: white; padding: 8px 15px; border-radius: 5px; text-decoration: none; font-size: 14px;">View Recipe →</a>
                </div>
            </div>
            
            <?php
        }
        echo '</div>';
        
        // PAGINATION
        echo '<div class="pagination" style="margin-top: 40px; text-align: center;">';
        echo paginate_links(array(
            'total' => $recipe_query->max_num_pages,
            'current' => max(1, get_query_var('paged')),
            'prev_text' => '« Previous',
            'next_text' => 'Next »',
            'mid_size' => 2
        ));
        echo '</div>';
        
    } else {
        echo '<div style="background: #f5f5f51e; padding: 20px; border-radius: 5px; text-align: center;">';
        echo '<p>No recipes found matching your criteria.</p>';
        echo '<p>Try different ingredients or <a href="' . get_permalink() . '">clear all filters</a>.</p>';
        echo '</div>';
    }
    
    wp_reset_postdata();
    ?>
    
</div>

<?php get_footer(); ?>