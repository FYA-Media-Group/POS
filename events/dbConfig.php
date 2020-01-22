<?php
//db details
$dbHost = 'localhost';
$dbUsername = 'fyatedjh_nailspa';
$dbPassword = 'q&#RrLdW,&i7';
$dbName = 'fyatedjh_nailspa';

//Connect and select the database
$db = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);

if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}
?>