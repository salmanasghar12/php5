<?php
    require_once("initialize.php");

    if(isPostRequest()){
      $noteTitle = $_POST['noteTitle'] ?? null;
      $noteBody = $_POST['noteBody'] ?? null;
      $id = $_GET['id'] ?? null;

      if($noteTitle != null && $noteBody != null)
      {
        $note = new Note();
        $note->setNoteTitle($noteTitle);
        $note->setNoteBody("$noteBody");

        if(isForEdit())
        {
          $note->setID($id);
          $isSuccessfull = $note->update();
          if($isSuccessfull)
          {
            redirectTo('index.php');
            exit;
          }
          exit("Update Failed");
        }
        else {
          $isSuccessfull = $note->create();
          if($isSuccessfull)
          {
            redirectTo('index.php');
            exit;
          }
          exit("Insertion Failed");

        }
      }
      else {
        exit("Data Can't be null");
      }


    }else {

        $id = $_GET['id'] ?? NULL;
        $note;
        $isForEdit = false;

        if(isset($id)){
          $note = NOTE::find_by_id($id);
          $isForEdit = true;
        }


    }
 ?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Create-Edit Note</title>
    <link rel="stylesheet" href="styles/create_note.css">
  </head>
  <body>
    <div class="content">
        <form action=<?php if($isForEdit){echo "\"create_edit_note.php?id=".$id."\"";}else{echo "create_edit_note.php";} ?> method="post">
          <input type="hidden" name="isForEdit" value=<?php echo $isForEdit; ?>>
          <input type="text" name="noteTitle" placeholder="Note Title" maxlength="30" value=<?php if($isForEdit){echo "\"".$note->getNoteTitle()."\"";}else{echo "";} ?>>
          <textarea name="noteBody" rows="8" cols="80" placeholder="Enter Note"><?php if($isForEdit){echo $note->getNoteBody();}else{echo "";} ?></textarea>
          <input type="submit" name="submit" value="Save">
        </form>
    </div>
  </body>
</html>
