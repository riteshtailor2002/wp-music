<?php
/*
Plugin Name: WP Music
Plugin URI: 
Description: WP Music
Author:
Version: 1.0
Author URI: 
*/

// Creating a WP Music Custom Post Type
function wp_music_custom_post_type() {
	$labels = array(
		'name'                => __( 'WP Music' ),
		'singular_name'       => __( 'WP Music'),
		'menu_name'           => __( 'WP Musics'),
		'parent_item_colon'   => __( 'Parent Music'),
		'all_items'           => __( 'All Music'),
		'view_item'           => __( 'View Music'),
		'add_new_item'        => __( 'Add New Music'),
		'add_new'             => __( 'Add New'),
		'edit_item'           => __( 'Edit Music'),
		'update_item'         => __( 'Update Music'),
		'search_items'        => __( 'Search Music'),
		'not_found'           => __( 'Not Found'),
		'not_found_in_trash'  => __( 'Not found in Trash')
	);
	$args = array(
		'label'               => __( 'music'),
		'description'         => __( 'WP Music'),
		'labels'              => $labels,
		'supports'            => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'revisions', 'custom-fields'),
		'public'              => true,
		'hierarchical'        => false,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'show_in_nav_menus'   => true,
		'show_in_admin_bar'   => true,
		'has_archive'         => true,
		'can_export'          => true,
		'exclude_from_search' => false,
	        'yarpp_support'       => true,
		//'taxonomies' 	      => array('post_tag'),
		'publicly_queryable'  => true,
		'capability_type'     => 'post',
		'register_meta_box_cb' => 'wp_music_add_metaboxes',
);
	register_post_type( 'wpmusic', $args );
}
add_action( 'init', 'wp_music_custom_post_type', 0 );

// Let us create Taxonomy for Custom Post Type
add_action( 'init', 'create_wp_music_custom_taxonomy', 0 );
 
//create a custom taxonomy name it "music_category" for your posts
function create_wp_music_custom_taxonomy() {
	$labels = array(
	'name' => _x( 'WP Music', 'taxonomy general name' ),
	'singular_name' => _x( 'WP Music', 'taxonomy singular name' ),
	'search_items' =>  __( 'Search Music Genre' ),
	'all_items' => __( 'All Music Genre' ),
	'parent_item' => __( 'Parent Music Genre' ),
	'parent_item_colon' => __( 'Parent Music Genre:' ),
	'edit_item' => __( 'Edit Music Genre' ), 
	'update_item' => __( 'Update Music Genre' ),
	'add_new_item' => __( 'Add New Music Genre' ),
	'new_item_name' => __( 'New Music Genre Name' ),
	'menu_name' => __( 'Genre' ),
	); 	

	register_taxonomy('music_genre',array('wpmusic'), array(
	'hierarchical' => true,
	'labels' => $labels,
	'show_ui' => true,
	'show_admin_column' => true,
	'query_var' => true,
	'rewrite' => array( 'slug' => 'music_genre' ),
	));
}

add_action( 'init', 'create_music_tag_taxonomies', 0 );

//create two taxonomies, genres and tags for the post type "tag"
function create_music_tag_taxonomies() 
{
  // Add new taxonomy, NOT hierarchical (like tags)
  $labels = array(
    'name' => _x( 'Music Tags', 'taxonomy general name' ),
    'singular_name' => _x( 'Music Tag', 'taxonomy singular name' ),
    'search_items' =>  __( 'Search Music Tags' ),
    'popular_items' => __( 'Popular Music Tags' ),
    'all_items' => __( 'All Music Tags' ),
    'parent_item' => null,
    'parent_item_colon' => null,
    'edit_item' => __( 'Edit Music Tag' ), 
    'update_item' => __( 'Update Music Tag' ),
    'add_new_item' => __( 'Add New Music Tag' ),
    'new_item_name' => __( 'New Music Tag Name' ),
    'separate_items_with_commas' => __( 'Separate music tag with commas' ),
    'add_or_remove_items' => __( 'Add or remove music tags' ),
    'choose_from_most_used' => __( 'Choose from the most used music tags' ),
    'menu_name' => __( 'Music Tags' ),
  ); 

  register_taxonomy('music_tag','wpmusic',array(
    'hierarchical' => false,
    'labels' => $labels,
    'show_ui' => true,
    'update_count_callback' => '_update_post_term_count',
    'query_var' => true,
    'rewrite' => array( 'slug' => 'music_tag' ),
  ));
}

/* Meta boxes */
include('wp-music-meta-boxes.php');

/* Settings Page */
include('wp-music-settings.php');

/* Template include */
add_filter( 'template_include', 'include_template_function', 1 );
function include_template_function( $template_path ) {
	if ( get_post_type() == 'wpmusic' ) {
		 if ( is_single() ) {
		 global $post;
			  // checks if the file exists in the theme first,
			  // otherwise serve the file from the plugin
			  if ( $theme_file = locate_template( array ( 'single-wpmusic.php' ) ) ) {
					$template_path = $theme_file;
					
			  } else {
					$template_path = plugin_dir_path( __FILE__ ) . '/single-wpmusic.php';
					
			  }
		 }
	}
	return $template_path;
}

/* Add shortcode */
include('wp-music-shortcode.php');