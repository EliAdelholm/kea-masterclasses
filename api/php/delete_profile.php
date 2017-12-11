<?php

include 'db.php';

$iUserId = $_GET['id'];
// We pass the image path so we can also delete the users image
$sImageToDelete = $_GET['image'];

						// This is a stored procedure. If it doesn't work for you it's because you haven't imported it. Code is in the root folder. 
$query = $conn->prepare("call deleteUser(:id);"); 

$query->bindParam( ':id' , $iUserId,  PDO::PARAM_INT );
$query->execute();        

unlink($sImageToDelete);

?>