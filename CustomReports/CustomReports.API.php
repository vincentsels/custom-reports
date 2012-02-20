<?php
/**
 * Returns an array containing all stored reports.
 * @return array An array containing all stored custom reports.
 */
function custom_reports_get_all() {
	$t_custom_reports_table = plugin_table( 'reports' );
	$t_query = "SELECT * FROM $t_custom_reports_table";
	$t_result = db_query_bound( $t_query );

	$t_array = array();
	while ( $row = db_fetch_array( $t_result ) ) {
		$t_array[$row['id']] = $row;
	}

	return $t_array;
}