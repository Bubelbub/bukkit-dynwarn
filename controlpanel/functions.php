<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Robin
 * Date: 2013-01-13
 * Time: 10:12
 * Don't change this file unless you know what you are doing.
 */
include "settings.php";

function delWarning() {


}

function convertArray($data, $int) {
    $i = 0;
    $i2 = 0;
    $found_username = array();
    $new_a = "";

    foreach($data as $key => $value) {
        if(!in_array($value['username'], $found_username)){

            $found_username[$i2] = $value['username'];
            ++$i2;

        }
        $user_id = array_search($value['username'], $found_username);

        if($value['reason'] == null) { //If the Reason field in the DB is null
            $value['reason'] = "No reason given.";
        }
        if(!$value['deleted'] == 1) {
            $new_a[$user_id][$i] = array(
                'id' => $value['id'],
                'username_warner' => $value['username_warner'],
                'reason' => $value['reason'],
                'date' => $value['date']
            );
        }

        ++$i;
    }
    if($int == 0)
        return $new_a;
    else
        return $found_username;
}


function getArray_MySQL() {
    $mysqli = new mysqli(MYSQL_HOST, MYSQL_USER, MYSQL_PW, MYSQL_DB, MYSQL_PORT);
    if(mysqli_connect_errno()) {
        printf("Connect failed: %s\n", mysqli_connect_error());
        exit();
    }
    $query = "SELECT * FROM ew_warns ORDER BY date DESC";
    $db_return = array();
    $i = 0;
    if($result = $mysqli->query($query)) {
        while($row = $result->fetch_array(MYSQLI_ASSOC)) {
            $db_return[$i] = $row;
            ++$i;
        }
        $result-> free();
    }
    $mysqli->close();

    return $db_return;
}
