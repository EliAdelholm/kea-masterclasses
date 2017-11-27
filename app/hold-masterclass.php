<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HOLD MASTERCLASS</title>
    <link rel="stylesheet" type="text/css" href="css/hold-masterclass.css">
</head>
</head>

<body>

    <?php
		include 'nav.php';
	?>

    <section id="formContainer">

        <h2>HOLD MASTERCLASS</h2>

        <form id="frmHoldMasterclass" action="">
            <div class="form-group">
                <label class="inline">Select tag</label>
                <button id="filterUiBtn">ui</button>
				<button id="filterUxBtn">ux</button>
				<button id="filterDevBtn">dev</button>
            </div>

            <div class="form-group">
                <label>Name of the event</label>
                <input required name="sTitle" type="text">
            </div>

            <div class="form-group" style="display: flex;">
                <div class="inline" style="width: 50%;">
                    <label>Date</label>
                    <input required name="sDate" class="input-control" />
                </div>

                <div class="inline" style="width: 50%;">
                    <label class="right-inline">Time</label>
                    <input required name="sTime" class="input-control" />
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
                    <input required name="sAddress" class="input-control" />
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
                console.log(frmData)
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