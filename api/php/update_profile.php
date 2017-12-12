<?php
    session_start();
    include 'db.php';

   $iUserId = $_POST['id'];
    $sEmail = $_POST['txtUserEmail'];
    $sName = $_POST['txtUserName'];
    $sPassword = $_POST['txtUserPassword'];
    $sImg = $_POST['imgProfilePicture'];
    $sDesc = $_POST['txtUserDescription'];
    //$bNotif = $_POST['notification'] == "on" ? 1 : 0;


    //$statement = "UPDATE users SET `description` = ':desc' WHERE `id` =:id;";
    //password = ':passwd', 
    //email = ':email', 
    //image =':img', 
    //`name`=':name',
    //`notification` =':notif',

    $query = $conn->prepare("UPDATE users SET name = :name, password = :password, description = :description  WHERE id =:id;");
    // echo var_dump($statement);

    $query->bindParam( ':id' , $iUserId,  PDO::PARAM_INT );
    $query->bindParam( ':password' , $sPassword );
    $query->bindParam( ':name' , $sName );
   //$query->bindParam( ':img' , $sImg );
    $query->bindParam( ':description' , $sDesc );
    //$query->bindParam( ':notif' , $bNotif,  PDO::PARAM_INT );

    $query->execute();


   // $query = $conn->prepare("UPDATE users_emails SET email = :email  WHERE user_id =:user_id;")

    //$query->bindParam( ':user_id' , $iUserId ,  PDO::PARAM_INT);
    //$query->bindParam( ':email' , $sEmail );

    //$query->execute();



    echo var_dump($query);
?>
