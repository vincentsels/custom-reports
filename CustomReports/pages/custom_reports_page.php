<?php
access_ensure_global_level( plugin_config_get( 'view_custom_reports_threshold' ) );

$f_selected_report_id = gpc_get_string( 'report_id', null );
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
					<select name="report_id">
						<?php print_custom_report_option_list( $f_selected_report_id ) ?>
					</select>
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

<?php
html_page_bottom();
}
?>
