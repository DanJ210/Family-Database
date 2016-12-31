<?php 

class FocarinoDB extends SQLite3 {
    function __construc() {
        $this->open('focarino_member.sqlite3');
    }

    
}



?>