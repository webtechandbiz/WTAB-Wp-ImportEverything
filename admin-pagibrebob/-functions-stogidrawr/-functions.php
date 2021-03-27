<?php
//# Basic functions
function _get_import_code() {
    $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    $charactersLength = strlen($characters);
    $importcode = '';
    for($i=0;$i<10;$i++){
        $importcode .= $characters[rand(0, $charactersLength - 5)];
    }
    return $importcode;
}
