<?php
	session_start();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CREATE EVENT</title>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css">

    <!-- build:css css/combined.css -->
    <link rel="stylesheet" type="text/css" href="css/global.css">
    <link rel="stylesheet" type="text/css" href="css/dropDown.css">
    <!-- endbuild -->
</head>
</head>

<body>

    <?php
        include 'login.html';
        include 'nav.php';
    ?>

    <section id="topBannerCreateEvent">
        <h1><span>CREATE EVENT</span></h1>
    </section>

    <section id="formContainer" class="main-container">

        <article class="main-container textColumns">
            <label>Do you want to hold a masterclass?</label><br>
            <p>Everyone is welcome to host a masterclass about any topic related to UI, UX og Development.</p><br>
            <p>We don’t care if you are a student, a teacher, a KEA alumni or an industry professional wanting to share your knowledge. If you have anything you feel might be educational for our students – we welcome you to take the stage.</p>
            <br>
            <p>In order to hold a masterclass, you must fill out and submit the form below. The event is then created in our system, but an admin must review and approve the event before it is published to the site.</p>
            <br>
            <p>Please make sure that your email and phone are filled in correctly on your profile page, so that we may contact you for further questions or scheduling arrangements.</p> 
            <br>
            <p>It would also be helpful to us if you write a bit about yourself and your competencies in the additional information field on your profile, as that we give us a better idea of you qualifications.</p>
        </article>

        <h2 class="sectionHeader">Your Event</h2>

        <form id="frmHoldMasterclass" action="">
            <div class="displayFlexStyle">
                <label>Select type of the event</label>
                <span class="dropdown-el form-group ">
                    <input type="radio" name="sortType" value="ui" checked="checked" id="ui">
                    <label for="ui">ui</label>
                    <input type="radio" name="sortType" value="ux" id="ux">
                    <label for="ux">ux</label>
                    <input type="radio" name="sortType" value="dev" id="dev">
                    <label for="dev">dev</label>
                </span>
            </div>


            <div class="form-group">
                <label>Name of the event</label>
                <input required name="sTitle" type="text">
            </div>

            <div class="form-group" style="display: flex;">
                <div class="inline" style="width: 50%;">
                    <label>Date</label>
                    <input required name="sDate" class="input-control" id="datepicker"/>
                </div>

                <div class="inline" style="width: 50%;">
                    <label class="right-inline">Time</label>
                    <input  id="timepicker" required name="sTime" class="input-control" />
                </div>
            </div>

            <div class="form-group">
                <label>Description</label>
                <textarea required name="sDescription" class="input-control"></textarea>
            </div>

            <div class="form-group">
                <label>Reguired skills</label>
                <input name="sRequirements" class="input-control"/>
            </div>

            <div class="form-group" style="display: flex;">
                <div class="inline" style="width: 70%;">
                    <label>Address</label>
                    <input required name="sAddress" class="input-control" id="autocomplete" placeholder="Enter your address"
                           onFocus="geolocate()" type="text" />
                </div>

                <div class="inline" style="width: 30%;">
                    <label class="right-inline">Room</label>
                    <input name="sRoom" class="input-control" />
                </div>
            </div>

            <div class="form-group">
                <label>Name of lecturer</label>
                <input name="sLecturer" class="input-control" />
            </div>

            <div class="form-group">
                <label for="">Name of responsible person</label>
                <input name="sResponsible" class="input-control" />
            </div>

            <div class="form-group">
            <input type="file" name="sFile" id="file" class="inputfile inputfile-1 btnUploadEventImage" data-multiple-caption="{count} file selected" multiple/>
            <label id="lblProfilePicture" for="file"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="17" viewBox="0 0 20 17">
                <path d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z"/>
                <span>Upload Picture</span>
            </label>
            </div>

            <div class="form-group">
                <button type="button" class="redBtn" id="btnSubmitEvent">Submit</button>
            </div>
            <p id="msg"></p>
        </form>
    </section>

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

    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>

    <!-- build:js js/combined.js -->
    <script src="js/dateAndTimePicker.js"></script>
    <script src="js/googlePlacesAutocomplete.js"></script>
    <!-- endbuild -->

    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDlyupCC9WLDzTBU_rwfqydgqnvUQX8F60&libraries=places&callback=initAutocomplete"
    async defer></script>
      <script>
        

        		// ******************* ADD IMAGE BEAUTIFY *********************
		var inputs = document.querySelectorAll( '.inputfile' );
		Array.prototype.forEach.call( inputs, function( input )
		{
		var label	 = input.nextElementSibling,
			labelVal = label.innerHTML;

		input.addEventListener( 'change', function( e )
		{
			var fileName = '';
			if( this.files && this.files.length > 0 )
				fileName = ( this.getAttribute( 'data-multiple-caption' ) || '' ).replace( '{count}', this.files.length );
			else
				fileName = e.target.value.split( '\\' ).pop();

			if( fileName )
				label.querySelector( 'span' ).innerHTML = fileName;
			else
				label.innerHTML = labelVal;
		});
		});



        var frmValid = false;

        function validateForm() {
            console.log("<?php echo $_SESSION['sUserId']?>")
            var required = document.querySelectorAll("[required]");

            for (var i = 0; i < required.length; i++) {
                if ( !required[i].value ) {
                    return;
                }
            }
            frmValid = true;
        }
        
        btnSubmitEvent.addEventListener("click", function() {
            validateForm();

            if ( !frmValid ) {
                msg.innerHTML = '<div id="msgError" >\
                                        <h3>Ooops!</h3>\
                                        <p>In order to submit your event</p>\
                                        <p>please fill out all required fields.</p>\
                                    </div>';
            } else {
                msg.innerHTML = '<div id="msgOK" >\
                                        <h3>Your event has been submitted :)</h3>\
                                        <p>The next step is the approval</p>\
                                        <p>and than your event will be published.</p>\
                                    </div>';
                var frmData = new FormData(frmHoldMasterclass)
                frmData.append("sAddress", sTextAddress);
                frmData.append("sLat", sLatitude);
                frmData.append("sLng", sLongitude);
                frmData.append("sUserId", "<?php echo $_SESSION['sUserId']?>");

                var ajax = new XMLHttpRequest();
                ajax.onreadystatechange = function () {
                    if (this.readyState == 4 && this.status == 200) {
                        var sDataFromServer = this.responseText;
                        console.log(sDataFromServer)
                    }
                }
                ajax.open('POST', 'http://localhost:3333/create-event', true);
                ajax.send(frmData);
            }
           
        })
        
        //dropDown
        $('.dropdown-el').click(function(e) {
            e.preventDefault();
            e.stopPropagation();
            $(this).toggleClass('expanded');
            $('#'+$(e.target).attr('for')).prop('checked',true);
        });
        $(document).click(function() {
            $('.dropdown-el').removeClass('expanded');
        });

    </script>

</body>

</html>