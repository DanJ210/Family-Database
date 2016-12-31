<?php 

require_once('SQLite3.class.php');

$db = new FocarinoDB('focarino_database.sqlite3');

$sql = <<<EOF
    CREATE TABLE family_members
    (id int primary key,
    firstname varchar(25),
    lastname varchar(25),
    birthdate date,
    city varchar(25),
    state varchar(5),
    joindate datetime
    );

EOF;

$result = $db->exec($sql);

if (!$result) {
    echo $db->lastErrorMsg();
}
else {
    echo "Table created successfully";
}

?>