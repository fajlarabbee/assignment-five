<?php
//session_start();
require_once __DIR__ . '/includes/functions.php';
require_once __DIR__ . '/includes/classes/DB.php';

//$db = new DB("config.json", "r");
//
//echo $db->read();

getHeader();

echo json_encode($_SERVER, JSON_PRETTY_PRINT);