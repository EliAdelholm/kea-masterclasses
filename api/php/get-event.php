<?php
include 'db.php';

    $sEventId = $_GET['id'];
    
    
    $sjEvent = file_get_contents("http://localhost:3333/event/$sEventId");
    $jEvent = json_decode($sjEvent);
    
    try {
        $query = $conn->prepare("SELECT COUNT(*) AS attendance FROM attendance WHERE event_id=:id");
        $query->bindParam( ':id' , $sEventId );
        $query->execute();
        
        $result = $query->setFetchMode(PDO::FETCH_ASSOC); 
        // This returns an array with 1 element
        $aResult = $query->fetch();
        $key = 'attendance';
        // Get the value from our query and add it to our event object
        $jEvent->$key = $aResult[$key]; 
        $sjEvent = json_encode($jEvent);

        // Echo it back to the client
        echo $sjEvent;
    }
    
    
    
    catch (Exception $e) {
        
        echo "ERROR - could not connect to database";
        
    }  
    
        ?>