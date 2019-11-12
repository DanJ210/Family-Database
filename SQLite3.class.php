<?php 
class FocarinoDB extends SQLite3 {
    function __construct($fileName) {
        $this->open($fileName);
    }
}
?>