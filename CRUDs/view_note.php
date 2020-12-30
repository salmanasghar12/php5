<?php require_once("initialize.php"); ?>
<?php
  $id = $_GET['id'] ?? exit("id is null");
 ?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>View Note</title>
    <link rel="stylesheet" href="styles/view_note.css">
  </head>
  <body>
    <div class="content">
      <?php $note =  Note::find_by_id($id);?>
      <h1><?php echo $note->getNoteTitle(); ?></h1>
      <p><?php echo $note->getNoteBody(); ?></p>
    </body>
    </div>
</html>
