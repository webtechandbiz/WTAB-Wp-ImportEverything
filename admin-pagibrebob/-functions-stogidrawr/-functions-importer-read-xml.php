<?php

function _get_feed_xml($_auth, $ws_url__importer){
    if($_auth['username'] !== '' && $_auth['password'] !== ''){
        $username = $_auth['username'];
        $password = $_auth['password'];
    }

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $ws_url__importer);
    curl_setopt($ch, CURLOPT_FAILONERROR, 1);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_TIMEOUT, 15);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
    if($_auth['username'] !== '' && $_auth['password'] !== ''){
        curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");
    }

    $retValue = curl_exec($ch);          
    $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    
    return simplexml_load_string($retValue, "SimpleXMLElement", LIBXML_NOCDATA);
}

function xmltoarray(SimpleXMLElement $parent){
    $array = array();

    foreach ($parent as $name => $element) {
        ($node = & $array[$name]) && (1 === count($node) ? $node = array($node) : 1) && $node = & $node[];
        $node = $element->count() ? xmltoarray($element) : trim($element);
    }

    return $array;
}

function get_key_from_xml_item(SimpleXMLElement $parent){
    $array = array();

    foreach ($parent as $name => $element) {
        ($node = & $array[$name]) && (1 === count($node) ? $node = array($node) : 1) && $node = & $node[];
        $node = $element->count() ? xmltoarray($element) : trim($element);
    }

    return $array;
}
