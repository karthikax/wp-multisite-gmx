<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Adds Restaurant Meta content to food Post.
 *
 * @param  string   $content    Content.
 * @return string               Content with Restaurant meta.
 */
function add_restaurant_template( $content ) {
	global $post;
	if ( 'food' !== $post->post_type ) {
		return $content;
	}

	$res_slug = get_post_meta( $post->ID, 'restaurant_slug', true );
	$args = array(
		'name'          => $res_slug,
		'post_type'     => 'restaurant',
	);
	$posts = get_posts( $args );
	$res = isset( $posts[0] ) ? $posts[0] : false;

	$template = '<div class="restaurant-data">';

	if ( $res ) {
		$template .= '<h3>' . $res->post_title . '</h3>';
		$template .= '<p>' . $res->post_content . '</p>';
	}

	$template .= '</div>';

	/**
	 * food_restaurant_meta_content filter.
	 *
	 * @param   string  $template   Content with Restaurant Meta.
	 * @param   string  $content    Original Content.
	 */
	$template = apply_filters( 'food_restaurant_meta_content', $template, $content );
	$content .= $template;

	return $content;
}

add_filter( 'the_content', 'add_restaurant_template', 10 );
