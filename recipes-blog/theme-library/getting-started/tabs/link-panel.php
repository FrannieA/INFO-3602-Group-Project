<?php
/**
 * Right Buttons Panel.
 *
 * @package recipes_blog
 */
?>
<div class="panel-right">
	<div class="pro-btn theme-btn">
		<div class="screenshot">
			<img src="<?php echo esc_url(get_template_directory_uri()) .'/theme-library/getting-started/images/pro-screenshot.png'; ?>" />
		</div>
		<br>
		<div class="theme-info">
			<h3><?php esc_html_e( 'Recipes Bloggers WordPress Theme', 'recipes-blog' ); ?></h3>
			<div class="theme-price">
				<span class="price-text"><?php esc_html_e( 'Price:', 'recipes-blog' ); ?></h6>
				<del><?php esc_html_e( '$49', 'recipes-blog' ); ?></del>
				<span><?php esc_html_e( '$39', 'recipes-blog' ); ?></span>
			</div>
			<div class="panelbutton">
				<a class="button button-primary" href="<?php echo esc_url( RECIPES_BLOG_PREMIUM_PAGE ); ?>" title="<?php esc_attr_e( 'Go Pro', 'recipes-blog' ); ?>" target="_blank"><?php esc_html_e( 'Try Premium', 'recipes-blog' ); ?></a>

				<a class="button button-primary" href="<?php echo esc_url( RECIPES_BLOG_PRO_DEMO ); ?>" title="<?php esc_attr_e( 'Live Demo', 'recipes-blog' ); ?>" target="_blank"><?php esc_html_e( 'Live Demo', 'recipes-blog' ); ?></a>
			</div>
			<a class="button button-primary pro-doc" href="<?php echo esc_url( RECIPES_BLOG_PREMIUM_DOCUMENTATION ); ?>" title="<?php esc_attr_e( 'Pro Documentation', 'recipes-blog' ); ?>" target="_blank"><?php esc_html_e( 'Pro Documentation', 'recipes-blog' ); ?></a>
		</div>
	</div>
	<div class="pro-btn bundle-btn">
		<div class="bundle-img">
			<img src="<?php echo esc_url(get_template_directory_uri()) .'/theme-library/getting-started/images/bundle.png'; ?>" />
		</div>
		<br>
		<h3><?php esc_html_e( 'WP Theme Bundle', 'recipes-blog' ); ?></h3>
		<p><?php esc_html_e( 'Get access to a collection of premium WordPress themes in one bundle. Enjoy effortless website building, full customization, and dedicated customer support for a smooth, professional web experience.', 'recipes-blog' ); ?></p>
		<a class="button button-primary" href="<?php echo esc_url( RECIPES_BLOG_BUNDLE_PAGE ); ?>" title="<?php esc_attr_e( 'Go Pro', 'recipes-blog' ); ?>" target="_blank">
            <?php esc_html_e( 'Exclusive Theme Bundle - $79', 'recipes-blog' ); ?>
        </a>
	</div>
</div>