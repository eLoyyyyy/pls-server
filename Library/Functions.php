<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
    
    
    
    /**
     * Set error reporting
     */
    function setErrorLogging(){
        if(DEVELOPMENT_ENVIRONMENT == true){
            error_reporting(E_ALL);
            ini_set('display_errors', "1");
        }else{
            error_reporting(E_ALL);
            ini_set('display_errors', "0");
        }
        ini_set('log_errors', "1");
        ini_set('error_log', ROOT . 'Library/Error_Log.php');
    }
    
    /**
     * Trace function which outputs variables to system/log/output.php file
     */
    function trace($var,$append=false){
        $oldString="<?php\ndie();/*";
        if($append){
            $oldString=file_get_contents(ROOT . 'system/log/output.php') . "/*";
        }
        file_put_contents(ROOT . 'system/log/output.php', $oldString . "\n---\n" . print_r($var, true) . "\n*/");
    }
    
    /** Check for Magic Quotes and remove them **/
    function stripSlashesDeep($value) {
        $value = is_array($value) ? array_map('stripSlashesDeep', $value) : sanitize(stripslashes($value));
        return $value;
    }

    function sanitize($str)
    {
        $str = htmlentities($str);
        $str = htmlspecialchars($str);
        $str = strip_tags($str);
    }

    function removeMagicQuotes() {
        if ( get_magic_quotes_gpc() ) {
            $_GET    = stripSlashesDeep($_GET   );
            $_POST   = stripSlashesDeep($_POST  );
            $_COOKIE = stripSlashesDeep($_COOKIE);
        }
    }

    /** Check register globals and remove them **/
    function unregisterGlobals() {
        if (ini_get('register_globals')) {
            $array = array('_SESSION', '_POST', '_GET', '_COOKIE', '_REQUEST', '_SERVER', '_ENV', '_FILES');
            foreach ($array as $value) {
                foreach ($GLOBALS[$value] as $key => $var) {
                    if ($var === $GLOBALS[$key]) {
                        unset($GLOBALS[$key]);
                    }
                }
            }
        }
    }
    
    function HostUrl() 
    {
        $host = '';
        $thisDir = explode("/", ROOT);
        $conflen = strlen(array_pop($thisDir));
        $B = substr(__FILE__, 0, strpos(__FILE__, '/'));
        $A = substr($_SERVER['DOCUMENT_ROOT'], strpos($_SERVER['DOCUMENT_ROOT'], $_SERVER['PHP_SELF']));
        $C = substr($B, strlen($A));
        $posconf = strlen($C) - $conflen;
        $D = substr($C, 0, $posconf);
        $host = 'http://' . $_SERVER['SERVER_NAME'] . '/' . $D;
        return $host;
    }
