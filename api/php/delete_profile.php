<?php
//echo 'x';
session_start();
include 'db.php';

$iUserId = 2;//$_SESSION['sUserId'];
echo "userId " . $iUserId;

$query = $conn->prepare("START TRANSACTION;
	DELETE FROM users_emails
	WHERE user_id = :id;
	DELETE FROM users_interests
	WHERE users_id = :id;
	DELETE FROM users_phones
	WHERE users_id = :id;   
	DELETE FROM users
	WHERE id = :id;
COMMIT;"); 

$query->bindParam( ':id' , $iUserId,  PDO::PARAM_INT );
$query->execute();        

echo var_dump($query);


?>