<?php

function _get_feed_db($_auth){
    $db = new PDO("mysql:host=$_auth['dbhost'];port=$_auth['dbport'];dbname=$_auth['dbname']", $_auth['dbusername'], $_auth['dbpassword']);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->exec("SET NAMES 'utf8';");

    $query = '';

    try {
        global $wpdb;
        $stmt = $db->prepare($query);

        $stmt->execute();

        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($data as $_row){
            $id = $_row['id'];
            $title = $_row['title'];
            $description = $_row['description'];

          //# filter the recordset (get what you need)
          $_insert_ary = array(
              'id' => $id,
              'title' => $title,
              'description' => $description
          );
        }
        return $_insert_ary;

    } catch(PDOException $pdoE) {
        var_dump($pdoE);
    }
}
