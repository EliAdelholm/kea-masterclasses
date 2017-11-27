<?php
	session_start();
?>

<!DOCTYPE html>
<html>
<head>
	<title>EVENTS</title>
	<link rel="stylesheet" type="text/css" href="css/style.css">
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
		
		var filterByTime = document.getElementsByClassName("filterByTime");
		for ( i = 0; i < filterByTime.length; i++){
			filterByTime[i].addEventListener("click", function(e){
			  for ( j = 0; j < filterByTime.length; j++){
			  	if (e.target == filterByTime[j]){
			  		filterByTime[j].style.background = "inherit";
			  	} else {
			  		filterByTime[j].style.background = "#c1c1c1";
			  	}
			  }
			});
		}
	</script>
 </body>
</html>