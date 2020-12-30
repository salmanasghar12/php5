<?php


  function urlFor($script_path) {
      // add the leading '/' if not present
      if($script_path[0] != '/') {
        $script_path = "/" . $script_path;
      }
      return WWW_ROOT . $script_path;
  }


  function redirectTo($url)
  {
    header("Location: ".$url);
    exit();
  }

  function isPostRequest()
  {
    return $_SERVER['REQUEST_METHOD'] == 'POST';
  }


 ?>
