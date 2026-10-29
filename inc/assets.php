<?php
/**
 * Styles and scripts (built by gulp).
 */

defined( 'ABSPATH' ) || exit;

add_action( 'wp_enqueue_scripts', function () {
	wp_enqueue_style( 'rainshade', get_stylesheet_uri(), [], rainshade_ver( 'style.css' ) );
} );

add_action( 'init', function () {
	wp_register_script(
		'rainshade-water',
		get_theme_file_uri( 'assets/js/scripts.min.js' ),
		[],
		rainshade_ver( 'assets/js/scripts.min.js' ),
		[ 'strategy' => 'defer', 'in_footer' => true ]
	);
} );

// Default photos for editor previews of blocks without a picked photo.
add_action( 'enqueue_block_editor_assets', function () {
	wp_add_inline_script(
		'wp-blocks',
		'window.rainshadeTheme = ' . wp_json_encode( [ 'images' => get_theme_file_uri( 'assets/images/' ) ] ) . ';',
		'before'
	);
} );
