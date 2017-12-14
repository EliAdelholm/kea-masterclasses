<?php
session_start();
include 'db.php';

$iEventId = $_POST['eventId'];
$iUserId  = $_SESSION['sUserId'];
$iRating  = $_POST['rating'];

$query = $conn->prepare("UPDATE attendance 
                            SET rating=:rating 
                            WHERE event_id=:event_id and user_id=:user_id;");

$query->bindParam( ':user_id' , $iUserId,  PDO::PARAM_INT );
$query->bindParam( ':rating' , $iRating );
$query->bindParam( ':event_id' , $iEventId );

$query->execute();        

echo "ok";

?>