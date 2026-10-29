<?php
/**
 * Fallback: list of posts.
 */

defined( 'ABSPATH' ) || exit;

get_header();
?>
<div class="rs-page is-layout-constrained has-global-padding">
	<?php if ( have_posts() ) : ?>
		<?php while ( have_posts() ) : the_post(); ?>
			<article class="rs-post">
				<h2 class="rs-post__title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
				<time class="rs-post__date" datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>"><?php echo esc_html( get_the_date() ); ?></time>
				<?php the_excerpt(); ?>
			</article>
		<?php endwhile; ?>
		<?php the_posts_pagination(); ?>
	<?php else : ?>
		<p><?php esc_html_e( 'nothing here yet.', 'rainshade' ); ?></p>
	<?php endif; ?>
</div>
<?php
get_footer();
