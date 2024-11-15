<?php
$databaseHost = 'localhost';
$databaseName = 'poliklinik';
$databaseUsername = 'root';
$databasePassword = '';

$mysqli = new mysqli($databaseHost, $databaseUsername, $databasePassword, $databaseName);

// Check connection
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}
?>


