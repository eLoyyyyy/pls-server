<?php


abstract class Controller {
    
    private $params;
    
    protected $registry;
    
    public function __construct()
    {
    }
    
    function setParams($params = null)
    {
        $this->params = $params;
    }
    
    protected function getParams($key)
    {
        return $this->params[$key];
    }
}

