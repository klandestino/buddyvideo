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

/* Only load code that needs BuddyPress to run once BP is loaded and initialized. */
function buddyvideo_init() {
	require( dirname( __FILE__ ) . '/buddyvideo.php' );
}
add_action( 'bp_include', 'buddyvideo_init' );
?>