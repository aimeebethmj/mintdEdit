<?php
$home_layout = get_theme_mod('home_layout', 1);
$category_layout = get_theme_mod('category_layout', 1);
?>
<article id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?>  itemprop="blogPost" itemscope="itemscope" itemtype="http://schema.org/BlogPosting">
	<header class="entry-header">

		<?php if ( 'post' == get_post_type() ) : ?>
		<div class="entry-meta">
			<span class="date-bar-white-bg"><span class="vcard author show-author"><span class="fn" itemprop="name"><?php the_author(); ?></span><span class="show-author"> / </span></span><span class="entry-date updated"><time datetime="<?php echo get_the_date('Y-m'); ?>" itemprop="datePublished"><?php echo get_the_date(); ?></time></span></span>
		</div>
		<?php endif; ?>
		<h2 class="entry-title" itemprop="name headline"><a href="<?php the_permalink(); ?>" rel="bookmark" itemprop="url"><?php the_title(); ?></a></h2>
		
	</header><!-- .entry-header -->

	<?php if ( is_search() || ((is_home() && ($home_layout == 2))) || (is_archive() && ($category_layout == 2)) || (is_home() && ($home_layout == 5) && $wp_query->current_post == 0) || (is_archive() && ($category_layout == 5) && $wp_query->current_post == 0) ) { ?>
		<div class="entry-summary">
		<div class="textalign-center">
			<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" >
				<?php
				$link = esc_url(get_the_permalink());
				$title = rawurldecode(get_the_title());
				if (get_the_post_thumbnail() != '') {
					$attr = array(
						'data-p3-pin-title' => $title,
						'data-p3-pin-link' => $link,
						'itemprop' => 'image',
					);
					the_post_thumbnail('full', $attr);
				} else {
					if (pipdig_catch_that_image()) {
						echo '<img src="'.pipdig_catch_that_image().'" data-p3-pin-title="'.$title.'" data-p3-pin-link="'.$link.'" alt="" itemprop="image" />';
					}
				}
				?>
			</a>
		</div>
		<?php the_excerpt(); ?>
		
		<?php do_action('p3_content_end'); ?>
		
	</div><!-- .entry-summary -->
	<?php } else { ?>
	<div class="clearfix entry-content" itemprop="description articleBody">
	
		<?php do_action('p3_content_start'); ?>
		
		<?php the_content( __( 'View Post', 'pipdig-textdomain' ) ); ?>
		
		<div class="pipdig-post-sig socialz nopin">
			<?php if(get_theme_mod('post_signature_image')) { ?>
				<img src="<?php echo esc_url(get_theme_mod('post_signature_image')); ?>" data-pin-nopin="true" />
			<?php } //endif ?>
		</div>
		
		<?php if (function_exists('rwmb_meta')) { ?>
			<?php $sponsored = rwmb_meta( 'pipdig_meta_sponsored_post' ); ?>
			<?php if ($sponsored == '1' ) { ?>
				<div class="disclaimer-text">
					<i class="fa fa-info-circle"></i> <?php echo get_theme_mod('sponsored_post_disclaimer_text'); ?>
				</div>
			<?php } //endif ?>
		<?php } //endif ?>
		
		<?php do_action('p3_content_end'); ?>
		
	</div><!-- .entry-content -->
	<?php } ?>

	<footer class="entry-meta entry-footer">
		<?php if ( 'post' == get_post_type() ) { ?>

			<?php if(function_exists('pipdig_p3_social_shares')){ pipdig_p3_social_shares(); } ?>
			
			<?php if(!get_theme_mod('hide_comments_link')){ ?>
				<span class="commentz"><a href="<?php comments_link(); ?>" data-disqus-url="<?php echo get_the_permalink(); ?>"><?php if (function_exists('pipdig_p3_comment_count')) { pipdig_p3_comment_count(); } else { ?>Comments<?php } ?></a></span>
			<?php } // end if ?>
			
		<?php } ?>

	</footer><!-- .entry-footer -->
<!-- #post-<?php the_ID(); ?> --></article>