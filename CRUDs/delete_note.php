<?php require_once("initialize.php"); ?>
<?php
  $id = $_GET['id'] ?? NULL;

  if(!isset($id)){
    redirectTo('index.php');
    exit;
  }

  if(isPostRequest()){
    if(isset($_POST['delete']))
    {
      // exit("Delete Button Pressed");
      $note = Note::find_by_id($id);
      if(isset($note)){
        $note->delete();
        redirectTo('index.php');
      }
      else {
        // exit("Note is NULLLL");
        exit("Item you are trying to delete, not exist");
      }

    }else {
      // exit("Cancel Button Pressed");
      redirectTo('index.php');
    }
  }

?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Delete Note</title>
    <link rel="stylesheet" href="styles/delete_note.css">
  </head>
  <body>
    <div class="content">
      <form action="" method="post">
        <h1>Are You Sure?</h1>
        <input type="submit" name="cancel" value="Cancel">
        <input type="submit" name="delete" value="Delete">
      </form>
    </div>

  </body>
</html>
