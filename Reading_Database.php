<?php 

//require_once('C:/Wamp_64/www/Focarino_Database/Register_Member.php');
//require_once('C:/Wamp_64/www/Focarino_Database/Register_Form.php');
require_once('C:/Wamp_64/www/Focarino_Database/config.php');

$sql = "SELECT id from foc_member";
$st = $conn->query($sql);
$members = $st->fetch();
/*
echo "ID: ".$members["id"]."<br/>";
echo "First Name:  ".$members["firstName"]."<br/>";
echo "Last Name:  ".$members["lastName"]."<br/>";
echo count($members);
*/
for ($x = 0; $x < 5; $x++) {
    echo $x;
    $sql = "SELECT * FROM foc_member WHERE id=$x";
    echo $members["id"]."</br>";
    echo $members["firstName"];
}
$count = 0;
echo count($members);
for ($index=0; $index<=count($members); $index++) {
    $sql = "SELECT * FROM foc_member WHERE id=$index";
    echo $members["id"]."</br>";
    echo "This is the index: " . $index;
    echo $count++;
    //echo $members["firstName"]."</br>";
    //echo $members["lastName"]."</br>";
}
//$sql = "SELECT * FROM foc_member WHERE id=10";
//st = $conn->query($sql);
//$testingID = $st->fetch();
//echo $testingID["firstName"];
//echo $testingID["lastName"];

echo "</br>";

for ($i=0; $i<12; $i++) {
    $count++;
    echo $members["id"];

}
foreach ($members as $member) {
    /*
    echo $members["id"]."<br/>";
    echo $members["firstName"]."<br/>";
    echo $members["lastName"]."<br/>";
    //echo $members["lastName"];
    */
    //echo $conn->query("SELECT firstName from foc_member");
}
?>