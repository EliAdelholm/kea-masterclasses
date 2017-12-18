<?php

    // ini_set('display_errors', 1);
    // ini_set('display_startup_errors', 1);
    // error_reporting(E_ALL);

    include 'db.php';
    include('../../api/php/get-speaker-data.php');

    $jStats = json_decode('{"status": "OK"}');

    // GET NUMBER OF EVENTS
    $iEventCount = file_get_contents("http://localhost:3333/count-active-events");
    $jStats->eventCount = $iEventCount;

    // GET CURRENT SEMESTER BY MONTH
    $sToday = new DateTime('', new DateTimeZone('Europe/Riga')); 
    $sMonth = $sToday->format('M');
    // $sMonth = $aToday["month"];
    $aSpring = array("Feb", "Mar", "Apr", "May", "Jun", "Jul");

    if (in_array($sMonth, $aSpring, true)) {
        $sSemester = "spring";
    } else {
       $sSemester = "fall";
    }

    // GET THE EVENTS FROM THiS SEMESTER
    $sajSemesterEvents = file_get_contents("http://localhost:3333/semester-events/$sSemester");
    $ajSemesterEvents = json_decode($sajSemesterEvents);
    $aSemesterEvents = array();
    for ($i = 0; $i < count($ajSemesterEvents); $i++) {
        array_push($aSemesterEvents, $ajSemesterEvents[$i]->_id);
    }

    // GET AVERAGE CLICK RATES BY EVENT TYPE
    $sjAvgClickrates = file_get_contents("http://localhost:3333/average-clickrates");
    $jAvgClickrates = json_decode($sjAvgClickrates);
    $jStats->avgClickrates = $jAvgClickrates;

    // GET POPULAR EVENTS
    $sajPopularEvents = file_get_contents("http://localhost:3333/popular-events");
    $ajPopularEvents = json_decode($sajPopularEvents);
    $jStats->popularEvents = $ajPopularEvents;

    // GET SPEAKER IDS
    $sajSpeakers = file_get_contents("http://localhost:3333/speakers");
    $ajSpeakers = json_decode($sajSpeakers);

    // GET SPEAKER DATA

    // KLAUDIAS CODE
   /*  $aSpeakers = array();
    for ($i = 0; $i < count($ajSpeakers); $i++) {
        $iSpeakerId = $ajSpeakers[$i]->creator;
        include('../../api/php/get-speaker-data.php');
        $sResponse = getSpeakerData($iSpeakerId);
        array_push($aSpeakers, $sResponse);
    }
    $jStats->speakers = $aSpeakers; */

    // THE REAL CODE
    $aSpeakers = array();
    for ($i = 0; $i < count($ajSpeakers); $i++) {
        $iID = $ajSpeakers[$i]->creator;
        $sResponse = file_get_contents("http://localhost/kea-masterclasses/api/php/get-user.php?id=$iID");
        $jResponse = json_decode($sResponse);
        array_push($aSpeakers, $jResponse);
    }
    $jStats->speakers = $aSpeakers;

    

    try {
    
        ///////// GET NUMBER OF USERS /////////
        $query = $conn->prepare("SELECT COUNT(*) AS userCount FROM users"); 
            
        // Run the query
        $query->execute();             

        // set the resulting array to associative
        $result = $query->setFetchMode(PDO::FETCH_ASSOC);

        // Get the result
        $iUserCount = $query->fetch();
        $key = 'userCount';

        // Get the value from our query and add it to our stats object
        $jStats->$key = $iUserCount[$key]; 


        ///////// GET EVENT ATTENDANCE FOR SEMESTER /////////
        $query = $conn->prepare("SELECT COUNT(*) AS semesterAttendance FROM attendance WHERE event_id IN ('".implode("','",$aSemesterEvents)."')"); 
        
        // Run the query
        $query->execute();             

        // set the resulting array to associative
        $result = $query->setFetchMode(PDO::FETCH_ASSOC);

        // Get the result
        $iSemesterAttendance = $query->fetch();
        $key = 'semesterAttendance';

        // Get the value from our query and add it to our stats object
        $jStats->$key = $iSemesterAttendance[$key]; 


        ///////// GET AVG ATTENDANCE PER EVENT /////////
        $query = $conn->prepare("SELECT COUNT(*) AS attendanceCount FROM attendance"); 
        
        // Run the query
        $query->execute();             

        // set the resulting array to associative
        $result = $query->setFetchMode(PDO::FETCH_ASSOC);

        // Get the result
        $iSemesterAttendance = $query->fetch();
        $key = 'attendanceCount';

        // Get the value from our query and add it to our stats object
        $jStats->avgEventAttendance = $iSemesterAttendance[$key] / $iEventCount; 



        $sjStats = json_encode($jStats);
        echo $sjStats;
    }

    catch(PDOException $e) {
        echo '{"status": "ERROR"}';
    }

?>