<?php
// Database connection settings
$dsn = 'mysql:host=localhost;dbname=note_db';
$user = 'root';
$password = '';
$option = array(
    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES UTF8"
);
try {
    $con = new PDO($dsn, $user, $password, $option);
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $error) {
    echo $error->getMessage();
}
