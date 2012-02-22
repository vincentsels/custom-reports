<?php
auth_reauthenticate();
access_ensure_global_level( plugin_config_get( 'admin_threshold' ) );

html_page_top1( plugin_lang_get( 'configuration' ) );
html_page_top2();

print_manage_menu();
print_custom_report_config_menu( 'manage_reports_overview_page' );

$t_all_reports = custom_reports_get_all();
?>

<br/>
<table class="width75" align="center" cellspacing="1">
	<tr>
		<td class="form-title"
			colspan="2"><?php echo plugin_lang_get( 'manage_reports' ) ?></td>
	</tr>
	<tr class="row-category">
		<td><?php echo plugin_lang_get( 'report_name' ) ?></td>
		<td><?php echo plugin_lang_get( 'view_threshold' ) ?></td>
		<td><?php echo plugin_lang_get( 'query' ) ?></td>
		<td><?php echo lang_get( 'actions' ) ?></td>
	</tr>

	<?php
	foreach ( $t_all_reports as $row ) {
		$t_report_id = $row['id'];
		$t_report_name = $row['name'];
		$t_view_threshold = $row['view_threshold'];
		$t_query = string_shorten( $row['query'], 200 );
		?>
		<tr <?php echo helper_alternate_class() ?>>
			<td><?php echo $t_report_name ?></td>
			<td><?php echo $t_view_threshold ?></td>
			<td><?php echo $t_query ?></td>
			<td class="center">
				<form method="post" action="<?php echo plugin_page( 'manage_reports_page' ) ?>">
					<input type="hidden" name="report_id" value="<?php echo $t_report_id ?>" />
					<input type="submit" value="<?php echo lang_get( 'edit_link' ) ?>"/>
				</form>
				<form method="post" action="<?php echo plugin_page( 'manage_reports_delete' ) ?>">
					<?php echo form_security_field( 'plugin_CustomReports_delete' ) ?>
					<input type="hidden" name="report_id" value="<?php echo $t_report_id ?>" />
					<input type="submit" value="<?php echo lang_get( 'remove_link' ) ?>"/>
				</form>
			</td>
		</tr>
		<?php
	}
	?>

	<tr>
		<form method="post" action="<?php echo plugin_page( 'manage_reports_page' ) ?>">
			<td colspan="100%"><input type="submit" value="<?php echo plugin_lang_get( 'add_new_report' ) ?>"/></td>
		</form>
	</tr>
</table>

<?php
html_page_bottom();
?>