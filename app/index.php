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
	?>

	<div id="topSection">
		<div id="attentionText">
			<h1><span> MASTERCLASSES <span></h1>
			<h3>Lorem ipsum dolor sit amet, ut augue aliquam pede, arcu amet lorem, sed torquent</h3>
			<button id="topSectionBtn">view events</button>
		</div>
	</div>

	<div id="eventFilterSection">
		<h2>events</h2>
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
		<div id="eventBoxes">
			<!-- <div>{{eventBox}}</div> -->		
		</div>
	</div>
	<?php
		include 'footer.html';
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
			 //console.log("sajEvents ", sajEvents);
			 var ajEvents = JSON.parse(sajEvents); 
			  //console.log("ajEvents ", ajEvents);
			  displayEvents(ajEvents);
			 }
		}
		ajax.open( "GET", "../api/php/get-all-events.php", true );
		ajax.send();


		function displayEvents(ajEvents){
			 for (var i = 0; i<ajEvents.length; i++){
				var id = ajEvents[i]._id
				var img = ajEvents[i].image;
				var sType = ajEvents[i].type;
				var sTitle = ajEvents[i].title;
				var sDate = '12.10.2017';
				var sTime = ajEvents[i].time;
				var sDescription = ajEvents[i].description;
				var sEventDescription = img+' '+sType+' '+sTitle +' '+ sDate +' '+ sTime +' '+ sDescription
				console.log("sEventDescription ", sEventDescription);

				var oEvent = '<div class="eventBox" id="'+id+'">\
								<div class="eventImg greenBorder"><img src='+ img +'></div>\
								<div class="eventDetails">\
									<p>Name: '+ sTitle +'</p>\
									<p>Date: '+ sDate +'</p>\
									<p>Time: '+ sTime +'</p>\
									<p class="eventDescription">Description: '+ sDescription +'</p>\
							</div>';
				eventBoxes.insertAdjacentHTML('beforeend', oEvent);
				checkPastDate(sDate, id);
			}
		};

		function checkPastDate(sDate, id){
			var date = sDate.split("-");
			if (Date.parse(date[0]) < Date.now()) {
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
			filterUpcommingEventBtn.style.background = "#c1c1c1";
			filterPastEventBtn.style.background = "inherit";
			 for (var i = 0; i<aUpcommingEvents.length; i++){
				aUpcommingEvents[i].style.display = "none";
			 }
			 for (var i = 0; i<aPastEvents.length; i++){
				aPastEvents[i].style.display = "block";
			 }
		});

		filterUpcommingEventBtn.addEventListener("click", function(){
			filterPastEventBtn.style.background = "#c1c1c1";
			filterUpcommingEventBtn.style.background = "inherit";
			 for (var i = 0; i<aPastEvents.length; i++){
				aPastEvents[i].style.display = "none";
			 }
			 for (var i = 0; i<aUpcommingEvents.length; i++){
				aUpcommingEvents[i].style.display = "block";
			 }	
		});
		

	</script>
 </body>
</html>