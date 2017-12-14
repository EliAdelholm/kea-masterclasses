<?php
include 'db.php';

     $iUserId = $_GET['id'];
    try {
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
                $mails = $query->fetchAll();
                
                // ****************** USERS EMAIL TABLE END*******************/

                //****************** USERS PHONES TABLE START*******************/
                $query = $conn->prepare("SELECT  phone
                                        FROM users_phones
                                        WHERE users_id=:users_id"); 


                // Bind param, this if for security
                $query->bindParam( ':users_id' , $iUserId ,  PDO::PARAM_INT);

                // Run the query
                $query->execute();   

                // get the data
                $result = $query->setFetchMode(PDO::FETCH_OBJ);

                // Get the result
                $phones = $query->fetchAll();
                // ****************** USERS PHONES TABLE END*******************/

                //****************** USERS INTERESTS TABLE START*******************/
                $query = $conn->prepare("SELECT  interests
                                        FROM users_interests
                                        WHERE users_id=:users_id"); 


                // Bind param, this if for security
                $query->bindParam( ':users_id' , $iUserId ,  PDO::PARAM_INT);

                // Run the query
                $query->execute();   

                // get the data
                $result = $query->setFetchMode(PDO::FETCH_OBJ);

                // Get the result
                $interests = $query->fetchAll();

                // ****************** USERS INTERESTS TABLE END*******************/

                $aUser->email = $mails;
                $aUser->phone = $phones;
                $aUser->interests = $interests;

                // Turn the array with 1 user into a string that looks like JSON
                $sjUser = json_encode($aUser);                
                               
                echo $sjUser;                

    }

    catch(PDOException $e) {
    
                echo "Error";
    }

?>