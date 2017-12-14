<?php
    session_start();
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PENDING</title>
    <!-- build:css css/combined.css -->
    <link rel="stylesheet" type="text/css" href="css/global.css">
    <link rel="stylesheet" type="text/css" href="css/eventStyle.css">
    <!-- endbuild -->
    <style>
       
            
    </style>
</head>
</head>

<body>

    <?php
        include 'nav.php';
        include 'login.html';
    ?>

     <section id="topBannerPending">
        <h1><span>PENDING EVENTS</span></h1>
    </section>

    <div class="main-container">
        <div class="loader"></div>

        <h2 class="sectionHeader">Pending</h2>
        <div id="pendingContainer">
            <h2>There are no pending events right now</h2>
        </div>

        <h2 class="sectionHeader">Dismissed</h2>
        <div id="dissmissedContainer">
            <button id="btnShowDissmissed">Show Dismissed</button>
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
    
        var ajax = new XMLHttpRequest();
		ajax.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				var sajEvents = this.responseText;
				var ajEvents = JSON.parse(sajEvents)
                console.log(ajEvents);
                
                if(ajEvents.length > 0) {
                    displayEvents(ajEvents, "pending");
                }
			}
		}
		ajax.open( "GET", 'http://localhost:3333/pending-events', true );
        ajax.send();

        function displayEvents(ajEvents, type) {
            var event, borderColor, sDivEvent = '';

            for(var i = 0; i < ajEvents.length; i++) {
                event = ajEvents[i];
                borderColor = event.type == "ui" ? "greenBorder" : event.type == "ux" ? "redBorder" : "yellowBorder";

                sDivEvent +=   '<div class="eventBox" id="'+ event._id +'">\
                                    <a href="event.php?id='+ event._id +'" style="font-weight: inherit;">\
                                        <div style="background-image: url('+ event.image +')" class="eventImg '+ borderColor +'"></div>\
                                        <p><b>Title:</b> '+ event.title +'</p>\
                                        <p><b>Type:</b> '+ event.type +'</p>\
                                        <p><b>Date:</b> '+ event.date +'</p>\
                                        <p><b>Time:</b> '+ event.time +'</p>\
                                        <p><b>Speaker:</b> '+ event.speaker +'</p>\
                                        <p><b>Organizer:</b> '+ event.organizer +'</p>\
                                        <p><b>Location:</b> '+ event.location.address +'</p>\
                                        <p><b>Requirements:</b> '+ event.requirements +'</p>\
                                        <p class="clippedDescription"><b>Description:</b> '+ event.description+'</p>\
                                    </a>';

                type == "pending" ? sDivEvent += '<div class="pendingActions">\
                                                    <button class="btnDissmissEvent" data-id="'+ event._id +'">Dismiss</button>\
                                                    <button class="btnApproveEvent" data-id="'+ event._id +'">Approve</button>\
                                                 </div>\
                                            </div>' : sDivEvent += '</div>';

            }

            if( type == "pending" ) {
                pendingContainer.innerHTML = sDivEvent;
            } else {
                dissmissedContainer.innerHTML = sDivEvent;
            }
        }

        document.addEventListener("click", function(e) {

            // DISSMISS EVENT
            if (e.target.classList.contains("btnDissmissEvent")) {
                var sEventId = e.target.getAttribute("data-id");
                
                ajax.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        var sResults = this.responseText;
                        var jResults = JSON.parse(sResults)

                        if(jResults.status == "OK") {
                            console.log(sEventId)
                            document.getElementById(sEventId).remove();
                        }
                        
                    }
                }
                ajax.open( "GET", 'http://localhost:3333/dissmiss-event/'+sEventId, true );
                ajax.send();
            }

            // APPROVE EVENT
            if (e.target.classList.contains("btnApproveEvent")) {
                var sEventId = e.target.getAttribute("data-id");
                
                ajax.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        var sResults = this.responseText;
                        var jResults = JSON.parse(sResults)

                        if(jResults.status == "OK") {
                            console.log(sEventId)
                            document.getElementById(sEventId).remove();
                        }
                        
                    }
                }
                ajax.open( "GET", 'http://localhost:3333/approve-event/'+sEventId, true );
                ajax.send();
            }
        })

        btnShowDissmissed.addEventListener("click", function() {
            ajax.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				var sajEvents = this.responseText;
				var ajEvents = JSON.parse(sajEvents)
                console.log(ajEvents);
                
                if(ajEvents.length > 0) {
                    displayEvents(ajEvents, "dissmissed");
                }
			}
		}
		ajax.open( "GET", 'http://localhost:3333/dissmissed-events', true );
        ajax.send();
        })
        
    </script>
    
</body>

</html>