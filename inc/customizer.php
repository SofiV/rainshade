<?php
/**
 * Colors in Appearance → Customize → Colors.
 *
 * The picked colors replace the theme.json palette, so the CSS presets
 * (--wp--preset--color--*), the block editor and every block follow them.
 */

defined( 'ABSPATH' ) || exit;

/**
 * Palette from theme.json: [ slug => [ name, default color ] ].
 */
function rainshade_palette(): array {
	static $palette;
	if ( null === $palette ) {
		$json    = wp_json_file_decode( get_theme_file_path( 'theme.json' ), [ 'associative' => true ] );
		$palette = [];
		foreach ( $json['settings']['color']['palette'] ?? [] as $color ) {
			$palette[ $color['slug'] ] = [ $color['name'], $color['color'] ];
		}
	}
	return $palette;
}

add_action( 'customize_register', function ( WP_Customize_Manager $wp_customize ) {
	foreach ( rainshade_palette() as $slug => [ $name, $default ] ) {
		$wp_customize->add_setting( "rainshade_color_{$slug}", [
			'default'           => $default,
			'sanitize_callback' => 'sanitize_hex_color',
		] );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, "rainshade_color_{$slug}", [
			'label'   => $name,
			'section' => 'colors',
		] ) );
	}
} );

add_filter( 'wp_theme_json_data_theme', function ( WP_Theme_JSON_Data $data ) {
	$palette = [];
	foreach ( rainshade_palette() as $slug => [ $name, $default ] ) {
		$palette[] = [ 'slug' => $slug, 'name' => $name, 'color' => get_theme_mod( "rainshade_color_{$slug}", $default ) ];
	}
	return $data->update_with( [ 'version' => 3, 'settings' => [ 'color' => [ 'palette' => $palette ] ] ] );
} );

// Global styles are cached; rebuild them after colors change.
add_action( 'customize_save_after', 'wp_clean_theme_json_cache' );
