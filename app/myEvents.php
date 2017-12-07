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

			// echo DateTime::createFromFormat("d-M-Y H:i",  "07-Nov-2017 15:00", new DateTimeZone('CET')) -> getTimestamp();

			// ini_set('display_errors', 1);
			// ini_set('display_startup_errors', 1);
			// error_reporting(E_ALL);
				
				for($i = 0; $i < count($aEvents); $i++) {
					$sEventId =  $aEvents[$i];
					$sEvent = file_get_contents("http://localhost:3333/event/" . $sEventId);
					//echo $sEvent . "<br>";
					$oEvent = json_decode($sEvent);
					//echo $sEvent . "<br>";
					$dateAndTime = $oEvent -> date . " " . $oEvent -> time;
					//echo "dateAndTime: " . gettype ($dateAndTime). "<br>";
					
					$dt2 = DateTime::createFromFormat("d-M-Y H:i", $dateAndTime , new DateTimeZone('CET'));
					//echo gettype ($dt2) . "<br>";
					$eventTime = $dt2 -> getTimestamp();

					//echo "eventTime " . $eventTime . "<br>";
					$currentTime = time();
					//echo "currentTime " . $currentTime . "<br>";

					if($eventTime < $currentTime) {
						$rating = $aRatings[$sEventId];
						// echo "Ratings: " . var_dump( $aRatings);
						// echo "Rating: " . $rating;
						?> 
							<div class="eventBox">
								<a href="event.php?id=<?php echo $oEvent -> _id;?>">
								<div class="pastEventImg">
									<img src="<?php echo $oEvent -> image; ?>" class="eventImg greenBorder">
								</div>
								<div class="eventDetails pastEvent">
										<h3 class="eventTitle"><?php echo $oEvent -> title; ?></h3>
										<p>Date:<?php echo $oEvent -> date; ?></p>
										<p>Time:<?php echo $oEvent -> time; ?></p>
										<p class="eventDescription clippedDescription"><?php echo $oEvent -> description; ?></p>
									<div class="ratingContainer">
										<span>RATE:</span>
										<form class="rating">
											<input id="<?php echo $oEvent -> _id;?>" name="eventId" type="hidden" value="<?php echo $oEvent -> _id;?>">
												
											<input type="radio" id="star5<?php echo $oEvent -> _id;?>" name="rating" value="5" class="starRating"/>
											<label class = "full <?php if ($rating >= 5) echo ' active'; ?>" for="star5<?php echo $oEvent -> _id;?>"></label>
											
											<input type="radio" id="star4<?php echo $oEvent -> _id;?>" name="rating" value="4"  class=" starRating"/>
											<label class = "full <?php if ($rating >= 4) echo ' active'; ?>" for="star4<?php echo $oEvent -> _id;?>"></label>

											<input type="radio" id="star3<?php echo $oEvent -> _id;?>" name="rating" value="3"  class=" starRating"/>
											<label class = "full <?php if ($rating >= 3) echo ' active'; ?>" for="star3<?php echo $oEvent -> _id;?>"></label>
											
											<input type="radio" id="star2<?php echo $oEvent -> _id;?>" name="rating" value="2"  class=" starRating"/>
											<label class = "full <?php if ($rating >= 2) echo ' active'; ?>" for="star2<?php echo $oEvent -> _id;?>"></label>

											<input type="radio" id="star1<?php echo $oEvent -> _id;?>" name="rating" value="1"  class=" starRating"/>
											<label class = "full <?php if ($rating >= 1) echo ' active'; ?>" for="star1<?php echo $oEvent -> _id;?>"></label>
										</form>
									</div>
								</div>	
							</div>						
						<?php
					} else {
						?> 
							<div class="eventBox">
								<a href="event.php?id=<?php echo $oEvent -> _id;?>">
								<div class="greenBorder">
									<img src="<?php echo $oEvent -> image; ?>" class="eventImg greenBorder">
								</div>
								<div class="eventDetails">
									<h3 class="eventTitle"><?php echo $oEvent -> title; ?></h3>
									<p>Date: <?php echo $oEvent -> date; ?></p>
									<p>Time: <?php echo $oEvent -> time; ?></p>
									<p class="eventDescription clippedDescription"><?php echo $oEvent -> description; ?></p>
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
		console.log("Clicked: " + evnt.target.parentNode);
		var cls = evnt.target.className;
		if(cls != undefined && cls != null && cls.indexOf("starRating") > -1) {
			console.log(evnt.target);
			var rating = evnt.target.value;
			var eventId = evnt.target.parentElement.children[0].value;
 			console.log("eventId ", eventId);

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
			fd.append("eventId", eventId);
			ajax.send( fd );

		}
	});
</script>
 </body>
</html>