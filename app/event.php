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
		var jEvent;

		// AJAX FOR GENERATING THE EVENT	
  		var xhttp = new XMLHttpRequest();
  		xhttp.onreadystatechange = function() {
    	if (this.readyState == 4 && this.status == 200) {
			var sjEvent = this.responseText;
			console.log(sjEvent);
			// This is a global variable
			jEvent = JSON.parse(sjEvent);
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
				<h3>Location: </h3>\
				<p>Address: '+jEvent.location.address+' | Room '+jEvent.location.room+' :</p>\
				<p> Amount of registrations: '+jEvent.attendance+' </p>';
				// GENERATE CONTENT BASED ON THE USER BEING LOGGED IN OR NOT
				<?php 
				if (isset($_SESSION['sUserId'])) {
					echo 'if (jEvent.signedUp == true){';
						echo 'eventContainerHTML += "<div id=optionsContainer>";';
						echo 'eventContainerHTML += "<p class=bold>You are currently signed up for this event</p>";';
						echo 'eventContainerHTML += "<button id=btnUnregister data-eventId="+jEvent._id+"> I am not going </button>";';	
						echo 'eventContainerHTML += "</div>";';												
						echo '}';
						echo 'else {';
						echo 'eventContainerHTML += "<div id=optionsContainer>";';
							
							echo 'eventContainerHTML += "<button id=btnRegister data-eventId="+jEvent._id+"> I am going </button>";';
							echo 'eventContainerHTML += "</div>";';												
							
							echo '}'; 
						}
						else {
							echo 'eventContainerHTML += "<p id=errorMessage>You must be logged in to register for events</div>";';
						} 
						?>
					eventContainer.innerHTML = eventContainerHTML; 
						
					// Edit for the admin. It's inside the AJAX call to it's generated at the same time as the rest of the event.
						<?php 
						if (isset($_SESSION['bAdmin'])) {
							echo 'var btnEditHTML = "<button id=btnEdit>Edit this event</button>";';
							echo 'eventContainer.insertAdjacentHTML("beforeend" , btnEditHTML);';
						}
						?>
    	}
	};
	xhttp.open("GET", "../api/php/get-event.php?eventId=<?php echo $_GET['id']?>&userId=<?php echo $_SESSION['sUserId'] ?>", true);
	xhttp.send();
	
	// AJAX FOR REGISTERING FOR AN EVENT
	document.addEventListener("click" , function(e){
		if (e.target.id == "btnRegister") {
			optionsContainer.innerHTML = "Loading...";
			console.log("X");
			var sEventId = jEvent._id;
			console.log("Event id:  " + sEventId);
			var xhttp = new XMLHttpRequest();
  			xhttp.onreadystatechange = function() {
    		if (this.readyState == 4 && this.status == 200) {
				 sResponse = this.responseText;
				 console.log(sResponse);
				 optionsContainer.innerHTML = '<p class=bold>You are currently signed up for this event</p>\
				 						  <button id=btnUnregister data-eventId='+jEvent._id+'> I am not going </button>';
    		}
  		};
		xhttp.open("GET", "../api/php/register_attendance.php?userId=<?php echo $_SESSION['sUserId']?>&eventId="+sEventId, true);
		xhttp.send();
		}
	});

	// AJAX FOR UNREGISTERING FROM AN EVENT
	document.addEventListener("click" , function(e){
		if (e.target.id == "btnUnregister") {
			optionsContainer.innerHTML = "Loading..."
			var sEventId = jEvent._id;
			var xhttp = new XMLHttpRequest();
  			xhttp.onreadystatechange = function() {
    		if (this.readyState == 4 && this.status == 200) {
				 sResponse = this.responseText;
				 console.log(sResponse);
				 // Remove the message that says we're already registered
				 optionsContainer.innerHTML = '<button id=btnRegister data-eventId='+jEvent._id+'> I am going </button>';
    		}
  		};
  xhttp.open("GET", "../api/php/unregister_attendance.php?userId=<?php echo $_SESSION['sUserId']?>&eventId="+sEventId, true);
  xhttp.send();

		}
	});

	document.addEventListener("click", function(e){
		if (e.target.id == "btnEdit"){
			var containerHeaderHTML = '<form id="frmEditEvent">\
										<div id="tagStyle">TYPE <input type="text" name="eventType" value="'+jEvent.type+'"></div>\
										<div>DATE:<input type="text" name="eventDate" value="'+jEvent.date+'"></div>\
										<div>TIME:<input type="text" name="eventName" value="'+jEvent.time+'"></div>\
										<div>SPEAKER:<input type="text" name="eventSpeaker" value="'+jEvent.speaker+'"</div>';

			topImageSection.innerHTML = '<h1><span>'+jEvent.title+'</span></h1>';
			containerHeader.insertAdjacentHTML("afterend" , containerHeaderHTML);
			containerHeader.remove();

			var eventContainerHTML = '<h2>REQUIREMENT</h2>\
				<input type="text" name="eventRequirements" value="'+jEvent.requirements+'"> \
				<h2> DESCRIPTION </h2>\
				<input type="text" name="eventDescription" value="'+jEvent.description+'"><p>\
				<h3>Address </h3>\
				<div><input type="text" name="eventLocation" value="'+jEvent.location.address+'"</div>\
				<h3>Room </h3>\
				<div><input type="text" name="eventRoom" value="'+jEvent.location.room+'"</div>\
				</form>\
				<p> Amount of registrations: '+jEvent.attendance+' </p>\
				<button id="btnConfirmEdit"> Confirm changes</button>';
			eventContainer.innerHTML = eventContainerHTML;
		}
	});

	document.addEventListener("click" , function(e){
		if (e.target.id=="btnConfirmEdit") {
	    var ajax = new XMLHttpRequest();
    	ajax.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
        }
    }
    ajax.open("POST", "../api/php/updateEvent.php", true);
    var jFrmCreateAccount = new FormData(frmEditEvent);
    ajax.send(jFrmCreateAccount);
		}
	});

	</script>
	<!-- If the user is an admin, allow them to edit -->
	<?php
	/*
		if (isset($_SESSION['bAdmin'])) {
			echo '<script src="js/allowAdminEdit.js></script>;';
		}
		*/
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