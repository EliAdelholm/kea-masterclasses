<?php
	session_start();
?>

<!DOCTYPE html>
<html>
<head>
	<title>PROFILE</title>
	<link rel="stylesheet" type="text/css" href="css/global.css">
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
			<div id="addMoreEmailsDiv" class="form-group">
            	<label>Additional email</label>
            	<input class="input-control"/>
            	<button id="addMoreEmailsBtn" type="button">more emails</button>
            </div>
            <div id="addMorePhonesDiv" class="form-group">
                <label>Main phone</label>
                <input class="input-control"/>
                <button id="addMorePhoneBtn" type="button">more phones</button>
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
	<script>
		var clickCountEmails = 0;
		var clickCountPhones = 0;

		addMoreEmailsBtn.addEventListener("click", function(){
			clickCountEmails += 1;
			if(clickCountEmails < 3){
				var inputField = '<div class="transitionStyle"><label>Additional email</label><input class="input-control"/></div>';
				addMoreEmailsDiv.insertAdjacentHTML('beforeend', inputField);
			}
		})

		addMorePhoneBtn.addEventListener("click", function(){
			clickCountPhones += 1;
			if(clickCountPhones < 3){
				var inputField = '<div class="transitionStyle"><label>Additional phone</label><input class="input-control"/></div>';
				addMorePhonesDiv.insertAdjacentHTML('beforeend', inputField);
			}	
		})
	
	</script>
</body>
</html>