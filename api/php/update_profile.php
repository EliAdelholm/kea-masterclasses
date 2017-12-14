<?php
    include 'db.php';

    $iUserId = $_POST['id'];
    $sEmail = $_POST['txtUserEmail'];
    $sEmail2 = $_POST['txtUserEmail2'];
    $sEmail3 = $_POST['txtUserEmail3'];    
    $sName = $_POST['txtUserName'];
    $sPassword = $_POST['txtUserPassword'];
    $sDesc = $_POST['txtUserDescription'];
    $sPhone = $_POST['txtUserPhone'];
    $sPhone2 = $_POST['txtUserPhone2'];
    $sPhone3 = $_POST['txtUserPhone3'];    
    $bNotif = $_POST['notification'];
    $sInterests = $_POST['UI'];
    $sUserImage = $_FILES['file'];
    
    
    $bUiInterest = json_decode($_POST['uiInterest']);
    $bUxInterest = json_decode($_POST['uxInterest']);
    $bDevInterest = json_decode($_POST['devInterest']);

    
   

    $sSQL =  "UPDATE users 
    SET name = :name, password = :password, description = :description, notification = :notification    
    WHERE id =:id;";

    if( $sUserImage["error"]  == 0){
    $sFileExtension = pathinfo($sUserImage['name'], PATHINFO_EXTENSION);
    
        $sFolder = '../../app/assets/img/';
        $sFileName = 'userimage-'.uniqid().'.'.$sFileExtension;
        $sSaveFileTo = $sFolder.$sFileName;
        move_uploaded_file($sUserImage['tmp_name'], $sSaveFileTo);

    $sFilePath = 'assets/img/'.$sFileName;  
    
    $sSQL =  "UPDATE users 
    SET name = :name, password = :password, description = :description, notification = :notification, image = :image    
    WHERE id =:id;";
    }

   
    

    $query = $conn->prepare($sSQL); 
    // echo var_dump($statement);

    $query->bindParam( ':id' , $iUserId,  PDO::PARAM_INT );
    $query->bindParam( ':name' , $sName );
    $query->bindParam( ':password' , $sPassword );
    if( $sUserImage["error"]  == 0){
        $query->bindParam( ':image' , $sFilePath );
    }
    $query->bindParam( ':description' , $sDesc );
    $query->bindParam( ':notification' , $bNotif,  PDO::PARAM_INT );

    $query->execute();

    //*****************   EMAIL TABLE  *******************/
    $query = $conn->prepare("UPDATE users_emails 
                            SET email = :email   
                            WHERE user_id =:user_id;");
                            

    $query->bindParam( ':email' , $sEmail );
    $query->bindParam( ':user_id' , $iUserId,  PDO::PARAM_INT );

    $query->execute();


    //*****************   PHONE TABLE  ******************/
    $query = $conn->prepare("UPDATE users_phones 
                            SET phone = :phone   
                            WHERE users_id =:users_id;");
                            
    $query->bindParam( ':phone' , $sPhone );
    $query->bindParam( ':users_id' , $iUserId,  PDO::PARAM_INT );

    $query->execute();


    //*****************   INTERESTS  ******************/
    
    
    $mySqlQuery;
    
    if($bDevInterest) {
        $mySqlQuery .= "INSERT INTO users_interests (users_id, interests) VALUES (:users_id, 'dev'); ";
    }

    else {
        $mySqlQuery .= "DELETE FROM users_interests WHERE users_id = :users_id AND interests = 'dev'; ";
    }

    if($bUiInterest) {
        $mySqlQuery .= "INSERT INTO users_interests (users_id, interests) VALUES (:users_id, 'ui'); ";
    }

    else {
        $mySqlQuery .= "DELETE FROM users_interests WHERE users_id = :users_id AND interests = 'ui'; ";        
    }
    
    if($bUxInterest) {
        $mySqlQuery .= "INSERT INTO users_interests (users_id, interests) VALUES (:users_id, 'ux'); ";
    }

    else {
        $mySqlQuery .= "DELETE FROM users_interests WHERE users_id = :users_id AND interests = 'ux'; ";        
    }
  
    $query = $conn->prepare("$mySqlQuery");
                            
    $query->bindParam( ':users_id' , $iUserId,  PDO::PARAM_INT );

    $query->execute();
    
        
        ?>
