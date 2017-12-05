<?php
	session_start();
	include '../api/php/db.php';
	
	$iUserId = $_SESSION['sUserId'];
	echo "userId " . $iUserId;
	
	$query = $conn->prepare("SELECT * FROM attendance WHERE user_id = :user_id;"); 
	
	$query->bindParam( ':user_id' , $iUserId,  PDO::PARAM_INT );
	$query->execute();        
	
	$aEvents = array();
	$aRatings = array();
	if ($query->execute()) {
		while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
			$sEventId = $row['event_id'];
			$aEvents[] = $sEventId;
			$aRatings[$sEventId] = $row['rating'];
		}
	}
?>

<!DOCTYPE html>
<html>
<head>
	<title>MY EVENTS</title>
	<link rel="stylesheet" type="text/css" href="css/global.css">
	<link rel="stylesheet" type="text/css" href="css/eventStyle.css">
	<link rel="stylesheet" type="text/css" href="css/starRatingStyle.css">
</head>
</head>
<body>
	<?php
		include 'nav.php';
		include 'login.html';
	?>

	<div id="myEventsStyle">
		<div id="eventBoxes">

			<?php

			// ini_set('display_errors', 1);
			// ini_set('display_startup_errors', 1);
			// error_reporting(E_ALL);

				for($i = 0; $i < count($aEvents); $i++) {
					$sEventId =  $aEvents[$i];
					$sEvent = file_get_contents("http://localhost:3333/event/" . $sEventId);
					$oEvent = json_decode($sEvent);
					echo $sEvent;
					$dt2 = DateTime::createFromFormat("j-M-Y H:i",  $oEvent -> date . " " . $oEvent -> time, new DateTimeZone('CET'));

					$eventTime = $dt2 -> getTimestamp();
					$currentTime = time();

					if($eventTime < $currentTime) {
						$rating = $aRatings[$sEventId];
						echo "Ratings: " . var_dump( $aRatings);
						echo "Rating: " . $rating;
						?> 
							<div class="eventBox">
								<div class="eventImg greenBorder pastEventImg"></div>
								<div class="eventDetails pastEvent">
									<p>Name:<?php echo $oEvent -> title; ?></p>
									<p>Date:<?php echo $oEvent -> date; ?></p>
									<p>Time:<?php echo $oEvent -> time; ?></p>
									<p class="eventDescription"><?php echo $oEvent -> description; ?></p>
									<div class="ratingContainer">
										<span>RATE:</span>
										<form class="rating">
											<input type="radio" id="star5" name="rating" value="5" class=" starRating"/>
											<label class = "full" for="star5"></label>
											
											<input type="radio" id="star4" name="rating" value="4"  class=" starRating"/>
											<label class = "full" for="star4"></label>

											<input type="radio" id="star3" name="rating" value="3"  class=" starRating"/>
											<label class = "full" for="star3"></label>
											
											<input type="radio" id="star2" name="rating" value="2"  class=" starRating"/>
											<label class = "full" for="star2"></label>

											<input type="radio" id="star1" name="rating" value="1"  class=" starRating"/>
											<label class = "full" for="star1"></label>

										</form>
									</div>
								</div>	
							</div>						
						<?php
					} else {
						?> 
							<div class="eventBox">
								<div class="eventImg greenBorder"></div>
								<div class="eventDetails">
									<p>Name: <?php echo $oEvent -> title; ?></p>
									<p>Date: <?php echo $oEvent -> date; ?></p>
									<p>Time: <?php echo $oEvent -> time; ?></p>
									<p class="eventDescription"><?php echo $oEvent -> description; ?></p>
								</div>	
							</div>	
						<?php
					}
				}
			?>
		</div>
	</div>
	<?php
		include 'footer.html';
	?>

<?php
	if (!isset($_SESSION['sUserId'])) {
		echo '<script src="js/login.js"></script>';
	}
	else {
		echo '<script src="js/logout.js"></script>';
	}
	?>

<script>

	document.addEventListener("click", function(evnt){
		var cls = evnt.target.className;
		if(cls != undefined && cls != null && cls.indexOf("starRating") > -1) {
			console.log(evnt.target);
			var rating = evnt.target.value;

			var ajax = new XMLHttpRequest();
			ajax.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
					var response = this.responseText;
					console.log("response ", response);
				}
			}
			ajax.open( "POST", "../api/php/rate-course.php", true );
			var fd  = new FormData();
			fd.append("rating", rating);
			fd.append("eventId", 2);
			ajax.send( fd );

		}
	});
</script>
 </body>
</html>