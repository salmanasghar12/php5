<?php
  function isPostRequest()
  {
    if($_SERVER['REQUEST_METHOD'] == 'POST')
    {
      return true;
    }
    return false;
  }

  function isForEdit()
  {
    $isForEdit = isset($_POST['isForEdit']) ? $_POST['isForEdit'] : '';
    if($isForEdit == '1')
    {
      return true;
    }
    else {
      return false;
    }
  }

  function redirectTo($location)
  {
    header("Location: ".$location);
    exit;
  }

?>
