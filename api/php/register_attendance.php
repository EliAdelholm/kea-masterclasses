<?php

// echo 'x';
include 'db.php';


$sEventId = $_GET['eventId'];
$iUserId = $_GET['userId'];



$query = $conn->prepare("INSERT INTO attendance (event_id, user_id) VALUES (:event_id, :user_id)"); 

$query->bindParam( ':event_id' , $sEventId,  PDO::PARAM_INT );
$query->bindParam( ':user_id' , $iUserId,  PDO::PARAM_INT );

$query->execute();        

echo "user registered";

?>