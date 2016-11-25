<?php
/*
 * custom taxonomy "Research"
 */
function research_register() {
	$labels = array(
        'name'                       => _x( '研究方向', 'taxonomy general name', 'textdomain' ),
        'singular_name'              => _x( 'Research', 'taxonomy singular name', 'textdomain' ),
        'search_items'               => __( 'Search Researches', 'textdomain' ),
        'popular_items'              => __( 'Popular Researches', 'textdomain' ),
        'all_items'                  => __( 'All Researches', 'textdomain' ),
        'parent_item'                => null,
        'parent_item_colon'          => null,
        'edit_item'                  => __( 'Edit Research', 'textdomain' ),
        'update_item'                => __( 'Update Research', 'textdomain' ),
        'add_new_item'               => __( 'Add New Research', 'textdomain' ),
        'new_item_name'              => __( 'New Research Name', 'textdomain' ),
        'separate_items_with_commas' => __( 'Separate Researches with commas', 'textdomain' ),
        'add_or_remove_items'        => __( 'Add or remove researches', 'textdomain' ),
        'choose_from_most_used'      => __( 'Choose from the most used researches', 'textdomain' ),
        'not_found'                  => __( 'No researches found.', 'textdomain' ),
        'menu_name'                  => __( 'Researches', 'textdomain' ),
    );
 
    $args = array(
        'hierarchical'          => true,
        'labels'                => $labels,
        'show_ui'               => true,
        'show_admin_column'     => true,
        'update_count_callback' => '_update_post_term_count',
        'query_var'             => true,
        'rewrite'               => array( 'slug' => 'research' ),
    );
 
    register_taxonomy( 'research', 'post', $args );
}
add_action('init', 'research_register');


/**********
function add_filter_taxonomies() {

	register_taxonomy('filter', 'portfolio', array(
		// Hierarchical taxonomy (like categories)
		'hierarchical' => true,
		// This array of options controls the labels displayed in the WordPress Admin UI
		'labels' => array(
			'name' => _x( 'Filter', 'taxonomy general name' ),
			'singular_name' => _x( 'Filter', 'taxonomy singular name' ),
			'search_items' =>  __( 'Search Filters' ),
			'all_items' => __( 'All Filters' ),
			'parent_item' => __( 'Parent Filter' ),
			'parent_item_colon' => __( 'Parent Filter:' ),
			'edit_item' => __( 'Edit Filter' ),
			'update_item' => __( 'Update Filter' ),
			'add_new_item' => __( 'Add New Filter' ),
			'new_item_name' => __( 'New Filter Name' ),
			'menu_name' => __( 'Filters' ),
		),
		// Control the slugs used for this taxonomy
		'rewrite' => array(
			'slug' => 'filter', // This controls the base slug that will display before each term
			'with_front' => false, // Don't display the category base before "/locations/"
			'hierarchical' => true // This will allow URL's like "/locations/boston/cambridge/"
		),
	));
}
add_action( 'init', 'add_filter_taxonomies', 0 );
**********/
?>
