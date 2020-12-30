<?php
  require_once("DB.php");
  require_once("model/note.php");
  require_once("functions.php");

  $database = dbConnect();
  Note::setDatabase($database);





 ?>
