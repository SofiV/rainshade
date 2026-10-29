<?php
/**
 * Release section.
 *
 * @var array  $attributes
 * @var string $content Inner blocks (the forecast tracklist).
 */

defined( 'ABSPATH' ) || exit;

$url  = rainshade_image( $attributes, 'fall-cover.jpg' );
$link = $attributes['linkUrl'];
?>
<section <?php echo get_block_wrapper_attributes( [ 'class' => 'rs-release' ] ); ?>>
	<a class="rs-release__cover wp-block-image is-style-rain" href="<?php echo esc_url( $link ); ?>" target="_blank" rel="noopener">
		<img src="<?php echo esc_url( $url ); ?>" alt="<?php echo esc_attr( rainshade_alt( $attributes, $attributes['title'] . ' — cover' ) ); ?>" loading="lazy">
		<?php echo rainshade_streaks( 16, 'rs-rainon' ); ?>
	</a>
	<div class="rs-release__info">
		<div class="rs-release__head">
			<span class="rs-release__eyebrow"><?php echo esc_html( $attributes['eyebrow'] ); ?></span>
			<h2 class="rs-release__title"><?php echo esc_html( $attributes['title'] ); ?><i>.</i></h2>
		</div>
		<?php echo $content; ?>
		<?php if ( $attributes['linkText'] ) : ?>
			<a class="rs-release__link" href="<?php echo esc_url( $link ); ?>" target="_blank" rel="noopener"><?php echo esc_html( $attributes['linkText'] ); ?></a>
		<?php endif; ?>
	</div>
</section>
