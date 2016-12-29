<!DOCTYPE html>
<html>
    <?php
    // Page holding database connection configurations 
    require_once('C:/Wamp_64/www/Focarino_Database/config.php');
    
    // Creating PDO connection
    $dsn = "sqlite:/Users/DanJ2/Documents/focarino.sqlite3";
    try {
        $conn = new PDO($dsn);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        echo "Connection failed:".$e->getMessage();
    }

    // Checking if database file exists and if it doesn't then
    // it creates the database, useful for when I delete.
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
    //$sql = "select * FROM Foc_member";
    // Creating table but only needed once. 
    /*
    
    */
    
    // Adding a member
    $sqladd = "INSERT INTO foc_member (firstName, lastName) VALUES (:firstNameText,:lastNameText)";
    $st = $conn->prepare($sqladd);
    $st->bindValue(":firstNameText", $_POST['firstName']);
    $st->bindValue(":lastNameText", $_POST['lastName']);
    //$st->execute();
    if ($st->execute()) {
        echo "Registration Successful";
        
    }
    else {
        echo "Please enter information again";
    }
    ?>
    <body>
        </br>
        <h3><a href="members_area.html">Click link to go to members area</a></h3>
    </body>
</html>