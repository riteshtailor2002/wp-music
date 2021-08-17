<?php
 /*Template Name: WP Music
 */
 
get_header();
$post_id = $post->ID;
$post_title = $post->post_title;
$composer_name = get_post_meta( $post->ID, 'composer_name', true );
$music_publisher = get_post_meta( $post->ID, 'music_publisher', true );
$year_of_recording = get_post_meta( $post->ID, 'year_of_recording', true );
$additional_contributors = get_post_meta( $post->ID, 'additional_contributors', true );
$music_url = get_post_meta( $post->ID, 'music_url', true );
$music_price = get_post_meta( $post->ID, 'music_price', true );
$currnecy = get_option('wpmusic_currency');
echo'<h1>Single Page Music Template</h1>';

echo'<h2>'.$post_title.'</h2>';
echo'<h4>Composer Name: '.$composer_name.'</h4>';
echo'<h4>Music Publisher: '.$music_publisher.'</h4>';
echo'<h4>Year Of Recording: '.$year_of_recording.'</h4>';
echo'<h4>Additional Contributors: '.$additional_contributors.'</h4>';
echo'<h4>Music Url: '.$music_url.'</h4>';
echo'<h4>Music Price: '.$currnecy.''.$music_price.'</h4>';
//include('template-customerorderflow.php');
get_footer(); ?>