<?php

# Constants
define( 'PLUGIN_CR_PARAM_PERIOD_START', ':period_start' );
define( 'PLUGIN_CR_PARAM_PERIOD_END', ':period_end' );

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

if ( !function_exists( 'strtotime_safe' ) ) {
    /**
     * Fixes 0013332: Due date not saved successfully when date-format is set to 'd/m/Y'
     * The normal strtotime can't handle the format d/m/Y, since it will interpret
     * it as m/d/Y. To determine whether this is the case, this function looks
     * at the short_date_format setting.
     * Also, if the passed argument is null and parameter $p_allow_null is false (default),
     * date_get_null() is returned.
     * @param string $p_date
     * @param bool $p_allow_null
     * @return number
     */
    function strtotime_safe( $p_date, $p_allow_null = false ) {
        if( !$p_allow_null && ( $p_date == null || is_blank ( $p_date ) || $p_date === 1 ) ) {
            return date_get_null();
        }

        if ( config_get( 'short_date_format' ) == 'd/m/Y' ) {
            return strtotime( str_replace( '/', '-', $p_date ) );
        } else {
            return strtotime( $p_date );
        }
    }
}

if ( !function_exists( 'first_day_of_month' ) ) {
    /**
     * Returns the first day of the current month, or when specified,
     * the current month added (or substracted) with $p_add_months months.
     * @param int $p_add_months Optional. The amount of months to add or substract from the current month.
     * @param string $p_format Optional. The format of the date to return.
     * @return string the first day of the month, formated as $p_format.
     */
    function first_day_of_month( $p_add_months = 0, $p_format = null ) {
        if ( $p_format == null ) {
            $p_format = config_get( 'short_date_format' );
        }
        return date( $p_format, mktime( 0, 0, 0, date( 'm' ) + $p_add_months, 1 ) );
    }
}

if ( !function_exists( 'last_day_of_month' ) ) {
    /**
     * Returns the last day of the current month, or when specified,
     * the current month added (or substracted) with $p_add_months months.
     * @param int $p_add_months Optional. The amount of months to add or substract from the current month.
     * @param string $p_format Optional. The format of the date to return.
     * @return string the last day of the month, formated as $p_format.
     */
    function last_day_of_month( $p_add_months = 0, $p_format = null ) {
        if ( $p_format == null ) {
            $p_format = config_get( 'short_date_format' );
        }
        return date( $p_format, mktime( 0, 0, 0, date( 'm' ) + $p_add_months + 1, 0 ) );
    }
}