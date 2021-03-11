<?php
function droswavosw_create_menu() {
    add_menu_page('WTAB Importer', 'Importer', 'administrator', __FILE__, 'droswavosw_settings_page' , plugins_url('/images/icon.png', __FILE__) );

    add_submenu_page(__FILE__, 'Importer form', 'Importer form', 'administrator', 'Importer form', 'droswavosw_pnl_form_settings_page');
    add_submenu_page(__FILE__, 'Test Importer', 'Test Importer', 'administrator', 'Test Importer', 'droswavosw_pnl_test_importer_settings_page');

    add_action( 'admin_init', 'register_pnl_form_droswavosw_settings' );
}