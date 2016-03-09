<?php
/**
 * Template Name: Instagram Feed
 */
get_header(); ?>

	<div id="p3_instagram_page" class="row">
		<div class="col-xs-12 content-area nopin" role="main">
		
			<?php while ( have_posts() ) : the_post(); ?>
				<?php get_template_part( 'content', 'page' ); ?>
			<?php endwhile; ?>
			
			<?php
			$sb_options = get_option('sb_instagram_settings');
			if (pipdig_plugin_check('instagram-feed/instagram-feed.php') && (!empty($sb_options['sb_instagram_at']) && !empty($sb_options['sb_instagram_user_id']))) {
				$bg = get_theme_mod('content_background_color', '#ffffff');
				echo do_shortcode( '[instagram-feed width=100 height=100 widthunit=% heightunit=% background=' . $bg . ' imagepadding=1 imagepaddingunit=px class=instagramhome num=20 cols=5 imageres=full disablemobile=true showheader=true showbutton=true showfollow=false]' );
			} else { //elseif smash
				$images = p3_instagram_fetch(); // grab images
				if ($images) {
					$meta = intval(get_theme_mod('p3_instagram_meta', 1));
				?>
					<div id="p3_instagram_footer">
					<?php for ($x = 0; $x <= 29; $x++) { ?>
						<a href="<?php echo $images[$x]['link']; ?>" id="p3_instagram_post_<?php echo $x; ?>" class="p3_instagram_post" style="background-image:url(<?php echo $images[$x]['src']; ?>);" rel="nofollow" target="_blank">
							<img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAfQAAAH0AQMAAADxGE3JAAAAA1BMVEUAAACnej3aAAAAAXRSTlMAQObYZgAAADVJREFUeNrtwTEBAAAAwiD7p/ZZDGAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAOX0AAAEidG8rAAAAAElFTkSuQmCC" class="p3_instagram_square" alt=""/>
							<?php if ($meta) { ?><span class="p3_instagram_likes"><i class="fa fa-comment"></i> <?php echo $images[$x]['comments'];?> &nbsp;<i class="fa fa-heart"></i> <?php echo $images[$x]['likes'];?></span><?php } ?>
						</a>
					<?php } ?>
				<?php } ?>
			<?php } // end if smash ?>
			
			<div class="clearfix"></div>

		</div><!-- .content-area -->
	</div>
<?php get_footer(); ?>