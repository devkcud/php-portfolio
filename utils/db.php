<?php
$hostname = "localhost";
$username = "root";
$password = "";
$database = "portfolio";

$con = new mysqli($hostname, $username, $password, $database);

if ($con->connect_error) {
    die("ERROR: " . $con->connect_error);
}

// So it is more verbose when importing on another file
function db_connection() {
    global $con;
    return $con;
}
