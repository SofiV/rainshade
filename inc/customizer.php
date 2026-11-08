<?php
/**
 * Appearance → Customize: Colors, Fonts and the footer.
 */

defined( 'ABSPATH' ) || exit;

/**
 * theme.json as an array.
 */
function rainshade_theme_json(): array {
	static $json;
	return $json ??= wp_json_file_decode( get_theme_file_path( 'theme.json' ), [ 'associative' => true ] ) ?: [];
}

/**
 * Palette from theme.json: [ slug => [ name, default color ] ].
 */
function rainshade_palette(): array {
	$palette = [];
	foreach ( rainshade_theme_json()['settings']['color']['palette'] ?? [] as $color ) {
		$palette[ $color['slug'] ] = [ $color['name'], $color['color'] ];
	}
	return $palette;
}

/**
 * Font roles from theme.json (display, serif, mono) with their default fonts.
 */
function rainshade_font_roles(): array {
	return rainshade_theme_json()['settings']['typography']['fontFamilies'] ?? [];
}

/**
 * Networks for the footer icons: [ core/social-link service => label ].
 */
function rainshade_socials(): array {
	return [
		'instagram'  => 'Instagram',
		'youtube'    => 'YouTube',
		'spotify'    => 'Spotify',
		'applemusic' => 'Apple Music', 
		'soundcloud' => 'SoundCloud',
		'bandcamp'   => 'Bandcamp',
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

	// Fonts: each role can use any font installed in Appearance → Fonts.
	$wp_customize->add_section( 'rainshade_fonts', [ 'title' => __( 'Fonts', 'rainshade' ), 'description' => __( 'Install fonts in Appearance → Fonts, then pick them here.', 'rainshade' ) ] );
	$installed = wp_list_pluck( wp_get_global_settings( [ 'typography', 'fontFamilies', 'custom' ] ) ?: [], 'name', 'slug' );
	foreach ( rainshade_font_roles() as $role ) {
		$default = trim( strtok( $role['fontFamily'], ',' ), '"\' ' );
		$wp_customize->add_setting( "rainshade_font_{$role['slug']}", [ 'default' => '', 'sanitize_callback' => 'sanitize_key' ] );
		$wp_customize->add_control( "rainshade_font_{$role['slug']}", [
			'label'   => $role['name'],
			'type'    => 'select',
			'section' => 'rainshade_fonts',
			/* translators: %s: theme default font name */
			'choices' => [ '' => sprintf( __( 'Theme default (%s)', 'rainshade' ), $default ) ] + $installed,
		] );
	}

	// Footer sign-up line. Hidden until a link is set.
	$wp_customize->add_section( 'rainshade_footer', [ 'title' => __( 'Footer', 'rainshade' ) ] );
	$fields = [
		'rainshade_signup_text' => [ __( 'Sign-up text', 'rainshade' ), 'text', 'sanitize_text_field', 'tell me when it rains again:' ],
		'rainshade_signup_link' => [ __( 'Sign-up link text', 'rainshade' ), 'text', 'sanitize_text_field', 'sign up' ],
		'rainshade_signup_url'  => [ __( 'Sign-up link: URL or email', 'rainshade' ), 'text', fn ( $v ) => is_email( trim( $v ) ) ? 'mailto:' . trim( $v ) : esc_url_raw( $v ), '' ],
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

/**
 * Picked fonts as CSS.
 */
function rainshade_font_css(): string {
	$css = '';
	foreach ( rainshade_font_roles() as $role ) {
		$font = get_theme_mod( "rainshade_font_{$role['slug']}" );
		if ( $font ) {
			$css .= "--wp--preset--font-family--{$role['slug']}:var(--wp--preset--font-family--{$font});";
		}
	}
	return $css ? "body{{$css}}" : '';
}

add_action( 'wp_enqueue_scripts', fn () => wp_add_inline_style( 'rainshade', rainshade_font_css() ), 20 );

add_filter( 'block_editor_settings_all', function ( array $settings ) {
	$settings['styles'][] = [ 'css' => rainshade_font_css() ];
	return $settings;
} );

// Global styles are cached; rebuild them after colors change.
add_action( 'customize_save_after', 'wp_clean_theme_json_cache' );
