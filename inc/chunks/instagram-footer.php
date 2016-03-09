<?php if (pipdig_plugin_check('instagram-feed/instagram-feed.php')) { ?>
<div id="instagramz" class="nopin">
	<?php
	$bg = get_theme_mod('content_background_color');
	$num = get_theme_mod('footer_instagram_num');

	if($num == null){
		$num2 = '10';
	}
	else {
		$num2 = $num;
	}

	if($bg == null){
		$bg2 = '#ffffff';
	}
	else {
		$bg2 = $bg;
	}
	echo do_shortcode( '[instagram-feed width=100 height=100 widthunit=% heightunit=% background=' . $bg2 . ' imagepadding=0 imagepaddingunit=px class=instagramhome num=' . $num2 . ' cols=' . $num2 . ' imageres=medium disablemobile=true showheader=false showbutton=false showfollow=false]' ); ?>
</div>
<?php } // end if ?>