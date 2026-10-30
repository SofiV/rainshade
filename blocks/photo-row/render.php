<?php
/**
 * Photo row. Without picked photos it shows empty frames.
 *
 * @var array $attributes
 */

defined( 'ABSPATH' ) || exit;

$images = $attributes['images'] ?: array_fill( 0, max( 1, (int) $attributes['columns'] ), [] );

$style = sprintf( '--rs-cols:%d;--rs-ratio:%s', max( 1, (int) $attributes['columns'] ), preg_replace( '#[^0-9/.\s]#', '', $attributes['ratio'] ) );
?>
<section <?php echo get_block_wrapper_attributes( [ 'class' => 'rs-photos', 'style' => $style ] ); ?>>
	<?php foreach ( $images as $image ) : ?>
		<figure class="wp-block-image is-style-rain rs-photos__item">
			<?php if ( ! empty( $image['url'] ) ) : ?>
				<img src="<?php echo esc_url( $image['url'] ); ?>" alt="<?php echo esc_attr( $image['alt'] ?? '' ); ?>" loading="lazy">
			<?php else : ?>
				<span class="rs-frame"></span>
			<?php endif; ?>
			<?php echo rainshade_streaks( 16, 'rs-rainon' ); ?>
			<?php if ( ! empty( $image['caption'] ) ) : ?>
				<figcaption><?php echo esc_html( $image['caption'] ); ?></figcaption>
			<?php endif; ?>
		</figure>
	<?php endforeach; ?>
</section>
