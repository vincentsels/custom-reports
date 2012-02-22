<?php
form_security_validate( 'plugin_CustomReports_update' );

auth_reauthenticate();
access_ensure_global_level( plugin_config_get( 'admin_threshold' ) );

$f_report_id = gpc_get_int( 'report_id', null );
$f_report_name = gpc_get_string( 'report_name', null );
$f_view_threshold = gpc_get_string( 'view_threshold', null );
$f_query = htmlspecialchars( gpc_get_string( 'query', null ), ENT_QUOTES );

$t_reports_table = plugin_table( 'reports' );

if ( empty( $f_report_id ) ) {
	# Insert new report
	$t_query = "INSERT INTO $t_reports_table (name, view_threshold, query)
				VALUES ('$f_report_name', '$f_view_threshold', '$f_query')";
	db_query_bound( $t_query );
} else {
	# Update existing report
	$t_query = "UPDATE $t_reports_table
				   SET name = '$f_report_name', view_threshold = '$f_view_threshold', query = '$f_query'
				 WHERE id = $f_report_id";
	db_query_bound( $t_query );
}

form_security_purge( 'plugin_CustomReport_update' );
print_successful_redirect( plugin_page( 'manage_reports_overview_page', true ) );
?>