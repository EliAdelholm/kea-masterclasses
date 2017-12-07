<?php
	session_start();
?>

<!DOCTYPE html>
<html>
<head>
	<title>EVENTS</title>
	<link rel="stylesheet" type="text/css" href="css/global.css">
	<link rel="stylesheet" type="text/css" href="css/eventStyle.css">
</head>
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
			<button id="topSectionBtn">view events</button>
		</div>
	</div>

	<div id="eventFilterSection">
		<h2 class="subtitleMargin">events</h2>
		<div id="filerButtons">
			<div id="eventsByTime">
				<button id="filterPastEventBtn" class="filterByTime">past</button>
				<button id="filterUpcommingEventBtn" class="filterByTime">upcomming</button>
			</div>
			<section id="eventsByType">
				<div id="eventsByTypeWidth">
				<button id="filterUiBtn" class="filterByType">ui</button>
				<button id="filterUxBtn" class="filterByType">ux</button>
				<button id="filterDevBtn" class="filterByType">dev</button>	
				<div>			
			</section>
			<div id="searchEvent">
				<input id="search" type="text" name="" placeholder="SEARCH">
			</div>
		</div>

		<!-- <div id="filters">
			<div id="categories">
				<p id="uiBtn">UI</p>
				<p id="uxBtn">UX</p>
				<p id="devBtn">DEV</p>
			</div>
			<div id="timeFilters">
				<p id="upcomingBtn">UPCOMING</p>
				<p id="pastBtn">PAST</p>
			</div>
		</div> -->
		<div id="eventBoxes" class="main-container">
			<!-- <div>{{eventBox}}</div> -->		
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
		
		// var filterByTime = document.getElementsByClassName("filterByTime");
		// for ( i = 0; i < filterByTime.length; i++){
		// 	filterByTime[i].addEventListener("click", function(e){
		// 	  for ( j = 0; j < filterByTime.length; j++){
		// 	  	if (e.target == filterByTime[j]){
		// 	  		filterByTime[j].style.background = "inherit";
		// 	  	} else {
		// 	  		filterByTime[j].style.background = "#c1c1c1";
		// 	  	}
		// 	  }
		// 	});
		// }

		var ajax = new XMLHttpRequest();
		ajax.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				var sajEvents = this.responseText;
				var ajEvents = JSON.parse(sajEvents)
				displayEvents(ajEvents);
			}
		}
		ajax.open( "GET", "http://localhost:3333/events", true );
		ajax.send();


		function displayEvents(ajEvents) {
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
									<div class="eventDesc">\
										<div class="eventDate">\
											<h3 class="month">'+ sMonth +'</h3>\
											<p class="day">'+ sDay +'</p>\
										</div>\
										<div class="eventDetails">\
											<h3 class="eventTitle">'+ sTitle +'</h3>\
											<p>'+ sAddress +'</p>\
											<p>Held by '+ sSpeaker +'</p>\
											<p>'+ sTime +'</p>\
										</div>\
									</div>\
								</a>\
							</div>';
				eventBoxes.insertAdjacentHTML('beforeend', oEvent);
				checkPastDate(sDate, id);
			}
		};

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
		
function appear(elm, i, step, speed){
    var t_o;
    //initial opacity
    i = i || 0;
    //opacity increment
    step = step || 5;
    //time waited between two opacity increments in msec
    speed = speed || 50; 

    t_o = setInterval(function(){
        //get opacity in decimals
        var opacity = i / 100;
        //set the next opacity step
        i = i + step; 
        if(opacity > 1 || opacity < 0){
            clearInterval(t_o);
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
	appear(spanToAppear[i], 0, 5, 60);
}

	</script>
 </body>
</html>