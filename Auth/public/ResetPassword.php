<?php
  require_once('../private/initialize.php') ;
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Registration</title>
    <link rel="stylesheet" href="<?php echo urlFor('stylesheets/login.css'); ?>" type="text/css">
  </head>
  <body>
    <form action="#" method="post">
      <table>
        <caption><h1>Find Your Account</h1> </caption>
        <tr>
          <td> <input type="email" name="" value="" placeholder="Enter you email address"> </td>
          <!-- <td > <input class="error"  type="email" name="" value=""> </td> -->
          <!-- <td class="errorText">*Please enter correct Email</td> -->
        </tr>
        <tfoot>
          <tr>
            <td  colspan="2"><input type="submit" name="" value="Search"></td>
          </tr>
        </tfoot>
      </table>
    </form>

  </body>
</html>
