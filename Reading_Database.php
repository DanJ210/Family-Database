<!DOCTYPE html>
<html>
    <style>
    dl {
        display: inline;
    }
    dt {
        background-color: cornflowerblue;
        color: white;
        text-align: center;
    }
    dd {
        float: left;
    }
    </style>
<?php 

//require_once('C:/Wamp_64/www/Focarino_Database/Register_Member.php');
//require_once('C:/Wamp_64/www/Focarino_Database/Register_Form.php');
require_once('SQLite3.class.php');

$FcDB = new FocarinoDB('focarino_member.sqlite3');

if (!$FcDB) {
    echo $FcDB->lastErrorMsg();
}

$sqlDisplay =<<<EOF
    SELECT * FROM family_members;
EOF;
?>
    <dl>
        <dt> First Name</dt>
        
<?php
$results = $FcDB->query($sqlDisplay);
while ($row = $results->fetchArray(SQLITE3_ASSOC) ) {
    ?>
        <dd><?php echo $row['firstname'] ?></dd>    
    
    <?php 
}


?>
    </dl>
    </br>
    </br>
    </br>
    <dt> Last Name</dt>
    <?php 
    while ($row = $results->fetchArray(SQLITE3_ASSOC) ) {
    ?>
        <dd><?php echo $row['lastname'] ?></dd>    
    <?php 
    }
    while ($row = $results->fetchArray(SQLITE3_ASSOC) ) {
        echo "ID = " . $row['id'] . "</br>";
        echo "First Name = " . $row['firstname'] . "</br>";
        echo "Last Name = " . $row['lastname'] . "</br>";
        echo "Bday = " . $row['birthdate'] . "</br>";
        echo "City = " . $row['city'] . "</br>";
        echo "State = " . $row['state'] . "</br>";
        echo "Join Date = " . $row['joindate'] . "</br>";
        echo "</br>";
        echo "</br>";
    }
    $FcDB->close();
    ?>
</html>