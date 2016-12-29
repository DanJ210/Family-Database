<?php 

//require_once('C:/Wamp_64/www/Focarino_Database/Register_Member.php');
//require_once('C:/Wamp_64/www/Focarino_Database/Register_Form.php');
require_once('C:/Wamp_64/www/Focarino_Database/config.php');

$sql = "SELECT * from foc_member";
$st = $conn->query($sql);
$members = $st->fetch();
echo "ID: ".$members["id"]."<br/>";
echo "First Name:  ".$members["firstName"]."<br/>";
echo "Last Name:  ".$members["lastName"]."<br/>";

foreach ($members as $member) {
    echo $members["id"];
    echo $members["firstName"];
    echo $members["lastName"];
    //echo $members["lastName"];
    
    //echo $conn->query("SELECT firstName from foc_member");
}
?>