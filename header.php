<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<?php if(!get_theme_mod('disable_responsive')) { ?><meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"><?php } ?>
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
	<?php do_action( 'before' ); ?>

	<header class="site-header nopin" role="banner">
		<div class="clearfix container">
			<div class="site-branding">
		<?php
			$heading_tag = ( is_home() || is_front_page() ) ? 'h1' : 'div';
			if(get_theme_mod('logo_image')) :
		?>
			<<?php echo $heading_tag; ?> class="site-title">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">
					<img data-pin-nopin="true" src="<?php echo esc_url( get_theme_mod( 'logo_image' ) ); ?>" alt="<?php bloginfo( 'name' ); ?>" /><style>.site-header .container{padding-top:0}.site-title{background:none;padding-top:0}</style>
				</a>
			</<?php echo $heading_tag; ?>>
		<?php else : ?>
			<<?php echo $heading_tag; ?> class="site-title">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">
					<?php bloginfo( 'name' ); ?>
				</a>
			</<?php echo $heading_tag; ?>>
		<?php endif; ?>

				<?php if(false == get_theme_mod('hide_tagline')){ ?><div class="site-description"><?php bloginfo( 'description' ); ?></div><?php } // end if ?>
			</div>
		</div>
	</header><!-- .site-header -->

	<div class="site-top">
	<?php if ( is_admin_bar_showing() ) { ?><div class="wpadminbar-nudge"></div><?php } // fixed top navbar with admin bar ?>
		<div class="clearfix container">
			<nav class="site-menu" role="navigation">
				<?php wp_nav_menu( array( 'container_class' => 'clearfix menu-bar', 'theme_location' => 'primary' ) ); ?>
			</nav><!-- .site-menu -->
    	</div>
	</div><!-- .site-top -->

	<?php if ( is_active_sidebar( 'ad-area-1' ) ) { ?>
		<div id="ad-area-1" class="clearfix container ad-area textalign-center">
			<?php dynamic_sidebar( 'ad-area-1' ); ?>
		</div>
	<?php } // end if ?>
	
	<div class="site-main">
	
		<?php //do_action('p3_top_site_main'); ?>

		<?php if (true == get_theme_mod('header_full_width_slider') ) { ?>
			<?php if (false == get_theme_mod('header_full_width_slider_home') || is_front_page() ) { //show slider on home page only ?>
				<?php get_template_part('inc/chunks/layerslider-full-width'); ?>
			<?php } // end if ?>
		<?php } // end if ?>
		
		<?php do_action('p3_top_site_main'); // move this back to above full width slider.  just moved here for instagram ?>
	
		<div class="clearfix container">
		
			<?php if (get_theme_mod('top_slider') && (is_home() && !is_paged()) ) { ?>
				<?php get_template_part('inc/chunks/top-slider'); ?>
			<?php } // end if ?>

			<?php do_action('p3_top_site_main_container'); ?>