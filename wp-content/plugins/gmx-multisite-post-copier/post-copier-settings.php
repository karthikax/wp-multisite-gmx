<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Post copier settings page.
 */
function post_cloner_settings_page() {
	if ( ! current_user_can( 'manage_options' ) ) {
		wp_die( 'You do not have sufficient permissions to access this page.' );
	}
	?>
	<div class="wrap">
		<h1>Multisite Post Cloner Settings</h1>
		<form method="post" action="options.php">
			<?php settings_fields( 'mpc' ); ?>
			<?php do_settings_sections( 'mpc' ); ?>
			<table class="form-table">
				<tr>
					<th scope="row">Post Cloner</th>
					<td>
						<label for="mpc">
							<input name="enable_post_clone" id="mpc" type="checkbox" <?php checked( get_option( 'enable_post_clone' ), 1 ); ?>>
							Enable post cloning?
							<p>Check to enable & Un-check to disable post copying to child site.</p>
						</label>
					</td>
				</tr>
			</table>
			<?php submit_button(); ?>
		</form>
	</div>
<?php }

/**
 * Process cloner settings data.
 *
 * @param   int $input  Post input.
 * @return  int         Processed data.
 */
function process_post_clone_setting( $input ) {
	if ( $input || 'on' === $input ) {
		return 1;
	}
	return 0;
}

/**
 * Register cloner settings.
 */
function register_post_copier_settings() {
	//register our settings.
	register_setting( 'mpc', 'enable_post_clone', 'process_post_clone_setting' );
}

/**
 * Creates post cloner options menu.
 */
function post_copier_menu() {
	if ( ! is_main_site() ) {
		return;
	}

	add_options_page(
		'Post Cloner Settings',
		'Post Cloner',
		'manage_options',
		'mpc',
		'post_cloner_settings_page'
	);
}

add_action( 'admin_menu', 'post_copier_menu' );
add_action( 'admin_init', 'register_post_copier_settings' );
