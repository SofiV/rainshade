<?php
/**
 * Release section.
 *
 * @var array  $attributes
 * @var string $content Inner blocks (the forecast tracklist).
 */

defined( 'ABSPATH' ) || exit;

$url  = rainshade_image( $attributes );
$link = $attributes['linkUrl'];
$tag  = $link ? 'a' : 'div';
$href = $link ? sprintf( ' href="%s" target="_blank" rel="noopener"', esc_url( $link ) ) : '';
?>
<section <?php echo get_block_wrapper_attributes( [ 'class' => 'rs-release' ] ); ?>>
	<<?php echo $tag . $href; ?> class="rs-release__cover wp-block-image is-style-rain">
		<?php if ( $url ) : ?>
			<img src="<?php echo esc_url( $url ); ?>" alt="<?php echo esc_attr( rainshade_alt( $attributes, $attributes['title'] . ' — cover' ) ); ?>" loading="lazy">
		<?php else : ?>
			<span class="rs-frame"></span>
		<?php endif; ?>
		<?php echo rainshade_streaks( 16, 'rs-rainon' ); ?>
	</<?php echo $tag; ?>>
	<div class="rs-release__info">
		<div class="rs-release__head">
			<?php if ( $attributes['eyebrow'] ) : ?>
				<span class="rs-release__eyebrow"><?php echo esc_html( $attributes['eyebrow'] ); ?></span>
			<?php endif; ?>
			<?php if ( $attributes['title'] ) : ?>
				<h2 class="rs-release__title"><?php echo esc_html( $attributes['title'] ); ?><i>.</i></h2>
			<?php endif; ?>
		</div>
		<?php echo $content; ?>
		<?php if ( $link && $attributes['linkText'] ) : ?>
			<a class="rs-release__link" href="<?php echo esc_url( $link ); ?>" target="_blank" rel="noopener"><?php echo esc_html( $attributes['linkText'] ); ?></a>
		<?php endif; ?>
	</div>
</section>
