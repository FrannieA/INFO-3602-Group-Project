# SimmerDown - Ingredient Match Plugin

**Author:** SimmerDown Group  
**Version:** 1.0.0  
**Course:** INFO3602 - Web Programming and Technologies II

## Description

This plugin allows users to find recipes based on the ingredients they have at home. Simply enter ingredients separated by commas, and the plugin will search your recipe database for matching recipes.

## Features

- Search recipes by ingredients (separated by commas)
- Displays recipe cards with preparation time, budget, and dietary badges
- Shows popular recipes when no search is performed
- Pagination for search results
- Fully styled to match the SimmerDown theme

## Installation

1. Upload the `simmerdown-ingredient-match` folder to `/wp-content/plugins/`
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Use the shortcode or page template (see below)

## How to Use

### Method 1: Shortcode

Add the following shortcode to any page or post: `[ingredient_match]`


### Method 2: Page Template

1. Create a new page in WordPress
2. In the Page Attributes section, select "Ingredient Match" from the Template dropdown
3. Publish the page

## How It Works

1. User enters ingredients (e.g., "tomato, pasta, garlic")
2. Plugin splits the input into individual ingredients
3. A custom WP_Query searches for recipes where the `_recipe_ingredients` field contains ANY of the entered ingredients
4. Results are displayed with relevant metadata (time, budget, diet)
5. Pagination is included for large result sets

## Complex Query Documentation

The ingredient matching uses a dynamic meta query with OR relation:

```php
$args = array(
    'post_type' => 'recipe',
    'posts_per_page' => 12,
    'paged' => $paged,
    'meta_query' => array('relation' => 'OR')
);

foreach ($ingredients_array as $ingredient) {
    $args['meta_query'][] = array(
        'key' => '_recipe_ingredients',
        'value' => $ingredient,
        'compare' => 'LIKE'
    );
}