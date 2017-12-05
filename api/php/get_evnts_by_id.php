<?php
    $sEvents = file_get_contents("http://localhost:3333/event/:id");
    echo $sEvents;
?>