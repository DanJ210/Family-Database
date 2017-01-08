<!DOCTYPE html>
<html>
    <style>
    dl {
        display: block;
        float: left;
    }
    dt {
        background-color: cornflowerblue;
        /*border: 1px solid black;*/
        color: white;
        text-align: center;
        width: 300px;
    }
    dd {
        border: 1px solid black;
        width: 200px;
    }
    </style>
<?php 
require_once('SQLite3.class.php');

$FcDB = new FocarinoDB('focarino_member.sqlite3');
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
if (!$FcDB) {
    echo $FcDB->lastErrorMsg();
}
$sqlDisplay =<<<EOF
    SELECT * FROM family_members;
EOF;
?>
<!-- These break tags here are only to put some space between. Cheap way of doing it. -->
    </br>
    </br>  
<?php
$results = $FcDB->query($sqlDisplay);

    $count = 1;
    while ($row = $results->fetchArray(SQLITE3_ASSOC) ) {
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