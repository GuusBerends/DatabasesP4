<?php 

$PDOoptions = [
    PDO::ATTR_PERSISTENT => true,
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_TIMEOUT => 5, // in seconds
    PDO::MYSQL_ATTR_FOUND_ROWS => true
];

var_dump($_POST);

$db = null;
?>
