<?php
$post_cat = get_theme_mod('trending_post_category');
$recent_posts_title = get_theme_mod('recent_posts_title');
?>
<h2 class="venture-slider-title"><span><?php if ($recent_posts_title) {echo $recent_posts_title;} else {_e('Recent Posts', 'pipdig-textdomain');} ?></span></h2>
<style scoped>.cycle-slideshow li{display:none}.cycle-slideshow li.first{display:block}.slide-image{background-attachment:scroll;background-position:center center; background-size:cover;background-repeat: no-repeat;height:100%;width:100%;}.cycle-slideshow li {width: 100%;}</style>
<div data-starting-slide="1" data-cycle-speed="1200" data-cycle-slides="li" data-cycle-manual-speed="700" id="home-sliderz" class="cycle-slideshow nopin">
<ul>
<?php 
wp_enqueue_script( 'pipdig-cycle' );
	$args = array(
		'showposts'	=> 4,
		'cat'		=> $post_cat,
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
	<div class="slide-image" style="background-image:url(<?php echo $bg; ?>);">
		<div id="slide-container">
			<span class="slide-desc">
				<h2><?php $title = get_the_title(); echo pipdig_truncate($title, 11); ?></h2>
			</span>
			<a href="<?php the_permalink() ?>" style="display: block; width: 100%; height: 298px;">
				
			</a>
		</div>
	</div>
	</li>
<?php endwhile;?>
</ul>
<div class='cycle-prev'></div>
<div class='cycle-next'></div>
</div>
<div class="clearfix"></div>