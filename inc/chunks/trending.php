<?php
$post_cat = get_theme_mod('trending_post_category');
$big_this_month = get_theme_mod('big_this_month');
?>

<div id="trendingz" class="nopin">
<h2><span><?php if ($big_this_month) {echo $big_this_month;} else {_e('Big this Month', 'pipdig-textdomain');} ?></span></h2>
<ul>
<?php
	$date_range = get_theme_mod( 'trending_dates', '1 month ago' );
    $popular = new WP_Query( array(
        //'post_type'             => array( 'post' ),
		'meta_key'              => '_thumbnail_id',
		'cat'                   => $post_cat,
        'showposts'             => 4,
        'ignore_sticky_posts'   => true,
        'orderby'               => 'comment_count',
        'order'                 => 'dsc',
        'date_query' => array(
            array(
                'after' => $date_range,
            ),
        ),
    ) );
?>
<?php while ( $popular->have_posts() ): $popular->the_post(); ?>
<li>
<a href="<?php the_permalink() ?>">
<span class="trending-thumb">
<?php the_post_thumbnail( 'pipdig-trending', array( 'data-pin-nopin' => 'true' ) );?>
</span>
<h5><?php $title = get_the_title(); echo pipdig_truncate($title, 5); ?></h5>
</a>
</li>
<?php endwhile;?>
</ul>
</div>