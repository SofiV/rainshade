<?php
/**
 * One track in the forecast.
 *
 * @var array $attributes
 */

defined( 'ABSPATH' ) || exit;

if ( '' === trim( $attributes['title'] ) ) {
	return;
}
?>
<li <?php echo get_block_wrapper_attributes( [ 'class' => 'rs-track' ] ); ?>>
	<span class="rs-track__title"><?php echo esc_html( $attributes['title'] ); ?></span>
	<?php if ( $attributes['bpm'] ) : ?>
		<span class="rs-track__bpm"><?php echo esc_html( $attributes['bpm'] ); ?> bpm</span>
	<?php endif; ?>
	<?php if ( '' !== $attributes['tears'] ) : ?>
		<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" aria-hidden="true"><path d="M7 17a4 4 0 0 1 .5-8A5.5 5.5 0 0 1 18 9.5a3.5 3.5 0 0 1-.5 7.5M9 20l1-2m3 3l1-2"/></svg>
		<span class="rs-track__tears"><?php echo esc_html( $attributes['tears'] ); ?>%</span>
	<?php endif; ?>
</li>
