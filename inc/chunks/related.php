<div class="clearfix"></div>
<?php
$date_range = get_theme_mod( 'related_posts_date', '1 year ago' );
$orig_post = $post;
global $post;
$categories = get_the_category($post->ID);
if ($categories) {
	switch ($date_range) { //used to suffix transient id...
		case '1 year ago':
			$range = 'yr';
			break;
		case '1 month ago':
			$range = 'mth';
			break;
		case '1 week ago':
			$range = 'wk';
			break;
		case '':
			$range = 'all';
			break;
	}
	$category_ids = array();
	foreach($categories as $individual_category) $category_ids[] = $individual_category->term_id;
	$post_id = get_the_ID(); //used to suffix transient id...
	if ( false === ( $query = get_transient( 'pipdig_related_posts_'.$post_id.'_'.$range ) ) ) { // transient
		$query = new wp_query( array(
			'category__in' => $category_ids,
			'post__not_in' => array($post->ID),
			'posts_per_page'=> 4,
			'ignore_sticky_posts' => 1,
			'orderby' => 'rand',
			//'meta_key' => '_thumbnail_id',
			'date_query' => array(
				array(
					'after' => $date_range,
				),
			),
			)
		);
		set_transient( 'pipdig_related_posts_'.$post_id.'_'.$range, $query, 4 * HOUR_IN_SECONDS );
	}
	if( $query->have_posts() ) { ?>
		<div id="pipdig-related-posts">
			<h3><span><?php _e('You may also enjoy:', 'pipdig-textdomain'); ?></span></h3>
			<ul>
			<?php
			while( $query->have_posts() ) { $query->the_post();
			$thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'pipdig-trending' );
			if ($thumb) {
				$bg = esc_url($thumb['0']);
			} else {
				$bg = pipdig_catch_that_image();
			}
			?>
				<li>
					<div class="pipdig-related-thumb" style="background-image:url(<?php echo $bg; ?>);">
						<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"></a>
					</div>
					<div class="pipdig-related-content">
						<h4 class="pipdig-related-title"><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php $title = get_the_title(); echo pipdig_truncate($title, 5); ?></a></h4>
					</div>
				</li>
			<?php } //endwhile ?>
		</ul>
		</div>
		<?php
	}
}
$post = $orig_post;
wp_reset_query();
?>