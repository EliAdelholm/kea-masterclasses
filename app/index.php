<!DOCTYPE html>
<html>
<head>
	<title>EVENTS</title>
	<link rel="stylesheet" type="text/css" href="css/style.css">
</head>
</head>
<body>
	<?php
		include 'nav.html';
	?>

	<div id="topSection">
		<div id="attentionText">
			<h1><span> MASTERCLASSES <span></h1>
			<h3>Lorem ipsum dolor sit amet, ut augue aliquam pede, arcu amet lorem, sed torquent</h3>
			<button>view events</button>
		</div>
	</div>

	<div id="eventFilterSection">
		<h2>events</h2>
		<div id="filerButtons">
			<aside>
				<button id="filterPastEventBtn">past</button>
				<button id="filterUpcommingEventBtn">upcomming</button>
			</aside>
			<section>
				<button id="filterUiBtn">ui</button>
				<button id="filterUxBtn">ux</button>
				<button id="filterDevBtn">dev</button>				
			</section>
			<div>
				<input id="search" type="text" name="" placeholder="SEARCH">
			</div>
		</div>
		<div id="eventBoxes">
			<div class="eventBox">
				<div class="eventImg greenBorder"></div>
				<p>Name:kadkkdj</p>
				<p>Date:15.12.2017</p>
				<p>Time:15:00</p>
				<p>Description: Yes, all those months and years of planning, Valckes criticisms and Seth Balthermouth heartburn.</p>
			</div>	
		</div>
	</div>
	<?php
		include 'footer.html';
	?>
 </body>
</html>