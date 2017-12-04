<?php
	session_start();
?>

<!DOCTYPE html>
<html>
<head>
	<title>EVENT DETAILS</title>
	<link rel="stylesheet" type="text/css" href="css/viewEvent.css">
	<link rel="stylesheet" type="text/css" href="css/global.css">
</head>
<body>
	<?php
		include 'nav.php';
		include 'login.html';
	?>
	<div id="topImageSection">
	</div>
	<div id="descriptionContainer">
		<div id="containerHeader">
		</div>

		<div id="eventContainer">


		</div>

	</div>

	<?php
		include 'footer.html';
	?>

	<script>
	
		
  		var xhttp = new XMLHttpRequest();
  		xhttp.onreadystatechange = function() {
    	if (this.readyState == 4 && this.status == 200) {
		var sjEvent = this.responseText;
		console.log(sjEvent);
		var jEvent = JSON.parse(sjEvent);
		console.log(jEvent);
		topImageSection.style.backgroundImage = 'url('+jEvent.image+')';

		containerHeader.innerHTML = '<div id="tagStyle">'+jEvent.type+'</div>\
									 <div>DATE: '+jEvent.date+'</div>\
									 <div>TIME: '+jEvent.time+'</div>\
									 <div>SPEAKER: '+jEvent.speaker+'</div>';

		topImageSection.innerHTML = '<h1><span>'+jEvent.title+'</span></h1>';
		var eventContainerHTML = '<h2>REQUIREMENT</h2>\
			<p> '+jEvent.requirements+' </p>\
			<h2> DESCRIPTION </h2>\
			<p> '+jEvent.description+' <p>\
			<p> Amount of registrations: '+jEvent.attendance+' </p>';
			<?php 
			if (isset($_SESSION['sUserId'])) {
					echo 'eventContainerHTML += "<button id=btnRegister data-eventId="+jEvent._id+"> test me </button>";';
				}
				else {
					echo 'eventContainerHTML += "<p id=errorMessage>You must be logged in to register for events</div>";';
				} 
				?>
				eventContainer.innerHTML = eventContainerHTML; 
    	}
	};
	xhttp.open("GET", "../api/php/get-event.php?id=<?php echo $_GET['id']?>", true);
	xhttp.send();
	

	document.addEventListener("click" , function(e){
		if (e.target.id == "btnRegister") {
			console.log("X");
			var sEventId = btnRegister.getAttribute('data-eventId');
			console.log(sEventId);
			var xhttp = new XMLHttpRequest();
  			xhttp.onreadystatechange = function() {
    		if (this.readyState == 4 && this.status == 200) {
				 sResponse = this.responseText;
				 console.log(sResponse);
				 console.log("X");
    		}
  		};
  xhttp.open("GET", "../api/php/register_attendance.php?userId=<?php echo $_SESSION['sUserId']?>&eventId="+sEventId, true);
  xhttp.send();

		}
	});

	</script>

	<?php 
	if (isset($_SESSION['sUserId'])){

	}
	?>

	<?php
	if (!isset($_SESSION['sUserId'])) {
		echo '<script src="js/login.js"></script>';
	}
	else {
		echo '<script src="js/logout.js"></script>';
	}
	?>
	</body>
	</html>