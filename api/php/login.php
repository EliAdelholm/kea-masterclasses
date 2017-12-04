<?php
session_start();

// The database connection. You might need to change this if you're not using mamp!

// get ready to connect to the database
include 'db.php';
// Get the data from the client

$sUserName = $_POST['txtUserLoginName'];
$sPassword = $_POST['txtUserLoginPassword'];

// create a query
$query = $conn->prepare("SELECT id, admin FROM users WHERE name = :name  AND password = :password");

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
if ($jUser->admin == 1){
  $_SESSION['bAdmin'] = true;
}

$iUserId = $jUser->id;

$_SESSION['sUserId'] = $iUserId;
$_SESSION['bAdmin'] = true;

?>