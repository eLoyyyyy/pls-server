<?php

require ROOT . 'Library\Config.php';
require ROOT . 'Library\Functions.php';

function __autoload($className){
    $paths = array(
        ROOT."/Library/",
        ROOT."/Application/Controller/",
        ROOT."/Application/Model/"
    );
    foreach($paths as $path){
        if(file_exists($path.$className.".php")){
            require_once($path.$className.".php");
            break;
        }
    }
}

unregisterGlobals();
removeMagicQuotes();
$registry = new Registry;
$registry->db = Database::getInstance();

