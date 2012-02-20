<?php
form_security_validate( 'plugin_CustomReports_config_update' );

auth_reauthenticate();
access_ensure_global_level( plugin_config_get( 'admin_threshold' ) );

function maybe_set_option( $name, $value ) {
	if ( $value != plugin_config_get( $name ) ) {
		plugin_config_set( $name, $value );
	}
}

maybe_set_option( 'admin_threshold', gpc_get_int( 'admin_threshold' ) );
maybe_set_option( 'view_custom_reports_threshold', gpc_get_int( 'view_custom_reports_threshold' ) );

form_security_purge( 'plugin_CustomReports_config_update' );
print_successful_redirect( plugin_page( 'config_page', true ) );
?>
