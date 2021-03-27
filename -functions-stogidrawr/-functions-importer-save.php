<?php

function save_importer_stogidrawr($import_session_code, $_item, $_inserted_count){
    $_wp_insert_post_error = array();

    $post_title = $_item->title->__toString();
    $post_content = $_item->description->__toString();

    switch ($_wp_insert_post_error) {
        case 'customposttype':
            $table = 'wp_posts';
            $_insert_post_array = array(
                'post_author' => get_option('wp_user_id__importer'),
                'post_content' => $post_content,
                'post_title' => $post_title,
                'post_status' => 'publish',
                'post_type' => get_option('wp_posttype__importer')
            );

            break;

        case 'woocommerce':
            $table = 'wp_posts';
            $_insert_post_array = array(
                'post_author' => get_option('wp_user_id__importer'),
                'post_content' => $post_content,
                'post_title' => $post_title,
                'post_status' => 'publish',
                'post_type' => 'product'
            );

            break;

        default:
            break;
    }

    $_inserted_post_id = wp_insert_post($_insert_post_array, $_wp_insert_post_error);

    log_for_rollback($import_session_code, $table, $_inserted_post_id);

    $_inserted_count++;
    
    return array('inserted_post_id' => $_inserted_post_id, 'inserted_count' => $_insert_post_array, 'wp_insert_post_error' => $_wp_insert_post_error);
}
function _set_featured_image($image_url, $post_id){
    require_once(ABSPATH . 'wp-admin/includes/image.php');
    $upload_dir = wp_upload_dir();
    $image_data = file_get_contents($image_url);
    $filename = basename($image_url);
    if(wp_mkdir_p($upload_dir['path'])){
        $file = $upload_dir['path'].'/'.$filename;
    }else{
        $file = $upload_dir['basedir'].'/'.$filename;
        file_put_contents($file, $image_data);
    }

    $wp_filetype = wp_check_filetype($filename, null );
    if(isset($wp_filetype['type']) && $wp_filetype['type'] !== ''){
        $attachment = array(
            'post_title' => sanitize_file_name($filename),
            'post_status' => 'inherit',
            'post_mime_type' => $wp_filetype['type']
        );
        $attach_id = wp_insert_attachment($attachment, $file, $post_id);
        $attach_data = wp_generate_attachment_metadata($attach_id, $file ;
        wp_update_attachment_metadata($attach_id, $attach_data);
        set_post_thumbnail($post_id, $attach_id);
    }else{
        return false;
    }
}
function log_for_rollback($import_session_code, $table, $item_id){
    if(file_exists($import_session_code)){
        file_put_contents($import_session_code, $table.':'.$item_id.PHP_EOL, FILE_APPEND | LOCK_EX);
    }else{
        file_put_contents($import_session_code, $table.':'.$item_id.PHP_EOL);
    }
}
if ( ! function_exists( 'is_woocommerce_activated' ) ) {
    function is_woocommerce_activated() {
        if ( class_exists( 'woocommerce' ) ) { return true; } else { return false; }
    }
}
