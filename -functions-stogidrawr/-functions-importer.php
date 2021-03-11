<?php

set_time_limit(3000);

function _do_importer($_limit){
    $_inserted_count = $_item_count = 0;

    $_do_insert = _get_do_insert(get_option('active__importer'));
    $_WS_url_importer = get_option('ws_url__importer');
    $_format_importer = get_option('format__importer');

    if($_WS_url_importer === '' || $_format_importer === ''){
        return false;
    }
    try {
        //#Read: elemento che dialoga con la fonte dati
        $feed = get_feed($_WS_url_importer, $_format_importer);
        $table = array();
        $_keys[] = array();
        foreach ($feed as $_item){
            if(!$_do_insert){
                $_get_key_from_xml_item = get_key_from_xml_item($_item);
                $_td = 0;
                foreach ($_get_key_from_xml_item as $key => $xmlitem){
                    $_keys[$_td] = $key;
                    $table[$_item_count][] = array($_td => $xmlitem);
                    $_td++;
                }
            }else{
                if($_limit > 0){
                    if($_inserted_count == $_limit){
                        break;
                    }
                }
                //#Save: elemento che effettua l'inserimento a DB in base alle configurazioni
                $_save_importer_stogidrawr = save_importer_stogidrawr($_item, $_inserted_count);
                $_inserted_post_id = $_save_importer_stogidrawr['inserted_post_id'];
                $_inserted_count = $_save_importer_stogidrawr['inserted_count'];
                $_wp_insert_post_error = $_save_importer_stogidrawr['wp_insert_post_error']; //# TODO

                if($_inserted_post_id === 0){
                    break;
                }
            }

            $_item_count++;
        }

        if(!$_do_insert){
            echo '<table>';
                echo '<tr>';
                foreach ($_keys as $key){
                    echo '<th>'.$key.'</th>';
                }
                echo '</tr>';
                foreach ($table as $_key => $_tr){
                    echo '<tr>';
                    $_td_c = 0;
                    foreach ($_tr as $td){
                        echo '<td><pre>'.print_r($td[$_td_c], true).'</pre></td>';
                        $_td_c++;
                    }
                    echo '</tr>';
                }
            echo '</table>';
        }
    } catch (Exception $exc) {
        echo 'EXCEPTION:<pre>';
        var_dump($exc);
        echo '</pre>';
    }
}

function _get_do_insert($active__importer){
    if($active__importer == 1){
        return true;
    }else{
        return false;
    }
}