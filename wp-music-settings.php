<?php
add_action( 'admin_init', 'wp_music_settings' );
function wp_music_settings() {
	register_setting( 'wpmusic-settings', 'wpmusic_currency' );
	register_setting( 'wpmusic-settings', 'wpmusic_no_of_music' );
}

add_action('admin_menu', 'register_my_custom_submenu_page');

function register_my_custom_submenu_page() {
  add_submenu_page( 'edit.php?post_type=wpmusic', 'Settings', 'Settings', 'manage_options', 'setting-submenu-page', 'my_custom_submenu_page_callback' ); 
}

function my_custom_submenu_page_callback() {
	echo '<div class="wrap"><div id="icon-tools" class="icon32"></div>';
		echo '<h2>WP Music Settings</h2>';
	echo '</div>';
	?>
	<form method="post" action="options.php">
	<?php settings_fields( 'wpmusic-settings' ); ?>
	<?php do_settings_sections( 'wpmusic-settings' ); ?>
		<table class="form-table">
			<tr valign="top"><th scope="row">WP Music Currency</th>
				<td><input type="text" name="wpmusic_currency" value="<?php echo get_option( 'wpmusic_currency' ); ?>"/></td>
			</tr>
			<tr valign="top"><th scope="row">Number of musics displayed per page</th>
				<td><input type="text" name="wpmusic_no_of_music" value="<?php echo get_option( 'wpmusic_no_of_music' ); ?>"/></td>
			</tr>
		</table>
	<?php submit_button(); ?>
	</form>
	<?php
}