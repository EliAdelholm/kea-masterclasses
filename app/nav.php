<div id="positionAbsolut" class="nav">
	<nav class="main-container">
	
	<a href="#" class="toggleNav" id="hamburgerBtn">
		<div class="hamburgerContainer">
			<div class="bar1"></div>
			<div class="bar2"></div>
			<div class="bar3"></div>
		</div>
	</a>


		<!-- STATIC NAV ITEMS -->
		<a href="index.php" class="extraMargin hideResponsive">HOME</a>

		<!-- ADMIN NAV ITEMS -->
		<?php 
		error_reporting(E_ERROR | E_WARNING | E_PARSE);

			if($_SESSION['bAdmin']) {
				echo '<a href="stats.php" class="extraMargin hideResponsive">STATS</a>
					  <a href="pending.php" class="extraMargin hideResponsive" style="position: relative;" id="pendingCount">
						  PENDING
					  </a>';
			}
		?>

		<a href="create-event.php" class="extraMargin hideResponsive">CREATE EVENT</a>

		<!-- LOGIN OR PROFILE NAV ITEM -->
		<?php
			if (!isset($_SESSION['sUserId'])) {
				echo '<a href="#" id="btnOpenLogin" class="extraMargin hideResponsive">LOGIN</a>';
			} else {
				echo '<a href="my-events.php" class="extraMargin hideResponsive">MY EVENTS</a>
						<a href="profile.php" class="extraMargin hideResponsive">PROFILE</a>
						<a href="#" id="btnLogout" class="extraMargin hideResponsive">LOGOUT</a>';
			}
		?>

		
		
	</nav>
	<!-- <div id="navDropdown" class="main-container" style="position: relative;">
		<div id="nav-dropdown" class="arrow_box hideResponsive">
			<a href="profile.php" class="displayResponsive">SETTINGS</a>
			<a href="#" id="btnLogout" class="displayResponsive">LOGOUT</a>
		</div>
	</div> -->
</div>


<?php 

	if($_SESSION['bAdmin']) {
		echo '<script src="js/countPendingEvents.js"></script>';
	};

?>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
  
  <script>
    
    $(function(){
      $('.toggleNav').on('click', function(){
				$('nav').toggleClass('open');
				$('#navDropdown').toggleClass('showResponsive')
      });
    });
	

	$(function(){
      $('.hamburgerContainer').on('click', function(){
        $('.hamburgerContainer').toggleClass("change");
      });
    });
	
  </script>