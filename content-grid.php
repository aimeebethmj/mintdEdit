<?php

$this_post_num = $wp_query->current_post;

$home_layout = get_theme_mod('home_layout', 1);
$category_layout = get_theme_mod('category_layout', 1);

if ( (is_home() && ($home_layout == 3 || $home_layout == 5)) || ((is_archive()) && ($category_layout == 3 || $category_layout == 5)) ) { // offsets for kensington
	$this_post_num++;
} elseif(is_category() && get_theme_mod('category_kensington_layout')) {
	$this_post_num++;
}

$post_class = '';

if ($this_post_num % 2 == 0) { // check if even or odd number
	$post_class = 'pipdig-grid-post-even';
} else {
	$post_class = 'pipdig-grid-post-odd';
}

if (has_post_thumbnail()){
	$thumb = wp_get_attachment_image_src( get_post_thumbnail_id(), 'p3_medium' );
	$bg = esc_url($thumb['0']);
} else {
	$bg = pipdig_catch_that_image();
}

?>

<div class="pipdig-grid-post nopin <?php echo $post_class; ?>">
<article id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?>  itemprop="blogPost" itemscope="itemscope" itemtype="http://schema.org/BlogPosting">
	<header class="entry-header">

		<?php if ( 'post' == get_post_type() ) : ?>
		<div class="entry-meta">
			<span class="date-bar-white-bg"><span class="vcard author show-author"><span class="fn" itemprop="name"><?php the_author(); ?></span><span class="show-author"> / </span></span><span class="entry-date updated"><time datetime="<?php echo get_the_date('Y-m'); ?>" itemprop="datePublished"><?php echo get_the_date(); ?></time></span></span>
		</div>
		<?php endif; ?>
		<h2 class="entry-title grid-title" itemprop="name"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php echo pipdig_truncate(get_the_title(), 8); ?></a></h2>
		
	</header>

	<div class="entry-summary">
		<a href="<?php the_permalink() ?>" class="p3_slide_img" style="display: block; width: 100%; height: 100%;background-image:url(<?php echo $bg; ?>);">
			<img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAyAAAAHCAQMAAAAtrT+LAAAAA1BMVEUAAACnej3aAAAAAXRSTlMAQObYZgAAAENJREFUeNrtwYEAAAAAw6D7U19hANUAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAALIDsYoAAZ9qTLEAAAAASUVORK5CYII=" alt="<?php the_title_attribute(); ?>" class="p3_invisible" data-pin-nopin="true"/>
		</a>
		<a class="more-link" href="<?php the_permalink(); ?>"><?php _e('View Post', 'pipdig-textdomain'); ?></a>
	</div>

	<footer class="entry-meta entry-footer">
		<?php if ( 'post' == get_post_type() ) { ?>

			<?php if(function_exists('pipdig_p3_social_shares')){ pipdig_p3_social_shares(); } ?>
			
			<?php if(!get_theme_mod('hide_comments_link')){ ?>
				<span class="commentz"><a href="<?php comments_link(); ?>" data-disqus-url="<?php echo esc_url(get_the_permalink()); ?>"><?php if (function_exists('pipdig_p3_comment_count')) { pipdig_p3_comment_count(); } else { ?>Comments<?php } ?></a></span>
			<?php } // end if ?>
			
		<?php } //end if ?>

	</footer>
<!-- #post-<?php the_ID(); ?> --></article>
</div>