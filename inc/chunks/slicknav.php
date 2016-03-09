<?php
$links = get_option('pipdig_links');
$twitter = esc_url($links['twitter']);
$instagram = esc_url($links['instagram']);
$facebook = esc_url($links['facebook']);
$bloglovin = esc_url($links['bloglovin']);
$pinterest = esc_url($links['pinterest']);
$youtube = esc_url($links['youtube']);
$brand = '';
if ( $twitter || $instagram || $facebook || $bloglovin || $pinterest || $youtube ) {

	if($twitter) {
		$brand .= '<a href="'.$twitter.'" target="_blank"><i class="fa fa-twitter"></i></a>';
	}
	if($instagram) {
		$brand .= '<a href="'.$instagram.'" target="_blank"><i class="fa fa-instagram"></i></a>';
	}
	if($facebook) {
		$brand .= '<a href="'.$facebook.'" target="_blank"><i class="fa fa-facebook"></i></a>';
	}
	if($bloglovin) {
		$brand .= '<a href="'.$bloglovin.'" target="_blank"><i class="fa fa-plus"></i></a>';
	}
	if($pinterest) {
		$brand .= '<a href="'.$pinterest.'" target="_blank"><i class="fa fa-pinterest"></i></a>';
	}
	if($youtube) {
		$brand .= '<a href="'.$youtube.'" target="_blank"><i class="fa fa-youtube-play"></i></a>';
	}
	
} else {
	$brand = strip_tags(get_bloginfo());
}
?>
<script>
jQuery(document).ready(function($) {
	$(function(){
		$('.site-menu .menu').slicknav({
			label: '<i class="fa fa-bars"></i>',
			duration: 450,
			brand: '<?php echo $brand; ?>',
			closedSymbol: '<i class="fa fa-chevron-right"></i>',
			openedSymbol: '<i class="fa fa-chevron-down"></i>',
		});
	});
});
</script>
