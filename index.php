<?php
get_header();
$home_layout = get_theme_mod('home_layout', 1);
$category_layout = get_theme_mod('category_layout', 1);
?>

	<div class="row">
	
		<div class="<?php pipdig_left_or_right(); ?> content-area" role="main">
		
		<?php do_action('p3_posts_column_start'); ?>

		<?php if ( have_posts() ) { ?>
		
		<?php if ((is_home() && ($home_layout == 6)) || (is_archive() && ($category_layout == 6))) { //mosaic first? ?>
		<div class="grid p3_grid_mosaic">
			<?php while ( have_posts() ) : the_post(); ?>
			
				<?php
					if (has_post_thumbnail() != '') {
						$thumb = wp_get_attachment_image_src(get_post_thumbnail_id(), 'medium');
						$img = esc_url($thumb['0']);
					} else {
						$img = pipdig_p3_catch_that_image();
					}
					$comment_count = get_comments_number();
					if ($comment_count == 0) {
						$comments_out = '';
					} else {
						$comments_out = '<i class="fa fa-comments"></i> '.$comment_count;
					}
				?>
				
				<div class="pipdig-masonry-post grid-item">
					<img src="<?php echo $img; ?>" alt="" />
					<a href="<?php the_permalink(); ?>" class="mosaic-meta">
						<span class="date"><time itemprop="datePublished"><?php echo get_the_date(); ?></time></span>
						<h2 class="title moasic-title" itemprop="name"><?php the_title(); ?></h2>
						<div class="mosaic-comments"><?php echo $comments_out; ?></div>
					</a>
				</div>
			<?php endwhile; ?>
		</div>
		
		<style>
			.grid-item { width: 47%; margin: 1%; }
			.grid-item img {max-width: 100%; height: auto;}
			.grid-item .hentry {margin-bottom: 0;}
			.mosaic-meta {
			position: absolute;
			top: 0;
			right: 0;
			bottom: 0;
			left: 0;
			width: 100%;
			padding: 7px 7px 12px;
			background: rgba(255, 255, 255, .75);
			color: #000;
			opacity: 0;
			-moz-transition: all 0.25s ease-out; -webkit-transition: all 0.25s ease-out; transition: all 0.25s ease-out;
			}
			.moasic-title {margin: 0; letter-spacing: 0; line-height: 1.2;}
			.mosaic-comments {position: absolute; bottom: 5%;}
			.mosaic-meta:hover{opacity: 1;}
			#mosaic-nav .nav-previous {
			float: left;
			text-align: center;
			width: 50%;
			}
			#mosaic-nav .nav-next {
			float: right;
			text-align: center;
			width: 50%;
			}
			@media screen and (max-width: 769px) {
				.grid-item {width: 48%}
			}
		</style>
		<script src="//cdnjs.cloudflare.com/ajax/libs/jquery.imagesloaded/3.2.0/imagesloaded.pkgd.min.js"></script>
		<script>
		jQuery(document).ready(function($) {
			$(".content-area").imagesLoaded( function(){
				jQuery(".p3_grid_mosaic").masonry({
					itemSelector: ".pipdig-masonry-post",
				});
			});
		});
		</script>

		<?php } elseif ( (is_home() && ($home_layout == 3 || $home_layout == 5)) || ((is_archive()) && ($category_layout == 3 || $category_layout == 5)) ) { //Check if Kensington layout second ?>
				
				<?php while ( have_posts() ) : the_post(); ?>

					<?php if( $wp_query->current_post == 0 ) { ?>
						<?php get_template_part('content', get_post_format()); ?>
						<?php do_action( 'after_first_post' ); // after first post hook ?>
					<?php } else { ?>
						<?php get_template_part('content-grid', get_post_format()); ?>
					<?php } ?>

				<?php endwhile; ?>
				
			<?php } else {  // Not Kensington layout, so let's check if it is another more "normal" layout: ?>
		
				<?php while ( have_posts() ) : the_post(); ?>
				
					<?php if ( (is_home() && ($home_layout == 4)) || ((is_archive()) && ($category_layout == 4)) ) { // grid layout? ?>
						<?php get_template_part('content-grid', get_post_format()); ?>
					<?php } else { ?>
						<?php get_template_part('content', get_post_format()); ?>					
						<?php if( $wp_query->current_post == 0 ) { // after first post hook ?>
							<?php do_action( 'after_first_post' ); ?>
						<?php } //end if ?>
					<?php } // end if ?>
					
				<?php endwhile; ?>
			
			<?php } // Kensington end if ?>
			
			<div class="clearfix"></div>
			<div class="next-prev-hider"><?php pipdig_content_nav('nav-below'); ?></div>
			<?php pipdig_pagination(); ?>

		<?php } else { ?>

			<?php get_template_part( 'content', 'none' ); ?>

		<?php } //endif ?>
		
		<?php do_action('p3_posts_column_end'); ?>

		</div><!-- .content-area -->

		<?php get_sidebar(); ?>

	</div>

<?php get_footer(); ?>
