<?php
/**
 * Theme supports and menus.
 */

defined( 'ABSPATH' ) || exit;

add_action( 'after_setup_theme', function () {
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'align-wide' );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'html5', [ 'search-form', 'gallery', 'caption', 'style', 'script' ] );
	add_theme_support( 'editor-styles' );
	add_editor_style( 'assets/admin/editor.css' );

	// Classic menus (Appearance → Menus) for the header and footer.
	register_nav_menus( [
		'primary' => __( 'Header', 'rainshade' ),
		'footer'  => __( 'Footer', 'rainshade' ),
	] );
} );
