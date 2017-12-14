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
            <p>At noon they sat down by the roadside, near a little brook, and Dorothy opened her basket and got out some bread.  She offered a piece to the Scarecrow, but he refused.</p>
            <p>&ldquo;I am never hungry,&rdquo; he said, &ldquo;and it is a lucky thing I am not, for my mouth is only painted, and if I should cut a hole in it so I could eat, the straw I am stuffed with would come out, and that would spoil the shape of my head.&rdquo;</p>
            <p>Dorothy saw at once that this was true, so she only nodded and went on eating her bread.</p>
            <p>&ldquo;Tell me something about yourself and the country you came from,&rdquo; said the Scarecrow, when she had finished her dinner.  So she told him all about Kansas, and how gray everything was there, and how the cyclone had carried her to this queer Land of Oz.</p>
        </article>

        <h2 class="sectionHeader">New Event</h2>

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
                <label for="">Upload an image</label>
                <input name="sFile" type="file" class="input-control" />
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