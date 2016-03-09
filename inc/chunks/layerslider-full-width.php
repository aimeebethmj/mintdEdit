<div id="layerslider" class="pipdig-ls-full-width nopin" style="width: 100%; height: 420px;">

	<?php
	$delay = get_theme_mod('header_full_width_slider_delay', '4000');
	$transiton = get_theme_mod('header_full_width_slider_transition', '5');
	//if ( false === ( $the_query = get_transient( 'pipdig_full_width_slider' ) ) ) {
		$post_cat = get_theme_mod('header_full_width_slider_post_category');
		$num_posts = get_theme_mod('header_full_width_slider_posts', '3');
		$args = array(
			'showposts' => $num_posts,
			//'meta_key' => '_thumbnail_id',
			'cat' => $post_cat,
		);
		$the_query = new WP_Query( $args );
		//set_transient( 'pipdig_full_width_slider', $the_query, 24 * HOUR_IN_SECONDS );
	//}
	while ($the_query -> have_posts()) : $the_query -> the_post();
	
		if (function_exists('rwmb_meta')) {
			$images = rwmb_meta( 'pipdig_meta_slider_image', 'type=image&size=full' );
			if ($images){ // if an image has been added via meta box
				foreach ( $images as $image )
				{
					$bg = esc_url($image['url']);
				}
			} else { // if no meta box image, use featured as fallback
				if(has_post_thumbnail()){
					$thumb = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full' );
					$bg = esc_url($thumb['0']);
				} else { // what? No featured image?  Let's use the first from post
					$bg = pipdig_catch_that_image();
				}
			}
		} else { // meta box plugin not active, use featured as fallback
			if(has_post_thumbnail()){
				$thumb = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full' );
				$bg = esc_url($thumb['0']);
			} else { // what? No featured image?  Let's use the first from post
				$bg = pipdig_catch_that_image();
			}
		}
		
	?>

		<!-- Slide -->
		<div class="ls-slide" data-ls="transition2d: <?php echo $transiton; ?>; slidedelay: <?php echo $delay; ?>">
			<?php //the_post_thumbnail( 'full', array('class' => 'ls-bg') );?>
			<img alt="" class="ls-bg" src="<?php echo $bg; ?>" />
			<div class="ls-l layerslider-overlay" data-ls="offsetxin: 0; offsetxout: 0; offsetyin: 0; offsetyout: 25; easingout: easeInBack;" style="top: 50%; left: 50%; text-align: center;">
			<h3><?php $title = get_the_title(); echo pipdig_truncate($title, 8); ?></h3>
			<?php if(get_theme_mod('header_full_width_slider_cat')) { ?><span class="pipdig-slider-cats"><?php _e( 'Posted in:', 'pipdig-textdomain' ); ?><?php $category = get_the_category(); if ($category) { echo '&nbsp;<a href="' . get_category_link( $category[0]->term_id ) . '">' . $category[0]->name.'</a>';} ?></span><?php } //end if ?>
			<?php if(get_theme_mod('header_full_width_slider_excerpt')) { ?><p><?php $excerpt = get_the_excerpt(); echo pipdig_truncate($excerpt, 8); ?></p> <?php } //end if ?>
			<a href="<?php echo get_permalink(); ?>" class="read-more"><?php _e('View Post', 'pipdig-textdomain'); ?></a>
			</div>
		</div>

	<?php endwhile;?>

</div>