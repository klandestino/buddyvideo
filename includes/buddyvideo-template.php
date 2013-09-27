<?php

function buddyvideo_get_slug() {
	global $bp;

	// Avoid PHP warnings, in case the value is not set for some reason
	return $buddyvideo_slug = isset( $bp->buddyvideo->slug ) ? $bp->buddyvideo->slug : '';
}

function buddyvideo_is_user_online( $user_id ) {
	if ( bp_has_members( 'type=online&include='. $user_id ) ) {
		return true;
	} else {
		return false;
	}
}

function buddyvideo_get_video_chat_link() {
	return bp_loggedin_user_domain() . buddyvideo_get_slug() . '/chat?user=' . bp_displayed_user_id() . '&id=' . rand();
}

function buddyvideo_invite_button() {
	bp_button( array(
		'id'                => 'buddyvideo',
		'must_be_logged_in' => true,
		'block_self'        => true,
		'wrapper_id'        => 'buddyvideo',
		'link_href'         => buddyvideo_get_video_chat_link(),
		'link_title'        => __( 'Video chat with this user.', 'buddyvideo' ),
		'link_text'         => __( 'Video chat', 'buddyvideo' ),
		'link_class'        => 'send-message',
	) );
	if ( buddyvideo_is_user_online( bp_displayed_user_id() ) ) {
		echo 'online';
	} else {
		echo 'offline';
	}
}
add_action( 'bp_member_header_actions', 'buddyvideo_invite_button' );

function buddyvideo_get_all_video_notifications_for_user( $user_id) {
	global $bp, $wpdb;

 	return $wpdb->get_results( $wpdb->prepare( "SELECT * FROM {$bp->core->table_name_notifications} WHERE user_id = %d AND component_name = 'buddyvideo' AND is_new = 1", $user_id ) );
}
?>