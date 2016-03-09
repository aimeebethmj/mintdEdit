<?php get_header(); ?>

	<div class="row">
	
		<div class="<?php pipdig_left_or_right(); ?> content-area" role="main">

			<section class="error-404 not-found">
				<header class="page-header">
					<h1 class="page-title"><?php _e( 'Oops! That page can&rsquo;t be found.', 'pipdig-textdomain' ); ?></h1>
				<!-- .page-header --></header>

				<div class="page-content">
					<p><?php _e( 'It looks like this page is missing. Maybe try a search below?', 'pipdig-textdomain' ); ?></p>

					<?php get_search_form(); ?>

				<!-- .page-content --></div>
			<!-- .error-404 --></section>

		<!-- .content-area --></div>

			<?php get_sidebar(); ?>

	</div>

<?php get_footer(); ?>