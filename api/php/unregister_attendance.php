<?php
include 'db.php';

$iEventId = $_GET['eventId'];
$iUserId = $_GET['userId'];

try {
    $query = $conn->prepare("DELETE FROM attendance WHERE event_id=:event_id AND user_id=:user_id"); 

    $query->bindParam( ':event_id' , $iEventId,  PDO::PARAM_INT );
    $query->bindParam( ':user_id' , $iUserId,  PDO::PARAM_INT );


    $bResult = $query->execute();
    
    $sjResponse = $bResult ? '{"status":"ok, user unregistered"}' : '{"status":"error, could not unregister user"}' ;
    echo $sjResponse;
    }

catch (Exception $e) {
    
    echo "ERROR - could not connect to database";
    
      
}  
?>