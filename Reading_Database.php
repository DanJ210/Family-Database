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
echo count($members);
foreach ($members as $member) {
    echo $members["id"]."<br/>";
    echo $members["firstName"]."<br/>";
    echo $members["lastName"]."<br/>";
    //echo $members["lastName"];
    
    //echo $conn->query("SELECT firstName from foc_member");
}
?>