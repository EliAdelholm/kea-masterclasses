<?php
	session_start();
	include '../api/php/db.php';
	
	$iUserId = $_SESSION['sUserId'];
	echo "userId " . $iUserId;
	
	$query = $conn->prepare("SELECT * FROM attendance WHERE user_id = :user_id;"); 
	
	$query->bindParam( ':user_id' , $iUserId,  PDO::PARAM_INT );
	$query->execute();        
	
	$aEvents = array();
	if ($query->execute()) {
		while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
			$aEvents[] = $row;
		}
	}
	
	$jaEvents = json_encode($aEvents);
	echo var_dump($jaEvents);
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

			<div class="eventBox">
				<div class="eventImg greenBorder"></div>
				<div class="eventDetails">
					<p>Name:kadkkdj</p>
					<p>Date:15.12.2017</p>
					<p>Time:15:00</p>
					<p class="eventDescription">Description: Yes, all those months and years of planning, Valckes criticisms and Seth Balthermouth heartburn.</p>
				</div>	
			</div>

			<div class="eventBox">
				<div class="eventImg greenBorder pastEventImg"></div>
				<div class="eventDetails pastEvent">
					<p>Name:kadkkdj</p>
					<p>Date:15.12.2017</p>
					<p>Time:15:00</p>
					<p class="eventDescription">Description: Yes, all those months and years of planning, Valckes criticisms and Seth Balthermouth heartburn.</p>
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