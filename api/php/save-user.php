<?

$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "kea_masterclasses";


// INSERT INTO `users` (`name`, `email`, `password`, `notification`, `admin`, `image`) VALUES ('test', 'test', '123', '1', '1', 'test')



    $sFileExtension = pathinfo($_FILES['fileUserImage']['name'], PATHINFO_EXTENSION);
	$sFolder = '../../app/assets/img/';
	$sFileName = 'userimage-'.uniqid().'.'.$sFileExtension;
	$sSaveFileTo = $sFolder.$sFileName;
	move_uploaded_file( $_FILES['fileUserImage']['tmp_name'], $sSaveFileTo);

    $sUserName = $_POST['txtSaveUserName'];
    $sUserEmail = $_POST['txtSaveUserEmail'];
    $sUserPassword = $_POST['txtSaveUserPassword'];
    $bNotification = $_POST['checkNotification'];
    $sFilePath = 'assets/img/'.$sFileName;


    try {
                // connect to the database
                $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
                // create a query
                $query = $conn->prepare("INSERT INTO `users` (`name`, `email`, `password`, `notification`, `admin`, `image`) VALUES (:name, :email, :password, :notification, ':admin', ':image')");
                
                $query->bindParam( ':name' , $sUserName );
                $query->bindParam(':email' , $sUserEmail);
                $query->bindParam(':password', $sUserPassword);
                $query->bindParam(':notification' , $bNotification);
                // Admin goes to false or "0" by default
                $query->bindParam(':image', $sFilePath);
                //$query->bindParam(':image', $sFilePath);
                
                // run the query
                
                $bResult = $query->execute();
                $sjResponse = $bResult ? '{"status":"ok"}' : '{"status":"error"}' ;
                // $lastId = $query->lastInsertId();
                //$result = json_encode( $query->fetch(PDO::FETCH_ASSOC) );
        
                echo $sjResponse; 
        
        
            } catch (Exception $e) {
              
                echo "ERROR";
        
            }

?>
