<?php
	session_start();
?>

<!DOCTYPE html>
<html>
<head>
	<title>EVENT DETAILS</title>
	<link rel="stylesheet" type="text/css" href="css/eventDetailsStyle.css">
	<link rel="stylesheet" type="text/css" href="css/global.css">
</head>
<body>
	<?php
		include 'nav.php';
		include 'login.html';
	?>
	<div id="topImageSection">
		<h1><span>DB EVENT</span></h1>
	</div>
	<div id="descriptionContainer">
		<div id="containerHeadder">
			<div id="tagStyle">UI</div>
			<div><strong>DATE:</strong> 12.12.2017</div>
			<div><strong>TIME:</strong> 15:00</div>
			<div><strong>SPEAKER:</strong> ANNA HAPPY</div>
		</div>
		<div id="containerContent">
			<form>
				<div>
	                <label><strong>DESCRIPTION</strong></label>
	                <textarea name="Text1" cols="40" rows="4" disabled="disabled">Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan et iusto odio dignissim</textarea>
	            </div>
	            <div class="form-group">
	                <label><strong>REQUIREMENTS:</strong></label>
	                <textarea name="Text1" cols="40" rows="1">Lorem ipsum dolor sit amet</textarea>
	            </div>
				<div class="extraMarginBottom"><strong>ALREADY GOING:</strong> 20</div>
				<div class="form-group">
	                <label><strong>TO DO BEFORE EVENT:</strong></label>
	                <textarea name="Text1" cols="40" rows="1">Sed diam nonummy nibh euismod tincidunt ut laoreet doloremagna aliquam erat volutpat</textarea>
	            </div>
	            	<div id="showToAdmin"></div>
            </form>
            <hr>
            <div id="attedenceBtns">
            	<button class="attedenceBtn">register in event</button>
            	<button class="attedenceBtn" id="cancelBtn">unregister in event</button>
            </div>
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
		var amin = false;
		if(amin){
			var appendToForm = '<button>save changes</button><button>cancel event</button>';
			showToAdmin.insertAdjacentHTML('beforeend', appendToForm);
		}

		var attedenceBtn = document.getElementsByClassName("attedenceBtn");
		for ( i = 0; i < attedenceBtn.length; i++){
			attedenceBtn[i].addEventListener("click", function(e){
			  for ( j = 0; j < attedenceBtn.length; j++){
			  	if (e.target == attedenceBtn[j]){
			  		attedenceBtn[j].style.display = "none";
			  	} else {
			  		attedenceBtn[j].style.display = "inherit";
			  	}
			  }
			});
		}

	</script>
</body>
</html>