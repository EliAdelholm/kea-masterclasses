<?

// The database connection. You might need to change this if you're not using mamp!
$servername = "localhost";
$username = "root";
$password = "root";
// Please use the same database name
$dbname = "kea_masterclasses";

// INSERT INTO `USERS` (`id`, `name`, `password`, `notification`, `image`) VALUES ('521', 'Patrick', 'test', '1', 'test');



    // Save the image with a unique ID
    $sFileExtension = pathinfo($_FILES['fileUserImage']['name'], PATHINFO_EXTENSION);
	$sFolder = '../../app/assets/img/';
	$sFileName = 'userimage-'.uniqid().'.'.$sFileExtension;
	$sSaveFileTo = $sFolder.$sFileName;
	move_uploaded_file( $_FILES['fileUserImage']['tmp_name'], $sSaveFileTo);

    // Get the data from the client
    $sUserId = uniqid();
    $sUserName = $_POST['txtSaveUserName'];
    $sUserEmail = $_POST['txtSaveUserEmail'];
    $sUserPassword = $_POST['txtSaveUserPassword'];
    $sUserPhone = $_POST['txtSaveUserPhone'];
    $bNotification = $_POST['checkNotification'];
    $sFilePath = 'assets/img/'.$sFileName;

    try {
                // connect to the database
                $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
                // create a query
                $query = $conn->prepare("INSERT INTO `USERS` (`id`, `name`, `password`, `notification`, `image`) VALUES (:id, :name, :password, :notification, :image)");
                
                // Bind param, this if for security
                $query->bindParam( ':id' , $sUserId );
                $query->bindParam( ':name' , $sUserName );
                $query->bindParam(':password', $sUserPassword);
                $query->bindParam(':notification' , $bNotification);
                // Admin goes to false or "0" by default
                $query->bindParam(':image', $sFilePath);
                
                // run the query
                
                
                $bResult = $query->execute();
                
                // If the query is successful the bResult will be true
                $sjResponse = $bResult ? '{"status":"ok, data saved to users table"}' : '{"status":"error, could not save data to users table"}' ;
                
                // Echo back to the client
                echo $sjResponse; 
                
                
            } catch (Exception $e) {
                
                echo "ERROR";
                
            }
            


            ?>
