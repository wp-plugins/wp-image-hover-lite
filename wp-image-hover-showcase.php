<?php

/*
Plugin Name: Wordpress Image Hover Lite
Plugin URI: http://codecanyon.net/user/phpbits?ref=phpbits
Description: Increase social sharing to boost your website traffic with Wordpress Image Hover. If you decide to upgrade to <a href="http://codecanyon.net/item/wordpress-image-hover-showcase/7455102?ref=phpbits" target="_blank"><strong>Wordpress Image Hover Showcase</strong></a>, please deactivate Wordpress Image Hover Lite first.
Version: 1.0.1
Author: phpbits
Author URI: http://codecanyon.net/user/phpbits?ref=phpbits
License: GPL2
*/

//avoid direct calls to this file
if (!function_exists('add_action')) {
    header('Status: 403 Forbidden');
    header('HTTP/1.1 403 Forbidden');
    exit();
}

/*##################################
	REQUIRE
################################## */

//Add Redux Framework
if ( !class_exists( 'ReduxFramework' ) && file_exists( dirname( __FILE__ ) . '/includes/redux-framework/ReduxCore/framework.php' ) ) {
	require_once( dirname( __FILE__ ) . '/includes/redux-framework/ReduxCore/framework.php' );
}


require_once( dirname( __FILE__ ) . '/plugins/wysiwyg.php');
require_once( dirname( __FILE__ ) . '/includes/socials.php');
require_once( dirname( __FILE__ ) . '/admin/functions.config.php');
require_once( dirname( __FILE__ ) . '/core/functions.display.php');

//Upgrade to pro version to enable widgets
// require_once( dirname( __FILE__ ) . '/core/functions.widget.php');

?>