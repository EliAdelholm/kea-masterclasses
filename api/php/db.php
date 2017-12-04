<?php

$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "kea_masterclasses";

// $iUserId = $_GET['id'];
$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

?>
