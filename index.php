<?php
/*
Plugin Name: Buddyvideo
Plugin URI: http://klandestino.se/buddyvideo/
Description: Buddypress plugin that uses webRTC for p2p videochats
Version: 1.0
Requires at least: WordPress 3.6 / BuddyPress 1.8
Tested up to: WordPress 3.6.1 / BuddyPress 1.8.1
License: GNU/GPL 2
Author: Klandestino, redundans, lakrisgubben, alfreddatakillen
Author URI: http://klandestino.se
*/

// Define a constant that we can use to construct file paths throughout the component
define( 'BUDDYVIDEO_PLUGIN_DIR', dirname( __FILE__ ) );

/* Only load the component if BuddyPress is loaded and initialized. */
function bp_example_init() {
	// Because our loader file uses BP_Component, it requires BP 1.5 or greater.
	if ( version_compare( BP_VERSION, '1.3', '>' ) )
		require( dirname( __FILE__ ) . '/buddyvideo-component.php' );
}
add_action( 'bp_include', 'bp_example_init' );
?>