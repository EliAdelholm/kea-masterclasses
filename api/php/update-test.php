<?php

include 'db.php';

$iUserId = 5;

$query = $conn->prepare("SELECT email FROM users_emails WHERE user_id = :user_id");                           

    $query->bindParam( ':user_id' , $iUserId,  PDO::PARAM_INT );

    $query->execute();

    $aResult = $query->fetchAll();


    for ($i = 0; $i < count($aResult); $i++){
        print_r($aResult[$i]['email']);
    }

?>

