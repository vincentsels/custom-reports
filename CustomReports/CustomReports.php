<?php
class CustomReportsPlugin extends MantisPlugin {

    function register() {
        $this->name = 'Custom Reports';
        $this->description = 'Custom Reporting plugin that allows custom sql queries to be executed in Mantis.';
        $this->page = 'config_page';

        $this->version = '0.1';
        $this->requires = array(
           'MantisCore' => '1.2.0'
        );

        $this->author = 'Vincent Sels';
        $this->contact = 'vincent_sels@hotmail.com';
        $this->url = 'https://github.com/vincentsels';
    }

	function schema() {
		return array(
			array( 'CreateTableSQL', array( plugin_table( 'reports' ), "
						id                 I       NOTNULL UNSIGNED AUTOINCREMENT PRIMARY,
						name               C(32)   NOTNULL,
						view_threhold      I2      NOTNULL DEFAULT 50,
						query              XL      NOTNULL
						" ) )
		);
	}

    function hooks() {
        return array(
           'EVENT_MENU_MAIN' => 'custom_report_menu',
        );
    }

    function config() {
       return array(
          'view_custom_reports_threshold' => MANAGER,
		  'admin_threshold' => ADMINISTRATOR,
       );
    }

	function init() {
		require_once( 'CustomReports.API.php' );
		require_once( 'pages/html_api.php' );
	}

	public function custom_report_menu( $p_event ) {
		if ( access_has_global_level( plugin_config_get( 'view_custom_reports_threshold' ) ) ) {
			return '<a href="' . plugin_page( 'custom_reports_page', false ) . '">' . plugin_lang_get( 'custom_reports' ) . '</a>';
		}
	}
}
?>
