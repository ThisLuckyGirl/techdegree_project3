<?php
//create PDO connection to SQLite database and included error handling

//try command including code to attempt
try {
    //create PDO connection
    $db  = new PDO("sqlite:".__DIR__."/journal.db");
    //catch errors w/ setAttribute
    $db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
//handle exceptions w/ catch statement
} catch (Exception $e) {
    echo "Unable to connect";
    //run getMessage method
    echo $e->getMessage();
    //stop additional code from executing
    exit;
}
