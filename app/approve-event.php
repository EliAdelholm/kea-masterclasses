<?php
    session_start();
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>APPROVE EVENT</title>
    <link rel="stylesheet" type="text/css" href="css/hold-masterclass.css">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <!-- <link rel="stylesheet" href="/resources/demos/style.css"> -->
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css">
    <link rel="stylesheet" type="text/css" href="css/global.css">
</head>
</head>

<body>

    <?php
        include 'nav.php';
        include 'login.html';
	?>

    <section id="formContainer">

        <h2>APPROVE EVENT</h2>

        <form id="frmHoldMasterclass" action="">
            <div class="form-group displayFlex">
                <label>Select Tag</label>
                <select name="tagList" class="form-group">
                  <option value="volvo">ui</option>
                  <option value="saab">ux</option>
                  <option value="opel">dev</option>
                </select>
               <!--  <label class="inline">Select tag</label>
                <button id="filterUiBtn">ui</button>
                <button id="filterUxBtn">ux</button>
                <button id="filterDevBtn">dev</button> -->
            </div>

            <div class="form-group">
                <label>Name of the event</label>
                <input type="text">
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
                <textarea class="input-control"></textarea>
            </div>

            <div class="form-group">
                <label>Reguired skills</label>
                <input class="input-control"/>
            </div>

            <div class="form-group" style="display: flex;">
                <div class="inline" style="width: 70%;">
                    <label>Address</label>
                    <input class="input-control" />
                </div>

                <div class="inline" style="width: 30%;">
                    <label class="right-inline">Room</label>
                    <input class="input-control" />
                </div>
            </div>

            <div class="form-group">
                <label>Name of lecturer</label>
                <input class="input-control" />
            </div>

            <div class="form-group">
                <label for="">Name of responsible person</label>
                <input class="input-control" />
            </div>

            <div class="form-group">
                <label for="">Upload an image</label>
                <input type="file" class="input-control" />
            </div>


            <div class="form-group">
                <button class="redBtn">Submit</button>
            </div>
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
      <script>
          $( function() {
            $( "#datepicker" ).datepicker();
          } );

         $('#timepicker').timepicker({
            timeFormat: 'HH:mm',
            interval: 60,
            defaultTime: '15',
            startTime: '3:00',
            dynamic: true,
            dropdown: true,
            scrollbar: true
        });
     </script>

</body>

</html>