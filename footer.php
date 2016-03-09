		</div>
	</div><!-- .site-main -->
	
	<?php do_action('p3_site_main_end'); ?>

	<div class="hide-back-to-top"><div id="back-top"><a href="#top"><i class="fa fa-angle-double-up"></i></a></div></div>

	<?php if ( is_active_sidebar( 'ad-area-2' ) ) { ?>
		<div id="ad-area-2" class="clearfix container ad-area textalign-center">
			<?php dynamic_sidebar( 'ad-area-2' ); ?>
		</div>
	<?php } // end if ?>
	
	<?php get_sidebar( 'footer' ); ?>
	
	<?php if (get_theme_mod('posts_carousel_footer')) { ?>
	<div class="carousel-footer">
		<h3><?php _e('Where to next?', 'pipdig-textdomain'); ?></h3>
		<?php get_template_part('inc/chunks/posts-carousel'); ?>
	</div>
	<?php } // end if ?>

	<?php if(get_theme_mod('social_count_footer') && function_exists('pipdig_p3_social_footer')){ ?>
		<?php pipdig_p3_social_footer();?>
	<?php } // end if ?>
	
	<?php if(get_theme_mod('footer_instagram') && !function_exists('p3_instagram_footer')){ ?>
		<?php get_template_part('inc/chunks/instagram-footer');?>
	<?php } // end if ?>
	
	<?php do_action('p3_footer_bottom'); ?>
	
	<footer class="site-footer" role="contentinfo">
		<div class="clearfix container">
			<div class="row">
				<?php if (get_theme_mod('disable_responsive')) {
					$sm = $md = 'xs';
					} else {
						$sm = 'sm';
						$md = 'md';
					}
				?>
				<div class="col-<?php echo $sm; ?>-7 site-info">
					&copy; <?php echo date('Y'); ?> 
					<?php 
					if (get_theme_mod( 'copyright_statement' ) ) {
						$copyright = get_theme_mod( 'copyright_statement' );
					} else {
						$copyright = '<a href="'.site_url().'">'.bloginfo( 'name' ).'</a>';
					} ?>
					<?php if (has_nav_menu('footer')) {
						wp_nav_menu( array('container_class' => 'footer-menu-bar', 'theme_location' => 'footer'));
					} ?>
				</div>
				<div class="col-<?php echo $sm; ?>-5 site-credit">
					<?php $custom_credit = get_theme_mod('pipdig_custom_credit'); if ($custom_credit) { ?><span style="text-transform:none!important"><?php echo $custom_credit; ?><span><?php } else { ?><a href="<?php echo esc_url('http://www.pipdig.co'); ?>" target="_blank"><?php echo get_option('p3_amicorumi', 'WordPress Theme'); ?></a> BY <a href="<?php echo esc_url('https://plus.google.com/+Pipdig'); ?>" style="text-transform:lowercase">pipdig</a><?php } ?>
				</div>
			</div>
		</div>
	</footer>
	
<?php wp_footer(); ?>
<?php if (!get_theme_mod('disable_responsive')) { get_template_part('inc/chunks/slicknav'); } ?>
<?php if(get_theme_mod('pipdig_background_image') && get_theme_mod('pipdig_background_repeats') == '' ){ ?>
	<script>
	  jQuery.backstretch("<?php echo get_theme_mod('pipdig_background_image'); ?>");
	</script>
<?php } // end if ?>
<?php if(get_theme_mod('site_top_search')){ ?>
	<?php get_template_part('inc/chunks/scotch');?>
<?php } // end if ?>
<?php if (get_theme_mod('posts_carousel_footer')) { ?>
	<script>
		jQuery(document).ready(function($) {
		/*  hoot hoot
		/* ------------------------------------ */
			$("#owl-footer").owlCarousel({
				items : 5,
				itemsDesktop : [1199,5],
				itemsDesktopSmall : [980,4],
				itemsTablet: [768,3],
				itemsMobile : [479,1],
				slideSpeed : 800,
				paginationSpeed : 1200,
				rewindSpeed : 1800,
				autoPlay : true,
				baseClass : "owl-carousel",
				theme : "owl-theme",
				lazyLoad : true,
			})
		});
	</script>
<?php } // end if ?>
</body>
</html>