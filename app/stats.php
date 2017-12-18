<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">

        <!-- build:css css/combined.css -->
        <link rel="stylesheet" href="css/global.css">
        <link rel="stylesheet" href="css/stats.css">
        <!-- endbuild -->
        
        <title>STATS</title>
    </head>
    <body>

        <?php
            include 'nav.php';
        ?>

        <section id="topBannerStats">
            <h1><span>STATISTICS</span></h1>
        </section>

        <div id="stats-container" class="main-container" >
            <div class="stats-column stats-item">
                <h3>MOST POPULAR EVENTS</h3>
                <ol id="listPopularEvents">
                    <!-- Loading ... -->
                </ol>
            </div>


            <div class="totals-container">
                <div class="column1">
                    <div class="totals-item topLeft">
                        <h3>TOTAL EVENTS</h3>
                        <div class="stats-item-count"><span id="noTotalEvents"></span></div>
                    </div>
                    <div class="totals-item bottomLeft">
                        <h3>TOTAL USERS</h3>
                        <div class="stats-item-count"><span id="noTotalUsers"></span></div>
                    </div>
                </div>
                
                <div class="column2">
                    <div class="totals-item topRight">
                        <h3>EVENT ATTENDANCE THIS SEMESTER</h3>
                        <div class="stats-item-count"><span id="noAttendeesSemester"></span></div>
                    </div>
                    <div class="totals-item bottomRight">
                        <h3>AVERAGE ATTENDANCE PER EVENT</h3>
                        <div class="stats-item-count"><span id="noAvgAttendees"></span></div>
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

        <div class="stats-column stats-item">
                <h3>SPEAKERS</h3>
                <ol id="listSpeakers">
                    <!-- Loading ... -->
                </ol>
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

        <!-- INCLUDE CHART.JS -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.bundle.min.js"></script>

        <script>
            var jClickrates;

            // GET STATS
            var ajax = new XMLHttpRequest();
            var statItems = document.querySelectorAll('.stats-item');
            var chartItems = document.querySelectorAll('.charts-item');
            var statItemCount = document.querySelectorAll('.stats-item-count');
            var loaderHTML = '<div class="loader"></div>'
            var babyLoaderHTML = '<div class="babyLoader"></div>'
            
            statItemCount.forEach(function(item){
                var childNode = item.childNodes;
                childNode[0].innerHTML = babyLoaderHTML;
            });

            statItems.forEach(function(item){
                item.insertAdjacentHTML("beforeend" , loaderHTML);
            });


            
            ajax.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    var sjStats = this.responseText;
                    var jStats = JSON.parse(sjStats)
                    jClickrates = jStats.avgClickrates;
                    
                    if(jStats.status == "OK") {
                        // fix the styling from the loader style to the stat one
                        statItems.forEach(function(item){
                            item.style.display = 'block';
                        })
                        
                        
                        noTotalEvents.innerHTML = jStats.eventCount;
                        noTotalUsers.innerHTML = jStats.userCount;
                        noAttendeesSemester.innerHTML = jStats.semesterAttendance;
                        noAvgAttendees.innerHTML = Math.round(jStats.avgEventAttendance);
                        
                        var sListPopularEvents = '';
                        for (var i = 0; i < jStats.popularEvents.length; i++) {
                            var event = jStats.popularEvents[i];
                            
                            sListPopularEvents += '<a href="event.php?id='+event._id+'"><li class="'+event.type+'">'+ event.title +'</li></a>'
                        }
                        listPopularEvents.innerHTML = sListPopularEvents;

                        var sListSpeakers = '';
                        for (var i = 0; i < jStats.speakers.length; i++) {
                            var speaker = jStats.speakers[i];
                            var phone = speaker.phone.length > 0 ? speaker.phone[0].phone : "none"

                            sListSpeakers += '<li class="">'+ speaker.name + '<p>Email: '+ (speaker.email.length > 0 ? speaker.email[0].email : " none")+' - Phone: '+ phone +'</p></li>'
                        }
                        listSpeakers.innerHTML = sListSpeakers;
                        
                        var loaders = document.querySelectorAll('.loader');
                        loaders.forEach(function(loader){
                            loader.style.display = 'none';
                        });
                        chartItems.forEach(function(chartItem){
                            chartItem.style.display = 'block';
                        })

                        statItemCount.forEach(function(item){
                            item.style.margin = '30px 0 0 0';
                        });
                    }
                    
                    console.log(jStats);
                    
                    // Include charts js with PHP to access data
                    // Only clickChart is actually working with data from db
                    <?php
                        include 'js/clickChart.js';
                        include 'js/attendanceChart.js';
                        include 'js/ratingChart.js';
                    ?>
                }
            }
            ajax.open( "GET", '../api/php/get-stats.php', true );
            ajax.send();
        
        </script>
        
    </body>
</html>