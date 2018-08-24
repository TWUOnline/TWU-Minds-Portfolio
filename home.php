<?php
/**
 * Main template file when not using page for front,
 * use to issue a notice about setup.
 *
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main">	
			
		<?php

			if ( is_front_page() ) : ?>
				<div class="archive">
				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<header class="entry-header">
					<h2>Using This Theme</h2>
				</header>

				<div class="entry-content">
				<p>Note: This theme is specifically designed to use a Page as the front of your portfolio. Create <a href="<?php echo admin_url( 'post-new.php?post_type=page' );?>">a new WordPress Page</a> to add whatever you want to say as an introduction to your portfolio. Be sure to use the template <strong>TWU Portfolio Front Page</strong>. If you want to have a blog in your portfolio, create another empty Wordpress Page named "Blog" or "News".</p>
					<p>Then in your Wordpress Settings, under <strong><a href="<?php echo admin_url( 'options-reading.php' );?>">Reading</a></strong>, set the option for <strong>Your homepage displays</strong> to be  <code>A static page (select below)</code>, and select the appropriate pages.</p>
					
					<img src="<?php echo get_stylesheet_directory_uri()?>/images/reading-settings.jpg" alt="reading settings" class="aligncenter" width="80%" />
					
					<p>If you are wanting Wordpress site for a different purpose, switch your theme to <strong>Radcliffe 2</strong>, which is the one this theme is based on.</p>
				</div></article>
			</div>
			
			<?php else: // a posts display for a page set for blogs?>
			
				<?php if ( have_posts() ) : ?>

					<?php /* Start the Loop */ ?>
					<?php while ( have_posts() ) : the_post(); ?>

						<?php
							/* Include the Post-Format-specific template for the content.
							 * If you want to override this in a child theme, then include a file
							 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
							 */
							get_template_part( 'template-parts/content', get_post_format() );
						?>

					<?php endwhile; ?>
					
					
					<?php the_posts_navigation( array(
				'prev_text' => radcliffe_2_get_svg( array( 'icon' => 'previous' ) ) . esc_html__( 'Older Posts', 'radcliffe-2' ),
				'next_text' => esc_html__( 'Newer Posts', 'radcliffe-2' ) . radcliffe_2_get_svg( array( 'icon' => 'next' ) ),
			) );?>


				<?php else : ?>

					<?php get_template_part( 'template-parts/content', 'none' ); ?>

				<?php endif; ?>

			
			<?php endif;?>
			
				
			
			
			
		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_sidebar();
get_footer();
