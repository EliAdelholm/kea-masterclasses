<?php

// The database connection. You might need to change this if you're not using mamp!
$servername = "localhost";
$username = "root";
$password = "root";

// Please use the same database name
$dbname = "kea_masterclasses";

    $iUserId = $_GET['id'];;

    try {
                $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                // $query = $conn->prepare("SELECT *
                //                         FROM users"); 
                $query = $conn->prepare("SELECT  name, password, notification, image, description
                                         FROM users
                                         WHERE id=:id"); 


                // Bind param, this if for security
                $query->bindParam( ':id' , $iUserId ,  PDO::PARAM_INT);
                  
                // Run the query
                $query->execute();   

                // get the data
                $result = $query->setFetchMode(PDO::FETCH_OBJ);

                // Get the result
                $aUser = $query->fetch();


                //****************** USERS EMAIL TABLE START*******************/
                $query = $conn->prepare("SELECT  email
                                         FROM users_emails
                                         WHERE user_id=:user_id"); 


                // Bind param, this if for security
                $query->bindParam( ':user_id' , $iUserId ,  PDO::PARAM_INT);
                  
                // Run the query
                $query->execute();   

                // get the data
                $result = $query->setFetchMode(PDO::FETCH_OBJ);

                // Get the result
                $mails = $query->fetch();

                // ****************** USERS EMAIL TABLE END*******************/

                //****************** USERS EMAIL TABLE START*******************/
                $query = $conn->prepare("SELECT  phone
                                        FROM users_phones
                                        WHERE users_id=:users_id"); 


                // Bind param, this if for security
                $query->bindParam( ':users_id' , $iUserId ,  PDO::PARAM_INT);

                // Run the query
                $query->execute();   

                // get the data
                $result = $query->setFetchMode(PDO::FETCH_ASSOC);

                // Get the result
                $phones = $query->fetch();

                // ****************** USERS EMAIL TABLE END*******************/
                
                $aUser->email = json_encode($mails);
                $aUser->phone = json_encode($phones);

                // Turn the array with 1 user into a string that looks like JSON
                $sjUser = json_encode($aUser);                
                               
                echo $sjUser;                

    }

    catch(PDOException $e) {
    
                echo "Error";
    }

?>