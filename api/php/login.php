<?php
session_start();

// The database connection. You might need to change this if you're not using mamp!
$servername = "localhost";
$username = "root";
$password = "root";
// Please use the same database name
$dbname = "kea_masterclasses";

// Get the data from the client

$sUserName = $_POST['txtUserLoginName'];
$sPassword = $_POST['txtUserLoginPassword'];


// get ready to connect to the database
$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);

// create a query
$query = $conn->prepare("SELECT id FROM users WHERE name = :name  AND password = :password");

$query->bindParam(':name' , $sUserName);
$query->bindParam(':password' , $sPassword);

// run the query


$bResult = $query->execute();

// Check if we get any results
if ($query->rowCount() > 0) {
    echo 'Logging in';
  } else {
     echo 'Account does not exist';
     exit;
}

// Get the results
$query->setFetchMode(PDO::FETCH_OBJ);

$jUser = $query->fetch();
$iUserId = $jUser->id;

$_SESSION['sUserId'] = $iUserId;

?>