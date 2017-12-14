<?php
	session_start();
	include '../api/php/db.php';
	
	$iUserId = $_SESSION['sUserId'];
	//echo "userId " . $iUserId;
	
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
	<meta charset="UTF-8">
	<title>MY EVENTS</title>
	<!-- build:css css/combined.css -->
	<link rel="stylesheet" type="text/css" href="css/global.css">
	<link rel="stylesheet" type="text/css" href="css/eventStyle.css">
	<link rel="stylesheet" type="text/css" href="css/starRatingStyle.css">
	<!-- endbuild -->
</head>
</head>
<body>
	<?php
		include 'nav.php';
		include 'login.html';
	?>
	<section id="topBannerMyEvents">
            <h1><span>MY EVENTS</span></h1>
    </section>
	<div id="myEvents" class="main-container">
		<h2 class="sectionHeader">Attendance</h2>
		<div id="eventBoxes">

			<?php
				ini_set('display_errors', 1);
				ini_set('display_startup_errors', 1);
				error_reporting(E_ALL);	
				for($i = 0; $i < count($aEvents); $i++) {
					//echo "aEvents" . var_dump( $aEvents);
					$sEventId =  $aEvents[$i];
					//echo "sEventId " . $sEventId . "</br>";
					$sEvent = file_get_contents("http://localhost:3333/event/" . $sEventId);
					// echo "sEvent " . $sEvent . "</br>";
					$oEvent = json_decode($sEvent);
					//echo "oEvent " . $oEvent . "</br>";
					$dateAndTime = $oEvent -> date . " " . $oEvent -> time;
					
					$dt2 = DateTime::createFromFormat("d-M-Y H:i", $dateAndTime , new DateTimeZone('CET'));
					$eventTime = $dt2 -> getTimestamp();
					$currentTime = time();

					$clz = "";
					switch($oEvent -> type) {
						case "ui": $clz = "greenBorder"; break;
						case "ux": $clz = "redBorder"; break;
						case "dev": $clz = "yellowBorder"; break;
					}
	
					if($eventTime < $currentTime) {
						$rating = $aRatings[$sEventId];
						// echo "Ratings: " . var_dump( $aRatings);
						// echo "Rating: " . $rating;
						
					?> 
					<!-- ******************** PAST EVENT ******************** -->
					<div class="pastEvent">
						<div class="eventBox" id="<?php echo $oEvent -> _id;?>">
							<a href="event.php?id=<?php echo $oEvent -> _id;?>">
								<div style="background-image: url('<?php echo $oEvent -> image; ?>')" class="eventImg <?php echo $clz; ?>"></div>
								<div class="photo-overlay <?php echo $oEvent -> type; ?>">
									<h2><?php echo $oEvent -> type; ?></h2>
								</div>
								<div class="eventDesc">
									<div class="eventDate">
										<?php
											$date = $oEvent -> date;
											list( $day, $month, $year) = explode('-', $date);
										?>
										<h3 class="month"><?php echo $month; ?></h3>
										<p class="day"><?php echo $day; ?></p>
									</div>
									<div class="eventDetails">
										<h3 class="eventTitle"><?php echo $oEvent -> title; ?></h3>
										<p><?php echo $oEvent -> location -> address; ?></p>
										<p>Held by:  <?php echo $oEvent -> speaker; ?></p>
										<p><?php echo $oEvent -> time; ?></p>
									</div>
								</div>
								<!-- ******************** RATE EVENT ******************** -->
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
								<!-- ****************************************************** -->
							</a>
						</div>
					</div>						
					
					<?php
					} else {
						// echo "sEvent " . $sEvent . "</br>";
						// echo "sEvent " . $oEvent -> type . "</br>";
						?> 
							<!-- ******************** UPCOMMING EVENT ******************** -->
							<div class="eventBox" id="<?php echo $oEvent -> _id;?>">
								<a href="event.php?id=<?php echo $oEvent -> _id;?>">
									<div style="background-image: url('<?php echo $oEvent -> image; ?>')" class="eventImg <?php echo $clz; ?>"></div>
									<div class="photo-overlay <?php echo $oEvent -> type; ?>">
										<h2><?php echo $oEvent -> type; ?></h2>
									</div>
									<div class="eventDesc">
										<div class="eventDate">
											<?php
												$date = $oEvent -> date;
												list( $day, $month, $year) = explode('-', $date);
											?>
											<h3 class="month"><?php echo $month; ?></h3>
											<p class="day"><?php echo $day; ?></p>
										</div>
										<div class="eventDetails">
											<h3 class="eventTitle"><?php echo $oEvent -> title; ?></h3>
											<div class="iconDiv"><img src="css/img/location.svg"><p><?php echo $oEvent -> location -> address; ?></p></div>
											<div class="iconDiv"><img src="css/img/person.svg"><p>Held by: <?php echo $oEvent -> speaker; ?></p></div>
											<div class="iconDiv"><img src="css/img/time.svg"><p><?php echo $oEvent -> time; ?></p></div>
										</div>
									</div>
								</a>
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