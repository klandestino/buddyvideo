<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

function buddyvideo_callback() {
	$realm = $_POST['realm'];
	$action = $_POST['act'];

	switch ($action) {
		case 'find':
			if ( get_transient( $realm . '_offer' ) ) {
				echo get_transient( $offer_id . '_offer' );
			} else {
				echo null;
			}
		break;

		case 'offer':
			$id = random; // SET RANDOM ID!
			set_transient( $realm . '_offer', json_encode( array( 'id' => $_POST['id'], 'spd' => $_POST['spd'] ) ), 30 );
			echo json_encode( array( 'id' => $realm . '_offer' ) );
		break;

		case 'answer':
			set_transient( $realm . '_answer', json_encode( array( 'id' => $_POST['id'], 'spd' => $_POST['spd'] ) ), 30 );
			while ( ! get_transient( $realm . '_offercandidates' ) ) {
				usleep( 1000 );
			}
			echo get_transient( $realm . '_offercandidates' );
		break;

		case 'wait':
			while ( ! get_transient( $realm . '_answer' ) ) {
				usleep( 1000 );
			}
			echo get_transient( $realm . '_answer' );
		break;

		case 'cand':
			if ( $_POST['who'] == 'answer' ) {
				set_transient( $realm . '_answercandidates', $_POST['candidates'], 30 );
				echo null;
			} elseif ( $_POST['who'] == 'offer' ) {
				set_transient( $realm . '_offercandidates', $_POST['candidates'], 30 );
				while( ! get_transient( $realm . '_answercandidates' ) ) {
					usleep( 1000 );
				}
				echo get_transient( $realm . '_answercandidates' );
			}
		break;
	}
	die();
}
add_action('wp_ajax_buddyvideo', 'buddyvideo_callback');
?>