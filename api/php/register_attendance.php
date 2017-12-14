<?php

session_start();
include 'db.php';

$sEventId = $_GET['eventId'];
$iUserId = $_SESSION['sUserId'];


$query = $conn->prepare("INSERT INTO attendance (event_id, user_id) VALUES (:event_id, :user_id)"); 

$query->bindParam( ':event_id' , $sEventId );
$query->bindParam( ':user_id' , $iUserId );

$query->execute();        

echo "user registered";

?>