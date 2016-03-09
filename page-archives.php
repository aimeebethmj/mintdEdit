<?php
/**
 * Template Name: Archives
 */
get_header(); ?>

	<div class="row">
	
		<div class="<?php pipdig_left_or_right(); ?> content-area" role="main">

			<ul class="years">
<?php
if ( false === ( $all_posts = get_transient( 'pipdig_archives_page' ) ) ) {
	$all_posts = get_posts(array(
	  'posts_per_page' => -1, // to show all posts
	  'suppress_filters' => 0
	));
	set_transient( 'pipdig_archives_page', $all_posts, 24 * HOUR_IN_SECONDS );
}

// this variable will contain all the posts in a associative array
// with three levels, for every year, month and posts.

$ordered_posts = array();

foreach ($all_posts as $single) {

  $year  = mysql2date('Y', $single->post_date);
  $month = mysql2date('F', $single->post_date);

  // specifies the position of the current post
  $ordered_posts[$year][$month][] = $single;

}

// iterates the years
foreach ($ordered_posts as $year => $months) { ?>
  <li>

    <h3><?php echo $year ?></h3>

    <ul class="months">
    <?php foreach ($months as $month => $posts ) { // iterates the moths ?>
      <li>
        <h3><?php printf("%s (%d)", $month, count($months[$month])) ?></h3>

        <ul class="posts">
          <?php foreach ($posts as $single ) { // iterates the posts ?>

            <li>
              <span class="page-archives-post-date"><?php echo mysql2date('D, jS', $single->post_date) ?>:</span> <a href="<?php echo get_permalink($single->ID); ?>"><?php echo get_the_title($single->ID); ?></a></li>
            </li>

          <?php } // ends foreach $posts ?>
        </ul> <!-- ul.posts -->

      </li>
    <?php } // ends foreach for $months ?>
    </ul> <!-- ul.months -->

  </li> <?php
} // ends foreach for $ordered_posts
?>
</ul><!-- ul.years -->

		</div><!-- .content-area -->

			<?php get_sidebar(); ?>
			
	</div>

<?php get_footer(); ?>