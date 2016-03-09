<div id="scotch-panel" class="nopin">
<div class="follow-me">
	<a href="#" class="toggle-search"><?php _e( 'Close Me', 'pipdig-textdomain' ); ?> <i class="fa fa-times"></i></a>
	<h5><?php _e( 'Looking for Something?', 'pipdig-textdomain' ); ?></h5>
	
	<h6><i class="fa fa-search"></i> <?php _e( 'Search:', 'pipdig-textdomain' ); ?></h6>
	<?php get_search_form(); ?>

	<?php if ( class_exists('Woocommerce') ) { ?>
		<h6><?php _e( 'Product Categories:', 'pipdig-textdomain' ); ?></h6>
		<ul><?php wp_list_categories( array('title_li' => '', 'number' => 10, 'depth' => 1, 'taxonomy' => 'product_cat', ) ); ?></ul>
	<?php } // end if ?>	

	<h6><?php _e( 'Post Categories:', 'pipdig-textdomain' ); ?></h6>
	<ul><?php wp_list_categories( array('title_li' => '', 'number' => 10, 'depth' => 1, ) ); ?></ul>
	
</div>
</div>	
<script>
jQuery(document).ready(function($) {
	
    jQuery('#scotch-panel').scotchPanel({
        clickSelector: '.toggle-search',
		useCSS: false,
        containerSelector: 'body',
        direction: 'right',
        duration: 500,
        transition: 'ease',
        distanceX: '300px',
        enableEscapeKey: true,
    });
	
(function($) {
    var element = $('#scotch-panel .follow-me'),
        originalY = element.offset().top;

    // Space between element and top of screen (when scrolling)
    var topMargin = 30;

    // Should probably be set in CSS; but here just for emphasis
    element.css('position', 'relative');

    $(window).on('scroll', function(event) {
        var scrollTop = $(window).scrollTop();

        element.stop(false, false).animate({
            top: scrollTop < originalY
                    ? 0
                    : scrollTop - originalY + topMargin
        }, 900);
    });
})(jQuery);


});
</script>