<article id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?>  itemprop="blogPost" itemscope="itemscope" itemtype="http://schema.org/BlogPosting">
	<header class="entry-header">
		<div class="entry-meta">
			<span class="date-bar-white-bg"><span class="vcard author show-author"><span class="fn" itemprop="name"><?php the_author(); ?></span><span class="show-author"> / </span></span><span class="entry-date updated"><time datetime="<?php echo get_the_date('Y-m'); ?>" itemprop="datePublished"><?php echo get_the_date(); ?></time></span></span>
		</div>
		<h1 class="entry-title" itemprop="name headline"><?php the_title(); ?></h1>
	</header><!-- .entry-header -->

	<div class="clearfix entry-content" itemprop="description articleBody">
		
		<?php do_action('p3_content_start'); ?>
		
		<?php the_content(); ?>
		
		<div class="pipdig-post-sig socialz nopin">
			<?php if(get_theme_mod('post_signature_image')) { ?>
				<img src="<?php echo get_theme_mod('post_signature_image'); ?>" data-pin-nopin="true" />
			<?php } //endif ?>
		</div>
		
		<?php if (function_exists('rwmb_meta')) { ?>
			<?php
			$sponsored = rwmb_meta( 'pipdig_meta_sponsored_post' ); //OLD
			$disclaimer = rwmb_meta( 'pipdig_meta_post_disclaimer' );
			?>
			<?php if ($sponsored == '1' ) { // old method, let's still use it if set: ?>
				<div class="disclaimer-text">
					<i class="fa fa-info-circle"></i> <?php echo get_theme_mod('sponsored_post_disclaimer_text'); ?>
				</div>
			<?php } else { ?>
				<?php if ($disclaimer) { // new method, use only if old not set. We can probably retire this in 2016 ?>
					<div class="disclaimer-text">
						<i class="fa fa-info-circle"></i> <?php echo $disclaimer; ?>
					</div>
				<?php } //endif ?>
			<?php } //endif ?>
		<?php } //endif ?>
		
		<?php do_action('p3_content_end'); ?>
		
	</div><!-- .entry-content -->

	<footer class="entry-meta entry-footer">
		<?php if ( 'post' == get_post_type() ) : ?>

			<?php if(function_exists('pipdig_p3_social_shares')){ pipdig_p3_social_shares(); } ?>

			<?php
				$tags_list = get_the_tag_list( '', __( ', ', 'pipdig-textdomain' ) );
				if ( $tags_list ) :
			?>
			<?php if(false == get_theme_mod('hide_post_tags')){ ?>
			<span class="tags-links">
				<i class="fa fa-tags"></i>
				<?php printf( __( '%1$s', 'pipdig-textdomain' ), $tags_list ); ?>
			</span>
			<?php } // end if ?>
			<?php endif; ?>
			
			<?php if (function_exists('rwmb_meta')) { ?>
				<?php $post_location = rwmb_meta( 'pipdig_meta_geographic_location' ); ?>
				<?php if( !empty( $post_location ) ) { ?>
				<br />
				<div class="location">
					<a href="http://maps.google.com/?q=<?php echo $post_location ?>" target="_blank" rel="nofollow"><i class="fa fa-map-marker"></i>
					<?php echo $post_location ?>
					</a>
				</div>
				<?php } //end if ?>
			<?php } // end if ?>
			
		<?php endif; ?>

	</footer><!-- .entry-footer -->

<!-- #post-<?php the_ID(); ?> --></article>