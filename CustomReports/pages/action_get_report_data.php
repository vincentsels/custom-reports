<?php
if ( !access_has_global_level( plugin_config_get( 'view_custom_reports_threshold' ) ) ) {
    # Return nothing
    return;
}

$f_report_id = $_GET['report_id'];

$t_custom_reports_table = plugin_table( 'reports' );
$t_query_query          = "SELECT id, name, view_threshold, include_period
                             FROM $t_custom_reports_table
                            WHERE id = $f_report_id";
$t_query_result         = db_query_bound( $t_query_query );
$f_selected_report      = db_fetch_array( $t_query_result );

echo json_encode( $f_selected_report );