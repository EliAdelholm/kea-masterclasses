<?php
include 'db.php';

    $sEventId = $_GET['eventId'];
    $sUserId = $_GET['userId'];

    
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
        
        // If the user is logged in, check for him being signed up
        if (isset($sUserId)){
            $query = $conn->prepare("SELECT * FROM attendance WHERE event_id=:eventid AND user_id=:userid");
            $query->bindParam( ':eventid' , $sEventId );
            $query->bindParam( ':userid' , $sUserId );
            
            $query->execute();
            $result = $query->setFetchMode(PDO::FETCH_ASSOC); 
            $aResult = $query->fetch();
            $iNumberOfResults = count($aResult);
            // If the user isn't signed up, the result will be 1
            if ($iNumberOfResults !== 1) {
                $jEvent->signedUp = true;        
            }                      
            
            
        }

        $sjEvent = json_encode($jEvent);
        
        // Echo it back to the client
        echo $sjEvent;
    }
    
    
    catch (Exception $e) {
        
        echo "ERROR - could not connect to database";
        
          
    }  
        ?>