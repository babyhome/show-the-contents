<?php

if( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_shortcode( 'stc_list_post', 'stc_list_post_shortcode' );

function stc_list_post_shortcode( $atts, $content ) {

	$atts 	= shortcode_atts(
			array(
				'post_type' 				=> 'post',
				'limit' 					=> '12',
				'cat' 						=> 'category',
				'cat_id' 					=> '',
				'include_cat_child' 		=> 'true',
				'order' 					=> 'DESC',
				'orderby' 					=> 'date',
				'grid' 						=> '3',
				'image_fit' 				=> 'true',
				'media_size' 				=> 'large',
				'show_date' 				=> 'true',
				'show_category_name' 		=> 'true',
				'show_author' 				=> 'true',
				'image_height' 				=> '',
				'design'					=> 'style-1',		
				'content_words_limit' 		=> '20',
				'show_read_more'        	=> 'true',
				'content_tail'				=> '...',
				'pagination' 				=> 'true',
				'pagination_type'			=> 'numeric',
				'show_comments'				=> 'true',
				'show_content' 				=> 'true',
			),
			$atts,
			'stc_list_post' );



	$shortcode_designs 		= stc_post_designs();
	
	$post_type 				= !empty( $atts['post_type'] ) ? trim( $atts['post_type'] ) : 'post';
	$limit 					= !empty( $atts['limit'] ) ? intval( $atts['limit'] ) : 12;

	$cat 					= !empty( $atts['cat'] ) ? sanitize_text_field( $atts['cat'] ) : 'category';
	$cat_id 				= !empty( $atts['cat_id'] ) ? explode( ',', $atts['cat_id'] ) : '';
	$include_cat_child 		= ( $atts['include_cat_child'] == 'false' ) ? false : true;

	$order 					= !empty( strtolower( $order ) == 'asc' ) ? 'ASC' : 'DESC';
	$orderby 				= !empty( $atts['orderby'] ) ? $atts['orderby'] : 'date';
	$column 				= !empty( $atts['grid'] ) ? $atts['grid'] : '1';
	$design 				= array_key_exists( trim( $atts['design'] ), $shortcode_designs ) ? $atts['design'] : 'style-1';
	
	$words_limit 			= !empty( $atts['content_words_limit'] ) ? $atts['content_words_limit'] : 20;

	$content_tail 			= html_entity_decode( $atts['content_tail'] );
	$show_read_more 		= ( $atts['show_read_more'] == 'false' ) ? false : true;

	$show_author 			= ( $atts['show_author'] == 'false' ) ? false : true;
	$media_size 			= !empty( $atts['media_size'] ) ? $atts['media_size'] : 'large';
	$show_date 				= ( $atts['show_date'] == 'false' ) ? false : true;
	$show_category 			= ( $atts['show_category_name'] == 'false' ) ? false : true;
	$image_height 			= !empty( $atts['image_height'] ) ? $atts['image_height'] : '';
	$height_css 			= !empty( $image_height ) ? 'height:'.$image_height . 'px' : '';
	$pagination 			= ( $atts['pagination'] == 'false' ) ? false : true;
	$pagination_type 		= ( $atts['pagination_type'] == 'prev-next' ) ? 'prev-next' : 'numeric';
	
	$image_fit 				= ( $atts['image_fit'] == 'false' ) ? 0 : 1;
	$show_comments 			= ( $atts['show_comments'] == 'false' ) ? 'false' : 'true';
	$show_content 			= ( $atts['show_content'] == 'false' ) ? false : true;

	// Shortcode file
	// $file_path 				= STC_DIR  . '/templates/' . $design . '.php';
	// $design_file 			= ( file_exists( $file_path ) ) ? $file_path : '';

	global $post, $paged;
	$count 					= 0;
	$image_fit_class 		= ( $image_fit ) ? 'stc-image-fit' : '';

	if( is_home() || is_front_page() ) {
		$paged 	= get_query_var( 'page' );
	} else {
		$paged 	= get_query_var( 'paged' );
	}


	// arguments
	$args 		= array(
		'post_type' 			=> $post_type,
		'post_status' 			=> array( 'publish' ),
		'post_per_page' 		=> $limit,
		'order' 				=> $order,
		'orderby' 				=> $orderby,
		'ignore_sticky_posts' 	=> true,
		'paged' 				=> $paged
	);

	// category
	if( !empty( $cat_id ) ) {
		$args['tax_query'] 		= array(
				array(
					'taxonomy' 			=> $cat,
					'field' 			=> 'term_id',
					'terms' 			=> $cat_id,
					'include_children' 	=> $include_cat_child
				)
		);
	}

	// WP Query
	$lists 			= new WP_Query( $args );
	$post_count 	= $lists->post_count;

	ob_start();

	if( $lists->have_posts() ) {
		?>

		<div id="stc-main" class="stc-container stc-grid-main <?php echo 'stc-' . $design . ' ' . $image_fit_class; ?> stc-grid-<?php echo $column; ?> stc-clearfix" >
			<?php
			while( $lists->have_posts() ) :
				$lists->the_post();

				$count++;
				$cat_links 				= [];
				$css_class 				= '';
				$post_featured_image 	= stc_get_featured_image( $post->ID, $media_size, true );
				$post_link 				= !empty( $post->ID ) ? get_permalink( $post->ID ) : '';

				$terms 					= get_the_terms( $post->ID, $cat );
				$comments 				= get_comments_number( $post->ID );
				$reply 					= ( $comments <= 1 ) ? 'Reply' : 'Replies';

				if( $terms ) {
					foreach( $terms as $term ) {
						$term_link 		= get_term_link( $term );
						$cat_links[] 	= '<a href="' . esc_url( $term_link ) . '">' . $term->name . '</a>';
					}
				}
				$cate_name 		= join( " ", $cat_links );

				if( ( is_numeric( $grid ) && ( $grid > 0 ) && ( 0 == ( $count - 1 ) % $grid ) ) || 1 == $count ) {
					$css_class 	.= ' stc-first';
				}

				if( ( is_numeric( $grid ) && ( $grid > 0 ) && ( 0 == $count % $grid ) ) || $post_count == $count ) {
					$css_class 	.= ' stc-last';
				}

				// include shortcode html filecs
				// if( $design_file ) {
				// 	include( $design_file );
				// }

				if( $column == '2' ) {
					$cols 	= '6';
				} elseif( $column == '3' ) {
					$cols 	= '4';
				} elseif( $column == '4' ) {
					$cols 	= '3';
				} elseif( $column == '5' ) {
					$cols 	= 'c5';
				} elseif( $column == '1' ) {
					$cols 	= '12';
				} else {
					$cols 	= '12';
				}

				?>

				<div class="stc-post-grid stc-medium-<?php echo $cols ?> stc-columns <?php echo $css_class ?>">
					<div class="stc-post-content <?php if( !has_post_thumbnail() ) { echo 'no-thumb-image'; } ?>">
						<?php
						if( has_post_thumbnail() ) {
							?>
							<div class="stc-post-image-bg" style="<?php echo $height_css; ?>">
								<a href="<?php echo $post_link; ?>"><img src="<?php echo $post_featured_image; ?>" alt="<?php the_title(); ?>" /></a>
							</div>
							<?php
						}
						?>

						<h2 class="stc-post-title">
							<a href="<?php echo $post_link; ?>"><?php the_title(); ?></a>
						</h2>

						<?php if( $show_category === true && $cate_name != '' ) { ?>
							<div class="stc-post-categories">
								<?php echo $cate_name; ?>
							</div>
						<?php } 
						
						if( $show_date === true || $show_author === true || $show_comments === true ) {
							?>
							<div class="stc-post-date">
								<?php if( $show_author === true ) { ?>
									<span class="stc-user-img"><i class="fas fa-user-alt"></i> <?php the_author(); ?></span>
								<?php } 
								
								echo ( $show_author === true && $show_date === true ) ? '&nbsp;' : '';

								if( $show_date === true ) {
									?>
									<span class="stc-time"><i class="fas fa-calendar-alt"></i> <?php echo get_the_date(); ?></span>
									<?php
								}

								echo ( $show_author === true && $show_date === true && $show_comments === true ) ? '&nbsp;' : '';

								if( !empty( $comments ) && $show_comments === true ) {
									?>
									<span class="stc-post-comments">
										<i class="fas fa-comment"></i><a href="<?php the_permalink(); ?>#comments"><?php echo $comments . ' ' . $reply; ?></a>
									</span>

									<?php
								}
								?>
							</div>
							<?php
						}
						
						if( $show_content === true ) {
							?>
							<div class="stc-post-content-detail">
								<div class="stc-post-short-content"><?php echo stc_get_post_excerpt( $post->ID, get_the_content(), $words_limit, $content_tail ); ?></div>
								<?php
								if( $show_read_more === true ) {
									?>
									<a href="<?php echo $post_link; ?>" class="readmorebtn"><?php _e( 'Read More', 'stc' ); ?></a>

									<?php
								}
								?>
							</div>
							<?php
						}
						?>
					</div>
				</div>



				<?php
			endwhile;

			?>
		</div>

		<?php

		if( $pagination === false ) {
			?>
			<div class="stc-post-pagination stc-clearfix">
				<?php 
				if( $pagination_type == "numeric" ) {
					echo stc_pagination( array( 'paged' => $paged, 'total' => $lists->max_num_pages ) );
				} else {
					?>
					<div class="button-post-p"><?php next_post_link( ' Next >>', $lists->max_num_pages ); ?></div>
					<div class="button-post-n"><?php previous_posts_link( '<< Previous' ); ?></div>
					<?php
				}
				?>
			</div>

			<?php
		}

	} // end have_posts()

	wp_reset_postdata();

	$content .= ob_get_clean();

	return $content;

}











