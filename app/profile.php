<?php
	session_start();
?>

<!DOCTYPE html>
<html>
<head>
	<title>PROFILE</title>
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link rel="stylesheet" type="text/css" href="css/profileStyle.css">
	<link rel="stylesheet" type="text/css" href="css/hold-masterclass.css">
</head>
<body>
	<?php
		include 'nav.php';
	?>

	<div id="profileContentBox">
		<div id="profilePicture"></div>

		<form id="frmUpdateProfile" action="">

            <div class="form-group">
                <label for="">Update profile picture</label>
                <input type="file" class="input-control" />
            </div>

            <div class="form-group">
                <label>Name</label>
                <input type="text">
            </div>

            <div class="form-group">
                <label>E-mail</label>
                <input type="text">
            </div>

            <div class="form-group">
                <label>Password</label>
                <input class="input-control"/>
            </div>

            <div class="form-group displayFlex">
			    <label for="subscribeNews">NOTIFY ME ABOUT MY EVENTS</label>
			    <input type="checkbox">
			</div>
			<hr>
			<h3>ADDITIONAL INFORMATION</h3>
			<div class="form-group">
                <label>Second email</label>
                <input class="input-control"/>
            </div>
            <div class="form-group">
                <label>Main phone</label>
                <input class="input-control"/>
            </div>
            <div class="form-group">
                <label>Second phone</label>
                <input class="input-control"/>
            </div>
            <div class="form-group">
                <label>Description</label>
                <input class="input-control"/>
            </div>
            <div class="form-group">
                <button class="redBtn">Save changes</button>
            </div>
        </form>
	</div>

	<?php
		include 'footer.html';
	?>
</body>
</html>