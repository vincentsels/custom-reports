<?php
auth_reauthenticate();
access_ensure_global_level( plugin_config_get( 'admin_threshold' ) );
html_page_top( plugin_lang_get( 'configuration' ) );

print_manage_menu();
print_custom_report_config_menu( 'config_page' );
?>

<br/>
<form action="<?php echo plugin_page( 'config_update' ) ?>" method="post">
	<?php echo form_security_field( 'plugin_CustomReports_config_update' ) ?>
	<table class="width60" align="center" cellspacing="1">
		<tr>
			<td class="form-title" colspan="2"><?php echo plugin_lang_get( 'configuration' ) ?></td>
		</tr>
		<tr <?php echo helper_alternate_class() ?>>
			<td class="category"><?php echo plugin_lang_get( 'admin_threshold' ) ?></td>
			<td><select
				name="admin_threshold"><?php print_enum_string_option_list( 'access_levels', plugin_config_get( 'admin_threshold' ) ) ?></select>
			</td>
		</tr>
		<tr <?php echo helper_alternate_class() ?>>
			<td class="category"><?php echo plugin_lang_get( 'view_custom_reports_threshold' ) ?></td>
			<td><select
				name="view_custom_reports_threshold"><?php print_enum_string_option_list( 'access_levels', plugin_config_get( 'view_custom_reports_threshold' ) ) ?></select>
			</td>
		</tr>
		<tr>
			<td class="center" colspan="2"><input type="submit" value="<?php echo lang_get( 'edit_link' ) ?>"/></td>
		</tr>
	</table>
</form>

<?php
html_page_bottom();
?>
