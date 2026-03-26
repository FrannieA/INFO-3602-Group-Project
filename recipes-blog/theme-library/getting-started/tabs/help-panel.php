<?php
/**
 * Help Panel.
 *
 * @package recipes_blog
 */
?>

<div id="help-panel" class="panel-left visible">
    <div id="#help-panel" class="steps">  
        <h4 class="c">
            <?php esc_html_e( 'Quick Setup for Home Page', 'recipes-blog' ); ?>
            <a href="<?php echo esc_url( RECIPES_BLOG_THEME_DOCUMENTATION ); ?>" class="button button-primary" style="margin-left: 5px; margin-right: 10px;" target="_blank"><?php esc_html_e( 'Free Theme Documentation', 'recipes-blog' ); ?></a>
        </h4>
        <hr class="quick-set">
        <p><?php esc_html_e( '1) Go to the dashboard. navigate to pages, add a new one, and label it "home" or whatever else you like.The page has now been created.', 'recipes-blog' ); ?></p>
        <p><?php esc_html_e( '2) Go back to the dashboard and then select Settings.', 'recipes-blog' ); ?></p>
        <p><?php esc_html_e( '3) Then Go to readings in the setting.', 'recipes-blog' ); ?></p>
        <p><?php esc_html_e( '4) There are 2 options your latest post or static page.', 'recipes-blog' ); ?></p>
        <p><?php esc_html_e( '5) Select static page and select from the dropdown you wish to use as your home page, save changes.', 'recipes-blog' ); ?></p>
        <p><?php esc_html_e( '6) You can set the home page in this manner.', 'recipes-blog' ); ?></p>
        <br>
        <h4><?php esc_html_e( 'Setup Banner Section', 'recipes-blog' ); ?></h4>
        <hr class="quick-set">
         <p><?php esc_html_e( '1) Go to Appereance > then Go to Customizer.', 'recipes-blog' ); ?></p>
         <p><?php esc_html_e( '2) In Customizer > Go to Front Page Options > Go to Banner Section.', 'recipes-blog' ); ?></p>
         <p><?php esc_html_e( '3) For Setup Banner Section you have to create post in dashboard first.', 'recipes-blog' ); ?></p>
         <p><?php esc_html_e( '4) In Banner Section > Enable the Toggle button > and fill the following details.', 'recipes-blog' ); ?></p>
         <p><?php esc_html_e( '5) In this way you can set Banner Section.', 'recipes-blog' ); ?></p>
        <br>
        <h4><?php esc_html_e( 'Setup Services Section', 'recipes-blog' ); ?></h4>
        <hr class="quick-set">
         <p><?php esc_html_e( '1) Go to Post > add new post and add category which you want.', 'recipes-blog' ); ?></p>
         <p><?php esc_html_e( '2) Go to Customizer > Go to Front Page Options > Go to Menus Section.', 'recipes-blog' ); ?></p>
         <p><?php esc_html_e( '4) In Menus Section > Enable the Toggle button and give heading and select category which you want.', 'recipes-blog' ); ?></p>
         <p><?php esc_html_e( '5) In this way you can set Menus Section.', 'recipes-blog' ); ?></p> 
        <br>
    </div>
    <div class="custom-setting">
        <h4><?php esc_html_e( 'Quick Customizer Settings', 'recipes-blog' ); ?></h4>
        <span><a href="<?php echo esc_url( admin_url( 'customize.php' ) ); ?>" target="_blank" class=""><?php esc_html_e( 'Customize', 'recipes-blog' ); ?></a></span>
    </div>
    <hr>
   <div class="setting-box">
        <div class="custom-links">
            <div class="icon-box">
                <img src="<?php echo esc_url(get_template_directory_uri()) .'/theme-library/getting-started/images/img1.png'; ?>" />
            </div>
            <h5><?php esc_html_e( 'Site Logo', 'recipes-blog' ); ?></h5>
            <a href="<?php echo esc_url( admin_url( 'customize.php?autofocus[control]=custom_logo' ) ); ?>" target="_blank" class=""><?php esc_html_e( 'Customize', 'recipes-blog' ); ?></a>
            
        </div>
        <div class="custom-links">
            <div class="icon-box">
                <img src="<?php echo esc_url(get_template_directory_uri()) .'/theme-library/getting-started/images/img2.png'; ?>" />
            </div>
            <h5><?php esc_html_e( 'Color Picker', 'recipes-blog' ); ?></h5>
            <a href="<?php echo esc_url( admin_url( 'customize.php?autofocus[control]=recipes_blog_primary_color' ) ); ?>" target="_blank" class=""><?php esc_html_e( 'Customize', 'recipes-blog' ); ?></a>
            
        </div>
        <div class="custom-links">
            <div class="icon-box">
                <img src="<?php echo esc_url(get_template_directory_uri()) .'/theme-library/getting-started/images/img3.png'; ?>" />
            </div>
            <h5><?php esc_html_e( 'Theme Options', 'recipes-blog' ); ?></h5>
            <a href="<?php echo esc_url( admin_url( 'customize.php?autofocus[panel]=recipes_blog_theme_options' ) ); ?>"target="_blank" class=""><?php esc_html_e( 'Customize', 'recipes-blog' ); ?></a>
            
        </div>
    </div>
    <div class="setting-box">
        <div class="custom-links">
            <div class="icon-box">
                <img src="<?php echo esc_url(get_template_directory_uri()) .'/theme-library/getting-started/images/img4.png'; ?>" />
            </div>
            <h5><?php esc_html_e( 'Header Image ', 'recipes-blog' ); ?></h5>
            <a href="<?php echo esc_url( admin_url( 'customize.php?autofocus[control]=header_image' ) ); ?>" target="_blank" class=""><?php esc_html_e( 'Customize', 'recipes-blog' ); ?></a>
            
        </div>
        <div class="custom-links">
            <div class="icon-box">
                <img src="<?php echo esc_url(get_template_directory_uri()) .'/theme-library/getting-started/images/img5.png'; ?>" />
            </div>
            <h5><?php esc_html_e( 'Footer Option ', 'recipes-blog' ); ?></h5>
            <a href="<?php echo esc_url( admin_url( 'customize.php?autofocus[control]=recipes_blog_footer_copyright_text' ) ); ?>" target="_blank" class=""><?php esc_html_e( 'Customize', 'recipes-blog' ); ?></a>
            
        </div>
        <div class="custom-links">
            <div class="icon-box">
                <img src="<?php echo esc_url(get_template_directory_uri()) .'/theme-library/getting-started/images/img6.png'; ?>" />
            </div>
            <h5><?php esc_html_e( 'Front Page Option', 'recipes-blog' ); ?></h5>
            <a href="<?php echo esc_url( admin_url( 'customize.php?autofocus[panel]=recipes_blog_front_page_options' ) ); ?>" target="_blank" class=""><?php esc_html_e( 'Customize', 'recipes-blog' ); ?></a>
            
        </div>
    </div>
</div>