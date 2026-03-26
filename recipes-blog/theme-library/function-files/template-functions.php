<?php

/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package recipes_blog
 */

function recipes_blog_body_classes( $recipes_blog_classes ) {
	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$recipes_blog_classes[] = 'hfeed';
	}

	// Adds a class of no-sidebar when there is no sidebar present.
	if ( ! is_active_sidebar( 'sidebar-1' ) ) {
		$recipes_blog_classes[] = 'no-sidebar';
	}

	$recipes_blog_classes[] = recipes_blog_sidebar_layout();

	return $recipes_blog_classes;
}
add_filter( 'body_class', 'recipes_blog_body_classes' );

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function recipes_blog_pingback_header() {
	if ( is_singular() && pings_open() ) {
		printf( '<link rel="pingback" href="%s">', esc_url( get_bloginfo( 'pingback_url' ) ) );
	}
}
add_action( 'wp_head', 'recipes_blog_pingback_header' );


/**
 * Get all posts for customizer Post content type.
 */
function recipes_blog_get_post_choices() {
	$recipes_blog_choices = array( '' => esc_html__( '--Select--', 'recipes-blog' ) );
	$recipes_blog_args    = array( 'numberposts' => -1 );
	$recipes_blog_posts   = get_posts( $recipes_blog_args );

	foreach ( $recipes_blog_posts as $recipes_blog_post ) {
		$recipes_blog_id             = $recipes_blog_post->ID;
		$recipes_blog_title          = $recipes_blog_post->post_title;
		$recipes_blog_choices[ $recipes_blog_id ] = $recipes_blog_title;
	}

	return $recipes_blog_choices;
}
/**
 * Get all pages for customizer Page content type.
 */
function recipes_blog_get_page_choices() {
	$recipes_blog_choices = array( '' => esc_html__( '--Select--', 'recipes-blog' ) );
	$recipes_blog_pages   = get_pages();

	foreach ( $recipes_blog_pages as $recipes_blog_page ) {
		$recipes_blog_choices[ $recipes_blog_page->ID ] = $recipes_blog_page->post_title;
	}

	return $recipes_blog_choices;
}

if ( ! function_exists( 'recipes_blog_excerpt_length' ) ) :
	/**
	 * Excerpt length.
	 */
	function recipes_blog_excerpt_length( $recipes_blog_length ) {
		if ( is_admin() ) {
			return $recipes_blog_length;
		}

		return get_theme_mod( 'recipes_blog_excerpt_length', 20 );
	}
endif;
add_filter( 'excerpt_length', 'recipes_blog_excerpt_length', 999 );

if ( ! function_exists( 'recipes_blog_excerpt_more' ) ) :
	/**
	 * Excerpt more.
	 */
	function recipes_blog_excerpt_more( $recipes_blog_more ) {
		if ( is_admin() ) {
			return $recipes_blog_more;
		}

		return '&hellip;';
	}
endif;
add_filter( 'excerpt_more', 'recipes_blog_excerpt_more' );

if ( ! function_exists( 'recipes_blog_sidebar_layout' ) ) {
	/**
	 * Get sidebar layout.
	 */
	function recipes_blog_sidebar_layout() {
		$recipes_blog_sidebar_position      = get_theme_mod( 'recipes_blog_sidebar_position', 'right-sidebar' );
		$recipes_blog_sidebar_position_post = get_theme_mod( 'recipes_blog_post_sidebar_position', 'right-sidebar' );
		$recipes_blog_sidebar_position_page = get_theme_mod( 'recipes_blog_page_sidebar_position', 'right-sidebar' );

		if ( is_single() ) {
			$recipes_blog_sidebar_position = $recipes_blog_sidebar_position_post;
		} elseif ( is_page() ) {
			$recipes_blog_sidebar_position = $recipes_blog_sidebar_position_page;
		}

		return $recipes_blog_sidebar_position;
	}
}

if ( ! function_exists( 'recipes_blog_is_sidebar_enabled' ) ) {
	/**
	 * Check if sidebar is enabled.
	 */
	function recipes_blog_is_sidebar_enabled() {
		$recipes_blog_sidebar_position      = get_theme_mod( 'recipes_blog_sidebar_position', 'right-sidebar' );
		$recipes_blog_sidebar_position_post = get_theme_mod( 'recipes_blog_post_sidebar_position', 'right-sidebar' );
		$recipes_blog_sidebar_position_page = get_theme_mod( 'recipes_blog_page_sidebar_position', 'right-sidebar' );

		$recipes_blog_sidebar_enabled = true;
		if ( is_home() || is_archive() || is_search() ) {
			if ( 'no-sidebar' === $recipes_blog_sidebar_position ) {
				$recipes_blog_sidebar_enabled = false;
			}
		} elseif ( is_single() ) {
			if ( 'no-sidebar' === $recipes_blog_sidebar_position || 'no-sidebar' === $recipes_blog_sidebar_position_post ) {
				$recipes_blog_sidebar_enabled = false;
			}
		} elseif ( is_page() ) {
			if ( 'no-sidebar' === $recipes_blog_sidebar_position || 'no-sidebar' === $recipes_blog_sidebar_position_page ) {
				$recipes_blog_sidebar_enabled = false;
			}
		}
		return $recipes_blog_sidebar_enabled;
	}
}

if ( ! function_exists( 'recipes_blog_get_homepage_sections ' ) ) {
	/**
	 * Returns homepage sections.
	 */
	function recipes_blog_get_homepage_sections() {
		$recipes_blog_sections = array(
			'banner'  => esc_html__( 'Banner Section', 'recipes-blog' ),
			'menus-section' => esc_html__( 'Menus Section', 'recipes-blog' ),
		);
		return $recipes_blog_sections;
	}
}

/**
 * Renders customizer section link
 */
function recipes_blog_section_link( $recipes_blog_section_id ) {
	$recipes_blog_section_name      = str_replace( 'recipes_blog_', ' ', $recipes_blog_section_id );
	$recipes_blog_section_name      = str_replace( '_', ' ', $recipes_blog_section_name );
	$recipes_blog_starting_notation = '#';
	?>
	<span class="section-link">
		<span class="section-link-title"><?php echo esc_html( $recipes_blog_section_name ); ?></span>
	</span>
	<style type="text/css">
		<?php echo $recipes_blog_starting_notation . $recipes_blog_section_id; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>:hover .section-link {
			visibility: visible;
		}
	</style>
	<?php
}

/**
 * Adds customizer section link css
 */
function recipes_blog_section_link_css() {
	if ( is_customize_preview() ) {
		?>
		<style type="text/css">
			.section-link {
				visibility: hidden;
				background-color: black;
				position: relative;
				top: 80px;
				z-index: 99;
				left: 40px;
				color: #fff;
				text-align: center;
				font-size: 20px;
				border-radius: 10px;
				padding: 20px 10px;
				text-transform: capitalize;
			}

			.section-link-title {
				padding: 0 10px;
			}

			.banner-section {
				position: relative;
			}

			.banner-section .section-link {
				position: absolute;
				top: 100px;
			}
		</style>
		<?php
	}
}
add_action( 'wp_head', 'recipes_blog_section_link_css' );

/**
 * Breadcrumb.
 */
function recipes_blog_breadcrumb( $recipes_blog_args = array() ) {
	if ( ! get_theme_mod( 'recipes_blog_enable_breadcrumb', true ) ) {
		return;
	}

	$recipes_blog_args = array(
		'show_on_front' => false,
		'show_title'    => true,
		'show_browse'   => false,
	);
	breadcrumb_trail( $recipes_blog_args );
}
add_action( 'recipes_blog_breadcrumb', 'recipes_blog_breadcrumb', 10 );

/**
 * Add separator for breadcrumb trail.
 */
function recipes_blog_breadcrumb_trail_print_styles() {
	$recipes_blog_breadcrumb_separator = get_theme_mod( 'recipes_blog_breadcrumb_separator', '/' );

	$recipes_blog_style = '
		.trail-items li::after {
			content: "' . $recipes_blog_breadcrumb_separator . '";
		}'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

	$recipes_blog_style = apply_filters( 'recipes_blog_breadcrumb_trail_inline_style', trim( str_replace( array( "\r", "\n", "\t", '  ' ), '', $recipes_blog_style ) ) );

	if ( $recipes_blog_style ) {
		echo "\n" . '<style type="text/css" id="breadcrumb-trail-css">' . $recipes_blog_style . '</style>' . "\n"; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}
}
add_action( 'wp_head', 'recipes_blog_breadcrumb_trail_print_styles' );

/**
 * Pagination for archive.
 */
function recipes_blog_render_posts_pagination() {
	$recipes_blog_is_pagination_enabled = get_theme_mod( 'recipes_blog_enable_pagination', true );
	if ( $recipes_blog_is_pagination_enabled ) {
		$recipes_blog_pagination_type = get_theme_mod( 'recipes_blog_pagination_type', 'default' );
		if ( 'default' === $recipes_blog_pagination_type ) :
			the_posts_navigation();
		else :
			the_posts_pagination();
		endif;
	}
}
add_action( 'recipes_blog_posts_pagination', 'recipes_blog_render_posts_pagination', 10 );

/**
 * Pagination for single post.
 */
function recipes_blog_render_post_navigation() {
	the_post_navigation(
		array(
			'prev_text' => '<span>&#10229;</span> <span class="nav-title">%title</span>',
			'next_text' => '<span class="nav-title">%title</span> <span>&#10230;</span>',
		)
	);
}
add_action( 'recipes_blog_post_navigation', 'recipes_blog_render_post_navigation' );

/**
 * Adds footer copyright text.
 */

function recipes_blog_output_footer_copyright_content() {
    $recipes_blog_theme_data = wp_get_theme();
    $recipes_blog_copyright_text = get_theme_mod('recipes_blog_footer_copyright_text');

    if (!empty($recipes_blog_copyright_text)) {
        $recipes_blog_text = $recipes_blog_copyright_text;
    } else {
        $recipes_blog_default_text = '<a href="'. esc_url(__('https://www.asterthemes.com/products/free-recipes-wordpress-theme','recipes-blog')) . '" target="_blank"> ' . esc_html($recipes_blog_theme_data->get('Name')) . '</a>' . '&nbsp;' . esc_html__('by', 'recipes-blog') . '&nbsp;<a target="_blank" href="' . esc_url($recipes_blog_theme_data->get('AuthorURI')) . '">' . esc_html(ucwords($recipes_blog_theme_data->get('Author'))) . '</a>';
        /* translators: %s: WordPress.org URL */
		$recipes_blog_default_text .= sprintf(esc_html__(' | Powered by %s', 'recipes-blog'), '<a href="' . esc_url(__('https://wordpress.org/', 'recipes-blog')) . '" target="_blank">WordPress</a>. ');

        $recipes_blog_text = $recipes_blog_default_text;
    }
    ?>
    <span><?php echo wp_kses_post($recipes_blog_text); ?></span>
    <?php
}
add_action('recipes_blog_footer_copyright', 'recipes_blog_output_footer_copyright_content');

/* Footer Social Icons */ 
function recipes_blog_footer_social_links() {

    if ( get_theme_mod('recipes_blog_enable_footer_icon_section', true) ) {

            ?>
            <div class="socialicons">
				<div class="asterthemes-wrapper">
					<?php if ( get_theme_mod('recipes_blog_footer_facebook_link', 'https://www.facebook.com/') != '' ) { ?>
						<a target="_blank" href="<?php echo esc_url(get_theme_mod('recipes_blog_footer_facebook_link', 'https://www.facebook.com/')); ?>">
							<i class="<?php echo esc_attr(get_theme_mod('recipes_blog_facebook_icon', 'fab fa-facebook-f')); ?>"></i>
							<span class="screen-reader-text"><?php esc_html_e('Facebook', 'recipes-blog'); ?></span>
						</a>
					<?php } ?>
					<?php if ( get_theme_mod('recipes_blog_footer_twitter_link', 'https://x.com/') != '' ) { ?>
						<a target="_blank" href="<?php echo esc_url(get_theme_mod('recipes_blog_footer_twitter_link', 'https://x.com/')); ?>">
							<i class="<?php echo esc_attr(get_theme_mod('recipes_blog_twitter_icon', 'fab fa-twitter')); ?>"></i>
							<span class="screen-reader-text"><?php esc_html_e('Twitter', 'recipes-blog'); ?></span>
						</a>
					<?php } ?>
					<?php if ( get_theme_mod('recipes_blog_footer_instagram_link', 'https://www.instagram.com/') != '' ) { ?>
						<a target="_blank" href="<?php echo esc_url(get_theme_mod('recipes_blog_footer_instagram_link', 'https://www.instagram.com/')); ?>">
							<i class="<?php echo esc_attr(get_theme_mod('recipes_blog_instagram_icon', 'fab fa-instagram')); ?>"></i>
							<span class="screen-reader-text"><?php esc_html_e('Instagram', 'recipes-blog'); ?></span>
						</a>
					<?php } ?>
					<?php if ( get_theme_mod('recipes_blog_footer_linkedin_link', 'https://in.linkedin.com/') != '' ) { ?>
						<a target="_blank" href="<?php echo esc_url(get_theme_mod('recipes_blog_footer_linkedin_link', 'https://in.linkedin.com/')); ?>">
							<i class="<?php echo esc_attr(get_theme_mod('recipes_blog_linkedin_icon', 'fab fa-linkedin')); ?>"></i>
							<span class="screen-reader-text"><?php esc_html_e('Linkedin', 'recipes-blog'); ?></span>
						</a>
					<?php } ?>
					<?php if ( get_theme_mod('recipes_blog_footer_youtube_link', 'https://www.youtube.com/') != '' ) { ?>
						<a target="_blank" href="<?php echo esc_url(get_theme_mod('recipes_blog_footer_youtube_link', 'https://www.youtube.com/')); ?>">
							<i class="<?php echo esc_attr(get_theme_mod('recipes_blog_youtube_icon', 'fab fa-youtube')); ?>"></i>
							<span class="screen-reader-text"><?php esc_html_e('Youtube', 'recipes-blog'); ?></span>
						</a>
					<?php } ?>
				</div>
            </div>
            <?php
    }
}
add_action('wp_footer', 'recipes_blog_footer_social_links');

/**
 * GET START FUNCTION
 */

function recipes_blog_getpage_css($hook) {
	wp_enqueue_script( 'recipes-blog-admin-script', get_template_directory_uri() . '/resource/js/recipes-blog-admin-notice-script.js', array( 'jquery' ) );
    wp_localize_script( 'recipes-blog-admin-script', 'recipes_blog_ajax_object',
        array( 'ajax_url' => admin_url( 'admin-ajax.php' ) )
    );
    wp_enqueue_style( 'recipes-blog-notice-style', get_template_directory_uri() . '/resource/css/notice.css' );
}

add_action( 'admin_enqueue_scripts', 'recipes_blog_getpage_css' );


add_action('wp_ajax_recipes_blog_dismissable_notice', 'recipes_blog_dismissable_notice');
function recipes_blog_switch_theme() {
    delete_user_meta(get_current_user_id(), 'recipes_blog_dismissable_notice');
}
add_action('after_switch_theme', 'recipes_blog_switch_theme');
function recipes_blog_dismissable_notice() {
    update_user_meta(get_current_user_id(), 'recipes_blog_dismissable_notice', true);
    die();
}

function recipes_blog_deprecated_hook_admin_notice() {

    $recipes_blog_dismissed = get_user_meta(get_current_user_id(), 'recipes_blog_dismissable_notice', true);
    if ( !$recipes_blog_dismissed) { ?>
        <div class="getstrat updated notice notice-success is-dismissible notice-get-started-class">
	    	
	    	<div class="at-admin-content" ><h2><?php esc_html_e('Welcome to Recipes Blog', 'recipes-blog'); ?></h2>
                <p><?php _e('Explore the features of our Pro Theme and take your recipes journey to the next level.', 'recipes-blog'); ?></p>
                <p ><?php _e('Get Started With Theme By Clicking On Getting Started.', 'recipes-blog'); ?><p>
                <div style="display: flex; justify-content: center; align-items:center; flex-wrap: wrap; gap: 5px">
	        		<a class="admin-notice-btn button button-primary button-hero" href="<?php echo esc_url( admin_url( 'themes.php?page=recipes-blog-getting-started' )); ?>"><?php esc_html_e( 'Get started', 'recipes-blog' ) ?></a>
                    <a  class="admin-notice-btn button button-primary button-hero" target="_blank" href="https://demo.asterthemes.com/recipes-blog"><?php esc_html_e('View Demo', 'recipes-blog') ?></a>
					<a  class="admin-notice-btn button button-primary button-hero" target="_blank" href="https://www.asterthemes.com/products/recipes-bloggers-wordpress-theme"><?php esc_html_e('Buy Now', 'recipes-blog') ?></a>
                    <a  class="admin-notice-btn button button-primary button-hero" target="_blank" href="<?php echo esc_url( RECIPES_BLOG_BUNDLE_PAGE ); ?>"><?php esc_html_e('Get Bundle', 'recipes-blog') ?></a>
                </div>
            </div>
            <div class="at-admin-image">
	    		<img style="width: 100%;max-width: 320px;line-height: 40px;display: inline-block;vertical-align: top;border: 2px solid #ddd;border-radius: 4px;" src="<?php echo esc_url(get_stylesheet_directory_uri()) .'/screenshot.png'; ?>" />
	    	</div>
        </div>
    <?php }
}

add_action( 'admin_notices', 'recipes_blog_deprecated_hook_admin_notice' );


//Admin Notice For Getstart
function recipes_blog_ajax_notice_handler() {
    if ( isset( $_POST['type'] ) ) {
        $type = sanitize_text_field( wp_unslash( $_POST['type'] ) );
        update_option( 'dismissed-' . $type, TRUE );
    }
}

if ( ! function_exists( 'recipes_blog_footer_widget' ) ) :
	function recipes_blog_footer_widget() {
		$recipes_blog_footer_widget_column = get_theme_mod('recipes_blog_footer_widget_column','4');

		$recipes_blog_column_class = '';
		if ($recipes_blog_footer_widget_column == '1') {
			$recipes_blog_column_class = 'one-column';
		} elseif ($recipes_blog_footer_widget_column == '2') {
			$recipes_blog_column_class = 'two-columns';
		} elseif ($recipes_blog_footer_widget_column == '3') {
			$recipes_blog_column_class = 'three-columns';
		} else {
			$recipes_blog_column_class = 'four-columns';
		}
	
		if($recipes_blog_footer_widget_column !== ''): 
		?>
		<div class="dt_footer-widgets <?php echo esc_attr($recipes_blog_column_class); ?> wow bounceInUp delay-1000" data-wow-duration="2s">
			<div class="footer-widgets-column">
				<?php
				$footer_widgets_active = false;

				// Loop to check if any footer widget is active
				for ($i = 1; $i <= $recipes_blog_footer_widget_column; $i++) {
					if (is_active_sidebar('recipes-blog-footer-widget-' . $i)) {
						$footer_widgets_active = true;
						break;
					}
				}

				if ($footer_widgets_active) {
					// Display active footer widgets
					for ($i = 1; $i <= $recipes_blog_footer_widget_column; $i++) {
						if (is_active_sidebar('recipes-blog-footer-widget-' . $i)) : ?>
							<div class="footer-one-column">
								<?php dynamic_sidebar('recipes-blog-footer-widget-' . $i); ?>
							</div>
						<?php endif;
					}
				} else {
				?>
				<div class="footer-one-column default-widgets">
					<aside id="search-2" class="widget widget_search default_footer_search">
						<div class="widget-header">
							<h4 class="widget-title"><?php esc_html_e('Search Here', 'recipes-blog'); ?></h4>
						</div>
						<?php get_search_form(); ?>
					</aside>
				</div>
				<div class="footer-one-column default-widgets">
					<aside id="recent-posts-2" class="widget widget_recent_entries">
						<h2 class="widget-title"><?php esc_html_e('Recent Posts', 'recipes-blog'); ?></h2>
						<ul>
							<?php
							$recent_posts = wp_get_recent_posts(array(
								'numberposts' => 5,
								'post_status' => 'publish',
							));
							foreach ($recent_posts as $post) {
								echo '<li><a href="' . esc_url(get_permalink($post['ID'])) . '">' . esc_html($post['post_title']) . '</a></li>';
							}
							wp_reset_query();
							?>
						</ul>
					</aside>
				</div>
				<div class="footer-one-column default-widgets">
					<aside id="recent-comments-2" class="widget widget_recent_comments">
						<h2 class="widget-title"><?php esc_html_e('Recent Comments', 'recipes-blog'); ?></h2>
						<ul>
							<?php
							$recent_comments = get_comments(array(
								'number' => 5,
								'status' => 'approve',
							));
							foreach ($recent_comments as $comment) {
								echo '<li><a href="' . esc_url(get_comment_link($comment)) . '">' .
									/* translators: %s: details. */
									sprintf(esc_html__('Comment on %s', 'recipes-blog'), get_the_title($comment->comment_post_ID)) .
									'</a></li>';
							}
							?>
						</ul>
					</aside>
				</div>
				<div class="footer-one-column default-widgets">
					<aside id="calendar-2" class="widget widget_calendar">
						<h2 class="widget-title"><?php esc_html_e('Calendar', 'recipes-blog'); ?></h2>
						<?php get_calendar(); ?>
					</aside>
				</div>
			</div>
			<?php } ?>
		</div>
		<?php
		endif;
	}
	endif;
add_action( 'recipes_blog_footer_widget', 'recipes_blog_footer_widget' );

function recipes_blog_footer_text_transform_css() {
    $recipes_blog_footer_text_transform = get_theme_mod('footer_text_transform', 'none');
    ?>
    <style type="text/css">
        .site-footer h4,footer#colophon h2.wp-block-heading,footer#colophon .widgettitle,footer#colophon .widget-title {
            text-transform: <?php echo esc_html($recipes_blog_footer_text_transform); ?>;
        }
    </style>
    <?php
}
add_action('wp_head', 'recipes_blog_footer_text_transform_css');