<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Runs when video chat tab is visited
 *
*/
function buddyvideo_chat() {
	add_action( 'bp_template_content', 'buddyvideo_chat_content' );
	bp_core_load_template( apply_filters( 'bp_core_template_plugin', 'members/single/plugins' ) );
}
function buddyvideo_chat_content() {
	if ( isset( $_GET['user'] ) && isset( $_GET['id'] ) ) {
		$user = get_user_by( 'id', $_GET['user'] );
		bp_core_add_notification( $_GET['id'], $user->ID, 'buddyvideo', 'new_video_chat', bp_loggedin_user_id() );
		_e( 'Attempting to start video chat with:  ' . $user->user_nicename, 'buddyvideo');
		echo '<video autoplay id="myself"></video>';
	} elseif ( ! isset( $_GET['user'] ) && isset( $_GET['id'] ) ) {
		bp_core_delete_notifications_by_item_id( bp_loggedin_user_id(), $_GET['id'], 'buddyvideo', 'new_video_chat' );
		echo '<video autoplay id="myself"></video>';
	} else {
		_e( 'No video chats going on right now...', 'buddyvideo' );
	}
}

/**
 * Runs when video main tab is visited
 *
*/
function buddyvideo_list_chats() {
	add_action( 'bp_template_content', 'buddyvideo_list_chats_content' );
	bp_core_load_template( apply_filters( 'bp_core_template_plugin', 'members/single/plugins' ) );
}
function buddyvideo_list_chats_content() {
	$notifications = buddyvideo_get_all_video_notifications_for_user( bp_loggedin_user_id() );
	if ( $notifications ) {
		echo '<ul>';
		foreach ( $notifications as $notification ) {
			$user_fullname = bp_core_get_user_displayname( $notification->secondary_item_id, false );
			echo '<li><a href="' . bp_loggedin_user_domain() . buddyvideo_get_slug() . '/chat?id=' . $notification->item_id . '">' . sprintf( __( '%s wants to video chat!', 'buddyvideo' ), $user_fullname ) . '</a></li>';
		}
		echo '</ul>';
	} else {
		_e( 'No new video chat requests', 'buddyvideo' );
	}
}
?>