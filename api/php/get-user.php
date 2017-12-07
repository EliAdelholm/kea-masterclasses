<?php

// The database connection. You might need to change this if you're not using mamp!
$servername = "localhost";
$username = "root";
$password = "root";

// Please use the same database name
$dbname = "kea_masterclasses";

    $iUserId = $_GET['id'];

    try {
                $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                $query = $conn->prepare("SELECT * FROM users WHERE id= :id"); 

                // Bind param, this if for security
                $query->bindParam( ':id' , $iUserId );
                  
                // Run the query
                $query->execute();             

                // set the resulting array to associative
                $result = $query->setFetchMode(PDO::FETCH_ASSOC);

                // Get the result
                $aUser = $query->fetch();

                // Turn the array with 1 user into a string that looks like JSON
                $sjUser = json_encode($aUser);

                // Echo it back to the client
                echo $sjUser;
    }

    catch(PDOException $e) {

                echo "Error";
    }

?>