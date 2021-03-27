<?php

function get_feed($ws_url__importer, $format__importer){
    
    switch ($format__importer) {
        case '1': //XML
            $_auth['username'] = get_option('username_basicauth__importer');
            $_auth['password'] = get_option('password_basicauth__importer');

            $sXML = _get_feed_xml($_auth, $ws_url__importer);

            return $sXML;

        case '2': //CSV
            $_auth['username'] = get_option('username_basicauth__importer');
            $_auth['password'] = get_option('password_basicauth__importer');

            $sCSV = _get_feed_csv($_auth, $ws_url__importer);

            return $sCSV;

        case '3': //JSON
            $_auth['username'] = get_option('username_basicauth__importer');
            $_auth['password'] = get_option('password_basicauth__importer');

            $sJSON = _get_feed_json($_auth, $ws_url__importer);

            return $sJSON;

        case '4': //DB
            $_auth['dbhost'] = get_option('host_db__importer');
            $_auth['dbusername'] = get_option('username_db__importer');
            $_auth['dbpassword'] = get_option('password_db__importer');
            $_auth['dbname'] = get_option('name_db__importer');

            $sDB = _get_feed_db($_auth);

            return $sDB;

        default:
            break;
    }
}
