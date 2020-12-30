<?php

    define("PRIVATE_PATH", dirname(__FILE__));
    define("PROJECT_PATH", dirname(PRIVATE_PATH));
    define("PUBLIC_PATH", PROJECT_PATH . '/public');
    // define("SHARED_PATH", PRIVATE_PATH . '/shared');


    // $_SERVER['SCRIPT_NAME'] will return, /seoExchange/public/index.php , hum public k bad /index.php ko cut off kr rahy hain
    $public_end = strpos($_SERVER['SCRIPT_NAME'], '/public') + 7;
    $doc_root = substr($_SERVER['SCRIPT_NAME'], 0, $public_end);
    define("WWW_ROOT", $doc_root);



    require_once('functions.php');
    require_once('validation_functions.php');
    require_once('classes/user.class.php');

 ?>
