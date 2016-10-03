<?php
define("HOSTNAME","localhost:8889");
define("USERNAME","root");
define("PASSWORD","root");
define("DB_NAME","supercoach");
function connect()
{
    $mysqli = new mysqli(HOSTNAME, USERNAME, PASSWORD, DB_NAME);
    if ($mysqli->connect_errno) {
        printf("Connect failed: %s\n". $mysqli->connect_error);
        exit();
    }
    return $mysqli;
}?>