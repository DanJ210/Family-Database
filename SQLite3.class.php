<?php 

class FocarinoDB extends SQLite3 {
    function __construct() {
        $this->open('focarino_member.sqlite3');
    }

    
}



?>