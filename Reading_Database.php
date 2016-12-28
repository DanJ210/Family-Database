<?php 

//require_once('C:/Wamp_64/www/Focarino_Database/Register_Member.php');
//require_once('C;/Wamp_64/www/Focarino_Database/Register_Form.php');

$dsn = "sqlite:/Users/DanJ2/Documents/focarino.sqlite3";
try {
    $conn = new PDO($dsn);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failes:".$e->getMessage();
}
$sql = "SELECT * from foc_member";
$st = $conn->query($sql);
$members = $st->fetch();
echo "ID: ".$members["id"]."<br/>";
echo "First Name:  ".$members["firstName"]."<br/>";
echo "Last Name:  ".$members["lastName"]."<br/>";

foreach ($members as $member) {
    echo $members["firstName"];
    //echo $conn->query("SELECT firstName from foc_member");
}
?>