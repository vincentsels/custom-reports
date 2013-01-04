<?php
form_security_validate( 'plugin_CustomReports_update' );

auth_reauthenticate();
access_ensure_global_level( plugin_config_get( 'admin_threshold' ) );

$f_report_id = gpc_get_int( 'report_id', null );
$f_report_name = gpc_get_string( 'report_name', null );
$f_view_threshold = gpc_get_string( 'view_threshold', null );
$f_query = htmlspecialchars( gpc_get_string( 'query', null ), ENT_QUOTES );

$t_test_query = ' ' . $f_query . ' ';

if ( stripos( $t_test_query, ' INSERT ' ) !== false ||
    stripos( $t_test_query, ' UPDATE ' ) !== false ||
    stripos( $t_test_query, ' DELETE ' ) !== false ||
    stripos( $t_test_query, ' CREATE ' ) !== false ||
    stripos( $t_test_query, ' ALTER ' ) !== false ||
    stripos( $t_test_query, ' DROP ' ) !== false ||
    stripos( $t_test_query, ' TRUNCATE ' ) !== false ||
    stripos( $t_test_query, ' COMMENT ' ) !== false ||
    stripos( $t_test_query, ' RENAME ' ) !== false ||
    stripos( $t_test_query, ' GRANT ' ) !== false ||
    stripos( $t_test_query, ' REVOKE ' ) !== false ) {
    form_security_purge( 'plugin_CustomReport_update' );
    print_successful_redirect( plugin_page( 'manage_reports_overview_page&invalid_keywords=true', true ) );
}

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
print_successful_redirect( plugin_page( 'manage_reports_overview_page&success=true', true ) );
?>