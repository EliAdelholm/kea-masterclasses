<div id="positionAbsolut" class="nav">
	<nav class="main-container">
	
		<!-- ADMIN NAV ITEMS -->
		<?php 
		error_reporting(E_ERROR | E_WARNING | E_PARSE);

			if($_SESSION['bAdmin']) {
				echo '<a href="stats.php" class="extraMargin">STATS</a>
					  <a href="pending.php" class="extraMargin">PENDING</a>';
			}
		?>

		<!-- STATIC NAV ITEMS -->
		<a href="index.php" class="extraMargin">EVENTS</a>
		<a href="create-event.php" class="extraMargin">CREATE EVENT</a>

		<!-- LOGIN OR PROFILE NAV ITEM -->
		<?php
			if (!isset($_SESSION['sUserId'])) {
				echo '<a href="#" id="btnOpenLogin" class="extraMargin">LOGIN</a>';
			} else {
				echo '<a href="myEvents.php" class="extraMargin">MY EVENTS</a>
					  <a href="#" id="btnOpenDropdown" class="extraMargin">PROFILE</a>';
			}
		?>

		
		
	</nav>
	<div id="navDropdown" class="main-container" style="position: relative;">
		<div id="nav-dropdown">
			<a href="profile.php">SETTINGS</a>
			<a href="#" id="btnLogout">LOGOUT</a>
		</div>
	</div>
</div>
