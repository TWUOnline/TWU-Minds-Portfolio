<?php
/**
 * Template part for displaying page content in page.php
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Radcliffe 2
 */

// Get number of projects to display (hardwired for now)
$portfolio_items_number = twu_minds_front_artifact_count();

$args = array(
	'post_type'      => 'twu-portfolio',
	'posts_per_page' => $portfolio_items_number,
);

$portfolio_query = new WP_Query ( $args );
?>

<?php if ( radcliffe_2_has_post_thumbnail() ) : ?>
	<div class="entry-thumbnail" <?php radcliffe_2_background_image(); ?>></div>
<?php endif; ?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php
			the_content();

			wp_link_pages( array(
				'before'      => '<div class="page-links">' . esc_html__( 'Pages:', 'radcliffe-2' ),
				'after'       => '</div>',
				'link_before' => '<span>',
				'link_after'  => '</span>',
			) );
		?>
	</div><!-- .entry-content -->

	<?php if ( get_edit_post_link() ) : ?>
		<footer class="entry-footer">
			<?php
				edit_post_link(
					sprintf(
						wp_kses(
							/* translators: %s: Name of current post. Only visible to screen readers */
							__( 'Edit <span class="screen-reader-text">%s</span>', 'radcliffe-2' ),
							array(
								'span' => array(
									'class' => array(),
								),
							)
						),
						get_the_title()
					),
					'<span class="edit-link">' . radcliffe_2_get_svg( array( 'icon' => 'edit', 'title' => esc_html__( 'Edit', 'radcliffe-2' ) ) ),
					'</span>'
				);
			?>
		</footer><!-- .entry-footer -->
	<?php endif; ?>
</article><!-- #post-<?php the_ID(); ?> -->

	<?php if ( $portfolio_query -> have_posts() ) : ?>
	
		<div class="entry-content">
		
			<header class="page-header">
				<h2 class="entry-header"><?php twu_minds_front_artifact_title()?></h2>
	
		
				<div class="archive-description">
					<?php twu_minds_portfolio_tagline()?>
				</div>
			</header><!-- .page-header -->
		
		</div>

	<div class="archive">

			<?php
				while ( $portfolio_query->have_posts() ) : $portfolio_query->the_post();
					get_template_part( 'template-parts/content', 'portfolio' );
				endwhile;
			
				if ($portfolio_query->found_posts > $portfolio_items_number) {
					echo '<p style="text-align:center"><a href="' . get_post_type_archive_link( 'twu-portfolio' ) . '">see all artifacts</a></p>';
						}

				wp_reset_postdata();
			?>
	
	</div>
	
	<?php else:?>
	
		<?php if ( current_user_can( 'publish_posts' ) ) : ?>


			<div class="entry-content">
				<h2 class="entry-header"><?php _e( 'No Artifacts Found', 'radcliffe-2' ); ?></h2>

				<p>
					<?php printf( esc_html__( 'This section will display your ' . $portfolio_items_number . ' latest artifacts.', 'radcliffe-2' ) ); ?><br />
					<?php printf( wp_kses( __( 'Ready to publish your first artifact? <a href="%1$s">Get started here</a>.', 'radcliffe-2' ), array( 'a' => array( 'href' => array() ) ) ), esc_url( admin_url( 'post-new.php?post_type=twu-portfolio' ) ) ); ?>
				</p>
			</div>


	<?php endif; ?>

	
	
	
	<?php endif?>



