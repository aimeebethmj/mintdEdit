<?php get_header(); ?>

	<div class="row">

		<div class="<?php pipdig_left_or_right(); ?> content-area" role="main">

		<?php while ( have_posts() ) : the_post(); ?>

			<?php get_template_part( 'content', 'single' ); ?>

			<?php pipdig_content_nav( 'nav-below' ); ?>

			<?php
				if ( comments_open() || '0' != get_comments_number() )
					comments_template();
			?>

		<?php endwhile; ?>

		</div><!-- .content-area -->

		<?php get_sidebar(); ?>

	</div>

<?php get_footer(); ?>