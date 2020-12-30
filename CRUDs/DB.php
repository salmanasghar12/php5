<?php
  define("DB_SERVER","localhost");
  define("DB_Name","noteTakingWeb");
  define("DB_USER","root");
  define("DB_PASS","");


  function dbConnect(){
    $db = new mysqli(DB_SERVER,DB_USER,DB_PASS,DB_Name);
    if($db->connect_errno)
    {
      $errorMessage = "Database Connection Failed: ".$db->connect_error .", Error no: ".$db->connect_errno;
      exit($errorMessage);
    }
    return $db;
  }

  function dbDisconnect($db)
  {
    isset($db)  ? $db->close(): exit("Connection Not opened");
  }

?>
