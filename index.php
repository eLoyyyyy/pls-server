<?php

    define('ROOT' , dirname(realpath(__FILE__)) . DIRECTORY_SEPARATOR);
    
    require ROOT . 'Library\Init.php';

    define('ROOT_URL', HostUrl());

    $application = new Application();
    $application->load();
