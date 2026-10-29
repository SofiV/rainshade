<?php
/**
 * Blocks and block styles.
 */

defined( 'ABSPATH' ) || exit;

add_action( 'init', function () {
	$blocks = [
		'window', 'release', 'fog-quote', 'visuals', 'photo-row', 'shows', // sections
		'forecast', 'track', 'show',                 // children
	];
	foreach ( $blocks as $block ) {
		$json = get_theme_file_path( "blocks/{$block}/block.json" );
		if ( file_exists( $json ) ) {
			register_block_type( $json );
		} elseif ( WP_DEBUG ) {
			error_log( "rainshade: missing {$json}" );
		}
	}

	register_block_style( 'core/image', [
		'name'  => 'rain',
		'label' => __( 'Rain on hover', 'rainshade' ),
	] );
} );

// Image style "Rain on hover": add falling streaks inside the figure.
add_filter( 'render_block_core/image', function ( $html, $block ) {
	if ( ! str_contains( $block['attrs']['className'] ?? '', 'is-style-rain' ) ) {
		return $html;
	}
	return preg_replace( '#</figure>\s*$#', rainshade_streaks( 16, 'rs-rainon' ) . '</figure>', $html, 1 );
}, 10, 2 );
