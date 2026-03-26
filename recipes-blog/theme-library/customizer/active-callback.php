<?php

/**
 * Active Callbacks
 *
 * @package recipes_blog
 */

// Theme Options.
function recipes_blog_is_pagination_enabled( $recipes_blog_control ) {
	return ( $recipes_blog_control->manager->get_setting( 'recipes_blog_enable_pagination' )->value() );
}
function recipes_blog_is_breadcrumb_enabled( $recipes_blog_control ) {
	return ( $recipes_blog_control->manager->get_setting( 'recipes_blog_enable_breadcrumb' )->value() );
}
function recipes_blog_is_layout_enabled( $recipes_blog_control ) {
	return ( $recipes_blog_control->manager->get_setting( 'recipes_blog_website_layout' )->value() );
}
function recipes_blog_is_pagetitle_bcakground_image_enabled( $recipes_blog_control ) {
	return ( $recipes_blog_control->manager->get_setting( 'recipes_blog_page_header_style' )->value() );
}
function recipes_blog_is_preloader_style( $recipes_blog_control ) {
	return ( $recipes_blog_control->manager->get_setting( 'recipes_blog_enable_preloader' )->value() );
}

// Header Options.
function recipes_blog_is_topbar_enabled( $recipes_blog_control ) {
	return ( $recipes_blog_control->manager->get_Setting( 'recipes_blog_enable_topbar' )->value() );
}

// Banner Slider Section.
function recipes_blog_is_banner_slider_section_enabled( $recipes_blog_control ) {
	return ( $recipes_blog_control->manager->get_setting( 'recipes_blog_enable_banner_section' )->value() );
}
function recipes_blog_is_banner_slider_section_and_content_type_post_enabled( $recipes_blog_control ) {
	$content_type = $recipes_blog_control->manager->get_setting( 'recipes_blog_banner_slider_content_type' )->value();
	return ( recipes_blog_is_banner_slider_section_enabled( $recipes_blog_control ) && ( 'post' === $content_type ) );
}
function recipes_blog_is_banner_slider_section_and_content_type_page_enabled( $recipes_blog_control ) {
	$content_type = $recipes_blog_control->manager->get_setting( 'recipes_blog_banner_slider_content_type' )->value();
	return ( recipes_blog_is_banner_slider_section_enabled( $recipes_blog_control ) && ( 'page' === $content_type ) );
}

// Product section.
function recipes_blog_is_menus_section_enabled( $recipes_blog_control ) {
	return ( $recipes_blog_control->manager->get_setting( 'recipes_blog_enable_menus_section' )->value() );
}