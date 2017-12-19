<?php
	session_start();
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>EVENTS</title>

	<!-- build:css css/combined.css -->
	<link rel="stylesheet" type="text/css" href="css/global.css">
	<link rel="stylesheet" type="text/css" href="css/eventStyle.css">
	<!-- endbuild -->

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
</head>
<body>
	<?php
		include 'nav.php';
		include 'login.html';
	?>

	<div id="topSection">
		<div id="attentionText">
			<h2><span>IN</span></h2>
			<h1><span> MASTERCLASSES</span></h1>
			<h2><span>I LEARN</span></h2>
			<h3><span>INTERRESTING STUFF</span></h3>
		</div>
		<img id="scrollArrow" src="css/img/arrow.svg">
	</div>

	<div id="eventFilterSection">
		<div class="FlexColumnCenter">
			<h1 class="subtitleMargin">events</h1>
			<div id="filtersBtn">
				<p id="filtersText">FILTERS</p>
				<img id="arrow" class="openFilters" src="css/img/arrow.svg">
			</div>
			<div id="displayAllFilters">
				
				<div class="FlexColumnCenter">
					<p class="filterGroup">DATE</p>
					<div class="displayFilters">
						<p id="filterPastEventBtn" class="underline">PAST</p>
						<p id="filterUpcommingEventBtn" class="underline">UPCOMMING</p>
					</div>
				</div>

				<div class="FlexColumnCenter">
					<p class="filterGroup">CATEGORY</p>
					<div class="displayFilters">
						<p id="underlineUi">UI</p>
						<p id="underlineUx">UX</p>
						<p id="underlineDev">DEV</p>
					</div>
				</div>

				<div class="FlexColumnCenter">
					<p class="filterGroup">LOCATION</p>
					<div class="displayFilters">
						<p id="locationBtn" class="underlineLocation">EVENTS NEAR ME</p>
					</div>
				</div>
			</div>
			<!-- *************************************************** -->
	</div>
</div>




	<div id="eventBoxes" class="main-container">
		<!-- <div>{{eventBox}}</div> -->		
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
		// ******************* FILTER EVENTS BY TYPE *********************
		var filterByType = document.getElementsByClassName("filterByType");
		for ( i = 0; i < filterByType.length; i++){
			filterByType[i].addEventListener("click", function(e){
			  for ( j = 0; j < filterByType.length; j++){
			  	if (e.target == filterByType[j]){
			  		switch(j) {
			  			case 0: filterByType[0].style.background = "#52B795"; break;
			  			case 1: filterByType[1].style.background = "#EF4B47"; break;
			  			case 2: filterByType[2].style.background = "#F9E131"; break;
			  		}
			  	} else {
			  		filterByType[j].style.background = "#c1c1c1";
			  		//filterByType[j].style.color = "#f7f7f7";
			  	}
			  }
			});
		}

		// ******************* GET ALL EVENTS FROM MONGO *******************
		var ajax = new XMLHttpRequest();
		ajax.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				var sajEvents = this.responseText;
				gajEvents = JSON.parse(sajEvents)
				displayEvents(gajEvents);
			}
		}
		ajax.open( "GET", "http://localhost:3333/events", true );
		ajax.send();

		function displayEvents(ajEvents) {
			document.getElementById("eventBoxes").innerHTML = "";
			 for (var i = 0; i<ajEvents.length; i++) {
				var id = ajEvents[i]._id
				var img = ajEvents[i].image;
				var sType = ajEvents[i].type;
				var sTitle = ajEvents[i].title;
				var sDate = ajEvents[i].date;
				var sMonth = sDate.split("-")[1];
				var sDay = sDate.split("-")[0];
				var sTime = ajEvents[i].time;
				var sAddress = ajEvents[i].location.address +", " +ajEvents[i].location.room;
				var sSpeaker = ajEvents[i].speaker;

				var borderColor = sType == "ui" ? "greenBorder" : sType == "ux" ? "redBorder" : "yellowBorder";

				var oEvent = '<div class="eventBox" id="'+id+'">\
								<a href="event.php?id='+id+'">\
									<div style="background-image: url('+img+')" class="eventImg '+ borderColor +'"></div>\
									<div class="photo-overlay '+sType+'">\
										<h2>'+sType+'</h2>\
									</div>\
									<div class="eventDesc">\
										<div class="eventDate">\
											<h3 class="month">'+ sMonth +'</h3>\
											<p class="day">'+ sDay +'</p>\
										</div>\
										<div class="eventDetails">\
											<h3 class="eventTitle">'+ sTitle +'</h3>\
											<div class="iconDiv"><img src="css/img/location.svg"><p>'+ sAddress +'</p></div>\
											<div class="iconDiv"><img src="css/img/person.svg"><p>Held by '+ sSpeaker +'</p></div>\
											<div class="iconDiv"><img src="css/img/time.svg"><p>'+ sTime +'</p></div>\
										</div>\
									</div>\
								</a>\
							</div>';
				eventBoxes.insertAdjacentHTML('beforeend', oEvent);
				checkPastDate(sDate, id);
			}
		};

		// ******************* DISPLAY PAST EVENTS IN GRAY *******************
		function checkPastDate(sDate, id){
			var date = sDate.split("-");
			if (Date.parse(date) < Date.now()) {
				console.log("event has past date");
				var pastEvent = document.getElementById(id);
				pastEvent.style.opacity = "0.5";
				pastEvent.classList.add("pastEvent");
			}else {
				var upcommingEvent = document.getElementById(id);
				upcommingEvent.classList.add("upcommingEvent");
			}
		}

		// ******************* FILTER PAST AND UPCOMMING EVENTS *******************
		var aUpcommingEvents = document.getElementsByClassName("upcommingEvent");
		var aPastEvents = document.getElementsByClassName("pastEvent");
		filterPastEventBtn.addEventListener("click", function(){
			filterUpcommingEventBtn.style.opacity = "0.5";
			filterPastEventBtn.style.opacity = "1";
			 for (var i = 0; i<aUpcommingEvents.length; i++){
				aUpcommingEvents[i].style.display = "none";
			 }
			 for (var i = 0; i<aPastEvents.length; i++){
				aPastEvents[i].style.display = "block";
			 }
		});
		filterUpcommingEventBtn.addEventListener("click", function(){
			filterPastEventBtn.style.opacity = "0.5";
			filterUpcommingEventBtn.style.opacity = "1";
			 for (var i = 0; i<aPastEvents.length; i++){
				aPastEvents[i].style.display = "none";
			 }
			 for (var i = 0; i<aUpcommingEvents.length; i++){
				aUpcommingEvents[i].style.display = "block";
			 }	
		});

		//*************************** SHOW TEXT SLOWLY ************************
		function appear(elm, i, step, speed){
			var toAppar;
			//initial opacity i
			//opacity increment step
			//time waited between two opacity increments in msec speed
			toAppar = setInterval(function(){
				//get opacity in decimals
				var opacity = i / 100;
				//set the next opacity step
				i = i + step; 
				if(opacity > 1 || opacity < 0){
					clearInterval(toAppar);
					//if 1-opaque or 0-transparent, stop
					return; 
				}
				//modern browsers
				elm.style.opacity = opacity;
				//older IE
				elm.style.filter = 'alpha(opacity=' + opacity*100 + ')';
			}, speed);
		}

		var spanToAppear =  document.getElementsByTagName('span');
		for (var i = 0; i<spanToAppear.length; i++){
			appear(spanToAppear[i], 0, 5, 50);
		}
		appear(scrollArrow, 0,5,150);

		// ************************* GET USERS LOCATION *************************
		var locationClickCount = 1;
		locationBtn.addEventListener("click", function(){
			// /user-location/:usersLat/:usersLng
			if(locationClickCount % 2 == 1){
				getLocalEvents();
				locationBtn.className += " activeLocation";
				locationClickCount++
			}else{
				displayEvents(gajEvents);
				locationBtn.classList.remove("activeLocation");
				locationClickCount++

			}
			
		})

		function getLocalEvents() {
			var ajax = new XMLHttpRequest();
			ajax.onreadystatechange = function() {
				if (this.readyState == 4 && this.status == 200) {
					var sajEvents = this.responseText;
					//console.log("sajEvents ", sajEvents);
					var ajEvents = JSON.parse(sajEvents);
					displayEvents(ajEvents);
				}
			}
			ajax.open( "GET", "http://localhost:3333/user-location/"+gUsersLat+"/"+gUsersLng, true );
			ajax.send();
		}

		function getLocation() {
				if (navigator.geolocation) {
					navigator.geolocation.getCurrentPosition(showPosition);
				} else {
					console.log("Geolocation is not supported by this browser.q");
				}
		}

		function showPosition(position) {
			gUsersLat = position.coords.latitude;
			gUsersLng = position.coords.longitude;
			gUserPosition = "Latitude: " + gUsersLat + " Longitude: " + gUsersLng; 
			console.log(gUserPosition);
		}

		// ************* SHOW AND HIDE FILTERS BOX ****************
		var count = 0;
		$("#displayAllFilters").hide();
		$(document).ready(function(){
			$("#filtersBtn").click(function(){
				if(count % 2 == 1){
					$("#displayAllFilters").hide(1000);
					$( "#arrow" ).addClass( "openFilters" );
					count ++
				}else{
					$("#displayAllFilters").show(1000);
					$( "#arrow" ).removeClass( "openFilters" )
					count ++
				}
			});
		});

		scrollArrow.addEventListener("click", function(){
			document.querySelector('#eventFilterSection').scrollIntoView({ behavior: 'smooth' })
			//window.scrollBy({ top: 100, left: 0, behavior: 'smooth' });
		})
		

		window.onload = function(e){ 
			getLocation();
		}

	</script>
 </body>
</html>