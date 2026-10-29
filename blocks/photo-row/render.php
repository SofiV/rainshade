<?php
/**
 * Photo row. Without picked photos it shows the theme's blossom series.
 *
 * @var array $attributes
 */

defined( 'ABSPATH' ) || exit;

$images = $attributes['images'];
if ( ! $images ) {
	$images = array_map(
		static fn( $n ) => [ 'url' => get_theme_file_uri( "assets/images/blossom-0{$n}.jpg" ), 'alt' => 'rainshade among blossoms', 'caption' => "blossom series — 0{$n}" ],
		[ 1, 2, 3 ]
	);
}

$style = sprintf( '--rs-cols:%d;--rs-ratio:%s', max( 1, (int) $attributes['columns'] ), preg_replace( '#[^0-9/.\s]#', '', $attributes['ratio'] ) );
?>
<section <?php echo get_block_wrapper_attributes( [ 'class' => 'rs-photos', 'style' => $style ] ); ?>>
	<?php foreach ( $images as $image ) : ?>
		<figure class="wp-block-image is-style-rain rs-photos__item">
			<img src="<?php echo esc_url( $image['url'] ?? '' ); ?>" alt="<?php echo esc_attr( $image['alt'] ?? '' ); ?>" loading="lazy">
			<?php echo rainshade_streaks( 16, 'rs-rainon' ); ?>
			<?php if ( ! empty( $image['caption'] ) ) : ?>
				<figcaption><?php echo esc_html( $image['caption'] ); ?></figcaption>
			<?php endif; ?>
		</figure>
	<?php endforeach; ?>
</section>
