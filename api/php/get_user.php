<?php

// The database connection. You might need to change this if you're not using mamp!
$servername = "localhost";
$username = "root";
$password = "";

// Please use the same database name
$dbname = "kea_masterclasses";


    try {
                $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                //$iUserId = $_GET[':id'];
                $query = $conn->prepare("SELECT id, name, password, notification, image, description, admin FROM users WHERE id= 5;"); 

                // Bind param, this if for security
                $query->bindParam( ':id' , $iUserId );
                $query->bindParam( ':name' , $sUserName );
                $query->bindParam(':password', $sUserPassword);
                $query->bindParam(':notification' , $bNotification);
                // Admin goes to false or "0" by default
                $query->bindParam(':image', $sFilePath);        
                $query->execute();

                

                // set the resulting array to associative
                $result = $query->setFetchMode(PDO::FETCH_ASSOC); 
                foreach(new TableRows(new RecursiveArrayIterator($query->fetchAll())) as $k=>$v) { 
                    echo $v;
                }
    }

    catch(PDOException $e) {

                echo "Error";
    }

?>