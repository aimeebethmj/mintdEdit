<div id="pipdig-top-slider" class="nopin">
	<div id="pipdig-top-slider-content">
	<ul class="bxslider">
	
	<?php
		//wp_enqueue_script('bxslider');
		$post_cat = get_theme_mod('top_slider_category');
		$exclude_post_cat = get_theme_mod('top_slider_category_exclude');
		if (!empty($exclude_post_cat)) {
			$post_cat .= ',-'.$exclude_post_cat;
		}
		$num_posts = get_theme_mod('top_slider_posts', 4);
		$args = array(
			'showposts' => $num_posts,
			'cat' => $post_cat,
		);
		$the_query = new WP_Query( $args );

	while ($the_query -> have_posts()) : $the_query -> the_post();
		if(has_post_thumbnail()){
			$thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'full' );
			$bg = esc_url($thumb['0']);
		} else {
			$bg = pipdig_catch_that_image();
		}
	?>
	
		<li>
	
			<div class="top-slider-section" style="background-image:url(<?php echo $bg; ?>);">
			
				<div class="top-slider-overlay">
					<div class="top-slider-overlay-inner">
						
						<div class="post-header">
							
							<h2><a href="<?php echo get_permalink(); ?>"><?php $title = get_the_title(); echo pipdig_truncate($title, 11); ?></a></h2>
						
							<?php if(get_theme_mod('top_slider_cat', 1)) { ?><span class="pipdig-slider-cats">Posted in: <?php $category = get_the_category(); if ($category) { echo '<a href="' . get_category_link( $category[0]->term_id ) . '">' . $category[0]->name.'</a> ';} ?></span><?php } //end if ?>
							
							<a href="<?php echo get_permalink(); ?>" class="read-more"><?php _e('View Post', 'pipdig-textdomain'); ?></a>
							
						</div>
					
					</div>
				</div>
				
			</div>
		
		</li>
		
		<?php endwhile; ?>
	
	</ul>
	</div>
</div>
<script>
jQuery(document).ready(function($) {
	$('#pipdig-top-slider .bxslider').bxSlider({
		pager: true,
		auto: true,
		mode: 'fade',
		pause: 4000,
		speed: 1200,
		onSliderLoad: function(){
			$('#pipdig-top-slider-content').css('visibility', 'visible');
		  }
	});
});
</script>