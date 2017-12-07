<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/global.css">
    <link rel="stylesheet" href="css/stats.css">
    <title>STATS</title>
</head>
<body>

    <?php
        include 'nav.php';
        include 'login.php';
    ?>

       <section id="topBanner">
            <h1><span>STATISTICS</span></h1>
        </section>

<div id="stats-container" class="main-container" >
        <div class="stats-column stats-item">
            <h3>MOST POPULAR EVENTS</h3>
            <ol>
                <li>Event Name</li>
                <hr>
                <li>Event Name</li>
                <hr>
                <li>Event Name</li>
                <hr>
                <li>Event Name</li>
                <hr>
                <li>Event Name</li>
                <hr>
                <li>Event Name</li>
                <hr>
                <li>Event Name</li>
                <hr>
                <li>Event Name</li>
                <hr>
                <li>Event Name</li>
                <hr>
                <li>Event Name</li>
                <hr>
            </ol>
        </div>


        <div class="totals-container">
            <div class="column1">
                <div class="totals-item">
                    <h3>TOTAL EVENTS</h3>
                    <div class="stats-item-count"><span id="noTotalEvents">-</span></div>
                </div>
                <div class="totals-item">
                    <h3>TOTAL USERS</h3>
                    <div class="stats-item-count"><span id="noTotalUsers">-</span></div>
                </div>
            </div>
            
            <div class="column2">
                <div class="totals-item">
                    <h3>EVENT ATTENDANCE THIS SEMESTER</h3>
                    <div class="stats-item-count"><span id="noAttendeesSemester">-</span></div>
                </div>
                <div class="totals-item">
                    <h3>AVERAGE ATTENDANCE PER EVENT</h3>
                    <div class="stats-item-count"><span id="noAvgAttendees">-</span></div>
                </div>
            </div>    
        </div>

    <div id="charts-container" class="stats-column stats-item">
        <h3>AVERAGE ATTENDANCE RATES</h3>
        <canvas id="attendanceChart" class="charts-item"></canvas>
    </div>

    <div id="charts-container" class="stats-column stats-item">
        <h3>AVERAGE CLICK RATES</h3>
        <canvas id="clickChart" class="charts-item"></canvas>
    </div>

    <div id="charts-container" class="stats-column stats-item">
        <h3>AVERAGE RATING</h3>
        <canvas id="ratingChart" class="charts-item"></canvas>
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

    <!-- INCLUDE CHART.JS AND CHART SCRIPTS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.bundle.min.js"></script>
    <script src="js/attendanceChart.js"></script>
    <script src="js/clickChart.js"></script>
    <script src="js/ratingChart.js"></script>
    <script>

        // GET TOTAL EVENTS
        var ajax = new XMLHttpRequest();
        ajax.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                var sStats = this.responseText;
                var iStats = JSON.parse(sStats)

                if(iStats.status == "OK") {
                    noTotalEvents.innerHTML = iStats.eventCount;
                    noTotalUsers.innerHTML = iStats.userCount;
                    noAttendeesSemester.innerHTML = iStats.semesterAttendance;
                    noAvgAttendees.innerHTML = Math.round(iStats.avgEventAttendance);

                }
                
                console.log(iStats);
                
                
            }
        }
        ajax.open( "GET", '../api/php/get-stats.php', true );
        ajax.send();
    
    </script>
    
</body>
</html>