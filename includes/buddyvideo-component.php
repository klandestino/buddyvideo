<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

if ( file_exists( dirname( __FILE__ ) . '/languages/' . get_locale() . '.mo' ) )
	load_textdomain( 'buddyvideo', dirname( __FILE__ ) . '/languages/' . get_locale() . '.mo' );


class Buddyvideo_Component extends BP_Component {

	/**
	 * Constructor method
	 *
	 */
	function __construct() {
		global $bp;

		parent::start(
			'buddyvideo',
			__( 'Buddyvideo', 'buddyvideo' ),
			BUDDYVIDEO_PLUGIN_DIR
		);

		/**
		 * BuddyPress-dependent plugins are loaded too late to depend on BP_Component's
		 * hooks, so we must call the function directly.
		 */
		 $this->includes();

		/**
		 * Puts component into the active components array, so that
		 * bp_is_active( 'buddyvideo' );
		 * returns true when appropriate. We have to do this manually, because non-core
		 * components are not saved as active components in the database.
		 */
		$bp->active_components[$this->id] = '1';
	}

	/**
	 * Include our component's files
	 *
	 */
	function includes() {

		// Files to include
		$includes = array(
			'includes/buddyvideo-template.php',
			'includes/buddyvideo-screens.php',
			'includes/buddyvideo-notifications.php',
			'includes/buddyvideo-ajax.php'
		);

		parent::includes( $includes );
	}

	/**
	 * Set up our plugin's globals
	 *
	 */
	function setup_globals() {
		global $bp;

		// Defining the slug in this way makes it possible for site admins to override it
		if ( !defined( 'BUDDYVIDEO_SLUG' ) )
			define( 'BUDDYVIDEO_SLUG', $this->id );

		// Set up the $globals array to be passed along to parent::setup_globals()
		$globals = array(
			'slug'                  => BUDDYVIDEO_SLUG,
			'has_directory'         => false, // Set to false if not required
			'notification_callback' => 'buddyvideo_format_notifications'
		);

		// Let BP_Component::setup_globals() do its work.
		parent::setup_globals( $globals );

	}

	/**
	 * Set up our component's navigation.
	 *
	 * The navigation elements created here are responsible for the main site navigation (eg
	 * Profile > Video ), as well as the navigation in the BuddyBar.
	 *
	 */
	function setup_nav() {
		// Add 'Video' to the main navigation
		$main_nav = array(
			'name' => __( 'Video', 'buddyvideo' ),
			'slug' => buddyvideo_get_slug(),
			'screen_function' => 'buddyvideo_screen_settings_menu',
			'position' => 80,
			'show_for_displayed_user' => false,
			'default_subnav_slug' => 'list-chat-requests'
		);

		$buddyvideo_link = trailingslashit( bp_loggedin_user_domain() . buddyvideo_get_slug() );

		// Add a few subnav items under the main video tab
		$sub_nav[] = array(
			'name'            =>  __( 'List chat requests', 'buddyvideo' ),
			'slug'            => 'list-chat-requests',
			'parent_url'      => $buddyvideo_link,
			'parent_slug'     => buddyvideo_get_slug(),
			'screen_function' => 'buddyvideo_list_chats',
			'position'        => 10
		);

		$sub_nav[] = array(
			'name'            =>  __( 'Chat', 'bp-example' ),
			'slug'            => 'chat',
			'parent_url'      => $buddyvideo_link,
			'parent_slug'     => buddyvideo_get_slug(),
			'screen_function' => 'buddyvideo_chat',
			'position'        => 20
		);

		parent::setup_nav( $main_nav, $sub_nav );

	}

}

/**
 * Loads our component into the $bp global
 *
 */
function buddyvideo_load_core_component() {
	global $bp;

	$bp->buddyvideo = new Buddyvideo_Component;
}
add_action( 'bp_loaded', 'buddyvideo_load_core_component' );

/**
 * Loads our components scripts and styles
 *
 */
function buddyvideo_add_script_and_styles() {
	global $bp;

	if ( $bp->current_component == $bp->buddyvideo->slug )
		wp_enqueue_script( 'buddyvideo-js', plugins_url( '/buddyvideo/includes/buddyvideo.js' ) );
}
add_action( 'template_redirect', 'buddyvideo_add_script_and_styles', 1 );
?>