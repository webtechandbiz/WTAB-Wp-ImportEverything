<?php
session_start();

set_time_limit(600);
if(is_user_logged_in() && current_user_can('administrator') ) {
    $post = $_POST;
    $session = $_SESSION;

    $_wp_load_path = '../../../../../../wp-load.php';

    if(file_exists($_wp_load_path)){
        $now = new DataTime();
        require $_wp_load_path;
        global $admin__log_folder_path;
        global $admin__imported_folder_path;
        
        $import_session_code = $now->format('Ymd-His').'-'._get_import_code();

        try {
            $date_log = new DateTime();


            $_limit = intval(get_option('max_products__importer'));

            _do_importer($import_session_code, $_limit);

        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }else{
        echo 'no-wp-load';
    }
}