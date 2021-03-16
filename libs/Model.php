<?php

class Model {
    protected $database;

    public function __construct() {
        //TODO:do not connect before login        
        $db = new Database();
        $this->database = $db;
    }

    public function __destruct() {
        $this->database = null;
    }
}
?>
