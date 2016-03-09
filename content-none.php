<section class="no-results not-found">
	<header class="page-header">
		<h1 class="page-title"><?php _e( 'Nothing Found', 'pipdig-textdomain' ); ?></h1>
	<!-- .page-header --></header>

	<div class="clearfix page-content">
		<?php if ( is_home() && current_user_can( 'publish_posts' ) ) : ?>

			<p><?php printf( __( 'Ready to publish your first post? <a href="%1$s">Get started here</a>.', 'pipdig-textdomain' ), esc_url( admin_url( 'post-new.php' ) ) ); ?></p>

		<?php elseif ( is_search() ) : ?>

			<p><?php _e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'pipdig-textdomain' ); ?></p>
			<?php get_search_form(); ?>

		<?php else : ?>

			<p><?php _e( 'Sorry, We can&rsquo;t find that page!', 'pipdig-textdomain' ); ?></p>
			<?php get_search_form(); ?>

		<?php endif; ?>
	<!-- .page-content --></div>
<!-- .no-results --></section>