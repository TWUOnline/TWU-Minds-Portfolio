<?php
/* Functions to modify parent theme for TRU portfolios
                                                                 */


# -----------------------------------------------------------------
# Enqueue Scripts 'n Styles
# -----------------------------------------------------------------

function twu_portfolio_enqueues() {	 
 
    $parent_style = 'radcliffe_style'; 
    
    wp_enqueue_style( $parent_style, get_template_directory_uri() . '/style.css' );
    
    wp_enqueue_style( 'child-style',
        get_stylesheet_directory_uri() . '/style.css',
        array( $parent_style ),
        wp_get_theme()->get('Version')
    );

}

add_action('wp_enqueue_scripts', 'twu_portfolio_enqueues');

function twu_minds_entry_footer() {
	
	global $post;
	
	// Hide category and tag text for pages.
	if ( 'post' === get_post_type() ) {
		/* translators: used between list items, there is a space after the comma */
		$categories_list = get_the_category_list( esc_html__( ', ', 'radcliffe-2' ) );
		if ( $categories_list && ! is_wp_error( $categories_list ) ) {
			/* translators: 1: list of categories. */
			echo '<span class="cat-links">' . radcliffe_2_get_svg( array( 'icon' => 'category', 'title' => esc_html__( 'Categories', 'radcliffe-2' ) ) ) . $categories_list . '</span>';
		}

		/* translators: used between list items, there is a space after the comma */
		$tags_list = get_the_tag_list( '', esc_html_x( ', ', 'list item separator', 'radcliffe-2' ) );
		if ( $tags_list && ! is_wp_error( $tags_list ) ) {
			/* translators: 1: list of tags. */
			echo '<span class="tags-links">' . radcliffe_2_get_svg( array( 'icon' => 'tag', 'title' => esc_html__( 'Tags', 'radcliffe-2' ) ) ) . $tags_list . '</span>';
		}
	} elseif ( 'twu-portfolio' === get_post_type() ) {
	

		/* translators: used between list items, there is a space after the comma */
		$categories_list = get_the_term_list( $post->ID, 'twu-portfolio-type', '', __( ', ', 'radcliffe-2' ) );
		if ( $categories_list && ! is_wp_error( $categories_list ) ) {
			echo '<span class="cat-links">' . radcliffe_2_get_svg( array( 'icon' => 'category', 'title' => esc_html__( 'Categories', 'radcliffe-2' ) ) ) . $categories_list . '</span>';
		}

		/* translators: used between list items, there is a space after the comma */
		$tags_list = get_the_term_list( $post->ID, 'twu-portfolio-tag', '', __( ', ', 'radcliffe-2' ) );
		if ( $tags_list && ! is_wp_error( $tags_list ) ) {
			echo '<span class="tags-links">' . radcliffe_2_get_svg( array( 'icon' => 'tag', 'title' => esc_html__( 'Tags', 'radcliffe-2' ) ) ) . $tags_list . '</span>';
		}
	
	}

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
}

# -----------------------------------------------------------------
# Misc Stuff
# useful wrenches and hammers
# -----------------------------------------------------------------


?>