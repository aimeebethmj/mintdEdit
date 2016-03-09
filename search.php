<?php get_header(); ?>

	<div class="row">
	
		<div class="<?php pipdig_left_or_right(); ?> content-area" role="main">

		<?php if ( have_posts() ) : ?>

			<header class="page-header">
				<h1 class="page-title"><?php printf( __( 'Search Results for: %s', 'pipdig-textdomain' ), '<span>' . get_search_query() . '</span>' ); ?></h1>
			<!-- .page-header --></header>

			<?php while ( have_posts() ) : the_post(); ?>

				<?php get_template_part( 'content', 'search' ); ?>

			<?php endwhile; ?>

			<?php pipdig_content_nav( 'nav-below' ); ?>

		<?php else : ?>

			<?php get_template_part( 'content', 'none' ); ?>

		<?php endif; ?>

		</div><!-- .content-area -->

			<?php get_sidebar(); ?>
	</div>

<?php get_footer(); ?>