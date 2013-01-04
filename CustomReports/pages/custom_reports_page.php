<?php
access_ensure_global_level( plugin_config_get( 'view_custom_reports_threshold' ) );

$f_selected_report_id = gpc_get_string( 'report_id', null );
$f_param_period_start = gpc_get_string( 'param_period_start', first_day_of_month( -1 ) );
$f_param_period_end = gpc_get_string( 'param_period_end', last_day_of_month( -1 ) );
$f_export = gpc_get_bool( 'export', false );
$f_selected_report    = array();

$t_result = array();

if ( !is_null( $f_selected_report_id ) ) {
	$t_custom_reports_table = plugin_table( 'reports' );
	$t_query_query          = "SELECT * FROM $t_custom_reports_table WHERE id = $f_selected_report_id";
	$t_query_result         = db_query_bound( $t_query_query );
	$f_selected_report      = db_fetch_array( $t_query_result );

	# Remove special html quote chars
	$t_report_query = htmlspecialchars_decode( $f_selected_report['query'], ENT_QUOTES );

	# Remove trailing ;
	$t_report_query = rtrim( $t_report_query, ';' );

    # Fill in parameters
    if ( $f_param_period_start != null && $f_param_period_end != null ) {
        $t_startdate  = strtotime_safe( $f_param_period_start );
        $t_enddate    = strtotime_safe( $f_param_period_end );
        $t_report_query = str_ireplace( PLUGIN_CR_PARAM_PERIOD_START, $t_startdate, $t_report_query );
        $t_report_query = str_ireplace( PLUGIN_CR_PARAM_PERIOD_END, $t_enddate, $t_report_query );
    }

	$t_report_result = db_query_bound( $t_report_query );

	# Populate the result array
	while ( $row = db_fetch_array( $t_report_result ) ) {
		$t_result[] = $row;
	}
}

if ( $f_export && !is_null( $f_selected_report_id ) && count( $t_result ) > 0 ) {
	# Export to excel
	$xls = new ExcelExporterIncludingHeader;
	$xls->addWorksheetWithHeader('Result', $t_result);
	$xls->sendWorkbook($f_selected_report['name'] . '.xls');
} else {
	html_page_top( plugin_lang_get( 'custom_reports' ) );
?>

<br/>
<div class="center">
	<table class="width100">
		<tr>
			<td class="center">
				<form action="<?php echo plugin_page( 'custom_reports_page' ) ?>" method="post">
					<?php echo plugin_lang_get( 'custom_report' ) ?>
					<select id="report_id" name="report_id">
						<?php print_custom_report_option_list( $f_selected_report_id ) ?>
					</select>
                    <div id="include_period" class="hidden">
                        <?php
                        echo plugin_lang_get( 'period_start' ) . ': ';
                        echo '<input type="text" size="8" maxlength="10" autocomplete="off" id="param_period_start" name="param_period_start" value="' . $f_param_period_start . '">';
                        date_print_calendar( 'period_start_cal' );
                        date_finish_calendar( 'period_start', 'period_start_cal' );
                        echo ' - ' . plugin_lang_get( 'period_end' ) . ': ';
                        echo '<input type="text" size="8" maxlength="10" autocomplete="off" id="param_period_end" name="param_period_end" value="' . $f_param_period_end . '">';
                        date_print_calendar( 'period_end_cal' );
                        date_finish_calendar( 'period_end', 'period_end_cal' );
                        ?>
                    </div>
					<input type="submit" value="<?php echo plugin_lang_get( 'load_report' ) ?>"/>
				</form>
			</td>
		</tr>
	</table>
</div>
<br/>

<?php
if ( count( $f_selected_report ) > 0 ) {
	?>

<table class="width100" cellspacing="1">
	<tr>
		<td class="form-title" colspan="100%">
			<?php
				echo $f_selected_report['name'];
				echo ' <span style="font-weight:normal">';
				$t_url = plugin_page( 'custom_reports_page' );
				$t_url .= '&report_id=' . $f_selected_report_id . '&' . 'export=true';
				print_bracket_link( $t_url, plugin_lang_get( 'export_to_excel' ) );
				echo '</span>';
			?>
		</td>
	</tr>
	<tr class="row-category">
		<?php
		if ( count( $t_result ) > 0 && count( $t_result[0] > 0 ) ) {
			foreach ( array_keys( $t_result[0] ) as $key ) {
				echo '<td>' . $key . '</td>';
			}
		}
		?>
	</tr>
	<?php
	if ( count( $t_result ) > 0 ) {
		foreach ( $t_result as $row ) {
			echo '<tr ' . helper_alternate_class() . '>';
			if ( count( $row ) > 0 ) {
				foreach ( $row as $value ) {
					echo '<td>' . string_shorten( $value, 300 ) . '</td>';
				}
			}
			echo '</tr>';
		}
	}
	?>
</table>

<?php } ?>

    <script>
        function toggle_period_section() {
            var report_id = jQuery('#report_id').val();
            jQuery.get("<?php echo plugin_page( 'action_get_report_data', false ) ?>", { report_id : report_id }, function(data) {
                var periodSection = jQuery("#include_period");
                var reportData = jQuery.parseJSON(data);
                if (reportData.include_period === "1") {
                    periodSection.show();
                } else {
                    periodSection.hide();
                }
            });
        }

        jQuery('#report_id').change(function() {
            toggle_period_section();
        });

        jQuery(document).ready(function() {
            toggle_period_section();
        });
    </script>

<?php
html_page_bottom();
}
?>
