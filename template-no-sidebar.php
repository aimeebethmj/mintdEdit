<?php
/**
 * Template Name: Full Width Page
 */
get_header(); ?>

	<div class="row">
		<div class="col-xs-12 content-area" role="main">

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
	</div>

<?php get_footer(); ?>