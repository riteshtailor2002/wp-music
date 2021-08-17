<?php
add_shortcode( 'wp_music_list', 'wp_music_list_shortcode' );

function wp_music_list_shortcode( $atts ) {
    $a = shortcode_atts( array(
        'year' => '2017',
        'genre' => 'hiphop',
    ), $atts );
    $term = get_term_by( 'name',  $a['genre'],  'music_genre'  );
    
    $per_page = get_option('wpmusic_no_of_music');
    $args = array( 
        'post_type' => 'wpmusic',
        'post_status' => 'publish',
        'orderby' => 'date',
        'order'   => 'DESC',
        'posts_per_page' => $per_page,
        'paged' =>get_query_var( 'paged' ),
        'tax_query'=> array ( 
            'relation' => 'AND',
            array(
                'taxonomy' => 'music_genre',
                'terms' => array($term->slug),
                'field' => 'slug'
            )
        ),
        'relation' => 'AND',
        'meta_query' => array(
            array(
                'key'     => 'year_of_recording',
                'value'   => $a['year'],
            ),
        ),
    );
$loop = new WP_Query( $args );

if ( $loop->have_posts() ) {
    while ( $loop->have_posts() ) : $loop->the_post();
    $post_id = $loop->post->ID;
    $post_title = $loop->post->post_title;
    $permalink = get_permalink($post_id);
    echo'<h3><a href="'.$permalink.'">'.$post_title.'</a></h3>';
    endwhile;
    $big = 999999999; // need an unlikely integer
    echo paginate_links( array(
        'base' => str_replace( $big, '%#%', get_pagenum_link( $big ) ),
        'format' => '?paged=%#%',
        'current' => max( 1, get_query_var('paged') ),
        'total' => $loop->max_num_pages
    ) );
}else{
    echo'<h3>No Music Available</h3>';
}    
    // Reset Post Data
wp_reset_postdata();

}