<?php
/* Meta box setup function. */
function wp_music_add_metaboxes() {

	add_meta_box(
		'wp_music_composer_name',
		'Composer Name',
		'wp_music_composer_name',
		'wpmusic',
		'normal',
		'default'
	);

	add_meta_box(
		'wp_music_publisher',
		'Publisher Name',
		'wp_music_publisher',
		'wpmusic',
		'normal',
		'high'
	);

	add_meta_box(
		'wp_music_year_recording',
		'Year of Recording',
		'wp_music_year_recording',
		'wpmusic',
		'normal',
		'high'
	);

	add_meta_box(
		'wp_music_additional_contributors',
		'Additional Contributors',
		'wp_music_additional_contributors',
		'wpmusic',
		'normal',
		'high'
	);

	add_meta_box(
		'wp_music_url',
		'Music Url',
		'wp_music_url',
		'wpmusic',
		'normal',
		'high'
	);

	add_meta_box(
		'wp_music_price',
		'Music Price',
		'wp_music_price',
		'wpmusic',
		'normal',
		'high'
	);

}

function wp_music_composer_name() {
	global $post;
	wp_nonce_field( basename( __FILE__ ), 'wpmusic_fields' );
	$composer_name = get_post_meta( $post->ID, 'composer_name', true );
	echo '<input type="text" name="composer_name" value="' . esc_textarea( $composer_name )  . '" class="widefat">';
}

function wp_music_publisher() {
	global $post;
	wp_nonce_field( basename( __FILE__ ), 'wpmusic_fields' );
	$music_publisher = get_post_meta( $post->ID, 'music_publisher', true );
	echo '<input type="text" name="music_publisher" value="' . esc_textarea( $music_publisher )  . '" class="widefat">';
}

function wp_music_year_recording() {
	global $post;
	wp_nonce_field( basename( __FILE__ ), 'wpmusic_fields' );
	$year_of_recording = get_post_meta( $post->ID, 'year_of_recording', true );
	echo '<input type="text" name="year_of_recording" value="' . esc_textarea( $year_of_recording )  . '" class="widefat">';
}

function wp_music_additional_contributors() {
	global $post;
	wp_nonce_field( basename( __FILE__ ), 'wpmusic_fields' );
	$additional_contributors = get_post_meta( $post->ID, 'additional_contributors', true );
	echo '<input type="text" name="additional_contributors" value="' . esc_textarea( $additional_contributors )  . '" class="widefat">';
}

function wp_music_url() {
	global $post;
	wp_nonce_field( basename( __FILE__ ), 'wpmusic_fields' );
	$music_url = get_post_meta( $post->ID, 'music_url', true );
	echo '<input type="text" name="music_url" value="' . esc_textarea( $music_url )  . '" class="widefat">';
}

function wp_music_price() {
	global $post;
	wp_nonce_field( basename( __FILE__ ), 'wpmusic_fields' );
	$music_price = get_post_meta( $post->ID, 'music_price', true );
	echo '<input type="text" name="music_price" value="' . esc_html( $music_price )  . '" class="widefat">';
}

function wp_music_save_meta( $post_id, $post ) {

	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return $post_id;
	}

	if ( ! isset( $_POST['composer_name'] ) || ! isset( $_POST['music_publisher'] ) || ! isset( $_POST['year_of_recording'] ) || ! isset( $_POST['additional_contributors'] ) || ! isset( $_POST['music_url'] ) || ! isset( $_POST['music_price'] ) || ! wp_verify_nonce( $_POST['wpmusic_fields'], basename(__FILE__) ) ) {
		return $post_id;
	}

	$wpmusic_meta['composer_name'] = esc_textarea( $_POST['composer_name'] );
	$wpmusic_meta['music_publisher'] = esc_textarea( $_POST['music_publisher'] );
	$wpmusic_meta['year_of_recording'] = esc_textarea( $_POST['year_of_recording'] );
	$wpmusic_meta['additional_contributors'] = esc_textarea( $_POST['additional_contributors'] );
	$wpmusic_meta['music_url'] = esc_textarea( $_POST['music_url'] );
	$wpmusic_meta['music_price'] = esc_textarea( $_POST['music_price'] );

	foreach ( $wpmusic_meta as $key => $value ) :

		if ( 'revision' === $post->post_type ) {
			return;
		}

		if ( get_post_meta( $post_id, $key, false ) ) {
			update_post_meta( $post_id, $key, $value );
		} else {
			add_post_meta( $post_id, $key, $value);
		}

		if ( ! $value ) {
			delete_post_meta( $post_id, $key );
		}

	endforeach;

}
add_action( 'save_post', 'wp_music_save_meta', 1, 2 );