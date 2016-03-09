<?php

if (pipdig_sidebar_check()) {
	
	if (get_theme_mod('disable_responsive')) {
		$sm = 'xs';
	} else {
		$sm = 'sm';
	}
			
	if(get_theme_mod('sidebar_position') != 'left') {
		$side_col = 'col-'.$sm.'-4';
	} else {
		$side_col = 'col-'.$sm.'-4 col-'.$sm.'-pull-8';
	}
	
	if (is_single() && function_exists('rwmb_meta')) { 
		$post_sidebar_position = rwmb_meta( 'pipdig_meta_post_sidebar_position' );
		if (!empty($post_sidebar_position)) {
			switch ($post_sidebar_position) {
				case 'sidebar_right':
					$side_col = 'col-'.$sm.'-4';
					break;
				case 'sidebar_left':
					$side_col = 'col-'.$sm.'-4 col-'.$sm.'-pull-8';
					break;
			}
		}
	}

?>

	<div class="<?php echo $side_col; ?> site-sidebar nopin" role="complementary">
		<?php if (!dynamic_sidebar('sidebar-1')) { ?>
			<?php the_widget('WP_Widget_Categories', '', 'before_title=<h3 class="widget-title">&after_title=</h3>'); ?>
		<?php } //endif ?>
	</div><!-- .site-sidebar -->
	
<?php } //endif ?>