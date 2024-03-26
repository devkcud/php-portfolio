<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

function gen_head(string $title, int $return = 1): void {
    $url = str_repeat("../", $return) . "css/output.css";
    echo "<!DOCTYPE html><html lang='en'><head><meta charset='UTF-8'><meta name='viewport' content='width=device-width, initial-scale=1.0'><title>$title</title><link rel='stylesheet' href='$url' /></head><body>";
}
