<?php
auth_reauthenticate();
access_ensure_global_level( plugin_config_get( 'admin_threshold' ) );

html_page_top1( plugin_lang_get( 'manage_reports' ) );
html_page_top2();

$f_report_id = gpc_get_int( 'report_id', null );

$t_report_name = null;
$t_view_threshold = null;
$t_query = null;
$t_include_period = null;

if ( !empty( $f_report_id ) ) {
	$t_reports_table = plugin_table( 'reports' );
	$t_query = "SELECT * FROM $t_reports_table WHERE id = $f_report_id";
	$t_result = db_query_bound( $t_query );
	$t_report = db_fetch_array( $t_result );
	if ( is_array( $t_report ) ) {
		$t_report_name = $t_report['name'];
		$t_view_threshold = $t_report['view_threshold'];
		$t_query = $t_report['query'];
        $t_include_period = $t_report['include_period'];
	}
}

print_manage_menu();
print_custom_report_config_menu( plugin_page( 'manage_reports_overview_page' ) );
?>

<br/>
<form method="post" action="<?php echo plugin_page( 'manage_reports_update' ) ?>">
	<?php echo form_security_field( 'plugin_CustomReports_update' ) ?>

	<input type="hidden" name="report_id" value="<?php echo $f_report_id ?>" />;

	<table class="width50" align="center" cellspacing="1">
		<tr>
			<td class="form-title"
				colspan="2"><?php echo plugin_lang_get( 'manage_reports' ) ?></td>
		</tr>
		<tr <?php echo helper_alternate_class() ?>>
			<td class="category"><?php echo plugin_lang_get( 'report_name' ) ?></td>
			<td>
				<input type="text" size="64" maxlength="64" name="report_name" id="report_name"
					   value="<?php echo $t_report_name ?>" />
			</td>
		</tr>
		<tr <?php echo helper_alternate_class() ?>>
			<td class="category"><?php echo plugin_lang_get( 'view_threshold' ) ?></td>
			<td>
				<select name="view_threshold" id="view_threshold">
					<?php print_enum_string_option_list( 'access_levels', $t_view_threshold ) ?>
				</select>
			</td>
		</tr>
		<tr <?php echo helper_alternate_class() ?>>
			<td class="category"><?php echo plugin_lang_get( 'query' ) ?><br/>
			<td><textarea rows="10" cols="50" name="query"><?php echo $t_query ?></textarea>
			</td>
		</tr>
        <tr <?php echo helper_alternate_class() ?>>
            <td class="category"><?php echo plugin_lang_get( 'include_period_parameters' ) ?><br/>
            <td><input type="checkbox" name="include_period"<?php echo $t_include_period ? " checked=checked" : "" ?>>
            <?php echo plugin_lang_get( 'include_period_parameters_info' ) ?>
            </td>
        </tr>
		<tr>
			<td class="center" colspan="100%"><input type="submit" value="<?php echo lang_get( 'update' ) ?>"/></td>
		</tr>
	</table>
</form>

<?php
html_page_bottom();
?>