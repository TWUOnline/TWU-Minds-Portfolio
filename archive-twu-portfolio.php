<?php
/**
 * The template for displaying archive pages
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Radcliffe 2
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main">

		<?php
		if ( have_posts() ) : ?>

			<header class="page-header">
			
				<h1 class="page-title"><?php _e( 'All My Artifacts', 'radcliffe-2' );?> (<?php echo wp_count_posts('twu-portfolio')->publish?> total)</h1>



				<?php twu_minds_portfolio_content( '<div class="archive-description">', '</div>' ); ?>
			
			
			</header><!-- .page-header -->

			<?php
			/* Start the Loop */
			while ( have_posts() ) : the_post();

				/*
				 * Include the Post-Format-specific template for the content.
				 * If you want to override this in a child theme, then include a file
				 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
				 */
				get_template_part( 'template-parts/content', get_post_format() );

			endwhile;

			the_posts_navigation( array(
				'prev_text' => radcliffe_2_get_svg( array( 'icon' => 'previous' ) ) . esc_html__( 'Older Artifacts', 'radcliffe-2' ),
				'next_text' => esc_html__( 'Newer Artifacts', 'radcliffe-2' ) . radcliffe_2_get_svg( array( 'icon' => 'next' ) ),
			) );

		else :

			get_template_part( 'template-parts/content', 'none' );

		endif; ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_sidebar();
get_footer();
