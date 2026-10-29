<?php
/**
 * Fogged window.
 *
 * @var array $attributes
 */

defined( 'ABSPATH' ) || exit;

$url   = rainshade_image( $attributes, 'night.jpg' );
$fx    = round( ( $attributes['focalPoint']['x'] ?? 0.5 ) * 100, 2 );
$fy    = round( ( $attributes['focalPoint']['y'] ?? 0.4 ) * 100, 2 );
$pos   = "{$fx}% {$fy}%";
$name  = get_bloginfo( 'name' );
$alt   = rainshade_alt( $attributes );
$style = sprintf( 'height:%dpx;--rs-pos:%s;', (int) $attributes['height'], $pos );

$wrapper = get_block_wrapper_attributes( [
	'class'    => 'rs-window alignfull',
	'style'    => $style,
	'data-src' => $url,
] );
?>
<section id="top" <?php echo $wrapper; ?>>
	<img class="rs-window__photo" src="<?php echo esc_url( $url ); ?>" alt="<?php echo esc_attr( $alt ); ?>" fetchpriority="high">
	<?php echo rainshade_streaks( 40, 'rs-window__rain' ); ?>
	<canvas class="rs-window__fog" aria-hidden="true"></canvas>
	<div class="rs-water" aria-hidden="true"></div>

	<div class="rs-window__name" aria-hidden="true">
		<span style="background-image:url('<?php echo esc_url( $url ); ?>')"><?php echo esc_html( $name ); ?></span>
	</div>
	<h1 class="screen-reader-text"><?php echo esc_html( $name ); ?></h1>

	<div class="rs-window__bar">
		<div class="rs-window__release">
			<?php if ( $attributes['eyebrow'] ) : ?>
				<span class="rs-window__eyebrow"><?php echo esc_html( $attributes['eyebrow'] ); ?></span>
			<?php endif; ?>
			<a href="<?php echo esc_url( $attributes['linkUrl'] ); ?>" target="_blank" rel="noopener">
				<span class="rs-window__title"><?php echo esc_html( $attributes['release'] ); ?><i>.</i></span>
				<span class="rs-window__link"><?php echo esc_html( $attributes['linkText'] ); ?></span>
			</a>
		</div>
		<?php if ( $attributes['hint'] ) : ?>
			<span class="rs-window__hint">
				<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" aria-hidden="true"><path d="M9 11V5.5a1.5 1.5 0 0 1 3 0V11m0-1.5a1.5 1.5 0 0 1 3 0V12m0-1a1.5 1.5 0 0 1 3 0v3.5a6.5 6.5 0 0 1-6.5 6.5h-.6a6 6 0 0 1-4.6-2.2L4.5 15a1.6 1.6 0 0 1 2.4-2.1L9 15"/></svg>
				<?php echo esc_html( $attributes['hint'] ); ?>
			</span>
		<?php endif; ?>
	</div>
</section>
