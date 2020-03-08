<?php

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

