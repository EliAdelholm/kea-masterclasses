<?php
	session_start();
?>

<!DOCTYPE html>
<html>
<head>
	<title>PROFILE</title>
	<link rel="stylesheet" type="text/css" href="css/global.css">
	<link rel="stylesheet" type="text/css" href="css/profileStyle.css">
	<!-- <link rel="stylesheet" type="text/css" href="css/hold-masterclass.css"> -->
</head>
<body>

	<?php
		include 'nav.php';
		include 'login.html';
	?>
	<section id="topBannerProfile">
		<h1><span>PROFILE</span></h1>
	</section>


	<form id="frmUpdateProfile" action="../api/php/update_profile.php" method="post" enctype="multipart/form-data">

	<div id="instertUserDetailsHere" class="main-container">

		<div class="column1 displayFlex margin">
			<div id="profilePicture"></div>	
			<!--	Upload Image button	-->
			<div class="box">
					<input type="file" name="file" id="file" class="inputfile inputfile-1"/>
					<label id="lblProfilePicture" for="file"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="17" viewBox="0 0 20 17">
						<path d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z"/>
						<span>Upload Picture</span>
					</label>
			</div>
		</div>
				
		<div class="column2 displayFlex margin">
			<h3>GENERAL INFORMATION</h3>
			<div class="form-group">
				<label>Name</label>
				<input id="txtUserName" type="text" name="txtUserName">
			</div>

			<div class="form-group">
				<label>E-mail</label>
				<input id="txtUserEmail" type="text" name="txtUserEmail">
			</div>

			<div class="form-group">
				<label>Password</label>
				<input id="txtUserPassword" class="input-control" name="txtUserPassword"/>
			</div>

			<div class="form-group">
				<li>
				<label for="subscribeNews">NOTIFY ME ABOUT MY EVENTS</label>
				<input id="notification" value="0" type="checkbox" name="notification">
				</li>		
			</div>

			<div class="form-group">
				<label>Description</label>
				<textarea id="txtUserDescription" name="txtBio" cols="40" rows="8">Sed diam nonummy nibh euismod tincidunt ut laoreet doloremagna aliquam erat volutpat </textarea>		
			</div>

		</div>


		<div class="column3 displayFlex margin">
			<h3>ADDITIONAL INFORMATION</h3>
			<div id="addMoreEmailsDiv" class="form-group">
				<label>Additional email</label>
				<input id="txtUserEmail2" class="input-control" name="txtUserEmail2"/>
				<button id="addMoreEmailsBtn" type="button">more emails</button>
			</div>

				<div id="addMorePhonesDiv" class="form-group">
					<label>Main phone</label>
					<input id="txtUserPhone2" class="input-control" name="txtUserPhone2"/>
					<button id="addMorePhoneBtn" type="button">more phones</button>
				</div>

				<p>SELECT DESIRED INTERESTS</p>
				<div id="filters" class="selectInterest displayFlex">
					<button id="filterUiBtn" class="" type="button" value="UI">UI</button>
					<button id="filterUxBtn" class="" type="button"  value="UX">UX</button>
					<button id="filterDevBtn" class="" type="button">DEV</button>
				</div>
			</div>
			
			<div class="column5 displayFlex">
				<button id="btnSaveChanges" type="button" class="greenBtn button button--isi button--text-thick button--text-upper button--size-s">Save changes</button>
	</form>		

				<button id="btnDeleteProfile" type="button">DELETE PROFILE</button>
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
		
		var clickCountEmails = 0;
		var clickCountPhones = 0;

		addMoreEmailsBtn.addEventListener("click", function(){
			clickCountEmails += 1;
			if(clickCountEmails < 3){
				var inputField = '<div class="transitionStyle"><label>Additional email</label><input class="input-control"/></div>';
				addMoreEmailsDiv.insertAdjacentHTML('afterbegin', inputField);
			}
		});

		addMorePhoneBtn.addEventListener("click", function(){
			clickCountPhones += 1;
			if(clickCountPhones < 3){
				var inputField = '<div class="transitionStyle"><label>Additional phone</label><input id="txtUserPhone3" class="input-control"/></div>';
				addMorePhonesDiv.insertAdjacentHTML('afterbegin', inputField);
			}	
		});

			//****************** JAVASCRIPT FOR UPLOAD IMAGE ******************//
			var inputs = document.querySelectorAll( '.inputfile' );
		Array.prototype.forEach.call( inputs, function( input )
		{
		var label	 = input.nextElementSibling,
			labelVal = label.innerHTML;

		input.addEventListener( 'change', function( e )
		{
			var fileName = '';
			if( this.files && this.files.length > 1 )
				fileName = ( this.getAttribute( 'data-multiple-caption' ) || '' ).replace( '{count}', this.files.length );
			else
				fileName = e.target.value.split( '\\' ).pop();

			if( fileName )
				label.querySelector( 'span' ).innerHTML = fileName;
			else
				label.innerHTML = labelVal;
		});
		});
	


		//****************** UPDATE USER PROFILE --AJAX ******************
		btnSaveChanges.addEventListener("click",function(){
			console.log('button update clicked');
			var ajax = new XMLHttpRequest();
			ajax.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				var sjUser = this.responseText;
				window.location.reload();
			}
		}
		ajax.open( "POST", "../api/php/update_profile.php", true );
		var oFrmUser = new FormData(frmUpdateProfile);
		oFrmUser.append("id", "<?php echo $_SESSION['sUserId']?>" );
		ajax.send(oFrmUser);
		});

		//****************** GET USER DETAILS ******************
		var ajax = new XMLHttpRequest();
		ajax.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				var sjUser = this.responseText;
 				console.log("sjUser ", sjUser);
				
				var jUser = JSON.parse(sjUser);
 				console.log("jUser ", jUser);
				txtUserName.value = jUser.name;
				if(jUser.email.length > 0)
					txtUserEmail.value = jUser.email[0].email;
				if(jUser.email.length > 1)
					txtUserEmail2.value = jUser.email[1].email;
				txtUserPassword.value = jUser.password;
				txtUserDescription.value = jUser.description;
				if(jUser.phone.length > 0)
					txtUserPhone2.value = jUser.phone[0].phone;
				notification.checked = JSON.parse(jUser.notification);
				//imgProfilePicture.src = jUser.image;
				//Javascript to create img tag & source
				var image = document.createElement("img");
				image.id = "imgProfilePicture";	
				image.src = jUser.image;
				profilePicture.appendChild(image);
				
			}
		}
		ajax.open( "GET", "../api/php/get-user.php?id=<?php echo $_SESSION['sUserId']?>", true );
		ajax.send();

		notification.addEventListener("click", function () {
			if (this.checked) {
				this.value = 1;
				console.log(this.value);
			}
			else {
				this.value = 0;
				console.log(this.value);                
			}
		});


		//****************** DELETE USER ******************
		btnDeleteProfile.addEventListener("click", function()
		{
			console.log("delete button clicked");
			var ajax = new XMLHttpRequest();
			ajax.onreadystatechange = function()
			{
				if (this.readyState == 4 && this.status == 200)
				{
					var jUser =this.responseText;
					window.location.href = "index.php";

					var ajax2 = new XMLHttpRequest();
					ajax2.onreadystatechange = function()
					{
						if (this.readyState == 4 && this.status == 200)
						{
							var jUser2 =this.responseText;
							window.location.href = "index.php";
							
						} 
				};
				ajax2.open("POST", "../api/php/logout.php", true);
				ajax2.send();
				} 
			};
			ajax.open("GET", "../api/php/delete_profile.php?id=<?php echo $_SESSION['sUserId']?>", true);
			ajax.send();
			
		});


	</script>
	
</body>
</html>