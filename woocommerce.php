<?php

get_header();

$full_width = get_theme_mod('full_width_layout', false);

?>

	<div class="row">
		<?php if ($full_width == false) { ?>

			<?php if (is_product_category() || is_shop() || is_product_tag()){ ?>
				<div class="<?php pipdig_left_or_right(); ?> content-area" role="main">
			<?php } else { ?>
				<div class="col-xs-12 content-area" role="main">
			<?php } // end if ?>

		<?php } else { ?>
			<div class="col-xs-12 content-area" role="main">
		<?php } // end if ?>

			<?php woocommerce_content(); ?>

		</div><!-- .content-area -->

		<?php //Show sidebar? i.e. not on products
		if ($full_width == false) {
			if (is_product_category() || is_shop() || is_product_tag()){
				get_sidebar();
			}
		} 
		?>
	</div>

<?php get_footer(); ?>