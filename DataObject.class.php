<?php 

require_once("config.php");

abstract class DataObject {
    protected $data = array();

    public function __construct( $data ) {
        foreach ( $data as $key => $value ) {
            if (array_key_exists( $key, $this->data )) $this->data[$key] = $value;
        }
    }

    public function connect() {
        try {
            $conn = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
            $conn->setAttribute( PDO::ATTR_PERSISTENT, true );
            $conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERMODE_EXCEPTION );
        } catch ( PDOException $e ) {
            die( "Connection Failed: ". $e->getMessage() );
        }
    }

    public function disconnect( $conn ) {
        $conn = "";
    }
}

?>