<?php
/**
* Wizard
* @package Whizzie
* @since 1.0.0
*/

class Whizzie {
	protected $version = '1.1.0';
	protected $theme_name = '';
	protected $theme_title = '';
	protected $page_slug = '';
	protected $page_title = '';
	protected $config_steps = array();
	public $parent_slug;
	/**
	 * Constructor
	 * @param $config Configuration parameters
	 */
	public function __construct( $config ) {
		$this->set_vars( $config );
		$this->init();
	}

	/**
	 * Set variables based on configuration
	 * @param $config Configuration parameters
	 */
	public function set_vars( $config ) {
		if ( isset( $config['page_slug'] ) ) {
			$this->page_slug = esc_attr( $config['page_slug'] );
		}
		if ( isset( $config['page_title'] ) ) {
			$this->page_title = esc_attr( $config['page_title'] );
		}
		if ( isset( $config['steps'] ) ) {
			$this->config_steps = $config['steps'];
		}

		$current_theme = wp_get_theme();
		$this->theme_title = $current_theme->get( 'Name' );
		$this->theme_name = strtolower( preg_replace( '#[^a-zA-Z]#', '', $current_theme->get( 'Name' ) ) );
		$this->page_slug = apply_filters( $this->theme_name . '_theme_setup_wizard_page_slug', $this->theme_name . '-wizard' );
		$this->parent_slug = apply_filters( $this->theme_name . '_theme_setup_wizard_parent_slug', '' );
	}

	/*** Initialize hooks and actions ***/
	public function init() {
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
		add_action( 'admin_menu', array( $this, 'menu_page' ) );
		add_action( 'wp_ajax_setup_widgets', array( $this, 'setup_widgets' ) );
	}
	
	public function enqueue_scripts() {
		wp_enqueue_style( 'theme-wizard-style', get_template_directory_uri() . '/theme-wizard/assets/css/theme-wizard-style.css');
		wp_register_script( 'theme-wizard-script', get_template_directory_uri() . '/theme-wizard/assets/js/theme-wizard-script.js', array( 'jquery' ));
		wp_localize_script(
			'theme-wizard-script',
			'recipes_blog_whizzie_params',
			array(
				'ajaxurl' => admin_url( 'admin-ajax.php' ),
				'verify_text' => esc_html( 'verifying', 'recipes-blog' )
			)
		);
		wp_enqueue_script( 'theme-wizard-script' );
	}

	public function menu_page() {
		add_theme_page( esc_html( $this->page_title ), esc_html( $this->page_title ), 'manage_options', $this->page_slug, array( $this, 'recipes_blog_setup_wizard' ) );
	}

	/*** Display the wizard page content ***/
	public function wizard_page() { ?>
		<div class="main-wrap">
			<div class="card whizzie-wrap">
				<ul class="whizzie-menu">
					<?php foreach ( $this->get_steps() as $step ) : ?>
						<li data-step="<?php echo esc_attr( $step['id'] ); ?>" class="step step-<?php echo esc_attr( $step['id'] ); ?>">

							<h2><?php echo esc_html( $step['title'] ); ?></h2>

							<?php
							$content = call_user_func( array( $this, $step['view'] ) );
							?>

							<?php if ( isset( $content['summary'] ) ) : ?>
								<div class="summary">
									<?php echo wp_kses_post( $content['summary'] ); ?>
								</div>
							<?php endif; ?>

							<?php if ( isset( $content['detail'] ) ) : ?>
								<p>
									<a href="#" class="more-info">
										<?php esc_html_e( 'More Info', 'recipes-blog' ); ?>
									</a>
								</p>
								<div class="detail">
									<?php echo wp_kses_post( $content['detail'] ); ?>
								</div>
							<?php endif; ?>

							<?php if ( ! empty( $step['button_text'] ) ) : ?>
								<div class="button-wrap">

									<?php if ( ! get_option( 'is-demo-imported' ) ) : ?>

										<a href="#"
										class="button button-primary do-it"
										data-callback="<?php echo esc_attr( $step['callback'] ); ?>"
										data-step="<?php echo esc_attr( $step['id'] ); ?>">
											<?php echo esc_html( $step['button_text'] ); ?>
										</a>

									<?php else : ?>

										<a target="_blank"
										href="<?php echo esc_url( home_url() ); ?>"
										class="button button-primary"
										style="font-size:20px;font-weight:600;">
											<?php esc_html_e( 'Visit Site', 'recipes-blog' ); ?>
										</a>

									<?php endif; ?>

								</div>
							<?php endif; ?>

						</li>
					<?php endforeach; ?>
				</ul>
				<div class="step-loading">
					<span class="spinner"></span>
				</div>
			</div>
		</div>
	<?php }

	/*** Setup wizard page content and options ***/
	public function recipes_blog_setup_wizard() { ?>
		<div class="wrapper-info get-stared-page-wrap">
			<div class="tab-sec theme-option-tab">
				<div id="demo_offer" class="tabcontent">
					<?php $this->wizard_page(); ?>
				</div>
			</div>
		</div>
	<?php }

	/**
	 * Get the steps for the wizard
	 * @return array
	 */
	public function get_steps() {
		$steps = array(
			'intro' => array(
				'id' => 'intro',
				'title' => __( 'Welcome to ', 'recipes-blog' ) . $this->theme_title,
				'view' => 'get_step_intro',
				'callback' => 'do_next_step',
				'button_text' => __( 'Start Now', 'recipes-blog' ),
				'can_skip' => false
			),
			'widgets' => array(
				'id' => 'widgets',
				'title' => __( 'Demo Importer', 'recipes-blog' ),
				'view' => 'get_step_widgets',
				'callback' => 'install_widgets',
				'button_text' => __( 'Import Demo', 'recipes-blog' ),
				'can_skip' => true
			),
			'done' => array(
				'id' => 'done',
				'title' => __( 'All Done', 'recipes-blog' ),
				'view' => 'get_step_done'
			)
		);

		return $steps;
	}

	/*** Display the content for the intro step ***/
	public function get_step_intro() { ?>
		<div class="summary">
			<p style="text-align: center;"><?php esc_html_e( 'Thank you for choosing our theme! We are excited to help you get started with your new website.', 'recipes-blog' ); ?></p>
			<p style="text-align: center;"><?php esc_html_e( 'This section will guide you through setting up and customizing the theme. You can follow the steps to import demo content or adjust settings at any time to make the website look and work the way you want.', 'recipes-blog' ); ?></p>
		</div>
	<?php }

	/*** Display the content for the widgets step ***/
	public function get_step_widgets() { ?>
		<div class="summary">
			<p><?php esc_html_e('To get started, use the button below to import demo content and add widgets to your site. After installation, you can manage settings and customize your site using the Customizer. Enjoy your new theme!', 'recipes-blog'); ?></p>
		</div>
	<?php }

	/*** Display the content for the final step ***/
	public function get_step_done() { ?>
		<div id="aster-demo-setup-guid">
			<div class="aster-setup-menu">
				<h3><?php esc_html_e('Setup Navigation Menu','recipes-blog'); ?></h3>
				<p><?php esc_html_e('Follow the following Steps to Setup Menu','recipes-blog'); ?></p>
				<h4><?php esc_html_e('A) Create Pages','recipes-blog'); ?></h4>
				<ol>
					<li><?php esc_html_e('Go to Dashboard >> Pages >> Add New','recipes-blog'); ?></li>
					<li><?php esc_html_e('Enter Page Details And Save Changes','recipes-blog'); ?></li>
				</ol>
				<h4><?php esc_html_e('B) Add Pages To Menu','recipes-blog'); ?></h4>
				<ol>
					<li><?php esc_html_e('Go to Dashboard >> Appearance >> Menu','recipes-blog'); ?></li>
					<li><?php esc_html_e('Click On The Create Menu Option','recipes-blog'); ?></li>
					<li><?php esc_html_e('Select The Pages And Click On The Add to Menu Button','recipes-blog'); ?></li>
					<li><?php esc_html_e('Select Primary Menu From The Menu Setting','recipes-blog'); ?></li>
					<li><?php esc_html_e('Click On The Save Menu Button','recipes-blog'); ?></li>
				</ol>
			</div>
			<div class="aster-setup-widget">
				<h3><?php esc_html_e('Setup Footer Widgets','recipes-blog'); ?></h3>
				<p><?php esc_html_e('Follow the following Steps to Setup Footer Widgets','recipes-blog'); ?></p>
				<ol>
					<li><?php esc_html_e('Go to Dashboard >> Appearance >> Widgets','recipes-blog'); ?></li>
					<li><?php esc_html_e('Drag And Add The Widgets In The Footer Columns','recipes-blog'); ?></li>
				</ol>
			</div>
			<div style="display:flex; justify-content: center; margin-top: 20px; gap:20px">
				<div class="aster-setup-finish">
					<a target="_blank" href="<?php echo esc_url(home_url()); ?>" class="button button-primary">Visit Site</a>
				</div>
				<div class="aster-setup-finish">
					<a target="_blank" href="<?php echo esc_url( admin_url('customize.php') ); ?>" class="button button-primary">Customize Your Demo</a>
				</div>
				<div class="aster-setup-finish">
					<a target="_blank" href="<?php echo esc_url( admin_url('themes.php?page=recipes-blog-getting-started') ); ?>" class="button button-primary">Dashboard</a>
				</div>
			</div>
		</div>
	<?php }


	//                      ------------- MENUS -----------------                    //

	public function recipes_blog_customizer_primary_menu(){

		// ------- Create Primary Menu --------
		$recipes_blog_menuname = $recipes_blog_themename . 'Primary Menu';
		$recipes_blog_bpmenulocation = 'primary';
		$recipes_blog_menu_exists = wp_get_nav_menu_object( $recipes_blog_menuname );
 
		if( !$recipes_blog_menu_exists){
			$recipes_blog_menu_id = wp_create_nav_menu($recipes_blog_menuname);
			$recipes_blog_parent_item = 
			wp_update_nav_menu_item($recipes_blog_menu_id, 0, array(
				'menu-item-title' =>  __('Home','recipes-blog'),
				'menu-item-classes' => 'home',
				'menu-item-url' => home_url( '/' ),
				'menu-item-status' => 'publish'));

			wp_update_nav_menu_item($recipes_blog_menu_id, 0, array(
				'menu-item-title' =>  __('Vegetarian','recipes-blog'),
				'menu-item-classes' => 'vegetarian',
				'menu-item-url' => get_permalink(get_page_by_title('Vegetarian')),
				'menu-item-status' => 'publish'));

			wp_update_nav_menu_item($recipes_blog_menu_id, 0, array(
				'menu-item-title' =>  __('Non Vegetarian','recipes-blog'),
				'menu-item-classes' => 'non-vegetarian',
				'menu-item-url' => get_permalink(get_page_by_title('Non Vegetarian')),
				'menu-item-status' => 'publish'));

			wp_update_nav_menu_item($recipes_blog_menu_id, 0, array(
				'menu-item-title' =>  __('Blogs','recipes-blog'),
				'menu-item-classes' => 'blog',
				'menu-item-url' => get_permalink(get_page_by_title('Blogs')),
				'menu-item-status' => 'publish'));

			wp_update_nav_menu_item($recipes_blog_menu_id, 0, array(
				'menu-item-title' =>  __('About','recipes-blog'),
				'menu-item-classes' => 'about',
				'menu-item-url' => get_permalink(get_page_by_title('About')),
				'menu-item-status' => 'publish'));

			if( !has_nav_menu( $recipes_blog_bpmenulocation ) ){
				$locations = get_theme_mod('nav_menu_locations');
				$locations[$recipes_blog_bpmenulocation] = $recipes_blog_menu_id;
				set_theme_mod( 'nav_menu_locations', $locations );
			}
		}
	}


	//                      ------------- /*** Imports demo content ***/ -----------------                    //

	public function setup_widgets() {

		// Create a front page and assigned the template
		$recipes_blog_home_title = 'Home';
		$recipes_blog_home_check = get_page_by_title($recipes_blog_home_title);
		$recipes_blog_home = array(
			'post_type' => 'page',
			'post_title' => $recipes_blog_home_title,
			'post_status' => 'publish',
			'post_author' => 1,
			'post_slug' => 'home'
		);
		$recipes_blog_home_id = wp_insert_post($recipes_blog_home);

		//Set the static front page
		$recipes_blog_home = get_page_by_title( 'Home' );
		update_option( 'page_on_front', $recipes_blog_home->ID );
		update_option( 'show_on_front', 'page' );


		// Create a posts page and assigned the template
		$recipes_blog_blog_title = 'Blogs';
		$recipes_blog_blog = get_page_by_title($recipes_blog_blog_title);

		if (!$recipes_blog_blog) {
			$recipes_blog_blog = array(
				'post_type' => 'page',
				'post_title' => $recipes_blog_blog_title,
				'post_status' => 'publish',
				'post_author' => 1,
				'post_name' => 'blog'
			);
			$recipes_blog_blog_id = wp_insert_post($recipes_blog_blog);

			if (is_wp_error($recipes_blog_blog_id)) {
				// Handle error
			}
		} else {
			$recipes_blog_blog_id = $recipes_blog_blog->ID;
		}
		// Set the posts page
		update_option('page_for_posts', $recipes_blog_blog_id);

		
		// Create a about and assigned the template
		$recipes_blog_about_title = 'About';
		$recipes_blog_about_check = get_page_by_title($recipes_blog_about_title);
		$recipes_blog_about = array(
			'post_type' => 'page',
			'post_title' => $recipes_blog_about_title,
			'post_content' => '<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry standard dummy text ever since the 1500, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960 with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>',
			'post_status' => 'publish',
			'post_author' => 1,
			'post_slug' => 'blog'
		);
		$recipes_blog_about_id = wp_insert_post($recipes_blog_about);

		
		// Create a Non Vegetarian and assigned the template
		$recipes_blog_nonvegetarian_title = 'Non Vegetarian';
		$recipes_blog_nonvegetarian_check = get_page_by_title($recipes_blog_nonvegetarian_title);
		$recipes_blog_nonvegetarian = array(
			'post_type' => 'page',
			'post_title' => $recipes_blog_nonvegetarian_title,
			'post_content' => '<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry standard dummy text ever since the 1500, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960 with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>',
			'post_status' => 'publish',
			'post_author' => 1,
			'post_slug' => 'blog'
		);
		$recipes_blog_nonvegetarian_id = wp_insert_post($recipes_blog_nonvegetarian);

		
		// Create a Vegetarian and assigned the template
		$recipes_blog_vegetarian_title = 'Vegetarian';
		$recipes_blog_vegetarian_check = get_page_by_title($recipes_blog_vegetarian_title);
		$recipes_blog_vegetarian = array(
			'post_type' => 'page',
			'post_title' => $recipes_blog_vegetarian_title,
			'post_content' => '<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry standard dummy text ever since the 1500, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960 with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>',
			'post_status' => 'publish',
			'post_author' => 1,
			'post_slug' => 'blog'
		);
		$recipes_blog_vegetarian_id = wp_insert_post($recipes_blog_vegetarian);

		/*----------------------------------------- Header Button --------------------------------------------------*/

			set_theme_mod( 'recipes_blog_welcome_topbar_text','Subscribe to our Newsletter');
			

		// ------------------------------------------ Blogs for Sections --------------------------------------

			// Create categories if not already created
			$recipes_blog_category_banner = wp_create_category('Banner');
			$recipes_blog_category_menus = wp_create_category('Menus');

			// Array of categories to assign to each set of posts
			$recipes_blog_categories = array($recipes_blog_category_banner, $recipes_blog_category_menus);

			// Array of image URLs for the "menus" category
			$menus_images = array(
				get_template_directory_uri() . '/resource/img/menus1.png',
				get_template_directory_uri() . '/resource/img/menus2.png',
				get_template_directory_uri() . '/resource/img/menus3.png',
				get_template_directory_uri() . '/resource/img/menus4.png'
			);

			// Loop to create posts
			for ($i = 1; $i <= 7; $i++) { // Adjusted to 7 posts in total
				$title = array(
					'LET’S "Delight Your Taste Buds With Our Culinary Creations"',
					'LET’S "Eat Healthy & Hearty: Nutritious Recipes for Every Diet"',
					'LET’S "Explore Global Flavors: Cook Your Way Around the World"',
					'Spanish Salad',
					'Leafy Green Salad',
					'Cucumber Salad',
					'Fattoush Salad'
				);
			
				$content = 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry standard dummy text ever since.';
			
				// Determine category index (first 3 for Banner, next 4 for Menus)
				$category_index = ($i <= 3) ? 0 : 1; // 0 = Banner, 1 = Menus
				$post_title = $title[$i - 1]; // Adjust for zero-based index
			
				// Create post
				$my_post = array(
					'post_title'    => wp_strip_all_tags($post_title),
					'post_content'  => $content,
					'post_status'   => 'publish',
					'post_type'     => 'post',
					'post_category' => array($recipes_blog_categories[$category_index]), // Assign Banner to first 3, Menus to next 4
				);
			
				// Insert post
				$post_id = wp_insert_post($my_post);
			
				// Assign images
				if ($category_index === 0) { // Banner category
					$banner_images = array(
						get_template_directory_uri() . '/resource/img/banner1.png',
						get_template_directory_uri() . '/resource/img/banner2.png',
						get_template_directory_uri() . '/resource/img/banner3.png'
					);
					$recipes_blog_image_url = $banner_images[$i - 1]; // Assign unique banner image
				} else { // Menus category
					$menus_image_index = $i - 4; // Adjust index for menus images (4th post = index 0)
					$recipes_blog_image_url = $menus_images[$menus_image_index]; // Fetch image from menus array
				}
			
				$recipes_blog_image_name = basename($recipes_blog_image_url);
				$recipes_blog_upload_dir = wp_upload_dir();
				$recipes_blog_image_data = file_get_contents($recipes_blog_image_url);
				$recipes_blog_unique_file_name = wp_unique_filename($recipes_blog_upload_dir['path'], $recipes_blog_image_name);
				$filename = basename($recipes_blog_unique_file_name);
			
				if (wp_mkdir_p($recipes_blog_upload_dir['path'])) {
					$file = $recipes_blog_upload_dir['path'] . '/' . $filename;
				} else {
					$file = $recipes_blog_upload_dir['basedir'] . '/' . $filename;
				}
			
				if (!function_exists('WP_Filesystem')) {
					require_once ABSPATH . 'wp-admin/includes/file.php';
				}
			
				WP_Filesystem();
				global $wp_filesystem;
			
				if (!$wp_filesystem->put_contents($file, $recipes_blog_image_data, FS_CHMOD_FILE)) {
					wp_die('Error saving file!');
				}
			
				$wp_filetype = wp_check_filetype($filename, null);
				$attachment = array(
					'post_mime_type' => $wp_filetype['type'],
					'post_title'     => sanitize_file_name($filename),
					'post_content'   => '',
					'post_status'    => 'inherit'
				);
			
				$recipes_blog_attach_id = wp_insert_attachment($attachment, $file, $post_id);
			
				require_once ABSPATH . 'wp-admin/includes/image.php';
			
				$recipes_blog_attach_data = wp_generate_attachment_metadata($recipes_blog_attach_id, $file);
				wp_update_attachment_metadata($recipes_blog_attach_id, $recipes_blog_attach_data);
				set_post_thumbnail($post_id, $recipes_blog_attach_id);
			}			

		// ---------------------------------------- Banner --------------------------------------------------- //

			for($i=1; $i<=3; $i++) {
				set_theme_mod('recipes_blog_banner_button_label_'.$i,'Explore Now');
				set_theme_mod('recipes_blog_banner_button_link_'.$i,'#');
			}


		// ---------------------------------------- Menus --------------------------------------------------- //

			set_theme_mod('recipes_blog_heading_menus_section','MENUS');
			set_theme_mod('recipes_blog_menus_number','5');
			set_theme_mod('recipes_blog_enable_menus_section',true);
			
			$tab_names = array('Salad','Soup','Vegetarian food','Non-Vegetarian food','Desert');

			for ($i=1; $i<=5; $i++) {
				set_theme_mod('recipes_blog_menus_text'.$i,$tab_names[$i-1]);
			}
			
			set_theme_mod('recipes_blog_menus_category','Menus');

		// ---------------------------------------- Footer section --------------------------------------------------- //	
		
			set_theme_mod('recipes_blog_footer_background_color_setting','#000000');
			
		// ---------------------------------------- Related post_tag --------------------------------------------------- //	
		
			set_theme_mod('recipes_blog_post_related_post_label','Related Posts');
			set_theme_mod('recipes_blog_related_posts_count','3');


		$this->recipes_blog_customizer_primary_menu();
		update_option('is-demo-imported', true);
	}
}