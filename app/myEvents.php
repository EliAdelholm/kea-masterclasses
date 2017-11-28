<?php
	session_start();
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
	?>
	<div id="myEventsStyle">
		<div id="eventBoxes">
			<!-- <div>{{eventBox}}</div> -->
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
						<fieldset class="rating">
							<input type="radio" id="star5" name="rating" value="5" />
							<label class = "full" for="star5" title="Awesome - 5 stars"></label>
							
							<!-- <input type="radio" id="star4half" name="rating" value="4 and a half" />
							<label class="half" for="star4half" title="Pretty good - 4.5 stars"></label> -->
							
							<input type="radio" id="star4" name="rating" value="4" />
							<label class = "full" for="star4" title="Pretty good - 4 stars"></label>
							
							<!-- <input type="radio" id="star3half" name="rating" value="3 and a half" />
							<label class="half" for="star3half" title="Meh - 3.5 stars"></label> -->

							<input type="radio" id="star3" name="rating" value="3" />
							<label class = "full" for="star3" title="Meh - 3 stars"></label>
							
							<!-- <input type="radio" id="star2half" name="rating" value="2 and a half" />
							<label class="half" for="star2half" title="Kinda bad - 2.5 stars"></label> -->
							
							<input type="radio" id="star2" name="rating" value="2" />
							<label class = "full" for="star2" title="Kinda bad - 2 stars"></label>
							
							<!-- <input type="radio" id="star1half" name="rating" value="1 and a half" />
							<label class="half" for="star1half" title="Meh - 1.5 stars"></label>
							 -->
							<input type="radio" id="star1" name="rating" value="1" />
							<label class = "full" for="star1" title="Sucks big time - 1 star"></label>
							
							<!-- <input type="radio" id="starhalf" name="rating" value="half" />
							<label class="half" for="starhalf" title="Sucks big time - 0.5 stars"></label> -->
						</fieldset>
					</div>
				</div>	
			</div>	

		</div>
	</div>
	<?php
		include 'footer.html';
	?>
 </body>
</html>