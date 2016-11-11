<?php
/**
 * Plugin Name: Custom Post Types
 * Description: Custom Post Types | GyanMatrix
 * Author: Karthik Bhat
 * Author URI: http://kart.tk
 * Version: 1.0.0
 *
 * Text Domain: gmx-cpt
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Print Restaurant Metabox.
 *
 * @param WP_Post $post Current post object.
 */
function restaurant_metabox_content( $post ) {
	$restaurants = get_posts( 'post_type=restaurant' );
	$saved_res = get_post_meta( $post->ID, 'restaurant_slug', true );

	echo '<select name="gmx-restaurant" id="gmx-restaurant">';
	foreach ( $restaurants as $res ) {
		printf(
			'<option value="%1$s" %2$s>%3$s</option>',
			esc_attr( $res->post_name ),
			selected( $saved_res, $res->post_name, false ),
			esc_attr( $res->post_title )
		);
	}
	echo '</select>';
	wp_nonce_field( 'add_res', 'res_nonce' );
}

/**
 * Add CPT restaurant as metabox.
 */
function add_restaurant_metabox() {
	add_meta_box( 'cpt_restaurant', 'Restaurant', 'restaurant_metabox_content', null, 'side' );
}

/**
 * Create Custom Post Types.
 */
function create_custom_post_types() {
	// Define custom post type labels.
	$restaurant_labels = array(
		'name' => __( 'Restaurants', 'gmx-cpt' ),
		'singular_name' => __( 'Restaurant', 'gmx-cpt' ),
		'add_new' => __( 'Add Restaurant', 'gmx-cpt' ),
		'add_new_item' => __( 'Add New Restaurant', 'gmx-cpt' ),
		'edit_item' => __( 'Edit Restaurant', 'gmx-cpt' ),
	);

	$food_labels = array(
		'name' => __( 'Food', 'gmx-cpt' ),
		'singular_name' => __( 'Food', 'gmx-cpt' ),
		'add_new' => __( 'Add Food', 'gmx-cpt' ),
		'add_new_item' => __( 'Add New Food Item', 'gmx-cpt' ),
		'edit_item' => __( 'Edit Food', 'gmx-cpt' ),
	);

	// Register restaurant post type.
	register_post_type( 'restaurant',
		array(
			'labels' => $restaurant_labels,
			'public' => true,
			'has_archive' => true,
			'rewrite' => array( 'slug' => 'restaurant' ),
			'menu_icon' => 'dashicons-store',
			'taxonomies' => array( 'category', 'post_tag' ),
		)
	);

	// Register food post type.
	register_post_type( 'food',
		array(
			'labels' => $food_labels,
			'public' => true,
			'has_archive' => true,
			'rewrite' => array( 'slug' => 'food' ),
			'menu_icon' => 'dashicons-chart-pie',
			'register_meta_box_cb' => 'add_restaurant_metabox',
		)
	);
}

/**
 * Register custom post types and Reload rewrite rules on activation.
 */
function gmx_cpt_activate() {
	create_custom_post_types();
	flush_rewrite_rules();
}

/**
 * Save food post meta.
 *
 * @param int     $post_id  Post ID.
 */
function save_food_postmeta( $post_id ) {
	// If this isn't a 'food' post, don't update it.
	$post_type = get_post_type( $post_id );
	if ( 'food' !== $post_type ) {
		return;
	}

	if ( ! isset( $_POST['res_nonce'] ) || ! wp_verify_nonce( $_POST['res_nonce'], 'add_res' ) ) {
		return;
	}

	if ( isset( $_POST['gmx-restaurant'] ) ) {
		update_post_meta( $post_id, 'restaurant_slug', sanitize_text_field( $_POST['gmx-restaurant'] ) );
	}
}

include_once( plugin_dir_path( __FILE__ ) . 'food-template.php' );

// Invoke rewrite rule flusher upon activation.
register_activation_hook( __FILE__, 'gmx_cpt_activate' );

// Add thumbnail support for custom post types.
add_post_type_support( 'restaurant', array( 'thumbnail', 'author' ) );
add_post_type_support( 'food', array( 'thumbnail', 'author' ) );

// Invoke custom post type creation on init.
add_action( 'init', 'create_custom_post_types', 10 );

// Invoke save food meta on save_post.
add_action( 'save_post', 'save_food_postmeta', 10 );
