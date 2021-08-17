<?php 
add_action('init', 'ext_cs_ajax_hooks', 3);
function ext_cs_ajax_hooks(){

    add_action("wp_ajax_getMake", "getMake");
    add_action("wp_ajax_nopriv_getMake", "getMake");

    add_action("wp_ajax_getMode", "getMode");
    add_action("wp_ajax_nopriv_getMode", "getMode");
    
    add_action("wp_ajax_getDriveType", "getDriveType");
    add_action("wp_ajax_nopriv_getDriveType", "getDriveType");

}

/*
* Defining Menu
* Author : Tj Thouhid
* Date : 06-15-2020
*
 */
function excs_panel(){
    add_menu_page('EXTERNAL CUSTOM SEARCH', 'EXTERNAL CUSTOM SEARCH', 'manage_options', 'excs-system', 'excs_system_func');
    add_submenu_page( 'excs-system', 'Sync Product', 'Sync Product', 'manage_options', 'excs-system-sync-db', 'hexcs_system_db_func');
    add_submenu_page( 'excs-system', 'Year', 'Year', 'manage_options', 'excs-system-year', 'hexcs_system_year_func');
    add_submenu_page( 'excs-system', 'Make', 'Make', 'manage_options', 'excs-system-make', 'hexcs_system_make_func');
    add_submenu_page( 'excs-system', 'Model', 'Model', 'manage_options', 'excs-system-model', 'hexcs_system_model_func');
    add_submenu_page( 'excs-system', 'Drive Type', 'Drive Type', 'manage_options', 'excs-system-drive-type', 'hexcs_system_drive_type_func');
    //add_submenu_page( 'hrms-salary-system', 'Extra Hours Addons', 'Extra Hours Addons', 'manage_options', 'hrms-ex-hour-addons', 'hrms_ex_hour_addonse_func');
    //add_submenu_page( 'qebm-plugin-options', 'Attendance Settings', 'Attendance Settings', 'manage_options', 'qebm-att-settings', 'qebm_att_func_settings');
    //add_submenu_page( 'theme-options', 'FAQ page title', 'FAQ menu label', 'manage_options', 'theme-op-faq', 'wps_theme_func_faq');
}
add_action('admin_menu', 'excs_panel');
?>