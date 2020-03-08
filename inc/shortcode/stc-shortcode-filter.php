<?php

if( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_shortcode( 'stc_list_filter', 'stc_list_filter_shortcode' );

function stc_list_filter_shortcode( $atts, $content ) {

	$atts 	= shortcode_atts(
		array(
			'cat_id' 						=> '',
			'include_cat_child'				=> 'true',		
			'order'							=> 'DESC',
			'orderby'						=> 'date',
			'grid' 							=> '3',		
			'media_size' 					=> 'large',
			'show_date' 					=> 'true',
			'show_category_name' 			=> 'true',
			'show_author' 					=> 'true',
			'image_height' 					=> '',
			'design'						=> 'style-1',		
			'content_words_limit' 			=> '20',
			'show_read_more'        		=> 'true',
			'content_tail'					=> '...',
			'cat_limit'						=> 0,
			'cat_order'						=> 'asc',
			'image_fit' 					=> 'true',		
			'cat_orderby'					=> 'name',
			'exclude_cat'					=> array(),
			'show_comments'					=> 'true',
			'show_content' 					=> 'true',
			'all_filter_text'				=> '',
		),
		$atts,
		'stc_list_filter' );














	
	$shortcode_designs 	= stc_post_designs();
	$unique 			= stc_get_unique();

	$cat_id 			= !empty( $atts['cat_id'] ) ? explode( ',', $atts['cat_id'] ) : '';
	$include_cat_child 	= ( $atts['include_cat_child'] == 'false' ) ? false : true;

	$limit 				= !empty( $atts['limit'] ) ? $atts['limit'] : '12';
	$order 				= ( strtolower( $atts['order'] ) == 'asc' ) ? 'ASC' : 'DESC';
	$orderby 			= !empty( $atts['orderby'] ) ? $atts['orderby'] : 'date';
	$gridcol 			= !empty( $atts['grid'] ) ? $atts['grid'] : '3';
	$design 			= array_key_exists( trim( $atts['design'] ), $shortcode_designs ) ? $atts['design'] : 'style-1';
	$words_limit 		= !empty( $atts['content_words_limit'] ) ? $atts['content_words_limit'] : 20;
	$content_tail 		= html_entity_decode( $atts['content_tail'] );
	$show_read_more 	= ( $show_read_more == 'true' ) ? false : true;
	
	$show_author 		= ( $atts['show_author'] == 'false' ) ? false : true;
	$media_size 		= !empty( $atts['media_size'] ) ? $atts['media_size'] : 'large'; 	//thumbnail, medium, large, full
	$show_date 			= ( $atts['show_date'] == 'false' ) ? false : true;
	$show_category 		= ( $atts['show_category_name'] == 'false' ) ? false : true;
	$image_height 		= !empty( $atts['image_height'] ) ? $atts['image_height'] : '';
	$height_css 		= $atts['image_height'] ? 'height:' . $atts['image_height'] . 'px;' : '';
	$cat_limit 			= !empty( $atts['cat_limit'] ) ? $atts['cat_limit'] : 0;
	$cat_order 			= ( strtolower( $atts['cat_order'] ) == 'asc' ) ? 'ASC' : 'DESC';
	$cat_orderby 		= !empty( $atts['cat_orderby'] ) ? $atts['cat_orderby'] : 'name';
	$exclude_cat 		= !empty( $atts['exclude_cat'] ) ? explode( ',', $atts['exclude_cat'] ) : [];
	$image_fit			= ( $atts['image_fit'] == 'false' ) ? 0 : 1;
	$show_comments 		= ( $atts['show_comments'] == 'false' ) ? false	: true;
	$show_content 		= ( $atts['show_content'] == 'false' ) ? false : true;
	$all_filter_text 	= !empty( $atts['all_filter_text'] ) ? $atts['all_filter_text'] : __( 'All', 'stc' );

	// not finished yet




	return "this shortcode filter";

}
