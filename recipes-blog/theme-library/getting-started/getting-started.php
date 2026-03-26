<?php
/**
 * Getting Started Page.
 *
 * @package recipes_blog
 */


if( ! function_exists( 'recipes_blog_getting_started_menu' ) ) :
/**
 * Adding Getting Started Page in admin menu
 */
function recipes_blog_getting_started_menu(){	
	add_theme_page(
		__( 'Getting Started', 'recipes-blog' ),
		__( 'Getting Started', 'recipes-blog' ),
		'manage_options',
		'recipes-blog-getting-started',
		'recipes_blog_getting_started_page'
	);
}
endif;
add_action( 'admin_menu', 'recipes_blog_getting_started_menu' );

if( ! function_exists( 'recipes_blog_getting_started_admin_scripts' ) ) :
/**
 * Load Getting Started styles in the admin
 */
function recipes_blog_getting_started_admin_scripts( $hook ){
	// Load styles only on our page
	if( 'appearance_page_recipes-blog-getting-started' != $hook ) return;

    wp_enqueue_style( 'recipes-blog-getting-started', get_template_directory_uri() . '/resource/css/getting-started.css', false, RECIPES_BLOG_THEME_VERSION );

    wp_enqueue_script( 'recipes-blog-getting-started', get_template_directory_uri() . '/resource/js/getting-started.js', array( 'jquery' ), RECIPES_BLOG_THEME_VERSION, true );
}
endif;
add_action( 'admin_enqueue_scripts', 'recipes_blog_getting_started_admin_scripts' );

if( ! function_exists( 'recipes_blog_getting_started_page' ) ) :
/**
 * Callback function for admin page.
*/
function recipes_blog_getting_started_page(){ 
	$recipes_blog_theme = wp_get_theme();?>
	<div class="wrap getting-started container">
		<div class="getting-info">
			<div class="theme-intro">
				<div class="intro-wrap">
					<div class="intro cointaner">
						<div class="intro-content">
							<h3><?php echo esc_html( 'Welcome to', 'recipes-blog' );?> <span class="theme-name"><?php echo esc_html( RECIPES_BLOG_THEME_NAME ); ?></span></h3>
							<p class="about-text">
								<?php
								// Remove last sentence of description.
								$recipes_blog_description = explode( '. ', $recipes_blog_theme->get( 'Description' ) );

								$recipes_blog_description = implode( '. ', $recipes_blog_description );

								echo esc_html( $recipes_blog_description . '' );
							?></p>
							<div class="btns-getstart">
								<a href="<?php echo esc_url( RECIPES_BLOG_PREMIUM_PAGE ); ?>" target="_blank" class="button button-primary"><?php esc_html_e( 'Get Premium', 'recipes-blog' ); ?></a>
								<a href="<?php echo esc_url( RECIPES_BLOG_PRO_DEMO ); ?>" target="_blank" class="button button-primary"><?php esc_html_e( 'Live Demo', 'recipes-blog' ); ?></a>
								<a href="<?php echo esc_url( admin_url( 'customize.php' ) ); ?>" target="_blank" class="button button-primary"><?php esc_html_e( 'Customize Theme', 'recipes-blog' ); ?></a>
							</div>
							<div class="btns-wizard">
                                <?php if ( ! get_option('is-demo-imported') ) : ?>
                                    <a class="wizard" href="<?php echo esc_url( admin_url( 'themes.php?page=recipesblog-wizard' ) ); ?>" class="button button-primary"><?php esc_html_e( 'Import Theme Demo', 'recipes-blog' ); ?></a>
                                <?php else : ?>
                                    <a target="_blank" href="<?php echo esc_url( home_url() ); ?>" class="button button-primary view-site">
                                        <?php esc_html_e( 'Visit Your Website', 'recipes-blog' ); ?>
                                    </a>
                                <?php endif; ?>
  							</div>
						</div>
						<div class="intro-img">
							<img src="<?php echo esc_url(get_template_directory_uri()) .'/theme-library/getting-started/images/bundle.png'; ?>" />										
							<br>
							<h4 class="bundle-text"><?php esc_html_e( 'WP Theme Bundle', 'recipes-blog' ); ?></h4>
							<p class="about-text"><?php esc_html_e('Get access to a collection of premium WordPress themes in one bundle. Enjoy effortless website building, full customization, and dedicated customer support for a smooth, professional web experience.', 'recipes-blog'); ?></p>
							<a class="button button-primary" href="<?php echo esc_url( RECIPES_BLOG_BUNDLE_PAGE ); ?>" title="<?php esc_attr_e( 'Go Pro', 'recipes-blog' ); ?>" target="_blank">
								<?php esc_html_e( 'Exclusive Theme Bundle - $79', 'recipes-blog' ); ?>
							</a>
						</div>
					</div>
				</div>
				<div class="cointaner panels">
					<ul class="inline-list">
						<li class="current">
							<a id="help" href="javascript:void(0);">
								<?php esc_html_e( 'Getting Started', 'recipes-blog' ); ?>
							</a>
						</li>
						<li>
							<a id="free-pro-panel" href="javascript:void(0);">
								<?php esc_html_e( 'Free Vs Pro', 'recipes-blog' ); ?>
							</a>
						</li>
					</ul>
					<div id="panel" class="panel">
						<?php require get_template_directory() . '/theme-library/getting-started/tabs/help-panel.php'; ?>
						<?php require get_template_directory() . '/theme-library/getting-started/tabs/free-vs-pro-panel.php'; ?>
						<?php require get_template_directory() . '/theme-library/getting-started/tabs/link-panel.php'; ?>
					</div>
				</div>
			</div>
			<div class="icons-info">
				<div class="icon-img">									
					<a href="<?php echo esc_url( RECIPES_BLOG_REVIEW ); ?>" title="<?php esc_attr_e( 'Review Theme', 'recipes-blog' ); ?>" target="_blank">
						<img src="<?php echo esc_url(get_template_directory_uri()) .'/theme-library/getting-started/images/icon1.png'; ?>" />	
						<?php esc_html_e( 'Review Theme', 'recipes-blog' ); ?>
					</a>
				</div>
				<div class="icon-img">									
					<a href="<?php echo esc_url( RECIPES_BLOG_SUPPORT ); ?>" title="<?php esc_attr_e( 'Contact Support', 'recipes-blog' ); ?>" target="_blank">
						<img src="<?php echo esc_url(get_template_directory_uri()) .'/theme-library/getting-started/images/icon2.png'; ?>" />	
						<?php esc_html_e( 'Contact Support', 'recipes-blog' ); ?>
					</a>
				</div>
				<div class="icon-img">									
					<a href="<?php echo esc_url( RECIPES_BLOG_THEME_DOCUMENTATION ); ?>" title="<?php esc_attr_e( 'Free Theme Documentation', 'recipes-blog' ); ?>" target="_blank">
						<img src="<?php echo esc_url(get_template_directory_uri()) .'/theme-library/getting-started/images/icon3.png'; ?>" />	
						<?php esc_html_e( 'Free Theme Documentation', 'recipes-blog' ); ?>
					</a>
				</div>
			</div>	
		</div>	
	</div>
	<?php
}
endif;