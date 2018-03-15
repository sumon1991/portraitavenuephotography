<?php

/**
 * Submenu page
 */
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
	exit;
}

class DGWT_JG_Admin_Menu {

	public function __construct() {

		add_action( 'admin_menu', array( $this, 'add_menu' ), 20 );
	}

	/**
	 * Add meun items
	 */
	public function add_menu() {

		add_submenu_page( 'options-general.php', __( 'Justified Gallery', DGWT_JG_DOMAIN ), __( 'Justified Gallery', DGWT_JG_DOMAIN ), 'manage_options', 'dgwt_jg_settings', array( $this, 'settings_page' ) );
	}

	/**
	 * Settings page
	 */
	public function settings_page() {
		DGWT_JG_Settings::output();
	}

}

$admin_menu = new DGWT_JG_Admin_Menu();

