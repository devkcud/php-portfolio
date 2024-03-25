<?php
$hostname = "localhost";
$username = "root";
$password = "";
$database = "portfolio";

$db = new mysqli($hostname, $username, $password, $database);

if ($db->connect_error) {
    die("ERROR: $db->connect_error");
}
