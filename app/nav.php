<div id="positionAbsolut">
	<nav class="main-container">
	
		<!-- ADMIN NAV ITEMS -->
		<?php 
			if($_SESSION['bAdmin']) {
				echo '<a href="#" class="extraMargin">STATS</a>
					  <a href="#" class="extraMargin">PENDING</a>';
			}
		?>

		<!-- STATIC NAV ITEMS -->
		<a href="index.php" class="extraMargin">EVENTS</a>
		<a href="hold-masterclass.php" class="extraMargin">HOLD MASTERCLASS</a>

		<!-- LOGIN OR PROFILE NAV ITEM -->
		<?php
			if (!isset($_SESSION['sUserId'])) {
				echo '<a href="#" class="extraMargin">LOGIN</a>';
			} else {
				echo '<a href="#" class="extraMargin">PROFILE</a>';
			}
		?>
		
	</nav>
</div>
