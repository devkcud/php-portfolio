<?php
$db = new mysqli("localhost", "root", "", "portfolio");

if ($db->connect_error) {
    die("ERROR: $db->connect_error");
}
