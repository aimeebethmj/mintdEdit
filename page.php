<?php get_header(); ?>

	<?php if (is_front_page() && get_theme_mod('top_features') ) { ?>
	<div id="top-features" class="row">
		<div class="col-md-6">
			<?php get_template_part('inc/chunks/trending'); ?>
		</div>
		<div class="col-md-6">
			<?php get_template_part('inc/chunks/post-slider'); ?>
		</div>
	</div>
	<?php } // end if ?>

	<div class="row">
	
	<div class="<?php pipdig_left_or_right(); ?> content-area" role="main">

			<?php while ( have_posts() ) : the_post(); ?>

				<?php get_template_part( 'content', 'page' ); ?>

				<?php if (true == get_theme_mod('page_comments')){ ?>
				<?php
					if ( comments_open() || '0' != get_comments_number() )
					comments_template();
				?>
				<?php } // end if ?>

			<?php endwhile; ?>

		</div><!-- .content-area -->

			<?php get_sidebar(); ?>
	</div>

<?php get_footer(); ?>