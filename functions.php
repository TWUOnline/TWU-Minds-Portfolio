<?php
/* Functions to modify parent theme for TRU portfolios

                                                              */

# -----------------------------------------------------------------
# Theme Setup
# -----------------------------------------------------------------

add_action( 'after_setup_theme', 'twu_minds_setup');

function twu_minds_setup() {
	
	//register support for portfolio features
	add_theme_support( 'twu-portfolio' );
}


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



// content for the archives
function twu_minds_portfolio_content( $before = '', $after = '' ) {

	if ( is_tax() && get_the_archive_description() ) {
		echo $before . get_the_archive_description() . $after;
	} else {
		$content = twu_minds_portfolio_tagline('get');
		echo $before . $content . $after;
	}
}

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
# General TWU Portfolio Stuff
# -----------------------------------------------------------------


function twu_portfolio_tax_count ( $taxonomy, $term, $p_type='twu-portfolio' ) {
	// find the number of items in custom post type that use the term in a taxonomy
	
	$args = array(
		'post_type' =>  $p_type,
		'posts_per_page' => -1,
		'tax_query' => array(
			array(
				'taxonomy' => $taxonomy,
				'field'    => 'slug',
				'terms'    => $term,
			),
		),
	);
	
	$tax_query = new WP_Query( $args );
	
	return ($tax_query->found_posts);

}


/* Clean up the +New menu to put "Artifacts" at top, remove "Media" / "User"
   Add a custom menu for TWU (hard wired for now)                            */
   
function twu_portfolio_adminbar() {

	// admin bar needs to be known globally
	global $wp_admin_bar;
	
	// remove all items from New Content menu
	$wp_admin_bar->remove_node('new-post');
	$wp_admin_bar->remove_node('new-media');
	$wp_admin_bar->remove_node('new-page');
	$wp_admin_bar->remove_node('new-user');
	
	// add back the new Post link
	$args = array(
		'id'     => 'new-post',    
		'title'  => 'Blog Post', 
		'parent' => 'new-content',
		'href'  => admin_url( 'post-new.php' ),
		'meta'  => array( 'class' => 'ab-item' )
	);
	$wp_admin_bar->add_node( $args );

	// add back the new Page 
	$args = array(
		'id'     => 'new-page',    
		'title'  => 'Page', 
		'parent' => 'new-content',
		'href'  => admin_url( 'post-new.php?post_type=page' ),
		'meta'  => array( 'class' => 'ab-item' )
	);
	$wp_admin_bar->add_node( $args );


	// add a top menu for the TWU Create links
	$args = array(
		'id'    => 'twu-portfolio',
		'title' => 'TWU Create',
		'href'  => 'https://create.twu.ca/',
		'meta'  => array(
			'title' => __('TWU Create'),            
		),
	);
	
	$wp_admin_bar->add_menu( $args );

	$args = array(
		'id'    => 'portfolio',
		'parent' => 'twu-portfolio',
		'title' => 'E-Portfolio Help',
		'href'  => 'http://create.twu.ca/eportfolios',
		'meta'  => array(
			'title' => __('TWU E-Portfolio information and documentation'),
			'target' => '_blank',
			'class' => ''
		),
	);
	
	$wp_admin_bar->add_menu( $args );

	$args = array(
		'id'    => 'wordpress-guide',
		'parent' => 'twu-portfolio',
		'title' => 'WordPress Guide',
		'href'  => 'http://create.twu.ca/eportfolios/wordpress/',
		'meta'  => array(
			'title' => __('TWU Eportfolio WordPress Guide'),
			'target' => '_blank',
			'class' => ''
		),
	);
	
	$wp_admin_bar->add_menu( $args );

	$args = array(
		'id'    => 'wordpress-glossary',
		'parent' => 'twu-portfolio',
		'title' => 'WordPress Glossary',
		'href'  => 'https://www.wpglossary.net/',
		'meta'  => array(
			'title' => __('Definitions of words that you come in contact with when you use WordPress'),
			'target' => '_blank',
			'class' => ''
		),
	);

	$wp_admin_bar->add_menu( $args );
	
		
	$args = array(
		'id'    => 'theme-guide',
		'parent' => 'twu-portfolio',
		'title' => 'TWU Minds Theme',
		'href'  => 'http://create.twu.ca/eportfolios/portfolio-themes/twu-minds/',
		'meta'  => array(
			'title' => __('Using the TWU Minds theme'),
			'target' => '_blank',
			'class' => ''
		),
	);
	
	$wp_admin_bar->add_menu( $args );
}

add_action( 'wp_before_admin_bar_render', 'twu_portfolio_adminbar', 99 );

function twu_portfolio_dashboard_widgets() {
	wp_add_dashboard_widget('twu_portfolio_admin', 'Your TWU Portfolio', 'twu_portfolio_make_dashboard_widget');
}

function twu_portfolio_make_dashboard_widget() {
	echo '<p>There are currently <strong>' . twu_artifact_count() . '</strong> artifacts in your portfolio.</p>
	<ul>
		<li><a href="' . get_post_type_archive_link( 'twu-portfolio' ) . '" target="_blank">See all artifacts</a><li>
		<li><a href="' . admin_url( 'edit.php?post_type=twu-portfolio') . '">Manage your artifacts</a></li>	
		<li><a href="' . admin_url( 'post-new.php?post_type=twu-portfolio') . '">Create a new artifact</a></li>
	
	 </ul>';
}

add_action('wp_dashboard_setup', 'twu_portfolio_dashboard_widgets');

function twu_artifact_count() {
	return wp_count_posts('twu-portfolio')->publish;
}


# -----------------------------------------------------------------
# Customizer Additions 
# -----------------------------------------------------------------


add_action( 'customize_register', 'twu_minds_register_theme_customizer' );

// register custom customizer stuff

function twu_minds_register_theme_customizer( $wp_customize ) {

	// Add section in customizer for this stuff
	$wp_customize->add_section( 'twu_portfolio' , array(
		'title'    => __('TWU Portfolio', 'radcliffe-2'),
		'priority' => 10
	) );



	// setting for title label
	$wp_customize->add_setting( 'front_artifact_title', array(
		 'default'           => __( 'Recent Artifacts', 'radcliffe-2'),
		 'type' => 'theme_mod',
		 'sanitize_callback' => 'sanitize_text'
	) );
	
	// Control for title 
	$wp_customize->add_control( new WP_Customize_Control(
	    $wp_customize,
		'front_artifact_title',
		    array(
		        'label'    => __( 'Front Artifact Title', 'radcliffe-2'),
		        'priority' => 2,
		        'description' => __( 'The heading for artifacts displayed on your front page' ),
		        'section'  => 'twu_portfolio',
		        'settings' => 'front_artifact_title',
		        'type'     => 'text'
		    )
	    )
	);

		
	// setting for count of artifacts to show
	$wp_customize->add_setting( 'front_artifact_count', array(
		'default'           => '3',
		'sanitize_callback' => 'absint',
	) );

	// Control for title 
	$wp_customize->add_control( new WP_Customize_Control(
	    $wp_customize,
		'front_artifact_count',
		    array(
		        'label'    => __( 'Number of Artifacts to Show', 'radcliffe-2'),
		        'priority' => 4,
		        'description' => __( 'How many artifacts to display on front page' ),
		        'section'  => 'twu_portfolio',
		        'settings' => 'front_artifact_count',
				'type'              => 'select',
					'choices' 		=> array(
						'3'	=> '3',
						'4'	=> '4',
						'5' => '5',
						'6' => '6',	
						'7' => '7',	
						'8' => '8',	
						'9' => '9',
						'10' => '10',	
						'11' => '11',
						'12' => '12',							
					),

		    )
	    )
	);

	// setting for categories  prompt
	$wp_customize->add_setting( 'portfolio_tagline', array(
		 'default'           => __( 'Please explore and provide feedback on my artifacts!', 'radcliffe-2'),
		 'type' => 'theme_mod',
		 'sanitize_callback' => 'sanitize_text'
	) );
	
	// Control for categories prompt
	$wp_customize->add_control( new WP_Customize_Control(
	    $wp_customize,
		'portfolio_tagline',
		    array(
		        'label'    => __( 'Tagline for Main Portfolio Page', 'radcliffe-2'),
		        'priority' => 8,
		        'description' => __( 'Text below the header on  <a href="' . get_post_type_archive_link( 'twu-portfolio' ) . '" target="_blank">Main Portfolio Index</a>' ),
		        'section'  => 'twu_portfolio',
		        'settings' => 'portfolio_tagline',
		        'type'     => 'textarea'
		    )
	    )
	);
	


 	// Sanitize text
	function sanitize_text( $text ) {
	    return sanitize_text_field( $text );
	}	
}

function twu_minds_front_artifact_title() {
	 if ( get_theme_mod( 'front_artifact_title') != "" ) {
	 	echo get_theme_mod( 'front_artifact_title');
	 }	else {
	 	echo 'Recent Artifacts';
	 }
}

function twu_minds_front_artifact_count() {
	 if ( get_theme_mod( 'front_artifact_count') != "" ) {
	 	return get_theme_mod( 'front_artifact_count');
	 }	else {
	 	return 6;
	 }
}

function twu_minds_portfolio_tagline( $mode = 'echo' ) {
	 if ( get_theme_mod( 'portfolio_tagline') != "" ) {
	 	if ($mode == 'echo' ) {
	 		echo get_theme_mod( 'portfolio_tagline');
	 	} else {
	 		return get_theme_mod( 'portfolio_tagline');
	 	}
	 	
	 }	else {
	 
	 	if ($mode == 'echo' ) {
	 		echo 'Please explore and provide feedback on my artifacts!';
	 	} else {
	 		return 'Please explore and provide feedback on my artifacts!';
	 	
	 	}
	 }
}




# -----------------------------------------------------------------
# Misc Stuff
# useful wrenches and hammers
# -----------------------------------------------------------------

// Load enhancement file to display admin notices.
require get_stylesheet_directory() . '/inc/twu-minds-enhancements.php';


?>