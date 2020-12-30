<?php require_once("initialize.php"); ?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Note Taking Web</title>
    <link rel="stylesheet" href="styles/main.css">
  </head>
  <body>

    <div class="content">
        <a href="create_edit_note.php">Create New Note</a>
        <table>
          <thead>
            <tr>
              <th>Note Title</th>
              <th>View</th>
              <th>Edit</th>
              <th>Delete</th>
            </tr>
          </thead>
          <tbody>
            <?php $notes = Note::find_all(); ?>
            <?php foreach ($notes as $note) {  ?>
                <tr>
                  <td><?php echo $note->getNoteTitle(); ?></td>
                  <td><a href=<?php echo "view_note.php?id=".$note->getId(); ?>>View</a></td>
                  <td><a href=<?php echo "create_edit_note.php?id=".$note->getId();?>>Edit</a></td>
                  <td><a href=<?php echo "delete_note.php?id=".$note->getId();?>>Delete</a></td>
                </tr>
          <?php } ?>
          </tbody>
        </table>
  </div>
  </body>

<?php dbDisconnect($database); ?>
</html>
