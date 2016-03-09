<?php
if ( ! function_exists( 'pipdig_content_nav' ) ) :
/**
 * Display navigation to next/previous pages when applicable.
 */
function pipdig_content_nav( $nav_id ) {
	global $wp_query, $post;

	// Don't print empty markup on single pages if there's nowhere to navigate.
	if ( is_single() ) {
		$previous = ( is_attachment() ) ? get_post( $post->post_parent ) : get_adjacent_post( false, '', true );
		$next = get_adjacent_post( false, '', false );

		if ( ! $next && ! $previous )
			return;
	}

	// Don't print empty markup in archives if there's only one page.
	if ( $wp_query->max_num_pages < 2 && ( is_home() || is_archive() || is_search() ) )
		return;

	$nav_class = ( is_single() ) ? 'post-navigation' : 'paging-navigation';

	?>
	<nav id="<?php echo esc_attr( $nav_id ); ?>" class="clearfix <?php echo $nav_class; ?>" role="navigation">
	<?php if ( is_single() ) : ?>

		<?php previous_post_link( '<div class="nav-previous">%link</div>', '<span class="meta-nav"><i class="fa fa-chevron-left"></i> ' . __( 'Previous Post', 'pipdig-textdomain' ) . '</span> %title' ); ?>
		<?php next_post_link( '<div class="nav-next">%link</div>', '<span class="meta-nav">' . __( 'Next Post', 'pipdig-textdomain' ) . ' <i class="fa fa-chevron-right"></i></span> %title' ); ?>

	<?php elseif ( $wp_query->max_num_pages > 1 && ( is_home() || is_archive() || is_search() ) ) : ?>

		<?php if ( get_next_posts_link() ) : ?>
		<div class="nav-previous"><?php next_posts_link( '<span class="meta-nav"><i class="fa fa-chevron-left"></i></span> '.__( 'Older Posts', 'pipdig-textdomain' ) ); ?></div>
		<?php endif; ?>

		<?php if ( get_previous_posts_link() ) : ?>
		<div class="nav-next"><?php previous_posts_link( __( 'Newer Posts', 'pipdig-textdomain' ).' <span class="meta-nav"><i class="fa fa-chevron-right"></i></span>' ); ?></div>
		<?php endif; ?>

	<?php endif; ?>

	</nav><!-- #<?php echo esc_html( $nav_id ); ?> -->
	<?php
}
endif;

if ( ! function_exists( 'pipdig_comment' ) ) :
/**
 * Template for comments and pingbacks.
 *
 * Used as a callback by wp_list_comments() for displaying the comments.
 */
function pipdig_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;

	if ( 'pingback' == $comment->comment_type || 'trackback' == $comment->comment_type ) : ?>

	<li id="comment-<?php comment_ID(); ?>" <?php comment_class(); ?>>
		<div class="comment-body">
			<?php _e( 'Pingback:', 'pipdig-textdomain' ); ?> <?php comment_author_link(); ?> <?php edit_comment_link( __( 'Edit', 'pipdig-textdomain' ), '<span class="comment-meta"><span class="edit-link"><i class="fa fa-pencil"></i>', '</span></span>' ); ?>
		</div>

	<?php else : ?>

	<li id="comment-<?php comment_ID(); ?>" <?php comment_class( empty( $args['has_children'] ) ? '' : 'parent' ); ?>>
		<article id="div-comment-<?php comment_ID(); ?>" class="comment-body">
			<div class="comment-meta">
				<?php if ( 0 != $args['avatar_size'] ) echo get_avatar( $comment, $args['avatar_size'] ); ?>
				<?php printf( __( '<strong class="comment-author">%s</strong>', 'pipdig-textdomain' ), sprintf( '<cite class="fn">%s</cite>', get_comment_author_link() ) ); ?>
				<span class="comment-date"><?php printf( _x( '%1$s / %2$s', '1: date, 2: time', 'pipdig-textdomain' ), get_comment_date(), get_comment_time() ); ?></span>
			</div>

			<?php if ( '0' == $comment->comment_approved ) : ?>
			<p class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'pipdig-textdomain' ); ?></p>
			<?php endif; ?>

			<div class="comment-content">
				<?php comment_text(); ?>
			</div>

			<div class="comment-meta comment-footer">
				<?php edit_comment_link( __( 'Edit', 'pipdig-textdomain' ), '<span class="edit-link"><i class="fa fa-pencil"></i>', '</span>' ); ?>
				<?php
					comment_reply_link( array_merge( $args, array(
						'add_below' => 'div-comment',
						'depth'     => $depth,
						'max_depth' => $args['max_depth'],
						'before'    => '<span class="comment-reply"><i class="fa fa-reply"></i>',
						'after'     => '</span>',
					) ) );
				?>
			</div>
		<!-- #div-comment-<?php comment_ID(); ?> --></article>

	<?php
	endif;
}
endif; // ends check for pipdig_comment()
