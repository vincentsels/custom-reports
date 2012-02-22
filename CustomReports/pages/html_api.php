<?php
/**
 * Prints an option list containing all stored custom reports.
 * @param $p_selected_report optionally specify the id of the report that should be selected.
 */
function print_custom_report_option_list( $p_selected_report = null, $p_all_custom_reports = null ) {
	$t_custom_reports = $p_all_custom_reports;
	if ( is_null( $t_custom_reports ) ) {
		$t_custom_reports = custom_reports_get_all();
	}

	if ( count( $t_custom_reports ) > 0 ) {
		foreach ( $t_custom_reports as $t_custom_report ) {
			echo '<option value="' . $t_custom_report['id'] . '"';
			check_selected( $t_custom_report['id'], $p_selected_report );
			echo '>' . $t_custom_report['name'] . '</option>';
		}
	}
}

function print_custom_report_config_menu( $p_page = '' ) {
	$t_pm_config_main_page   = plugin_page( 'config_page' );
	$t_pm_config_manage_reports_page = plugin_page( 'manage_reports_overview_page' );

	switch ( plugin_page( $p_page ) ) {
		case $t_pm_config_main_page:
			$t_pm_config_main_page = '';
			break;
		case $t_pm_config_manage_reports_page:
			$t_pm_config_manage_reports_page = '';
			break;
	}

	echo '<br /><div align="center">';
	if ( access_has_global_level( plugin_config_get( 'admin_threshold' ) ) ) {
		print_bracket_link( $t_pm_config_main_page, plugin_lang_get( 'general_configuration' ) );
	}
	if ( access_has_global_level( plugin_config_get( 'admin_threshold' ) ) ) {
		print_bracket_link( $t_pm_config_manage_reports_page, plugin_lang_get( 'manage_reports' ) );
	}
	echo '</div>';
}