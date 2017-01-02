<!DOCTYPE html>
<html>
    <style>
    dl {
        display: block;
    }
    dt {
        background-color: cornflowerblue;
        color: white;
        text-align: center;
    }
    dd {
        /*float: left;*/
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
        
<?php
$results = $FcDB->query($sqlDisplay);
?>
    <?php 
    $count = 1;
    while ($row = $results->fetchArray(SQLITE3_ASSOC) ) {
        echo $row['id'];
        ?>
        
        <dl>
            <dt>Record <?php echo $count;?></dt>
                <dd>
                <?php 
                // Counts 7 for each array associate key stored stored
                //echo count($row);
                echo "</br>";
                echo "ID = " . $row['id'] . "</br>";
                echo "First Name = " . $row['firstname'] . "</br>";
                echo "Last Name = " . $row['lastname'] . "</br>";
                echo "Bday = " . $row['birthdate'] . "</br>";
                echo "City = " . $row['city'] . "</br>";
                echo "State = " . $row['state'] . "</br>";
                echo "Join Date = " . $row['joindate'] . "</br>";
                echo "</br>";
                echo "</br>";
                ?>
                </dd>
        </dl>
        <?php
        // The count is for giving the record displayed a number
        $count++;
    }
    $FcDB->close();
    ?>
</html>