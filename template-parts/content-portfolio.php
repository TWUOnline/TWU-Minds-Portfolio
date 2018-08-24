<?php
/**
 * The template used for displaying projects on index view
 *
 * @package Radcliffe 2
 */
?>


<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php if ( radcliffe_2_has_post_thumbnail() ) : ?>
		<div class="entry-thumbnail" <?php radcliffe_2_background_image(); ?>></div>
	<?php endif; ?>

	<header class="entry-header">

		<div class="entry-meta">
			<?php radcliffe_2_posted_on(); ?>
		</div><!-- .entry-meta -->
		
		<?php the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );?>

	</header><!-- .entry-header -->
</article><!-- #post-<?php the_ID(); ?> -->
