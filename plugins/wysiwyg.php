<?php
/*
 * Create Custom Wordpress Editor Button
 */
if ( !class_exists( "wpimghover_showcase" ) ) {
	class wpimghover_showcase{
		public function __construct() {
			add_action( 'init', array($this, 'add_buttons_filter') );
		}
		function add_buttons_filter() {
		    add_filter( "mce_external_plugins", array($this, 'add_buttons') );
		    add_filter( 'mce_buttons', array($this, 'register_buttons') );
		}
		function add_buttons( $plugin_array ) {
		    $plugin_array['wpimagehover'] = plugins_url('/editor-buttons/plugin.js',__FILE__);;
		    return $plugin_array;
		}
		function register_buttons( $buttons ) {
		    array_push( $buttons, 'wp_image_hover' ); // add button
		    return $buttons;
		}
	}
}
$wpimghover_showcase = new wpimghover_showcase();
?>