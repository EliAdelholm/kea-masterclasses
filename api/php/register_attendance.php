<?php
session_start();
// echo 'x';
include 'db.php';


$iEventId = 1;
$iUserId = 1;//$_SESSION['sUserId'];


echo "iEventId". $iEventId;
echo "userId " . $iUserId;

$query = $conn->prepare("INSERT INTO attendance (event_id, user_id) VALUES (:event_id, :user_id)"); 

$query->bindParam( ':event_id' , $iUserId,  PDO::PARAM_INT );
$query->bindParam( ':user_id' , $iUserId,  PDO::PARAM_INT );

$query->execute();        

echo var_dump($query);
echo "user registered";

?>