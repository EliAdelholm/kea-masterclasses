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
        $query = $conn->prepare("SELECT * FROM users"); 
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