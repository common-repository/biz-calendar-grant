<?php
/*
Plugin Name: Biz Calendar Grant
Plugin URI:
Description: This plug-in can also be selected in non-administrator rights group that can be set Biz Calendar. Specifically , it gives you a display Biz Calendar's Menu and the authority of "manage_options" set to the selected authority group. It has become the authority that allows the "Settings" in menu. But, since it is separate from the right to display the menu, that can not be used settings other than Biz Calendar.
Author: 8suzuran8
Author URI: https://profiles.wordpress.org/8suzuran8/
Version: 1.0.1
Text Domain: biz_calendar_grant
License: GNU General Public License v2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/

function biz_calendar_grant_admin_init() {
	$biz_calendar_grant = get_option( 'biz_calendar_grant' );

	if ( is_array( $biz_calendar_grant ) && count( $biz_calendar_grant ) > 0 ) {
		foreach ( $biz_calendar_grant as $key => $value ) {
			$role = get_role( $key );
			$role->add_cap( 'manage_options' );
		}
	}

	register_setting( 'biz_calendar_grant', 'biz_calendar_grant' );
}

add_action( 'admin_init', 'biz_calendar_grant_admin_init' );

function biz_calendar_grant_admin_page() {
	global $wpdb;
	$roles = get_option($wpdb->prefix . 'user_roles');

	require_once( dirname( __FILE__ ) . '/view.php' );
}

function biz_calendar_grant_admin_menu() {
	$biz_calendar_grant = get_option( 'biz_calendar_grant' );

	if ( !class_exists( 'BizCalendarPlugin' ) ) {
		return;
	}

	if ( is_array( $biz_calendar_grant ) && count( $biz_calendar_grant ) > 0 ) {
		foreach ( $biz_calendar_grant as $key => $value ) {
			add_options_page( __( "Biz Calendar設定", 'biz_calendar_grant' ), __( "Biz Calendar設定", 'biz_calendar_grant' ), $key, 'biz_calendar', array(new BizCalendarPlugin, 'show_admin_page'));
		}
	}

	add_options_page( __( "Biz Calendar権限設定", 'biz_calendar_grant' ), __( "Biz Calendar権限設定", 'biz_calendar_grant' ), 'edit_themes', 'biz_calendar_grant', 'biz_calendar_grant_admin_page');
}

add_action( 'admin_menu', 'biz_calendar_grant_admin_menu' );

function low_priority_active_plugins( $active_plugins, $old_value ) {
	$this_plugin = str_replace( wp_normalize_path( WP_PLUGIN_DIR ) . '/', '', wp_normalize_path( __FILE__ ) );

	foreach ( $active_plugins as $no => $path ) {
		if ( $path == $this_plugin ) {
			unset( $active_plugins[ $no ] );
			array_push( $active_plugins, $this_plugin );
			break;
		}
	}

	return $active_plugins;
}

add_filter( 'pre_update_option_active_plugins', 'low_priority_active_plugins', 10, 2 );
