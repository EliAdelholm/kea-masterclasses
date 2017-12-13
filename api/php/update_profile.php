<?php
    include 'db.php';

    $iUserId = $_POST['id'];
    $sEmail = $_POST['txtUserEmail'];
    $sName = $_POST['txtUserName'];
    $sPassword = $_POST['txtUserPassword'];
    $sDesc = $_POST['txtUserDescription'];
    $sPhone = $_POST['txtUserPhone2'];
    $bNotif = $_POST['notification'] == "on" ? 1 : 0;
    //$sInterests = $_POST['UI'];
    $sUserImage = $_FILES['file'];


    if( $sUserImage["error"]  == 0){
    $sFileExtension = pathinfo($sUserImage['name'], PATHINFO_EXTENSION);
    
        $sFolder = '../../app/assets/img/';
        $sFileName = 'userimage-'.uniqid().'.'.$sFileExtension;
        $sSaveFileTo = $sFolder.$sFileName;
        move_uploaded_file($sUserImage['tmp_name'], $sSaveFileTo);

    $sFilePath = 'assets/img/'.$sFileName;  
    }

   
    

    $query = $conn->prepare("UPDATE users 
                            SET name = :name, password = :password, description = :description, notification = :notification    
                            WHERE id =:id;";); 

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


    //*****************   INTERESTS TABLE  ******************/
    $query = $conn->prepare("UPDATE users_interests 
                            SET interests = :interests   
                            WHERE users_id =:users_id;");
                            
    $query->bindParam( ':interests' , $sInterests );
    $query->bindParam( ':users_id' , $iUserId,  PDO::PARAM_INT );

    $query->execute();

    echo var_dump($query);
?>
