<?php

/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package recipes_blog
 */

get_header();

$recipes_blog_column = get_theme_mod( 'recipes_blog_archive_column_layout', 'column-1' );
?>
<main id="primary" class="site-main">
	<?php if ( have_posts() ) : ?>
		<div class="recipes_blog-archive-layout grid-layout <?php echo esc_attr( $recipes_blog_column ); ?>">
			<?php
			/* Start the Loop */
			while ( have_posts() ) : the_post();

			get_template_part( 'template-parts/content', get_post_format() );

			endwhile;
			?>
		</div>
		<?php
		do_action( 'recipes_blog_posts_pagination' );
	else :
		get_template_part( 'template-parts/content', 'none' );
	endif;
	?>
</main>
<?php
if ( recipes_blog_is_sidebar_enabled() ) {
	get_sidebar();
}
get_footer();