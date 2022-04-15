<?php

$server = 'fdb17.125mb.com:3306';
$username = '3347682_login';
$password = 'smartbikes2020';
$database = '3347682_login';

try {
  $conn = new PDO("mysql:host=$server;dbname=$database;", $username, $password);
} catch (PDOException $e) {
  die('Conexión fallida: ' . $e->getMessage());
}

?>
