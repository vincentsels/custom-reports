<?php
/**
 * Prints an option list containing all stored custom reports.
 * @param $p_selected_report optionally specify the id of the report that should be selected.
 */
function print_custom_report_option_list( $p_selected_report = null ) {
	echo 'wtf';
	$t_custom_reports = custom_reports_get_all();
	echo var_dump( $t_custom_reports );

	if ( count( $t_custom_reports ) > 0 ) {
		foreach ( $t_custom_reports as $t_custom_report ) {
			echo '<option value="' . $t_custom_report['id'] . '"';
			check_selected( $t_custom_report['id'], $p_selected_report );
			echo '>' . $t_custom_report['name'] . '</option>';
		}
	}
}