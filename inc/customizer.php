<?php
/**
 * Appearance → Customize: Colors and the footer sign-up line.
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

/**
 * Networks for the footer icons: [ core/social-link service => label ].
 */
function rainshade_socials(): array {
	return [
		'instagram'  => 'Instagram',
		'youtube'    => 'YouTube',
		'spotify'    => 'Spotify',
		'soundcloud' => 'SoundCloud',
		'tiktok'     => 'TikTok',
		'mail'       => 'Email',
	];
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

	// Footer sign-up line. Hidden until a link is set.
	$wp_customize->add_section( 'rainshade_footer', [ 'title' => __( 'Footer', 'rainshade' ) ] );
	$fields = [
		'rainshade_signup_text' => [ __( 'Sign-up text', 'rainshade' ), 'text', 'sanitize_text_field', 'tell me when it rains again:' ],
		'rainshade_signup_link' => [ __( 'Sign-up link text', 'rainshade' ), 'text', 'sanitize_text_field', 'sign up' ],
		'rainshade_signup_url'  => [ __( 'Sign-up URL (newsletter form, mailto:…)', 'rainshade' ), 'url', 'esc_url_raw', '' ],
	];
	foreach ( $fields as $id => [ $label, $type, $sanitize, $default ] ) {
		$wp_customize->add_setting( $id, [ 'default' => $default, 'sanitize_callback' => $sanitize ] );
		$wp_customize->add_control( $id, [ 'label' => $label, 'type' => $type, 'section' => 'rainshade_footer' ] );
	}

	// Footer social icons: one URL per network, empty ones are skipped.
	foreach ( rainshade_socials() as $service => $label ) {
		$wp_customize->add_setting( "rainshade_social_{$service}", [ 'sanitize_callback' => 'mail' === $service ? 'sanitize_email' : 'esc_url_raw' ] );
		$wp_customize->add_control( "rainshade_social_{$service}", [ 'label' => $label, 'type' => 'mail' === $service ? 'email' : 'url', 'section' => 'rainshade_footer' ] );
	}
} );

add_filter( 'wp_theme_json_data_theme', function ( WP_Theme_JSON_Data $data ) {
	$palette = [];
	foreach ( rainshade_palette() as $slug => [ $name, $default ] ) {
		$palette[] = [ 'slug' => $slug, 'name' => $name, 'color' => get_theme_mod( "rainshade_color_{$slug}", $default ) ];
	}
	return $data->update_with( [ 'version' => 3, 'settings' => [ 'color' => [ 'palette' => $palette ] ] ] );
} );

add_action( 'customize_save_after', 'wp_clean_theme_json_cache' );
