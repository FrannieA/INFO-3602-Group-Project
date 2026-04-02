# SimmerDown - Budget Healthy Recipes Website

**Course:** INFO3602 - Web Programming and Technologies II  
**Semester:** Semester II, 2025/2026  
**Team Name:** SimmerDown  
**Group:** 3

## Team Members

| Name | Student ID | Role |
|------|------------|------|
| Jasmin Hippolyte | 816036300 |
| Franchesca Ammon | 816040884 |
| Darius Sankar | 816036271 |
| Jael Hamilton | 816035832 |

## Project Overview

SimmerDown is a budget-friendly healthy recipe website designed to make healthy eating accessible and practical for students, young adults, and families with limited time, ingredients, or financial resources.

The site allows users to:
- Browse recipes filtered by dietary needs, preparation time, and budget
- Search recipes based on ingredients they already have at home (Ingredient Match)
- Submit their own recipe reviews with star ratings
- Comment on existing recipes

## Live Site

**URL:** [Website-URL]

## Technology Stack

| Tool | Purpose |
|------|---------|
| WordPress | Content Management System |
| Recipes Blog Theme | Base theme (customized) |
| Local by Flywheel | Local development |
| Git & GitHub | Version control |
| InfinityFree | Web hosting |

---

## Custom Plugins Developed

### Plugin 1: SimmerDown - Ingredient Match

Allows users to find recipes based on ingredients they have at home.

**Features:**
- Search by ingredients (comma-separated)
- Displays recipe cards with prep time, budget, and dietary badges
- Pagination for search results
- Shortcode `[ingredient_match]` and page template support

**Location:** `/wp-content/plugins/simmerdown-ingredient-match/`

---

### Plugin 2: SimmerDown – Post & Reviews

Adds a Recipe Review custom post type with star ratings and front-end submission form.

**Features:**
- Recipe review custom post type
- Star rating (1-5) and budget score (1-5)
- Front-end review submission form (logged-in users only)
- Custom user role: `recipe_reviewer`
- Review moderation (pending approval)

**Location:** `/wp-content/plugins/SimmerDownReview/`

---

### Plugin 3: SimmerDown - User Registration

Provides front-end user registration and login functionality.

**Features:**
- Front-end registration form with validation
- Front-end login form
- Auto-login after registration
- Auto-assign `recipe_reviewer` role
- Shortcodes: `[register_form]` and `[login_form]`

**Location:** `/wp-content/plugins/simmerdown-user-registration/`


---

### Complex Query #1: Ingredient Match

**Location:** `simmerdown-ingredient-match/templates/shortcode-form.php`

**Purpose:** Finds recipes that contain any of the user's provided ingredients.

**Why it is complex:**
- Dynamically builds a query with a variable number of conditions (one per ingredient entered by the user)
- Uses `relation => 'OR'` to match ANY ingredient (not requiring all ingredients)
- Uses `LIKE` comparison for partial matching (e.g., "toma" matches "tomato")
- Sanitizes user input for security
- Handles pagination correctly with large result sets

**Code:**

```php
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

```

### Complex Query #2: Top Rated This Month

**Location:** `page-post-reviews.php (Post & Reviews Page Template)`

**Purpose:** Displays the highest-rated recipe reviews from the last 30 days.

**Why it is complex:**

- Combines meta query (star rating) with date query (last 30 days)
- Uses meta_value_num for proper numeric sorting
- Filters posts by date range using date_query
- Limits results to 3 most relevant reviews

**Code:**

```php
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

```


### Complex Query #3: Super Budget Picks

**Location:** `page-post-reviews.php (Post & Reviews Page Template)`

**Purpose:** Displays reviews where the budget score equals 1 (very cheap).

**Why it is complex:**

- Uses a numeric meta query with exact value comparison
- Includes type specification (NUMERIC) for proper comparison
- Sorted by date to show most recent budget-friendly reviews first

**Code:**

```php
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

```


## Page Hierarchy

Post & Reviews (Parent Page)
├── Write Review (Child Page)
└── Browse Reviews (Child Page)


## User Roles & Permissions

| Role | Capabilities |
|------|-------------|
| Administrator | Full site control |
| Editor | Can publish and manage all reviews |
| Recipe Reviewer | Can submit reviews (pending moderation), read content |


## Front-End Features

| Feature | Description |
|---------|-------------|
| Ingredient Match Search | Users enter ingredients, system finds matching recipes |
| Recipe Filters | Filter by diet, prep time, and budget |
| Review Submission | Logged-in users can submit recipe reviews with star ratings |
| User Registration/Login | Full front-end authentication system |
| Comments | Users can comment on recipes |
| Breadcrumbs | Dynamic navigation trail on all pages |


## Changelog

### Version 1.0.0 (April 2, 2026)

- Initial release
- Recipe custom post type with custom fields
- Ingredient Match feature with complex query
- Post & Reviews system with 2 complex queries
- Front-end user registration and login
- Recipe filtering by diet, time, and budget
- Pagination on all archive pages
- 3 custom interactive plugins
- Custom breadcrumbs implementation
- Comments enabled on recipes

## Acknowledgments

- Theme base: Recipes Blog by Aster Themes (customized for SimmerDown)
- Icons: Font Awesome


## License

**This project was created for educational purposes only.**