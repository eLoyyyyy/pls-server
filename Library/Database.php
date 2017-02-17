<?php
/**
 * Database Singleton
 */
class Database extends PDO {
    
    protected static $instance;
    
    static function getInstance(){
        
        $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8';
        
        if(!self::$instance){
            self::$instance = new Database($dsn, DB_USER, DB_PASS);
        }
        return self::$instance;
    }
 
    function __construct($dsn,$dbname,$dbpass) {
            parent::__construct($dsn,$dbname,$dbpass);
            $this->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
            $this->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    }
    
}