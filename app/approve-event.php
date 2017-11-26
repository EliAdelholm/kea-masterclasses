<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>APPROVE EVENT</title>
    <link rel="stylesheet" type="text/css" href="css/hold-masterclass.css">
</head>
</head>

<body>

    <?php
		include 'nav.html';
	?>

    <section id="formContainer">

        <h2>APPROVE EVENT</h2>

        <form id="frmHoldMasterclass" action="">
            <div class="form-group">
                <label class="inline">Select tag</label>
                <button id="filterUiBtn">ui</button>
				<button id="filterUxBtn">ux</button>
				<button id="filterDevBtn">dev</button>
            </div>

            <div class="form-group">
                <label>Name of the event</label>
                <input type="text">
            </div>

            <div class="form-group" style="display: flex;">
                <div class="inline" style="width: 50%;">
                    <label>Date</label>
                    <input class="input-control" />
                </div>

                <div class="inline" style="width: 50%;">
                    <label class="right-inline">Time</label>
                    <input class="input-control" />
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
</body>

</html>