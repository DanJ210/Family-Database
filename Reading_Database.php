<?php 
require_once(Register_Member.php);

$dsn = "sqlite:/Users/DanJ2/Documents/focarino.sqlite3";
try {
    $conn = new PDO($dsn);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failes:".$e->getMessage();
}
$sql = "SELECT * from members";
$st = $conn->query($sql);
$members = $st->fetch();
echo "ID: ".$members["id"]."<br/>";
echo "First Name:  ".$members["firstName"]."<br/>";
echo "Last Name:  ".$members["lastName"]."<br/>";
?>