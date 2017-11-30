<?php
	session_start();
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HOLD MASTERCLASS</title>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <!-- <link rel="stylesheet" href="/resources/demos/style.css"> -->
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css">
    <link rel="stylesheet" type="text/css" href="css/global.css">
    
    
</head>
</head>

<body>

    <?php
        include 'login.html';
        include 'nav.php';
    ?>

    <section id="topBanner">
        <h1><span>CREATE EVENT</span></h1>
    </section>

    <section id="formContainer" class="main-container">

        <article class="main-container textColumns">
            <p>At noon they sat down by the roadside, near a little brook, and Dorothy opened her basket and got out some bread.  She offered a piece to the Scarecrow, but he refused.</p>
            <p>&ldquo;I am never hungry,&rdquo; he said, &ldquo;and it is a lucky thing I am not, for my mouth is only painted, and if I should cut a hole in it so I could eat, the straw I am stuffed with would come out, and that would spoil the shape of my head.&rdquo;</p>
            <p>Dorothy saw at once that this was true, so she only nodded and went on eating her bread.</p>
            <p>&ldquo;Tell me something about yourself and the country you came from,&rdquo; said the Scarecrow, when she had finished her dinner.  So she told him all about Kansas, and how gray everything was there, and how the cyclone had carried her to this queer Land of Oz.</p>
        </article>
        <form id="frmHoldMasterclass" action="">
            <div class="form-group displayFlex">
                <label>Select Tag</label>
                <select required name="sType" class="form-group">
                  <option value="ui">ui</option>
                  <option value="ux">ux</option>
                  <option value="dev">dev</option>
                </select>
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
            <p id="msgError"></p>
        </form>

    </section>

    <?php
        include 'footer.html';
    ?>

<script>


      var placeSearch, autocomplete, sTextAddress, sLatitude, sLongitude;

      function initAutocomplete() {
        // Create the autocomplete object, restricting the search to geographical
        // location types.
        autocomplete = new google.maps.places.Autocomplete(
            /** @type {!HTMLInputElement} */(document.getElementById('autocomplete')),
            {types: ['geocode']});

        // When the user selects an address from the dropdown, populate the address
        // fields in the form.
        autocomplete.addListener('place_changed', getAddress);
      }

      function getAddress() {
        // Get the place details from the autocomplete object.
        var place = autocomplete.getPlace();
        console.log(place.formatted_address, place.geometry.location.lat(), place.geometry.location.lng())

        sTextAddress = place.formatted_address;
        sLatitude = place.geometry.location.lat();
        sLongitude = place.geometry.location.lng();
        }
      }

      // Bias the autocomplete object to the user's geographical location,
      // as supplied by the browser's 'navigator.geolocation' object.
    function geolocate() {
        if (navigator.geolocation) {
          navigator.geolocation.getCurrentPosition(function(position) {
            var geolocation = {
              lat: position.coords.latitude,
              lng: position.coords.longitude
            };
            var circle = new google.maps.Circle({
              center: geolocation,
              radius: position.coords.accuracy
            });
            autocomplete.setBounds(circle.getBounds());
          });
        }
      }
    </script>

    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDlyupCC9WLDzTBU_rwfqydgqnvUQX8F60&libraries=places&callback=initAutocomplete"
    async defer></script>

    <script src="js/login.js"></script>
      <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
      <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
      <script src="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>
      <script>
          $( function() {
            $( "#datepicker" ).datepicker({
                firstDay: 1,
                dateFormat: 'd-M-yy'
            });
          });



         $('#timepicker').timepicker({
            timeFormat: 'HH:mm',
            interval: 60,
            defaultTime: '15',
            startTime: '3:00',
            dynamic: true,
            dropdown: true,
            scrollbar: true
        });


        var frmValid = false;

        function validateForm() {
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
                msgError.innerHTML = "Please fill out all required fields"
            } else {
                var frmData = new FormData(frmHoldMasterclass)
                frmData.append("address", sTextAddress);
                frmData.append("lat"), sLatitude);
                frmData.append("lng", sLongitude);

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
        
    </script>

</body>

</html>