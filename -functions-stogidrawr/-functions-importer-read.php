<?php


function get_feed($ws_url__importer, $format__importer){
    
    switch ($format__importer) {
        case '1': //XML
            $_auth['username'] = get_option('username_basicauth__importer');
            $_auth['password'] = get_option('password_basicauth__importer');

            $sXML = _get_feed_xml($_auth, $ws_url__importer);

            return $sXML;

        default:
            break;
    }
}