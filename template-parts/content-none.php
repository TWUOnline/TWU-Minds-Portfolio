<?php
/**
 * Template part for displaying a message that posts cannot be found
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Radcliffe 2
 */


 // add extra header
 if ( is_tax( 'twu-portfolio-type') ) {
 	$term_obj =	get_queried_object(); // the term we need for this taxonomy
    $term = get_term( $term_obj->term_id, 'twu-portfolio-type' );
    
    $extra = ' for Artifacts of Type "' .   $term->name . '"';

} elseif ( is_tax( 'twu-portfolio-tag') ) {
 	$term_obj =	get_queried_object(); // the term we need for this taxonomy
    $term = get_term( $term_obj->term_id, 'twu-portfolio-tag' );
    
    $extra = ' for Artifacts Tagged  "' .   $term->name . '"';
} else {
	$extra = '';
}
?>


<section class="no-results not-found">
	<header class="page-header">
		<h1 class="page-title"><?php esc_html_e( 'No Portfolio Items Found' . $extra, 'radcliffe-2' ); ?></h1>
	</header><!-- .page-header -->

	<div class="page-content">
		<?php
		if ( is_home() && current_user_can( 'publish_posts' ) ) : ?>

			<p><?php
				printf(
					wp_kses(
						/* translators: 1: link to WP admin new post page. */
						__( 'Ready to publish your first post? <a href="%1$s">Get started here</a>.', 'radcliffe-2' ),
						array(
							'a' => array(
								'href' => array(),
							),
						)
					),
					esc_url( admin_url( 'post-new.php' ) )
				);
			?></p>

		<?php elseif ( is_search() ) : ?>

			<p><?php esc_html_e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'radcliffe-2' ); ?></p>
			<?php
				get_search_form();

		else : ?>
			
			<p><?php _e( 'Sorry, but we did not find any content at this address. Try again from the <a href=" ' . site_url() . '">home of this site</a> or the <a href="' . get_post_type_archive_link( 'twu-portfolio' ) . '">main portfolio index</a>? Perhaps check the URL, try again, or try searching?', 'radcliffe-2' ); ?></p>
			
			<?php
				get_search_form();

		endif; ?>
	</div><!-- .page-content -->
</section><!-- .no-results -->
