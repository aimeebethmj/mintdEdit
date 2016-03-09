jQuery(document).ready(function($) {

var templateUrl = pass_template_dir.templateUrl;

	$('#layerslider').layerSlider({
		responsive: false,
		responsiveUnder : 960,
		layersContainer : 960,
		hideOnMobile: false,
		pauseOnHover: false,
		hoverPrevNext: false,
		navStartStop: false,
		navButtons: true,
		showCircleTimer: false,
		startInViewport: true,
		skin: 'pip-full-width',
		skinsPath: templateUrl + '/inc/layerslider-skins/'
    });
	
});