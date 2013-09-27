<?php

/**
 * The format notification function will take DB entries for notifications and format them
 * so that they can be displayed and read on the screen.
 *
 * Notifications are "screen" notifications, that is, they appear on the notifications menu
 * in the site wide navigation bar. They are not for email notifications.
 *
 *
 * The recording is done by using bp_core_add_notification() which you can search for in this file for
 * examples of usage.
 */
function buddyvideo_format_notifications( $action, $item_id, $secondary_item_id, $total_items ) {
	global $bp;

	switch ( $action ) {
		case 'new_video_chat':
			/* In this case, $secondary_item_id is the user ID of the user who sent the chat request. */

			$user_fullname = bp_core_get_user_displayname( $secondary_item_id, false );
			return apply_filters( 'buddyvideo_notification', '<a href="' . bp_loggedin_user_domain() . buddyvideo_get_slug() . '/chat?id=' . $item_id . '">' . sprintf( __( '%s wants to video chat!', 'buddyvideo' ), $user_fullname ) . '</a>', $user_fullname );

		break;
	}

	return false;
}
?>