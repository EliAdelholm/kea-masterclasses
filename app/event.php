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
				<p> Amount of registrations: '+jEvent.attendance+' </p>';
				// GENERATE CONTENT BASED ON THE USER BEING LOGGED IN OR NOT
				<?php 
				if (isset($_SESSION['sUserId'])) {
					echo 'if (jEvent.signedUp == true){';
						echo 'eventContainerHTML += "<p class=bold>You are currently signed up for this event</p>";';
						echo 'eventContainerHTML += "<button id=btnUnregister data-eventId="+jEvent._id+"> I am not going </button>";';							
						echo '}';
						echo 'else {';
							echo 'eventContainerHTML += "<button id=btnRegister data-eventId="+jEvent._id+"> I am going </button>";';
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
			console.log("X");
			var sEventId = btnRegister.getAttribute('data-eventId');
			console.log("Event id:  " + sEventId);
			var xhttp = new XMLHttpRequest();
  			xhttp.onreadystatechange = function() {
    		if (this.readyState == 4 && this.status == 200) {
				 sResponse = this.responseText;
				 console.log(sResponse);
				 btnRegister.style.display = "none";
				 var btnUnregisterHTML = '<p class=bold>You are currently signed up for this event</p>\
				 						  <button id=btnUnregister data-eventId='+jEvent._id+'> I am not going </button>';
				 eventContainer.insertAdjacentHTML("beforeend" , btnUnregisterHTML );
    		}
  		};
		xhttp.open("GET", "../api/php/register_attendance.php?userId=<?php echo $_SESSION['sUserId']?>&eventId="+sEventId, true);
		xhttp.send();
		}
	});

	// AJAX FOR UNREGISTERING FROM AN EVENT
	document.addEventListener("click" , function(e){
		if (e.target.id == "btnUnregister") {
			var sEventId = btnUnregister.getAttribute('data-eventId');
			var xhttp = new XMLHttpRequest();
  			xhttp.onreadystatechange = function() {
    		if (this.readyState == 4 && this.status == 200) {
				 sResponse = this.responseText;
				 console.log(sResponse);
				 btnUnregister.style.display = "none";
				 // Remove the message that says we're already registered
				 var registerMessages = document.querySelectorAll('.bold');
				 registerMessages[0].remove();
				 var btnRegisterHTML = '<button id=btnRegister data-eventId='+jEvent._id+'> I am going </button>';
				 eventContainer.insertAdjacentHTML("beforeend" , btnRegisterHTML );
    		}
  		};
  xhttp.open("GET", "../api/php/unregister_attendance.php?userId=<?php echo $_SESSION['sUserId']?>&eventId="+sEventId, true);
  xhttp.send();

		}
	});

	document.addEventListener("click", function(e){
		if (e.target.id == "btnEdit"){
			containerHeader.innerHTML = '<form id="frmEditEvent">\
										<div id="tagStyle"><input type="text" name="eventType" value="'+jEvent.type+'"</div>\
										<div>DATE: '+jEvent.date+'</div>\
										<div>TIME: '+jEvent.time+'</div>\
										<div>SPEAKER: '+jEvent.speaker+'</div>';

			topImageSection.innerHTML = '<h1><span>'+jEvent.title+'</span></h1>';

			var eventContainerHTML = '<h2>REQUIREMENT</h2>\
				<p> '+jEvent.requirements+' </p>\
				<h2> DESCRIPTION </h2>\
				<p> '+jEvent.description+' <p>\
				</form>\
				<p> Amount of registrations: '+jEvent.attendance+' </p>\
				<button id="btnConfirmEdit"> Confirm changes</button>';
			eventContainer.innerHTML = eventContainerHTML;
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