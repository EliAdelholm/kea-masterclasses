<?php
    session_start();
    include 'db.php';

    $iUserId = $_SESSION['sUserId'];
    $sEmail = $_POST['txtUserEmail'];
    $sName = $_POST['txtUserName'];
    $sPassword = $_POST['txtUserPassword'];
    $sImg = 'ads';//$_POST['img'];
    $sDesc = $_POST['txtUserDescription'];
    $bNotif = $_POST['notification'] == "on" ? 1 : 0;

    echo "userId " . $iUserId . "<br/>";
    echo "email " . $sEmail . "<br/>";
    echo "name " . $sName . "<br/>";
    echo "name " . $sPassword . "<br/>";
    echo "img: " . $sImg . "<br/>";
    echo "desc " . $sDesc . "<br/>";
    echo "notif: " . $bNotif . "<br/>";

    $statement = "UPDATE users SET `description` = ':desc' WHERE `id` =:id;";
    password = ':passwd', 
    email = ':email', 
    image =':img', 
    `name`=':name', `notification` =':notif',

    $query = $conn->prepare("UPDATE users SET name = :name, notification = :notif, description = :desc WHERE id =:id;"); 
    // echo var_dump($statement);

    $query->bindParam( ':id' , $iUserId,  PDO::PARAM_INT );
    // $query->bindParam( ':email' , $sEmail );
    $query->bindParam( ':name' , $sName );
    // $query->bindParam( ':img' , $sImg );
    $query->bindParam( ':desc' , $sDesc );
    $query->bindParam( ':notif' , $bNotif,  PDO::PARAM_INT );

    $query->execute();        

    echo var_dump($query);
?>
