<?php
/**
 * Plugin Name: Multisite Post Copier
 * Description: Multisite Post Copier | GyanMatrix
 * Author: Karthik Bhat
 * Author URI: http://kart.tk
 * Version: 1.0.0
 *
 * Text Domain: gmx-mpc
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Get cloned post by parent post
 *
 * @param   WP_Post $post   Parent post object.
 * @return  mixed           Cloned post or false.
 */
function gmx_get_cloned_post( $post ) {
	$args = array(
		'name'          => $post->post_name,
		'post_status'   => $post->post_status,
		'post_type'     => $post->post_type,
	);

	$posts = get_posts( $args );
	if ( $posts ) {
		return $posts[0];
	}
	return false;
}

/**
 * Clone current post to child sites.
 *
 * @param int       $post_id    Post id.
 * @param WP_Post   $post       Post object.
 */
function multisite_copy_post( $post_id, $post ) {
	if ( ( 'auto-draft' === $post->post_status ) || ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) ) {
		return;
	}

	// Apply cloning only for main site.
	if ( ! is_main_site() ) {
		return;
	}

	// Clone only if enabled in settings.
	if ( ! get_option( 'enable_post_clone' ) ) {
		return;
	}

	$metas = get_post_meta( $post_id );
	$sites = get_sites();

	foreach ( $sites as $site ) {
		if ( ! is_main_site( $site->id ) ) {
			switch_to_blog( $site->id );

			$child_post = gmx_get_cloned_post( $post );

			// If child post exists assign the id.
			if ( isset( $child_post->ID ) ) {
				$post->ID = $child_post->ID;
			} else {
				$post->ID = 0;
			}

			// Create or update post.
			$clone_id = wp_insert_post( (array) $post );

			// Update post metas.
			foreach ( $metas as $key => $meta ) {
				if ( 0 !== strpos( $key, '_' ) ) {
					update_post_meta( $clone_id, $key, $meta[0] );
				}
			}

			// Set cloned flag.
			update_post_meta( $clone_id, 'cloned', true );

			restore_current_blog();
		}
	}
}

/**
 * Check if a post is cloned post.
 *
 * @param int   $id Post id to check.
 * @return bool Whether cloned post.
 */
function is_cloned_post( $id ) {
	return (bool) get_post_meta( $id, 'cloned', true );
}

/**
 * Remove edit link from admin bar for cloned posts.
 *
 * @param WP_Admin_Bar  $admin_bar  Admin bar object.
 */
function remove_cloned_post_edit( $admin_bar ) {
	global $post;
	if ( null !== $post && is_cloned_post( $post->ID ) ) {
		$admin_bar->remove_node( 'edit' );
	}
}

/**
 * Removes post edit actions for cloned posts.
 *
 * @param array     $actions    Edit post actions.
 * @param WP_Post   $post       Current Post.
 *
 * @return mixed
 */
function remove_cloned_post_actions( $actions, $post ) {
	$cloned = get_post_meta( $post->ID, 'cloned', true );
	if ( $cloned ) {
		foreach ( $actions as $action => $val ) {
			if ( 'view' !== $action ) {
				unset( $actions[ $action ] );
			}
		}

		// Show non editable information.
		$actions['info'] = '<span>Non Editable</span>';
	}
	return $actions;
}

/**
 * Disables editing of cloned posts.
 */
function disable_cloned_post_edit() {
	global $pagenow;

	if ( 'post.php' !== $pagenow ) {
		return;
	}

	$id = $_GET['post'];

	// If editing cloned post redirect to view post.
	if ( is_cloned_post( $id ) ) {
		$location = get_post_permalink( $id );
		wp_safe_redirect( $location );
		exit;
	}
}

include_once( plugin_dir_path( __FILE__ ) . 'post-copier-settings.php' );

add_filter( 'post_row_actions', 'remove_cloned_post_actions', 10, 2 );
add_action( 'save_post', 'multisite_copy_post', 10, 2 );
add_action( 'admin_bar_menu', 'remove_cloned_post_edit', 999 );
add_action( 'admin_init', 'disable_cloned_post_edit', 999 );
