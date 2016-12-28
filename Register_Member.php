<!DOCTYPE html>
<html>
    <?php 
    /*
    $firstName = $_POST["firstName"];
    echo $firstName;
    echo $_POST['lastName'];
*/
    $dsn = "sqlite:/Users/DanJ2/Documents/focarino.sqlite3";
    try {
    $conn = new PDO($dsn);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    } catch (PDOException $e) {
        echo "Connection failes:".$e->getMessage();
    }
    $sql = "DROP TABLE IF EXISTS foc_member";
    $conn->exec($sql);
    $sql = "CREATE TABLE members (id INTEGER PRIMARY KEY, firstName, lastName)";
    $conn->exec($sql);

    // Adding a member
    $sqladd = "INSERT INTO members"
    ?>
</html>