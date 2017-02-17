<?php

abstract class Model {
    
    private $db = null;
    
    function __construct()
    {
        $this->db = Database::getInstance();
    }
    
    function getDb()
    {
        return Database::getInstance();
    }
}
