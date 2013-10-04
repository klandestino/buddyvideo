<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Get the slug for our component
 *
*/
function buddyvideo_get_slug() {
	global $bp;

	// Avoid PHP warnings, in case the value is not set for some reason
	return $buddyvideo_slug = isset( $bp->buddyvideo->slug ) ? $bp->buddyvideo->slug : '';
}

/**
 * A check to see if user is online, used to add a class of online to the video chat button
 *
*/
function buddyvideo_is_user_online( $user_id ) {
	if ( bp_has_members( 'type=online&include='. $user_id ) ) {
		return true;
	} else {
		return false;
	}
}

/**
 * Returns link for use in the video chatt button
 *
*/
function buddyvideo_get_video_chat_link() {
	return wp_nonce_url( bp_loggedin_user_domain() . buddyvideo_get_slug() . '/chat?user=' . bp_displayed_user_id() . '&id=' . rand(), 'buddyvideo_nonce', 'buddyvideo_nonce' );
}

/**
 * Creates the start video chat button on user profiles
 *
*/
function buddyvideo_invite_button() {
	if ( buddyvideo_is_user_online( bp_displayed_user_id() ) ) {
		$link_class = 'send-message online';
	} else {
		$link_class = 'send-message';
	}

	bp_button( array(
		'id'                => 'buddyvideo',
		'must_be_logged_in' => true,
		'block_self'        => true,
		'wrapper_id'        => 'buddyvideo',
		'link_href'         => buddyvideo_get_video_chat_link(),
		'link_title'        => __( 'Video chat with this user.', 'buddyvideo' ),
		'link_text'         => __( 'Video chat', 'buddyvideo' ),
		'link_class'	=> $link_class,
	) );

}
add_action( 'bp_member_header_actions', 'buddyvideo_invite_button', 99 );

/**
 * Buddypress doesn't seem to have a way to get notifications for user by type/component,
 * this function gets all notifications for user with the type 'new_video_chat' from the component 'buddyvideo'
 *
*/
function buddyvideo_get_all_video_notifications_for_user( $user_id) {
	global $bp, $wpdb;

 	return $wpdb->get_results( $wpdb->prepare( "SELECT * FROM {$bp->core->table_name_notifications} WHERE user_id = %d AND component_name = 'buddyvideo' AND is_new = 1", $user_id ) );
}
?>