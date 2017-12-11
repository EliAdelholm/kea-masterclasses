<?php

session_start();
include 'db.php';

$iUserId = $_GET['id'];
						// This is a stored procedure. If it doesn't work for you it's because you haven't imported it. Code is in the root folder. 
$query = $conn->prepare("call deleteUser(:id);"); 

$query->bindParam( ':id' , $iUserId,  PDO::PARAM_INT );
$query->execute();        

?>