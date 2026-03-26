<?php

/**
 * The sidebar containing the main widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package recipes_blog
 */

?>

<aside id="secondary" class="widget-area wow zoomIn delay-1000" data-wow-duration="2s">
	<?php dynamic_sidebar( 'sidebar-1' ); ?>
</aside>

<?php 
  if ( ! is_active_sidebar( 'sidebar-1' )) { ?>
	<aside id="secondary" class="widget-area wow zoomIn delay-1000" data-wow-duration="2s">
		<section id="Search" class="widget widget_block widget_archive " >
		    <h2 class="widget-title"><?php esc_html_e('Search', 'recipes-blog'); ?></h2>
		    <?php get_search_form(); ?>
		</section>
		<section id="archives" class="widget widget_block widget_archive " >
		    <h2 class="widget-title"><?php esc_html_e('Archives', 'recipes-blog'); ?></h2>
		    <ul>
		        <?php
		        wp_get_archives(array(
		            'type'            => 'monthly',
		            'show_post_count' => true,
		        ));
		        ?>
		    </ul>
		</section>
		<section id="categories" class="widget widget_categories" role="complementary">
		    <h2 class="widget-title"><?php esc_html_e('Categories', 'recipes-blog'); ?></h2>
		    <ul>
		        <?php
		        wp_list_categories(array(
		            'orderby'    => 'name',
		            'title_li'   => '',
		            'show_count' => true,
		        ));
		        ?>
		    </ul>
		</section>
		<section id="tags" class="widget widget_tag_cloud" role="complementary">
		    <h2 class="widget-title"><?php esc_html_e('Tags', 'recipes-blog'); ?></h2>
		    <?php
				$recipes_blog_tags = get_tags();
				if ($recipes_blog_tags) {
				    echo '<div class="tag-cloud">';
				    foreach ($recipes_blog_tags as $tag) {
				        $tag_link = get_tag_link($tag->term_id);
				        echo '<a href="' . esc_url($tag_link) . '" style="font-size:' . esc_attr($tag->font_size) . 'px;" class="tag-link">' . esc_html($tag->name) . '</a>';
				    }
				    echo '</div>';
				} else {
				    echo '<p>No tags found.</p>';
				}
			?>
		</section>
		<section id="recent-posts" class="widget" role="complementary">
		    <h2 class="widget-title"><?php esc_html_e('Recent Posts', 'recipes-blog'); ?></h2>
		    <ul class="recent-posts-list">
		        <?php
		        $recipes_blog_recent_posts = get_posts(array(
		            'numberposts' => 5, // Adjust the number of posts to display
		            'post_status' => 'publish',
		        ));

		        foreach ($recipes_blog_recent_posts as $post) :
		            setup_postdata($post);
		            ?>
		            <li>
		                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
		            </li>
		            <?php
		        endforeach;
		        wp_reset_postdata();
		        ?>
		    </ul>
		</section>
	</aside><!-- #secondary -->
<?php } ?>