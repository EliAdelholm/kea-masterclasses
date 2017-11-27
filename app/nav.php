<!-- <?php
	session_start();
?> -->

<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" type="text/css" href="css/navstyle.css">
</head>
<body>
	<div id="positionAbsolut">
		<nav>
			<a href="index.php" class="extraMargin">EVENTS</a>
			<a href="hold-masterclass.php" class="extraMargin">HOLD MASTERCLASS</a>
			<?php
				if (!isset($_SESSION['sUserId'])) {
					echo '<a href="#" class="extraMargin">LOGIN</a>';
				} else {
					echo '<a href="#" class="extraMargin">PROFILE</a>';
				}
			?>
			
		</nav>
	</div>
</body>
</html>