<?php
if ( post_password_required() )
	return;
?>

<div id="comments" class="comments-area">

	<?php if ( have_comments() ) : ?>
		<h3 class="comments-title">
			<?php if (function_exists('pipdig_p3_comment_count')) { pipdig_p3_comment_count(); } else { ?>Comments<?php } ?>
		</h3>

		<ol class="comment-list">
			<?php wp_list_comments( array( 'callback' => 'pipdig_comment', 'avatar_size' => 40 ) ); ?>
		</ol>

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) && function_exists('pipdig_p3_comment_nav') ) : ?>
		<nav class="clearfix comment-navigation" role="navigation">
			<?php pipdig_p3_comment_nav(); ?>
		</nav>
		<?php endif; ?>

	<?php endif; ?>

	<?php comment_form(); ?>


</div><!-- #comments -->