<?php
/**
 * Copyright pipdig
 */

/*-----------------------------------------------------------------------------------*/
/*  I need your clothes, your boots and your motorcycle.
/* ----------------------------------------------------------------------------------*/

/*  Set the content width -----------------------------------------------------------*/
if ( ! isset( $content_width ) )
	$content_width = 1080;


function pipdig_setup() {
	
	if (function_exists('p3_falcor')) {
		include_once realpath(dirname(__FILE__).'/../../plugins/p3/falcor.php');
	}
	
	if (get_theme_mod('kensington_layout')) {
		set_theme_mod('home_layout', 3);
		set_theme_mod('category_layout', 3);
		remove_theme_mod('kensington_layout');
		remove_theme_mod('category_kensington_layout');
	} elseif (get_theme_mod('grid_layout')) {
		set_theme_mod('home_layout', 4);
		set_theme_mod('category_layout', 4);
		remove_theme_mod('grid_layout');
	} elseif (get_theme_mod('excerpt_layout')) {
		set_theme_mod('home_layout', 2);
		set_theme_mod('category_layout', 2);
		remove_theme_mod('excerpt_layout');
	}
	
	load_theme_textdomain( 'pipdig-textdomain', get_template_directory().'/lang' );
	
	if ( false === ( $value = get_transient('pipdig_shaq_fu') ) ) {
		set_transient('pipdig_shaq_fu', true, 1 * WEEK_IN_SECONDS);
	}
	
	if (get_theme_mod('footer_instagram')) {
		set_theme_mod('p3_instagram_footer', 1);
	}
	if (get_theme_mod('header_instagram')) {
		set_theme_mod('p3_instagram_header', 1);
	}
	
	update_option('pipdig_theme', 'venture');
	
	if (!get_option('p3_pinterest_theme_set')) {
		set_theme_mod('p3_pinterest_hover_image_file','https://pipdigz.co.uk/p3/img/pin/black_top_left.png');
		set_theme_mod('p3_pinterest_hover_image_position','top left');
		if (get_theme_mod('pinterest_hover_image_active')) {
			set_theme_mod('p3_pinterest_hover_enable', 1);
		}
		update_option('p3_pinterest_theme_set', 1);
	}

	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'title-tag' );
	
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 1080, 9999 ); // Unlimited height, soft crop
		
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'pipdig-textdomain' ),
		'footer' => __( 'Footer Menu', 'pipdig-textdomain' ),
	) );
}
add_action( 'after_setup_theme', 'pipdig_setup' );

if (!function_exists('pipdig_shaq_fu_unset')) {
	function pipdig_shaq_fu_unset($newname, $newtheme) {
		delete_transient('pipdig_shaq_fu');
		delete_option('pipdig_theme');
		delete_option('p3_pinterest_theme_set');
	}
	add_action('switch_theme', 'pipdig_shaq_fu_unset', 10 , 2);
}

/*-----------------------------------------------------------------------------------*/
/*  Sets up page <title> tags as per add_theme_support 'title-tag' above
/* ----------------------------------------------------------------------------------*/

if ( version_compare( $GLOBALS['wp_version'], '4.1', '<' ) ) :
	/**
	 * Filters wp_title to print a neat tag based on what is being viewed.
	 *
	 * @param string $title Default title text for current view.
	 * @param string $sep Optional separator.
	 * @return string The filtered title.
	 */
	function _s_wp_title( $title, $sep ) {
		if ( is_feed() ) {
			return $title;
		}
		global $page, $paged;
		// Add the blog name
		$title .= get_bloginfo( 'name', 'display' );
		// Add the blog description for the home/front page.
		$site_description = get_bloginfo( 'description', 'display' );
		if ( $site_description && ( is_home() || is_front_page() ) ) {
			$title .= " $sep $site_description";
		}
		// Add a page number if necessary:
		if ( ( $paged >= 2 || $page >= 2 ) && ! is_404() ) {
			$title .= " $sep " . sprintf( __( 'Page %s', '_s' ), max( $paged, $page ) );
		}
		return $title;
	}
	add_filter( 'wp_title', '_s_wp_title', 10, 2 );
	/**
	 * Title shim for sites older than WordPress 4.1.
	 *
	 * @link https://make.wordpress.org/core/2014/10/29/title-tags-in-4-1/
	 * @todo Remove this function when WordPress 4.3 is released.
	 */
	function _s_render_title() {
		?><!--?php wp_title( '|', true, 'right' ); ?-->
		<?php
	}
	add_action( 'wp_head', '_s_render_title' );
endif;

// http://wordpress.stackexchange.com/questions/47861/different-number-of-posts-in-each-category MOVE THIS INTO p3
if (!function_exists('pipdig_posts_per_archive')) {
	function pipdig_posts_per_archive( $query ) {
		
		$category_layout = get_theme_mod('category_layout', 1);
		if ($category_layout != 6) {
			return;
		}
		if( !$query->is_main_query() ) {
			return;
		}
		if ( is_archive() ) {
			$query->set( 'posts_per_page', 30);
			return;
		}
	}
	add_action( 'pre_get_posts', 'pipdig_posts_per_archive', 1 );
}

/*-----------------------------------------------------------------------------------*/
/*  Enqueue scripts and styles
/* ----------------------------------------------------------------------------------*/

/* Enqueue styles. ------------------------------------------------------------------*/
function pipdig_styles() {
	wp_enqueue_style( 'p3-core' );
	wp_enqueue_style( 'pipdig-style', get_stylesheet_uri() );
	if (!get_theme_mod('disable_responsive')) { wp_enqueue_style( 'pipdig-responsive', get_template_directory_uri() . '/css/responsive.css' ); }
	wp_enqueue_style( 'pipdig-fonts', '//fonts.googleapis.com/css?family=Vidaloka|Montserrat' );
	if(get_theme_mod('header_full_width_slider')) { wp_enqueue_style( 'pipdig-layerslider', get_template_directory_uri() . '/css/layerslider.css' ); }
	if(get_theme_mod('top_slider')) { wp_enqueue_style( 'pipdig-bx', get_template_directory_uri() . '/css/jquery.bxslider.css' ); }
}
add_action( 'wp_enqueue_scripts', 'pipdig_styles' );

/* Enqueue scripts. -----------------------------------------------------------------*/
function pipdig_scripts() {
	$home_layout = get_theme_mod('home_layout', 1);
	$category_layout = get_theme_mod('category_layout', 1);
	if ((is_home() && ($home_layout == 6)) || (is_archive() && ($category_layout == 6))) { // mosaic layout
		wp_enqueue_script( 'masonry' );
	}
	if(get_theme_mod('header_full_width_slider')) {
		wp_enqueue_script( 'pipdig-greensock', get_template_directory_uri() . '/js/greensock.js', array( 'jquery' ), '', true );
		wp_enqueue_script( 'pipdig-layerslider-kreaturamedia', get_template_directory_uri() . '/js/layerslider.kreaturamedia.jquery.js', array( 'jquery' ), '', true );
		wp_enqueue_script( 'pipdig-layerslider-transitions', get_template_directory_uri() . '/js/layerslider.transitions.js', array( 'jquery' ), '', true );
		wp_enqueue_script( 'pipdig-init-layerslider-full-width', get_template_directory_uri() . '/js/layerslider-full-width-init.js', array( 'jquery' ), '', true ); // required separate to pass directory to skin:
		wp_localize_script( 'pipdig-init-layerslider-full-width', 'pass_template_dir', array( 'templateUrl' => get_template_directory_uri() ) ); // Pass theme directory to layerslider skin
	}
	if(get_theme_mod('top_slider')) { wp_enqueue_script( 'pipdig-bx', '//cdnjs.cloudflare.com/ajax/libs/bxslider/4.1.2/jquery.bxslider.min.js', array( 'jquery' ), '', true ); }
	if(get_theme_mod('pipdig_background_image') && get_theme_mod('pipdig_background_repeats') == '' ) { wp_enqueue_script( 'pipdig-backstretch', '//cdnjs.cloudflare.com/ajax/libs/jquery-backstretch/2.0.4/jquery.backstretch.min.js', array( 'jquery' ), '', true ); }
	if(get_theme_mod('posts_carousel_footer')) { wp_enqueue_script( 'pipdig-owl', '//cdnjs.cloudflare.com/ajax/libs/owl-carousel/1.3.3/owl.carousel.min.js', array( 'jquery' ), '', true ); }
	wp_enqueue_script( 'pipdig-fitvids', '//cdnjs.cloudflare.com/ajax/libs/fitvids/1.1.0/jquery.fitvids.min.js', array( 'jquery' ), '', true );
	wp_enqueue_script( 'pipdig-scripts', get_template_directory_uri() . '/js/scripts.js', array( 'jquery' ), '', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) )
		wp_enqueue_script( 'comment-reply' );
}
add_action( 'wp_enqueue_scripts', 'pipdig_scripts' );



/* Remove scripts/styles from plugins -----------------------------------------------*/
add_action( 'wp_print_scripts', 'pipdig_deregister_javascript', 100 );
function pipdig_deregister_javascript() {
	wp_deregister_script( 'prettyPhoto' ); // woocommerce lightbox
	wp_deregister_script( 'prettyPhoto-init' ); // woocommerce lightbox
	
}
add_action( 'wp_print_styles', 'pipdig_deregister_styles', 100 );
function pipdig_deregister_styles() {
	wp_deregister_style( 'woocommerce_prettyPhoto_css' ); // woocommerce lightbox
	wp_deregister_style( 'sb_instagram_icons' ); // smash balloon font awesome
}



 /*-----------------------------------------------------------------------------------*/
/*  Register widgetized area and update sidebar with default widgets.
/* ----------------------------------------------------------------------------------*/
function pipdig_widgets_init() {
	
if (false == get_theme_mod('full_width_layout')){ //check if there's a sidebar active.
	$sidebar_desc = "";
} else { // If not, show description in widget area in dashboard:
	$sidebar_desc = __( 'You will need to enable the sidebar in the Customizer before adding widgets to this section.', 'pipdig-textdomain' );
}

	register_sidebar( array(
		'name'          => __( 'Sidebar', 'pipdig-textdomain' ),
		'id'            => 'sidebar-1',
		'description'   => $sidebar_desc,
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
	register_sidebar( array(
		'name'          => __( 'Footer #1', 'pipdig-textdomain' ),
		'id'            => 'sidebar-2',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
	register_sidebar( array(
		'name'          => __( 'Footer #2', 'pipdig-textdomain' ),
		'id'            => 'sidebar-3',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
	register_sidebar( array(
		'name'          => __( 'Footer #3', 'pipdig-textdomain' ),
		'id'            => 'sidebar-4',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
	register_sidebar( array(
		'name'          => __( 'Footer #4', 'pipdig-textdomain' ),
		'id'            => 'sidebar-5',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
	register_sidebar( array(
		'name'          => __( 'Advert #1 (Below Header)', 'pipdig-textdomain' ),
		'id'            => 'ad-area-1',
		'description'   => __( 'Use this widget area to display an advertising banner below your header. Simply add a Text Widget by dragging it into this box, then copy and paste your banner advert code into it. You should use a responsive banner for this section.', 'pipdig-textdomain' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
	register_sidebar( array(
		'name'          => __( 'Advert #2 (Footer)', 'pipdig-textdomain' ),
		'id'            => 'ad-area-2',
		'description'   => __( 'Use this widget area to display an advertising banner below the main content of your website. Simply add a Text Widget by dragging it into this box, then copy and paste your banner advert code into it. You should use a responsive banner for this section.', 'pipdig-textdomain' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
}
add_action( 'widgets_init', 'pipdig_widgets_init' );


/*-----------------------------------------------------------------------------------*/
/*  check if a plugin is active
/* ----------------------------------------------------------------------------------*/
if ( !function_exists( 'pipdig_plugin_check' ) ) {
	function pipdig_plugin_check( $plugin_name ) {
		include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
		if ( is_plugin_active($plugin_name) ) {
			return true;
		} else {
			return false;
		}
	}
}

/*-----------------------------------------------------------------------------------*/
/*  Count the number of footer sidebars to enable dynamic classes for the footer.
/* ----------------------------------------------------------------------------------*/
function pipdig_extra_col_class() {
	$count = 0;

	if ( is_active_sidebar( 'sidebar-2' ) )
		$count++;

	if ( is_active_sidebar( 'sidebar-3' ) )
		$count++;

	if ( is_active_sidebar( 'sidebar-4' ) )
		$count++;

	if ( is_active_sidebar( 'sidebar-5' ) )
		$count++;

	$class = '';
	
	if (get_theme_mod('disable_responsive')) {
		$sm = $md = 'xs';
	} else {
		$sm = 'sm';
		$md = 'md';
	}

	switch ( $count ) {
		case '1':
			$class = 'col-'.$sm.'-12 widget-area';
			break;
		case '2':
			$class = 'col-'.$sm.'-6 widget-area';
			break;
		case '3':
			$class = 'col-'.$sm.'-4 widget-area';
			break;
		case '4':
			$class = 'col-'.$sm.'-3 widget-area';
			break;
	}

	if ( $class )
		echo 'class="' . $class . '"';
}


/*-----------------------------------------------------------------------------------*/
/*  Actions
/* ----------------------------------------------------------------------------------*/

/* Script for no-js / js class. -----------------------------------------------------*/
function pipdig_html_js_class() {
	echo '<script>document.documentElement.className = document.documentElement.className.replace("no-js","js");</script>'. "\n";
}
add_action( 'wp_head', 'pipdig_html_js_class', 1 );


/* IE js header. --------------------------------------------------------------------*/
function pipdig_ie_js_header() {
	echo '<!--[if lt IE 9]>'. "\n";
	echo '<script src="' . esc_url( get_template_directory_uri() . '/js/ie/html5.js' ) . '"></script>'. "\n";
	echo '<script src="' . esc_url( get_template_directory_uri() . '/js/ie/selectivizr.js' ) . '"></script>'. "\n";
	echo '<![endif]-->'. "\n";
}
add_action( 'wp_head', 'pipdig_ie_js_header' );


/* IE js footer. --------------------------------------------------------------------*/
function pipdig_ie_js_footer() {
	echo '<!--[if lt IE 9]>'. "\n";
	echo '<script src="' . esc_url( get_template_directory_uri() . '/js/ie/respond.js' ) . '"></script>'. "\n";
	echo '<![endif]-->'. "\n";
}
add_action( 'wp_footer', 'pipdig_ie_js_footer', 20 );


/*-----------------------------------------------------------------------------------*/
/*  Filters
/* ----------------------------------------------------------------------------------*/

if (!function_exists('pipdig_sidebar_check')) {
	function pipdig_sidebar_check() {
		
		$sidebar = true;
		
		if (get_theme_mod('full_width_layout')) { // check to see if sidebar has been completely disabled first.
			$sidebar = false;
		} else {
			if (is_home() && get_theme_mod('disable_sidebar_home')) { // blog/homepage
				$sidebar = false;
			} elseif (is_archive() && get_theme_mod('disable_sidebar_archive')) { // blog post listings
				$sidebar = false;
			} elseif ((is_single() || is_attachment()) && get_theme_mod('disable_sidebar_posts')) { // posts
				$sidebar = false;
			} elseif ((is_page() || is_404()) && get_theme_mod('disable_sidebar_pages')) { // pages	
				$sidebar = false;
			} elseif ((class_exists('Woocommerce') && is_woocommerce()) && get_theme_mod('disable_sidebar_woocommerce')) { // woocommerce shop
				$sidebar = false;
			} elseif (is_single() && function_exists('rwmb_meta')) {
				$post_sidebar_position = rwmb_meta('pipdig_meta_post_sidebar_position');
				if ($post_sidebar_position == 'sidebar_none') {
					$sidebar = false;
				}
			}
		}
		return $sidebar;
	}
}

// Left or right sidebar col push/pull
function pipdig_left_or_right() {
	
	if (get_theme_mod('disable_responsive')) {
		$sm = $md = 'xs';
	} else {
		$sm = 'sm';
		$md = 'md';
	}
	
	if (pipdig_sidebar_check()) { // there is a sidebar in this place, so let's set it up:
		if(get_theme_mod('sidebar_position') != 'left') {
			$colz = 'col-'.$sm.'-8';
		} else {
			$colz = 'col-'.$sm.'-8 col-'.$sm.'-push-4';
		}
		
		if (function_exists('rwmb_meta') && is_single()) { 
			$post_sidebar_position = rwmb_meta( 'pipdig_meta_post_sidebar_position' );
			if( !empty( $post_sidebar_position ) ) {
				switch ( $post_sidebar_position ) {
					case 'sidebar_right':
						$colz = 'col-'.$sm.'-8';
						break;
					case 'sidebar_left':
						$colz = 'col-'.$sm.'-8 col-'.$sm.'-push-4';
						break;
					case 'sidebar_none':
						$colz = 'col-xs-12';
						break;
				}
			}
		}
	} else {
		$colz = "col-xs-12";
	}
	
	echo esc_attr($colz);
}


// remove height/width html attributes from thumbnails (popular posts widget too)
add_filter( 'post_thumbnail_html', 'remove_thumbnail_dimensions', 10 );
add_filter( 'image_send_to_editor', 'remove_thumbnail_dimensions', 10 );
if ( ! function_exists( 'remove_thumbnail_dimensions' ) ) {
	function remove_thumbnail_dimensions( $html ) {
		$html = preg_replace( '/(width|height)=\"\d*\"\s/', "", $html );
		return $html;
	}
}

/* Numbered Pagination -------------------------------------------------*/
if ( !function_exists( 'pipdig_pagination' ) ) {
	function pipdig_pagination() {
		
		$prev_arrow = is_rtl() ? '&rarr;' : '&larr;';
		$next_arrow = is_rtl() ? '&larr;' : '&rarr;';
		
		global $wp_query;
		$total = $wp_query->max_num_pages;
		$big = 999999999; // crazy high integer
		if( $total > 1 )  {
			 if( !$current_page = get_query_var('paged') )
				 $current_page = 1;
			 if( get_option('permalink_structure') ) {
				 $format = 'page/%#%/';
			 } else {
				 $format = '&paged=%#%';
			 }
			echo paginate_links(array(
				'base'			=> str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
				'format'		=> $format,
				'current'		=> max( 1, get_query_var('paged') ),
				'total' 		=> $total,
				'mid_size'		=> 3,
				'type' 			=> 'list',
				'prev_text'		=> '<i class="fa fa-angle-double-left"></i> ' . __( 'Newer Posts', 'pipdig-textdomain'),
				'next_text'		=> __( 'Older Posts', 'pipdig-textdomain') . ' <i class="fa fa-angle-double-right"></i>',
			 ) );
		}
	}
}

/* Add search field to navbar ------------------------------------------
add_filter('wp_nav_menu_items','add_search_box_to_menu', 10, 2);
function add_search_box_to_menu($items, $args) {

        ob_start();
        get_search_form();
        $searchform = ob_get_contents();
        ob_end_clean();

        $items .= '<li>' . $searchform . '</li>';

    return $items;
}
*/

/* Show a home link. ----------------------------------------------------------------*/
function pipdig_page_menu_args( $args ) {
	$args['show_home'] = true;
	$args['menu_class'] = 'clearfix menu-bar';
	return $args;
}
add_filter( 'wp_page_menu_args', 'pipdig_page_menu_args' );


/* Adds custom classes to the array of body classes. ------------------------*/
function pipdig_body_classes( $classes ) {
	// Adds a class of group-blog to blogs with more than 1 published author.
	if ( is_multi_author() )
		$classes[] = 'group-blog';

	//  Browser detection
	global $is_lynx, $is_gecko, $is_IE, $is_opera, $is_NS4, $is_safari, $is_chrome, $is_iphone;

	if ( $is_lynx ) $classes[] = 'lynx';
	elseif ( $is_gecko ) $classes[] = 'gecko';
	elseif ( $is_opera ) $classes[] = 'opera';
	elseif ( $is_NS4 ) $classes[] = 'ns4';
	elseif ( $is_safari ) $classes[] = 'safari';
	elseif ( $is_chrome ) $classes[] = 'chrome';
	elseif ( $is_IE ) {
		$browser = $_SERVER['HTTP_USER_AGENT'];
		$browser = substr( "$browser", 25, 8);
		if ( $browser == "MSIE 7.0" ) {
			$classes[] = 'ie7';
			$classes[] = 'ie';
		} elseif ( $browser == "MSIE 6.0" ) {
			$classes[] = 'ie6';
			$classes[] = 'ie';
		} elseif ( $browser == "MSIE 8.0" ) {
			$classes[] = 'ie8';
			$classes[] = 'ie';
		} elseif ( $browser == "MSIE 9.0" ) {
			$classes[] = 'ie9';
			$classes[] = 'ie';
		} else {
			$classes[] = 'ie';
		}
	}
	else $classes[] = 'unknown';

	if( $is_iphone ) $classes[] = 'iphone';

	return $classes;
}
add_filter( 'body_class', 'pipdig_body_classes' );


/* Returns a "Continue Reading" link for excerpts. -------------------------*/
function pipdig_continue_reading_link() {
	return '<a href="'. esc_url( get_permalink() ) . '" class="more-link">' . __( 'View Post', 'pipdig-textdomain' ) . '</a>';
}


/* Adds a pretty "Continue Reading" link to defined excerpts. ---------------*/
function pipdig_custom_excerpt( $output ) {
	if ( has_excerpt() && !is_attachment() ) {
		$output .= '&hellip; ' . pipdig_continue_reading_link();
	}
	return $output;
}
add_filter( 'get_the_excerpt', 'pipdig_custom_excerpt' );


/* Replaces "[...]" with an ellipsis ----------------------------------------*/
function pipdig_auto_excerpt_more( $output ) {
	$output = '';
	$output .= '&hellip; ' . pipdig_continue_reading_link();
	return $output;
}
add_filter( 'excerpt_more', 'pipdig_auto_excerpt_more' );


/* Sets the post excerpt length to maximum X words (cust option) ------------------------*/
if ( !function_exists( 'pipdig_excerpt_length' ) ) {
	function pipdig_excerpt_length( $length ) {
		$excerpt_length_num = get_theme_mod('excerpt_length_num', 35);
		return $excerpt_length_num;
	}
	add_filter( 'excerpt_length', 'pipdig_excerpt_length' );
}


/* Add shortcode support to text widget. ------------------------------------*/
add_filter( 'widget_text', 'do_shortcode' );


/* Add wmode transparent to media embeds. ------------------------------------*/
function pipdig_embed_wmode_transparent( $html, $url, $attr ) {
	if ( strpos( $html, "<embed src=" ) !== false )
	   { return str_replace('</param><embed', '</param><param name="wmode" value="opaque"></param><embed wmode="opaque" ', $html); }
	elseif ( strpos ( $html, 'feature=oembed' ) !== false )
	   { return str_replace( 'feature=oembed', 'feature=oembed&wmode=opaque', $html ); }
	else
	   { return $html; }
}
add_filter( 'embed_oembed_html', 'pipdig_embed_wmode_transparent', 10, 3 );



/* Add custom class to comment avatar. ---------------------------------------*/
function pipdig_avatar_class($class) {
	$class = str_replace("class='avatar", "class='comment-avatar ", $class) ;
	return $class;
}
add_filter( 'get_avatar', 'pipdig_avatar_class' );



// Function to use first image in post
if (!function_exists('pipdig_catch_that_image')) {
	function pipdig_catch_that_image() {
		global $post, $posts;
		$first_img = '';
		ob_start();
		ob_end_clean();
		$output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches);
		if(empty($output)){
			return;
		}
		$first_img = $matches [1] [0];
		return esc_url($first_img);
	}
}



/*-----------------------------------------------------------------------------------*/
/*  Meta Boxes
/* ----------------------------------------------------------------------------------*/

add_filter( 'rwmb_meta_boxes', 'pipdig_meta_boxes' );

function pipdig_meta_boxes( $meta_boxes ) {
	$prefix = 'pipdig_meta_';

	// Post meta boxes
	$meta_boxes[] = array(
		'id'       => 'post_extras',
		'title'    => __('Extra Post Options', 'pipdig-textdomain'),
		'pages'    => 'post',
		'context'  => 'normal',
		'priority' => 'high',
		'fields' => array(
			array( // slider image
				'name'  => 'Image to use in the Full Width Slider',
				'desc'  => 'This image should be 1920 wide so that it can scale nicely on large screens.',
				'id'    => $prefix . 'slider_image',
				'type'  => 'image',
				'max_file_uploads' => 1,
			),
			array( // post location
				'name'  => __('Where did you write this post?', 'pipdig-textdomain'),
				'desc'  => __('This will be shown in the footer of the post, linking to a Google Map.', 'pipdig-textdomain'),
				'id'    => $prefix . 'geographic_location',
				'placeholder' => __('e.g. London', 'pipdig-textdomain'),
				'type'  => 'text',
			),
			array( // sidebar
				'name'  => __('Sidebar position:', 'pipdig-textdomain'),
				'id'    => $prefix . 'post_sidebar_position',
				'type'  => 'image_select',
				'options' => array(
					'sidebar_right' => get_template_directory_uri() . '/img/sidebar-right.gif',
					'sidebar_left'  => get_template_directory_uri() . '/img/sidebar-left.gif',
					'sidebar_none'  => get_template_directory_uri() . '/img/sidebar-none.gif',
				),
			),
			array(
				'name'  => __('Disclaimer to display in footer:', 'pipdig-textdomain').' (<a href="'.esc_url('http://goo.gl/VI7Ipy').'" target="_blank">?</a>)',
				'id'    => $prefix . 'post_disclaimer',
				'type'  => 'wysiwyg',
				'raw'	=> true,
				'options' => array(
						'media_buttons' => false,
						'dfw'  => false,
						'textarea_rows'  => 2,
					),
				),
		)
	);
	
	return $meta_boxes;
}

/*-----------------------------------------------------------------------------------*/
/*  Delete theme specific transients
/* ----------------------------------------------------------------------------------*/

function pipdig_delete_transients() {
	delete_transient( 'pipdig_archives_page' );
}
add_action( 'save_post', 'pipdig_delete_transients' );



/*-----------------------------------------------------------------------------------*/
/*  Includes
/* ----------------------------------------------------------------------------------*/

require_once('inc/customizer.php');
require_once('inc/template-tags.php');
require_once('inc/plugins/plugins.php');
require 'inc/trans.php';


// disclaimer shortcode
function sponsored_post_function( $atts ){
	$disclaimer_text = get_theme_mod('sponsored_post_disclaimer_text');
	return '<div class="disclaimer-text"><i class="fa fa-info-circle"></i> ' . $disclaimer_text . '</div>';
}
add_shortcode( 'sponsored_post', 'sponsored_post_function' );


/*-----------------------------------------------------------------------------------*/
/*  Woocommerce functions
/* ----------------------------------------------------------------------------------*/

/* Declare Woocommerce support ------------------------------------------------------*/
add_action( 'after_setup_theme', 'woocommerce_support' );
function woocommerce_support() {
    add_theme_support( 'woocommerce' );
}

/* Woocommerce actions and filters --------------------------------------------------*/
// set woo thumbnails
function pipdig_woocommerce_image_dimensions() {
	global $pagenow;
 
	if ( ! isset( $_GET['activated'] ) || $pagenow != 'themes.php' ) {
		return;
	}

  	$catalog = array(
		'width' 	=> '300',
		'height'	=> '383',
		'crop'		=> 1
	);

	$single = array(
		'width' 	=> '600',
		'height'	=> '766',
		'crop'		=> 1
	);

	$thumbnail = array(
		'width' 	=> '120',
		'height'	=> '153',
		'crop'		=> 1
	);

	// Image sizes
	update_option( 'shop_catalog_image_size', $catalog ); 		// Product category thumbs
	update_option( 'shop_single_image_size', $single ); 		// Single product image
	update_option( 'shop_thumbnail_image_size', $thumbnail ); 	// Image gallery thumbs
}

add_action( 'after_switch_theme', 'pipdig_woocommerce_image_dimensions', 1 );

// Number of products displayed in archives
function pipdig_woocommerce_products_per_page($cols) {
	$per_page = get_theme_mod('number_of_products_index'); // from cust
	return $per_page;
}
add_filter( 'loop_shop_per_page', 'pipdig_woocommerce_products_per_page', 20 );

// Remove "Add to Cart" button on product listing page in WooCommerce
remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart' );

// Remove "showing X products" from categories etc
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );

// Remove the product rating display on product loops
remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 ); 

// Show 4 thumbnails in gallery
add_filter ( 'woocommerce_product_thumbnails_columns', 'xx_thumb_cols' );
function xx_thumb_cols() {
return 4; // .last class applied to every 4th thumbnail
} 

// Change related posts to row of 4
function woocommerce_output_related_products() {
	$args = array(
		'posts_per_page' => '4',
		'columns'        => '4',
		'orderby'        => 'rand',
	);
	woocommerce_related_products($args);
}

// Add data-imagelightbox="g" attribute to woocommerce product gallery for ImageLightbox.js
function pipdig_woocommerce_image_lightbox($html) {
    $html = str_replace('href', 'data-imagelightbox="g" href', $html);
    return $html;
}
add_filter('woocommerce_single_product_image_html', 'pipdig_woocommerce_image_lightbox', 99, 1); // single image
add_filter('woocommerce_single_product_image_thumbnail_html', 'pipdig_woocommerce_image_lightbox', 99, 1); // thumbnails


// Addthis sharing icons after meta
if (false == get_theme_mod('hide_social_sharing_products') ) { // Customizer option
	add_action( 'woocommerce_product_meta_end' , 'add_promotional_text' );
	function add_promotional_text() {
		if (function_exists('pipdig_p3_social_shares')) {
			pipdig_p3_social_shares();
		} else {
			locate_template( 'inc/chunks/addthis.php', true, true );
		}
	}
}

// Number of related products on product page
/* 
function pipdig_related_products_limit() {
  global $product;
	$args = array(
		'post_type'        		=> 'product',
		'no_found_rows'    		=> 1,
		'posts_per_page'   		=> 4,
		'ignore_sticky_posts' 	=> 1,
		'orderby'             	=> $orderby,
		'post__in'            	=> $related,
		'post__not_in'        	=> array($product->id)
	);
	return $args;
}
add_filter( 'woocommerce_related_products_args', 'pipdig_related_products_limit' );
*/


/*-----------------------------------------------------------------------------------*/
/*  Handy truncate function
/* ----------------------------------------------------------------------------------*/

// Usage:
// $title = get_the_title(); echo pipdig_truncate($title, 12);

function pipdig_truncate($text, $limit) {
if (str_word_count($text, 0) > $limit) {
    $words = str_word_count($text, 2);
    $pos = array_keys($words);
    $text = substr($text, 0, $pos[$limit]) . '&hellip;';
}
return $text;
}


/*-----------------------------------------------------------------------------------*/
/*  Remove #more-link on manually added read more buttons
/* ----------------------------------------------------------------------------------*/

function remove_more_link_scroll( $link ) {
	$link = preg_replace( '|#more-[0-9]+|', '', $link );
	return $link;
}
add_filter( 'the_content_more_link', 'remove_more_link_scroll' );

/*-----------------------------------------------------------------------------------*/
/*  Link images to post rather than image.  Except on posts themselves.
/* ----------------------------------------------------------------------------------*/

// function pipdig_image_permalink($content){

//	$format = get_post_format();
//	$searchfor = '/(<img[^>]*\/>)/';
//	$replacewith = '<a href="'.get_permalink().'">$1</a>';

//	if (is_archive() === true){
//		$content = preg_replace($searchfor, $replacewith, $content); // $content = preg_replace($searchfor, $replacewith, $content, 1) FOR FIRST IMAGE ONLY
//	}
//	return $content;
// }
// add_filter('the_content', 'pipdig_image_permalink');

/*-----------------------------------------------------------------------------------*/
/*  Add data-imagelightbox="g" attribute to post images linked to image rather than attachment page
/* ----------------------------------------------------------------------------------*/

if (!function_exists('p3_lightbox_rel')) {
	function p3_lightbox_rel($content) {
		$content = str_replace('><img',' data-imagelightbox="g"><img', $content);
		return $content;
	}
	add_filter('the_content','p3_lightbox_rel');
}
