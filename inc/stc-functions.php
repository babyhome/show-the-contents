<?php

/**
 * Function to get 'stc_list_post' shortcode design
 * 
 * @since 1.0.0
 */

function stc_post_designs() {
	$design_array 	= [
		'design-1' 		=> __( 'Design 1', 'stc' ),
		'design-2' 		=> __( 'Design 2', 'stc' )
	];

	return apply_filters( 'stc_post_designs', $design_array );

}


/**
 * Function to get post featured image
 */
function stc_get_featured_image( $post_id = '', $size = 'full', $default_img = false ) {

	$size 	= !empty( $size ) ? $size : 'full';
	$image 	= wp_get_attachment_image_src( get_post_thumbnail_id( $post_id ), $size );

	if( !empty( $image ) ) {
		$image 	= isset( $image[0] ) ? $image[0] : '';
	}
	
	return $image;

}


/**
 * Pagination function for grid
 */
function stc_pagination( $args = array() ) {

	$big 	= 999999999;

	$paging 	= apply_filters( 'stc_post_paging_args', array(
			'base' 		=> str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
			'format' 	=> '?paged=%#%',
			'current' 	=> max( 1, $args['paged'] ),
			'total' 	=> $args['total'],
			'prev_next' 	=> true,
			'prev_next' 	=> __( "<< Previous", 'stc' ),
			'next_next' 	=> __( 'Next >>', 'stc' )
	) );

	echo paginate_links( $paging );
}


function stc_get_post_excerpt( $post_id = null, $content = '', $word_length = 55, $more = '...' ) {

	$has_excerpt 	= false;
	$word_length 	= !empty( $word_length ) ? $word_length : 55;

	if( !empty( $post_id ) ) {
		if( has_excerpt( $post_id ) ) {
			$has_excerpt 	= true;
			$content 		= get_the_excerpt();
		} else {
			$content 	= !empty( $content ) ? $content : get_the_content();
		}
	}

	if( !empty( $content ) && ( !$has_excerpt ) ) {
		$content 	= strip_shortcodes( $content );
		$content 	= wp_trim_words( $content, $word_length, $more );
	}

	return $content;
}


function stc_get_unique() {
	static $unique 	= 0;
	$unique++;

	return $unique;
}



