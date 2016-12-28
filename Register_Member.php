<!DOCTYPE html>
<html>
    <?php
    // Creating PDO connection
    $dsn = "sqlite:/Users/DanJ2/Documents/focarino.sqlite3";
    try {
    $conn = new PDO($dsn);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    } catch (PDOException $e) {
        echo "Connection failes:".$e->getMessage();
    }
    // Creating table but only needed once. 
    /*
    $sql = "DROP TABLE IF EXISTS foc_member";
    $conn->exec($sql);
    $sql = "CREATE TABLE foc_member (id INTEGER PRIMARY KEY, firstName, lastName)";
    $conn->exec($sql);
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