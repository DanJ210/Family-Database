<?php 

require_once('SQLite3.class.php');

$FcDB = new SQLite3('focarino_member.sqlite3');

?>
<!DOCTYPE html>
<html>

    <head>
        <title></title>
        <link rel="stylesheet" href="css/layout.css" media="screen"/>
    </head>
    <body>
        <div class="header">
            The Focarino Family Database
        </div>
        <div class="horizontalnav">
            <ul>
                <li><a href="index.html">Home</a></li>
                <li><a href="update_record.php">Fix Record</a></li>
                <li><a href="Reading_Database.php">View Records</a></li>
            </ul>
        </div>
    </body>
</html>

<?php

?>