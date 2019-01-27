<?php
//try command to handle exceptions
try {
    //create PDO connection
    $db  = new PDO("sqlite:".__DIR__."/journal.db");
    $db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
//handle
} catch (Exception $e) {
    echo "Unable to connect";
    //run getMessage method
    echo $e->getMessage();
    exit;
}

try {
    $db->query("SELECT ,  FROM ");
}
