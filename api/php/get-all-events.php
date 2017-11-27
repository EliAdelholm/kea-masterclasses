<?php

    $sEvents = file_get_contents("http://localhost:3333/display-all-events");
    
    echo $sEvents;

?>