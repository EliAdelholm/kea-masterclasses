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

    <div id="stats-container" class="main-container" style="margin-top: 100px;">

        <div class="stats-column stats-item">
            <h3>MOST POPULAR EVENTS</h3>
            <ol>
                <li>Event Name</li>
                <li>Event Name</li>
                <li>Event Name</li>
                <li>Event Name</li>
                <li>Event Name</li>
                <li>Event Name</li>
                <li>Event Name</li>
                <li>Event Name</li>
                <li>Event Name</li>
                <li>Event Name</li>
            </ol>
        </div>

        <div class="stats-column">
            <div class="stats-item">
                <h3>TOTAL EVENTS</h3>
                <div class="stats-item-count">30</div>
            </div>
            <div class="stats-item">
                <h3>TOTAL USERS</h3>
                <div class="stats-item-count">100</div>
            </div>
            <div class="stats-item">
                <h3>EVENT ATTENDANCE THIS MONTH</h3>
                <div class="stats-item-count">30</div>
            </div>
            <div class="stats-item">
                <h3>AVERAGE ATTENDANCE PER EVENT</h3>
                <div class="stats-item-count">200</div>
            </div>
        </div>
    </div>

    <div id="charts-container" class="main-container stats-item">
        <h3>AVERAGE ATTENDANCE RATES</h3>
        <canvas id="attendanceChart" class="charts-item"></canvas>
    </div>

    <div id="charts-container" class="main-container stats-item">
        <h3>AVERAGE CLICK RATES</h3>
        <canvas id="clickChart" class="charts-item"></canvas>
    </div>

    <div id="charts-container" class="main-container stats-item">
        <h3>AVERAGE RATING</h3>
        <canvas id="ratingChart" class="charts-item"></canvas>
    </div>
    

    <?php
        include 'footer.html';
    ?>

    <script src="js/login.js"></script>
    <!-- INCLUDE CHART.JS AND CHART SCRIPTS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.bundle.min.js"></script>
    <script src="js/attendanceChart.js"></script>
    <script src="js/clickChart.js"></script>
    <script src="js/ratingChart.js"></script>
    
</body>
</html>