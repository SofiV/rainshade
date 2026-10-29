<?php
/**
 * Small helpers used by templates and block renders.
 */

defined( 'ABSPATH' ) || exit;

/**
 * Asset version = file modification time, so browsers pick up every gulp build.
 */
function rainshade_ver( string $file ): string {
	$path = get_theme_file_path( $file );
	return file_exists( $path ) ? (string) filemtime( $path ) : RAINSHADE_VERSION;
}

/**
 * Photo URL for a block: the picked one, or the theme's default photo.
 */
function rainshade_image( array $attributes, string $fallback ): string {
	return ! empty( $attributes['mediaUrl'] ) ? $attributes['mediaUrl'] : get_theme_file_uri( 'assets/images/' . $fallback );
}

/**
 * Alt text of a picked photo.
 */
function rainshade_alt( array $attributes, string $fallback = '' ): string {
	return ! empty( $attributes['mediaId'] ) ? (string) get_post_meta( $attributes['mediaId'], '_wp_attachment_image_alt', true ) : $fallback;
}

/**
 * Falling rain streaks. Deterministic, so the markup is cache-friendly.
 */
function rainshade_streaks( int $count, string $class ): string {
	$out = '';
	for ( $i = 0; $i < $count; $i++ ) {
		$r = static fn( $s ) => fmod( abs( sin( $i * 12.9898 + $s * 78.233 ) * 43758.5453 ), 1 );
		$out .= sprintf(
			'<span style="--x:%.2f%%;--h:%dpx;--d:%.2fs;--t:-%.2fs;--o:%.2f"></span>',
			$r( 1 ) * 100,
			60 + $r( 2 ) * 160,
			1.2 + $r( 3 ) * 1.4,
			$r( 5 ) * 3,
			0.2 + $r( 4 ) * 0.4
		);
	}
	return '<span class="rs-streaks ' . esc_attr( $class ) . '" aria-hidden="true">' . $out . '</span>';
}
