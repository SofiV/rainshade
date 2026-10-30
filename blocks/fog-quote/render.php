<?php
/**
 * Words on fogged glass.
 *
 * @var array $attributes
 */

defined( 'ABSPATH' ) || exit;

$url = rainshade_image( $attributes );
$pos = round( ( $attributes['focalPoint']['x'] ?? 0.45 ) * 100, 2 ) . '% ' . round( ( $attributes['focalPoint']['y'] ?? 0.4 ) * 100, 2 ) . '%';
$alt = rainshade_alt( $attributes );

$wrapper = get_block_wrapper_attributes( [
	'class'    => 'rs-fogquote' . ( $url ? '' : ' is-empty' ),
	'style'    => '--rs-pos:' . $pos,
	'data-src' => $url,
	'tabindex' => '0',
] );
?>
<figure <?php echo $wrapper; ?>>
	<?php if ( $url ) : ?>
		<img class="rs-fogquote__photo" src="<?php echo esc_url( $url ); ?>" alt="<?php echo esc_attr( $alt ); ?>" loading="lazy">
		<div class="rs-fogquote__glass" aria-hidden="true">
			<img src="<?php echo esc_url( $url ); ?>" alt="" loading="lazy">
			<div class="rs-water"></div>
		</div>
	<?php endif; ?>
	<?php if ( $attributes['text'] ) : ?>
		<blockquote class="rs-fogquote__text"<?php echo $url ? ' style="background-image:url(\'' . esc_url( $url ) . '\')"' : ''; ?>>
			<?php echo nl2br( esc_html( $attributes['text'] ) ); ?>
		</blockquote>
	<?php endif; ?>
</figure>
