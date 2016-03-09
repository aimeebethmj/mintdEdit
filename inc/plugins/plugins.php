<?php 

require_once dirname( __FILE__ ) . '/tgm.php';

add_action( 'tgmpa_register', 'pipdig_plugins_install' );

function pipdig_plugins_install() {

    $plugins = array(
		array(
			'name' => 'Instagram Feed',
			'slug' => 'instagram-feed',
			'required' => true,
		),
		array(
			'name' => 'Regenerate Thumbnails',
			'slug' => 'regenerate-thumbnails',
			'required' => true,
		),
		array(
			'name' => 'Resize Image After Upload',
			'slug' => 'resize-image-after-upload',
			'required' => true,
		),
		array(
			'name' => 'Meta Box',
			'slug' => 'meta-box',
			'required' => true,
		),
		array(
			'name' => 'pipdig Power Pack (p3)',
			'slug' => 'p3',
			'source' => 'http://updates.pipdig.co/download.php?id=p3',
			'required' => true,
		),
    );

	$config = array(
		//'domain'         => 'pipdig-textdomain',
		//'default_path' => '',   // Default absolute path to pre-packaged plugins
		'menu'           => 'pipdig-plugins',
		'is_automatic'   => true,
		'strings'      	 => array(
			'page_title'             => 'Install Required Plugins',
			'menu_title'             => 'Install Plugins',
			'instructions_install'   => 'The %1$s plugin is required for this theme. Click on the big blue button below to install and activate %1$s.', // %1$s = plugin name
			'instructions_activate'  => 'The %1$s is installed but currently inactive. Please go to the <a href="%2$s">plugin administration page</a> page to activate it.', // %1$s = plugin name, %2$s = plugins page URL
			'button'                 => 'Install %s Now', // %1$s = plugin name
			'installing'             => 'Installing Plugin: %s', // %1$s = plugin name
			'oops'                   => 'Something went wrong with the plugin API.',
			'notice_can_install'     => 'This theme requires the %1$s plugin. <a href="%2$s"><strong>Click here to begin the installation process</strong></a>. You may be asked for FTP credentials based on your server setup.', // %1$s = plugin name, %2$s = TGMPA page URL
			'notice_cannot_install'  => 'Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', // %1$s = plugin name
			'notice_can_activate'    => 'This theme requires the %1$s plugin. That plugin is currently inactive, so please go to the <a href="%2$s">plugin administration page</a> to activate it.', // %1$s = plugin name, %2$s = plugins page URL
			'notice_cannot_activate' => 'Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', // %1$s = plugin name
			'return'                 => 'Return to Required Plugins Installer',
		),
	);

	tgmpa( $plugins, $config );

}

