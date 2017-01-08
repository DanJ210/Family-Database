<?php 

require_once('SQLite3.class.php');

$FcDB = new SQLite3('focarino_member.sqlite3');
$db = new FocarinoDB;

?>
<!DOCTYPE html>
<html>

    <head>
        <title></title>
        <link rel="stylesheet" href="css/layout.css" media="screen"/>
        <style>
            #connsuccess {
                position: absolute;
                top: 100px;
                left: 50px;
            }
        </style>
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
        <!-- Remove this when done -->
        <div id="connsuccess">
            <p>This entire div was only something for me to test,
                it can be removed as soon as I'm done.'
            </p>
            <?php 
            if (!$db) {
                echo $db->lastErrorMsg();
                echo "Broke";
            } else {
                echo "Successfull";
            }
            ?>
        </div>
        <div class="form" id="inputrecord">
            <h3>Enter record ID number to update: </h3>
            <form action="update_record.php" method="post">
                <fieldset>
                    ID? <input type="text" name="inputid"/>
                    <input type="submit" value="Search"/>
                </fieldset>
            </form>
        </div>
    </body>
</html>

<?php

$sql =<<<EOF
    SELECT * FROM family_members;
EOF;
$result = $FcDB->query($sql);
$sql2 =<<<EOF
    SELECT * FROM family_members;
EOF;
$results = $FcDB->query($sql2);

while ($row1 = $results->fetchArray(SQLITE3_ASSOC) ) {
    echo $row1['id'];
}
//echo $result->fetchArray(SQLITE3_ASSOC);
//$id = $result->fetchArray(SQLITE3_ASSOC);
echo "Doesn't work";
while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
    echo "Works";
    echo $row['id'];
    echo $row['firstname'];
}
echo "no";
//echo $id['id'];
echo 'test';
/*
$statement = $FcDB->prepare($sql);
$statement->bindValue(':id', $_POST['inputid'], SQLITE3_INTEGER);
$result = $statement->exec();
echo $result;
*/
$db->close();
$FcDB->close();
?>