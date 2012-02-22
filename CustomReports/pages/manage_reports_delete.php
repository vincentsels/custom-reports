<?php
form_security_validate( 'plugin_CustomReports_delete' );

auth_reauthenticate();
access_ensure_global_level( plugin_config_get( 'admin_threshold' ) );

$f_report_id = gpc_get_int( 'report_id', null );

$t_reports_table = plugin_table( 'reports' );

$t_query = "DELETE FROM $t_reports_table WHERE id = $f_report_id";
db_query_bound( $t_query );

form_security_purge( 'plugin_CustomReports_delete' );
print_successful_redirect( plugin_page( 'manage_reports_overview_page', true ) );
?>