<!DOCTYPE html>
<html>
    
    <?php
    


    require_once('SQLite3.class.php');

    $FcDB = new FocarinoDB('focarino_database.sqlite3');

    if (!$FcDB) {
        echo $FcDB->lastErrorMsg();
    }
    /*
    else {
        echo "Opened Successfully";
    }
    */

    // Capturing info from submitted form
    $fName = $_POST['firstName'];
    $lName = $_POST['lastName'];
    $bday = $_POST['birthDate'];

    $sqlInsertMember =<<<EOF
        INSERT INTO family_members
        (firstname, lastname, birthdate, city, state, joindate)
        VALUES
        ("$fName", '$lName', $bday, "Hendersonville", "FL", 2016/12/31);

EOF;

$results = $FcDB->exec($sqlInsertMember);

if (!$results) {
    echo $FcDB->lastErrorMsg();
}
else {
    echo "Added successfully";
}
$FcDB->close();

    // Page holding database connection configurations 
    // All old code below here which is mainly for more intense SQL 
    // connections, not SQLite3. Saving it for future reference.
    /*
    require_once('C:/Wamp_64/www/Focarino_Database/config.php');
    require_once('DataObject.class.php');

    try {
        $conn = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
        $conn->setAttribute( PDO::ATTR_PERSISTENT, true );
        $conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
    } catch ( PDOException $e ) {
        die( "Connection Failed: ". $e->getMessage() );
    }
    // Getting data from register page
    $fName = $_POST['firstName'];
    $lName = $_POST['lastName'];
    $bday = $_POST['birthDate'];

    $sql = 'INSERT INTO (firstName, lastName, birthDate) VALUES (:fname, :lname, :bday)';
    $st = $conn->prepare( $sql );
    $st->bindValue( ":fname", $fName );
    $st->bindValue( ":lname", $lName );
    $st->bindValue( ":bday", $bday );
    $st->execute();
    */
    // Creating PDO connection
    /*
    $dsn = "sqlite:/Users/DanJ2/Documents/focarino.sqlite3";
    try {
        $conn = new PDO($dsn);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        echo "Connection failed:".$e->getMessage();
    }
    */
    // Checking if database file exists and if it doesn't then
    // it creates the database, useful for when I delete.
    
    //$sql = "select * FROM Foc_member";
    // Creating table but only needed once. 
    /*
    
    */
    
    // Adding a member
    /*
    $sqladd = "INSERT INTO foc_member (firstName, lastName) VALUES (:firstNameText,:lastNameText)";
    $st = $conn->prepare($sqladd);
    $st->bindValue(":firstNameText", $_POST['firstName']);
    $st->bindValue(":lastNameText", $_POST['lastName']);
    $st->execute();

    $sqladd = "INSERT INTO foc_member (firstName, lastName) VALUES (:firstNameText,:lastNameText)";
    $st = $conn->prepare($sqladd);
    $st->bindValue(":firstNameText", $_POST['firstName']);
    $st->bindValue(":lastNameText", $_POST['lastName']);
    $st->execute();
    
    $sqladd = "INSERT INTO foc_member (firstName, lastName) VALUES (:firstNameText,:lastNameText)";
    $st = $conn->prepare($sqladd);
    $st->bindValue(":firstNameText", $_POST['firstName']);
    $st->bindValue(":lastNameText", $_POST['lastName']);
    $st->execute();
    
    
    $sqladd = ("INSERT INTO foc_member (firstName, lastName) VALUES (:nextNameText,:nextLastNameText)");
    $st = $conn->prepare($sqladd);
    $st->bindValue("nextNameText", "Test");
    $st->bindValue("nextLastNameText", "Last Name");
    
    if ($st->execute()) {
        echo "Registration Successful";
        
    }
    else {
        echo "Please enter information again";
    }
    */
    ?>
    <body>
        </br>
        <h3><a href="members_area.html">Click link to go to members area</a></h3>
    </body>
</html>