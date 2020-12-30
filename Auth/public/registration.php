<?php
  require_once('../private/initialize.php') ;

  $thisPageURL =  $_SERVER['SCRIPT_NAME'];
  $user = new User(array(''));
  $errors = [];

  if(isPostRequest())
  {
        // exit("Process form");
        $user = new User($_POST);
        $result = $user->save();
        if($result === true)
        {
          exit("User successfully created, its time to verify the user");
        }
        else {
          $errors = $result;
          // print_r($errors);
          // exit;
          // exit("display error");
        }
    }

?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Registration</title>
    <link rel="stylesheet" href="<?php echo urlFor('stylesheets/registration.css'); ?>">
  </head>
  <body>


    <form action="<?php echo $thisPageURL; ?>" method="post">
      <table>
        <caption><h1>Create New Account</h1> </caption>
        <tr>
          <td><label>First Name: </label></td>
          <?php
            if(isset($errors['firstName'])){
              echo "<td> <input class='error' type='text' name='firstName' value=".$user->getFirstName()."> </td>";
              echo "<td class='errorText'>".$errors['firstName']."</td>";
            }else {
              echo "<td> <input class='' type='text' name='firstName' value=".$user->getFirstName()."> </td>";
            }
          ?>
        </tr>
        <tr>
          <td> <label>Last Name: </label> </td>
          <?php
              if(isset($errors['lastName'])){
                echo "<td> <input class='error' type='text' name='lastName' value=".$user->getLastName()."> </td>";
                echo "<td class='errorText'>".$errors['lastName']."</td>";
              }else {
                echo "<td> <input class='' type='text' name='lastName' value=".$user->getLastName()."> </td>";
              }
           ?>
        </tr>
        <tr>
          <td> <label>Username:</label> </td>
          <?php
              if(isset($errors['userName'])){
                echo "<td> <input class='error' type='text' name='userName' value=".$user->getUserName()."> </td>";
                echo "<td class='errorText'>".$errors['userName']."</td>";
              }else {
                echo "<td> <input class='' type='text' name='userName' value=".$user->getUserName()."> </td>";
              }
           ?>
        </tr>
        <tr>
          <td> <label>Email:</label> </td>
          <?php
              if(isset($errors['email'])){
                echo "<td> <input class='error' type='text' name='email' value=".$user->getEmail()."> </td>";
                echo "<td class='errorText'>".$errors['email']."</td>";
              }else {
                echo "<td> <input class='' type='text' name='email' value=".$user->getEmail()."></td>";
              }
           ?>
        </tr>
        <tr>
          <td> <label>Password:</label> </td>
          <?php
              if(isset($errors['password'])){
                echo "<td> <input class='error' type='password' name='password' value=".$user->getPassword()."> </td>";
                echo "<td class='errorText'>".$errors['password']."</td>";
              }else {
                echo "<td> <input class='' type='password' name='password' value=".$user->getPassword()."></td>";
              }
           ?>
        </tr>
        <tr>
          <td> <label>Confirm Password:</label> </td>
          <?php
              if(isset($errors['confirmPassword'])){
                echo "<td> <input class='error' type='password' name='confirmPassword' value=".$user->getConfirmedPassword()."> </td>";
                echo "<td class='errorText'>".$errors['confirmPassword']."</td>";
              }else {
                echo "<td> <input class='' type='password' name='confirmPassword' value=".$user->getConfirmedPassword()."></td>";
              }
           ?>
        </tr>
        <tr>
          <td> <label>Phone Number:</label> </td>
          <?php
              if(isset($errors['phoneNumber'])){
                echo "<td> <input class='error' type='text' name='phoneNumber' value=".$user->getPhoneNumber()."> </td>";
                echo "<td class='errorText'>".$errors['phoneNumber']."</td>";
              }else {
                echo "<td> <input class='' type='text' name='phoneNumber' value=".$user->getPhoneNumber()."></td>";
              }
           ?>
        </tr>
        <tr>
          <td><label>Address:</label> </td>
          <?php
              if(isset($errors['address'])){
                echo "<td> <textarea class='error' name='address'   rows='8' cols='80' >".$user->getAddress()."</textarea></td>";
                echo "<td class='errorText'>".$errors['address']."</td>";
              }else {
                echo "<td> <textarea class='' name='address'   rows='8' cols='80' >".$user->getAddress()."</textarea></td>";
              }
           ?>
        </tr>

        <tfoot>
          <tr>
            <td  colspan="2"><input type="submit" name="create accout" value="Create Account"></td>
          </tr>
        </tfoot>
      </table>
      <table>
        <tr>
            <td class="link"><a href="#">Forget Your Password? </td>
            <td class="link" >Already Registered? <a href="<?php echo urlFor('login.php'); ?>"> Login</a></td>
        </tr>
      </table>
    </form>

  </body>
</html>
