<div id="owl-footer" class="owl-carousel">
<?php
//if ( false === ( $carousel_posts = get_transient( 'pipdig_carousel_footer' ) ) ) { // check for transient value
	$date_range = get_theme_mod( 'posts_carousel_dates', '1 year ago' );
	$carousel_posts = new WP_Query( array(
		'post_type'             => 'post',
		//'meta_key'              => '_thumbnail_id',
		'showposts'             => 15,
		'ignore_sticky_posts'   => true,
		'orderby'               => 'rand',
		'order'                 => 'dsc',
		'date_query' => array(
			array(
				'after' => $date_range,
				),
			),
		)
	);
	//set_transient( 'pipdig_carousel_footer', $carousel_posts, 24 * HOUR_IN_SECONDS ); // set transient value
//} ?>

<?php while ( $carousel_posts->have_posts() ): $carousel_posts->the_post();
		if(has_post_thumbnail()){
			$thumb = wp_get_attachment_image_src( get_post_thumbnail_id(), 'p3_medium' );
			$bg = esc_url($thumb['0']);
		} else {
			$bg = pipdig_catch_that_image();
		}
	?>
	<div class="owl-height-wrapper">
		<a href="<?php the_permalink() ?>" class="p3_slide_img" style="display: block; width: 100%; height: 100%;background-image:url(<?php echo $bg; ?>);">
			<img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAyAAAAHCAQMAAAAtrT+LAAAAA1BMVEUAAACnej3aAAAAAXRSTlMAQObYZgAAAENJREFUeNrtwYEAAAAAw6D7U19hANUAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAALIDsYoAAZ9qTLEAAAAASUVORK5CYII=" alt="<?php the_title_attribute(); ?>" class="p3_invisible" data-pin-nopin="true"/>
		</a>
		<h4 class="carousel-footer-title"><?php $title = get_the_title(); echo pipdig_truncate($title, 4); ?></h4>
	</div>
<?php endwhile; ?>
</div>
