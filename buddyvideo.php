<?php
function buddyvideo_is_user_online( $user_id ) {
	if ( bp_has_members( 'type=online&include='. $user_id ) ) {
		return true;
	} else {
		return false;
	}
}

function buddyvideo_setup_nav() {
	bp_core_new_nav_item( array(
		'name' => __( 'Video', 'buddyvideo' ),
		'slug' => 'video',
		'default_subnav_slug' => 'video',
		'screen_function' => 'buddyvideo_screen_settings_menu',
		'position' => 80,
		'show_for_displayed_user' => false
	) );
}
add_action( 'bp_setup_nav', 'buddyvideo_setup_nav' );

function buddyvideo_screen_settings_menu() {
	add_action( 'bp_template_content', 'buddyvideo_screen_settings_content' );
	bp_core_load_template( apply_filters( 'bp_core_template_plugin', 'members/single/plugins' ) );
}

function buddyvideo_screen_settings_content() {
	echo '<video></video>';
}

function buddyvideo_get_video_chat_link() {
	return wp_nonce_url( bp_loggedin_user_domain() . '/video?r=' . bp_core_get_username( bp_displayed_user_id() ) );
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
?>