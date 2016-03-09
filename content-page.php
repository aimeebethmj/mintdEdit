<article id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?>>
	<header class="entry-header">
		<h1 class="entry-title"><?php the_title(); ?></h1>
	<!-- .entry-header --></header>

	<div class="clearfix entry-content">
		<?php the_content(); ?>
		<?php
			wp_link_pages( array(
				'before' => '<div class="page-links">' . __( 'Pages:', 'pipdig-textdomain' ),
				'after'  => '</div>',
			) );
		?>
	<!-- .entry-content --></div>
<!-- #post-<?php the_ID(); ?> --></article>