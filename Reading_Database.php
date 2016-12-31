<?php 

//require_once('C:/Wamp_64/www/Focarino_Database/Register_Member.php');
//require_once('C:/Wamp_64/www/Focarino_Database/Register_Form.php');
require_once('SQLite3.class.php');

$FcDB = new FocarinoDB('focarino_database.sqlite3');

if (!$FcDB) {
    echo $FcDB->lastErrorMsg();
}

$sqlDisplay =<<<EOF
    SELECT * FROM family_members;
EOF;

$results = $FcDB->query($sqlDisplay);
while ($row = $results->fetchArray(SQLITE3_ASSOC) ) {
    echo "ID = " . $row['firstname'] . "</br>";
    echo "ID = " . $row['lastname'] . "</br>";
    echo "ID = " . $row['birthdate'] . "</br>";
    echo "ID = " . $row['city'] . "</br>";
    echo "ID = " . $row['state'] . "</br>";
    echo "ID = " . $row['joindate'] . "</br>";
}

$FcDB->close();
?>