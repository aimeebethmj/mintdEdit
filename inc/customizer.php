<?php
if (class_exists('WP_Customize_Control')) {
    class WP_Customize_Category_Control extends WP_Customize_Control {
        public function render_content() {
            $dropdown = wp_dropdown_categories(
                array(
                    'name'              => '_customize-dropdown-categories-' . $this->id,
                    'echo'              => 0,
                    'show_option_none'  => 'All categories',
                    'option_none_value' => '',
                    'selected'          => $this->value(),
                )
            );
 
            // Hackily add in the data link parameter.
            $dropdown = str_replace( '<select', '<select ' . $this->get_link(), $dropdown );
 
            printf(
                '<label class="customize-control-select"><span class="customize-control-title">%s</span> %s</label>',
                $this->label,
                $dropdown
            );
        }
    }
}

// create another class just to change default label
if (class_exists('WP_Customize_Control')) {
    class WP_Customize_Category_Control_Exclude extends WP_Customize_Control {
        public function render_content() {
            $dropdown = wp_dropdown_categories(
                array(
                    'name'              => '_customize-dropdown-categories-' . $this->id,
                    'echo'              => 0,
                    'show_option_none'  => 'No categories',
                    'option_none_value' => '',
                    'selected'          => $this->value(),
                )
            );
 
            // Hackily add in the data link parameter.
            $dropdown = str_replace( '<select', '<select ' . $this->get_link(), $dropdown );
 
            printf(
                '<label class="customize-control-select"><span class="customize-control-title">%s</span> %s</label>',
                $this->label,
                $dropdown
            );
        }
    }
}

function pipdig_customizer_styles() { ?>
    <style>
        #customize-controls span.description {font-size: 90%}
		.customize-control-checkbox label {padding-top: 15px;}
    </style>
    <?php
}
add_action( 'customize_controls_print_styles', 'pipdig_customizer_styles', 999 );

// the beef
class pipdig_Customize {
public static function register ( $wp_customize ) {

//remove unwanted sections
//$wp_customize->remove_section( 'title_tagline' );
$wp_customize->remove_section( 'colors' );
$wp_customize->remove_section( 'static_front_page' );
//$wp_customize->remove_section( 'nav' );
$wp_customize->remove_section( 'header_image' );
//$wp_customize->remove_panel( 'widgets' );


// SECTIONS ================================================================================

$wp_customize->add_section( 'pipdig_header', 
    array(
        'title' => __( 'Header Options', 'pipdig-textdomain' ),
        'priority' => 10,
        'capability' => 'edit_theme_options',
    ) 
);

$wp_customize->add_section( 'pipdig_general_options', 
    array(
        'title' => __( 'General Options', 'pipdig-textdomain' ),
        'priority' => 15,
        'capability' => 'edit_theme_options',
    ) 
);

$wp_customize->add_section( 'pipdig_layout', 
    array(
        'title' => __( 'Layout Options', 'pipdig-textdomain' ),
        'priority' => 20,
        'capability' => 'edit_theme_options',
    ) 
);

$wp_customize->add_section( 'post_layouts', 
    array(
		'title' => __( 'Post Layout Options', 'pipdig-textdomain' ),
		'description' => __("Use these settings to select different post layouts for your blog. You can also change the number of posts displayed by going to 'Settings > Reading' in your dashboard.", 'pipdig-textdomain'),
		'priority' => 30,
		'capability' => 'edit_theme_options',
    ) 
);

$wp_customize->add_section( 'pipdig_colors', 
	array(
		'title' => __( 'Color Options', 'pipdig-textdomain' ),
		'priority' => 40,
		'capability' => 'edit_theme_options',
	) 
);

$wp_customize->add_section( 'pipdig_backgrounds' , array(
   		'title'      => __( 'Background Image', 'pipdig-textdomain' ),
   		'description'=> __( 'Use these options to add a background image to your site. Note, if you would like a solid color please use the options in the "Color Options" section above.', 'pipdig-textdomain' ),
   		'priority'   => 50,
	)
);

$wp_customize->add_section( 'pipdig_fonts', 
    array(
        'title' => __( 'Font Options', 'pipdig-textdomain' ),
		'description'=> __( 'If you would like even more font options, we recommend using <a href="https://goo.gl/12Xv2n" target="_blank" rel="nofollow">this plugin</a>.', 'pipdig-textdomain' ),
        'priority' => 55,
        'capability' => 'edit_theme_options',
    ) 
);

$wp_customize->add_section( 'pipdig_homepage', 
    array(
        'title' => __( 'Homepage Options', 'pipdig-textdomain' ),
        'priority' => 60,
        'capability' => 'edit_theme_options',
    ) 
);

$wp_customize->add_section( 'pipdig_category', 
    array(
        'title' => __( 'Post Category Options', 'pipdig-textdomain' ),
		'description'=> __( 'These options will apply to post categories.', 'pipdig-textdomain' ),
        'priority' => 65,
        'capability' => 'edit_theme_options',
    ) 
);

$wp_customize->add_section( 'pipdig_posts', 
    array(
        'title' => __( 'Blog Post Options', 'pipdig-textdomain' ),
        'priority' => 70,
        'capability' => 'edit_theme_options',
    ) 
);

if ( class_exists('Woocommerce') ) { // wocommerce active?
	$wp_customize->add_section( 'pipdig_woocommerce', 
		array(
			'title' => __( 'Woocommerce Options', 'pipdig-textdomain' ),
			'priority' => 80,
			'capability' => 'edit_theme_options',
		) 
	);
}

// ====================================== gap

$wp_customize->add_section( 'pipdig_instagram_footer', 
    array(
        'title' => __( 'Instagram Footer', 'pipdig-textdomain' ),
        'priority' => 130,
        'capability' => 'edit_theme_options',
        'description' => __('Display your Instagram feed across the bottom of your site (You will need to setup <a href="https://wordpress.org/plugins/instagram-feed/" target="_blank" rel="nofollow"><strong>this plugin</strong></a> first)', 'pipdig-textdomain'),
    ) 
);

$wp_customize->add_section( 'pipdig_bloglovin', 
	array(
		'title' => __( "Bloglovin' Widget", 'pipdig-textdomain' ),
		'description' => __( "Use these settings to style our custom Bloglovin' Widget.", 'pipdig-textdomain' ),
		'priority' => 150,
		'capability' => 'edit_theme_options',
	) 
);


// Post Sliders panel/sections ==========================================================================

$wp_customize->add_section( 'pipdig_header_full_width_slider' , array(
   		'title'      => __( 'Full Width Slider', 'pipdig-textdomain' ),
   		'description'=> __( 'Use these options to display a full width post slider under the header. NOTE: for a post to be included in the slider it needs to have a "Featured Image" set.', 'pipdig-textdomain' ),
   		'priority'   => 100,
		//'panel' => 'post_sliders',
	)
);

$wp_customize->add_section( 'pipdig_top_slider' , array(
   		'title'      => __( 'Large Square Slider', 'pipdig-textdomain' ),
   		'description'=> __( 'Use these options to display alarge square shaped post slider at the top of the home page. NOTE: for a post to be included it needs to have a "Featured Image" set.', 'pipdig-textdomain' ),
   		'priority'   => 101,
		//'panel' => 'post_sliders',
	)
);

$wp_customize->add_section( 'pipdig_post_carousels' , array(
   		'title'      => __( 'Posts Carousel', 'pipdig-textdomain' ),
   		'description'=> __( 'Use these options to display a carousel of posts. NOTE: for a post to be included it needs to have a "Featured Image" set.', 'pipdig-textdomain' ),
   		'priority'   => 102,
		//'panel' => 'post_sliders',
	)
);


// Header section ==========================================================================

// Header image
$wp_customize->add_setting('logo_image',
	array(
		'sanitize_callback' => 'esc_url_raw',
	)
);
$wp_customize->add_control(
       new WP_Customize_Image_Control(
           $wp_customize,
           'upload_header',
           array(
               'label'      => __( 'Upload a header image', 'pipdig-textdomain' ),
               'section'    => 'pipdig_header',
               'settings'   => 'logo_image',
           )
       )
);

// Header image top padding
$wp_customize->add_setting( 'header_image_top_padding', array(
	'default' => 0,
	'capability' => 'edit_theme_options',
	'sanitize_callback' => 'absint',
	)
);

$wp_customize->add_control( 'header_image_top_padding', array(
    'type' => 'range',
    'priority' => 10,
    'section' => 'pipdig_header',
    'label' => __( 'Header image spacing', 'pipdig-textdomain' ),
    'description' => __( 'Move the slider to increase the space above your header image:', 'pipdig-textdomain' ),
    'input_attrs' => array(
        'min' => 0,
        'max' => 100,
        'step' => 1,
		),
	)
);


// Hide the tagline
$wp_customize->add_setting('hide_tagline',
	array(
		'default' => 0,
		'sanitize_callback' => 'absint',
	)
);
$wp_customize->add_control(
	'hide_tagline',
	array(
		'type' => 'checkbox',
		'label' => __( 'Remove the tagline from header', 'pipdig-textdomain' ),
		'section' => 'pipdig_header',
	)
);



// Header Full Width Slider ==============================================================================
	
// Activate full width header Slider
$wp_customize->add_setting('header_full_width_slider',
	array(
		'default' => 0,
		'sanitize_callback' => 'absint',
	)
);
$wp_customize->add_control(
	'header_full_width_slider',
	array(
		'type' => 'checkbox',
		'label' => __( 'Enable full width slider', 'pipdig-textdomain' ),
		'section' => 'pipdig_header_full_width_slider',
	)
);

// show on home or all pages?
$wp_customize->add_setting('header_full_width_slider_home',
	array(
		'default' => 0,
		'sanitize_callback' => 'absint',
	)
);
$wp_customize->add_control(
	'header_full_width_slider_home',
	array(
		'type' => 'checkbox',
		'label' => __( 'Home page only', 'pipdig-textdomain' ),
		'description' => __('Select this option if you want to display the slider on the home page and nowhere else', 'pipdig-textdomain' ),
		'section' => 'pipdig_header_full_width_slider',
	)
);

// Number of images to display in slider
$wp_customize->add_setting('header_full_width_slider_posts',
    array(
        'default' => '3',
		'sanitize_callback' => 'absint',
    )
);
$wp_customize->add_control('header_full_width_slider_posts',
    array(
        'type' => 'select',
        'label' => __('Number of posts to show in the slider', 'pipdig-textdomain'),
        'section' => 'pipdig_header_full_width_slider',
        'choices' => array(
            '3' => '3',
            '4' => '4',
            '5' => '5',
            '6' => '6',
            '7' => '7',
            '8' => '8',
        ),
    )
);

// Slide delay in ms
$wp_customize->add_setting('header_full_width_slider_delay',
    array(
        'default' => '4000',
		'sanitize_callback' => 'absint',
    )
);
$wp_customize->add_control(
    'header_full_width_slider_delay',
    array(
        'type' => 'select',
        'label' => __('How long should each slide be displayed?', 'pipdig-textdomain'),
        'section' => 'pipdig_header_full_width_slider',
        'choices' => array(
            '3000' => __('3 seconds', 'pipdig-textdomain'),
            '4000' => __('4 seconds', 'pipdig-textdomain'),
            '5000' => __('5 seconds', 'pipdig-textdomain'),
            '6000' => __('6 seconds', 'pipdig-textdomain'),
            '7000' => __('7 seconds', 'pipdig-textdomain'),
            '8000' => __('8 seconds', 'pipdig-textdomain'),
        ),
    )
);

// Slide transition
$wp_customize->add_setting('header_full_width_slider_transition',
    array(
        'default' => '5',
		'sanitize_callback' => 'absint',
    )
);
$wp_customize->add_control(
    'header_full_width_slider_transition',
    array(
        'type' => 'select',
        'label' => __('Slider animation style', 'pipdig-textdomain'),
        'section' => 'pipdig_header_full_width_slider',
        'choices' => array(
            '5' => __('Fade', 'pipdig-textdomain'),
            '1' => __('Slide', 'pipdig-textdomain'),
        ),
    )
);

// Choose a category
$wp_customize->add_setting('header_full_width_slider_post_category'); //can we sanitize this?
$wp_customize->add_control(
    new WP_Customize_Category_Control(
        $wp_customize,
        'header_full_width_slider_post_category',
        array(
            'label'    => __('Only display posts from:', 'pipdig-textdomain'),
            'settings' => 'header_full_width_slider_post_category',
            'section'  => 'pipdig_header_full_width_slider'
        )
    )
);

// Show category in slider
$wp_customize->add_setting('header_full_width_slider_cat',
	array(
		'default' => 1,
		'sanitize_callback' => 'absint',
	)
);
$wp_customize->add_control(
	'header_full_width_slider_cat',
	array(
		'type' => 'checkbox',
		'label' => __( 'Include post category', 'pipdig-textdomain' ),
		'description' => __( 'Display the main category of the post', 'pipdig-textdomain' ),
		'section' => 'pipdig_header_full_width_slider',
	)
);

// Show category in slider
$wp_customize->add_setting('header_full_width_slider_cat',
	array(
		'default' => 1,
		'sanitize_callback' => 'absint',
	)
);
$wp_customize->add_control(
	'header_full_width_slider_cat',
	array(
		'type' => 'checkbox',
		'label' => __( 'Display post category', 'pipdig-textdomain' ),
		'description' => __( 'You should probably disable this if you select to show posts from a single category.', 'pipdig-textdomain' ),
		'section' => 'pipdig_header_full_width_slider',
	)
);

// Show post excerpt in slider
$wp_customize->add_setting('header_full_width_slider_excerpt',
	array(
		'default' => 0,
		'sanitize_callback' => 'absint',
	)
);
$wp_customize->add_control(
	'header_full_width_slider_excerpt',
	array(
		'type' => 'checkbox',
		'label' => __( 'Include post excerpt', 'pipdig-textdomain' ),
		'description' => __( 'Display the excerpt from the post.', 'pipdig-textdomain' ),
		'section' => 'pipdig_header_full_width_slider',
	)
);


// Layout section ==========================================================================

// Container width
$wp_customize->add_setting( 'container_width',
	array(
		'default' => 1080,
		'capability' => 'edit_theme_options',
		'sanitize_callback' => 'absint',
	)
);

$wp_customize->add_control( 'container_width',
	array(
		'type' => 'number',
		'priority' => 10,
		'section' => 'pipdig_layout',
		'label' => __( 'Main Width', 'pipdig-textdomain' ),
		'description' => __( 'The number below is how wide your website is in pixels:', 'pipdig-textdomain' ),
		'input_attrs' => array(
			'min' => 800,
			'max' => 1280,
			'step' => 10,
		),
	)
);

// Disable responsive
$wp_customize->add_setting('disable_responsive',
	array(
		'default' => 0,
		'sanitize_callback' => 'absint',
	)
);
$wp_customize->add_control(
	'disable_responsive',
	array(
		'type' => 'checkbox',
		'label' => __( 'Disable Responsive layout', 'pipdig-textdomain' ),
		'description' => __( 'This theme automatically adapts to different screen sizes. Select this option to disable this, and show the same thing on all devices (not recommended).', 'pipdig-textdomain' ),
		'section' => 'pipdig_layout',
	)
);


// Sidebar position
$wp_customize->add_setting( 'sidebar_position',
	array(
		'default' => 'right',
		'capability' => 'edit_theme_options',
		'sanitize_callback' => 'pipdig_sanitize_sidebar_position',
	)
);

$wp_customize->add_control( 'sidebar_position',
	array(
		'type' => 'radio',
		'section' => 'pipdig_layout',
		'label' => __( 'Sidebar position:', 'pipdig-textdomain' ),
		'choices' => array(
            'left' => __( 'Left', 'pipdig-textdomain' ),
            'right' => __( 'Right', 'pipdig-textdomain' ),
        ),
	)
);


// Full width layout
$wp_customize->add_setting('full_width_layout',
	array(
		'default' => 0,
		'sanitize_callback' => 'absint',
	)
);
$wp_customize->add_control(
	'full_width_layout',
	array(
		'type' => 'checkbox',
		'label' => __( 'Completely disable the sidebar', 'pipdig-textdomain' ),
		'description' => __( 'Removes the sidebar from all pages and posts. This will override any settings below.', 'pipdig-textdomain' ),
		'section' => 'pipdig_layout',
	)
);


// is_home() sidebar
$wp_customize->add_setting('disable_sidebar_home',
	array(
		'default' => 0,
		'sanitize_callback' => 'absint',
	)
);
$wp_customize->add_control(
	'disable_sidebar_home',
	array(
		'type' => 'checkbox',
		'label' => __( 'Disable sidebar on home/blog', 'pipdig-textdomain' ),
		'section' => 'pipdig_layout',
	)
);

// is_archive() sidebar
$wp_customize->add_setting('disable_sidebar_archive',
	array(
		'default' => 0,
		'sanitize_callback' => 'absint',
	)
);
$wp_customize->add_control(
	'disable_sidebar_archive',
	array(
		'type' => 'checkbox',
		'label' => __( 'Disable sidebar on categories/archives', 'pipdig-textdomain' ),
		'section' => 'pipdig_layout',
	)
);

// is_single() sidebar
$wp_customize->add_setting('disable_sidebar_posts',
	array(
		'default' => 0,
		'sanitize_callback' => 'absint',
	)
);
$wp_customize->add_control(
	'disable_sidebar_posts',
	array(
		'type' => 'checkbox',
		'label' => __( 'Disable sidebar on all posts', 'pipdig-textdomain' ),
		'section' => 'pipdig_layout',
	)
);


// is_page() sidebar
$wp_customize->add_setting('disable_sidebar_pages',
	array(
		'default' => 0,
		'sanitize_callback' => 'absint',
	)
);
$wp_customize->add_control(
	'disable_sidebar_pages',
	array(
		'type' => 'checkbox',
		'label' => __( 'Disable sidebar on all pages', 'pipdig-textdomain' ),
		'section' => 'pipdig_layout',
	)
);


if ( class_exists('Woocommerce') ) { // woocommerce active?
	// is_woocommerce() sidebar
	$wp_customize->add_setting('disable_sidebar_woocommerce',
		array(
			'default' => 0,
			'sanitize_callback' => 'absint',
		)
	);
	$wp_customize->add_control(
		'disable_sidebar_woocommerce',
		array(
			'type' => 'checkbox',
			'label' => __( 'Disable sidebar on WooCommerce', 'pipdig-textdomain' ),
			'section' => 'pipdig_layout',
		)
	);
}


// Post Layouts section ==========================================================================

// Homepage layout
$wp_customize->add_setting('home_layout',
	array(
		'default' => 1,
		'sanitize_callback' => 'absint',
	)
);
$wp_customize->add_control('home_layout',
	array(
		'type' => 'radio',
		'label' => __('Homepage layout', 'pipdig-textdomain'),
		'description' => __("This setting will effect posts displayed on the homepage.", 'pipdig-textdomain'),
		'section' => 'post_layouts',
		'choices' => array(
			1 => __('Full blog posts', 'pipdig-textdomain'),
			2 => __('Excerpt/Summary only', 'pipdig-textdomain'),
			3 => __('1st post Full, then grid for others', 'pipdig-textdomain'),
			5 => __('1st post Excerpt, then grid for others', 'pipdig-textdomain'),
			4 => __('Grid', 'pipdig-textdomain'),
			//6 => __('Mosaic', 'pipdig-textdomain'),
		),
	)
);

// categories layout
$wp_customize->add_setting('category_layout',
	array(
		'default' => 1,
		'sanitize_callback' => 'absint',
	)
);
$wp_customize->add_control('category_layout',
	array(
		'type' => 'radio',
		'label' => __('Post Categories layout', 'pipdig-textdomain'),
		'description' => __("This setting will effect posts displayed in categories.", 'pipdig-textdomain'),
		'section' => 'post_layouts',
		'choices' => array(
			1 => __('Full blog posts', 'pipdig-textdomain'),
			2 => __('Excerpt/Summary only', 'pipdig-textdomain'),
			3 => __('1st post Full, then grid for others', 'pipdig-textdomain'),
			5 => __('1st post Excerpt, then grid for others', 'pipdig-textdomain'),
			4 => __('Grid', 'pipdig-textdomain'),
			//6 => __('Mosaic', 'pipdig-textdomain'),
		),
	)
);

// Excerpt length
$wp_customize->add_setting( 'excerpt_length_num', array(
	'default' => 35,
	'capability' => 'edit_theme_options',
	'sanitize_callback' => 'absint',
	)
);
$wp_customize->add_control( 'excerpt_length_num', array(
	'type' => 'number',
	'label' => __('Excerpt length (words):', 'pipdig-textdomain'),
	'description' => __("This setting will effect all posts when using an excerpt based layout.", 'pipdig-textdomain'),
	'section' => 'post_layouts',
	'input_attrs' => array(
		'min' => 0,
		'max' => 150,
		'step' => 5,
		),
	)
);

 


// Post options section ==========================================================================

// Show socialz in post signature?
$wp_customize->add_setting('show_socialz_signature',
	array(
		'default' => 0,
		'sanitize_callback' => 'absint',
	)
);
$wp_customize->add_control(
	'show_socialz_signature',
	array(
		'type' => 'checkbox',
		'label' => __( 'Display Social Media follow section', 'pipdig-textdomain' ),
		'description' => __( 'This option will add links to your social media pages at the end of each post.', 'pipdig-textdomain' ),
		'section' => 'pipdig_posts',
	)
);

// Show author under title?
$wp_customize->add_setting('show_author',
	array(
		'default' => 0,
		'sanitize_callback' => 'absint',
	)
);
$wp_customize->add_control(
	'show_author',
	array(
		'type' => 'checkbox',
		'label' => __( 'Show author name on posts', 'pipdig-textdomain' ),
		'description' => __( 'Shows the author\'s name next to the date on each post header', 'pipdig-textdomain' ),
		'section' => 'pipdig_posts',
	)
);

// Signature image
$wp_customize->add_setting('post_signature_image',
	array(
		'sanitize_callback' => 'esc_url_raw',
	)
);
$wp_customize->add_control(
	new WP_Customize_Image_Control(
		$wp_customize,
		'signature_image',
		array(
			'label' => __( 'Post signature image', 'pipdig-textdomain' ),
			'description' => __( 'This image will be shown in the footer of your posts', 'pipdig-textdomain' ),
			'section' => 'pipdig_posts',
			'settings' => 'post_signature_image',
		)
	)
);

// Hide comments link
$wp_customize->add_setting('hide_comments_link',
	array(
		'default' => 0,
		'sanitize_callback' => 'absint',
	)
);
$wp_customize->add_control('hide_comments_link',
	array(
		'type' => 'checkbox',
		'label' => __( 'Remove link to comments', 'pipdig-textdomain' ),
		'description' => __( 'This option will remove the "No comments" or "x Comments" link from posts on the home page', 'pipdig-textdomain' ),
		'section' => 'pipdig_posts',
	)
);

// Hide tags
$wp_customize->add_setting('hide_post_tags',
	array(
		'default' => 0,
		'sanitize_callback' => 'absint',
	)
);
$wp_customize->add_control('hide_post_tags',
	array(
		'type' => 'checkbox',
		'label' => __( 'Remove tags from posts', 'pipdig-textdomain' ),
		'description' => __( 'Select this option if you would prefer for your tags not to be shown at the bottom of posts', 'pipdig-textdomain' ),
		'section' => 'pipdig_posts',
	)
);



// Post carousels section ==========================================================================

// Enable post carousel Footer
$wp_customize->add_setting('posts_carousel_footer',
	array(
		'default' => 0,
		'sanitize_callback' => 'absint',
	)
);
$wp_customize->add_control(
	'posts_carousel_footer',
	array(
		'type' => 'checkbox',
		'label' => __('Enable post carousel in footer', 'pipdig-textdomain'),
		'section' => 'pipdig_post_carousels',
	)
);

// Date criteria for posts in carousel
$wp_customize->add_setting('posts_carousel_dates',
    array(
        'default' => '1 year ago',
		'sanitize_callback' => 'pipdig_sanitize_trending_dates',
    )
);
$wp_customize->add_control('posts_carousel_dates',
    array(
        'type' => 'select',
        'label' => __('Date range for posts:', 'pipdig-textdomain'),
        'section' => 'pipdig_post_carousels',
        'choices' => array(
            '1 year ago' => __('1 Year', 'pipdig-textdomain'),
            '1 month ago' => __('1 Month', 'pipdig-textdomain'),
            '1 week ago' => __('1 Week', 'pipdig-textdomain'),
			'' => __('All Time', 'pipdig-textdomain'),
        ),
    )
);

// Choose a category
$wp_customize->add_setting('posts_carousel_category'); //can we sanitize this?
$wp_customize->add_control(
    new WP_Customize_Category_Control(
        $wp_customize,
        'posts_carousel_category',
        array(
            'label'    => __('Only display posts from:', 'pipdig-textdomain'),
            'settings' => 'posts_carousel_category',
            'section'  => 'pipdig_post_carousels'
        )
    )
);

// text color
$wp_customize->add_setting('posts_carousel_text_color',
	array(
		'default' => '#ffffff',
		//'transport'=>'postMessage',
		'sanitize_callback' => 'sanitize_hex_color',
	)
);
$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'posts_carousel_text_color',
	array(
		'label' => __( 'Text color', 'pipdig-textdomain' ),
		'section' => 'pipdig_post_carousels',
		'settings' => 'posts_carousel_text_color',
	)
	)
);

// background
$wp_customize->add_setting('posts_carousel_bg_color',
	array(
		'default' => '#000000',
		'sanitize_callback' => 'sanitize_hex_color',
	)
);
$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'posts_carousel_bg_color',
	array(
		'label' => __( 'Background color', 'pipdig-textdomain' ),
		'section' => 'pipdig_post_carousels',
		'settings' => 'posts_carousel_bg_color',
	)
	)
);




// Large Top slider section ==========================================================================

// Top area Posts Slider
$wp_customize->add_setting('top_slider',
	array(
		'default' => 0,
		'sanitize_callback' => 'absint',
	)
);
$wp_customize->add_control('top_slider',
	array(
		'type' => 'checkbox',
		'label' => __( 'Enable large post slider', 'pipdig-textdomain' ),
		'section' => 'pipdig_top_slider',
	)
);

// Choose a category
$wp_customize->add_setting( 'top_slider_category', array(
	'sanitize_callback' => 'absint',
	)
);
$wp_customize->add_control(
    new WP_Customize_Category_Control(
        $wp_customize,
        'top_slider_category',
        array(
            'label'    => __('Only display posts from:', 'pipdig-textdomain'),
            'settings' => 'top_slider_category',
            'section'  => 'pipdig_top_slider'
        )
    )
);

// Exclude a category
$wp_customize->add_setting( 'top_slider_category_exclude', array(
	'sanitize_callback' => 'absint',
	)
);
$wp_customize->add_control(
    new WP_Customize_Category_Control_Exclude(
        $wp_customize,
        'top_slider_category_exclude',
        array(
            'label'    => __('Do NOT display posts from:', 'pipdig-textdomain'),
            'settings' => 'top_slider_category_exclude',
            'section'  => 'pipdig_top_slider'
        )
    )
);

$wp_customize->add_setting( 'top_slider_posts', array(
	'default' => 4,
	'sanitize_callback' => 'absint',
	)
);

$wp_customize->add_control( 'top_slider_posts', array(
    'type' => 'number',
    'section' => 'pipdig_top_slider',
    'label' => __( 'Number of Post to display:', 'pipdig-textdomain' ),
    'input_attrs' => array(
        'min' => 2,
        'max' => 6,
        'step' => 1,
		),
	)
);


// Instagram Footer section ==========================================================================

// Instagram footer
$wp_customize->add_setting('footer_instagram',
	array(
		'default' => 0,
		'sanitize_callback' => 'absint',
	)
);
$wp_customize->add_control(
	'footer_instagram',
	array(
		'type' => 'checkbox',
		'label' => __('Enable Instagram feed in footer', 'pipdig-textdomain'),
		'section' => 'pipdig_instagram_footer',
	)
);
// Number of images to display in instagram footer feed
$wp_customize->add_setting(
    'footer_instagram_num',
    array(
        'default' => '10',
		'sanitize_callback' => 'absint',
    )
);
$wp_customize->add_control('footer_instagram_num',
    array(
        'type' => 'select',
        'label' => __('Number of images to show in Instagram feed in the footer', 'pipdig-textdomain'),
        'section' => 'pipdig_instagram_footer',
        'choices' => array(
            '6' => '6',
            '7' => '7',
            '8' => '8',
            '9' => '9',
            '10' => '10',
        ),
    )
);





// General Options section ==========================================================================

// Left align menu
$wp_customize->add_setting('left_align_menu',
	array(
		'default' => 0,
		'sanitize_callback' => 'absint',
	)
);
$wp_customize->add_control(
	'left_align_menu',
	array(
		'type' => 'checkbox',
		'label' => __( 'Left-align the navbar', 'pipdig-textdomain' ),
		'description' => __( 'Select this option to align the navbar menu items to the left, rather than in the center.', 'pipdig-textdomain' ),
		'section' => 'pipdig_general_options',
	)
);

// Add search toggle to navbar (scotch)
$wp_customize->add_setting('site_top_search',
	array(
		'default' => 0,
		'sanitize_callback' => 'absint',
	)
);
$wp_customize->add_control(
	'site_top_search',
	array(
		'type' => 'checkbox',
		'label' => __( 'Search button', 'pipdig-textdomain' ),
		'section' => 'p3_navbar_icons_section',
	)
);

// Show socialz in footer with counter?
$wp_customize->add_setting('social_count_footer',
	array(
		'default' => 0,
		'sanitize_callback' => 'absint',
	)
);
$wp_customize->add_control(
	'social_count_footer',
	array(
		'type' => 'checkbox',
		'label' => __( 'Display social counter in the Footer', 'pipdig-textdomain' ),
		'description' => __( 'Select this option to show your social media follower counts at the bottom of your website.', 'pipdig-textdomain' ),
		'section' => 'pipdig_general_options',
	)
);

// Page comments
$wp_customize->add_setting('page_comments',
	array(
		'default' => 0,
		'sanitize_callback' => 'absint',
	)
);
$wp_customize->add_control('page_comments',
	array(
		'type' => 'checkbox',
		'label' => __('Enable comments on pages', 'pipdig-textdomain'),
		'description' => __('Select this option to enable comments on pages. This does not effect posts.', 'pipdig-textdomain'),
		'section' => 'pipdig_general_options',
	)
);


$wp_customize->add_setting('copyright_statement',
	array(
		'sanitize_callback' => 'pipdig_sanitize_text_html',
	)
);
$wp_customize->add_control(
	'copyright_statement',
	array(
		'type' => 'text',
		'label' => __( 'Copyright text in footer:', 'pipdig-textdomain' ),
		'section' => 'pipdig_general_options',
		'input_attrs' => array(
        'placeholder' => '',
		),
	)
);





// Background Image section ===============================================
	
$wp_customize->add_setting('pipdig_background_image',
	array(
		'sanitize_callback' => 'esc_url_raw',
	)
);
$wp_customize->add_control(
	new WP_Customize_Image_Control(
		$wp_customize,
		'upload_background_image',
		array(
			'label'      => __( 'Upload image', 'pipdig-textdomain' ),
			'section'    => 'pipdig_backgrounds',
			'settings'   => 'pipdig_background_image',
		)
	)
);

// Background image repeat or backstretch
$wp_customize->add_setting('pipdig_background_repeats',
    array(
        'default' => 'repeat',
		'sanitize_callback' => 'pipdig_sanitize_background_repeats',
    )
);
$wp_customize->add_control('pipdig_background_repeats',
    array(
        'type' => 'select',
        'label' => __('Date range for Popular Posts:', 'pipdig-textdomain'),
        'section' => 'pipdig_backgrounds',
        'choices' => array(
            'repeat' => __('Tile', 'pipdig-textdomain'),
            'repeat-x' => __('Tile Horizontally', 'pipdig-textdomain'),
            'repeat-y' => __('Tile Vertically', 'pipdig-textdomain'),
			'' => __('Stretch Full Screen', 'pipdig-textdomain'),
        ),
    )
);
	

			
// Woocommerce section ==========================================================================	
if ( class_exists('Woocommerce') ) { // wocommerce active?

$wp_customize->add_setting( 'number_of_products_index', array(
	'default' => 20,
	'capability' => 'edit_theme_options',
	'sanitize_callback' => 'absint',
	)
);

$wp_customize->add_control( 'number_of_products_index', array(
    'type' => 'number',
    'priority' => 10,
    'section' => 'pipdig_woocommerce',
    'label' => __( 'Number of Products displayed in the shop:', 'pipdig-textdomain' ),
    'input_attrs' => array(
        'min' => 4,
        'max' => 40,
        'step' => 4,
		),
	)
);

// Hide social sharing icons
$wp_customize->add_setting('hide_social_sharing_products',
	array(
		'default' => 0,
		'sanitize_callback' => 'absint',
	)
);
$wp_customize->add_control('hide_social_sharing_products',
	array(
		'type' => 'checkbox',
		'label' => __( 'Remove sharing icons from products', 'pipdig-textdomain' ),
		'description' => __( 'Select this option if you would prefer to use your own plugin for social sharing icons on products', 'pipdig-textdomain' ),
		'section' => 'pipdig_woocommerce',
	)
);

} // end if check woo
		


// Theme colors section ==========================================================================

// Navbar background color
$wp_customize->add_setting('navbar_background_color',
	array(
		'default' => '#000000',
		'transport'=>'postMessage',
		'sanitize_callback' => 'sanitize_hex_color',
	)
);
$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'navbar_background_color',
	array(
		'label' => __( 'Navbar background color', 'pipdig-textdomain' ),
		'section' => 'pipdig_colors',
		'settings' => 'navbar_background_color',
	)
	)
);

// Navbar text color
$wp_customize->add_setting('navbar_text_color',
	array(
		'default' => '#ffffff',
		'transport'=>'postMessage',
		'sanitize_callback' => 'sanitize_hex_color',
	)
);
$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'navbar_text_color',
	array(
		'label' => __( 'Navbar text color', 'pipdig-textdomain' ),
		'section' => 'pipdig_colors',
		'settings' => 'navbar_text_color',
	)
	)
);

// Navbar text color hover
$wp_customize->add_setting('navbar_text_color_hover',
	array(
		'default' => '#d1bc61',
		'sanitize_callback' => 'sanitize_hex_color',
	)
);
$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'navbar_text_color_hover',
	array(
		'label' => __( 'Navbar text hover color', 'pipdig-textdomain' ),
		'section' => 'pipdig_colors',
		'settings' => 'navbar_text_color_hover',
	)
	)
);

// Navbar border color
$wp_customize->add_setting('navbar_border_color',
	array(
		'default' => '#cccccc',
		'transport'=>'postMessage',
		'sanitize_callback' => 'sanitize_hex_color',
	)
);
$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'navbar_border_color',
	array(
		'label' => __( 'Navbar border color', 'pipdig-textdomain' ),
		'section' => 'pipdig_colors',
		'settings' => 'navbar_border_color',
	)
	)
);


// Header text color
$wp_customize->add_setting('header_color',
	array(
		'default' => '#000000',
		'transport'=>'postMessage',
		'sanitize_callback' => 'sanitize_hex_color',
	)
);
$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'header_color',
	array(
		'label' => __( 'Header text color', 'pipdig-textdomain' ),
		'section' => 'pipdig_colors',
		'settings' => 'header_color',
	)
	)
);
      

// Outer background color
$wp_customize->add_setting('outer_background_color',
	array(
		'default' => '#ffffff',
		'sanitize_callback' => 'sanitize_hex_color',
	)
);
$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'outer_background_color',
	array(
		'label' => __( 'Outer background color', 'pipdig-textdomain' ),
		'section' => 'pipdig_colors',
		'settings' => 'outer_background_color',
	)
	)
);

// Content background color
$wp_customize->add_setting('content_background_color',
	array(
		'default' => '#ffffff',
		'sanitize_callback' => 'sanitize_hex_color',
	)
);
$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'content_background_color',
	array(
		'label' => __( 'Content background color', 'pipdig-textdomain' ),
		'section' => 'pipdig_colors',
		'settings' => 'content_background_color',
	)
	)
);
	  
// Post title color
$wp_customize->add_setting('post_title_color',
	array(
		'default' => '#000000',
		'sanitize_callback' => 'sanitize_hex_color',
	)
);
$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'post_title_color',
	array(
		'label' => __( 'Post title color', 'pipdig-textdomain' ),
		'section' => 'pipdig_colors',
		'settings' => 'post_title_color',
	)
	)
);


// Post title hover color
$wp_customize->add_setting('post_title_hover_color',
	array(
		'default' => '#d1bc61',
		'sanitize_callback' => 'sanitize_hex_color',
	)
);
$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'post_title_hover_color',
	array(
		'label' => __( 'Post title hover color', 'pipdig-textdomain' ),
		'section' => 'pipdig_colors',
		'settings' => 'post_title_hover_color',
	)
	)
);


// Text links color
$wp_customize->add_setting('post_links_color',
	array(
		'default' => '#d1bc61',
		'transport'=>'postMessage',
		'sanitize_callback' => 'sanitize_hex_color',
	)
);
$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'post_links_color',
	array(
		'label' => __( 'Text links color', 'pipdig-textdomain' ),
		'section' => 'pipdig_colors',
		'settings' => 'post_links_color',
	)
	)
);


// Text links hover color
$wp_customize->add_setting('post_links_hover_color',
	array(
		'default' => '#000000',
		'sanitize_callback' => 'sanitize_hex_color',
	)
);
$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'post_links_hover_color',
	array(
		'label' => __( 'Text links hover color', 'pipdig-textdomain' ),
		'section' => 'pipdig_colors',
		'settings' => 'post_links_hover_color',
	)
	)
);


// Widget title background color
$wp_customize->add_setting('pipdig_widget_title_color',
	array(
		'default' => '#000000',
		'sanitize_callback' => 'sanitize_hex_color',
	)
);
$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'pipdig_widget_title_color',
	array(
		'label' => __( 'Widget title background color', 'pipdig-textdomain' ),
		'section' => 'pipdig_colors',
		'settings' => 'pipdig_widget_title_color',
	)
	)
);

// Widget title text color
$wp_customize->add_setting('pipdig_widget_title_text_color',
	array(
		'default' => '#ffffff',
		'transport'=>'postMessage',
		'sanitize_callback' => 'sanitize_hex_color',
	)
);
$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'pipdig_widget_title_text_color',
	array(
		'label' => __( 'Widget title text color', 'pipdig-textdomain' ),
		'section' => 'pipdig_colors',
		'settings' => 'pipdig_widget_title_text_color',
	)
	)
);


// Social Icon color
$wp_customize->add_setting('social_color',
	array(
		'default' => '#000000',
		'transport'=>'postMessage',
		'sanitize_callback' => 'sanitize_hex_color',
	)
);
$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'social_color',
	array(
		'label' => __( 'Social Icon color', 'pipdig-textdomain' ),
		'section' => 'pipdig_colors',
		'settings' => 'social_color',
	)
	)
);

// Social Icon Hover color
$wp_customize->add_setting('social_hover_color',
	array(
		'default' => '#d1bc61',
		'sanitize_callback' => 'sanitize_hex_color',
	)
);
$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'social_hover_color',
	array(
		'label' => __( 'Social Icon Hover color', 'pipdig-textdomain' ),
		'section' => 'pipdig_colors',
		'settings' => 'social_hover_color',
	)
	)
);



// Bloglovin widget =========================================================================

	// background color
	$wp_customize->add_setting('pipdig_bloglovin_widget_background_color',
		array(
			'default' => '#ffffff',
			//'transport'=>'postMessage',
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'pipdig_bloglovin_widget_background_color',
		array(
			'label' => __( 'Background color', 'pipdig-textdomain' ),
			'section' => 'pipdig_bloglovin',
			'settings' => 'pipdig_bloglovin_widget_background_color',
		)
		)
	);

	// border color
	$wp_customize->add_setting('pipdig_bloglovin_widget_border_color',
		array(
			'default' => '#cccccc',
			//'transport'=>'postMessage',
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'pipdig_bloglovin_widget_border_color',
		array(
			'label' => __( 'Border color', 'pipdig-textdomain' ),
			'section' => 'pipdig_bloglovin',
			'settings' => 'pipdig_bloglovin_widget_border_color',
		)
		)
	);

	// text color
	$wp_customize->add_setting('pipdig_bloglovin_widget_text_color',
		array(
			'default' => '#000000',
			//'transport'=>'postMessage',
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'pipdig_bloglovin_widget_text_color',
		array(
			'label' => __( 'Text color', 'pipdig-textdomain' ),
			'section' => 'pipdig_bloglovin',
			'settings' => 'pipdig_bloglovin_widget_text_color',
		)
		)
	);

	$wp_customize->add_setting('pipdig_bloglovin_widget_icon',
		array(
			'default' => 'heart',
			//'sanitize_callback' => 'bloglovin_widget_sanitize_icon',
		)
	);
	 
	$wp_customize->add_control('pipdig_bloglovin_widget_icon',
		array(
			'type' => 'radio',
			'label' => __( 'Widget Icon', 'pipdig-textdomain' ),
			'section' => 'pipdig_bloglovin',
			'choices' => array(
				'heart' => __( 'Heart', 'pipdig-textdomain' ),
				'plus' => __( 'Plus', 'pipdig-textdomain' ),
				'none' => __( 'None', 'pipdig-textdomain' ),
			),
		)
	);


// Use Bloglovin official widget?
$wp_customize->add_setting('pipdig_bloglovin_widget_official',
	array(
		'default' => 0,
		'sanitize_callback' => 'absint',
	)
);
$wp_customize->add_control('pipdig_bloglovin_widget_official',
	array(
		'type' => 'checkbox',
		'label' => __( "Use the official Bloglovin' widget", 'pipdig-textdomain' ),
		'description' => __( "Select this option if you would prefer to use the official Bloglovin' widget.", 'pipdig-textdomain' ),
		'section' => 'pipdig_bloglovin',
	)
);

// Font sizes =====================================================================

// Feature Google font
/*
$wp_customize->add_setting('google_font_titles',
    array(
        'default' => 'MillingtonDuo',
		'sanitize_callback' => 'pipdig_sanitize_fonts',
    )
);
$wp_customize->add_control('google_font_titles',
	array(
		'type' => 'select',
        'label' => __('Feature/Titles font:', 'pipdig-textdomain'),
        'section' => 'pipdig_fonts',
        'choices' => array(
			'MillingtonDuo' => 'Millington',
			'Anton' => 'Anton',
			'Roboto' => 'Roboto',
			'Philosopher' => 'Philosopher',
			'Raleway' => 'Raleway',
			'Lato' => 'Lato',
			'Open+Sans' => 'Open Sans',
			'Quicksand' => 'Quicksand',
			'Playfair+Display' => 'Playfair Display',
			'Merriweather' => 'Merriweather',
			'Lora' => 'Lora',
			'Abril+Fatface' => 'Abril Fatface',
			'Crimson+Text' => 'Crimson Text',
			'Old+Standard+TT' => 'Old Standard TT',
			'Amatic+SC' => 'Amatic SC',
        ),
    )
);
*/
// Main body font
$wp_customize->add_setting('font_body',
    array(
        'default' => 'Georgia,serif',
		'sanitize_callback' => 'pipdig_sanitize_body_fonts',
    )
);
$wp_customize->add_control('font_body',
	array(
		'type' => 'select',
        'label' => __('Body font:', 'pipdig-textdomain'),
        'section' => 'pipdig_fonts',
        'choices' => array(
			'Georgia,serif' => 'Georgia',
			'Verdana,sans-serif' => 'Verdana',
			'Arial,Helvetica,sans-serif' => 'Arial',
			'"Trebuchet MS",Helvetica,sans-serif' => 'Trebuchet',
			'Tahoma,Geneva,sans-serif' => 'Tahoma',
			'"Palatino Linotype", "Book Antiqua", Palatino, serif' => 'Palatino Linotype',
			'"Times New Roman",Times,serif' => 'Times New Roman',
        ),
    )
);

$wp_customize->add_setting( 'header_font_size', array(
	'default' => 64,
	'capability' => 'edit_theme_options',
	'sanitize_callback' => 'absint',
	)
);

$wp_customize->add_control( 'header_font_size', array(
    'type' => 'number',
    'section' => 'pipdig_fonts',
    'label' => __( 'Header Text:', 'pipdig-textdomain' ),
    'input_attrs' => array(
        'min' => 4,
        'max' => 120,
        'step' => 1,
		),
	)
);

$wp_customize->add_setting( 'body_font_size', array(
	'default' => 14,
	'capability' => 'edit_theme_options',
	'sanitize_callback' => 'absint',
	)
);

$wp_customize->add_control( 'body_font_size', array(
    'type' => 'number',
    'section' => 'pipdig_fonts',
    'label' => __( 'Main body:', 'pipdig-textdomain' ),
    'input_attrs' => array(
        'min' => 4,
        'max' => 40,
        'step' => 1,
		),
	)
);

$wp_customize->add_setting( 'post_title_font_size', array(
	'default' => 32,
	'capability' => 'edit_theme_options',
	'sanitize_callback' => 'absint',
	)
);

$wp_customize->add_control( 'post_title_font_size', array(
    'type' => 'number',
    'section' => 'pipdig_fonts',
    'label' => __( 'Post titles:', 'pipdig-textdomain' ),
    'input_attrs' => array(
        'min' => 4,
        'max' => 40,
        'step' => 1,
		),
	)
);



/*
$wp_customize->add_setting( 'widget_title_font_size', array(
	'default' => 11,
	'capability' => 'edit_theme_options',
	'sanitize_callback' => 'absint',
	)
);

$wp_customize->add_control( 'widget_title_font_size', array(
    'type' => 'number',
    'section' => 'pipdig_fonts',
    'label' => __( 'Widget titles:', 'pipdig-textdomain' ),
    'input_attrs' => array(
        'min' => 4,
        'max' => 40,
        'step' => 1,
		),
	)
);
*/


// Italic Post Titles
$wp_customize->add_setting('pipdig_italic_post_titles',
	array(
		'default' => 1,
		'sanitize_callback' => 'absint',
	)
);
$wp_customize->add_control('pipdig_italic_post_titles',
	array(
		'type' => 'checkbox',
		'label' => __( "Italic post titles", 'pipdig-textdomain' ),
		'description' => __( "The post titles in this theme are set as italic by default. Uncheck this option to disable this.", 'pipdig-textdomain' ),
		'section' => 'pipdig_fonts',
	)
);


// Disable uppercase titles
$wp_customize->add_setting('text_transform',
	array(
		'default' => 0,
		'sanitize_callback' => 'absint',
	)
);
$wp_customize->add_control('text_transform',
	array(
		'type' => 'checkbox',
		'label' => __( 'Lowercase text', 'pipdig-textdomain' ),
		'description' => __( 'This theme converts text such as widget titles to uppercase (capital letters). Select this option to disable this. This is useful if you change the fonts in the theme.', 'pipdig-textdomain' ),
		'section' => 'pipdig_fonts',
	)
);



}




public static function live_preview() {
	wp_enqueue_script( 
		'pipdig-themecustomizer', // Give the script a unique ID
		get_template_directory_uri() . '/inc/customizer.js', // Define the path to the JS file
		array(  'jquery', 'customize-preview' ), // Define dependencies
		'', // Define a version (optional) 
		true // Specify whether to put in footer (leave this true)
	);
	}
}

// Setup the Theme Customizer settings and controls...
add_action( 'customize_register' , array( 'pipdig_Customize' , 'register' ) );

// Enqueue live preview javascript in Theme Customizer admin screen
add_action( 'customize_preview_init' , array( 'pipdig_Customize' , 'live_preview' ) );




function pipdig_sanitize_sidebar_position( $input ) {
    $valid = array(
		'left' => __( 'Left', 'pipdig-textdomain' ),
		'right' => __( 'Right', 'pipdig-textdomain' ),
    );
 
    if ( array_key_exists( $input, $valid ) ) {
        return $input;
    } else {
        return '';
    }
}
function pipdig_sanitize_background_repeats( $input ) {
    $valid = array(
		'repeat' => __('Tile', 'pipdig-textdomain'),
        'repeat-x' => __('Tile Horizontally', 'pipdig-textdomain'),
        'repeat-y' => __('Tile Vertically', 'pipdig-textdomain'),
		'' => __('Stretch Full Screen', 'pipdig-textdomain'),
    );
 
    if ( array_key_exists( $input, $valid ) ) {
        return $input;
    } else {
        return '';
    }
}
function pipdig_sanitize_fonts( $input ) {
    $valid = array(
		'MillingtonDuo' => 'Millington',
		'Anton' => 'Anton',
		'Roboto' => 'Roboto',
		'Philosopher' => 'Philosopher',
		'Raleway' => 'Raleway',
		'Lato' => 'Lato',
		'Open+Sans' => 'Open Sans',
		'Quicksand' => 'Quicksand',
		'Playfair+Display' => 'Playfair Display',
		'Merriweather' => 'Merriweather',
		'Lora' => 'Lora',
		'Abril+Fatface' => 'Abril Fatface',
		'Crimson+Text' => 'Crimson Text',
		'Old+Standard+TT' => 'Old Standard TT',
		'Amatic+SC' => 'Amatic SC',
    );
    if ( array_key_exists( $input, $valid ) ) {
        return $input;
    } else {
        return '';
    }
}
function pipdig_sanitize_body_fonts( $input ) {
    $valid = array(
		'Verdana,sans-serif' => 'Verdana',
		'Arial,Helvetica,sans-serif' => 'Arial',
		'"Trebuchet MS",Helvetica,sans-serif' => 'Trebuchet',
		'Tahoma,Geneva,sans-serif' => 'Tahoma',
		'Georgia,serif' => 'Georgia',
		'"Palatino Linotype", "Book Antiqua", Palatino, serif' => 'Palatino Linotype',
		'"Times New Roman",Times,serif' => 'Times New Roman',
    );
    if ( array_key_exists( $input, $valid ) ) {
        return $input;
    } else {
        return '';
    }
}
function pipdig_sanitize_trending_dates( $input ) {
    $valid = array(
		'1 year ago' => __('1 Year', 'pipdig-textdomain'),
		'1 month ago' => __('1 Month', 'pipdig-textdomain'),
		'1 week ago' => __('1 Week', 'pipdig-textdomain'),
		'' => __('All Time', 'pipdig-textdomain'),
    );
 
    if ( array_key_exists( $input, $valid ) ) {
        return $input;
    } else {
        return '';
    }
}
function pipdig_sanitize_text_html( $input ) {
    return wp_kses_post( force_balance_tags( $input ) );
}



function pipdig_customizer_head_styles() {
		
	$styles_output = '';

	// .container max-width
	$container_width = get_theme_mod( 'container_width' ); 
	if ( ($container_width != 1080 && $container_width != null) ) {
		$styles_output .= '.container{max-width:' . $container_width . 'px}';
	}

	// Header image top padding
	$header_image_top_padding = get_theme_mod( 'header_image_top_padding' ); 
	if ( ($header_image_top_padding != 0 && $header_image_top_padding != null) ) {
		$styles_output .= '.site-title img{padding-top:' . $header_image_top_padding . 'px}';
	} 

	// Outer background color
	$outer_background_color = get_theme_mod( 'outer_background_color' ); 
	if ( ($outer_background_color != '#ffffff' && $outer_background_color != null) ) {
		$styles_output .= 'body{background:' . $outer_background_color . '}';
	} 
	
	// Content background color
	$content_background_color = get_theme_mod( 'content_background_color' ); 
	if ( ($content_background_color != '#ffffff' && $content_background_color != null) ) {
		$styles_output .= '.container,.widget-title span,.date-bar-white-bg,.venture-slider-title span, #trendingz h2 span,.pipdig-ls-full-width{background:' . $content_background_color . '}';
	}
	
	// Navbar background color
	$navbar_background_color = get_theme_mod( 'navbar_background_color' ); 
	if ( ($navbar_background_color != '#000000' && $navbar_background_color != null) ) {
		$styles_output .= '.site-top,.menu-bar ul ul,.slicknav_menu,.site-footer,.social-footer-outer{border:0;background:' . $navbar_background_color . '}';
	}
	
	// Navbar border color
	$navbar_border_color = get_theme_mod( 'navbar_border_color' ); 
	if ( ($navbar_border_color != '#cccccc' && $navbar_border_color != null) ) {
		$styles_output .= '.site-top{border-color:' . $navbar_border_color . '}';
	}
	
	// Navbar text color
	$navbar_text_color = get_theme_mod( 'navbar_text_color' ); 
	if ( ($navbar_text_color != '#ffffff' && $navbar_text_color != null) ) {
		$styles_output .= '.menu-bar ul li a,.slicknav_brand,.slicknav_brand a,.slicknav_nav a,.slicknav_menu .slicknav_menutxt,.site-footer,.site-footer a,.social-footer, .social-footer a{color:' . $navbar_text_color . '}';
	}
	
	
	// carosel background color
	$posts_carousel_bg_color = get_theme_mod( 'posts_carousel_bg_color' ); 
	if ( ($posts_carousel_bg_color != '#000000' && $posts_carousel_bg_color != null) ) {
		$styles_output .= '.carousel-footer-title{background:' . $posts_carousel_bg_color . '}';
	}
	
	// carosel text color
	$posts_carousel_text_color = get_theme_mod( 'posts_carousel_text_color' ); 
	if ( ($posts_carousel_text_color != '#ffffff' && $posts_carousel_text_color != null) ) {
		$styles_output .= '.carousel-footer-title{color:' . $posts_carousel_text_color . '}';
	}
	
	// Navbar text hover color
	$navbar_text_color_hover = get_theme_mod( 'navbar_text_color_hover' ); 
	if ( ($navbar_text_color_hover != '#d1bc61' && $navbar_text_color_hover != null) ) {
		$styles_output .= '.menu-bar ul li a:hover,.menu-bar ul ul li > a:hover,.menu-bar ul ul li:hover > a{color:' . $navbar_text_color_hover . '}';
	}
	
	// Post title color
	$post_title_color = get_theme_mod( 'post_title_color' ); 
	if ( ($post_title_color != '#000000' && $post_title_color != null) ) {
		$styles_output .= '.entry-title,.entry-title a{color:' . $post_title_color . '}';
	}


	// Post title hover color
	$post_title_hover_color = get_theme_mod( 'post_title_hover_color' ); 
	if ( ($post_title_hover_color != '#999999' && $post_title_hover_color != null) ) {
		$styles_output .= '.entry-title a:hover{color:' . $post_title_hover_color . '}';
	}

	// links color
	$post_links_color = get_theme_mod( 'post_links_color' ); 
	if ( ($post_links_color != '#d1bc61' && $post_links_color != null) ) {
		$styles_output .= 'a{color:' . $post_links_color . '}';
	}

	// links hover color
	$post_links_hover_color = get_theme_mod( 'post_links_hover_color' ); 
	if ( ($post_links_hover_color != '#000000' && $post_links_hover_color != null) ) {
		$styles_output .= 'a:hover,a:focus{color:' . $post_links_hover_color . '}';
	}

	// Widget title background color
	$pipdig_widget_title_color = get_theme_mod( 'pipdig_widget_title_color' ); 
	if ( ($pipdig_widget_title_color != '#000000' && $pipdig_widget_title_color != null) ) {
		$styles_output .= '.widget-title{background:' . $pipdig_widget_title_color . '}.widget-title::after{border-top-color:' . $pipdig_widget_title_color . '}.entry-header .entry-meta{border-color:' . $pipdig_widget_title_color .'}';
	}
	
	// Widget title text color
	$pipdig_widget_title_text_color = get_theme_mod( 'pipdig_widget_title_text_color' ); 
	if ( ($pipdig_widget_title_text_color != '#ffffff' && $pipdig_widget_title_text_color != null) ) {
		$styles_output .= '.widget-title{color:' . $pipdig_widget_title_text_color . '}';
	}

	// Header text color
	$header_color = get_theme_mod( 'header_color' );
	if ( ($header_color != '#000000' && $header_color != null) ) {
		$styles_output .= '.site-title a{color:' . $header_color . '}';
	}

	// Social Icon color
	$social_color = get_theme_mod( 'social_color' );
	if ( ($social_color != '#000000' && $social_color != null) ) {
		$styles_output .= '.socialz a{color:' . $social_color . '}';
	}

	// Social Icon Hover color
	$social_hover_color = get_theme_mod( 'social_hover_color' );
	if ( ($social_hover_color != '#d1bc61' && $social_hover_color != null) ) {
		$styles_output .= '.socialz a:hover{color:' . $social_hover_color . '}';
	} 
	
	$disclaimer_background_color = get_theme_mod( 'disclaimer_background_color' );
	if ( ($disclaimer_background_color != '#f8f8f8' && $disclaimer_background_color != null) ) {
		$styles_output .= '.disclaimer-text{background:' . $disclaimer_background_color . '}';
	}
	

	
	// FONT Sizes =====================
	
	// Main body font
	$font_body = get_theme_mod( 'font_body', 'Georgia,serif' );
	if ($font_body != 'Georgia,serif') {
		$styles_output .= 'body{font-family:' . $font_body . '}';
	}
	
	// Header font size
	$header_font_size = get_theme_mod( 'header_font_size' );
	if ( ($header_font_size != '64' && $header_font_size != null) ) {
		$styles_output .= '.site-title{font-size:' . $header_font_size . 'px}@media only screen and (max-width:769px){.site-title {font-size: 40px;font-size: 9vw}}';
	}
	
	// Body font size
	$body_font_size = get_theme_mod( 'body_font_size' );
	if ( ($body_font_size != '14' && $body_font_size != null) ) {
		$styles_output .= 'body{font-size:' . $body_font_size . 'px}';
	}
	
	// Post title font size
	$post_title_font_size = get_theme_mod( 'post_title_font_size' );
	if ( ($post_title_font_size != '32' && $post_title_font_size != null) ) {
		$styles_output .= '.entry-title{font-size:' . $post_title_font_size . 'px}.grid-title{height:' . $post_title_font_size . 'px;line-height:' . $post_title_font_size . 'px}@media only screen and (max-width:719px){.grid-title{height:auto}}';
	}


	$text_transform = get_theme_mod( 'text_transform' );
	// Stop posts titles going uppercase
	if ( $text_transform != 0 ) {
		$styles_output .= '.pipdig-related-title,.top-slider-section .read-more,.sharez,.pipdig-slider-cats,h1,h2,h3,h4,h5,h6,.site-description,.site-title,.menu-bar > ul > li > a,.menu-bar ul ul li a,.menu-bar ul li a,.entry-title,.entry-meta,.page-title,.page-links a,.site-main [class*="navigation"] a,.site-main .post-navigation a,.site-main .post-navigation .meta-nav,.comment-meta,.comment-author,.widget-title,.comment-date,.menu-titlez,.wpp-post-title,div#jp-relatedposts div.jp-relatedposts-items p,div#jp-relatedposts div.jp-relatedposts-items-visual h4.jp-relatedposts-post-title,.more-link,.cat-item a,.woocommerce table.shop_table th,.woocommerce a.button,.woocommerce .woocommerce-tabs li,.page-numbers a,.page-numbers span{text-transform:none}';
	}


	// Stop the navbar from sticking
	$stop_sticky_navbar = get_theme_mod( 'stop_sticky_navbar' );
	if ( $stop_sticky_navbar != 0 ) {
		$styles_output .= '.site-top{position:absolute}';
	}
	
	
	// Stop the navbar from sticking
	$show_author = get_theme_mod( 'show_author' );
	if ( $show_author != 0 ) {
		$styles_output .= '.show-author{display:inline}';
	}
	
	// background image and repeat setting (or backstretch)
	$repeat = get_theme_mod('pipdig_background_repeats');
	$bg_image = get_theme_mod('pipdig_background_image');
	if($bg_image) {
		if($repeat != '') { // if not set to backstretch:
			$styles_output .= 'body{background:url(' . $bg_image . ') ' . $repeat . ';}';
		}
	}
	
	
	// Bloglovin widget==========================

	// background color
	$pipdig_bloglovin_widget_background_color = get_theme_mod( 'pipdig_bloglovin_widget_background_color', '#ffffff' ); 
	if ($pipdig_bloglovin_widget_background_color != '#ffffff' ) {
		$styles_output .= '.pipdig-bloglovin-widget{background:' . $pipdig_bloglovin_widget_background_color . '}';
	}
		
	// border color
	$pipdig_bloglovin_widget_border_color = get_theme_mod( 'pipdig_bloglovin_widget_border_color', '#cccccc' ); 
	if ($pipdig_bloglovin_widget_border_color != '#cccccc' ) {
		$styles_output .= '.pipdig-bloglovin-widget{border:1px solid ' . $pipdig_bloglovin_widget_border_color . '}';
	}
		
	// text color
	$pipdig_bloglovin_widget_text_color = get_theme_mod( 'pipdig_bloglovin_widget_text_color', '#000000' ); 
	if ($pipdig_bloglovin_widget_text_color != '#000000') {
		$styles_output .= '.pipdig-bloglovin-widget,.wp-bloglovin-widget .fa{color:' . $pipdig_bloglovin_widget_text_color . '!important}';
	}

	//===========================================
	

	// Left sidebar
	$sidebar_position = get_theme_mod( 'sidebar_position' );
	if ($sidebar_position == 'left') {
		$styles_output .= '.site-sidebar{padding:0 30px 0 0;}';
	}
	
	// italic post titles
	if (!get_theme_mod('pipdig_italic_post_titles', 1)) {
		$styles_output .= 'h1,h2,h3,h4,h5,h6,blockquote p{font-style:normal}';
	}

	// left align menu items
	if (get_theme_mod('left_align_menu')) {
		$styles_output .= '.menu-bar{text-align:left}';
	}
	
	
	if ($styles_output) {
		echo '<!-- Cust --><style>'.$styles_output.'</style><!-- /Cust -->';
	}
}
add_action( 'wp_head', 'pipdig_customizer_head_styles' );
