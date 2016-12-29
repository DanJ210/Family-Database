<?php 
require_once('C:/Wamp_64/www/Focarino_Database/config.php');
$databaseFile = 'C:/Wamp_64/www/Focarino_Database/focarino.sqlite3';
    if (file_exists($databaseFile) ) {
        echo "It exists";
    }
    else {
        echo "It doesn't exist";
        $sql = "DROP TABLE IF EXISTS foc_member";
        $conn->exec($sql);
        $sql = "CREATE TABLE foc_member (id INTEGER PRIMARY KEY, firstName, lastName)";
        $conn->exec($sql);
    }
?>