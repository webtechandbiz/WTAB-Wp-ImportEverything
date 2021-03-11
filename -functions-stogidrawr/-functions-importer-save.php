<?php

function save_importer_stogidrawr($_item, $_inserted_count){
    $_wp_insert_post_error = array();

    $post_title = $_item->title->__toString();
    $post_content = $_item->description->__toString();

    switch ($_wp_insert_post_error) {
        case 'customposttype':
            $_insert_post_array = array(
                'post_author' => get_option('wp_user_id__importer'),
                'post_content' => $post_content,
                'post_title' => $post_title,
                'post_status' => 'publish',
                'post_type' => get_option('wp_posttype__importer')
            );

            break;

        case 'woocommerce':
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

    $_inserted_count++;
    
    return array('inserted_post_id' => $_inserted_post_id, 'inserted_count' => $_insert_post_array, 'wp_insert_post_error' => $_wp_insert_post_error);
}
if ( ! function_exists( 'is_woocommerce_activated' ) ) {
    function is_woocommerce_activated() {
        if ( class_exists( 'woocommerce' ) ) { return true; } else { return false; }
    }
}