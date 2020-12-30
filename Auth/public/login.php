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
        <caption><h1>Login</h1> </caption>
        <tr>
          <td><label>Email: </label></td>
          <td> <input type="email" name="" value=""> </td>
          <!-- <td > <input class="error"  type="email" name="" value=""> </td> -->
          <!-- <td class="errorText">*Please enter correct Email</td> -->
        </tr>
        <tr>
          <td> <label>Password: </label> </td>
          <td> <input type="password" name="" value=""> </td>
        </tr>
        <tfoot>
          <tr>
            <td  colspan="2"><input type="submit" name="" value="Login"></td>
          </tr>
        </tfoot>
      </table>
      <table>
        <tr>
            <td class="link"><a href="#">Forget Your Password ? </td>
            <td class="link"> New Member ? <a href="<?php echo urlFor('registration.php'); ?>">Create New Accout</a> </td>
        </tr>
      </table>

    </form>

  </body>
</html>
